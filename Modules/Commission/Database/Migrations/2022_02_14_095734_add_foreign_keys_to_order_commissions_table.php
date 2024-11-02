<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeysToOrderCommissionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('order_commissions', function (Blueprint $table) {
            $table->foreign(['category_id'])->references(['id'])->on('categories')->onUpdate('CASCADE')->onDelete('CASCADE');
            $table->foreign(['vendor_id'])->references(['id'])->on('vendors')->onUpdate('CASCADE')->onDelete('CASCADE');
            $table->foreign(['order_details_id'], 'order_commissions_order_detail_id_foreign')->references(['id'])->on('order_details')->onUpdate('CASCADE')->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('order_commissions', function (Blueprint $table) {
            $table->dropForeign('order_commissions_category_id_foreign');
            $table->dropForeign('order_commissions_vendor_id_foreign');
            $table->dropForeign('order_commissions_order_detail_id_foreign');
        });
    }
}
