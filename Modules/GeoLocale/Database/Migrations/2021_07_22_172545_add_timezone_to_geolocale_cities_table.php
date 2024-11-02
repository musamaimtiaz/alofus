<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTimezoneToGeoLocaleCitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('geolocale_cities', function (Blueprint $table) {
            $table->string('iana_timezone', 191)
                ->after('code')
                ->nullable()
                ->comment('IANA Timezone Name');
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
            $table->dropColumn('iana_timezone');
        });
    }
}
