<?php
/**
 * @author TechVillage <support@techvill.org>
 *
 * @contributor Soumik Datta <[soumik.techvill@gmail.com]>
 *
 * @created 24-03-2022
 */

namespace App\Filters;

class UserActivityLogFilter extends Filter
{
    /**
     * set the rules of query string
     *
     * @var array
     */
    protected $filterRules = [
        'log_name' => 'in:"USER LOGIN","USER LOGOUT"',
    ];

    /**
     * filter by log_name query string
     *
     * @param  string  $status
     * @return query builder
     */
    public function logName($name)
    {
        return $this->query->where('log_name', $name);
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
            $query->where('description', 'LIKE', '%' . $value . '%')
                ->OrWhere('properties->ip_address', 'LIKE', '%' . $value . '%')
                ->OrWhere('created_at', 'LIKE', '%' . $value . '%');
        });
    }
}
