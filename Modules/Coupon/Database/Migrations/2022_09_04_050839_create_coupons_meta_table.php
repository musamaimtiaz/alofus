<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCouponsMetaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('coupons_meta', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedBigInteger('coupon_id')->index('coupons_meta_coupon_id_foreign_idx');
            $table->string('type')->default('null');
            $table->string('key')->index();
            $table->string('value', 5000)->nullable();
            $table->unique(['key', 'coupon_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('coupons_meta');
    }
}
