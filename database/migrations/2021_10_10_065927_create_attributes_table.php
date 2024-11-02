<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAttributesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('attributes', function (Blueprint $table) {
            $table->bigInteger('id', true);
            $table->integer('attribute_group_id')->nullable();
            $table->string('name', 100)->index();
            $table->text('description')->nullable();
            $table->string('type', 30)->nullable()->index();
            $table->string('status', 8)->default('Active')->index();
            $table->boolean('is_filterable')->default(false);
            $table->boolean('is_required')->default(false);
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
        Schema::dropIfExists('attributes');
    }
}
