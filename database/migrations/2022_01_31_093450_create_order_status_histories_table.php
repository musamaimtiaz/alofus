<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrderStatusHistoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_status_histories', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('product_id')->nullable()->index('order_status_histories_product_id_foreign_idx');
            $table->unsignedBigInteger('order_id')->index('order_status_histories_order_id_foreign_idx');
            $table->bigInteger('user_id')->nullable()->index('order_status_histories_user_id_foreign_idx');
            $table->unsignedInteger('order_status_id')->index('order_status_histories_order_status_id_foreign_idx');
            $table->text('note')->nullable();
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
        Schema::dropIfExists('order_status_histories');
    }
}
