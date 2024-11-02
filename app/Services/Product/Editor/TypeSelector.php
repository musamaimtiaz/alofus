<?php

namespace App\Services\Product\Editor;

class TypeSelector
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
    public function productTypeSelectorOnAdd()
    {
        $productTypeSelectors['Simple'] = $this->createProductTypeOption('Simple', 'Simple Product', 'simple_product', '10');
        $productTypeSelectors['Variable'] = $this->createProductTypeOption('Variable', 'Variable Product', 'variable_product', '20');
        $productTypeSelectors['Grouped'] = $this->createProductTypeOption('Grouped', 'Grouped Product', 'grouped_product', '40');
        $productTypeSelectors['External'] = $this->createProductTypeOption('External', 'External/Affiliate Product', 'affiliate_product', '50');

        $productTypeSelectors = apply_filters('product_editor_type_selector', [
            'options' => $productTypeSelectors,
            'product' => $this->product,
        ]);

        // Sort items based on position, placing items without a position at the beginning
        uasort($productTypeSelectors['options'], function ($a, $b) {
            return ($a['position'] ?? -1) <=> ($b['position'] ?? -1);
        });

        return $productTypeSelectors;
    }

    /**
     * Check if the given product type is selected.
     */
    private function isTypeSelected(string $type): bool
    {
        if (is_null($this->product)) {
            return false;
        }

        return match ($type) {
            'Simple' => $this->product->isSimpleProduct(),
            'Variable' => $this->product->isVariableProduct(),
            'Grouped' => $this->product->isGroupedProduct(),
            'External' => $this->product->isExternalProduct(),
            default => false,
        };
    }

    /**
     * Create a product type option for the selector.
     *
     * @param  string  $type
     * @param  string  $label
     * @param  string  $visibility
     * @param  int  $position
     * @return array
     */
    protected function createProductTypeOption($type, $label, $visibility, $position)
    {
        return [
            'option_html' => sprintf(
                '<option %s value="%s">%s</option>',
                $this->isTypeSelected($type) ? 'selected' : '',
                $label,
                __($label)
            ),
            'visibility' => preference($visibility),
            'position' => $position,
        ];
    }
}
