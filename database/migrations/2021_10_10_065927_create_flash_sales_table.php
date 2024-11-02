<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFlashSalesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('flash_sales', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('campaign name')->index();
            $table->unsignedBigInteger('product_id')->index('flash_sales_product_id_foreign_idx');
            $table->dateTime('start_date_time', 5)->index();
            $table->dateTime('end_date_time', 5)->index();
            $table->decimal('price', 16, 8)->index();
            $table->decimal('quantity', 16, 8)->index();
            $table->bigInteger('vendor_id')->nullable()->index('flash_sales_vendor_id_foreign_idx');
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
        Schema::dropIfExists('flash_sales');
    }
}
