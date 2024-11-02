<?php
/**
 * @author TechVillage <support@techvill.org>
 *
 * @contributor Al Mamun <[almamun.techvill@gmail.com]>
 *
 * @created 29-03-2022
 */

namespace Modules\Coupon\Filters;

use App\Filters\Filter;

class CouponFilter extends Filter
{
    /**
     * set the rules of query string
     *
     * @var array
     */
    protected $filterRules = [
        'status' => 'in:Active,Inactive,Expired',
    ];

    /**
     * filter status  query string
     *
     * @param  string  $status
     * @return query builder
     */
    public function status($status)
    {
        return $this->query->where('status', $status);
    }

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
                $query->WhereLike('name', $value)
                    ->OrWhereLike('code', $value)
                    ->OrWhereLike('discount_type', $value)
                    ->OrWhereLike('discount_amount', $value)
                    ->OrWhereLike('status', $value);
            });
        }
    }
}
