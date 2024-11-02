<?php

namespace Modules\Shipping\Database\Seeders;

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
            [
                'id' => 44,
                'label' => 'shipping',
                'link' => 'shippings',
                'params' => '{"permission":"Modules\\\\Shipping\\\\Http\\\\Controllers\\\\ShippingController@index","route_name":["shipping.index"]}',
                'is_default' => 1,
                'icon' => null,
                'parent' => 31,
                'sort' => 52,
                'class' => null,
                'menu' => 1,
                'depth' => 1,
                'is_custom_menu' => 0,
            ],
        ], 'id');

    }
}
