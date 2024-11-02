<?php
/**
 * @author TechVillage <support@techvill.org>
 *
 * @contributor Al Mamun <[almamun.techvill@gmail.com]>
 *
 * @created 29-03-2022
 */

namespace App\Filters;

class VendorFilter extends Filter
{
    /**
     * set the rules of query string
     *
     * @var array
     */
    protected $filterRules = [
        'status' => 'in:Active,Inactive,Pending',
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

        return $this->query->where(function ($query) use ($value) {
            $query->whereLike('vendors.name', $value)
                ->OrWhereLike('vendors.email', $value)
                ->OrWhereLike('vendors.phone', $value)
                ->OrWhereLike('vendors.status', $value)
                ->orWhereHas('userList', function ($q) use ($value) {
                    $q->whereLike('name', $value);
                });
        });
    }
}
