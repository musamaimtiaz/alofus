<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToGeoLocaleCountriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('geolocale_countries', function (Blueprint $table) {
            $table->foreign('continent_id', 'geolocale_countries_ibfk_1')->references('id')->on('geolocale_continents')->onUpdate('RESTRICT')->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('geolocale_countries', function (Blueprint $table) {
            $table->dropForeign('geolocale_countries_ibfk_1');
        });
    }
}
