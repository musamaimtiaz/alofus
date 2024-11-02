<?php
/**
 * @author TechVillage <support@techvill.org>
 *
 * @contributor Al Mamun <[almamun.techvill@gmail.com]>
 *
 * @created 30-09-2021
 */

namespace Modules\Shipping\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ShippingZoneMethodResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request = [])
    {
        $costType = ['cost_per_order' => __('Cost per order'), 'cost_per_quantity' => __('Cost per quantity'), 'percent_sub_total_item_price' => __('Percent sub total of product price')];
        $taxStatus = ['taxable' => __('Taxable'), 'none' => __('None')];
        $requirement = ['' => 'N/A', 'coupon' => __('A valid free shipping coupon'), 'min_amount' => __('A minimum order amount'), 'either' => __('A minimum order amount OR a coupon'), 'both' => __('A minimum order amount AND a coupon')];

        return [
            'id' => $this->id,
            'cost' => formatNumber($this->cost),
            'cost_type' => $costType[$this->cost_type],
            'shipping_zone_id' => $this->shipping_zone_id,
            'shipping_method_id' => $this->shipping_method_id,
            'shipping_method_name' => optional($this->shippingMethod)->name,
            'shipping_zone_name' => optional($this->shippingZone)->name,

            'method_title' => $this->method_title,
            'tax_status' => $taxStatus[$this->tax_status],
            'calculation_type' => $this->calculation_type,
            'requirements' => $requirement[$this->requirements],
            'status' => $this->status,
        ];
    }
}
