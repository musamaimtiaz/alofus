<?php

namespace Modules\Popup\Database\Seeders;

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
                'id' => 81,
                'label' => 'Add Popup',
                'link' => 'popup/create',
                'params' => '{"permission":"Modules\\\\Popup\\\\Http\\\\Controllers\\\\PopupController@create", "route_name":["popup.create"], "menu_level":"1"}',
                'is_default' => 1,
                'icon' => null,
                'parent' => 73,
                'sort' => 30,
                'class' => null,
                'menu' => 1,
                'depth' => 1,
            ],
            [
                'id' => 64,
                'label' => 'All popups',
                'link' => 'popups',
                'params' => '{"permission":"Modules\\\\Popup\\\\Http\\\\Controllers\\\\PopupController@index", "route_name":["popup.index", "popup.show", "popup.store", "popup.edit", "popup.update", "popup.delete"], "menu_level":"1"}',
                'is_default' => 1,
                'icon' => null,
                'parent' => 73,
                'sort' => 31,
                'class' => null,
                'menu' => 1,
                'depth' => 1,
            ],
        ], 'id');

    }
}
