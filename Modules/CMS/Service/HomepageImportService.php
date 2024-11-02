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
use ZipArchive;
use Illuminate\Support\Facades\{
    Artisan,
    DB,
    File as FacadeFile
};

class HomepageImportService
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
     * Import
     *
     * @return $this
     */
    public function import()
    {
        DB::beginTransaction();

        try {
            $this
                ->upload()
                ->setSlug()
                ->checkValidity()
                ->refactorResource()
                ->storePage()
                ->storeThemes()
                ->storeSliders()
                ->storeImages()
                ->finished();

            DB::commit();
        } catch (\Exception $e) {
            $this->errorMessage = $e->getMessage();
            FacadeFile::deleteDirectory(storage_path('homepage/unzipped'));
            DB::rollBack();
        }

        return $this;
    }

    /**
     * Upload in storage
     *
     * @return $this
     */
    private function upload()
    {
        if (! class_exists('ZipArchive')) {
            $this->errorMessage = __('Please install ZipArchive.');

            return $this;
        }

        $zip = new ZipArchive();
        $res = $zip->open(request()->attachment);

        $storagePath = storage_path('homepage/unzipped');

        if (is_dir($storagePath)) {
            FacadeFile::deleteDirectory($storagePath);
        }

        if ($res === true) {
            $res = $zip->extractTo($storagePath);
            $zip->close();
        }

        return $this;
    }

    /**
     * Set Slug
     *
     * @return $this;
     */
    private function setSlug()
    {
        if ($this->errorMessage) {
            return $this;
        }

        $files = FacadeFile::files(storage_path('homepage/unzipped'));

        $jsonFiles = array_filter($files, function ($file) {
            return pathinfo($file, PATHINFO_EXTENSION) === 'json';
        });

        if (! isset($jsonFiles[0])) {
            $this->errorMessage = __('Trying to import invalid homepage.');

            return $this;
        }

        $this->slug = pathinfo($jsonFiles[0], PATHINFO_FILENAME);

        return $this;
    }

    /**
     * Check homepage validity
     *
     * @return $this
     */
    private function checkValidity()
    {
        if ($this->errorMessage) {
            return $this;
        }

        $resourcePath = storage_path('homepage/unzipped/' . $this->slug . '.json');

        if (! FacadeFile::exists($resourcePath)) {
            $this->errorMessage = __('Trying to import invalid homepage.');
        }

        return $this;
    }

    /**
     * Merge Resource
     *
     * @return $this
     */
    private function refactorResource()
    {
        if ($this->errorMessage) {
            return $this;
        }

        $jsonFilePath = storage_path('homepage/unzipped/' . $this->slug . '.json');

        // Read the JSON file as a string
        $jsonString = FacadeFile::get($jsonFilePath);

        // Decode the JSON string into an array
        $this->homeResource = json_decode($jsonString, true);

        $this->replaceLinks();

        $this->page = $this->homeResource['page'];
        $this->themes = $this->homeResource['themes'];
        $this->sliders = $this->homeResource['sliders'];

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
            str_replace('"', '', json_encode($this->homeResource['base_url'])),
        ];

        $replaceTo = url('/');

        array_walk_recursive($this->homeResource, function (&$value) use ($replaceFrom, $replaceTo) {
            $value = str_replace($replaceFrom, $replaceTo, $value);
        });

        return $this;
    }

    /**
     * Store Page
     *
     * @return $this
     */
    private function storePage()
    {
        if ($this->errorMessage) {
            return $this;
        }

        $page = Page::where('slug', $this->slug)->first();

        if ($page) {
            $this->errorMessage = __('The :x already exists.', ['x' => __('Homepage')]);

            return $this;
        }

        $page = Page::create($this->page);

        $componentProperties = [];

        foreach ($this->page['components'] as $component) {
            $componentId = Component::insertGetId([
                'page_id' => $page->id,
                'layout_id' => $component['layout_id'],
                'level' => $component['level'],
            ]);

            foreach ($component['properties'] as $property) {
                $componentProperties[] = [
                    'component_id' => $componentId,
                    'name' => $property['name'],
                    'type' => $property['type'],
                    'value' => is_array($property['value']) ? json_encode($property['value']) : $property['value'],
                ];
            }
        }

        ComponentProperty::insert($componentProperties);

        return $this;
    }

    /**
     * Store Themes
     *
     * @return $this;
     */
    private function storeThemes()
    {
        if ($this->errorMessage) {
            return $this;
        }

        $themes = ThemeOption::where('name', 'like', $this->page['layout'] . '_template%')->get();

        if ($themes->count()) {
            return $this;
        }

        foreach ($this->themes as $theme) {
            $themeId = ThemeOption::insertGetId([
                'name' => $theme['name'],
                'value' => $theme['value'],
            ]);

            if ($theme['file']) {
                $fileId = File::insertGetId([
                    'params' => json_encode($theme['file']['params']),
                    'object_type' => $theme['file']['object_type'],
                    'object_id' => $theme['file']['object_id'],
                    'uploaded_by' => $theme['file']['uploaded_by'],
                    'file_name' => $theme['file']['file_name'],
                    'file_size' => $theme['file']['file_size'],
                    'original_file_name' => $theme['file']['original_file_name'],
                ]);

                ObjectFile::insert([
                    'object_type' => $theme['object_file']['object_type'],
                    'object_id' => $themeId,
                    'file_id' => $fileId,
                ]);
            }
        }

        return $this;
    }

    /**
     * Store Sliders
     *
     * @return $this
     */
    private function storeSliders()
    {
        if ($this->errorMessage) {
            return $this;
        }

        foreach ($this->sliders as $slider) {
            $sliderExist = Slider::where('slug', $slider['slug'])->first();

            if ($sliderExist) {
                continue;
            }

            $sliderId = Slider::insertGetId([
                'name' => $slider['name'],
                'slug' => $slider['slug'],
                'status' => $slider['status'],
            ]);

            foreach ($slider['slides'] as $slide) {
                $slideId = Slide::insertGetId([
                    'slider_id' => $sliderId,
                    'title_text' => $slide['title_text'],
                    'title_animation' => $slide['title_animation'],
                    'title_delay' => $slide['title_delay'],
                    'title_font_color' => $slide['title_font_color'],
                    'title_font_size' => $slide['title_font_size'],
                    'title_direction' => $slide['title_direction'],
                    'sub_title_text' => $slide['sub_title_text'],
                    'sub_title_animation' => $slide['sub_title_animation'],
                    'sub_title_delay' => $slide['sub_title_delay'],
                    'sub_title_font_color' => $slide['sub_title_font_color'],
                    'sub_title_font_size' => $slide['sub_title_font_size'],
                    'sub_title_direction' => $slide['sub_title_direction'],
                    'description_title_text' => $slide['description_title_text'],
                    'description_title_animation' => $slide['description_title_animation'],
                    'description_title_delay' => $slide['description_title_delay'],
                    'description_title_font_color' => $slide['description_title_font_color'],
                    'description_title_font_size' => $slide['description_title_font_size'],
                    'description_title_direction' => $slide['description_title_direction'],
                    'button_title' => $slide['button_title'],
                    'button_link' => $slide['button_link'],
                    'button_font_color' => $slide['button_font_color'],
                    'button_bg_color' => $slide['button_bg_color'],
                    'button_position' => $slide['button_position'],
                    'button_animation' => $slide['button_animation'],
                    'button_delay' => $slide['button_delay'],
                    'is_open_in_new_window' => $slide['is_open_in_new_window'],
                ]);

                if ($slide['file']) {
                    $fileId = File::insertGetId([
                        'params' => json_encode($slide['file']['params']),
                        'object_type' => $slide['file']['object_type'],
                        'object_id' => $slide['file']['object_id'],
                        'uploaded_by' => $slide['file']['uploaded_by'],
                        'file_name' => $slide['file']['file_name'],
                        'file_size' => $slide['file']['file_size'],
                        'original_file_name' => $slide['file']['original_file_name'],
                    ]);

                    ObjectFile::insert([
                        'object_type' => $slide['object_file']['object_type'],
                        'object_id' => $slideId,
                        'file_id' => $fileId,
                    ]);
                }
            }
        }

        return $this;
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

        FacadeFile::copyDirectory(storage_path('homepage/unzipped/images'), public_path('uploads/'));

        $this->successMessage = __('Images successfully copied.');

        return $this;
    }

    /**
     * Finished
     *
     * @return $this
     */
    private function finished()
    {
        if (! $this->errorMessage) {
            $this->successMessage = __('Homepage successfully imported');
        }

        FacadeFile::deleteDirectory(storage_path('homepage/unzipped'));

        Artisan::call('cache:clear');
        Artisan::call('view:clear');
        Artisan::call('config:clear');
        Artisan::call('route:clear');

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
