<?php
/**
 * @author TechVillage <support@techvill.org>
 *
 * @contributor Al Mamun <[almamun.techvill@gmail.com]>
 *
 * @created 18-01-2024
 */

namespace App\Filters;

class DatabaseNotificationFilter extends Filter
{
    /**
     * set the rules of query string
     *
     * @var array
     */
    protected $filterRules = [
        'read_at' => 'in:Read,Unread',
    ];

    /**
     * filter read at  query string
     *
     * @param  string  $readStatus
     * @return query builder
     */
    public function readAt($readStatus)
    {
        if ($readStatus == 'unread') {
            return $this->query->whereNull('read_at');
        }

        return $this->query->whereNotNull('read_at');
    }

    /**
     * filter by search query string
     *
     * @param  string  $value
     * @return query builder
     */
    public function search($value)
    {
        $value = $value['value'];

        return $this->query->where(function ($query) use ($value) {
            $query->whereLike('data', $value);
        });
    }
}
