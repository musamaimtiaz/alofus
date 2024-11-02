<?php
/**
 * @author TechVillage <support@techvill.org>
 *
 * @contributor Al Mamun <[almamun.techvill@gmail.com]>
 *
 * @created 28-07-2022
 */

namespace Modules\Tax\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TaxRateUpdateRequest extends FormRequest
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
            'country' => 'nullable|max:30',
            'state' => 'nullable|max:30',
            'postcode' => 'nullable|max:10',
            'city' => 'nullable|max:30',
            'rate' => 'nullable|numeric|between:0,99999999.99999999',
            'name' => 'nullable|max:50',
            'priority' => 'nullable|numeric|between:0,99999999',
            'compound' => 'nullable',
            'shipping' => 'nullable',
            'tax_class_id' => 'nullable|exists:tax_classes,id',
        ];
    }
}
