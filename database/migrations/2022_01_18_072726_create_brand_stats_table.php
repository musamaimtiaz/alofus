<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBrandStatsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('brand_stats', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('brand_id');
            $table->integer('count_views')->default(0);
            $table->integer('count_sales')->default(0);
            $table->date('date');
            $table->unique(['brand_id', 'date']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('product_stats');
    }
}
