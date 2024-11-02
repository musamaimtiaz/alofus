<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateShippingZoneShippingClassesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('shipping_zone_shipping_classes', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('shipping_zone_id')->unsigned()->index();
            $table->string('shipping_class_slug', 120)->nullable()->index();
            $table->decimal('cost', 16, 8)->nullable()->index();
            $table->string('cost_type', 50)->nullable()->index();

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
        Schema::dropIfExists('shipping_zone_shipping_classes');
    }
}
