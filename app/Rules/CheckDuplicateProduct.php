<?php
/**
 * @author TechVillage <support@techvill.org>
 *
 * @contributor Sakawat Hossain Rony <[sakawat.techvill@gmail.com]>
 *
 * @created 17-10-2021
 */

namespace App\Rules;

use App\Models\{Product, ProductCrossSale, ProductRelate, ProductTag};
use Illuminate\Contracts\Validation\Rule;

class CheckDuplicateProduct implements Rule
{
    protected $type;

    protected $productId;

    protected $message;

    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct($type = null, $productId = null)
    {
        $this->type = $type;
        $this->productId = $productId;
        $this->message = __('Duplicate :x entry error!', ['x' => __('Product')]);
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        $allData = [];
        if ($this->type == 'relate') {
            $relatedProduct = ProductRelate::getAll()->where('product_id', $this->productId)->pluck('related_product_id')->toArray();
            foreach ($value as $product) {
                if (! in_array($product, $allData) && ! in_array($product, $relatedProduct)) {
                    $productExist = Product::where('id', $product);
                    if ($product == $this->productId || ! $productExist->exists()) {
                        $this->message = __('Invalid :x', ['x' => __('Product')]);

                        return false;
                    }
                    $allData[] = $product;

                    continue;
                } else {
                    return false;
                }
            }
        } elseif ($this->type == 'cross') {
            $crossProduct = ProductCrossSale::getAll()->where('product_id', $this->productId)->pluck('cross_sale_product_id')->toArray();
            foreach ($value as $product) {
                if (! in_array($product, $allData) && ! in_array($product, $crossProduct)) {
                    $productExist = Product::where('id', $product);
                    if ($product == $this->productId || ! $productExist->exists()) {
                        $this->message = __('Invalid :x', ['x' => __('Product')]);

                        return false;
                    }
                    $allData[] = $product;

                    continue;
                } else {
                    return false;
                }
            }
        } elseif ($this->type == 'up') {
            $upSaleProduct = ProductTag::getAll()->where('product_id', $this->productId)->pluck('upsale_product_id')->toArray();
            foreach ($value as $product) {
                if (! in_array($product, $allData) && ! in_array($product, $upSaleProduct)) {
                    $productExist = Product::where('id', $product);
                    if ($product == $this->productId || ! $productExist->exists()) {
                        $this->message = __('Invalid :x', ['x' => __('Product')]);

                        return false;
                    }
                    $allData[] = $product;

                    continue;
                } else {
                    return false;
                }
            }
        }

        return true;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return $this->message;
    }
}
