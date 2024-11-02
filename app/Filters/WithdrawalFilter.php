<?php
/**
 * @author TechVillage <support@techvill.org>
 *
 * @contributor AH Millat <[millat.techvill@gmail.com]>
 *
 * @created 24-03-2022
 */

namespace App\Filters;

class WithdrawalFilter extends Filter
{
    /**
     * set the rules of query string
     *
     * @var array
     */
    protected $filterRules = [
        'status' => 'in:Accepted,Rejected,Pending',
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
                $query->WhereLike('transactions.status', $value)
                    ->OrWhereLike('amount', $value)
                    ->OrWhereLike('total_amount', $value)
                    ->orWhereHas('withdrawalMethod', function ($query) use ($value) {
                        $query->WhereLike('method_name', $value);
                    })
                    ->orWhereHas('currency', function ($query) use ($value) {
                        $query->WhereLike('currencies.name', $value);
                    })
                    ->orWhereHas('user', function ($query) use ($value) {
                        $query->where('users.name', 'like', '%' . $value . '%');
                    });
            });
        }
    }
}
