<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVendorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vendors', function (Blueprint $table) {
            $table->bigInteger('id', true);
            $table->string('name')->index()->unique();
            $table->string('email', 100)->nullable()->index()->unique();
            $table->string('phone', 45);
            $table->string('formal_name')->nullable()->index('vendors_formal_name');
            $table->string('status', 15)->default('Pending')->index();
            $table->string('website')->nullable();
            $table->decimal('sell_commissions', 16, 8)->nullable()->index();
            $table->timestamp('created_at')->useCurrent();
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
        Schema::dropIfExists('vendors');
    }
}
