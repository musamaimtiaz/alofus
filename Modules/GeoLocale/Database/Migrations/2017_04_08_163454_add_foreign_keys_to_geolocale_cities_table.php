<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToGeoLocaleCitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('geolocale_cities', function (Blueprint $table) {
            $table->foreign('country_id', 'geolocale_cities_ibfk_1')->references('id')->on('geolocale_countries')->onUpdate('RESTRICT')->onDelete('CASCADE');
            $table->foreign('division_id', 'geolocale_cities_ibfk_2')->references('id')->on('geolocale_divisions')->onUpdate('RESTRICT')->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('geolocale_cities', function (Blueprint $table) {
            $table->dropForeign('geolocale_cities_ibfk_1');
            $table->dropForeign('geolocale_cities_ibfk_2');
        });
    }
}
