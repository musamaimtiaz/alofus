<?php

namespace App\Http\Requests\Admin;

use App\Rules\CheckValidEmail;
use App\Rules\CheckValidFile;
use App\Rules\CheckValidPhone;
use App\Rules\StrengthPassword;
use Illuminate\Foundation\Http\FormRequest;

class StoreUserRequest extends FormRequest
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

    private function sendMail()
    {
        return isset($this->send_mail) && strtolower($this->send_mail) == 'on' ? 'on' : false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required|min:3',
            'email' => ['required', 'unique:users,email', new CheckValidEmail()],
            'phone' => ['required', 'min:7', 'max:15', 'unique:users,phone', new CheckValidPhone()],
            'password' => ['required', new StrengthPassword()],
            'status' => 'required|in:Pending,Active,Inactive,Deleted',
            'role_ids' => 'required',
            'send_mail' => 'in:' . $this->sendMail(),
            'attachment'  => [new CheckValidFile(getFileExtensions(2))],
        ];
    }

    /**
     * Prepare the data for validation.
     */
    protected function prepareForValidation(): void
    {
        $this->merge([
            'phone' => $this->dial_code . $this->phone,
        ]);
    }
}
