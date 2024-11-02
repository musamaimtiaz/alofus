<?php

namespace Modules\Refund\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AdminMenusTableSeeder extends Seeder
{
    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        DB::table('admin_menus')->upsert([
            [
                'name' => 'Refunds',
                'url' => 'refund-requests',
                'slug' => 'admin-refund-requests',
                'permission' => '{"permission":"Modules\\\\Refund\\\\Http\\\\Controllers\\\\RefundController@index","route_name":["refund.index"], "menu_level":"1"}',
                'is_default' => 1,
            ],
            [
                'name' => 'Refunds',
                'url' => 'refund-requests',
                'slug' => 'vendor-refund-requests',
                'permission' => '{"permission":"Modules\\\\Refund\\\\Http\\\\Controllers\\\\Vendor\\\\RefundController@index","route_name":["vendor.refund.index"], "menu_level":"3"}',
                'is_default' => 1,
            ],
            [
                'name' => 'Refund',
                'url' => 'refund-request',
                'slug' => 'user-refund-request',
                'permission' => '{"permission":"Modules\\\\Refund\\\\Http\\\\Controllers\\\\Site\\\\RefundController@index","route_name":["site.refundRequest"], "menu_level":"2"}',
                'is_default' => 1,
            ],
        ], 'slug');

    }
}
