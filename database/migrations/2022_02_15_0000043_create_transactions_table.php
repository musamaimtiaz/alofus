<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransactionsTable extends Migration
{
    public function up()
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('user_id')->nullable()->index()->comment('Who paid for this transaction');
            $table->integer('currency_id')->unsigned()->index();
            $table->integer('account_id')->nullable()->index()->comment('account_id refers accounts table id');
            $table->bigInteger('shop_id')->nullable()->index();
            $table->bigInteger('vendor_id')->nullable()->index();
            $table->bigInteger('order_id')->unsigned()->nullable()->index();
            $table->integer('withdrawal_method_id')->unsigned()->nullable()->index();
            $table->integer('exchange_currency_id')->nullable()->unsigned()->index();
            $table->decimal('exchange_rate', 12, 8)->nullable();

            $table->decimal('amount', 16, 8)->nullable()->comment('product amount');
            $table->decimal('charge_amount', 16, 8)->nullable()->comment('payment processor fee');
            $table->decimal('commission_amount', 16, 8)->nullable()->comment('admin/platform fee');
            $table->decimal('discount_amount', 16, 8)->nullable()->comment('amount user got as discount');
            $table->decimal('paid_amount', 16, 8)->nullable()->comment('payer paid after discount');
            $table->decimal('total_amount', 16, 8)->index()->nullable()->comment('Receiver amount after all fees');

            $table->string('transaction_type', 100)->index();
            $table->date('transaction_date')->index();
            $table->string('reference_number', 100)->nullable()->index();
            $table->string('reference_type', 50)->nullable()->index();

            $table->text('description', 1000)->nullable();
            $table->text('params')->nullable();
            $table->string('status', 20)->comment('Pending/Rejected/Accepted');

            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrentOnUpdate()->nullable();
        });

    }

    public function down()
    {
        Schema::dropIfExists('transactions');
    }
}
