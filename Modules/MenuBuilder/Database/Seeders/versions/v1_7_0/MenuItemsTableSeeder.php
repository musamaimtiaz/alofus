<?php

namespace Modules\MenuBuilder\Database\Seeders\versions\v1_7_0;

use Illuminate\Database\Seeder;
use Modules\MenuBuilder\Http\Models\MenuItems;

class MenuItemsTableSeeder extends Seeder
{
    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        $customerMenuData = [
            'label' => 'Customers',
            'link' => 'customer',
            'params' => '{"permission":"App\\\\Http\\\\Controllers\\\\Vendor\\\\CustomerController@index", "route_name":["vendor.customer"], "menu_level":"3"}',
            'is_default' => 1,
            'icon' => 'fas fa-users',
            'parent' => 0,
            'sort' => 3,
            'class' => null,
            'menu' => 3,
            'depth' => 0,
            'is_custom_menu' => 0,
        ];

        MenuItems::updateOrInsert(['link' => 'customer', 'menu' => 3], $customerMenuData);
    }
}
