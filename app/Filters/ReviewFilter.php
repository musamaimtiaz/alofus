<?php
/**
 * @author TechVillage <support@techvill.org>
 *
 * @contributor AH Millat <[millat.techvill@gmail.com]>
 *
 * @created 24-03-2022
 */

namespace App\Filters;

class ReviewFilter extends Filter
{
    /**
     * set the rules of query string
     *
     * @var array
     */
    protected $filterRules = [
        'status' => 'in:Active,Inactive',
        'is_public' => 'in:0,1',
        'rating' => 'int',
    ];

    /**
     * filter status  query string
     *
     * @param  string  $status
     * @return query builder
     */
    public function status($status)
    {
        return $this->query->where('status', $status);
    }

    /**
     * filter by public query string
     *
     * @param  int  $value
     * @return void
     */
    public function isPublic($value)
    {
        return $this->query->where('is_public', $value);
    }

    /**
     * filter by rating query string
     *
     * @param  int  $value
     * @return void
     */
    public function rating($value)
    {
        return $this->query->where('rating', $value);
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

        if (! empty($value)) {
            return $this->query->where(function ($query) use ($value) {
                $query->WhereLike('comments', $value)
                    ->OrWhere('rating', $value)
                    ->OrWhereLike('status', $value)
                    ->OrWhereHas('product', function ($query) use ($value) {
                        $query->WhereLike('name', $value);
                    })->OrWhereHas('user', function ($query) use ($value) {
                        $query->WhereLike('name', $value);
                    });

                $value = ucfirst(strtolower($value));
                $public = [__('No') => '0', __('Yes') => '1'];
                if (array_key_exists($value, $public)) {
                    $query->OrWhere('is_public', $public[$value]);
                }
            });
        }
    }
}
