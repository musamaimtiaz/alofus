<?php

namespace App\Http\Requests\Auth;

use App\Rules\CheckValidEmail;
use Illuminate\Foundation\Http\FormRequest;

class ResendUserVerificationCodeRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'email' => ['required', 'max:191', new CheckValidEmail()],
            'password' => 'required|string',
        ];
    }
}
