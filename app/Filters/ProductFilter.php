<?php

/**
 * @author TechVillage <support@techvill.org>
 *
 * @contributor AH Millat <[millat.techvill@gmail.com]>
 *
 * @created 24-03-2022
 */

namespace App\Filters;

use App\Models\Product;

class ProductFilter extends Filter
{
    /**
     * set the rules of query string
     *
     * @var array
     */
    protected $filterRules = [
        'status' => 'in:Published,Draft,Pending Review',
        'brand' => 'int',
        'category' => 'int',
        'vendor' => 'int',
        'stock' => 'in:outofstock,instock,backorder',
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
     * filter by brand  query string
     *
     * @param  int  $id
     * @return query builder
     */
    public function brand($id)
    {
        return $this->query->whereHas('brand', function ($query) use ($id) {
            $query->where('id', $id);
        });
    }

    /**
     * filter by vendor  query string
     *
     * @param  int  $id
     * @return query builder
     */
    public function vendor($id)
    {
        return $this->query->whereHas('vendor', function ($query) use ($id) {
            $query->where('id', $id);
        });
    }

    /**
     * filter by category  query string
     *
     * @param  int  $id
     * @return query builder
     */
    public function category($id)
    {
        return $this->query->whereHas('category', function ($query) use ($id) {
            $query->where('category_id', $id);
        });
    }

    /**
     * Filter by stock query string
     *
     * @param  string  $status
     * @return query builder
     */
    public function stock($status)
    {
        $inStock = (int) ($status == 'instock');

        $onBackOrder = (int) ($status == 'backorder');

        if ($inStock) {

            return $this->queryInStockProducts();
        } elseif ($onBackOrder) {

            return $this->queryOnBackOrderProducts();
        }

        return $this->queryOutOfStockProducts();
    }

    /**
     * search product type
     *
     * @return mixed
     */
    public function type($type)
    {
        return $this->query->where('type', $type);
    }

    /**
     * check product other types
     *
     * @return mixed
     */
    public function subType($key)
    {
        if (request()->type == \App\Enums\ProductType::$Variable) {
            $variationProduct = Product::where('type', 'Variation')->whereHas('metadata', function ($query) use ($key) {
                $query->where('key', $key)->where('value', 1);
            })->pluck('parent_id')->toArray();

            return $this->query->whereIn('id', $variationProduct);
        } else {
            return $this->query->whereHas('metadata', function ($query) use ($key) {
                $query->where('key', $key)->where('value', 1);
            });
        }
    }

    /**
     * filter by search  query string
     *
     * @param  string  $value
     * @return query builder
     */
    public function search($value)
    {
        $value = xss_clean($value['value']);

        return $this->query->where(function ($query) use ($value) {
            $query->WhereLike('name', $value)
                ->OrWhereLike('code', $value)
                ->OrWhereLike('sku', $value)
                ->OrWhereLike('status', $value)
                ->OrWhereLike('regular_price', $value)
                ->OrWhereLike('type', $value)
                ->orWhereHas('category', function ($query) use ($value) {
                    $query->WhereLike('name', $value);
                })
                ->orWhereHas('brand', function ($query) use ($value) {
                    $query->WhereLike('name', $value);
                })
                ->orWhereHas('vendor', function ($query) use ($value) {
                    $query->WhereLike('name', $value);
                });
        });
    }

    /**
     * filter by order  query string
     *
     * @param  string  $value
     * @return query builder
     */
    public function order($value)
    {
        if ($value[0]['dir'] == 'asc' || $value[0]['dir'] == 'desc') {
            return $this->query->with(['brand', 'ProductCategory', 'vendor']);
        }

        return $this->query->orderBy('id', 'DESC')->with(['brand', 'ProductCategory', 'vendor']);
    }

    /**
     * Filter Parent
     *
     * @return query builder
     */
    public function filterParent()
    {
        return $this->query->where('parent_id', null);
    }

    /**
     * Filter Code
     *
     * @return query builder
     */
    public function filterCode()
    {
        return $this->query->where('code', '!=', null);
    }

    /**
     * Attach In stock filter query
     *
     * @return query builder
     */
    private function queryInStockProducts()
    {

        return $this->query->where(function ($query) {

            $query->where(function ($query) {

                $query->where('manage_stocks', 1)
                    ->where('total_stocks', '>', 0);
            })->orWhere(function ($subQuery) {

                $subQuery->where('manage_stocks', 0)

                    ->where(function ($query) {
                        $query->whereHas('metaData', function ($metaQuery) {

                            $metaQuery->where('key', 'meta_stock_status')

                                ->where('value', 'In Stock');
                        })
                            ->orWhereDoesntHave('metaData', function ($metaQuery) {

                                $metaQuery->where('key', 'meta_stock_status');
                            });
                    });
            });
        });
    }

    /**
     * Attach on backorder filter query
     *
     * @return query builder
     */
    private function queryOnBackOrderProducts()
    {

        return $this->query->where(function ($query) {

            $query->where(function ($subQuery) {

                $subQuery->where('manage_stocks', 1)

                    ->where('total_stocks', '<', 1)

                    ->whereHas('metaData', function ($metaQuery) {

                        $metaQuery->where('key', 'meta_backorder')
                            ->where('value', '1');
                    });
            })->orWhere(function ($subQuery) {

                $subQuery->where('manage_stocks', 0)

                    ->whereHas('metaData', function ($metaQuery) {

                        $metaQuery->where('key', 'meta_stock_status')
                            ->where('value', 'On Backorder');
                    });
            });
        });
    }

    /**
     * Attach out of stock filter query
     *
     * @return query builder
     */
    private function queryOutOfStockProducts()
    {

        return $this->query->where(function ($query) {

            $query->where(function ($subQuery) {

                $subQuery->where('manage_stocks', 1)

                    ->where('total_stocks', '<', 1)

                    ->whereDoesntHave('metaData', function ($metaQuery) {

                        $metaQuery->where('key', 'meta_backorder')
                            ->where('value', '1');
                    });
            })->orWhere(function ($subQuery) {

                $subQuery->where('manage_stocks', 0)

                    ->whereHas('metaData', function ($metaQuery) {

                        $metaQuery->where('key', 'meta_stock_status')
                            ->where('value', 'Out Of Stock');
                    });
            });
        });
    }
}
