<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWithdrawalMethodsTable extends Migration
{
    public function up()
    {
        Schema::create('withdrawal_methods', function (Blueprint $table) {
            $table->increments('id');
            $table->string('method_name', 50)->unique();
            $table->text('params')->nullable();
            $table->string('status', 20)->comment('Active/Inactive');

            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrentOnUpdate()->nullable();
        });

    }

    public function down()
    {
        Schema::dropIfExists('withdrawal_methods');
    }
}
