<?php

namespace App\Services\Product\Editor;

class Section
{
    /**
     * @var \App\Models\Product|null
     */
    protected $product;

    /**
     * Editor constructor.
     *
     * @param  \App\Models\Product|null  $product
     */
    public function __construct($product = null)
    {
        $this->product = $product;
    }

    /**
     * Generate product type selectors for the Add Product form.
     *
     * @return array
     */
    public function getSections()
    {
        $sections = [
            'product-basic' => [
                'is_main' => true,
                'position' => '10',
                'visibility' => true,
                'content' => 'admin.products.sections.product-basic',
            ],
            'product-details' => [
                'is_main' => true,
                'is_draggable' => true,
                'position' => '20',
                'visibility' => true,
                'content' => 'admin.products.sections.product-details',
            ],
            'product-data' => [
                'is_main' => true,
                'is_draggable' => true,
                'position' => '30',
                'visibility' => true,
                'content' => 'admin.products.sections.product-data',
            ],
            'product-media' => [
                'is_main' => true,
                'is_draggable' => true,
                'position' => '40',
                'visibility' => true,
                'content' => 'admin.products.sections.product-media',
            ],
            'seo' => [
                'is_main' => true,
                'is_draggable' => true,
                'position' => '50',
                'visibility' => true,
                'content' => 'admin.products.sections.seo',
            ],
            'product-stats' => [
                'is_left_side' => true,
                'position' => '60',
                'visibility' => true,
                'content' => 'admin.products.sections.product-stats',
            ],
            'additional-info' => [
                'is_left_side' => true,
                'position' => '70',
                'visibility' => true,
                'content' => 'admin.products.sections.additional-info',
            ],
            'tags' => [
                'is_left_side' => true,
                'position' => '80',
                'visibility' => true,
                'content' => 'admin.products.sections.tags',
            ],
        ];

        $sections = apply_filters('product_editor_sections', [
            'sections' => $sections,
            'product' => $this->product,
        ]);

        // Sort items based on position, placing items without a position at the beginning
        uasort($sections['sections'], function ($a, $b) {
            return ($a['position'] ?? -1) <=> ($b['position'] ?? -1);
        });

        return $sections;
    }
}
