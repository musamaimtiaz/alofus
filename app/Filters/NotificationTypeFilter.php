<?php

namespace App\Filters;

use Closure;

class NotificationTypeFilter
{
    /**
     * Handle the incoming request for filtering by notification type (read/unread).
     *
     * @param  mixed  $query
     * @return mixed
     */
    public function handle($query, Closure $next)
    {
        if (request()->filled('filter_type')) {
            $filterType = request('filter_type');

            $this->applyTypeFilter($query, $filterType);
        }

        return $next($query);
    }

    /**
     * Apply the specified type filter to the query.
     *
     * @param  mixed  $query
     * @param  string  $filterType
     * @return void
     */
    protected function applyTypeFilter($query, $filterType)
    {
        $filterMappings = [
            'read' => 'whereNotNull',
            'unread' => 'whereNull',
        ];

        if (array_key_exists($filterType, $filterMappings)) {
            $query->{$filterMappings[$filterType]}('read_at');
        }
    }
}
