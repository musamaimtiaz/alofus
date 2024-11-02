<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeysToShippingZoneShippingMethodsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('shipping_zone_shipping_methods', function (Blueprint $table) {
            $table->foreign(['shipping_zone_id'])->references(['id'])->on('shipping_zones')->onUpdate('CASCADE')->onDelete('CASCADE');
            $table->foreign(['shipping_method_id'])->references(['id'])->on('shipping_methods')->onUpdate('CASCADE')->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('shipping_zone_shipping_methods', function (Blueprint $table) {
            $table->dropForeign('shipping_zone_shipping_methods_shipping_zone_id_foreign');
            $table->dropForeign('shipping_zone_shipping_methods_shipping_method_id_foreign');
        });
    }
}
