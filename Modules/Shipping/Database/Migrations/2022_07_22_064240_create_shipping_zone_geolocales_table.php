<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateShippingZoneGeolocalesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('shipping_zone_geolocales', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('shipping_zone_id')->unsigned()->index();
            $table->string('country')->nullable()->index();
            $table->string('state')->nullable()->index();
            $table->string('city')->nullable()->index();
            $table->string('zip', 10)->nullable();

            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrentOnUpdate()->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('shipping_zone_geolocales');
    }
}
