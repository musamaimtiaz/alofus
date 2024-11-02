<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class StrengthPassword implements Rule
{
    protected $errorMessage = '';

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        if (env('PASSWORD_STRENGTH') == null && env('PASSWORD_STRENGTH') == '') {
            return true;
        }
        $status = true;
        $length = filter_var(env('PASSWORD_STRENGTH'), FILTER_SANITIZE_NUMBER_INT);
        $conditions = explode('|', env('PASSWORD_STRENGTH'));

        $conditionArr = ['UPPERCASE' => '/[A-Z]/', 'LOWERCASE' => '/[a-z]/', 'NUMBERS' => '/[0-9]/', 'SYMBOLS' => '/[#?!@$%^&*-]/'];

        $tmpMsg = [];
        foreach ($conditions as $condition) {
            if (array_key_exists($condition, $conditionArr)) {
                if (! preg_match($conditionArr[$condition], $value)) {
                    $tmpMsg[] = __(strtolower($condition));
                    $status = false;
                }
            }
        }

        if (! empty($tmpMsg)) {
            $this->errorMessage = __('Password must contain :x', ['x' => implode(', ', $tmpMsg)]) . '.';
        }

        if (! empty($length) && strlen($value) < $length) {
            if (! empty($this->errorMessage)) {
                $this->errorMessage = __('Password must contain :x and :y characters long.', ['x' => implode(', ', $tmpMsg), 'y' => $length]);
            } else {
                $this->errorMessage = __('Password must be at least :x characters.', ['x' => $length]);
            }
            $status = false;
        }

        return $status;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return $this->errorMessage;
    }
}
