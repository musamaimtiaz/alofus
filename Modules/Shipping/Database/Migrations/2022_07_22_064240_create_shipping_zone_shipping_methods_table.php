<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateShippingZoneShippingMethodsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('shipping_zone_shipping_methods', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('shipping_zone_id')->unsigned()->index();
            $table->integer('shipping_method_id')->unsigned()->index();
            $table->string('method_title', 191)->nullable();
            $table->string('tax_status')->nullable()->index();
            $table->decimal('cost', 16, 8)->nullable()->index()->comment('free shipping minimum order');
            $table->string('cost_type', 50)->nullable()->index();
            $table->string('calculation_type', 191)->nullable()->index()->comment('free shipping coupon discount');
            $table->string('requirements', 191)->nullable()->index();
            $table->tinyInteger('status')->default(0)->index();

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
        Schema::dropIfExists('shipping_zone_shipping_methods');
    }
}
