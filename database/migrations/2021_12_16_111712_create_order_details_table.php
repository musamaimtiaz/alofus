<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrderDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_details', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('product_id')->index('order_details_product_id_foreign_idx');
            $table->unsignedBigInteger('parent_id')->nullable()->index('order_details_parent_id_foreign_idx');
            $table->unsignedBigInteger('order_id')->index('order_details_order_id_foreign_idx');
            $table->bigInteger('vendor_id')->nullable()->index('order_details_vendor_id_foreign_idx');
            $table->bigInteger('shop_id')->nullable()->index('order_details_shop_id_foreign_idx');
            $table->text('description')->nullable();
            $table->string('product_name')->index();
            $table->decimal('price', 16, 8)->index();
            $table->decimal('quantity_sent', 16, 8)->index();
            $table->decimal('quantity', 16, 8)->index();
            $table->decimal('discount_amount', 16, 8)->unsigned()->nullable()->index();
            $table->string('discount_type', 12)->nullable()->index();
            $table->decimal('shipping_charge', 16, 8)->nullable();
            $table->decimal('tax_charge', 16, 8)->nullable();
            $table->string('hsn')->nullable()->index();
            $table->text('payloads')->nullable();
            $table->integer('order_by')->index();
            $table->unsignedInteger('order_status_id')->nullable()->index('order_details_order_status_id_foreign_idx');
            $table->boolean('is_delivery')->default(false);
            $table->integer('estimate_delivery')->nullable();
            $table->boolean('is_on_time')->nullable();
            $table->boolean('is_stock_reduce')->nullable();
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
        Schema::dropIfExists('order_details');
    }
}
