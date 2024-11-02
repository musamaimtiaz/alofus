<?php

/**
 * @author TechVillage <support@techvill.org>
 *
 * @contributor Al Mamun <[almamun.techvill@gmail.com]>
 *
 * @created 23-11-2021
 */

namespace Modules\Coupon\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CouponDetailResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
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
            'maximum_discount_amount' => formatCurrencyAmount($this->maximum_discount_amount),
            'start_date' => timeZoneFormatDate($this->start_date),
            'end_date' => timeZoneFormatDate($this->end_date),
            'status' => $this->status,
            'created_at' => timeZoneFormatDate($this->created_at),
            'updated_at' => timeZoneFormatDate($this->updated_at),
        ];
    }
}
