<?php
/**
 * @author TechVillage <support@techvill.org>
 *
 * @contributor Al Mamun <[almamun.techvill@gmail.com]>
 *
 * @created 21-11-2021
 */

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class DateCompare implements Rule
{
    protected $startDate;

    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct($startDate)
    {
        $this->startDate = $startDate;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        return strtotime($this->startDate) <= strtotime($value);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return __('The :attribute must be greater than or equal to start date.');
    }
}
