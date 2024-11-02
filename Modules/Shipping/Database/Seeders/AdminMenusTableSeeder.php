<?php

namespace Modules\Shipping\Database\Seeders;

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
                'name' => 'Shipping',
                'slug' => 'shipping',
                'url' => 'shippings',
                'permission' => '{"permission":"Modules\\\\Shipping\\\\Http\\\\Controllers\\\\ShippingController@index", "route_name":["shipping.index"], "menu_level":"1"}',
                'is_default' => 1,
            ],
        ], 'slug');
    }
}
