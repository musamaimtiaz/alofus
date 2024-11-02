<?php

/**
 * @author TechVillage <support@techvill.org>
 *
 * @contributor Md Abdur Rahaman Zihad <[zihad.techvill@gmail.com]>
 *
 * @created 17-09-2022
 */

namespace App\Services;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Query\Builder as QueryBuilder;

abstract class CategorizationService
{
    protected $limit = 10;

    protected $query = null;

    protected $fields = ['*'];

    protected $startDate = null;

    protected $endDate = null;

    protected $paginator = null;

    protected $fetchMeta = false;

    protected $metaFetched = false;

    protected $useCache = true;

    protected $data = null;

    protected $method = null;

    /**
     * @var int
     *          Default value 6 hours
     */
    protected $cacheDuration = 21600;

    public function __construct($query = null, $withMeta = false)
    {
        $this->initialize($query, $withMeta);
    }

    abstract protected function initialize($query, $withMeta);

    /**
     * Get stats table name
     *
     * @return string
     */
    abstract protected function getStatsTable();

    /**
     * Set limit for result
     *
     * @param  int  $limit
     * @return self
     */
    public function setLimit($limit)
    {
        $this->limit = $limit;

        return $this;
    }

    /**
     * Provides the final value after implementing service business logic
     *
     * @return mixed
     */
    public function get()
    {
        if ($this->data) {
            return $this->data;
        }

        if ($this->isValidQueryBuilder($this->query)) {
            $result = $this->query->get();
            if ($this->method) {
                $this->setCache($this->method, $result);
            }

            return $result;
        }

        return null;
    }

    protected function isValidQueryBuilder($query)
    {
        return $query instanceof Builder || $query instanceof QueryBuilder;
    }

    protected function isEloquentBuilder($query)
    {
        return $query instanceof Builder;
    }

    /**
     * Returns the build query
     *
     * @return Builder
     */
    public function getQuery()
    {
        if ($this->isValidQueryBuilder($this->query)) {
            if ($this->isMetaRequired() && ! $this->metaFetched() && $this->isEloquentBuilder($this->query)) {
                $this->query->with('metadata');
            }

            return $this->query;
        }

        return null;
    }

    public function limit($limit = null)
    {
        $this->setQuery($this->getQuery()->limit($limit ?? $this->limit));

        return $this;
    }

    /**
     * Sets the query
     *
     * @param  Builder|QueryBuilder  $query
     * @return self|null
     */
    public function setQuery($query)
    {
        if (! $this->isValidQueryBuilder($query)) {
            return null;
        }
        $this->query = $query;

        return $this;
    }

    /**
     * Returns the selectable fields from the database
     *
     * @return array
     */
    public function getSelectFields()
    {
        return $this->fields;
    }

    /**
     * Updates the selectable fields
     *
     * @param array
     * @return self
     */
    public function addSelectFields(array $array = [])
    {
        $this->fields = array_merge($this->fields, $array);

        return $this;
    }

    /**
     * Enables paginate
     *
     * @return self
     */
    public function paginate(array $options = [])
    {
        if (is_null($this->paginator)) {
            if (! $this->hasQuery()) {
                return null;
            }
            $defaults = [
                'row_per_page' => $this->limit,
            ];

            $defaults = array_merge($defaults, $options);

            return $this->getQuery()->paginate($defaults['row_per_page']);
        }

        return $this->paginator->setCollection($this->getQuery()->get());
    }

    protected function hasQuery()
    {
        return ! is_null($this->query);
    }

    /**
     * Replace the selectable fields with the new one
     *
     * @param  array  $array
     */
    public function selectOnly($array = ['*'])
    {
        $this->fields = $array;

        return $this;
    }

    /**
     * Checks if the start date is set for checking time period
     *
     * @return bool
     */
    protected function hasStartDate()
    {
        return ! is_null($this->startDate);
    }

    public function getStartDate()
    {
        return $this->hasStartDate() ? $this->startDate : $this->defaultStartDate();
    }

    /**
     * Checks if the end date is set for checking time period
     *
     * @return bool
     */
    protected function hasEndDate()
    {
        return ! is_null($this->endDate);
    }

    public function getEndDate()
    {
        return $this->hasEndDate() ? $this->endDate : $this->defaultEndDate();
    }

    public function setStartDate($date)
    {
        $this->startDate = $date;

        return $this;
    }

    public function setEndDate($date)
    {
        $this->endDate = $date;

        return $this;
    }

    public function defaultStartDate()
    {
        return now()->subDay(30)->toDateString();
    }

    public function defaultEndDate()
    {
        return now()->toDateString();
    }

    protected function isMetaRequired()
    {
        return $this->fetchMeta;
    }

    protected function metaFetched()
    {
        return $this->metaFetched;
    }

    public function withMeta($withMeta = true)
    {
        $this->fetchMeta = $withMeta;

        return $this;
    }

    /**
     * Get result from cache
     *
     * @param  string  $name  Cache key
     * @return mixed
     */
    protected function getFromCache($name = '')
    {
        return cache(config('cache.prefix') . $name);
    }

    /**
     * Set data to cache
     *
     * @param  string  $method  Cache key
     * @return void
     */
    protected function setCache($method, $data)
    {
        cache([config('cache.prefix') . $method => $data], $this->cacheDuration);
    }

    /**
     * Set flag for not fetching data form cache
     *
     * @return self
     */
    public function noCache()
    {
        $this->useCache = false;

        return $this;
    }
}
