<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pages', function (Blueprint $table) {
            $table->id();
            $table->string('name', 150);
            $table->string('slug', 191);
            $table->string('css', 30000)->nullable();
            $table->mediumText('description')->nullable();
            $table->string('meta_title', 150)->nullable();
            $table->string('meta_description', 500)->nullable();
            $table->string('status', 8)->default('Active');
            $table->string('type')->nullable();
            $table->string('layout')->default('default');
            $table->boolean('default')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pages');
    }
}
