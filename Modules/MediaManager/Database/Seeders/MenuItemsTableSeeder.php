<?php

namespace Modules\MediaManager\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MenuItemsTableSeeder extends Seeder
{
    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        DB::table('menu_items')->upsert([
            ['id' => 61, 'label' => 'Media Manager', 'link' => 'uploaded-files', 'params' => '{"permission":"Modules\\\\MediaManager\\\\Http\\\\Controllers\\\\MediaManagerController@uploadedFiles", "route_name":["mediaManager.create", "mediaManager.upload", "mediaManager.uploadedFiles", "mediaManager.sortFiles", "mediaManager.paginateFiles", "mediaManager.download", "mediaManager.maxId"], "menu_level":"1"}', 'is_default' => 1, 'icon' => 'fas fa-folder-open', 'parent' => 0, 'sort' => 43, 'class' => null, 'menu' => 1, 'depth' => 0],
        ], 'id');

    }
}
