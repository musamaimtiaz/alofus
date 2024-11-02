<?php

namespace Modules\Newsletter\Database\Seeders;

use Illuminate\Database\Seeder;

class AdminMenusTableSeeder extends Seeder
{
    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        \DB::table('admin_menus')->upsert([
            [
                'name' => 'Subscribers',
                'slug' => 'subscriber',
                'url' => 'subscribers',
                'permission' => '{"permission":"Modules\\\\Newsletter\\\\Http\\\\Controllers\\\\SubscriberController@index", "route_name":["subscriber.index"], "menu_level":"1"}',
                'is_default' => 1,
            ],
        ], 'slug');
    }
}
