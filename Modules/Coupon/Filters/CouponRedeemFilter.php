<?php
/**
 * @author TechVillage <support@techvill.org>
 *
 * @contributor Al Mamun <[almamun.techvill@gmail.com]>
 *
 * @created 08-02-2023
 */

namespace Modules\Coupon\Filters;

use App\Filters\Filter;

class CouponRedeemFilter extends Filter
{
    /**
     * filter by search query string
     *
     * @param  string  $value
     * @return query builder
     */
    public function search($value)
    {
        $value = xss_clean($value['value']);
        if (! empty($value)) {
            return $this->query->where(function ($query) use ($value) {
                $query->WhereLike('coupon_code', $value)
                    ->orWhereLike('user_name', $value)
                    ->orWhereLike('order_code', $value)
                    ->orWhereLike('discount_amount', $value);
            });
        }
    }
}
