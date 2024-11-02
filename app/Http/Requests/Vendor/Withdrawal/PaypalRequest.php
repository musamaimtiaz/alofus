<?php

namespace App\Http\Requests\Vendor\Withdrawal;

use App\Rules\CheckValidEmail;
use Illuminate\Foundation\Http\FormRequest;

class PaypalRequest extends FormRequest
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
        return $this->isMethod('GET') || ! isset($this->email) ? [] : [
            'email' => ['required', new CheckValidEmail()],
            'is_default' => 'required|in:0,1',
        ];
    }

    /**
     * Get custom attributes for validator errors.
     *
     * @return array
     */
    public function attributes()
    {
        return [
            'email' => __('Email Address'),
            'is_default' => __('Default'),
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'is_default.in' => __('The :attribute must be either 0 or 1'),
        ];
    }
}
