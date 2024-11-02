<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->bigInteger('id', true);
            $table->string('name')->index();
            $table->string('email')->index();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->string('phone', 45)->nullable();
            $table->date('birthday')->nullable();
            $table->string('gender', 10)->nullable();
            $table->tinyText('address')->nullable();
            $table->string('sso_account_id')->nullable();
            $table->string('sso_service')->nullable();
            $table->rememberToken();
            $table->string('status', 15)->default('Pending')->index();
            $table->string('activation_code')->nullable();
            $table->string('activation_otp')->nullable();
            $table->timestamp('created_at')->nullable()->useCurrent();
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
        Schema::dropIfExists('users');
    }
}
