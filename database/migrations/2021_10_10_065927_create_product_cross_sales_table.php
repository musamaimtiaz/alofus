<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductCrossSalesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_cross_sales', function (Blueprint $table) {
            $table->unsignedBigInteger('product_id')->index('product_cross_sales_product_id_idx');
            $table->integer('cross_sale_product_id')->index('product_cross_sales_cross_sale_product_id_foreign_idx');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('product_cross_sales');
    }
}
