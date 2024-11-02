<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrderCommissionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_commissions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('order_details_id')->index('order_commissions_order_detail_id_foreign_idx');
            $table->bigInteger('vendor_id')->nullable()->index('order_commissions_vendor_id_foreign_idx');
            $table->integer('category_id')->nullable()->index('order_commissions_category_id_foreign_idx');
            $table->decimal('amount', 16, 8)->nullable();
            $table->dateTime('approval_time', 5)->nullable()->index();
            $table->string('status', 12)->default('Pending')->index();
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
        Schema::dropIfExists('order_commissions');
    }
}
