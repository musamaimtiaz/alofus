<?php

namespace Modules\CMS\Database\Seeders;

use Illuminate\Database\Seeder;

class SlidesTableSeeder extends Seeder
{
    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {

        $data =  [
            0 => [
                'id' => 1,
                'slider_id' => 1,
                'title_text' => '',
                'title_animation' => 'fadeIn',
                'title_delay' => 0.02,
                'title_font_color' => '#737373',
                'title_font_size' => 0,
                'title_direction' => 'left',
                'sub_title_text' => '',
                'sub_title_animation' => 'fadeIn',
                'sub_title_delay' => 0.02,
                'sub_title_font_color' => '#000000',
                'sub_title_font_size' => 40,
                'sub_title_direction' => 'left',
                'description_title_text' => '',
                'description_title_animation' => 'fadeIn',
                'description_title_delay' => 0.03,
                'description_title_font_color' => '#000000',
                'description_title_font_size' => 26,
                'description_title_direction' => 'left',
                'button_title' => 'Shop Now',
                'button_link' => 'https://demo.martvill.techvill.net/search-products?categories=Fashion',
                'button_font_color' => '#2c2c2c',
                'button_bg_color' => '#fcca19',
                'button_position' => 'left',
                'button_animation' => 'fadeIn',
                'button_delay' => 0.0,
                'is_open_in_new_window' => 'Yes',
            ],
            1 => [
                'id' => 2,
                'slider_id' => 1,
                'title_text' => 'Hena’s Lifestyle',
                'title_animation' => 'fadeIn',
                'title_delay' => 0.02,
                'title_font_color' => '#dcdbdb',
                'title_font_size' => 26,
                'title_direction' => 'left',
                'sub_title_text' => 'MODERN FURNITURES',
                'sub_title_animation' => 'fadeIn',
                'sub_title_delay' => 0.02,
                'sub_title_font_color' => '#ffffff',
                'sub_title_font_size' => 40,
                'sub_title_direction' => 'left',
                'description_title_text' => 'Flash Sale up to <br><span style="color:#E43147;margin-top:10px">10% OFF<span>',
                'description_title_animation' => 'fadeIn',
                'description_title_delay' => 0.02,
                'description_title_font_color' => '#ffffff',
                'description_title_font_size' => 26,
                'description_title_direction' => 'left',
                'button_title' => 'Shop Now',
                'button_link' => 'https://demo.martvill.techvill.net/search-products?categories=Home%20Appliances',
                'button_font_color' => '#2c2c2c',
                'button_bg_color' => '#fcca19',
                'button_position' => 'left',
                'button_animation' => 'fadeIn',
                'button_delay' => 0.0,
                'is_open_in_new_window' => 'Yes',
            ],
            2 => [
                'id' => 3,
                'slider_id' => 1,
                'title_text' => 'Custom Men’s',
                'title_animation' => 'fadeIn',
                'title_delay' => 0.02,
                'title_font_color' => '#878787',
                'title_font_size' => 26,
                'title_direction' => 'left',
                'sub_title_text' => 'SPORTS GEAR',
                'sub_title_animation' => 'fadeIn',
                'sub_title_delay' => 0.02,
                'sub_title_font_color' => '#000000',
                'sub_title_font_size' => 40,
                'sub_title_direction' => 'left',
                'description_title_text' => 'Flash Sale up to <br><span style="color:#E43147;margin-top:10px">30% OFF<span>',
                'description_title_animation' => 'fadeIn',
                'description_title_delay' => 0.02,
                'description_title_font_color' => '#000000',
                'description_title_font_size' => 26,
                'description_title_direction' => 'left',
                'button_title' => 'Shop Now',
                'button_link' => 'https://demo.martvill.techvill.net/search-products?categories=Automotive%20%26%20Motorbike',
                'button_font_color' => '#2c2c2c',
                'button_bg_color' => '#fcca19',
                'button_position' => 'left',
                'button_animation' => 'fadeIn',
                'button_delay' => 0.0,
                'is_open_in_new_window' => 'Yes',
            ],
            3 => [
                'id' => 4,
                'slider_id' => 1,
                'title_text' => 'CellHive Gadgets',
                'title_animation' => 'fadeIn',
                'title_delay' => 0.02,
                'title_font_color' => '#8c8c8c',
                'title_font_size' => 26,
                'title_direction' => 'left',
                'sub_title_text' => 'GEN V EARPHONES',
                'sub_title_animation' => 'fadeIn',
                'sub_title_delay' => 0.02,
                'sub_title_font_color' => '#000000',
                'sub_title_font_size' => 40,
                'sub_title_direction' => 'left',
                'description_title_text' => 'Sale up to <br><span style="color:#E43147;margin-top:10px">30% OFF<span>',
                'description_title_animation' => 'fadeIn',
                'description_title_delay' => 0.02,
                'description_title_font_color' => '#000000',
                'description_title_font_size' => 26,
                'description_title_direction' => 'left',
                'button_title' => 'Shop Now',
                'button_link' => 'https://demo.martvill.techvill.net/search-products?categories=Electronic%20Accessories',
                'button_font_color' => '#2c2c2c',
                'button_bg_color' => '#fcca19',
                'button_position' => 'left',
                'button_animation' => 'fadeIn',
                'button_delay' => 0.0,
                'is_open_in_new_window' => 'Yes',
            ],
        ];

        $replaceFrom = [
            'https:\\/\\/demo.martvill.techvill.net\\',
            'https://demo.martvill.techvill.net',
        ];

        $replaceTo = url('/');

        array_walk_recursive($data, function (&$value) use ($replaceFrom, $replaceTo) {
            $value = str_replace($replaceFrom, $replaceTo, $value);
        });

        \DB::table('slides')->delete();

        \DB::table('slides')->insert($data);

    }
}
