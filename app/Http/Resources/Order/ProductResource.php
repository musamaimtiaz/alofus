<?php

namespace App\Http\Resources\Order;

use App\Models\Product;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request = [])
    {
        if (! is_null(optional($this->product)->parent_id)) {
            $product = Product::select('id')->where('id', $this->product->parent_id)->first();
        } else {
            $product = Product::select('id')->where('id', $this->product_id)->first();
        }

        return [
            'id' => $this->id,
            'name' => $this->product_name,
            'slug' => isset($this->product) && $this->product->isVariation() ? optional(optional($this->product)->parentDetail)->slug : optional($this->product)->slug,
            'product_id' => optional($this->product)->parent_id ?? $this->product_id,
            'variation_id' => is_null(optional($this->product)->parent_id) ? 0 : $this->product_id,
            'quantity' => (int) $this->quantity,
            'is_delivered' => $this->is_delivery,
            'tax_class' => null,
            'price' => formatCurrencyAmount($this->price),
            'sub_total' => formatCurrencyAmount($this->price * $this->quantity),
            'subtotal_tax' => formatCurrencyAmount($this->tax_charge),
            'subtotal_shipping' => formatCurrencyAmount($this->shipping_charge),
            'total' => formatCurrencyAmount($this->price * $this->quantity + $this->tax_charge + $this->shipping_charge - $this->discount_amount),
            'variations' => json_decode($this->payloads),
            'category' => optional($product->category)->first()->name,
            'taxes' => [],
            'refunds' => RefundResource::collection($this->refunds),
            'vendor' => new VendorResource($this->vendor),
            'sku' => optional($this->product)->sku,
            'estimate_delivery' => $this->estimate_delivery,
        ];
    }
}
