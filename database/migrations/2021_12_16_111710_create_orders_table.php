<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('user_id')->nullable()->index('orders_user_id_foreign_idx');
            $table->string('reference', 45)->index();
            $table->text('note')->nullable();
            $table->date('order_date')->index();
            $table->unsignedInteger('currency_id')->index('orders_currency_id_foreign_idx');
            $table->boolean('leave_door')->nullable();
            $table->decimal('other_discount_amount', 16, 8)->nullable()->default(0);
            $table->string('other_discount_type', 45)->nullable();
            $table->decimal('shipping_charge', 16, 8)->nullable();
            $table->decimal('tax_charge', 16, 8)->nullable();
            $table->string('shipping_title')->nullable();
            $table->decimal('total', 16, 8)->index();
            $table->decimal('paid', 16, 8)->index();
            $table->decimal('total_quantity', 16, 8);
            $table->decimal('amount_received', 16, 8)->nullable()->index();
            $table->unsignedInteger('order_status_id')->nullable()->index('orders_order_status_id_foreign_idx');
            $table->boolean('is_delivery')->default(false);
            $table->string('payment_status', 15)->default('Unpaid');
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
        Schema::dropIfExists('orders');
    }
}
