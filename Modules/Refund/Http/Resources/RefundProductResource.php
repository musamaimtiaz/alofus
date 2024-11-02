<?php
/**
 * @author TechVillage <support@techvill.org>
 *
 * @contributor Al Mamun <[almamun.techvill@gmail.com]>
 *
 * @created 06-09-2022
 */

namespace Modules\Refund\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class RefundProductResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->product_name,
            'product_id' => $this->product_id,
            'quantity' => (int) $this->quantity,
            'tax_class' => null,
            'subtotal' => formatCurrencyAmount($this->price),
            'subtotal_tax' => formatCurrencyAmount($this->tax_charge),
            'subtotal_shipping' => formatCurrencyAmount($this->shipping_charge),
            'variations' => json_decode($this->payloads),
            'taxes' => [],
            'sku' => $this->product->sku,
        ];
    }
}
