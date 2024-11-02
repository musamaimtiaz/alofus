<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmailTemplatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('email_templates', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('parent_id')->nullable();
            $table->string('name')->nullable()->index();
            $table->string('slug', 100)->nullable()->index();
            $table->string('subject')->index();
            $table->text('body');
            $table->integer('language_id')->index('email_templates_language_id_idx');
            $table->string('status', 10)->nullable();
            $table->text('variables')->nullable();
            $table->timestamp('created_at')->useCurrent();
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
        Schema::dropIfExists('email_templates');
    }
}
