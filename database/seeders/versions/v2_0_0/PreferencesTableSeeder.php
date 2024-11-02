<?php

namespace Database\Seeders\versions\v2_0_0;

use App\Models\Preference;
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
        Preference::insertOrIgnore([
            [
                'category' => 'invoice',
                'field' => 'invoice',
                'value' =>  json_encode(
                    [
                        'general' => [
                            'company_name' => 'Martvill',
                            'company_logo' => 'Martvill',
                            'pdf_view' => 'new_tap',
                            'page_size' => 'A4',
                            'invoice_type' => 'global',
                            'logo' => '',
                        ],
                        'document' => [
                            'header' => [
                                'logo' => 'logo',
                                'is_invoice_no_show' => 1,
                                'invoice_label' => 'Order Invoice',
                                'is_show_customer_info' => 1,
                            ],
                            'product_table' => [
                                'is_image' => 1,
                                'product_label' => 'Product Name',
                                'is_attribute' => 1,
                                'is_quentity' => 1,
                                'quentity_label' => 'Quantity',
                                'is_vendor_name' => '1',
                                'vendor_name_label' => 'Shop Name',
                            ],
                            'delivery_details' => [
                                'is_delivery_details' => 1,
                                'delivery_details_labal' => 'DELIVERY DETAILS',
                                'is_shopping_address' => 1,
                                'shopping_address_label' => 'SHIPPING ADDRESS',
                                'is_estimate_time_section' => 1,
                                'estimate_time_label' => 'ESTIMATED DELIVERY TIME',
                                'is_payment_section' => 1,
                                'payment_label' => 'PAYMENT',
                            ],
                            'footer' => [
                                'is_footer' => 1,
                                'is_main_footer' => 1,
                                'main_footer' => [
                                    'label' => 'Keep in touch',
                                    'content' => 'If you have any queries, concerns or suggestions phone number: 017838859887 email : martvill@techvill.net',
                                    'text_color' => '',
                                    'align' => 'center',
                                ],
                                'is_copy_right_footer' => 1,
                                'copy_right_footer' => [
                                    'content' => '©2024 Mart Vill | All Rights Reserved',
                                    'text_color' => '',
                                    'align' => 'center',
                                ],
                            ],
                        ],
                    ]
                ),
            ],
        ]);

        Preference::updateOrInsert(
            [
                'category' => 'preference',
                'field' => 'db_version',
            ],
            [
                'value' => '2.0.0',
            ]
        );

        Preference::updateOrInsert(
            ['category' => 'product_barcode', 'field' => 'link_to'],
            ['value' => 'code']
        );

        Preference::updateOrInsert(
            ['category' => 'product_barcode', 'field' => 'show_product_name'],
            ['value' => 0]
        );

        Preference::updateOrInsert(
            ['category' => 'product_barcode', 'field' => 'show_vendor_name'],
            ['value' => 0]
        );

        Preference::updateOrInsert(
            ['category' => 'product_barcode', 'field' => 'show_product_image'],
            ['value' => 0]
        );

        Preference::updateOrInsert(
            ['category' => 'barcode', 'field' => 'barcode_text'],
            ['value' => 0]
        );

        Preference::updateOrInsert(
            ['category' => 'barcode', 'field' => 'barcode_type'],
            ['value' => 'C128']
        );

        Preference::updateOrInsert(
            ['category' => 'barcode', 'field' => 'barcode_color'],
            ['value' => '[0,0,0]']
        );

        Preference::updateOrInsert(
            ['category' => 'barcode', 'field' => 'barcode_width'],
            ['value' => 1]
        );

        Preference::updateOrInsert(
            ['category' => 'barcode', 'field' => 'barcode_height'],
            ['value' => 33]
        );
    }
}
