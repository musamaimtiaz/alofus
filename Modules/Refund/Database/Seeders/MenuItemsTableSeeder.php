<?php

namespace Modules\Refund\Database\Seeders;

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
            38 => [
                'id' => 51,
                'label' => 'Refunds',
                'link' => 'refund-requests',
                'params' => '{"permission":"Modules\\\\Refund\\\\Http\\\\Controllers\\\\RefundController@index","route_name":["refund.index"], "menu_level":"1"}',
                'is_default' => 1,
                'icon' => null,
                'parent' => 43,
                'sort' => 17,
                'class' => null,
                'menu' => 1,
                'depth' => 1,
                'is_custom_menu' => 0,
            ],
            39 => [
                'id' => 52,
                'label' => 'Refunds',
                'link' => 'refund-requests',
                'params' => '{"permission":"Modules\\\\Refund\\\\Http\\\\Controllers\\\\Vendor\\\\RefundController@index","route_name":["vendor.refund.index"], "menu_level":"3"}',
                'is_default' => 1,
                'icon' => 'fas fa-retweet',
                'parent' => 0,
                'sort' => 6,
                'class' => null,
                'menu' => 3,
                'depth' => 0,
                'is_custom_menu' => 0,
            ],
            40 => [
                'id' => 53,
                'label' => 'Refunds',
                'link' => 'refund-request',
                'params' => '{"permission":"Modules\\\\Refund\\\\Http\\\\Controllers\\\\Site\\\\RefundController@index","route_name":["site.refundRequest", "site.createRefundRequest", "site.refundDetails"], "menu_level":"2"}',
                'is_default' => 1,
                'icon' => 'fas fa-backward',
                'parent' => 0,
                'sort' => 5,
                'class' => null,
                'menu' => 2,
                'depth' => 0,
                'is_custom_menu' => 0,
            ],
        ], 'id');

    }
}
