<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('code', 120)->index();
            $table->string('sku', 45)->nullable();
            $table->unsignedBigInteger('parent_id')->nullable()->index('products_parent_id_foreign_idx');
            $table->string('slug')->nullable()->index('products_slug_to_index');
            $table->string('name')->index();
            $table->text('description')->nullable();
            $table->string('summary')->nullable();
            $table->bigInteger('vendor_id')->nullable()->index('products_vendor_id_foreign_idx');
            $table->bigInteger('shop_id')->nullable()->index('products_shop_id_foreign_idx');
            $table->unsignedInteger('brand_id')->nullable()->index('products_brand_id_foreign_idx');
            $table->string('status', 15)->default('Draft')->index();
            $table->integer('total_wish')->default(0);
            $table->integer('total_sales')->default(0);
            $table->decimal('regular_price', 16, 8)->nullable()->index();
            $table->decimal('sale_price', 16, 8)->nullable()->index();
            $table->timestamp('sale_from')->nullable()->index();
            $table->timestamp('sale_to')->nullable()->index();
            $table->timestamp('available_from')->nullable()->index('products_availability_from_index');
            $table->timestamp('available_to')->nullable()->index('products_availability_to_index');
            $table->timestamp('featured')->nullable()->index('product_featured_index');
            $table->tinyInteger('manage_stocks')->default(0);
            $table->integer('total_stocks')->default(0);
            $table->unsignedSmallInteger('review_count')->nullable()->default('0');
            $table->decimal('review_average', 6)->nullable();
            $table->integer('total_views')->default(0);
            $table->string('type', 30)->default('Simple');
            $table->unsignedSmallInteger('menu_order')->nullable()->default('0');
            $table->timestamp('created_at')->nullable()->useCurrent();
            $table->timestamp('updated_at')->useCurrentOnUpdate()->nullable();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('products');
    }
}
