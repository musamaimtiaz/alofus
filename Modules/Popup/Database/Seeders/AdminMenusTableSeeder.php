<?php

namespace Modules\Popup\Database\Seeders;

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
            ['name' => 'Popup', 'slug' => 'popups', 'url' => 'popups', 'permission' => '{"permission":"Modules\\\\Popup\\\\Http\\\\Controllers\\\\PopupController@index", "route_name":["popup.index"], "menu_level":"1"}', 'is_default' => 1],
        ], 'slug');

    }
}
