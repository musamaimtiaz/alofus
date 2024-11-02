<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRefundsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('refunds', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->bigInteger('user_id')->index();
            $table->bigInteger('order_detail_id')->unsigned()->index();
            $table->integer('refund_reason_id')->unsigned()->index();
            $table->string('reference')->comment('unique string');
            $table->integer('quantity_sent')->unsigned()->default(1);
            $table->string('refund_type', 30)->comment('Full/Partial');
            $table->string('refund_method', 30)->comment('Wallet/Bank');
            $table->string('shipping_method', 30)->comment('Courier/Drop');
            $table->string('payment_status', 20)->comment('Paid/Unpaid');
            $table->string('status', 20)->comment('Opened/In progress/Declined/Accepted');

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
        Schema::dropIfExists('refunds');
    }
}
