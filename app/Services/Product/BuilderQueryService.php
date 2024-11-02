<?php

/**
 * @author TechVillage <support@techvill.org>
 *
 * @contributor Md Abdur Rahaman Zihad <[zihad.techvill@gmail.com]>
 *
 * @created 26-10-2022
 */

namespace App\Services\Product;

use App\Filters\HomePageProductFilter;
use App\Models\Product;

class BuilderQueryService
{
    /**
     * @var array
     */
    protected $queryArray;

    /**
     * @var Builder
     */
    protected $query;

    /**
     * @var array
     */
    protected $filterable = ['brand', 'createdAt', 'vendor', 'featured', 'category', 'tag', 'price', 'name'];

    /**
     * @var array
     */
    protected $queryOperations = [
        'is' => 'where',
        'not' => 'whereNot',
        'in' => 'whereIn',
        'notIn' => 'whereNotIn',
        'greaterThanEqual' => '>=',
        'lessThanEqual' => '<=',
        'equal' => '=',
        'has' => 'whereLike',
    ];

    /**
     * Construct query builder service
     *
     * @param  int  $limit
     * @param  array  $queries
     * @return void
     */
    public function __construct($limit, $queries)
    {
        $this->queryArray = $queries;
        $this->limit = $limit;
        $this->query = Product::query()->isAvailable()->notVariation()->published()->filter(HomePageProductFilter::class);
    }

    /**
     * Get products from query
     *
     * @return Collection|null
     */
    public function get()
    {
        foreach ($this->queryArray as $query) {
            if (isset($query['column']) && in_array($query['column'], $this->filterable) && isset($query['type']) && (isset($query['value']) || isset($query['order']))) {
                try {
                    if ($query['type'] == 'orderBy') {

                        $this->{$query['column'] . 'OrderBy'}($query['order']);
                    } else {
                        $this->{$query['column']}($query);
                    }
                } catch (\Throwable $th) {
                    // Skip the query if face any exception
                }
            }
        }

        return $this->query->limit($this->limit)->get();
    }

    /**
     * Filter by brand column
     *
     * @param  array  $condition
     * @return void
     */
    private function brand($condition)
    {
        $array = $this->processQueryData($condition);

        extract($array);

        $this->query->$function(function ($query) use ($searchables, $operation) {
            $query->$operation('brand_id', $searchables);
        });
    }

    /**
     * Filter by brand column
     *
     * @param  array  $condition
     * @return void
     */
    private function tag($condition)
    {
        $ids = $condition['value'];

        if ($condition['operation'] == 'notIn') {
            $operation = 'whereNotIn';
        } else {
            $operation = 'whereIn';
        }

        if ($condition['type'] == 'orWhere') {
            $function = 'orWhereHas';
        } else {
            $function = 'whereHas';
        }

        $ids = is_array($ids) ? $ids : [$ids];

        $this->query->$function('tags', function ($query) use ($ids, $operation) {
            $query->$operation('tag_id', $ids);
        });
    }

    /**
     * Filter by vendor column
     *
     * @param  array  $condition
     * @return void
     */
    private function vendor($condition)
    {
        $array = $this->processQueryData($condition);

        extract($array);

        $this->query->$function(function ($query) use ($searchables, $operation) {
            $query->$operation('vendor_id', $searchables);
        });
    }

    /**
     * Order by name column
     *
     * @param  string  $order  asc|desc
     * @return void
     */
    private function nameOrderBy($order)
    {
        $this->query->orderBy('name', $order);
    }

    /**
     * Order by featured column
     *
     * @param  string  $order  asc|desc
     * @return void
     */
    private function featuredOrderBy($order)
    {
        $this->query->whereNotNull('featured')->orderBy('featured', $order);
    }

    /**
     * Order by created_at column
     *
     * @param  string  $order  asc|desc
     * @return void
     */
    private function createdAtOrderBy($order)
    {
        $this->query->orderBy('created_at', $order);
    }

    /**
     * Order by created_at column
     *
     * @param  string  $order  asc|desc
     * @return void
     */
    private function priceOrderBy($order)
    {
        $this->query->orderBy('regular_price', $order);
    }

    /**
     * Filter created_at column
     *
     * @param  array  $condition
     * @return void
     */
    private function createdAt($condition)
    {
        $array = $this->processQueryData($condition);

        extract($array);

        $this->query->$function(function ($query) use ($searchables, $operation) {
            $query->where('products.created_at', $operation, $searchables);
        });
    }

    /**
     * Process query data
     *
     * @param  array  $condition
     * @return array
     */
    private function processQueryData($condition)
    {
        $function = $condition['type'] ?? 'where';

        $searchables = $condition['value'];

        $operation = isset($condition['operation']) ? $condition['operation'] : (! is_array($searchables) ? 'is' : 'in');

        $operation = $this->queryFunctionName($operation);

        return [
            'searchables' => $searchables,
            'operation' => $operation,
            'function' => $function,
        ];
    }

    /**
     * Filter category column
     *
     * @param  array  $condition
     * @return void
     */
    private function category($condition)
    {
        $ids = $condition['value'];

        if ($condition['operation'] == 'notIn') {
            $operation = 'whereNotIn';
        } else {
            $operation = 'whereIn';
        }

        if ($condition['type'] == 'orWhere') {
            $function = 'orWhereHas';
        } else {
            $function = 'whereHas';
        }

        $ids = is_array($ids) ? $ids : [$ids];

        $this->query->$function('category', function ($query) use ($ids, $operation) {
            $query->$operation('category_id', $ids);
        });
    }

    /**
     * Filter featured column
     *
     * @param  array  $condition
     * @return void
     */
    private function featured($condition)
    {
        if (! isset($condition['type']) || ! isset($condition['value'])) {
            return;
        }

        $array = $this->processQueryData($condition);

        extract($array);

        $featured = $condition['value'];

        $operation = $featured == 1 ? '!=' : '=';

        $featured == null;

        $this->query->$function(function ($query) use ($featured, $operation) {
            $query->where('featured', $operation, $featured);
        });
    }

    /**
     * Get query operation name
     *
     * @param  array  $query
     * @return string
     */
    private function queryOperation($query)
    {
        return $this->queryFunctionName($query['type'] ?? 'is');
    }

    /**
     * Get query function name
     *
     * @param  string  $name
     * @return string
     */
    private function queryFunctionName($name)
    {
        return isset($this->queryOperations[$name]) ? $this->queryOperations[$name] : 'where';
    }
}
