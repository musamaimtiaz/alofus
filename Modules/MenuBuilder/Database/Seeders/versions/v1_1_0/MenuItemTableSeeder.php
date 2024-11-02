<?php

namespace Modules\MenuBuilder\Database\Seeders\versions\v1_1_0;

use Illuminate\Database\Seeder;
use DB;
use Modules\MenuBuilder\Http\Models\MenuItems;

class MenuItemTableSeeder extends Seeder
{
    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {

        DB::table('menu_items')->where(['id' => 131, 'label' => 'product import'])->update(['label' => 'Import Products']);

        DB::table('menu_items')->where(['id' => 132, 'label' => 'Import'])->update([
            'label' => 'Tools',
            'link' => null,
            'params' => null,
        ]);

        $dbImportMenu = MenuItems::where(['label' => 'Tools'])->first();

        if ($dbImportMenu) {
            $importsMenu = MenuItems::where(['link' => 'imports'])->first();

            if (! $importsMenu) {
                MenuItems::insert([
                    'label' => 'Import',
                    'link' => 'imports',
                    'params' => '{"permission":"App\\\\Http\\\\Controllers\\\\ImportController@index", "route_name":["epz.import.products", "epz.imports", "epz.import.users"]}',
                    'is_default' => 1,
                    'icon' => null,
                    'parent' => 132,
                    'sort' => 48,
                    'class' => null,
                    'menu' => 1,
                    'depth' => 1,
                    'is_custom_menu' => 0,
                ]);
            }

            $exportMenu = MenuItems::where(['link' => 'exports'])->first();

            if (! $exportMenu) {
                MenuItems::insert([
                    'label' => 'Export',
                    'link' => 'exports',
                    'params' => '{"permission":"App\\\\Http\\\\Controllers\\\\ExportController@index", "route_name":["epz.export.products", "epz.exports"]}',
                    'is_default' => 1,
                    'icon' => null,
                    'parent' => 132,
                    'sort' => 49,
                    'class' => null,
                    'menu' => 1,
                    'depth' => 1,
                    'is_custom_menu' => 0,
                ]);
            }
        }

        $exportProduct = MenuItems::where(['link' => 'export/products'])->first();

        if (! $exportProduct) {
            MenuItems::insert([
                'label' => 'Export Products',
                'link' => 'export/products',
                'params' => '{"permission":"App\\\\Http\\\\Controllers\\\\Vendor\\\\ExportController@productExport", "route_name":["vendor.epz.export.products"], "menu_level":"3"}',
                'is_default' => 1,
                'icon' => 'fas fa-download',
                'parent' => 0,
                'sort' => 6,
                'class' => null,
                'menu' => 3,
                'depth' => 1,
                'is_custom_menu' => 0,
            ]);
        }

        $pages = MenuItems::where(['link' => '#pages', 'menu' => 4])->first();
        $categories = MenuItems::where(['link' => 'categories', 'menu' => 4])->first();

        if ($pages && ! $categories) {
            MenuItems::insert([
                'label' => 'All Categories',
                'link' => 'categories',
                'params' => null,
                'is_default' => 0,
                'icon' => null,
                'parent' => 122,
                'sort' => 16,
                'class' => null,
                'menu' => 4,
                'depth' => 1,
                'is_custom_menu' => 0,
            ]);
        }
    }
}
