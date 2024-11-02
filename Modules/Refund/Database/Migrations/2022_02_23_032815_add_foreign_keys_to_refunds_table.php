<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeysToRefundsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('refunds', function (Blueprint $table) {
            $table->foreign(['user_id'])->references(['id'])->on('users')->onUpdate('CASCADE')->onDelete('CASCADE');
            $table->foreign(['order_detail_id'])->references(['id'])->on('order_details')->onUpdate('CASCADE')->onDelete('CASCADE');
            $table->foreign(['refund_reason_id'])->references(['id'])->on('refund_reasons')->onUpdate('CASCADE')->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('refunds', function (Blueprint $table) {
            $table->dropForeign('refunds_user_id_foreign');
            $table->dropForeign('refunds_order_detail_id_foreign');
            $table->dropForeign('refunds_refund_reason_id_foreign');
        });
    }
}
