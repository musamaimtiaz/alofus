<?php

namespace App\Filters;

class ProductVariationSearchFilter extends Filter
{
    /**
     * set the rules of query string
     *
     * @var array
     */
    protected $filterRules = [
        'brands' => 'string',
        'categories' => 'string',
        'rating' => 'int',
        'keyword' => 'string',
    ];

    /**
     * filter using price range
     *
     * @param  mixed  $value
     * @return void
     */
    public function priceRange($value)
    {
        $priceRange = explode(',', xss_clean($value));

        if (isset($priceRange[0])) {
            $min = $priceRange[0];
            $this->query->where('regular_price', '>=', $min);
        }

        if (isset($priceRange[1])) {
            $max = $priceRange[1];
            $this->query->where('regular_price', '<=', $max);
        }

        return $this->query;
    }

    /**
     * filter using sort by
     *
     * @return mixed
     */
    public function sortBy($value)
    {
        if ($value == 'Price High to Low') {
            return $this->query->orderBy('regular_price', 'DESC');
        } elseif ($value == 'Avg. Ratting') {
            return $this->query->orderBy('review_average', 'DESC');
        } else {
            return $this->query->orderBy('regular_price', 'ASC');
        }
    }

    public function b2b($value)
    {
        return $this->query->whereHas('metadata', function ($query) use ($value) {
            $query->where('key', 'meta_enable_b2b')->where('value', $value);
        });
    }

    /**
     * filter by keyword  query string
     *
     * @param  string  $value
     * @return query builder
     */
    public function keyword($value)
    {
        $value = xss_clean($value);

        return $this->query->where(function ($query) use ($value) {
            $query->WhereLike('name', $value);
        });
    }
}
