<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCouponsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('coupons', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name', 120)->index();
            $table->bigInteger('vendor_id')->nullable()->index();
            $table->bigInteger('shop_id')->nullable()->index();
            $table->integer('usage_limit')->nullable()->index();
            $table->decimal('minimum_spend', 16, 8)->nullable();
            $table->integer('usage_count')->nullable();
            $table->string('code', 100)->index();
            $table->string('discount_type', 15)->index();
            $table->decimal('discount_amount', 16, 8)->index();
            $table->decimal('maximum_discount_amount', 16, 8)->nullable();
            $table->date('start_date')->index();
            $table->date('end_date')->index();
            $table->string('status', 10)->default('Inactive')->index();
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrentOnUpdate()->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('coupons');
    }
}
