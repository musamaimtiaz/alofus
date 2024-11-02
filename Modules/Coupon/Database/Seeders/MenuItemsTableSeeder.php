<?php

namespace Modules\Coupon\Database\Seeders;

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
            ['id' => 72, 'label' => 'Add coupon', 'link' => 'coupon/create', 'params' => '{"permission":"Modules\\\\Coupon\\\\Http\\\\Controllers\\\\CouponController@create","route_name":["coupon.create"]}', 'is_default' => 1, 'icon' => null, 'parent' => 73, 'sort' => 27, 'class' => null, 'menu' => 1, 'depth' => 1],

            ['id' => 105, 'label' => 'All Coupons', 'link' => 'coupons', 'params' => '{"permission":"Modules\\\\Coupon\\\\Http\\\\Controllers\\\\CouponController@index","route_name":["coupon.index","coupon.edit","coupon.pdf","coupon.csv","coupon.shop","coupon.item"]}', 'is_default' => 1, 'icon' => null, 'parent' => 73, 'sort' => 28, 'class' => null, 'menu' => 1, 'depth' => 1],

            ['id' => 106, 'label' => 'Coupon Redeems', 'link' => 'coupon-redeems', 'params' => '{"permission":"Modules\\\\Coupon\\\\Http\\\\Controllers\\\\CouponRedeemController@index","route_name":["couponRedeem.index"]}', 'is_default' => 1, 'icon' => null, 'parent' => 73, 'sort' => 29, 'class' => null, 'menu' => 1, 'depth' => 1],

            ['id' => 75, 'label' => 'Coupons', 'link' => 'coupons', 'params' => '{"permission":"Modules\\\\Coupon\\\\Http\\\\Controllers\\\\Vendor\\\\CouponController@index","route_name":["vendor.coupons", "vendor.couponCreate", "vendor.couponEdit", "vendor.couponProduct"]}', 'is_default' => 1, 'icon' => 'fas fa-ticket-alt', 'parent' => 0, 'sort' => 4, 'class' => null, 'menu' => 3, 'depth' => 0],
        ], 'id');
    }
}
