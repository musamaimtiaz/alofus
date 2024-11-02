<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserWithdrawalSettingsTable extends Migration
{
    public function up()
    {
        Schema::create('user_withdrawal_settings', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('user_id')->index();
            $table->integer('withdrawal_method_id')->unsigned()->index();

            $table->text('param');
            $table->boolean('is_default')->default(false);

            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrentOnUpdate()->nullable();
        });

    }

    public function down()
    {
        Schema::dropIfExists('user_withdrawal_settings');
    }
}
