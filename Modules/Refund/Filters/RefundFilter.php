<?php
/**
 * @author TechVillage <support@techvill.org>
 *
 * @contributor Al Mamun <[almamun.techvill@gmail.com]>
 *
 * @created 29-03-2022
 */

namespace Modules\Refund\Filters;

use App\Filters\Filter;

class RefundFilter extends Filter
{
    /**
     * set the rules of query string
     *
     * @var array
     */
    protected $filterRules = [
        'status' => 'in:Opened,In progress,Declined,Accepted',
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
                $query->WhereLike('shipping_method', $value)
                    ->OrWhereLike('refund_method', $value)
                    ->OrWhere('quantity_sent', $value)
                    ->OrWhereLike('status', $value)
                    ->orWhereHas('orderDetail', function ($query) use ($value) {
                        $query->WhereLike('price', $value);
                    })
                    ->orWhereHas('refundReason', function ($query) use ($value) {
                        $query->WhereLike('name', $value);
                    });
            });
        }

    }
}
