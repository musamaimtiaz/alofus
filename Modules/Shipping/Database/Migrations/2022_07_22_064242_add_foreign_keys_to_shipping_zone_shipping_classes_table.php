<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeysToShippingZoneShippingClassesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('shipping_zone_shipping_classes', function (Blueprint $table) {
            $table->foreign(['shipping_zone_id'])->references(['id'])->on('shipping_zones')->onUpdate('CASCADE')->onDelete('CASCADE');
            $table->foreign('shipping_class_slug')->references('slug')->on('shipping_classes')->onUpdate('CASCADE')->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('shipping_zone_shipping_classes', function (Blueprint $table) {
            $table->dropForeign('shipping_zone_shipping_classes_shipping_zone_id_foreign');
            $table->dropForeign('shipping_zone_shipping_classes_shipping_class_slug_foreign');
        });
    }
}
