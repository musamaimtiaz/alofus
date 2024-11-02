<?php

/**
 * @author TechVillage <support@techvill.org>
 *
 * @contributor Md Abdur Rahaman Zihad <[zihad.techvill@gmail.com]>
 *
 * @created 21-06-2022
 */

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class VariationResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $data = [
            'id' => $this->id,
            'code' => $this->code,
            'sku' => $this->sku,
            'parent_id' => $this->parent_id,
            'regular_price' => $this->getPrice(),
            'regular_price_formatted' => $this->getFormattedPrice(),
            'sale_price' => $this->getSalePrice(),
            'sale_from' => $this->sale_from,
            'sale_to' => $this->sale_to,
            'sale_price_formatted' => $this->getFormattedSalePrice(),
            'available_from' => ! empty($this->available_from) ? formatDate($this->available_from) : null,
            'available_to' => ! empty($this->available_to) ? formatDate($this->available_to) : null,
            'total_stocks' => $this->total_stocks,
            'manage_stocks' => $this->manage_stocks,
            'backorder' => $this->meta_backorder,
            'critical_stock_quantity' => $this->meta_stock_threshold,
            'summary' => $this->summary,
            'created_at' => $this->format_created_at,
            'attributes' => $this->attributes,
            'images' => $this->getAllImagesUrls(),
            'dimensions' => $this->meta_dimension,
            'offerCheck' => $this->offerCheck(),
            'discountPercent' => $this->getDiscountAmount(),
        ];

        if (isActive('B2B')) {
            $data = array_merge($data, ['isEnableB2B' => $this->meta_enable_b2b, 'b2bData' => $this->getB2BData()]);
        }

        return $data;
    }
}
