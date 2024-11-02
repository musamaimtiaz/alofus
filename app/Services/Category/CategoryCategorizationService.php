<?php

/**
 * @author TechVillage <support@techvill.org>
 *
 * @contributor Md Abdur Rahaman Zihad <[zihad.techvill@gmail.com]>
 *
 * @created 15-15-2022
 */

namespace App\Services\Category;

use App\Models\Category;
use App\Services\CategorizationService;
use Illuminate\Support\Facades\DB;

class CategoryCategorizationService extends CategorizationService
{
    protected function initialize($query, $withMeta)
    {
        $this->setQuery($query ?? Category::query());
    }

    protected function getStatsTable()
    {
        return 'category_stats';
    }

    /**
     * Popular categories
     *
     * @return self
     */
    public function popularCategories()
    {
        $this->method = 'popularCategories';

        if ($this->useCache) {

            $categories = $this->getFromCache($this->method);

            if ($categories) {
                $this->data = $categories;

                return $this;
            }
        }

        $categoryIds = DB::table($this->getStatsTable())->selectRaw('sum(count_views) as total_views, sum(count_sales) as total_sales, category_id')
            ->whereBetween('date', [$this->getStartDate(), $this->getEndDate()])
            ->where('category_id', '!=', 1)
            ->groupBy('category_id')
            ->orderBy('total_views', 'desc')
            ->orderBy('total_sales', 'desc')
            ->paginate($this->limit);

        $this->paginator = $categoryIds;

        $ids = $categoryIds->getCollection()->pluck('category_id')->toArray();

        if (! is_array($ids) || count($ids) == 0) {
            $this->query = null;
            $this->paginator = null;

            return $this;
        }

        $this->query = $this->getQuery()
            ->select($this->getSelectFields())
            ->whereIn('id', $ids)
            ->active()
            ->orderBy(DB::raw('FIELD(id, ' . implode(',', $ids) . ')'));

        return $this;
    }

    /**
     * Best seller categories
     *
     * @return self
     */
    public function bestSellerCategories()
    {
        $this->method = 'bestSellerCategories';

        if ($this->useCache) {

            $categories = $this->getFromCache($this->method);

            if ($categories) {
                $this->data = $categories;

                return $this;
            }
        }

        $categoryIds = DB::table($this->getStatsTable())->selectRaw('sum(count_views) as total_views, sum(count_sales) as total_sales, category_id')
            ->whereBetween('date', [$this->getStartDate(), $this->getEndDate()])
            ->where('category_id', '!=', 1)
            ->groupBy('category_id')
            ->orderBy('total_sales', 'desc')
            ->orderBy('total_views', 'desc')
            ->paginate($this->limit);

        $this->paginator = $categoryIds;

        $ids = $categoryIds->getCollection()->pluck('category_id')->toArray();

        if (! is_array($ids) || count($ids) == 0) {
            $this->query = null;
            $this->paginator = null;

            return $this;
        }

        $this->query = $this->getQuery()
            ->select($this->getSelectFields())
            ->whereIn('id', $ids)
            ->active()
            ->orderBy(DB::raw('FIELD(id, ' . implode(',', $ids) . ')'));

        return $this;
    }

    /**
     * Random categories
     *
     * @return self
     */
    public function randomCategories()
    {
        $this->method = 'randomCategories';

        if ($this->useCache) {

            $categories = $this->getFromCache($this->method);

            if ($categories) {
                $this->data = $categories;

                return $this;
            }
        }

        $this->query = $this->getQuery()
            ->active()
            ->inRandomOrder()
            ->limit($this->limit);

        return $this;
    }

    /**
     * Selected categories
     *
     * @return self
     */
    public function selectedCategories($ids = [])
    {
        $this->useCache = false;

        $this->query = $this->getQuery()
            ->active()
            ->whereIn('id', $ids)
            ->limit($this->limit)
            ->orderBy(DB::raw('FIELD(id, ' . implode(',', $ids) . ')'));

        return $this;
    }
}
