<?php

namespace Modules\FormBuilder\Filters;

use App\Filters\Filter;

class SubmissionFilter extends Filter
{
    /**
     * set the rules of query string
     *
     * @var array
     */
    protected $filterRules = [
        'visibility' => 'required|numeric',
    ];

    /**
     * filter visibility  query string
     *
     * @param int form
     * @return query builder
     */
    public function form($form)
    {
        return $this->query->where('visibility', $form);
    }
}
