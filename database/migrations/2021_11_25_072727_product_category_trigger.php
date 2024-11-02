<?php

use Illuminate\Database\Migrations\Migration;

class ProductCategoryTrigger extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // -- trigger on after soft delete product
        \DB::unprepared('
            CREATE TRIGGER `products_AUPD` AFTER UPDATE ON products
            FOR EACH ROW
            BEGIN
                IF !(NEW.deleted_at <=> OLD.deleted_at) THEN
                    DELETE FROM product_categories
                        WHERE product_categories.product_id = OLD.id;
                END IF;
            END;
        ');

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        \DB::unprepared('DROP TRIGGER `products_AUPD`');
    }
}
