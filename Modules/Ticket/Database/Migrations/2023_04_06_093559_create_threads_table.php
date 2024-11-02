<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateThreadsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('threads', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('receiver_id')->nullable()->index('threads_receiver_id_foreign_idx');
            $table->string('email')->nullable();
            $table->string('name')->nullable();
            $table->string('thread_type', 8)->nullable();
            $table->integer('department_id')->unsigned()->nullable();
            $table->integer('priority_id')->unsigned()->nullable();
            $table->unsignedInteger('thread_status_id')->nullable()->index('threads_status_to_index');
            $table->string('thread_key', 45)->index('threads_key_to_index');
            $table->string('subject')->nullable();
            $table->bigInteger('sender_id')->nullable()->index();
            $table->dateTime('date')->nullable();
            $table->integer('project_id')->unsigned()->nullable();
            $table->dateTime('last_reply')->nullable();
            $table->integer('assigned_member_id')->unsigned()->nullable()->index('threads_member_to_index');

            $table->foreign(['receiver_id'])->references(['id'])->on('users')->onUpdate('CASCADE')->onDelete('CASCADE');
            $table->foreign(['sender_id'])->references(['id'])->on('users')->onUpdate('CASCADE')->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('threads');
    }
}
