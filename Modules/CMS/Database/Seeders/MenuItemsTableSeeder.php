<?php

namespace Modules\CMS\Database\Seeders;

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
            ['id' => 57, 'label' => 'Website Setup', 'link' => null, 'params' => null, 'is_default' => 1, 'icon' => 'fas fa-globe', 'parent' => 0, 'sort' => 39, 'class' => null, 'menu' => 1, 'depth' => 0],
            ['id' => 58, 'label' => 'All Sliders', 'link' => 'sliders', 'params' => '{"permission":"Modules\\\\CMS\\\\Http\\\\Controllers\\\\SliderController@index", "route_name":["slider.index", "slide.create", "slide.edit"], "menu_level":"1"}', 'is_default' => 1, 'icon' => null, 'parent' => 57, 'sort' => 39, 'class' => null, 'menu' => 1, 'depth' => 1],
            ['id' => 60, 'label' => 'Pages', 'link' => 'page/list', 'params' => '{"permission":"Modules\\\\CMS\\\\Http\\\\Controllers\\\\CMSController@index", "route_name":["page.index", "page.create", "page.edit"], "menu_level":"1"}', 'is_default' => 1, 'icon' => null, 'parent' => 57, 'sort' => 41, 'class' => null, 'menu' => 1, 'depth' => 1],
            ['id' => 92, 'label' => 'Appearance', 'link' => 'theme/list', 'params' => '{"permission":"Modules\\\\CMS\\\\Http\\\\Controllers\\\\ThemeOptionController@list", "route_name":["theme.index", "theme.store"], "menu_level":"1"}', 'is_default' => 1, 'icon' => null, 'parent' => 57, 'sort' => 42, 'class' => null, 'menu' => 1, 'depth' => 1],
            ['id' => 93, 'label' => 'Home Pages', 'link' => 'page/home/list', 'params' => '{"permission":"Modules\\\\CMS\\\\Http\\\\Controllers\\\\CMSController@index", "route_name":["page.home", "builder.edit", "page.home.create", "page.home.edit"], "menu_level":"1"}', 'is_default' => 1, 'icon' => null, 'parent' => 57, 'sort' => 40, 'class' => null, 'menu' => 1, 'depth' => 1],
        ], 'id');
    }
}
