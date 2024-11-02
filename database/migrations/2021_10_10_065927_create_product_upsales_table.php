<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductUpsalesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_upsales', function (Blueprint $table) {
            $table->unsignedBigInteger('product_id')->index('product_upsales_product_id_idx');
            $table->integer('upsale_product_id')->index('product_upsales_upsale_product_id_foreign_idx');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('product_upsales');
    }
}
