<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class CheckValidEmail implements Rule
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
        return preg_match('/^[A-Za-z0-9]+((\.[_A-Za-z0-9-]+)|(\_[.A-Za-z0-9-]+)|(\-[.A-Za-z0-9_]+))*@[A-Za-z0-9-]+(\.[A-Za-z0-9-]+)*(\.[A-Za-z]{2,})$/', $value);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return __('The email must be a valid email address.');
    }
}
