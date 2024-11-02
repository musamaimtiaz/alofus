<?php

namespace Modules\MediaManager\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AdminMenusTableSeeder extends Seeder
{
    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        DB::table('admin_menus')->upsert([
            ['name' => 'Media Manager', 'slug' => 'media-manager', 'url' => 'uploaded-files', 'permission' => '{"permission":"Modules\\\\MediaManager\\\\Http\\\\Controllers\\\\MediaManagerController@uploadedFiles", "route_name":["mediaManager.create", "mediaManager.upload", "mediaManager.uploadedFiles", "mediaManager.sortFiles", "mediaManager.paginateFiles", "mediaManager.download", "mediaManager.maxId"], "menu_level":"1"}', 'is_default' => 1],
        ], 'slug');

    }
}
