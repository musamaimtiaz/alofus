<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToGeoLocaleDivisionsLocaleTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('geolocale_divisions_locale', function (Blueprint $table) {
            $table->foreign('division_id', 'geolocale_divisions_locale_ibfk_1')->references('id')->on('geolocale_divisions')->onUpdate('RESTRICT')->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('geolocale_divisions_locale', function (Blueprint $table) {
            $table->dropForeign('geolocale_divisions_locale_ibfk_1');
        });
    }
}
