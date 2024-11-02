<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmailConfigurationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('email_configurations', function (Blueprint $table) {
            $table->integer('id', true);
            $table->string('protocol');
            $table->string('encryption');
            $table->string('smtp_host');
            $table->string('smtp_port');
            $table->string('smtp_email');
            $table->string('smtp_username');
            $table->string('smtp_password');
            $table->string('from_address');
            $table->string('from_name');
            $table->string('status', 10)->comment('1= verified, 0= unverified');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('email_configurations');
    }
}
