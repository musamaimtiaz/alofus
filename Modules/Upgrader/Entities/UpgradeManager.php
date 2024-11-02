<?php

namespace Modules\Upgrader\Entities;

use Modules\Upgrader\Entities\Handler\FilesystemWritable;
use Modules\Upgrader\Entities\Handler\{
    View, Contractor
};
use Illuminate\Support\Facades\{
    Artisan, File, Log
};
use ZipArchive;

class UpgradeManager extends Contractor
{
    /**
     * List of non-writable directories
     *
     * @var array
     */
    private $directoriesNeedPermission = [];

    /**
     * View the upgrade process
     *
     * @param  string  $redirectTo
     * @return void
     */
    public function view($redirectTo)
    {
        return (new View())->view($redirectTo);
    }

    /**
     * Run the upgrade process
     *
     * @return void
     */
    public function run()
    {
        $updaterJson = $this->updaterJson;

        if (function_exists('beforeUpgrade')) {
            beforeUpgrade();
        }

        $this->log(__('The system upgrading: ') . $this->getCurrentVersion() . ' to ' . $this->getLastVersion());

        try {

            $this->log(__('Enabling maintenance mode...'));
            Artisan::call('down');

            $this->install($updaterJson['archive']);

            $this->setCurrentVersion($updaterJson['version']); //update system version

            $this->log(__('Disabling maintenance mode...'));
            Artisan::call('up');

            if (function_exists('afterUpgrade')) {
                afterUpgrade();
            }

            $this->log('<b>' . __('The system successfully updated to ') . $this->getLastVersion() . '<b>');

        } catch (\Exception $e) {
            $this->log(__('An exception occurred: ') . '<small>' . $e->getMessage() . '</small>');
            Artisan::call('up');
        }
    }

    /**
     * Install the update
     *
     * @return void
     */
    private function install($filename)
    {
        $this->copyArchiveFilesAndDirectories($filename);
        $this->deleteFilesAndDirectories();
        $this->migrations();
        $this->seeds($this->getVersions());
        $this->cleanUp();

        Artisan::call('optimize:clear');
    }

    /**
     * Copy all the files and directories from the archive to the root directory
     *
     * @return void
     */
    private function copyArchiveFilesAndDirectories($filename)
    {
        $this->log('<p>' . __('Copying required files') . '</p>', false);

        try {
            $zip = new ZipArchive();
            $res = $zip->open($this->baseURL . '/' . $filename);

            $extractToPath = base_path();

            if ($res === true) {
                $res = $zip->extractTo($extractToPath);
                $zip->close();
            }

        } catch (\Exception $e) {

            $this->log(__('An exception occurred: ') . $e->getMessage());

            return false;
        }
    }

    /**
     * Delete all the files and directories which are listed in the delete array
     *
     * @return void
     */
    protected function deleteFilesAndDirectories()
    {
        if (! is_array($this->updaterJson['delete'])) {
            return;
        }

        $this->log('<p>' . __('Deleting required files...') . '</p>', false);

        foreach ($this->updaterJson['delete'] as $deletableItem) {
            if (File::isFile($deletableItem) && File::exists($deletableItem)) {
                File::delete($deletableItem);
            } elseif (File::isDirectory($deletableItem) && File::exists($deletableItem)) {
                File::deleteDirectory($deletableItem);
            }
        }

        $downloadDirectory = storage_path('app' . DIRECTORY_SEPARATOR . 'downloaded-files');

        if (File::isDirectory($downloadDirectory)) {
            File::deleteDirectory($downloadDirectory);
        }
    }

    /**
     * Migrate files if exist
     *
     * @return void
     */
    private function migrations()
    {
        $this->log('<p>' . __('Migrating files') . '...</p>', false);

        Artisan::call('migrate');
    }

    /**
     * Seed files if exist
     */
    private function seeds(string|array $versions): void
    {
        $this->log('<p>' . __('Seeding files') . '...</p>', false);

        if (is_string($versions)) {
            $versions = [$versions];
        }

        $seedDirectories = [];
        foreach ($versions as $version) {
            $version = 'v' . str_replace('.', '_', $version);
            array_push($seedDirectories, implode(DIRECTORY_SEPARATOR, ['Database', 'Seeders', 'versions', $version, 'DatabaseSeeder']));

            foreach (\Nwidart\Modules\Facades\Module::getOrdered() as $module) {
                array_push($seedDirectories, implode(DIRECTORY_SEPARATOR, ['Modules', $module->getName(), 'Database', 'Seeders', 'versions', $version, 'DatabaseSeeder']));
            }
        }

        $seedDirectories = str_replace('/', '\\', $seedDirectories);

        foreach ($seedDirectories as $class) {
            if (class_exists($class)) {
                Artisan::call('db:seed', ['--class' => $class]);
            }
        }
    }

    /**
     * Clean up the temporary, backup and update files
     *
     * @return void
     */
    private function cleanUp()
    {
        $this->log('<p>' . __('Deleting temporary directory...') . '</p>');
        File::deleteDirectory($this->tempPath());

        $this->log('<p>' . __('Deleting backup directory...') . '</p>');
        File::deleteDirectory($this->backupPath());

        $this->log('<p>' . __('Deleting update file...') . '</p>');
        File::deleteDirectory(storage_path('updates'));
    }

    /**
     * Check writable permission in directories
     *
     * @return bool
     */
    private function needPermission()
    {
        $filesystem = new FilesystemWritable(base_path(), [
            'exclude' => [
                'bootstrap/cache',
                'storage',
                'storage/app',
                'storage/app/public',
                'storage/framework',
                'storage/framework/cache',
                'storage/framework/sessions',
                'storage/framework/views',
                'storage/logs',
                'public/uploads',
            ],
        ]);

        if (! $filesystem->isWritable()) {
            $this->directoriesNeedPermission = $filesystem->getNotWritables();

            return true;
        }

        return false;
    }

    /**
     * Check if the update file is valid
     *
     * @return array
     */
    public function isValid()
    {
        // check if the update file is valid
        if (is_null($this->updaterJson['version']) || is_null($this->updaterJson['archive'])) {
            return [
                'status' => false,
                'message' => __('The update file is not valid.'),
            ];
        }

        // check if the update version is equal to current version
        if (version_compare($this->getLastVersion(), $this->getCurrentVersion(), '=')) {
            return [
                'status' => false,
                'message' => __('The version you uploaded is the same as the current one (:x)', ['x' => $this->getLastVersion()]),
            ];
        }

        // check if the update version is older than current version
        if (version_compare($this->getLastVersion(), $this->getCurrentVersion(), '<')) {
            return [
                'status' => false,
                'message' => __('The version you uploaded (:x) is older than the current one (:y)', ['x' => $this->getLastVersion(), 'y' => $this->getCurrentVersion()]),
            ];
        }

        // check if the update version is supported
        if (! in_array($this->getCurrentVersion(), $this->getSupportedVersions())) {
            return [
                'status' => false,
                'message' => __('You are on a version (:x) that is not supported by this update.', ['x' => $this->getCurrentVersion()]),
            ];
        }

        if ($this->needPermission()) {
            return [
                'status' => false,
                'needPermission' => true,
                'permissionRequire' => $this->directoriesNeedPermission,
                'message' => __('These directories need writable permission. you need re-change the permission after successfully system update.'),
            ];
        }

        // everything is ok
        return [
            'status' => true,
            'json' => $this->updaterJson,
            'message' => __('An update version (:x) of :y is available.', ['x' => $this->getLastVersion(), 'y' => env('APP_NAME', 'Martvill')]),
        ];
    }

    /**
     * Get Martvill versions
     */
    private function getVersions()
    {
        try {
            $configFilePath = config_path('martvill.php');
            $key = 'versions';

            return $this->readConfigValue($configFilePath, $key);
        } catch (\Exception $e) {
            return config('martvill.versions');
        }
    }

    /**
     * Read Config Value
     */
    private function readConfigValue(string $configFilePath, string $key): mixed
    {
        // Check if the configuration file exists
        if (! file_exists($configFilePath)) {
            throw new \Exception("Configuration file '{$configFilePath}' not found.");
        }

        // Read the configuration file
        $configContents = file_get_contents($configFilePath);

        $config = [];
        if ($configContents !== false) {
            $config = eval('?>' . $configContents);
        }

        // Check if the configuration is an array
        if (! is_array($config)) {
            throw new \Exception("Invalid configuration format in '{$configFilePath}'.");
        }

        // Check if the key exists in the configuration
        if (! array_key_exists($key, $config)) {
            throw new \Exception("Key '{$key}' not found in '{$configFilePath}'.");
        }

        // Return the value associated with the key
        return $config[$key];
    }
}
