<?php

namespace Modules\Newsletter\Http\Requests;

use App\Rules\CheckValidDate;
use App\Rules\CheckValidEmail;
use Illuminate\Foundation\Http\FormRequest;

class UpdateSubscriberRequest extends FormRequest
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
            'email' => ['required', 'unique:subscribers,email,' . $this->id, new CheckValidEmail()],
            'confirmation_date' => ['required', new CheckValidDate()],
            'status' => ['required', 'in:Active,Inactive'],
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
            'status.in' => __('The :attribute must be either Active or Inactive'),
        ];
    }
}
