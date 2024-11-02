<?php

/**
 * @author TechVillage <support@techvill.org>
 *
 * @contributor Md. Al Mamun <[almamun.techvill@gmail.com]>
 *
 * @created 05-09-2023
 */

namespace Modules\CMS\Service;

use App\Models\File;
use Illuminate\Support\Facades\File as FacadeFile;
use Modules\CMS\Entities\{
    Component,
    ComponentProperty,
    Page
};
use Modules\CMS\Http\Models\{
    Slide,
    Slider
};
use Modules\CMS\Http\Models\ThemeOption;
use Modules\MediaManager\Http\Models\ObjectFile;
use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use ZipArchive;

class HomepageExportService
{
    /**
     * Slug
     *
     * @var string
     */
    private $slug;

    /**
     * Success Message
     *
     * @var string
     */
    private $successMessage = '';

    /**
     * Error Message
     *
     * @var string
     */
    private $errorMessage = '';

    /**
     * Page
     *
     * @var object
     */
    private $page;

    /**
     * Themes
     *
     * @var object
     */
    private $themes;

    /**
     * Sliders
     *
     * @var object
     */
    private $sliders;

    /**
     * Home Resource
     *
     * @var array
     */
    private $homeResource;

    /**
     * JSON file
     *
     * @var string
     */
    private $json;

    /**
     * Export
     *
     * @param  string  $slug
     * @return $this
     */
    public function export($slug)
    {
        try {
            $this->slug = $slug;

            $this->getPage()
                ->getTheme()
                ->getSlider()
                ->mergeResource()
                ->replaceLinks()
                ->storeImages()
                ->makeJson()
                ->makeJsonFile()
                ->makeZip()
                ->download();

        } catch (\Exception $e) {
            $this->errorMessage = $e->getMessage();
            FacadeFile::deleteDirectory(storage_path('homepage/' . $this->slug));
        }

        return $this;
    }

    /**
     * Get page with relative child
     *
     * @return $this
     */
    private function getPage()
    {
        $page = Page::with(['components' => function ($q) {
            $q->orderBy('level')->with(['properties']);
        }])->slug($this->slug)->first();

        if (! $page) {
            $this->errorMessage = __('The :x does not exist.', ['x' => __('Page')]);

            return $this;
        }

        $this->page = $page->toArray();

        return $this;
    }

    /**
     * Get theme with related child
     *
     * @return $this;
     */
    private function getTheme()
    {
        if ($this->errorMessage) {
            return $this;
        }

        $themes = ThemeOption::where('name', 'like', $this->page['layout'] . '_template%')->get();

        if (! $themes) {
            $this->errorMessage = __('The appearance does not exist.');

            return $this;
        }

        foreach ($themes as $theme) {
            $objectFile = ObjectFile::where('object_type', 'theme_options')->where('object_id', $theme->id)->first();
            $file = File::where('id', $objectFile['file_id'] ?? '')->first();

            $theme->object_file = $objectFile?->toArray();
            $theme->file = $file?->toArray();
        }

        $this->themes = $themes?->toArray();

        return $this;
    }

    /**
     * Get theme with related child
     *
     * @return $this
     */
    private function getSlider()
    {
        if ($this->errorMessage) {
            return $this;
        }

        $sliderComponentIds = Component::where(['page_id' => $this->page['id'], 'layout_id' => 10])->pluck('id')->toArray();

        $sliderSlugs = ComponentProperty::where('name', 'slider')->whereIn('component_id', $sliderComponentIds)->get()->pluck('value')->toArray();

        $sliders = Slider::whereIn('slug', $sliderSlugs)->get();

        foreach ($sliders as $slider) {
            $slides = Slide::where('slider_id', $slider->id)->get();

            foreach ($slides as $slide) {
                $objectFile = ObjectFile::where('object_type', 'slides')->where('object_id', $slide->id)->first();
                $file = File::where('id', $objectFile['file_id'] ?? '')->first();

                $slide->object_file = $objectFile?->toArray();
                $slide->file = $file?->toArray();
            }
            $slider->slides = $slides?->toArray();
        }

        $this->sliders = $sliders?->toArray();

        return $this;
    }

    /**
     * Merge Resource
     *
     * @return array
     */
    private function mergeResource()
    {
        $this->homeResource = ['page' => $this->page, 'themes' => $this->themes, 'sliders' => $this->sliders, 'base_url' => url('/')];

        return $this;
    }

    /**
     * Replace Link
     *
     * @return $this
     */
    private function replaceLinks()
    {
        if ($this->errorMessage) {
            return $this;
        }

        $replaceFrom = [
            'https:\\/\\/demo.martvill.techvill.net\\',
            'https://demo.martvill.techvill.net',
        ];

        $replaceTo = url('/');

        array_walk_recursive($this->homeResource, function (&$value) use ($replaceFrom, $replaceTo) {
            $value = str_replace($replaceFrom, $replaceTo, $value);
        });

        return $this;
    }

    /**
     * Get Image Names
     *
     * @return $this
     */
    private function getImageNames()
    {
        if ($this->errorMessage) {
            return $this;
        }

        $images = [];
        array_walk_recursive($this->homeResource, function ($value, $key) use (&$images) {
            if (in_array($key, ['image', 'file_name'])) {
                $images[] = $value;
            }
        });

        return $images;
    }

    /**
     * Store Images
     *
     * @return $this
     */
    private function storeImages()
    {
        if ($this->errorMessage) {
            return $this;
        }

        $images = $this->getImageNames();

        foreach ($images as $image) {
            $sourcePath = public_path('uploads/' . $image); // Replace with the source file path
            $destinationPath = storage_path('homepage/' . $this->slug . '/images//' . $image); // Replace with the destination directory

            // Copy the file to the destination directory with the original name
            if (FacadeFile::exists($destinationPath)) {
                // Delete the file or link or directory
                if (is_link($destinationPath) || is_file($destinationPath)) {
                    FacadeFile::delete($destinationPath);
                } else {
                    FacadeFile::deleteDirectory($destinationPath);
                }
            } else {
                // Make sure the PARENT directory exists
                $dirname = pathinfo($destinationPath)['dirname'];

                if (! FacadeFile::exists($dirname)) {
                    FacadeFile::makeDirectory($dirname, 0777, true, true);
                }
            }

            // if source is a file, just copy it
            if (FacadeFile::isFile($sourcePath)) {
                FacadeFile::copy($sourcePath, $destinationPath);
            } else {
                FacadeFile::copyDirectory($sourcePath, $destinationPath);
            }
        }

        return $this;
    }

    /**
     * Make Json
     *
     * @return $this
     */
    private function makeJson()
    {
        if ($this->errorMessage) {
            return $this;
        }

        $this->json = json_encode($this->homeResource);

        return $this;
    }

    /**
     * Make Json File
     *
     * @return $this
     */
    private function makeJsonFile()
    {
        if ($this->errorMessage) {
            return $this;
        }

        $jsonFilename = $this->slug . '.json'; // Name of the JSON file
        $jsonDataPath = storage_path('homepage/' . $this->slug . '/'); // Destination directory in the storage path

        // Use File::put() to store the JSON data in a file
        FacadeFile::put($jsonDataPath . $jsonFilename, $this->json);

        return $this;
    }

    /**
     * Make Zip
     *
     * @return $this
     */
    private function makeZip()
    {
        if (! class_exists('ZipArchive')) {
            $this->errorMessage = __('Please install ZipArchive.');
        }

        if ($this->errorMessage) {
            return $this;
        }

        $zip = new ZipArchive();

        // Specify the name and path of the zip file
        $zipFileName = $this->slug . '.zip';
        $zipFilePath = storage_path('homepage/');

        if (FacadeFile::exists($zipFilePath . $this->slug . '.zip')) {
            $this->errorMessage = __('The Homepage already exist.');
            FacadeFile::deleteDirectory($zipFilePath . $this->slug);

            return $this;
        }

        // Create the zip file
        if ($zip->open($zipFilePath . $zipFileName, ZipArchive::CREATE) === true) {
            // Add files or directories to the zip file
            $files = new RecursiveIteratorIterator(
                new RecursiveDirectoryIterator($zipFilePath),
                RecursiveIteratorIterator::LEAVES_ONLY
            );

            $resourcePath = storage_path('homepage/' . $this->slug . '/');

            foreach ($files as $file) {
                // Skip directories (they would be added automatically)
                if (! $file->isDir()) {
                    // Get real and relative path for current file
                    $filePath = $file->getRealPath();
                    $relativePath = substr($filePath, strlen($resourcePath));

                    // Add current file to archive
                    $zip->addFile($filePath, $relativePath);
                }
            }

            // Close the zip file
            $zip->close();

            if (FacadeFile::exists($resourcePath)) {
                FacadeFile::deleteDirectory($resourcePath);
            }

            $this->successMessage = __('The homepage successfully exported.');
        } else {
            $this->errorMessage =  __('Failed to create the zip file.');
        }

        return $this;
    }

    /**
     * Download Homepage
     *
     * @return $this
     */
    private function download()
    {
        // Specify the path to the file
        $filePath = storage_path('homepage/' . $this->slug . '.zip');
        $filename = $this->slug . '.zip';

        // Check if the file exists
        if (file_exists($filePath)) {
            $response = new BinaryFileResponse($filePath);

            // Set the file's mime type
            $response->headers->set('Content-Type', 'application/zip');

            // Set the Content-Disposition header to force download
            $response->headers->set('Content-Disposition', 'attachment; filename="' . $filename . '"');

            // Send the response to the browser
            $response->send();

            // Delete the file after download
            unlink($filePath);
        }

        return $this;
    }

    /**
     * Get Boolean Response
     *
     * @return bool
     */
    public function getBoolResponse()
    {
        return ! boolval($this->errorMessage);
    }

    /**
     * Get Array Response
     *
     * @return array
     */
    public function getArrayResponse()
    {
        if ($this->getBoolResponse()) {
            return [
                'status' => 'success',
                'message' => $this->successMessage,
            ];
        }

        return [
            'status' => 'fail',
            'message' => $this->errorMessage,
        ];
    }
}
