<?php
/**
 * @author TechVillage <support@techvill.org>
 *
 * @contributor AH Millat <[millat.techvill@gmail.com]>
 *
 * @created 24-03-2022
 */

namespace App\Filters;

class ThreadFilter extends Filter
{
    /**
     * set the rules of query string
     *
     * @var array
     */
    protected $filterRules = [
        'status' => 'int',
        'assignee' => 'int',
        'department' => 'int',
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
        return $this->query->where('thread_status_id', $status);
    }

    /**
     * filter by assignee query string
     *
     * @param  int  $id
     * @return void
     */
    public function assignee($assignee)
    {
        return $this->query->where('assigned_member_id', $assignee);
    }

    /**
     * filter department  query string
     *
     * @param  string  $status
     * @return query builder
     */
    public function department($department)
    {
        return $this->query->where('department_id', $department);
    }

    /**
     * @return void
     */
    public function startDate($startDate)
    {
        if ($startDate != 'null') {
            return $this->query->whereDate('date', '>=', DbDateFormat($startDate));
        }
    }

    /**
     * @return void
     */
    public function endDate($endDate)
    {
        if ($endDate != 'null') {
            return $this->query->whereDate('date', '<=', DbDateFormat($endDate));
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

        return $this->query->where(function ($query) use ($value) {
            $query->whereLike('subject', $value)
                ->orWhereHas('assignedMember', function ($q) use ($value) {
                    $q->whereLike('name', $value);
                })->orWhereHas('department', function ($q) use ($value) {
                    $q->whereLike('name', $value);
                })->orWhereHas('vendor', function ($q) use ($value) {
                    $q->whereLike('name', $value);
                });
        });
    }
}
