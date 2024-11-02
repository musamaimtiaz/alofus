<?php

/**
 * @author TechVillage <support@techvill.org>
 *
 * @contributor Sakawat Hossain Rony <[sakawat.techvill@gmail.com]>
 * @contributor Md Abdur Rahaman Zihad <[zihad.techvill@gmail.com]>
 *
 * @created 28-10-2021
 */

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request = null)
    {
        $userId = null;
        if (! isset($request->user_id) && isset(auth()->guard('api')->user()->id)) {
            $userId = auth()->guard('api')->user()->id;
        } elseif (isset($request->user_id)) {
            $userId = $request->user_id;
        }

        return [
            'id' => $this->id,
            'name' => $this->name,
            'code' => $this->code,
            'sku' => $this->sku,
            'slug' => $this->slug,
            'type' => $this->type,
            'available_from' => $this->available_from,
            'available_to' => $this->available_to,
            'summary' => $this->summary,
            'categories' => $this->getCategoryName(),
            'brand' => optional($this->brand)->name,
            'brand_id' => $this->brand_id,
            'shop_id' => $this->shop_id,
            'vendor_id' => $this->vendor_id,
            'regular_price' => $this->getPrice(),
            'regular_price_formatted' => $this->getFormattedPrice(),
            'sale_price' => $this->getSalePrice(),
            'sale_price_formatted' => $this->getFormattedSalePrice(),
            'sale_from' => $this->sale_from,
            'sale_to' => $this->sale_to,
            'total_sales' => $this->total_sales,
            'featured' => $this->featured,
            'virtual' => $this->meta_virtual,
            'downloadable' => $this->meta_downloadable,
            'status' => $this->status,
            'total_downloads' => $this->purchase_downloads,
            'manage_stocks'  => $this->isStockManageable(),
            'stock_quantity' => $this->getStockQuantity(),
            'stock_status' => $this->getStockStatus(),
            'stock_hide' => $this->meta_hide_stock,
            'backorders' => $this->isAllowBackorder(),
            'critical_stock_quantity' => $this->meta_stock_threshold,
            'shipping_status' => true,
            'shipping_required' => true,
            'featured_image' =>  $this->getFeaturedImage(),
            'featured_image_small' =>  $this->getFeaturedImage('small'),
            'featured_image_medium' =>  $this->getFeaturedImage('medium'),
            'tags' => TagResource::collection($this->whenLoaded('tags', $this->tags)),
            'review_count' => $this->review_count,
            'review_average' => $this->review_average,
            'attributes' => $this->getProductAttributes(),
            'attribute_values' => $this->getAttributeValues(),
            'offerCheck' => $this->offerCheck(),
            'discountPercent' => $this->getDiscountAmount(),
            'estimated_delivery' => $this->estimated_delivery,
            'estimated_delivery_unit' => 'days',
            'is_wishlisted' => $this->isWishlist($this->id, $userId),
            'is_compared' => isCompared($this->id, $userId),
            'isOutOfStock' => $this->isOutOfStock(),
            'individual_sale' => $this->meta_individual_sale,
        ];
    }
}
