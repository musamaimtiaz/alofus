<?php

use Illuminate\Database\Migrations\Migration;

class TagTrigger extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // -- trigger on after delete product tag
        \DB::unprepared('
            CREATE TRIGGER `product_tags_ADEL` AFTER DELETE ON `product_tags`
            FOR EACH ROW UPDATE tags SET product_counts = (select count(product_id) from product_tags WHERE tag_id = tags.id) WHERE tags.id = OLD.tag_id
        ');

        // -- trigger on after insert product tag
        \DB::unprepared('
            CREATE TRIGGER `product_tags_AINS` AFTER INSERT ON `product_tags`
            FOR EACH ROW UPDATE tags SET product_counts = (select count(product_id) from product_tags WHERE tag_id = tags.id) WHERE tags.id = NEW.tag_id
        ');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        \DB::unprepared('DROP TRIGGER `product_tags_ADEL`');
        \DB::unprepared('DROP TRIGGER `product_tags_AINS`');
    }
}
