<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateShopsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('shops', function (Blueprint $table) {
            $table->bigInteger('id', true);
            $table->bigInteger('vendor_id')->index('shops_vendor_id_foreign_idx');
            $table->string('name', 100)->index();
            $table->string('email', 100)->nullable()->index();
            $table->string('website')->nullable();
            $table->string('alias', 45)->unique();
            $table->string('address')->nullable();
            $table->string('country', 100)->nullable();
            $table->string('state', 100)->nullable();
            $table->string('city', 100)->nullable();
            $table->string('post_code', 10)->nullable();
            $table->string('phone', 45)->nullable()->index();
            $table->string('fax', 45)->nullable();
            $table->string('description', 5000)->nullable();
            $table->string('status', 20)->default('Active')->index()->comment('Active/Inactive;');
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
        Schema::dropIfExists('shops');
    }
}
