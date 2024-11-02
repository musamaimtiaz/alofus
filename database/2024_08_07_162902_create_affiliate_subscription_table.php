<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('affiliate_subscription', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('cascade');
            $table->foreignId('plan_id')->constrained('plans')->onDelete('cascade');
            $table->string('stripe_subscription_id');
            $table->string('stripe_customer_id');
            $table->string('stripe_price_id');
            $table->string('plan_amount');
            $table->string('curency');
            $table->string('plan_intervel');
            $table->string('plan_intervel_count');
            $table->string('plan_start_date');
            $table->string('plan_end_date');
            $table->string('payer_email');
            $table->string('payment_status');
            $table->string('subscription_status');
            $table->string('status');
            $table->timestamp('billing_cycle_anchor');
            $table->string('mode');
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
        Schema::dropIfExists('affiliate_subscription');
    }
};
