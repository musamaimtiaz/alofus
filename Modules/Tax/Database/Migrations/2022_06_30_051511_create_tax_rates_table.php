<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTaxRatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tax_rates', function (Blueprint $table) {
            $table->bigIncrements('id', true);
            $table->integer('tax_class_id')->unsigned()->index();
            $table->string('country', 30)->nullable()->index();
            $table->string('state', 30)->nullable()->index();
            $table->string('city', 30)->nullable()->index();
            $table->string('postcode', 10)->nullable();
            $table->string('name', 50)->nullable()->index();
            $table->decimal('tax_rate', 16, 8)->nullable()->index();
            $table->integer('priority')->nullable()->default(0)->index();
            $table->tinyInteger('compound')->nullable();
            $table->tinyInteger('shipping')->nullable()->default(1);
            $table->integer('sort_by')->default(0);
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
        Schema::dropIfExists('tax_rates');
    }
}
