<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateGeoLocaleDivisionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('geolocale_divisions', function (Blueprint $table) {
            $table->bigIncrements('id')->comment('Auto Increase ID');
            $table->bigInteger('country_id')->unsigned()->comment('Country ID');
            $table->string('name', 191)->default('')->comment('Division Common Name');
            $table->string('full_name', 191)->nullable()->comment('Division Full Name');
            $table->string('code', 64)->nullable()->comment('ISO 3166-2 Code');
            $table->boolean('has_city')->default(0)->comment('Has city?');
            $table->unique(['country_id', 'name'], 'uniq_division');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('geolocale_divisions');
    }
}
