<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeysToOrderStatusRolesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('order_status_roles', function (Blueprint $table) {
            $table->foreign(['order_status_id'])->references(['id'])->on('order_statuses')->onUpdate('CASCADE')->onDelete('CASCADE');
            $table->foreign(['role_id'])->references(['id'])->on('roles')->onUpdate('CASCADE')->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('order_status_roles', function (Blueprint $table) {
            $table->dropForeign('order_status_roles_order_status_id_foreign');
            $table->dropForeign('order_status_roles_role_id_foreign');
        });
    }
}
