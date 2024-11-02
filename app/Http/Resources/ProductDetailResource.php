<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ProductDetailResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $userId = null;
        if (! isset($request->user_id) && isset(auth()->guard('api')->user()->id)) {
            $userId = auth()->guard('api')->user()->id;
        } elseif (isset($request->user_id)) {
            $userId = $request->user_id;
        }

        $data = [
            'id' => $this->id,
            'name' => $this->name,
            'code' => $this->code,
            'sku' => $this->sku,
            'slug' => $this->slug,
            'type' => $this->type,
            'available_from' => $this->available_from,
            'available_to' => $this->available_to,
            'description' => $this->description,
            'summary' => $this->summary,
            'parent_id' => $this->parent_id,
            'categories' => $this->getCategoryName(),
            'brand' => optional($this->brand)->name,
            'brand_id' => $this->brand_id,
            'shop_id' => $this->shop_id,
            'vendor_id' => $this->vendor_id,
            'shop_alias' => isset($this->vendor) && isset($this->vendor->shops[0]) ? $this->vendor->shops[0]->alias : '',
            'regular_price' => $this->getPrice(),
            'regular_price_formatted' => $this->getFormattedPrice(),
            'sale_price' => $this->getSalePrice(),
            'sale_price_formatted' => $this->getFormattedSalePrice(),
            'sale_from' => $this->sale_from,
            'sale_to' => $this->sale_to,
            'tax_classes' => $this->getTaxClass(),
            'total_sales' => $this->total_sales,
            'featured' => $this->featured,
            'virtual' => $this->meta_virtual,
            'downloadable' => $this->meta_downloadable,
            'downloads' => $this->getDownloadables(),
            'download_limit' => $this->getDownloadLimit(),
            'status' => $this->status,
            'total_downloads' => $this->purchase_downloads,
            'manage_stocks'  => $this->isStockManageable(),
            'stock_quantity' => $this->getStockQuantity(),
            'stock_status' => $this->getStockStatus(),
            'stock_hide' => $this->meta_hide_stock,
            'backorders' => $this->isAllowBackorder(),
            'critical_stock_quantity' => $this->meta_stock_threshold,
            'weight' => $this->meta_weight,
            'dimensions' => is_array($this->meta_dimension) && count($this->meta_dimension) > 0 ? $this->meta_dimension : [],
            'shipping_status' => true,
            'shipping_required' => true,
            'is_shipping_taxable' => true,
            'shipping_class_ids' => $this->meta_shipping_id,
            'reviews_allowed' => $this->isReviewEnabled(),
            'related_ids' => $this->getRelatedProductIds(),
            'upsell_ids' => $this->getUpSaleIds(),
            'cross_sell_ids' => $this->getRelatedProductIds(),
            'purchase_note' => $this->purchase_note,
            'featured_image' =>  $this->getFeaturedImage(),
            'featured_image_small' =>  $this->getFeaturedImage('small'),
            'featured_image_medium' =>  $this->getFeaturedImage('medium'),
            'images' => $this->getAllImagesUrls(),
            'videos' => $this->getAllVideoUrls(),
            'meta' => [
                'cash_on_delivery' => $this->cash_on_delivery,
                'individual_sale' => $this->meta_individual_sale,
            ],
            'tags' => TagResource::collection($this->whenLoaded('tags', $this->tags)),
            'seo' => $this->getSeoMeta(),
            'warranty_type' => $this->warranty_type,
            'warranty_period' => $this->warranty_period,
            'warranty_policy' => $this->warranty_policy,
            'review_count' => $this->review_count,
            'review_average' => $this->review_average,
            'can_review' => $this->canReview(),
            'total_wish' => $this->total_wish,
            'external_products' => $this->meta_external_product,
            'attributes' => $this->getProductAttributes(),
            'attribute_values' => $this->getAttributeValues(),
            'default_attributes' => $this->getDefaultVariationAttributes(),
            'variations' => VariationResource::collection($this->variations),
            'estimated_delivery' => $this->estimated_delivery,
            'estimated_delivery_unit' => 'days',
            'is_wishlisted' => $this->isWishlist($this->id, $userId),
            'is_compared' => isCompared($this->id, $userId),
            'isOutOfStock' => $this->isOutOfStock(),
            'wishlist_id' => $this->wishListId($userId),
            'group_products' => $this->groupProducts(),
            'share_link' => route('site.productDetails', $this->slug),
            'offerCheck' => $this->offerCheck(),
            'discountPercent' => $this->getDiscountAmount(),
        ];

        if (isActive('B2B')) {
            $data = array_merge($data, ['isEnableB2B' => $this->meta_enable_b2b, 'b2bData' => $this->getB2BData()]);
        }

        return $data;
    }
}
