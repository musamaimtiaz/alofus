<?php

namespace Modules\Upgrader\Entities;

use Modules\Upgrader\Entities\Handler\Contractor;
use Illuminate\Support\Facades\{
    Artisan, File, Log
};

class L10Handler extends Contractor
{
    /**
     * Run the upgrade process
     *
     * @return void
     */
    public function run()
    {
        $updaterJson = $this->updaterJson;

        try {

            $this->log(__('Enabling maintenance mode...'));
            Artisan::call('down');

            $this->install();

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
    private function install()
    {
        $this->deleteFilesAndDirectories();
        $this->migrations();
        $this->seeds(config('martvill.versions'));
        $this->cleanUp();

        Artisan::call('optimize:clear');
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
}
