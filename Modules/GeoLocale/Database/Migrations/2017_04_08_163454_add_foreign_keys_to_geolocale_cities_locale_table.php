<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToGeoLocaleCitiesLocaleTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('geolocale_cities_locale', function (Blueprint $table) {
            $table->foreign('city_id', 'geolocale_cities_locale_ibfk_1')->references('id')->on('geolocale_cities')->onUpdate('RESTRICT')->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('geolocale_cities_locale', function (Blueprint $table) {
            $table->dropForeign('geolocale_cities_locale_ibfk_1');
        });
    }
}
