<?php

namespace Modules\Report\Database\Seeders;

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
            ['name' => 'Reports', 'slug' => 'reports', 'url' => 'reports', 'permission' => '{"permission":"Modules\\\\Report\\\\Http\\\\Controllers\\\\ReportController@index", "route_name":["reports"], "menu_level":"1"}', 'is_default' => 1],
            ['name' => 'Reports', 'slug' => 'vendor-report', 'url' => 'reports', 'permission' => '{"permission":"Modules\\\\Report\\\\Http\\\\Controllers\\\\Vendor\\\\ReportController@index", "route_name":["vendor.reports"], "menu_level":"3"}', 'is_default' => 1],
        ], 'slug');

    }
}
