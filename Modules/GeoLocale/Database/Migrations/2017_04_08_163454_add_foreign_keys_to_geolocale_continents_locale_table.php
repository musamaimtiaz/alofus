<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToGeoLocaleContinentsLocaleTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('geolocale_continents_locale', function (Blueprint $table) {
            $table->foreign('continent_id', 'geolocale_continents_locale_ibfk_1')->references('id')->on('geolocale_continents')->onUpdate('RESTRICT')->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('geolocale_continents_locale', function (Blueprint $table) {
            $table->dropForeign('geolocale_continents_locale_ibfk_1');
        });
    }
}
