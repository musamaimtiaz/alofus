<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeysToVendorCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('vendor_categories', function (Blueprint $table) {
            $table->foreign(['category_id'])->references(['id'])->on('categories')->onUpdate('CASCADE')->onDelete('CASCADE');
            $table->foreign(['shop_id'])->references(['id'])->on('shops')->onUpdate('SET NULL')->onDelete('SET NULL');
            $table->foreign(['vendor_id'])->references(['id'])->on('vendors')->onUpdate('CASCADE')->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('vendor_categories', function (Blueprint $table) {
            $table->dropForeign('vendor_categories_category_id_foreign');
            $table->dropForeign('vendor_categories_shop_id_foreign');
            $table->dropForeign('vendor_categories_vendor_id_foreign');
        });
    }
}
