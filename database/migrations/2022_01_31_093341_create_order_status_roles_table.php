<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrderStatusRolesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_status_roles', function (Blueprint $table) {
            $table->unsignedInteger('order_status_id')->index('order_status_roles_order_status_id_foreign_idx');
            $table->integer('role_id')->index('order_status_roles_role_id_foreign_idx');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('order_status_roles');
    }
}
