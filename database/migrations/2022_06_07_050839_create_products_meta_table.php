<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsMetaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products_meta', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedBigInteger('product_id')->index('products_meta_product_id_foreign_idx');
            $table->unique(['key', 'product_id']);
            $table->string('type')->nullable()->default('null');
            $table->string('key')->index();
            $table->string('value', 10000)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('products_meta');
    }
}
