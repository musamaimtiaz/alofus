<?php
/**
 * @author TechVillage <support@techvill.org>
 *
 * @contributor AH Millat <[millat.techvill@gmail.com]>
 *
 * @created 24-03-2022
 */

namespace App\Filters;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use ReflectionMethod;

abstract class Filter
{
    /**
     * request
     *
     * @var object
     */
    protected $request;

    /**
     * The query builder.
     *
     * @var [type]
     */
    protected $query;

    /**
     * set the filter rules like Validation
     *
     * @var array
     */
    protected $filterRules = [];

    /**
     * is request filterable
     *
     * @var bool
     */
    protected $requestFilterable = true;

    /**
     * Retrieve the request
     *
     * @return \Illuminate\Http\Request
     */
    public function getRequest()
    {
        if (! isset($this->request)) {
            $this->request = Request::instance();
        }

        return $this->request;
    }

    /**
     * Apply filters based on query parameters.
     *
     * @return Builder $query
     */
    public function apply(Builder $query)
    {
        $this->query = $query;

        $fullClassName = get_class($this);

        apply_filters("before_{$fullClassName}", $this->query);

        $this->runFilterMethods();

        if (! $this->requestFilterable) {
            return $query;
        }

        foreach ($this->getRequest()->all() as $filter => $value) {
            if ($this->isApplicable($filter, $value)) {
                call_user_func([$this, Str::camel($filter)], $value);
            }
        }

        apply_filters("after_{$fullClassName}", $this->query);

        return $query;
    }

    /**
     * applied the filter
     *
     * @param  string  $filter
     * @param  mixed  $value
     * @return bool
     */
    protected function isApplicable($filter, $value)
    {
        if (! method_exists($this, Str::camel($filter))) {
            return false;
        }

        if ($value !== '' && ! is_null($value)) {
            return ! Validator::make($this->getRequest()->only($filter), Arr::only($this->filterRules, $filter))->fails();
        }

        return (new ReflectionMethod($this, Str::camel($filter)))->getNumberOfParameters() === 0;
    }

    /**
     * execute filter method
     *
     * @return void
     */
    protected function runFilterMethods()
    {
        foreach (get_class_methods($this) as $method) {
            if (Str::startsWith($method, ['filter'])) {
                $this->{$method}();
            }
        }
    }
}
