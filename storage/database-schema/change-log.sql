-- captcha_configurations table
CREATE TABLE `captcha_configurations`
(
    `id`              int(10) unsigned NOT NULL AUTO_INCREMENT,
    `site_key`        varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
    `secret_key`      varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
    `site_verify_url` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
    `plugin_url`      varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
    PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Captcha permission in preference table
INSERT INTO `preferences` (`id`, `category`, `field`, `value`) VALUES (NULL, 'preference', 'captcha', 'disable');

 -- sms_configurations table
CREATE TABLE `sms_configurations`
(
    `id`             int(10) unsigned NOT NULL AUTO_INCREMENT,
    `type`           varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci  NOT NULL,
    `status`         varchar(8)                                                    NOT NULL,
    `key`            varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
    `secret_key`     varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
    `is_default`     tinyint(1) NOT NULL DEFAULT '0',
    `default_number` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci  NOT NULL,
    PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- brands table
CREATE TABLE `brands`
(
    `id`          int(11) unsigned NOT NULL AUTO_INCREMENT,
    `vendor_id`   bigint(20) DEFAULT NULL,
    `name`        varchar(50) NOT NULL,
    `description` text,
    `status`      varchar(10) NOT NULL DEFAULT 'Active',
    `created_at`  timestamp   NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `updated_at`  timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    UNIQUE KEY `brands_name_unique` (`name`),
    KEY           `brands_name_index` (`name`),
    KEY           `brands_status_index` (`status`),
    KEY           `brands_vendor_id_foreign_idx` (`vendor_id`),
    CONSTRAINT `brands_vendor_id_foreign` FOREIGN KEY (`vendor_id`) REFERENCES `vendors` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- categories table
CREATE TABLE `categories`
(
    `id`            int(11) NOT NULL AUTO_INCREMENT,
    `name`          varchar(100) NOT NULL,
    `slug`          varchar(120) NOT NULL,
    `parent_id`     int(11) DEFAULT NULL,
    `order_by`      int(8) unsigned NOT NULL,
    `is_searchable` tinyint(1) NOT NULL DEFAULT '0',
    `item_counts`   int(8) unsigned DEFAULT '0',
    `status`        varchar(10)  NOT NULL DEFAULT 'Active',
    `created_at`    timestamp NULL DEFAULT CURRENT_TIMESTAMP,
    `updated_at`    timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    KEY             `categories_name_index` (`name`),
    KEY             `categories_slug_index` (`slug`),
    KEY             `categories_order_by_index` (`order_by`),
    KEY             `categories_status_index` (`status`),
    KEY             `categories_is_searchable_index` (`is_searchable`),
    KEY             `categories_parent_id_foreign_idx` (`parent_id`),
    CONSTRAINT `categories_parent_id_foreign` FOREIGN KEY (`parent_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- attribute_groups table
CREATE TABLE `attribute_groups`
(
    `id`         int(11) NOT NULL AUTO_INCREMENT,
    `vendor_id`  bigint(20) DEFAULT NULL,
    `name`       varchar(50) NOT NULL,
    `summary`    varchar(255) DEFAULT NULL,
    `status`     varchar(10) NOT NULL DEFAULT 'Active',
    `created_at` timestamp   NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `updated_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    UNIQUE KEY `attribute_groups_name_unique` (`name`),
    KEY          `attribute_groups_name_index` (`name`),
    KEY          `attribute_groups_status_index` (`status`),
    KEY          `attribute_groups_vendor_id_foreign_idx` (`vendor_id`),
    CONSTRAINT `attribute_groups_vendor_id_foreign` FOREIGN KEY (`vendor_id`) REFERENCES `vendors` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- attribute_values table
CREATE TABLE `attribute_values`
(
    `id`           bigint(20) NOT NULL AUTO_INCREMENT,
    `attribute_id` bigint(20) NOT NULL,
    `value`        varchar(50) NOT NULL DEFAULT '',
    `order_by`     int(8) NOT NULL,
    `status`       varchar(8)  NOT NULL DEFAULT 'Active',
    `created_at`   timestamp   NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `updated_at`   timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    KEY            `attribute_values_value_index` (`value`),
    KEY            `attribute_values_status_index` (`status`),
    KEY            `attribute_values_attribute_id_foreign_idx` (`attribute_id`),
    CONSTRAINT `attribute_values_attribute_id_foreign` FOREIGN KEY (`attribute_id`) REFERENCES `attributes` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- attributes table
CREATE TABLE `attributes`
(
    `id`                 bigint(20) NOT NULL AUTO_INCREMENT,
    `attribute_group_id` int(11) NOT NULL,
    `category_id`        int(11) NOT NULL,
    `name`               varchar(100) NOT NULL,
    `type`               varchar(30)  NOT NULL,
    `status`             varchar(8)   NOT NULL DEFAULT 'Active',
    `is_filterable`      tinyint(1) NOT NULL DEFAULT '0',
    `is_required`        tinyint(1) NOT NULL DEFAULT '0',
    `created_at`         timestamp    NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `updated_at`         timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    KEY                  `attributes_name_index` (`name`),
    KEY                  `attributes_status_index` (`status`),
    KEY                  `attributes_attribute_group_id_foreign_idx` (`attribute_group_id`),
    KEY                  `attributes_category_id_foreign_idx` (`category_id`),
    KEY                  `attributes_type_index` (`type`),
    CONSTRAINT `attributes_attribute_group_id_foreign` FOREIGN KEY (`attribute_group_id`) REFERENCES `attribute_groups` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
    CONSTRAINT `attributes_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- category_attributes table
CREATE TABLE `category_attributes`
(
    `category_id`  int(11) NOT NULL,
    `attribute_id` bigint(20) NOT NULL,
    KEY            `category_attributes_category_id_foreign_idx` (`category_id`),
    KEY            `category_attributes_attribute_id_foreign_idx` (`attribute_id`),
    CONSTRAINT `category_attributes_attribute_id_foreign` FOREIGN KEY (`attribute_id`) REFERENCES `attributes` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
    CONSTRAINT `category_attributes_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- items table
CREATE TABLE `items`
(
    `id`                         bigint(20) unsigned NOT NULL AUTO_INCREMENT,
    `code`                  varchar(120)   NOT NULL,
    `name`                       varchar(255)   NOT NULL,
    `description`                text,
    `summary`                    varchar(255)            DEFAULT NULL,
    `video_url`                  varchar(255)            DEFAULT NULL,
    `review_count`               smallint(5) unsigned DEFAULT '0',
    `review_average`             decimal(6, 2)           DEFAULT NULL,
    `availablity_from`           varchar(50)             DEFAULT NULL,
    `availablity_to`             varchar(50)             DEFAULT NULL,
    `vendor_id`                  bigint(20) DEFAULT NULL,
    `brand_id`                   int(11) unsigned DEFAULT NULL,
    `status`                     varchar(8)     NOT NULL DEFAULT 'Active',
    `is_virtual`                 tinyint(1) NOT NULL DEFAULT '0',
    `is_shippable`               tinyint(1) NOT NULL DEFAULT '0',
    `is_shareable`               tinyint(1) NOT NULL DEFAULT '0',
    `favourite_count`            int(5) DEFAULT NULL,
    `total_wish`                 int(5) DEFAULT NULL,
    `price`                      decimal(16, 8)          DEFAULT NULL,
    `discount_amount`            decimal(16, 8)          DEFAULT NULL,
    `discount_type`              varchar(20)             DEFAULT NULL,
    `discounted_price`           decimal(16, 8)          DEFAULT NULL,
    `discount_from`              varchar(50)             DEFAULT NULL,
    `discount_to`                varchar(50)             DEFAULT NULL,
    `maximum_discount_amount`    decimal(16, 8) NOT NULL,
    `minimum_order_for_discount` varchar(45)    NOT NULL,
    `sku`                        varchar(45)    NOT NULL,
    `is_inventory_enabled`       tinyint(1) NOT NULL DEFAULT '0',
    `item_quantity`              decimal(16, 8) NOT NULL,
    `stock_availability`         decimal(16, 8) NOT NULL,
    `created_at`                 timestamp NULL DEFAULT CURRENT_TIMESTAMP,
    `updated_at`                 timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    KEY                          `items_code_index` (`code`),
    KEY                          `items_name_index` (`name`),
    KEY                          `items_availablity_from_index` (`availablity_from`),
    KEY                          `items_availablity_to_index` (`availablity_to`),
    KEY                          `items_status_index` (`status`),
    KEY                          `items_price_index` (`price`),
    KEY                          `items_discount_amount_index` (`discount_amount`),
    KEY                          `items_discount_type_index` (`discount_type`),
    KEY                          `items_discounted_price_index` (`discounted_price`),
    KEY                          `items_discount_from_index` (`discount_from`),
    KEY                          `items_discount_to_index` (`discount_to`),
    KEY                          `items_vendor_id_foreign_idx` (`vendor_id`),
    KEY                          `items_brand_id_foreign_idx` (`brand_id`),
    CONSTRAINT `items_brand_id_foreign` FOREIGN KEY (`brand_id`) REFERENCES `brands` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
    CONSTRAINT `items_vendor_id_foreign` FOREIGN KEY (`vendor_id`) REFERENCES `vendors` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- option_groups table
CREATE TABLE `option_groups`
(
    `id`          bigint(20) NOT NULL AUTO_INCREMENT,
    `vendor_id`   bigint(20) DEFAULT NULL,
    `category_id` int(11) NOT NULL,
    `name`        varchar(50) NOT NULL,
    `type`        varchar(30) NOT NULL,
    `is_required` tinyint(1) NOT NULL DEFAULT '0',
    `created_at`  timestamp   NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `updated_at`  timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    KEY           `option_groups_name_index` (`name`),
    KEY           `option_groups_type_index` (`type`),
    KEY           `option_groups_vendor_id_foreign_idx` (`vendor_id`),
    KEY           `option_groups_category_id_idx` (`category_id`),
    CONSTRAINT `option_groups_category_id` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
    CONSTRAINT `option_groups_vendor_id_foreign` FOREIGN KEY (`vendor_id`) REFERENCES `vendors` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- options table
CREATE TABLE `options`
(
    `id`              bigint(20) NOT NULL AUTO_INCREMENT,
    `option_group_id` bigint(20) NOT NULL,
    `option`          varchar(191)            DEFAULT NULL,
    `is_default`      tinyint(1) NOT NULL DEFAULT '0',
    `price`           decimal(16, 8) NOT NULL,
    `price_type`      varchar(10)    NOT NULL,
    `status`          varchar(8)     NOT NULL DEFAULT 'Active',
    `order_by`        int(8) DEFAULT NULL,
    `created_at`      timestamp      NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    KEY               `options_option_index` (`option`),
    KEY               `options_price_index` (`price`),
    KEY               `options_price_type_index` (`price_type`),
    KEY               `options_status_index` (`status`),
    KEY               `options_option_group_id_foreign_idx` (`option_group_id`),
    CONSTRAINT `options_option_group_id_foreign` FOREIGN KEY (`option_group_id`) REFERENCES `option_groups` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- tags table
CREATE TABLE `tags`
(
    `id`         bigint(20) NOT NULL AUTO_INCREMENT,
    `name`       varchar(50) NOT NULL,
    `vendor_id`   bigint(20) DEFAULT NULL,
    `item_counts` int(8) unsigned DEFAULT '0',
    `status`     varchar(8)  NOT NULL DEFAULT 'Active',
    `created_at` timestamp   NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `updated_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    UNIQUE KEY `tags_name_unique` (`name`),
    KEY          `tags_status_index` (`status`),
    KEY          `tags_vendor_id_foreign_idx` (`vendor_id`),
    CONSTRAINT `tags_vendor_id_foreign` FOREIGN KEY (`vendor_id`) REFERENCES `vendors` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- coupons table
CREATE TABLE `coupons`
(
    `id`                      bigint(20) unsigned NOT NULL AUTO_INCREMENT,
    `name`                    varchar(120)   NOT NULL,
    `code`                    varchar(100)   NOT NULL,
    `discount_type`           varchar(15)    NOT NULL,
    `discount_amount`         decimal(16, 8) NOT NULL,
    `maximum_discount_amount` decimal(16, 8)          DEFAULT NULL,
    `start_date`              date           NOT NULL,
    `end_date`                date           NOT NULL,
    `status`                  varchar(10)    NOT NULL DEFAULT 'Inactive',
    `created_at`              timestamp      NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `updated_at`              timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    KEY                       `coupons_name_index` (`name`),
    KEY                       `coupons_code_index` (`code`),
    KEY                       `coupons_discount_type_index` (`discount_type`),
    KEY                       `coupons_discount_amount_index` (`discount_amount`),
    KEY                       `coupons_start_date_index` (`start_date`),
    KEY                       `coupons_end_date_index` (`end_date`),
    KEY                       `coupons_status_index` (`status`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- favourites table
CREATE TABLE `favourites`
(
    `id`            int(11) unsigned NOT NULL AUTO_INCREMENT,
    `item_id`       bigint(20) unsigned NOT NULL,
    `user_id`       bigint(20) NOT NULL,
    `ip_address`    varchar(16) NOT NULL,
    `browser_agent` varchar(12)          DEFAULT NULL,
    `created_at`    timestamp   NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    KEY             `favourites_ip_address_index` (`ip_address`),
    KEY             `favourites_browser_agent_index` (`browser_agent`),
    KEY             `favourites_item_id_foreign_idx` (`item_id`),
    KEY             `favourites_user_id_foreign_idx` (`user_id`),
    CONSTRAINT `favourites_item_id_foreign` FOREIGN KEY (`item_id`) REFERENCES `items` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
    CONSTRAINT `favourites_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- flash_sales table
CREATE TABLE `flash_sales`
(
    `id`              bigint(20) unsigned NOT NULL AUTO_INCREMENT,
    `campaign name`   varchar(255)   NOT NULL,
    `item_id`         bigint(20) unsigned NOT NULL,
    `start_date_time` datetime(5) NOT NULL,
    `end_date_time`   datetime(5) NOT NULL,
    `price`           decimal(16, 8) NOT NULL,
    `quantity`        decimal(16, 8) NOT NULL,
    `vendor_id`       bigint(20) DEFAULT NULL,
    `created_at`      timestamp      NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `updated_at`      timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    KEY               `flash_sales_campaign name_index` (`campaign name`),
    KEY               `flash_sales_price_index` (`price`),
    KEY               `flash_sales_quantity_index` (`quantity`),
    KEY               `flash_sales_start_date_time_index` (`start_date_time`),
    KEY               `flash_sales_end_date_time_index` (`end_date_time`),
    KEY               `flash_sales_item_id_foreign_idx` (`item_id`),
    KEY               `flash_sales_vendor_id_foreign_idx` (`vendor_id`),
    CONSTRAINT `flash_sales_item_id_foreign` FOREIGN KEY (`item_id`) REFERENCES `items` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
    CONSTRAINT `flash_sales_vendor_id_foreign` FOREIGN KEY (`vendor_id`) REFERENCES `vendors` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- item_categories table
CREATE TABLE `item_categories`
(
    `item_id`     bigint(20) unsigned NOT NULL,
    `category_id` int(11) NOT NULL,
    KEY           `item_categories_item_id_foreign_idx` (`item_id`),
    KEY           `item_categories_category_id_foreign_idx` (`category_id`),
    CONSTRAINT `item_categories_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
    CONSTRAINT `item_categories_item_id_foreign` FOREIGN KEY (`item_id`) REFERENCES `items` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- item_options table
CREATE TABLE `item_options`
(
    `id`          int(11) unsigned NOT NULL AUTO_INCREMENT,
    `item_id`     bigint(20) unsigned NOT NULL,
    `name`        varchar(100) NOT NULL,
    `type`        varchar(15)  NOT NULL,
    `payloads`    text         NOT NULL,
    `is_required` tinyint(1) NOT NULL DEFAULT '0',
    `created_at`  timestamp    NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `updated_at`  timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    KEY           `item_options_name_index` (`name`),
    KEY           `item_options_type_index` (`type`),
    KEY           `item_options_item_id_foreign_idx` (`item_id`),
    CONSTRAINT `item_options_item_id_foreign` FOREIGN KEY (`item_id`) REFERENCES `items` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- item_tags table
CREATE TABLE `item_tags`
(
    `item_id`    bigint(20) unsigned NOT NULL,
    `tag_id`     bigint(20) NOT NULL,
    KEY          `item_tags_item_id_foreign_idx` (`item_id`),
    KEY          `item_tags_tag_id_foreign_idx` (`tag_id`),
    CONSTRAINT `item_tags_id_foreign` FOREIGN KEY (`tag_id`) REFERENCES `tags` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
    CONSTRAINT `item_tags_item_id_foreign` FOREIGN KEY (`item_id`) REFERENCES `items` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- reviews table
CREATE TABLE `reviews`
(
    `id`          bigint(20) unsigned NOT NULL AUTO_INCREMENT,
    `comments`    text,
    `rating`      tinyint(1) DEFAULT NULL,
    `reviewed_by` varchar(50)            DEFAULT NULL,
    `user_id`     bigint(20) DEFAULT NULL,
    `item_id`     bigint(20) unsigned NOT NULL,
    `review_time` decimal(5, 3) NOT NULL,
    `is_public`   tinyint(1) NOT NULL DEFAULT '0',
    `status`      varchar(10)   NOT NULL DEFAULT 'Inactive',
    `attachment`  varchar(255)           DEFAULT NULL,
    `created_at`  timestamp     NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    KEY           `reviews_status_index` (`status`),
    KEY           `reviews_item_id_foreign_idx` (`item_id`),
    KEY           `reviews_user_id_foreign_idx` (`user_id`),
    CONSTRAINT `reviews_item_id_foreign` FOREIGN KEY (`item_id`) REFERENCES `items` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
    CONSTRAINT `reviews_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- wishlist table
CREATE TABLE `wishlists`
(
    `id`            int(11) unsigned NOT NULL AUTO_INCREMENT,
    `item_id`       bigint(20) unsigned NOT NULL,
    `user_id`       bigint(20) NOT NULL,
    `ip_address`    varchar(16) NOT NULL,
    `browser_agent` varchar(12)          DEFAULT NULL,
    `created_at`    timestamp   NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    KEY             `wishlist_ip_address_index` (`ip_address`),
    KEY             `wishlist_browser_agent_index` (`browser_agent`),
    KEY             `wishlis_item_id_foreign_idx` (`item_id`),
    KEY             `wishlist_user_id_foreign_idx` (`user_id`),
    CONSTRAINT `wishlis_item_id_foreign` FOREIGN KEY (`item_id`) REFERENCES `items` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
    CONSTRAINT `wishlist_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- locations table
CREATE TABLE `locations`
(
    `id`               int(11) unsigned NOT NULL AUTO_INCREMENT,
    `code`             varchar(10)  NOT NULL,
    `name`             varchar(60)  NOT NULL,
    `delivery_address` varchar(100) NOT NULL,
    `email`            varchar(25)           DEFAULT NULL,
    `phone`            varchar
        (18)           DEFAULT NULL,
    `fax`              varchar(25)           DEFAULT NULL,
    `contact`          varchar(60)           DEFAULT NULL,
    `is_active`        tinyint(1) NOT NULL DEFAULT '0',
    `is_default`       tinyint(1) NOT NULL DEFAULT '0',
    `created_at`       timestamp    NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `updated_at`       timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    UNIQUE KEY `locations_code_unique` (`code`),
    KEY                `locations_name_index` (`name`),
    KEY                `locations_email_index` (`email`),
    KEY                `locations_phone_index` (`phone`),
    KEY                `locations_code_index` (`code`),
    KEY                `locations_is_active_index` (`is_active`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- stock_management_details table
CREATE TABLE `stock_management_details`
(
    `id`                  bigint(20) unsigned NOT NULL AUTO_INCREMENT,
    `stock_management_id` bigint(20) unsigned NOT NULL,
    `item_id`             bigint(20) unsigned NOT NULL,
    `description`         text,
    `quantity`            decimal(16, 8) NOT NULL,
    PRIMARY KEY (`id`),
    KEY                   `stock_management_details_quantity_index` (`quantity`),
    KEY                   `stock_management_details_stock_management_id_foreign_idx` (`stock_management_id`),
    KEY                   `stock_management_details_item_id_foreign_idx` (`item_id`),
    CONSTRAINT `stock_management_details_item_id_foreign` FOREIGN KEY (`item_id`) REFERENCES `items` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
    CONSTRAINT `stock_management_details_stock_management_id_foreign` FOREIGN KEY (`stock_management_id`) REFERENCES `stock_managements` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- stock_managements table
CREATE TABLE `stock_managements`
(
    `id`               bigint(20) unsigned NOT NULL AUTO_INCREMENT,
    `vendor_id`        bigint(20) DEFAULT NULL,
    `user_id`          bigint(20) NOT NULL,
    `location_id`      int(11) unsigned NOT NULL,
    `transaction_type` varchar(12)             DEFAULT NULL,
    `total_quantity`   decimal(16, 8) NOT NULL,
    `note`             text,
    `created_at`       timestamp      NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    KEY                `stock_managements_transaction_type_index` (`transaction_type`),
    KEY                `stock_managements_total_quantity_index` (`total_quantity`),
    KEY                `stock_managements_user_id_foreign_idx` (`user_id`),
    KEY                `stock_managements_location_id_foreign_idx` (`location_id`),
    KEY                `stock_managements_vendor_id_foreign_idx` (`vendor_id`),
    CONSTRAINT `stock_managements_location_id_foreign` FOREIGN KEY (`location_id`) REFERENCES `locations` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
    CONSTRAINT `stock_managements_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
    CONSTRAINT `stock_managements_vendor_id_foreign` FOREIGN KEY (`vendor_id`) REFERENCES `vendors` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- currency_converter_configurations
CREATE TABLE `currency_converter_configurations`
(
    `id`      int(10) unsigned NOT NULL AUTO_INCREMENT,
    `slug`    varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
    `api_key` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
    `status`  varchar(10) COLLATE utf8mb4_unicode_ci  NOT NULL,
    PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


-- trigger on after delete item tag
CREATE TRIGGER `item_tags_ADEL` AFTER DELETE ON `item_tags`
 FOR EACH ROW UPDATE tags SET item_counts = (select count(item_id) from item_tags WHERE tag_id = tags.id) WHERE tags.id = OLD.tag_id

-- trigger on after insert item tag
CREATE TRIGGER `item_tags_AINS` AFTER INSERT ON `item_tags`
 FOR EACH ROW UPDATE tags SET item_counts = (select count(item_id) from item_tags WHERE tag_id = tags.id) WHERE tags.id = NEW.tag_id

-- trigger on after delete item category
CREATE TRIGGER `item_categories_ADEL` AFTER DELETE ON `item_categories`
 FOR EACH ROW UPDATE categories SET item_counts = (select count(item_id) from item_categories WHERE category_id = categories.id) WHERE categories.id = OLD.category_id

-- trigger on after insert item category
CREATE TRIGGER `item_categories_AINS` AFTER INSERT ON `item_categories`
 FOR EACH ROW UPDATE categories SET item_counts = (select count(item_id) from item_categories WHERE category_id = categories.id) WHERE categories.id = NEW.category_id

-- database schema for create table subscription_quotes
CREATE TABLE `subscription_quotes` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `quote_date` date DEFAULT NULL,
  `due_date` date DEFAULT NULL,
  `object_type` varchar(45) DEFAULT NULL,
  `object_id` bigint(20) DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL,
  `billing_name` varchar(100) DEFAULT NULL,
  `billing_email` varchar(100) DEFAULT NULL,
  `billing_address` varchar(100) DEFAULT NULL,
  `billing_address_2` varchar(100) DEFAULT NULL,
  `billing_city` varchar(100) DEFAULT NULL,
  `billing_zip` varchar(45) DEFAULT NULL,
  `billing_state` varchar(100) DEFAULT NULL,
  `billing_country` varchar(45) DEFAULT NULL,
  `billing_phone` varchar(45) DEFAULT NULL,
  `amount` decimal(16,8) DEFAULT NULL,
  `currency` varchar(45) NOT NULL DEFAULT 'USD',
  `vendor_id` bigint(11) DEFAULT NULL,
  `user_id` bigint(20) DEFAULT NULL,
  `notes` text,
  `is_resolved` int(1) DEFAULT '0',
  `created_at` timestamp    NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `subscription_quotes_quote_date_index` (`quote_date`),
  KEY `subscription_quotes_object_type_index` (`object_type`),
  KEY `subscription_quotes_object_id_index` (`object_id`),
  KEY `subscription_quotes_is_resolved_index` (`is_resolved`),
  KEY `subscription_quotes_vendor_id_index` (`vendor_id`),
  KEY `subscription_quotes_user_id_index` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- database schema for create table subscription_invoices
CREATE TABLE `subscription_invoices` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `invoice_date` date DEFAULT NULL,
  `due_date` date DEFAULT NULL,
  `object_type` varchar(45) DEFAULT NULL,
  `object_id` bigint(20) DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL,
  `transcation_reference` varchar(100) DEFAULT NULL,
  `billing_name` varchar(100) DEFAULT NULL,
  `billing_email` varchar(100) DEFAULT NULL,
  `billing_address` varchar(100) DEFAULT NULL,
  `billing_address_2` varchar(100) DEFAULT NULL,
  `billing_city` varchar(100) DEFAULT NULL,
  `billing_zip` varchar(45) DEFAULT NULL,
  `billing_state` varchar(100) DEFAULT NULL,
  `billing_country` varchar(45) DEFAULT NULL,
  `billing_phone` varchar(45) DEFAULT NULL,
  `billed_amount` decimal(16,8) DEFAULT NULL,
  `received_amount` decimal(16,8) DEFAULT NULL,
  `discount_amount` decimal(16,8) DEFAULT NULL,
  `tax_amount` decimal(16,8) DEFAULT NULL,
  `balance_amount` decimal(16,8) DEFAULT NULL COMMENT 'Balance has to be zero after payment. (Received + discount) - Billied',
  `currency` varchar(45) NOT NULL DEFAULT 'USD',
  `vendor_id` bigint(11) DEFAULT NULL,
  `user_id` bigint(20) DEFAULT NULL,
  `notes` text,
  `is_resolved` int(1) DEFAULT '0',
  `status` varchar(20) DEFAULT 'Draft',
  `charged_customer_name` varchar(100) DEFAULT NULL,
  `charged_amount` decimal(16,8) DEFAULT NULL,
  `charged_billing_method` varchar(20) DEFAULT NULL,
  `charged_email` varchar(100) DEFAULT NULL,
  `charged_card` varchar(40) DEFAULT NULL,
  `charged_at` datetime DEFAULT NULL,
  `created_at` timestamp    NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `subscription_invoices_invoice_date_index` (`invoice_date`),
  KEY `subscription_invoices_object_type_index` (`object_type`),
  KEY `subscription_invoices_object_id_index` (`object_id`),
  KEY `subscription_invoices_status_index` (`status`),
  KEY `subscription_invoices_is_resolved_index` (`is_resolved`),
  KEY `subscription_invoices_vendor_id_index` (`vendor_id`),
  KEY `subscription_invoices_user_id_index` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- database schema for create table subscription_invoice_items
CREATE TABLE `subscription_invoice_items` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `invoice_id` bigint(20) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `period` varchar(255) DEFAULT NULL,
  `object_type` varchar(45) DEFAULT NULL,
  `object_id` bigint(20) DEFAULT NULL,
  `price` decimal(18,8) DEFAULT NULL,
  `quantity` tinyint(4) DEFAULT NULL,
  `amount` decimal(16,8) DEFAULT NULL,
  `discount` decimal(16,8) DEFAULT NULL,
  `tax_amount` decimal(16,8) DEFAULT NULL,
  `total` decimal(16,8) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `subscription_invoice_items_object_type_index` (`object_type`),
  KEY `subscription_invoice_items_object_id_index` (`object_id`),
  KEY `subscription_invoice_items_invoice_id_index` (`invoice_id`),
  CONSTRAINT `subscription_invoice_items_invoice_id_foreign` FOREIGN KEY (`invoice_id`) REFERENCES `subscription_invoices` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- database schema for create table payment_terms
DROP TABLE IF EXISTS `payment_terms`;
CREATE TABLE IF NOT EXISTS `payment_terms` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `days_before_due` smallint(6) NOT NULL,
  `is_default` tinyint(4) NOT NULL DEFAULT '0' COMMENT '1 for default;0 for otherwise;',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `payment_terms_name_index` (`name`),
  KEY `payment_terms_days_before_due_index` (`days_before_due`),
  KEY `payment_terms_is_default_index` (`is_default`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;



ALTER TABLE `permissions` ADD `controller_path` VARCHAR(250) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL AFTER `name`;

ALTER TABLE `permissions` CHANGE `controller_path` `controller_path` TEXT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL;

ALTER TABLE `permissions` CHANGE `name` `name` VARCHAR(250) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL;


ALTER TABLE `permissions`
  DROP `description`;


  ALTER TABLE `permission_roles` CHANGE `pernission_id` `permission_id` BIGINT(20) NOT NULL;

-- database schema for create table vendors
CREATE TABLE `vendors`
(
    `id`          bigint(20) NOT NULL AUTO_INCREMENT,
    `name`        varchar(100) NOT NULL,
    `email`       varchar(100)          DEFAULT NULL,
    `phone`       varchar(45) NOT NULL,
    `formal_name` varchar(100)          DEFAULT NULL,
    `alias`       varchar(50)  NOT NULL,
    `status`      varchar(15)  NOT NULL DEFAULT 'Pending',
    `website`     varchar(255)          DEFAULT NULL,
    `created_at`  timestamp    NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `updated_at`  timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    KEY           `vendors_name_index` (`name`),
    KEY           `vendors_formal_name` (`formal_name`),
    KEY           `vendors_alias_index` (`alias`),
    KEY           `vendors_status_index` (`status`),
    KEY           `vendors_email_index` (`email`)
    KEY           `vendors_phone_index` (`phone`),
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
-- --------------------------------------------------------

--
-- Table structure for table `item_attributes`
--

DROP TABLE IF EXISTS `item_attributes`;
CREATE TABLE IF NOT EXISTS `item_attributes` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `item_id` bigint(20) UNSIGNED NOT NULL,
  `attribute_id` bigint(20) UNSIGNED NOT NULL,
  `payloads` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `item_attributes_item_id_foreign_idx` (`item_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--------------------------------------------------------

--
-- Table structure for table `translations`
--

DROP TABLE IF EXISTS `translations`;
CREATE TABLE IF NOT EXISTS `translations` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `locale` varchar(32) NOT NULL
  `field_name` varchar(255) NOT NULL
  `value` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Constraints for dumped tables
--


-- --------------------------------------------------------

--
-- Table structure for table `item_cross_sales`
--

DROP TABLE IF EXISTS `item_cross_sales`;
CREATE TABLE IF NOT EXISTS `item_cross_sales` (
  `item_id` bigint(20) UNSIGNED NOT NULL,
  `cross_sale_item_id` int(11) NOT NULL,
  KEY `item_cross_sales_item_id_idx` (`item_id`),
  KEY `item_cross_sales_cross_sale_item_id_foreign_idx` (`cross_sale_item_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
COMMIT;


ALTER TABLE `item_cross_sales` ADD CONSTRAINT `item_cross_sales` FOREIGN KEY (`item_id`) REFERENCES `items`(`id`) ON DELETE CASCADE ON UPDATE CASCADE;


-- --------------------------------------------------------

--
-- Table structure for table `item_relates`
--

DROP TABLE IF EXISTS `item_relates`;
CREATE TABLE IF NOT EXISTS `item_relates` (
  `item_id` bigint(20) UNSIGNED NOT NULL,
  `related_item_id` int(11) NOT NULL,
  KEY `item_relates_related_item_id_foreign_idx` (`related_item_id`),
  KEY `item_relates_item_id_idx` (`item_id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
COMMIT;


ALTER TABLE `item_relates` ADD CONSTRAINT `item_relates` FOREIGN KEY (`item_id`) REFERENCES `items`(`id`) ON DELETE CASCADE ON UPDATE CASCADE;


-- --------------------------------------------------------

--
-- Table structure for table `item_upsales`
--

DROP TABLE IF EXISTS `item_upsales`;
CREATE TABLE IF NOT EXISTS `item_upsales` (
  `item_id` bigint(20) UNSIGNED NOT NULL,
  `upsale_item_id` int(11) NOT NULL,
  KEY `item_upsales_item_id_idx` (`item_id`) USING BTREE,
  KEY `item_upsales_upsale_item_id_foreign_idx` (`upsale_item_id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
COMMIT;

ALTER TABLE `item_upsales` ADD CONSTRAINT `item_upsales` FOREIGN KEY (`item_id`) REFERENCES `items`(`id`) ON DELETE CASCADE ON UPDATE CASCADE;




ALTER TABLE `items` DROP `attribute_ids_with_values`, DROP `option_ids_with_names`, DROP `related_product_ids`, DROP `upsale_sale_item_ids`, DROP `cross_sale_item_ids`;
ALTER TABLE `items` DROP `seo_meta_title`, DROP `seo_meta_description`;



ALTER TABLE `items` ADD `video_url` VARCHAR(255) NULL DEFAULT NULL AFTER `summary`;

-- database schema for create table taxes
CREATE TABLE `taxes`
(
    `id`         int(10) unsigned NOT NULL AUTO_INCREMENT,
    `name`       varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
    `tax_rate`   decimal(12, 8)                         NOT NULL,
    `is_default` tinyint(1) NOT NULL DEFAULT '0' COMMENT '1 for defaults;\\n0 for otherwise',
    PRIMARY KEY (`id`),
    KEY          `taxes_name_index` (`name`),
    KEY          `taxes_tax_rate_index` (`tax_rate`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci

-- --------------------------------------------------------

--
-- Table structure for table `shops`
--

DROP TABLE IF EXISTS `shops`;
CREATE TABLE IF NOT EXISTS `shops` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `vendor_id` bigint(20) NOT NULL,
  `name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `website` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `fax` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` varchar(1000) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Active' COMMENT 'Active/Inactive;',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `shops_vendor_id_foreign_idx` (`vendor_id`),
  KEY `shops_name_index` (`name`),
  KEY `shops_email_index` (`email`),
  KEY `shops_phone_index` (`phone`),
  KEY `shops_status_index` (`status`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

ALTER TABLE `shops`
  ADD CONSTRAINT `shops_vendor_id_foreign` FOREIGN KEY (`vendor_id`) REFERENCES `vendors` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--change attribute value
ALTER TABLE `attribute_values`
    ADD UNIQUE INDEX `attribute_values_composit_unique` (`attribute_id` ASC, `value` ASC);

-- change item table
ALTER TABLE `items`
    CHANGE COLUMN `availablity_from` `availablity_from` DATE NULL DEFAULT NULL ,
    CHANGE COLUMN `availablity_to` `availablity_to` DATE NULL DEFAULT NULL ,
    CHANGE COLUMN `discount_from` `discount_from` DATE NULL DEFAULT NULL ,
    CHANGE COLUMN `discount_to` `discount_to` DATE NULL DEFAULT NULL ;

ALTER TABLE `items`
    CHANGE COLUMN `maximum_discount_amount` `maximum_discount_amount` DECIMAL(16,8) NULL ,
    CHANGE COLUMN `minimum_order_for_discount` `minimum_order_for_discount` VARCHAR(45) NULL ,
    CHANGE COLUMN `sku` `sku` VARCHAR(45) NULL ,
    CHANGE COLUMN `item_quantity` `item_quantity` DECIMAL(16,8) NULL ,
    CHANGE COLUMN `stock_availability` `stock_availability` DECIMAL(16,8) NULL ;

ALTER TABLE `items`
    CHANGE COLUMN `availablity_from` `available_from` DATE NULL DEFAULT NULL ,
    CHANGE COLUMN `availablity_to` `available_to` DATE NULL DEFAULT NULL ;

--item attributes changes issue
ALTER TABLE `item_attributes`
    ADD COLUMN `order_by` INT(8) NOT NULL AFTER `attribute_id`,
CHANGE COLUMN `id` `id` BIGINT(20) UNSIGNED NOT NULL ,
CHANGE COLUMN `attribute_id` `attribute_id` BIGINT(20) NOT NULL ,
ADD INDEX `item_attributes_attribute_id_idx` (`attribute_id` ASC);

ALTER TABLE `item_attributes`
    ADD CONSTRAINT `item_attributes_item_id`
        FOREIGN KEY (`item_id`)
            REFERENCES `items` (`id`)
            ON DELETE CASCADE
            ON UPDATE CASCADE,
ADD CONSTRAINT `item_attributes_attribute_id`
  FOREIGN KEY (`attribute_id`)
  REFERENCES `attributes` (`id`)
  ON DELETE CASCADE
  ON UPDATE CASCADE;

ALTER TABLE `item_attributes`
    CHANGE COLUMN `id` `id` BIGINT(20) UNSIGNED NOT NULL AUTO_INCREMENT ;

ALTER TABLE `item_attributes`
DROP COLUMN `order_by`;

-- item option
ALTER TABLE `item_options`
    ADD COLUMN `order_by` INT(8) NOT NULL AFTER `type`;



-- database schema for create table payment_methods
DROP TABLE IF EXISTS `payment_methods`;
CREATE TABLE IF NOT EXISTS `payment_methods` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL,
  `mode` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `client_id` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `consumer_key` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `consumer_secret` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `approve` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_default` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0 for not default;\r\n1 for default',
  `is_active` tinyint(1) NOT NULL COMMENT '0 for inactive;\\n1 for active',
  PRIMARY KEY (`id`),
  KEY `payment_methods_name_index` (`name`),
  KEY `payment_methods_is_default_index` (`is_default`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `payment_methods`
--

INSERT INTO `payment_methods` (`id`, `name`, `mode`, `client_id`, `consumer_key`, `consumer_secret`, `approve`, `is_default`, `is_active`) VALUES
(1, 'Paypal', 'sandbox', 'AavnhZLU2Z3AKlVkdDCftpvOAWaH8acCzsBciHQz0Cif1aE-K0-BTmcean862hlYlnSeGwRvV6Dnjr6N', NULL, 'EC5gE_BS6oHlQUvCM9HW_KPPT8CW2tSsf4VbWj7hdKcGISfu2teTH3OmNpyoRslFUplOnDGwNKUQI7DA', NULL, 1, 1),
(2, 'Bank', NULL, '1', NULL, NULL, 'automatic', 0, 1),
(3, 'Stripe', NULL, NULL, 'pk_test_F6LAUawJNJFrdtKWPOcV60VV00NGAE6hgK', 'sk_test_oJJYy5TYtZNxr4erRlxIUE0K00vMlXcl4E', NULL, 0, 1);

--attributes table changes issue
ALTER TABLE `attributes`
    ADD COLUMN `is_required` TINYINT(1) NOT NULL DEFAULT '0' AFTER `is_filterable`;

--items changes
ALTER TABLE `items`
    CHANGE COLUMN `price` `price` DECIMAL(16,8) NULL ;

--item brand id nullable
ALTER TABLE `items`
DROP FOREIGN KEY `items_brand_id_foreign`;
ALTER TABLE `items`
    CHANGE COLUMN `brand_id` `brand_id` INT(11) UNSIGNED NULL ;
ALTER TABLE `items`
    ADD CONSTRAINT `items_brand_id_foreign`
        FOREIGN KEY (`brand_id`)
            REFERENCES `laravel`.`brands` (`id`)
            ON DELETE CASCADE
            ON UPDATE CASCADE;

-- attribute table add column
ALTER TABLE `attributes`
    ADD COLUMN `description` TEXT NULL AFTER `name`;

-- add column in users table
ALTER TABLE `users`
    ADD COLUMN `sso_service` VARCHAR(45) NULL AFTER `password`,
ADD COLUMN `sso_account_id` VARCHAR(191) NULL AFTER `sso_service`;


-- preference new data
INSERT INTO `preferences` (`id`, `category`, `field`, `value`) VALUES ('55', 'preference', 'sso_service', '["Google"]');

-- reviews table changes issue
ALTER TABLE `reviews`
DROP COLUMN `attachment`,
DROP COLUMN `review_time`;

-- category changes issue
ALTER TABLE `categories`
    ADD COLUMN `is_featured` TINYINT(1) NOT NULL DEFAULT 0 AFTER `is_searchable`,
ADD INDEX `categories_is_featureable_index` (`is_featureable` ASC);
;


---create table orders
CREATE TABLE `orders` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `transaction_type` varchar(15) NOT NULL,
  `invoice_type` varchar(15) NOT NULL,
  `order_type` varchar(15) NOT NULL,
  `user_id` bigint(20) NOT NULL,
  `address_id` int(10) unsigned NOT NULL,
  `tax_type` varchar(15) NOT NULL,
  `reference` varchar(45) NOT NULL,
  `order_reference_id` bigint(20) unsigned DEFAULT NULL,
  `note` text,
  `order_date` date NOT NULL,
  `due_date` date DEFAULT NULL,
  `payment_method_id` int(10) unsigned DEFAULT NULL,
  `discount_on` varchar(15) NOT NULL,
  `currency_id` int(10) unsigned NOT NULL,
  `exchange_rate` decimal(16,8) NOT NULL,
  `has_tax` tinyint(1) NOT NULL DEFAULT '0',
  `has_description` tinyint(1) NOT NULL DEFAULT '0',
  `has_item_discount` tinyint(1) NOT NULL DEFAULT '0',
  `has_hsn` tinyint(1) NOT NULL DEFAULT '0',
  `has_other_discount` tinyint(1) NOT NULL DEFAULT '0',
  `has_shipping_charge` tinyint(1) NOT NULL DEFAULT '0',
  `leave_door` tinyint(1) DEFAULT NULL,
  `has_custom_charge` varchar(45) NOT NULL DEFAULT '0',
  `other_discount_amount` decimal(16,8) DEFAULT '0.00000000',
  `other_discount_type` varchar(45) DEFAULT NULL,
  `shipping_charge` decimal(16,8) DEFAULT NULL,
  `custom_charge_title` varchar(200) DEFAULT NULL,
  `custom_charge_amount` decimal(16,8) NULL,
  `total` decimal(16,8) NOT NULL,
  `paid` decimal(16,8) NOT NULL,
  `amount_received` decimal(16,8) DEFAULT NULL,
  `payment_term_id` int(10) unsigned DEFAULT NULL,
  `status` varchar(12) NOT NULL DEFAULT 'Pending',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `orders_user_id_foreign_idx` (`user_id`),
  KEY `orders_payment_method_id_foreign_idx` (`payment_method_id`),
  KEY `orders_currency_id_foreign_idx` (`currency_id`),
  KEY `orders_payment_term_id_foreign_idx` (`payment_term_id`),
  KEY `orders_transaction_type_index` (`transaction_type`),
  KEY `orders_order_type_index` (`order_type`),
  KEY `orders_tax_type_index` (`tax_type`),
  KEY `orders_reference_index` (`reference`),
  KEY `orders_order_reference_id_index` (`order_reference_id`),
  KEY `orders_order_date_index` (`order_date`),
  KEY `orders_due_date_index` (`due_date`),
  KEY `orders_total_index` (`total`),
  KEY `orders_paid_index` (`paid`),
  KEY `orders_amount_received_index` (`amount_received`),
  KEY `orders_exchange_rate_index` (`exchange_rate`),
  KEY `orders_status_index` (`status`),
  KEY `orders_address_id_foreign_idx` (`address_id`),
  CONSTRAINT `orders_address_id_foreign` FOREIGN KEY (`address_id`) REFERENCES `addresses` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `orders_currency_id_foreign` FOREIGN KEY (`currency_id`) REFERENCES `currencies` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `orders_payment_method_id_foreign` FOREIGN KEY (`payment_method_id`) REFERENCES `payment_methods` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `orders_payment_term_id_foreign` FOREIGN KEY (`payment_term_id`) REFERENCES `payment_terms` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `orders_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


-- create table order_details
CREATE TABLE `order_details` (
 `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
 `item_id` bigint(20) unsigned NOT NULL,
 `order_id` bigint(20) unsigned NOT NULL,
 `vendor_id` bigint(20) DEFAULT NULL,
 `shop_id` bigint(20) DEFAULT NULL,
 `description` text,
 `item_name` varchar(255) NOT NULL,
 `price` decimal(16,8) NOT NULL,
 `quantity_sent` decimal(16,8) NOT NULL,
 `quantity` decimal(16,8) NOT NULL,
 `discount_amount` decimal(16,8) unsigned DEFAULT NULL,
 `discount_type` varchar(12) DEFAULT NULL,
 `hsn` varchar(255) DEFAULT NULL,
 `payloads` text,
 `order_by` int(3) NOT NULL,
 `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
 `updated_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
 PRIMARY KEY (`id`),
 KEY `order_details_item_id_foreign_idx` (`item_id`),
 KEY `order_details_item_name_index` (`item_name`),
 KEY `order_details_price_index` (`price`),
 KEY `order_details_quantity_sent_index` (`quantity_sent`),
 KEY `order_details_quantity_index` (`quantity`),
 KEY `order_details_discount_amount_index` (`discount_amount`),
 KEY `order_details_discount_index` (`discount`),
 KEY `order_details_discount_type_index` (`discount_type`),
 KEY `order_details_hsn_index` (`hsn`),
 KEY `order_details_order_by_index` (`order_by`),
 KEY `order_details_vendor_id_foreign_idx` (`vendor_id`),
 KEY `order_details_shop_id_foreign_idx` (`shop_id`),
 KEY `order_details_order_id_foreign_idx` (`order_id`),
 CONSTRAINT `order_details_item_id_foreign` FOREIGN KEY (`item_id`) REFERENCES `items` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
 CONSTRAINT `order_details_order_id_foreign` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
 CONSTRAINT `order_details_shop_id_foreign` FOREIGN KEY (`shop_id`) REFERENCES `shops` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
 CONSTRAINT `order_details_vendor_id_foreign` FOREIGN KEY (`vendor_id`) REFERENCES `vendors` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--create table transaction_references
CREATE TABLE `transaction_references` (
`id` BIGINT(20) UNSIGNED NOT NULL AUTO_INCREMENT,
`object_id` INT(10) NULL,
`reference_type` VARCHAR(50) NOT NULL,
`code` VARCHAR(100) NOT NULL,
PRIMARY KEY (`id`),
INDEX `transaction_references_reference_type_index` (`reference_type` ASC),
INDEX `transaction_references_object_id_index` (`object_id` ASC))
    ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8mb4;

--create table transactions
CREATE TABLE `transactions` (
    `id` BIGINT(20) UNSIGNED NOT NULL AUTO_INCREMENT,
    `currency_id` INT(10) UNSIGNED NOT NULL,
    `amount` DECIMAL(16,8) NOT NULL,
    `transaction_type` VARCHAR(100) NOT NULL,
    `account_id` BIGINT(20) NULL,
    `transaction_date` DATE NOT NULL,
    `user_id` BIGINT(20) NULL,
    `transaction_reference_id` BIGINT(20) UNSIGNED NOT NULL,
    `transaction_method` VARCHAR(50) NOT NULL,
    `description` TEXT NULL,
    `payment_method_id` INT(10) UNSIGNED NOT NULL,
    `params` TEXT NULL,
    `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    INDEX `transactions_currency_id_foreign_idx` (`currency_id` ASC),
    INDEX `transactions_user_id_foreign_idx` (`user_id` ASC),
    INDEX `transactions_transaction_reference_id_foreign_idx` (`transaction_reference_id` ASC),
    INDEX `transactions_payment_method_id_foreign_idx` (`payment_method_id` ASC),
    INDEX `transactions_amount_index` (`amount` ASC),
    INDEX `transactions_transaction_type_index` (`transaction_type` ASC),
    INDEX `transactions_transaction_date_index` (`transaction_date` ASC),
    INDEX `transactions_transaction_method_index` (`transaction_method` ASC),
    CONSTRAINT `transactions_currency_id_foreign`
        FOREIGN KEY (`currency_id`)
            REFERENCES `currencies` (`id`)
            ON DELETE CASCADE
            ON UPDATE CASCADE,
    CONSTRAINT `transactions_user_id_foreign`
        FOREIGN KEY (`user_id`)
            REFERENCES `users` (`id`)
            ON DELETE CASCADE
            ON UPDATE CASCADE,
    CONSTRAINT `transactions_transaction_reference_id_foreign`
        FOREIGN KEY (`transaction_reference_id`)
            REFERENCES `transaction_references` (`id`)
            ON DELETE CASCADE
            ON UPDATE CASCADE,
    CONSTRAINT `transactions_payment_method_id_foreign`
        FOREIGN KEY (`payment_method_id`)
            REFERENCES `payment_methods` (`id`)
            ON DELETE CASCADE
            ON UPDATE CASCADE)
    ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8mb4;

--create table item_details
CREATE TABLE `item_details` (
    `id` BIGINT(20) UNSIGNED NOT NULL AUTO_INCREMENT,
    `item_id` BIGINT(20) UNSIGNED NULL,
    `warranty_type` VARCHAR(25) NOT NULL,
    `warranty_period` VARCHAR(12) NULL,
    `warranty_policy` TEXT NULL,
    `is_free_shipping` TINYINT(1) NULL DEFAULT 0,
    `is_flat_rate` TINYINT(1) NULL DEFAULT 0,
    `is_show_stock_quantity` TINYINT(1) NULL DEFAULT 0,
    `is_hide_stock` TINYINT(1) NULL DEFAULT 0,
    `is_featured` TINYINT(1) NULL DEFAULT 0,
    `is_cash_on_delivery` TINYINT(1) NULL DEFAULT 0,
    PRIMARY KEY (`id`),
    INDEX `item_details_item_id_foeign_idx` (`item_id` ASC),
    INDEX `item_details_warranty_type_index` (`warranty_type` ASC),
    INDEX `item_details_warranty_period_index` (`warranty_period` ASC),
    INDEX `item_details_is_free_shipping_index` (`is_free_shipping` ASC),
    INDEX `item_details_is_featured_index` (`is_featured` ASC),
    INDEX `item_details_is_cash_on_delivery_index` (`is_cash_on_delivery` ASC),
    CONSTRAINT `item_details_item_id_foeign`
        FOREIGN KEY (`item_id`)
            REFERENCES `items` (`id`)
            ON DELETE CASCADE
            ON UPDATE CASCADE)
    ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8mb4;

--order status table
CREATE TABLE `status_orders` (
 `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
 `name` varchar(15) COLLATE utf8_unicode_ci NOT NULL,
 `is_default` tinyint(1) NOT NULL DEFAULT '0',
 `order_by` int(2) NULL,
 `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
 `updated_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
 PRIMARY KEY (`id`),
 KEY `status_orders_name_index` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--add order_status_id in order table
ALTER TABLE `orders`
DROP FOREIGN KEY `orders_status_order_id_foreign`;
ALTER TABLE `orders`
DROP COLUMN `status_order_id`,
ADD COLUMN `order_status_id` INT(10) UNSIGNED NULL AFTER `coupon_code`,
ADD INDEX `orders_order_status_id_foreign_idx` (`order_status_id` ASC),
DROP INDEX `orders_status_index` ;
;
ALTER TABLE `orders`
    ADD CONSTRAINT `orders_order_status_id_foreign`
        FOREIGN KEY (`order_status_id`)
            REFERENCES `order_statuses` (`id`)
            ON DELETE CASCADE
            ON UPDATE CASCADE;

--create order_status_roles table
CREATE TABLE `order_status_roles` (
   `order_status_id` INT(10) UNSIGNED NOT NULL,
   `role_id` INT(11) NOT NULL,
   INDEX `order_status_roles_role_id_foreign_idx` (`role_id` ASC),
   INDEX `order_status_roles_order_status_id_foreign_idx` (`order_status_id` ASC),
   CONSTRAINT `order_status_roles_order_status_id_foreign`
       FOREIGN KEY (`order_status_id`)
           REFERENCES `order_statuses` (`id`)
           ON DELETE CASCADE
           ON UPDATE CASCADE,
   CONSTRAINT `order_status_roles_role_id_foreign`
       FOREIGN KEY (`role_id`)
           REFERENCES `roles` (`id`)
           ON DELETE CASCADE
           ON UPDATE CASCADE)
    ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8mb4
COLLATE = utf8mb4_unicode_ci;

--create order_status_histories table
CREATE TABLE `order_status_histories` (
`id` BIGINT(20) UNSIGNED NOT NULL AUTO_INCREMENT,
`item_id` BIGINT(20) UNSIGNED NOT NULL,
`order_id` BIGINT(20) UNSIGNED NOT NULL,
`user_id` BIGINT(20) NOT NULL,
`order_status_id` INT(10) UNSIGNED NOT NULL,
`created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
`updated_at` TIMESTAMP NULL ON UPDATE CURRENT_TIMESTAMP,
PRIMARY KEY (`id`),
INDEX `order_status_histories_item_id_foreign_idx` (`item_id` ASC),
INDEX `order_status_histories_order_id_foreign_idx` (`order_id` ASC),
INDEX `order_status_histories_user_id_foreign_idx` (`user_id` ASC),
INDEX `order_status_histories_order_status_id_foreign_idx` (`order_status_id` ASC),
CONSTRAINT `order_status_histories_order_id_foreign`
   FOREIGN KEY (`order_id`)
       REFERENCES `orders` (`id`)
       ON DELETE CASCADE
       ON UPDATE CASCADE,
CONSTRAINT `order_status_histories_user_id_foreign`
   FOREIGN KEY (`user_id`)
       REFERENCES `users` (`id`)
       ON DELETE CASCADE
       ON UPDATE CASCADE,
CONSTRAINT `order_status_histories_order_status_id_foreign`
   FOREIGN KEY (`order_status_id`)
       REFERENCES `order_statuses` (`id`)
       ON DELETE CASCADE
       ON UPDATE CASCADE,
CONSTRAINT `order_status_histories_item_id_foreign`
    FOREIGN KEY (`item_id`)
        REFERENCES `items` (`id`)
        ON DELETE CASCADE
        ON UPDATE CASCADE)
    ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8mb4
COLLATE = utf8mb4_unicode_ci;

--add order_status_id in order_details table
ALTER TABLE `order_details`
    ADD COLUMN `order_status_id` INT(10) UNSIGNED NULL AFTER `order_by`,
ADD INDEX `order_details_order_status_id_foreign_idx` (`order_status_id` ASC);
;
ALTER TABLE `order_details`
    ADD CONSTRAINT `order_details_order_status_id_foreign`
        FOREIGN KEY (`order_status_id`)
            REFERENCES `order_statuses` (`id`)
            ON DELETE CASCADE
            ON UPDATE CASCADE;

--add shipping_id in order details table
ALTER TABLE `order_details`
    ADD COLUMN `shipping_id` BIGINT(20) UNSIGNED NULL AFTER `order_status_id`,
ADD INDEX `order_details_shipping_id_foreign_idx` (`shipping_id` ASC);
;
ALTER TABLE `order_details`
    ADD CONSTRAINT `order_details_shipping_id_foreign`
        FOREIGN KEY (`shipping_id`)
            REFERENCES `shippings` (`id`)
            ON DELETE CASCADE
            ON UPDATE CASCADE;

--create inventories table
CREATE TABLE `inventories` (
`id` BIGINT(20) UNSIGNED NOT NULL AUTO_INCREMENT,
`item_option_id` INT(10) UNSIGNED NULL,
`label` VARCHAR(45) NULL,
`vendor_id` BIGINT(20) NULL,
`quantity` DECIMAL(16,8) NOT NULL,
`created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
`updated_at` TIMESTAMP NULL ON UPDATE CURRENT_TIMESTAMP,
PRIMARY KEY (`id`),
INDEX `inventories_label_index` (`label` ASC),
INDEX `inventories_item_option_id_foreign_idx` (`item_option_id` ASC),
INDEX `inventories_vendor_id_foreign_idx` (`vendor_id` ASC),
INDEX `inventories_quantity_index` (`quantity` ASC),
CONSTRAINT `inventories_item_option_id_foreign`
    FOREIGN KEY (`item_option_id`)
        REFERENCES `item_options` (`id`)
        ON DELETE CASCADE
        ON UPDATE CASCADE,
CONSTRAINT `inventories_vendor_id_foreign`
    FOREIGN KEY (`vendor_id`)
        REFERENCES `vendors` (`id`)
        ON DELETE CASCADE
        ON UPDATE CASCADE);

--create table commission
CREATE TABLE `commissions` (
   `id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
   `is_active` TINYINT(1) NULL DEFAULT 0,
   `is_category_based` TINYINT(1) NULL DEFAULT 0,
   `amount` FLOAT(16,8) NULL,
  `created_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`))
    ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8mb4
COLLATE = utf8mb4_unicode_ci;

--create table option_group_categories
CREATE TABLE `category_option_groups` (
`option_group_id` BIGINT(20) NOT NULL,
`category_id` INT(11) NOT NULL,
INDEX `option_group_categories_option_group_id_foreign_idx` (`option_group_id` ASC),
INDEX `option_group_categories_category_id_foreign_idx` (`category_id` ASC),
CONSTRAINT `option_group_categories_option_group_id_foreign`
    FOREIGN KEY (`option_group_id`)
        REFERENCES `option_groups` (`id`)
        ON DELETE CASCADE
        ON UPDATE CASCADE,
CONSTRAINT `option_group_categories_category_id_foreign`
    FOREIGN KEY (`category_id`)
        REFERENCES `categories` (`id`)
        ON DELETE CASCADE
        ON UPDATE CASCADE);

-- create order commission tble
CREATE TABLE `order_commissions` (
  `id` BIGINT(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `order_id` BIGINT(20) UNSIGNED NULL,
  `vendor_id` BIGINT(20) NULL,
  `amount` DECIMAL(16,8) NULL,
  `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  INDEX `order_commissions_order_id_foreign_idx` (`order_id` ASC),
  INDEX `order_commissions_vendor_id_foreign_idx` (`vendor_id` ASC),
  CONSTRAINT `order_commissions_order_id_foreign`
      FOREIGN KEY (`order_id`)
          REFERENCES `orders` (`id`)
          ON DELETE CASCADE
          ON UPDATE CASCADE,
  CONSTRAINT `order_commissions_vendor_id_foreign`
      FOREIGN KEY (`vendor_id`)
          REFERENCES `vendors` (`id`)
          ON DELETE CASCADE
          ON UPDATE CASCADE)
    ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8mb4
COLLATE = utf8mb4_unicode_ci;

--drop category_id in attributes table
ALTER TABLE `attributes`
DROP FOREIGN KEY `attributes_category_id_foreign`;
ALTER TABLE `attributes`
DROP COLUMN `category_id`,
DROP INDEX `attributes_category_id_foreign_idx` ;
;

-- add sell_commission column in vendors table
ALTER TABLE `vendors`
    ADD COLUMN `sell_commissions` DECIMAL(16,8) NULL AFTER `website`,
ADD INDEX `vendors_sell_commissions_index` (`sell_commissions` ASC);
;

--added sell_commissions column in categories table
ALTER TABLE `categories`
    ADD COLUMN `sell_commissions` DECIMAL(16,8) NULL AFTER `item_counts`,
ADD INDEX `categories_sell_commissions_index` (`sell_commissions` ASC);
;

--order commission tble update
ALTER TABLE `order_commissions`
DROP FOREIGN KEY `order_commissions_order_id_foreign`;
ALTER TABLE `order_commissions`
DROP COLUMN `order_id`,
ADD COLUMN `order_details_id` BIGINT(20) UNSIGNED NOT NULL AFTER `id`,
ADD INDEX `order_commissions_order_detail_id_foreign_idx` (`order_details_id` ASC),
DROP INDEX `order_commissions_order_id_foreign_idx` ;
;
ALTER TABLE `order_commissions`
    ADD CONSTRAINT `order_commissions_order_detail_id_foreign`
        FOREIGN KEY (`order_details_id`)
            REFERENCES `order_details` (`id`)
            ON DELETE CASCADE
            ON UPDATE CASCADE;

ALTER TABLE `order_commissions`
    ADD COLUMN `approval_time` DATETIME(5) NULL AFTER `amount`,
ADD COLUMN `status` VARCHAR(12) NULL DEFAULT 'Pending' AFTER `approval_time`,
ADD INDEX `order_commissions_status_index` (`status` ASC),
ADD INDEX `order_commissions_approval_time_index` (`approval_time` ASC);
;

-- drop category_id column from option_groups table
ALTER TABLE `option_groups`
DROP FOREIGN KEY `option_groups_category_id`;
ALTER TABLE `option_groups`
DROP COLUMN `category_id`,
DROP INDEX `option_groups_category_id_idx` ;
;

