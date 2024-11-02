<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateComponentPropertiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('component_properties', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('component_id')->index('component_properties_component_id_foreign_idx');
            $table->string('name')->nullable();
            $table->string('type')->nullable();
            $table->string('value', 15000)->nullable();
            $table->unique(['name', 'component_id']);
            $table->foreign(['component_id'])->references(['id'])->on('components')->onUpdate('CASCADE')->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('component_properties');
    }
}
