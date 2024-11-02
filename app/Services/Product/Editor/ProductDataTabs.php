<?php

namespace App\Services\Product\Editor;

class ProductDataTabs
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
    public function tabs()
    {
        $tabs = [
            'General' => [
                'tab' => '<li class="nav-item conditional-dom not-variable-dom not-grouped-dom ' .
                    ($this->isTabDisplayNone('General') ? 'd-none' : '') . '">
                            <a class="nav-link ' . ($this->isTabActive('General') ? '' : 'active') . '"
                                id="tabs-one" data-bs-toggle="tab" href="#tabs-a" role="tab" aria-controls="tabs-a"
                                aria-selected="true">' . __('General') . '</a>
                        </li>',
                'tab_content' => 'admin.products.sections.sub.general-tab',
                'position' => '10',
                'visibility' => true,
            ],

            'Inventory' => [
                'tab' => '<li class="nav-item conditional-dom">
                            <a class="nav-link inventory ' . ($this->isTabActive('Inventory') ? 'active' : '') . '"
                                id="tabs-two" data-bs-toggle="tab" href="#tabs-b" role="tab" aria-controls="tabs-b"
                                aria-selected="false">' . __('Inventory') . '</a>
                        </li>',
                'tab_content' => 'admin.products.sections.sub.inventory-tab',
                'position' => '20',
                'visibility' => preference('manage_stock'),
            ],

            'Shipping & Delivery' => [
                'tab' => '<li class="nav-item off_impact conditional-dom not-grouped-dom not-external-dom ' .
                    ($this->isTabActive('Shipping & Delivery') ? 'd-none' : '') . '" data-name="virtual">
                            <a class="nav-link" id="tabs-three" data-bs-toggle="tab" href="#tabs-c" role="tab"
                                aria-controls="tabs-c" aria-selected="false">' . __('Shipping & Delivery') . '</a>
                        </li>',
                'tab_content' => 'admin.products.sections.sub.shipping-tab',
                'position' => '30',
                'visibility' => true,
            ],

            'Service' => [
                'tab' => '<li class="nav-item conditional-dom not-grouped-dom ' .
                    ($this->isTabDisplayNone('Service') ? 'd-none' : '') . '">
                            <a class="nav-link" id="tabs-4" data-bs-toggle="tab" href="#tabs-d" role="tab"
                                aria-controls="tabs-d" aria-selected="false">' . __('Service') . '</a>
                        </li>',
                'tab_content' => 'admin.products.sections.sub.warranty-tab',
                'position' => '40',
                'visibility' => true,
            ],

            'Attributes' => [
                'tab' => '<li class="nav-item ">
                            <a class="nav-link" id="tabs-6" data-bs-toggle="tab" href="#tabs-f" role="tab"
                                aria-controls="tabs-f" aria-selected="false">' . __('Attributes') . '</a>
                        </li>',
                'tab_content' => 'admin.products.sections.sub.attributes-tab',
                'position' => '50',
                'visibility' => true,
            ],

            'Variations' => [
                'tab' => '<li class="nav-item conditional-dom not-simple-dom not-grouped-dom not-external-dom ' .
                    ($this->isTabActive('Variations') ? '' : 'd-none') . '">
                            <a class="nav-link"
                                id="tabs-7" data-bs-toggle="tab" href="#tabs-g" role="tab"
                                aria-controls="tabs-g" aria-selected="false">' . __('Variations') . '</a>
                        </li>',
                'tab_content' => 'admin.products.sections.sub.variations-tab',
                'position' => '60',
                'visibility' => true,
            ],

            'Advanced' => [
                'tab' => '<li class="nav-item">
                            <a class="nav-link ' . ($this->isTabActive('Advanced') ? 'active' : '') . '"
                                id="tabs-8" data-bs-toggle="tab" href="#tabs-h" role="tab" aria-controls="tabs-h"
                                aria-selected="false">' . __('Advanced') . '</a>
                        </li>',
                'tab_content' => 'admin.products.sections.sub.advanced-tab',
                'position' => '70',
                'visibility' => true,
            ],
        ];

        $tabs = apply_filters('product_editor_data_tabs', [
            'tabs' => $tabs,
            'product' => $this->product,
        ]);

        // Sort items based on position, placing items without a position at the beginning
        uasort($tabs['tabs'], function ($a, $b) {
            return ($a['position'] ?? -1) <=> ($b['position'] ?? -1);
        });

        return $tabs;
    }

    private function isTabActive($tabName)
    {
        if (is_null($this->product)) {
            return false;
        }

        switch ($tabName) {
            case 'General':
            case 'Inventory':
                return $this->product->isGroupedProduct() || $this->product->isVariableProduct();

            case 'Shipping & Delivery':
                return $this->product->isVirtual() || $this->product->isDownloadable();

            case 'Variations':
                return $this->product->isVariableProduct();

            case 'Advanced':
                return ! preference('manage_stock') && ($this->product->isGroupedProduct() || $this->product->isVariableProduct());

            default:
                return false;
        }
    }

    private function isTabDisplayNone($tabName)
    {
        switch ($tabName) {
            case 'General':
                return ! is_null($this->product) && ($this->product->isVariableProduct() || $this->product->isGroupedProduct());

            case 'Service':
                return ! is_null($this->product) && $this->product->isGroupedProduct();

            default:
                return false;
        }
    }
}
