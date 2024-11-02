<?php

/**
 * @author TechVillage <support@techvill.org>
 *
 * @contributor Al Mamun <[almamun.techvill@gmail.com]>
 *
 * @created 18-11-2021
 */

namespace Modules\Coupon\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CouponResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request
     * @return array
     */
    public function toArray($request = [])
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'code' => $this->code,
            'discount_type' => $this->discount_type,
            'discount_amount' => formatCurrencyAmount($this->discount_amount),
            'start_date' => timeZoneFormatDate($this->start_date),
            'end_date' => timeZoneFormatDate($this->end_date),
            'status' => $this->status,
        ];
    }
}
