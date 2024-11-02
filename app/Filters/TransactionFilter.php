<?php
/**
 * @author TechVillage <support@techvill.org>
 *
 * @contributor AH Millat <[millat.techvill@gmail.com]>
 *
 * @created 24-03-2022
 */

namespace App\Filters;

class TransactionFilter extends Filter
{
    /**
     * set the rules of query string
     *
     * @var array
     */
    protected $filterRules = [
        'status' => 'in:Accepted,Rejected,Pending',
        'transaction_type' => 'required',
        'user_id' => 'required',
        'start_date' => 'required',
        'end_date' => 'required',
    ];

    /**
     * filter status  query string
     *
     * @param  string  $status
     * @return query builder
     */
    public function status($status)
    {
        return $this->query->where('transactions.status', $status);
    }

    /**
     * filter by role query string
     *
     * @param  int  $type
     * @return query builder
     */
    public function transactionType($type)
    {
        return $this->query->where('transactions.transaction_type', $type);
    }

    /**
     * filter by role query string
     *
     * @param  int  $type
     * @return query builder
     */
    public function userId($userId)
    {
        return $this->query->where('transactions.user_id', $userId);
    }

    /**
     * filter by start date
     *
     * @param  string  $startDate
     * @return query builder
     */
    public function startDate($startDate)
    {
        if ($startDate != 'null') {
            return $this->query->where('transactions.transaction_date', '>=', DbDateFormat($startDate));
        }
    }

    /**
     * filter by end date
     *
     * @param  string  $endDate
     * @return query builder
     */
    public function endDate($endDate)
    {
        if ($endDate != 'null') {
            return $this->query->where('transactions.transaction_date', '<=', DbDateFormat($endDate));
        }
    }

    /**
     * filter by Vendor Id
     *
     * @param  int  $vendorId
     * @return query builder
     */
    public function vendorId($vendorId)
    {
        return $this->query->where('transactions.vendor_id', $vendorId);
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
                    ->OrWhereLike('transactions.amount', $value)
                    ->OrWhereLike('transactions.total_amount', $value)
                    ->OrWhereLike('transactions.transaction_type', $value)
                    ->orWhereHas('withdrawalMethod', function ($query) use ($value) {
                        $query->WhereLike('method_name', $value);
                    })
                    ->orWhereHas('currency', function ($query) use ($value) {
                        $query->WhereLike('currencies.name', $value);
                    })
                    ->orWhereHas('user', function ($query) use ($value) {
                        $query->where('users.name', 'like', '%' . $value . '%');
                    })->orWhereHas('order', function ($query) use ($value) {
                        $query->whereLike('reference', $value);
                    })->orWhereHas('vendor', function ($query) use ($value) {
                        $query->whereLike('name', $value);
                    });
            });
        }
    }
}
