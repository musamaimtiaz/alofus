<?php

namespace App\Filters;

use Closure;

class NotificationDateFilter
{
    /**
     * Handle the incoming request.
     *
     * @param  mixed  $query
     * @return mixed
     */
    public function handle($query, Closure $next)
    {
        $filters = [
            'today' => today(),
            'last_week' => now()->subWeek(),
            'last_month' => now()->subMonth(),
            'last_year' => now()->subYear(),
        ];

        $filterDay = request('filter_day');

        if ($this->isValidFilterDay($filterDay, $filters)) {
            $query->whereDate('created_at', '>=', $filters[$filterDay]);
        }

        return $next($query);
    }

    /**
     * Check if the requested filter day is valid.
     *
     * @param  string|null  $filterDay
     * @param  array  $filters
     * @return bool
     */
    protected function isValidFilterDay($filterDay, $filters)
    {
        return request()->filled('filter_day') && array_key_exists($filterDay, $filters);
    }
}
