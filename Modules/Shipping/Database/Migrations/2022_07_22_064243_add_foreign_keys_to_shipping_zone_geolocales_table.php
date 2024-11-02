<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeysToShippingZoneGeolocalesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('shipping_zone_geolocales', function (Blueprint $table) {
            $table->foreign(['shipping_zone_id'])->references(['id'])->on('shipping_zones')->onUpdate('CASCADE')->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('shipping_zone_geolocales', function (Blueprint $table) {
            $table->dropForeign('shipping_zone_geolocales_shipping_zone_id_foreign');
        });
    }
}
