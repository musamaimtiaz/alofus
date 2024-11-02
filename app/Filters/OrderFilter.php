<?php

namespace App\Filters;

class OrderFilter extends Filter
{
    /**
     * set the rules of query string
     *
     * @var array
     */
    protected $filterRules = [
        'order_status_id' => 'required',
        'vendor_id' => 'required',
        'start_date' => 'required',
        'end_date' => 'required',
        'payment_status' => 'required',
    ];

    /**
     * filter status  query string
     *
     * @param  string  $status
     * @return query builder
     */
    public function orderStatusId($orderStatusId)
    {
        return $this->query->where('order_status_id', $orderStatusId)
            ->orWhereHas('orderStatus', function ($q) use ($orderStatusId) {
                $q->where('name', $orderStatusId);
            });
    }

    /**
     * filter by payment query string
     *
     * @param  int  $type
     * @return void
     */
    public function paymentStatus($paymentStatus)
    {
        return $this->query->where('payment_status', $paymentStatus);
    }

    /**
     * filter by vendor query string
     *
     * @param  int  $type
     * @return void
     */
    public function vendorId($vendorId)
    {
        return $this->query->whereHas('orderDetails', function ($q) use ($vendorId) {
            $q->where('vendor_id', $vendorId);
        })->with('orderDetails');
    }

    /**
     * @return void
     */
    public function startDate($startDate)
    {
        if ($startDate != 'null') {
            return $this->query->where('order_date', '>=', DbDateFormat($startDate));
        }
    }

    /**
     * @return void
     */
    public function endDate($endDate)
    {
        if ($endDate != 'null') {
            return $this->query->where('order_date', '<=', DbDateFormat($endDate));
        }
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
                $query->WhereLike('reference', $value)
                    ->orWhereLike('payment_status', $value)
                    ->orWhereLike('total', $value)
                    ->orwhereHas('user', function ($q) use ($value) {
                        $q->whereLike('name', $value);
                    })->orwhereHas('orderStatus', function ($q) use ($value) {
                        $q->whereLike('name', $value);
                    });
            });
        }
    }
}
