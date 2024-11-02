<?php

namespace Modules\MenuBuilder\Database\Seeders\versions\v2_0_0;

use Illuminate\Database\Seeder;

class MenuItemsTableSeeder extends Seeder
{
    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        addMenuItem('vendor', 'Decorate Shop', [
            'link' => 'homes',
            'icon' => 'fas fa-building',
            'sort' => 5,
            'params' => '{"permission":"Modules\\\\CMS\\\Http\\\\Controllers\\\\Vendor\\\\HomeController@index", "route_name":["vendor.home", "vendor.home.edit", "vendor.home.create", "vendor.builder.edit"], "menu_level":"3"}',
        ]);

        $barCodeId = addMenuItem('admin', 'Barcode', [
            'icon' => 'fas fa-building',
            'sort' => 8,
            'icon' => 'fas fa-barcode',
        ]);

        addMenuItem('admin', 'Product', [
            'link' => 'barcode/product',
            'params' => '{"permission":"App\\\\Http\\\\Controllers\\\\BarcodeController@product","route_name":["barcode.product"]}',
            'sort' => 1,
            'parent' => $barCodeId,
        ]);

        addMenuItem('admin', 'Settings', [
            'link' => 'barcode/settings',
            'params' => '{"permission":"App\\\\Http\\\\Controllers\\\\BarcodeController@settings","route_name":["barcode.settings"]}',
            'sort' => 2,
            'parent' => $barCodeId,
        ]);

        addMenuItem('vendor', 'Barcode', [
            'link' => 'barcode/product',
            'params' => '{"permission":"App\\\\Http\\\\Controllers\\\\Vendor\\\\BarcodeController@product","route_name":["vendor.barcode.product"]}',
            'sort' => 2,
            'icon' => 'fas fa-barcode',
        ]);

        addMenuItem('vendor', 'Categories', [
            'link' => 'all-categories',
            'params' => '{"permission":"App\\\\Http\\\\Controllers\\\\Vendor\\\\CategoryController@index","route_name":["vendor.categories.index"], "menu_level":"3"}',
            'sort' => 3,
            'icon' => 'fas fa-align-left',
        ]);
    }
}
