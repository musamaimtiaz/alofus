<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnToPagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('pages', function (Blueprint $table) {
            $table->bigInteger('vendor_id')->nullable()->index()->after('slug');

            $table->foreign('vendor_id')->references('id')->on('vendors')->onDelete('set null')->onUpdate('cascade');
        });
    }
}
