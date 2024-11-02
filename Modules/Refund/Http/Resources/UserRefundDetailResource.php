<?php
/**
 * @author TechVillage <support@techvill.org>
 *
 * @contributor Al Mamun <[almamun.techvill@gmail.com]>
 *
 * @created 26-07-2022
 */

namespace Modules\Refund\Http\Resources;

use App\Http\Resources\Order\ProductResource;
use Illuminate\Http\Resources\Json\JsonResource;

class UserRefundDetailResource extends JsonResource
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
            'user_id' => $this->user_id,
            'order_reference' => $this?->orderDetail?->order?->reference,
            'reason' => $this?->refundReason?->name,
            'reference' => $this->reference,
            'quantity_sent' => $this->quantity_sent,
            'type' => $this->refund_type,
            'method' => $this->refund_method,
            'payment_status' => $this->payment_status,
            'product_image_url' => $this->getRefundImage(),
            'refund_image_urls' => $this->objectFile()->get()->isNotEmpty() ? $this->filesUrlold() : null,
            'line_items' => new ProductResource($this->orderDetail),
            'status' => $this->status,
            'created_at' => timeZoneFormatDate($this->created_at),
            'updated_at' => timeZoneFormatDate($this->updated_at),
        ];
    }
}
