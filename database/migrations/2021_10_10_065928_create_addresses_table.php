<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAddressesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('addresses', function (Blueprint $table) {
            $table->increments('id');
            $table->bigInteger('user_id')->index('address_user_id_foreign_idx');
            $table->string('first_name', 191)->index();
            $table->string('last_name', 191)->nullable()->index();
            $table->string('phone', 45)->nullable();
            $table->string('email')->nullable();
            $table->string('company_name')->nullable();
            $table->string('type_of_place', 20)->default('home')->comment('home/office');
            $table->string('address_1', 191);
            $table->string('address_2', 191)->nullable();
            $table->string('city', 191)->index();
            $table->string('state', 191)->nullable()->index();
            $table->string('zip', 191)->nullable()->index();
            $table->string('country', 191)->index();
            $table->mediumInteger('is_default')->default(0);
            $table->timestamp('created_at')->nullable()->useCurrent();
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
        Schema::dropIfExists('addresses');
    }
}
