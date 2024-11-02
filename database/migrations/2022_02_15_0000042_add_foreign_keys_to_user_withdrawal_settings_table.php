<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeysToUserWithdrawalSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('user_withdrawal_settings', function (Blueprint $table) {
            $table->foreign('user_id')->references('id')->on('users')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('withdrawal_method_id')->references('id')->on('withdrawal_methods')->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('user_withdrawal_settings', function (Blueprint $table) {
            $table->dropForeign('user_withdrawal_settings_user_id_foreign');
            $table->dropForeign('user_withdrawal_settings_withdrawal_method_id_foreign');
        });
    }
}
