<?php
/**
 * @author TechVillage <support@techvill.org>
 *
 * @contributor Sakawat Hossain Rony <[sakawat.techvill@gmail.com]>
 *
 * @created 17-08-2021
 */

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class CheckDefaultTimeZone implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {

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
        $mergeTimeZone = [];
        foreach (timeZoneList() as $time) {
            $mergeTimeZone[] = $time['zone'];
        }

        return in_array($value, $mergeTimeZone);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return __('The selected :x is invalid.', ['x' => __('Timezone')]);
    }
}
