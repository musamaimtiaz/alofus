<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('files', function (Blueprint $table) {
            $table->id();
            $table->string('params', 191)->nullable();
            $table->string('object_type', 191)->nullable();
            $table->string('object_id', 191)->nullable();
            $table->integer('uploaded_by')->nullable();
            $table->string('file_name', 191)->nullable();
            $table->float('file_size', 8, 2)->nullable();
            $table->string('original_file_name', 191)->nullable();
            $table->timestamp('created_at')->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('files');
    }
}
