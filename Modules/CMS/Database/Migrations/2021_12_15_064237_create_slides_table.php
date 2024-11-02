<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSlidesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('slides', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('slider_id');
            $table->string('title_text', 191)->nullable();
            $table->string('title_animation', 191)->nullable();
            $table->float('title_delay', 4, 3)->nullable();
            $table->string('title_font_color', 191)->nullable();
            $table->integer('title_font_size')->nullable();
            $table->string('title_direction', 6)->nullable();
            $table->string('sub_title_text', 191)->nullable();
            $table->string('sub_title_animation', 191)->nullable();
            $table->float('sub_title_delay', 4, 3)->nullable();
            $table->string('sub_title_font_color', 191)->nullable();
            $table->integer('sub_title_font_size')->nullable();
            $table->string('sub_title_direction', 6)->nullable();
            $table->string('description_title_text', 191)->nullable();
            $table->string('description_title_animation', 191)->nullable();
            $table->float('description_title_delay', 4, 3)->nullable();
            $table->string('description_title_font_color', 191)->nullable();
            $table->integer('description_title_font_size')->nullable();
            $table->string('description_title_direction', 6)->nullable();
            $table->string('button_title', 191)->nullable();
            $table->string('button_link', 191)->nullable();
            $table->string('button_font_color', 20)->default('#ffffff');
            $table->string('button_bg_color', 20)->default('#000000');
            $table->string('button_position', 6)->nullable();
            $table->string('button_animation', 191)->default('fadeIn');
            $table->float('button_delay', 4, 3)->nullable();
            $table->string('is_open_in_new_window', 3)->default('Yes');
            $table->timestamps();
            $table->foreign('slider_id')->references('id')->on('sliders')
                ->onDelete('cascade')
                ->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('slides');
    }
}
