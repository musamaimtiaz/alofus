<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateThreadRepliesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('thread_replies', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('thread_id')->unsigned();
            $table->integer('sender_id')->unsigned()->nullable()->index();
            $table->integer('receiver_id')->unsigned()->nullable()->index();
            $table->dateTime('date')->nullable()->index();
            $table->text('message')->nullable();
            $table->boolean('has_attachment')->default(0)->index();
            $table->boolean('is_read')->default(0)->index();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('thread_replies');
    }
}
