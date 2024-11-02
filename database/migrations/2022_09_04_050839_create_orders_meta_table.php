<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersMetaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders_meta', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedBigInteger('order_id')->index('orders_meta_order_id_foreign_idx');
            $table->string('type')->default('null');
            $table->string('key')->index();
            $table->string('value', 10000)->nullable();
            $table->unique(['key', 'order_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('orders_meta');
    }
}
