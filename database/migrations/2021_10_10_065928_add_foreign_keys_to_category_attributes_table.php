<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeysToCategoryAttributesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('category_attributes', function (Blueprint $table) {
            $table->foreign(['attribute_id'])->references(['id'])->on('attributes')->onUpdate('CASCADE')->onDelete('CASCADE');
            $table->foreign(['category_id'])->references(['id'])->on('categories')->onUpdate('CASCADE')->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('category_attributes', function (Blueprint $table) {
            $table->dropForeign('category_attributes_attribute_id_foreign');
            $table->dropForeign('category_attributes_category_id_foreign');
        });
    }
}
