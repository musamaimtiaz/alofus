<?php

/**
 * @author TechVillage <support@techvill.org>
 *
 * @contributor Md Abdur Rahaman Zihad <[zihad.techvill@gmail.com]>
 *
 * @created 26-09-2022
 */

namespace App\Services\Brand;

use App\Models\Brand;
use App\Services\CategorizationService;
use Illuminate\Support\Facades\DB;

class BrandCategorizingService extends CategorizationService
{
    protected $fields = ['id', 'name'];

    protected $method = null;

    protected $useCache = true;

    protected $data = null;

    /**
     * 1 day duration
     */
    protected $cacheDuration = 86400;

    /**
     * Initializes the service
     *
     * @return void
     */
    protected function initialize($query, $withMeta)
    {
        $this->setQuery($query ?? Brand::query());
    }

    /**
     * Popular brands
     *
     * @return self
     */
    public function popularBrands()
    {
        $this->method = 'popularBrands';

        if ($this->useCache) {

            $brands = $this->getFromCache($this->method);

            if ($brands) {
                $this->data = $brands;

                return $this;
            }
        }

        $brandIds = DB::table($this->getStatsTable())->selectRaw('sum(count_views) as total_views, sum(count_sales) as total_sales, brand_id')
            ->whereBetween('date', [$this->getStartDate(), $this->getEndDate()])
            ->groupBy('brand_id')
            ->orderBy('total_views', 'desc')
            ->orderBy('total_sales', 'desc')
            ->paginate($this->limit);

        $this->paginator = $brandIds;

        $ids = $brandIds->getCollection()->pluck('brand_id')->toArray();

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
     * Best seller brands
     *
     * @return self
     */
    public function bestSellerBrands()
    {
        $this->method = 'bestSellerBrands';

        if ($this->useCache) {

            $brands = $this->getFromCache($this->method);

            if ($brands) {
                $this->data = $brands;

                return $this;
            }
        }

        $brandIds = DB::table('brand_stats')->selectRaw('sum(count_views) as total_views, sum(count_sales) as total_sales, brand_id')
            ->whereBetween('date', [$this->getStartDate(), $this->getEndDate()])
            ->groupBy('brand_id')
            ->orderBy('total_sales', 'desc')
            ->orderBy('total_views', 'desc')
            ->paginate($this->limit);

        $this->paginator = $brandIds;

        $ids = $brandIds->getCollection()->pluck('brand_id')->toArray();

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
     * Random brands
     *
     * @return self
     */
    public function randomBrands()
    {
        $this->query = $this->getQuery()
            ->active()
            ->inRandomOrder()
            ->limit($this->limit);

        return $this;
    }

    /**
     * Selected brands
     *
     * @return self
     */
    public function selectedBrands($ids = [])
    {
        $this->useCache = false;

        $this->query = $this->getQuery()
            ->active()
            ->whereIn('id', $ids)
            ->limit($this->limit)
            ->orderBy(DB::raw('FIELD(id, ' . implode(',', $ids) . ')'));

        return $this;
    }

    /**
     * Get stats table name
     *
     * @return string
     */
    protected function getStatsTable()
    {
        return 'brand_stats';
    }
}
