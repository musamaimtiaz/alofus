<?php

namespace Modules\Shipping\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ShippingZoneMethodStoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'cost' => 'nullable|between:0,99999999.99999999',
            'cost_type' => 'nullable|max:50|in:cost_per_order,cost_per_quantity,percent_sub_total_item_price',
            'shipping_zone_id' => 'required|exists:shipping_zones,id',
            'shipping_method_id' => 'required|exists:shipping_methods,id',
            'method_title' => 'nullable|max:191',
            'tax_status' => 'nullable|in:taxable,none',
            'calculation_type' => 'nullable|in:0,1',
            'requirements' => 'nullable|in:coupon,min_amount,either,both',
            'status' => 'nullable|in:0,1',
        ];
    }
}
