<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWishlistsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('wishlists', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedBigInteger('product_id')->index('wishlist_product_id_foreign_idx');
            $table->bigInteger('user_id')->index('wishlist_user_id_foreign_idx');
            $table->string('ip_address', 16)->index('wishlist_ip_address_index');
            $table->string('browser_agent', 30)->nullable()->index('wishlist_browser_agent_index');
            $table->timestamp('created_at')->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('wishlists');
    }
}
