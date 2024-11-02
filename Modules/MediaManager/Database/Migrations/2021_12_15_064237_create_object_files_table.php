<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateObjectFilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('object_files', function (Blueprint $table) {
            $table->id();
            $table->string('object_type', 191);
            $table->integer('object_id');
            $table->unsignedBigInteger('file_id');

            $table->foreign('file_id')->references('id')->on('files')
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
        Schema::dropIfExists('object_files');
    }
}
