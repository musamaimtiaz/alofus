<?php

use Illuminate\Database\Migrations\Migration;

class ProductTrigger extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        // -- trigger on after insert wishlist
        \DB::unprepared('
            CREATE TRIGGER `wishlists_AINS` AFTER INSERT ON `wishlists`
            FOR EACH ROW UPDATE products SET total_wish = (select count(product_id) from wishlists WHERE product_id = products.id) WHERE products.id = NEW.product_id
        ');

        // -- trigger on after delete wishlist
        \DB::unprepared('
            CREATE TRIGGER `wishlists_ADEL` AFTER DELETE ON `wishlists`
            FOR EACH ROW UPDATE products SET total_wish = (select count(product_id) from wishlists WHERE product_id = products.id) WHERE products.id = OLD.product_id
        ');

        // -- trigger on after insert review
        \DB::unprepared('
            CREATE TRIGGER `reviews_AINS` AFTER INSERT ON `reviews`
            FOR EACH ROW UPDATE products SET review_count = (select count(product_id) from reviews WHERE product_id = products.id AND is_public = "1" AND status = "Active"), review_average = (select avg(rating) from reviews WHERE product_id = products.id AND is_public = "1" AND status = "Active") WHERE products.id = NEW.product_id
        ');

        // -- trigger on after update review
        \DB::unprepared('
            CREATE TRIGGER `reviews_AUPD` AFTER UPDATE ON `reviews`
            FOR EACH ROW UPDATE products SET review_count = (select count(product_id) from reviews WHERE product_id = products.id AND is_public = "1" AND status = "Active"), review_average = (select avg(rating) from reviews WHERE product_id = products.id AND is_public = "1" AND status = "Active") WHERE products.id = NEW.product_id
        ');

        // -- trigger on after delete review
        \DB::unprepared('
            CREATE TRIGGER `reviews_ADEL` AFTER DELETE ON `reviews`
            FOR EACH ROW UPDATE products SET review_count = (select count(product_id) from reviews WHERE product_id = products.id AND is_public = "1" AND status = "Active"), review_average = (select avg(rating) from reviews WHERE product_id = products.id AND is_public = "1" AND status = "Active") WHERE products.id = OLD.product_id
        ');

        \DB::unprepared('
            CREATE TRIGGER `order_details_product_stats_ins` AFTER INSERT ON `order_details` FOR EACH ROW
            BEGIN IF NEW.parent_id IS NOT NULL THEN SET @mpid = NEW.parent_id; ELSE SET @mpid = NEW.product_id; END IF; INSERT INTO product_stats (`product_id`,`count_sales`,`date`) VALUES (@mpid, 1, CURDATE()) ON DUPLICATE KEY UPDATE count_sales = count_sales + 1; END;
        ');

        \DB::unprepared('
            CREATE TRIGGER `product_stats_counter_upd` AFTER UPDATE ON `product_stats` FOR EACH ROW BEGIN update products set products.total_views = CASE WHEN OLD.count_views = NEW.count_views THEN products.total_views ELSE products.total_views + 1 END, products.total_sales = CASE WHEN OLD.count_sales = NEW.count_sales THEN products.total_sales ELSE products.total_sales + 1 END WHERE id = NEW.product_id;
            IF (select `brand_id` from products where id = NEW.product_id) is not null THEN IF NEW.count_views != OLD.count_views THEN INSERT INTO brand_stats (`brand_id`,`count_views`,`date`) VALUES ((select `brand_id` from products where id = NEW.product_id), 1, CURDATE()) ON DUPLICATE KEY UPDATE count_views = count_views + 1; END IF;
            IF NEW.count_sales != OLD.count_sales THEN INSERT INTO brand_stats (`brand_id`,`count_sales`,`date`) VALUES ((select `brand_id` from products where id = NEW.product_id), 1, CURDATE()) ON DUPLICATE KEY UPDATE count_sales = count_sales + 1; END IF; END IF; END
        ');

        \DB::unprepared('
            CREATE TRIGGER `product_stats_counter_ins` AFTER INSERT ON `product_stats`
            FOR EACH ROW BEGIN update products set products.total_views = CASE WHEN NEW.count_views = 1 THEN products.total_views + 1 ELSE products.total_views END, products.total_sales = CASE WHEN NEW.count_sales = 1 THEN products.total_sales + 1 ELSE products.total_sales END WHERE id = NEW.product_id;
            IF (select `brand_id` from products where id = NEW.product_id) is not null THEN IF NEW.count_views != 0 THEN INSERT INTO brand_stats (`brand_id`,`count_views`,`date`) VALUES ((select `brand_id` from products where id = NEW.product_id), 1, CURDATE()) ON DUPLICATE KEY UPDATE count_views = count_views + 1; END IF;
            IF NEW.count_sales != 0 THEN INSERT INTO brand_stats (`brand_id`,`count_sales`,`date`) VALUES ((select `brand_id` from products where id = NEW.product_id), 1, CURDATE()) ON DUPLICATE KEY UPDATE count_sales = count_sales + 1; END IF; END IF; END
        ');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        \DB::unprepared('DROP TRIGGER `order_details_AINS`');
        \DB::unprepared('DROP TRIGGER `reviews_ADEL`');
        \DB::unprepared('DROP TRIGGER `reviews_AINS`');
        \DB::unprepared('DROP TRIGGER `reviews_AUPD`');
        \DB::unprepared('DROP TRIGGER `wishlists_ADEL`');
        \DB::unprepared('DROP TRIGGER `wishlists_AINS`');
        \DB::unprepared('DROP TRIGGER `product_stats_counter_ins`');
        \DB::unprepared('DROP TRIGGER `product_stats_counter_upd`');
    }
}
