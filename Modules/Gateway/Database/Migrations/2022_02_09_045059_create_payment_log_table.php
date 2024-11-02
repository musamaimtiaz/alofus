<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePaymentLogTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payment_logs', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique()->index('payment_logs_code_foreign_idx');
            $table->string('unique_code')->unique()->nullable();
            $table->text('sending_details');
            $table->text('response_raw')->nullable();
            $table->text('response')->nullable();
            $table->string('gateway')->nullable();
            $table->string('payment_id')->nullable();
            $table->decimal('total', 16, 8);
            $table->string('currency_code');
            $table->string('status')->default('pending');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('payment_log');
    }
}
