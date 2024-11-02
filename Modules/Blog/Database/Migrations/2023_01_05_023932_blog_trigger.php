<?php

use Illuminate\Database\Migrations\Migration;

class BlogTrigger extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // -- trigger on after delete blog category
        \DB::unprepared('
            CREATE TRIGGER `blog_category_AFDEL` AFTER DELETE ON `blog_categories`
            FOR EACH ROW UPDATE blogs SET category_id = "1" WHERE category_id = OLD.id
        ');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        \DB::unprepared('DROP TRIGGER `blog_category_AFDEL`');
    }
}
