<?php

namespace Modules\CMS\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\CMS\Entities\Layout;
use Modules\CMS\Entities\LayoutType;

class TemplateAndLayoutSeeder extends Seeder
{
    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        \DB::table('layout_types')->delete();
        LayoutType::insert([
            [
                'id' => 1,
                'name' => 'Call To Action',
                'description' => 'Call to action',
            ],
            [
                'id' => 2,
                'name' => 'Product Blocks',
                'description' => 'Different Blocks',
            ],
            [
                'id' => 3,
                'name' => 'Categories',
                'description' => 'Categories',
            ],
            [
                'id' => 4,
                'name' => 'Brands',
                'description' => 'Product Brands',
            ],
            [
                'id' => 5,
                'name' => 'Blogs',
                'description' => 'Blogs Layout',
            ],
            [
                'id' => 6,
                'name' => 'Extras',
                'description' => 'Information Box',
            ],
        ]);
        \DB::table('layouts')->delete();
        Layout::insert([
            [
                'id' => 1,
                'layout_type_id' => 1,
                'name' => 'Brand Call To Action 1',
                'description' => 'Brand CTA 1',
                'file' => 'cta-banner-template-v1',
                'image' => 'cta-banner-template-v1.png',
            ],
            [
                'id' => 2,
                'layout_type_id' => 2,
                'name' => 'Grid with sidebar',
                'description' => 'Grid with left slider/banner',
                'file' => 'product-grid-with-sidebar-template-v1',
                'image' => 'product-grid-with-sidebar-template-v1.png',
            ],
            [
                'id' => 3,
                'layout_type_id' => 2,
                'name' => 'Product Grid Tabs',
                'description' => 'Product grid with tabs',
                'file' => 'product-tabs-grid-template-v1',
                'image' => 'product-tabs-grid-template-v1.png',
            ],
            [
                'id' => 4,
                'layout_type_id' => 1,
                'name' => 'Multiple Call To Action',
                'description' => 'Multiple CTA',
                'file' => 'cta-banner-template-v2',
                'image' => 'cta-banner-template-v2.png',
            ],
            [
                'id' => 5,
                'layout_type_id' => 3,
                'name' => 'Category Block 1',
                'description' => 'Categories Block',
                'file' => 'category-template-v1',
                'image' => 'category-template-v1.png',
            ],
            [
                'id' => 6,
                'layout_type_id' => 4,
                'name' => 'Brand Block',
                'description' => 'Brand Block',
                'file' => 'brands-template-v1',
                'image' => 'brands-template-v1.png',
            ],
            [
                'id' => 7,
                'layout_type_id' => 5,
                'name' => 'Blogs Grid',
                'description' => 'Blogs Grid',
                'file' => 'blogs-template-v1',
                'image' => 'blogs-template-v1.png',
            ],
            [
                'id' => 8,
                'layout_type_id' => 6,
                'name' => 'Iconbox Grid',
                'description' => 'Iconbox Grid',
                'file' => 'iconbox-grid-template-v1',
                'image' => 'iconbox-grid-template-v1.png',
            ],
            [
                'id' => 9,
                'layout_type_id' => 6,
                'name' => 'Newsletter',
                'description' => 'Newsletter',
                'file' => 'newsletter-template-v1',
                'image' => 'newsletter-template-v1.png',
            ],
            [
                'id' => 10,
                'layout_type_id' => 1,
                'name' => 'Slider',
                'description' => 'Slider',
                'file' => 'slider-template-v1',
                'image' => 'slider-template-v1.png',
            ],
            [
                'id' => 11,
                'layout_type_id' => 6,
                'name' => 'Custom Block',
                'description' => 'Custom Block',
                'file' => 'custom-block-template-v1',
                'image' => 'custom-block-template-v1.png',
            ],
        ]);
    }
}
