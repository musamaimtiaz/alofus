<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateGeoLocaleCitiesLocaleTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('geolocale_cities_locale', function (Blueprint $table) {
            $table->bigIncrements('id')->comment('Auto increase ID');
            $table->bigInteger('city_id')->unsigned()->comment('City ID');
            $table->string('name', 191)->default('')->comment('Localized city name');
            $table->string('alias', 191)->nullable()->comment('Localized city alias');
            $table->string('full_name', 191)->nullable()->comment('Localized city fullname');
            $table->string('locale', 6)->nullable()->comment('locale name');
            $table->unique(['city_id', 'locale'], 'uniq_city_id_locale');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('geolocale_cities_locale');
    }
}
