<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class CheckValidDate implements Rule
{
    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        return preg_match('/^[0-9]{1,4}[\/\-\.]{1}[0-9A-Za-z]{1,3}[\/\-\.]{1}[0-9]{1,4}$/', $value);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return __('The date must be a valid date.');
    }
}
