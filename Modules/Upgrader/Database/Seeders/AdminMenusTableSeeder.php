<?php

namespace Modules\Upgrader\Database\Seeders;

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
            ['id' => 144, 'name' => 'System Update', 'slug' => 'system-update', 'url' => 'system-update', 'permission' => '{"permission":"Modules\\\\Upgrater\\\\Http\\\\Controllers\\\\SystemUpdateController@upgrade", "route_name":["systemUpdate.upgrade"], "menu_level":"2"}', 'is_default' => 1],
        ], 'id');
    }
}
