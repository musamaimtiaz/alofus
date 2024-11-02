<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLanguagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('languages', function (Blueprint $table) {
            $table->integer('id', true);
            $table->string('name', 50)->index();
            $table->string('short_name', 5)->index();
            $table->string('flag', 100)->nullable();
            $table->string('status', 16)->default('Active')->index()->comment('\'Active\', \'Inactive');
            $table->boolean('is_default')->index();
            $table->string('direction', 8)->default('ltr')->comment('(\'ltr\', \'rtl\') ltr = left-to-right directionrtl = right-to-left direction');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('languages');
    }
}
