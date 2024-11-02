<?php

namespace Modules\Coupon\Database\Seeders;

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
                'name' => 'Coupons',
                'slug' => 'coupons',
                'url' => 'coupons',
                'permission' => '{"permission":"Modules\\\\Coupon\\\\Http\\\\Controllers\\\\CouponController@index", "route_name":["coupon.index"], "menu_level":"1"}',
                'is_default' => 1,
            ],
            [
                'name' => 'Coupons',
                'slug' => 'vendor-coupons',
                'url' => 'coupons',
                'permission' => '{"permission":"Modules\\\\Coupon\\\\Http\\\\Controllers\\\\Vendor\\\\CouponController@index", "route_name":["vendor.coupons"], "menu_level":"3"}',
                'is_default' => 1,
            ],
        ], 'slug');
    }
}
