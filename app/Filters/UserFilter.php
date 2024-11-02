<?php
/**
 * @author TechVillage <support@techvill.org>
 *
 * @contributor AH Millat <[millat.techvill@gmail.com]>
 *
 * @created 24-03-2022
 */

namespace App\Filters;

class UserFilter extends Filter
{
    /**
     * set the rules of query string
     *
     * @var array
     */
    protected $filterRules = [
        'status' => 'in:Active,Inactive,Pending,Deleted',
        'role' => 'int',
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
     * filter by role query string
     *
     * @param  int  $id
     * @return void
     */
    public function role($id)
    {
        return $this->query->whereHas('roleUser', function ($query) use ($id) {
            $query->where('role_id', $id);
        });
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
            $query->whereLike('name', $value)
                ->OrWhereLike('email', $value)
                ->OrWhereLike('created_at', $value)
                ->OrWhereLike('status', $value);
        });
    }
}
