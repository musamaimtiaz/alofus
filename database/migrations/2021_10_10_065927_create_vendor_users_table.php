<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVendorUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vendor_users', function (Blueprint $table) {
            $table->bigInteger('id', true);
            $table->bigInteger('vendor_id')->index('vendor_users_vendor_id_foreign_idx');
            $table->bigInteger('user_id')->index('vendor_users_user_id_foreign_idx');
            $table->string('status', 15)->default('Pending')->index();
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
        Schema::dropIfExists('vendor_users');
    }
}
