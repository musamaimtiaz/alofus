<?php

namespace Modules\Ticket\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MessageRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $this->size = preference('file_size', 1) * 1000;

        return [
            'thread_id' => 'required|exists:threads,id',
            'inbox_message' => 'required',
            'attach' => 'nullable|mimes:jpg,jpeg,bmp,PNG,png,gif,svg,pdf,doc,docx,xls,xlsx,csv|max:' . $this->size,
        ];
    }

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
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'attach.mimes' => __('Only Image, PDF and Doc files are accepted.'),
            'attach.max' => __('Max file size :x KB.', ['x' => $this->size]),
            'attach.*' => __('Attachment upload error.'),
        ];
    }
}
