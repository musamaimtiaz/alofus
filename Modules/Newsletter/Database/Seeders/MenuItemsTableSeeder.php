<?php

namespace Modules\Newsletter\Database\Seeders;

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
            ['id' => 84, 'label' => 'All Subscribers', 'link' => 'subscribers', 'params' => '{"permission":"Modules\\\\Newsletter\\\\Http\\\\Controllers\\\\SubscriberController@index","route_name":["subscriber.index","subscriber.edit","subscriber.update","subscriber.pdf","subscriber.csv"]}', 'is_default' => 1, 'icon' => null, 'parent' => 73, 'sort' => 32, 'class' => null, 'menu' => 1, 'depth' => 1],
        ], 'id');

    }
}
