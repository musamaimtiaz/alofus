<?php

namespace App\Http\Resources\Order;

use App\Models\Order;
use Illuminate\Http\Resources\Json\JsonResource;

class PaymentResource extends JsonResource
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
            'code' => $this->code,
            'unique_code' => $this->unique_code,
            'gateway' => $this->gateway,
            'transaction_id' => optional(Order::select('id', 'reference')->where('reference', $this->code)->first()->transaction)->id,
            'payment_id' => $this->payment_id,
            'total' => formatCurrencyAmount($this->total),
            'currency' => $this->currency_code,
            'status' => $this->status,
            'created_at' => timeZoneFormatDate($this->created_at) . ' ' . timeZoneGetTime($this->created_at),
            'updated_at' => timeZoneFormatDate($this->updated_at) . ' ' . timeZoneGetTime($this->updated_at),
        ];
    }
}
