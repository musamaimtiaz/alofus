<?php

namespace Modules\Ticket\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AdminTicketRequest extends FormRequest
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
            'message' => 'required',
            'assign_id' => 'required',
            'subject' => 'required|max:191',
            'receiver_id' => 'required',
            'department_id' => 'required',
            'email' => 'required|email',
            'priority_id' => 'required',
            'object_type' => 'required',
        ];
    }
}
