<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class AuthUserRequest extends FormRequest
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
        $rules = [
            'password' => 'required',
            'gCaptcha' => isRecaptchaActive() ? 'required|captcha' : 'nullable',
        ];

        if ($this->phone) {
            $rules['phone'] = 'required|exists:users';
        } else {
            $rules['email'] = 'required|email|exists:users';
        }

        return $rules;
    }

    /**
     * Prepare the data for validation.
     *
     * @return void
     */
    protected function prepareForValidation()
    {
        $this->merge([
            'gCaptcha' => $this['g-recaptcha-response'],
            'phone' => $this['dial_code'] . $this['phone'],
        ]);
    }
}
