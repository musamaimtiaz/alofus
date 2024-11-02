<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReviewsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reviews', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->text('comments')->nullable();
            $table->boolean('rating')->nullable();
            $table->string('reviewed_by', 50)->nullable();
            $table->bigInteger('user_id')->nullable()->index('reviews_user_id_foreign_idx');
            $table->unsignedBigInteger('product_id')->index('reviews_product_id_foreign_idx');
            $table->boolean('is_public')->default(false);
            $table->string('status', 10)->default('Inactive')->index();
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
        Schema::dropIfExists('reviews');
    }
}
