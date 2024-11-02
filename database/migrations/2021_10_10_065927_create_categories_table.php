<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('categories', function (Blueprint $table) {
            $table->integer('id', true);
            $table->string('name', 100)->index();
            $table->string('slug', 120)->index();
            $table->integer('parent_id')->nullable()->index('categories_parent_id_foreign_idx');
            $table->unsignedInteger('order_by')->index();
            $table->boolean('is_searchable')->default(false)->index();
            $table->boolean('is_featured')->default('0')->index();
            $table->unsignedInteger('product_counts')->nullable()->default('0');
            $table->decimal('sell_commissions', 16, 8)->nullable()->index();
            $table->string('status', 10)->default('Active')->index();
            $table->timestamp('created_at')->nullable()->useCurrent();
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
        Schema::dropIfExists('categories');
    }
}
