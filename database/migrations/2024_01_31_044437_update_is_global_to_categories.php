<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class () extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Update existing rows to set is_global to 1
        DB::table('categories')->update(['is_global' => 1]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // Revert the change if needed
        DB::table('categories')->update(['is_global' => 0]);
    }
};
