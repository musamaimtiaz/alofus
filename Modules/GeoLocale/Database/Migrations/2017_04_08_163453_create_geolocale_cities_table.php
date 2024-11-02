<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateGeoLocaleCitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('geolocale_cities', function (Blueprint $table) {
            $table->bigIncrements('id')->comment('Auto increase ID');
            $table->bigInteger('country_id')->unsigned()->comment('Country ID');
            $table->bigInteger('division_id')->unsigned()->nullable()->index('division_id')->comment('Division ID');
            $table->string('name', 191)->default('')->comment('City Name');
            $table->string('full_name', 191)->nullable()->comment('City Fullname');
            $table->string('code', 64)->nullable()->comment('City Code');
            $table->index(['country_id', 'division_id', 'name'], 'uniq_city');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('geolocale_cities');
    }
}
