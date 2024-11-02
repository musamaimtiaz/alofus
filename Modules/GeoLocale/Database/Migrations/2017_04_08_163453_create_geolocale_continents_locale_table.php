<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateGeoLocaleContinentsLocaleTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('geolocale_continents_locale', function (Blueprint $table) {
            $table->bigIncrements('id')->comment('Auto increase ID');
            $table->bigInteger('continent_id')->unsigned()->comment('Continent ID');
            $table->string('name', 191)->nullable()->comment('Localized Name');
            $table->string('alias', 191)->nullable()->comment('Localized Alias');
            $table->string('abbr', 16)->nullable()->comment('Localized Abbr name');
            $table->string('full_name', 191)->nullable()->comment('Localized Fullname');
            $table->string('locale', 6)->nullable()->comment('Locale');
            $table->unique(['continent_id', 'locale'], 'uniq_continent_id_locale');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('geolocale_continents_locale');
    }
}
