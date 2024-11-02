<?php

namespace Modules\Report\Database\Seeders;

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
            ['id' => 63, 'label' => 'Reports', 'link' => 'reports', 'params' => '{"permission":"Modules\\\\Report\\\\Http\\\\Controllers\\\\ReportController@index", "route_name":["reports"], "menu_level":"1"}', 'is_default' => 1, 'icon' => 'fas fa-chart-bar', 'parent' => 0, 'sort' => 57, 'class' => null, 'menu' => 1, 'depth' => 0, 'is_custom_menu' => 0],
            ['id' => 102, 'label' => 'Reports', 'link' => 'reports', 'params' => '{"permission":"Modules\\\\Report\\\\Http\\\\Controllers\\\\Vendor\\\\ReportController@index", "route_name":["vendor.reports"], "menu_level":"3"}', 'is_default' => 1, 'icon' => 'fas fa-chart-bar', 'parent' => 0, 'sort' => 10, 'class' => null, 'menu' => 3, 'depth' => 0, 'is_custom_menu' => 0],
        ], 'id');

    }
}
