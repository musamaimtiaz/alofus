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

class ShippingZoneClassResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request = [])
    {
        $arr = ['cost_per_order' => __('Cost per order'), 'cost_per_quantity' => __('Cost per quantity'), 'percent_sub_total_item_price' => __('Percent sub total of product price')];

        return [
            'id' => $this->id,
            'cost' => formatNumber($this->cost),
            'cost_type' => $arr[$this->cost_type],
            'shipping_zone_id' => $this->shipping_zone_id,
            'shipping_class_slug' => $this->shipping_class_slug,
            'shipping_class_name' => optional($this->shippingClass)->name,
            'shipping_zone_name' => optional($this->shippingZone)->name,
        ];
    }
}
