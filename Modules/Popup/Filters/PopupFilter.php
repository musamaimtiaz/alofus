<?php
/**
 * @author TechVillage <support@techvill.org>
 *
 * @contributor Al Mamun <[almamun.techvill@gmail.com]>
 *
 * @created 29-03-2022
 */

namespace Modules\Popup\Filters;

use App\Filters\Filter;

class PopupFilter extends Filter
{
    /**
     * set the rules of query string
     *
     * @var array
     */
    protected $filterRules = [
        'status' => 'in:Active,Inactive',
        'login_enabled' => 'bool',
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
     * filter by login required  query string
     *
     * @param  int  $isLogin
     * @return query builder
     */
    public function loginEnabled($isLogin)
    {
        return $this->query->where('login_enabled', $isLogin);
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
            $query->whereLike('name', $value);
        });
    }
}
