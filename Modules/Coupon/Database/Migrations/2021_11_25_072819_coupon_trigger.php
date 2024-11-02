<?php

use Illuminate\Database\Migrations\Migration;

class CouponTrigger extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // -- trigger on after insert product coupon
        \DB::unprepared('
            CREATE TRIGGER `coupon_redeems_AINS` AFTER INSERT ON `coupon_redeems` FOR EACH ROW
            UPDATE coupons SET usage_count = (select count(coupon_id) from coupon_redeems WHERE coupon_id = coupons.id) WHERE coupons.id = NEW.coupon_id;
        ');
        // -- trigger on after delete product coupon
        \DB::unprepared('
            CREATE TRIGGER `coupon_redeems_ADEL` AFTER DELETE ON `coupon_redeems` FOR EACH ROW
            UPDATE coupons SET usage_count = (select count(coupon_id) from coupon_redeems WHERE coupon_id = coupons.id) WHERE coupons.id = OLD.coupon_id;
        ');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        \DB::unprepared('DROP TRIGGER `product_coupons_AINS`');
        \DB::unprepared('DROP TRIGGER `product_coupons_ADEL`');
    }
}
