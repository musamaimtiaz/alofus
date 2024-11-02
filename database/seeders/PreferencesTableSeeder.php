<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class PreferencesTableSeeder extends Seeder
{
    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {

        \DB::table('preferences')->delete();

        \DB::table('preferences')->insert([
            0 => [
                'id' => 1,
                'category' => 'preference',
                'field' => 'row_per_page',
                'value' => '25',
            ],
            1 => [
                'id' => 2,
                'category' => 'preference',
                'field' => 'date_format',
                'value' => '1',
            ],
            2 => [
                'id' => 3,
                'category' => 'preference',
                'field' => 'date_sepa',
                'value' => '-',
            ],
            3 => [
                'id' => 5,
                'category' => 'company',
                'field' => 'site_short_name',
                'value' => 'MV',
            ],
            4 => [
                'id' => 8,
                'category' => 'preference',
                'field' => 'date_format_type',
                'value' => 'dd-mm-yyyy',
            ],
            5 => [
                'id' => 9,
                'category' => 'company',
                'field' => 'company_name',
                'value' => 'Martvill',
            ],
            6 => [
                'id' => 10,
                'category' => 'company',
                'field' => 'company_email',
                'value' => 'admin@techvill.net',
            ],
            7 => [
                'id' => 11,
                'category' => 'company',
                'field' => 'company_phone',
                'value' => '+12013828901',
            ],
            8 => [
                'id' => 12,
                'category' => 'company',
                'field' => 'company_street',
                'value' => 'City Hall Park Path',
            ],
            9 => [
                'id' => 13,
                'category' => 'company',
                'field' => 'company_city',
                'value' => 'Azimpur',
            ],
            10 => [
                'id' => 14,
                'category' => 'company',
                'field' => 'company_state',
                'value' => '81',
            ],
            11 => [
                'id' => 15,
                'category' => 'company',
                'field' => 'company_zip_code',
                'value' => '1200',
            ],
            12 => [
                'id' => 17,
                'category' => 'company',
                'field' => 'dflt_lang',
                'value' => 'en',
            ],
            13 => [
                'id' => 18,
                'category' => 'company',
                'field' => 'dflt_currency_id',
                'value' => '3',
            ],
            14 => [
                'id' => 21,
                'category' => 'company',
                'field' => 'company_gstin',
                'value' => '11',
            ],
            15 => [
                'id' => 29,
                'category' => 'preference',
                'field' => 'default_timezone',
                'value' => 'Asia/Manila',
            ],
            16 => [
                'id' => 44,
                'category' => 'preference',
                'field' => 'thousand_separator',
                'value' => ',',
            ],
            17 => [
                'id' => 45,
                'category' => 'preference',
                'field' => 'decimal_digits',
                'value' => '2',
            ],
            18 => [
                'id' => 46,
                'category' => 'preference',
                'field' => 'symbol_position',
                'value' => 'before',
            ],
            19 => [
                'id' => 47,
                'category' => 'company',
                'field' => 'company_icon',
                'value' => '4b24511c095a0ce03fdcb53acab1ef2d_25_data_center_icon_191506ico.ico',
            ],
            20 => [
                'id' => 48,
                'category' => 'company',
                'field' => 'company_logo',
                'value' => 'ce54b25300edb99322ac9987c9c44bae_25_0f5af83d90766696bc8aa3e0af2a233e_1_rover_logo_transparent1pngpng.png',
            ],
            21 => [
                'id' => 49,
                'category' => 'preference',
                'field' => 'pdf',
                'value' => 'mPdf',
            ],
            22 => [
                'id' => 51,
                'category' => 'preference',
                'field' => 'file_size',
                'value' => '10',
            ],
            23 => [
                'id' => 55,
                'category' => 'preference',
                'field' => 'sso_service',
                'value' => '["Facebook","Google"]',
            ],
            24 => [
                'id' => 56,
                'category' => 'preference',
                'field' => 'order_prefix',
                'value' => 'ORD-',
            ],
            25 => [
                'id' => 61,
                'category' => 'verification',
                'field' => 'email',
                'value' => 'both',
            ],
            26 => [
                'id' => 62,
                'category' => 'product_inventory',
                'field' => 'manage_stock',
                'value' => '1',
            ],
            27 => [
                'id' => 63,
                'category' => 'product_inventory',
                'field' => 'hold_stock',
                'value' => '20',
            ],
            28 => [
                'id' => 64,
                'category' => 'product_inventory',
                'field' => 'notification_low_stock',
                'value' => '1',
            ],
            29 => [
                'id' => 65,
                'category' => 'product_inventory',
                'field' => 'notification_out_of_stock',
                'value' => '1',
            ],
            30 => [
                'id' => 66,
                'category' => 'product_inventory',
                'field' => 'stock_threshold',
                'value' => '1',
            ],
            31 => [
                'id' => 67,
                'category' => 'product_inventory',
                'field' => 'out_of_stock_visibility',
                'value' => '1',
            ],
            32 => [
                'id' => 68,
                'category' => 'product_inventory',
                'field' => 'stock_display_format',
                'value' => 'always_show',
            ],
            33 => [
                'id' => 69,
                'category' => 'product_general',
                'field' => 'taxes',
                'value' => '1',
            ],
            34 => [
                'id' => 70,
                'category' => 'product_general',
                'field' => 'coupons',
                'value' => '1',
            ],
            35 => [
                'id' => 71,
                'category' => 'product_general',
                'field' => 'calculate_coupon',
                'value' => '1',
            ],
            36 => [
                'id' => 72,
                'category' => 'product_general',
                'field' => 'measurement_weight',
                'value' => 'kg',
            ],
            37 => [
                'id' => 73,
                'category' => 'product_general',
                'field' => 'measurement_dimension',
                'value' => 'm',
            ],
            38 => [
                'id' => 74,
                'category' => 'product_general',
                'field' => 'reviews_enable_product_review',
                'value' => '1',
            ],
            39 => [
                'id' => 75,
                'category' => 'product_general',
                'field' => 'reviews_verified_owner_label',
                'value' => '1',
            ],
            40 => [
                'id' => 76,
                'category' => 'product_general',
                'field' => 'review_left',
                'value' => '1',
            ],
            41 => [
                'id' => 77,
                'category' => 'product_general',
                'field' => 'rating_enable',
                'value' => '1',
            ],
            42 => [
                'id' => 78,
                'category' => 'product_general',
                'field' => 'rating_required',
                'value' => '1',
            ],
            43 => [
                'id' => 79,
                'category' => 'product_vendor',
                'field' => 'show_sold_by',
                'value' => '1',
            ],
            44 => [
                'id' => 80,
                'category' => 'shipping_setting',
                'field' => 'hide_shipping_cost',
                'value' => '0',
            ],
            45 => [
                'id' => 81,
                'category' => 'shipping_setting',
                'field' => 'shipping_destination',
                'value' => 'billing_address',
            ],
            46 => [
                'id' => 82,
                'category' => 'shipping_setting',
                'field' => 'shipping_calculator_cart_page',
                'value' => '1',
            ],
            47 => [
                'id' => 84,
                'category' => 'product_general',
                'field' => 'simple_product',
                'value' => '1',
            ],
            48 => [
                'id' => 85,
                'category' => 'product_general',
                'field' => 'grouped_product',
                'value' => '1',
            ],
            49 => [
                'id' => 86,
                'category' => 'product_general',
                'field' => 'affiliate_product',
                'value' => '1',
            ],
            50 => [
                'id' => 87,
                'category' => 'product_general',
                'field' => 'variable_product',
                'value' => '1',
            ],
            51 => [
                'id' => 88,
                'category' => 'preference',
                'field' => 'customer_signup',
                'value' => '1',
            ],
            52 => [
                'id' => 89,
                'category' => 'preference',
                'field' => 'vendor_signup',
                'value' => '1',
            ],
            53 => [
                'id' => 90,
                'category' => 'preference',
                'field' => 'order_refund',
                'value' => '1',
            ],
            54 => [
                'id' => 91,
                'category' => 'tax_setting',
                'field' => 'calculate_tax',
                'value' => 'customer billing address',
            ],
            55 => [
                'id' => 92,
                'category' => 'tax_setting',
                'field' => 'shipping_tax_class',
                'value' => 'shipping tax class base on cart items',
            ],
            56 => [
                'id' => 93,
                'category' => 'tax_setting',
                'field' => 'rounding',
                'value' => '0',
            ],
            57 => [
                'id' => 94,
                'category' => 'tax_setting',
                'field' => 'display_tax_totals',
                'value' => 'as a single total',
            ],
            58 => [
                'id' => 95,
                'category' => 'company',
                'field' => 'company_country',
                'value' => 'bd',
            ],
            59 => [
                'id' => 96,
                'category' => 'product_general',
                'field' => 'wishlist',
                'value' => '1',
            ],
            60 => [
                'id' => 97,
                'category' => 'product_general',
                'field' => 'compare',
                'value' => '1',
            ],
            61 => [
                'id' => 98,
                'category' => 'product_vendor',
                'field' => 'is_publish_product',
                'value' => '1',
            ],
            62 => [
                'id' => 99,
                'category' => 'product_vendor',
                'field' => 'chat',
                'value' => '1',
            ],
            63 => [
                'id' => 100,
                'category' => 'preference',
                'field' => 'hide_decimal',
                'value' => '1',
            ],
            64 => [
                'id' => 101,
                'category' => 'preference',
                'field' => 'user_default_signup_status',
                'value' => 'Active',
            ],
            65 => [
                'id' => 102,
                'category' => 'preference',
                'field' => 'vendor_default_signup_status',
                'value' => 'Active',
            ],
            66 => [
                'id' => 103,
                'category' => 'preference',
                'field' => 'file_extension',
                'value' => '["jpg","jpeg","png","bmp","gif","doc","docx","xls","xlsx","csv","pdf","mp4","3gp","ico","zip"]',
            ],

        ]);
    }
}
