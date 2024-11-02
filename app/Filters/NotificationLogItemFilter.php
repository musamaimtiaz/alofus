<?php
/**
 * @author TechVillage <support@techvill.org>
 *
 * @contributor Al Mamun <[almamun.techvill@gmail.com]>
 *
 * @created 03-03-2024
 */

namespace App\Filters;

class NotificationLogItemFilter extends Filter
{
    /**
     * set the rules of query string
     *
     * @var array
     */
    protected $filterRules = [];

    /**
     * filter read at  query string
     *
     * @param  string  $readStatus
     * @return query builder
     */
    public function users($id)
    {
        return $this->query->where('notifiable_id', $id);
    }

    /**
     * filter notification type at  query string
     *
     * @param  string  $key
     * @return query builder
     */
    public function types($key)
    {
        return $this->query->where('notification_type', $key);
    }

    /**
     * filter notification channel at  query string
     *
     * @param  string  $key
     * @return query builder
     */
    public function channels($key)
    {
        return $this->query->where('channel', $key);
    }
}
