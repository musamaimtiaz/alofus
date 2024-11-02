<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePopupsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('popups', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 120)->unique()->index();
            $table->string('type', 50)->index();
            $table->integer('show_time')->default(30)->comment('second');
            $table->text('page_link');
            $table->boolean('login_enabled')->default(false);
            $table->integer('show_again')->nullable()->comment('days');
            $table->text('param')->nullable()->comment('JSON');
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->string('status', 10)->default('Inactive')->index();
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
        Schema::dropIfExists('popups');
    }
}
