<?php

namespace Modules\FormBuilder\Filters;

use App\Filters\Filter;

class FormFilter extends Filter
{
    /**
     * set the rules of query string
     *
     * @var array
     */
    protected $filterRules = [
        'visibility' => 'required',
    ];

    /**
     * filter visibility  query string
     *
     * @param  string  $visibility
     * @return query builder
     */
    public function visibility($visibility)
    {
        return $this->query->where('visibility', $visibility);
    }

    /**
     * filter type  query string
     *
     * @param  string  $type
     * @return query builder
     */
    public function type($type)
    {
        return $this->query->where('type', $type);
    }
}
