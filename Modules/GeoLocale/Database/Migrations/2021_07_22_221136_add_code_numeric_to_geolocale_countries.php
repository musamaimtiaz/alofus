<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCodeNumericToGeoLocaleCountries extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('geolocale_countries', function (Blueprint $table) {
            $table->smallInteger('code_numeric')
                ->after('code_alpha3')
                ->nullable()
                ->comment('ISO3166-1-Numeric');
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
            $table->dropColumn('code_numeric');
        });
    }
}
