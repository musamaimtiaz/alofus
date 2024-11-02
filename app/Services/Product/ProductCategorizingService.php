<?php

/**
 * @author TechVillage <support@techvill.org>
 *
 * @contributor Md Abdur Rahaman Zihad <[zihad.techvill@gmail.com]>
 *
 * @created 15-09-2022
 */

namespace App\Services\Product;

use App\Filters\HomePageProductFilter;
use App\Models\Product;
use App\Services\CategorizationService;
use Illuminate\Support\Facades\DB;

class ProductCategorizingService extends CategorizationService
{
    protected $fields = ['id', 'slug', 'name', 'code', 'sale_to', 'sale_from', 'regular_price', 'sale_price', 'review_count', 'review_average', 'available_from', 'available_to', 'type', 'shop_id', 'featured', 'manage_stocks', 'total_stocks', 'vendor_id'];

    public function __construct($query = null, $withMeta = false)
    {
        $this->initialize($query, $withMeta);
    }

    /**
     * Bootstrap Categorizing Service for action
     *
     * @return void
     */
    protected function initialize($query, $withMeta)
    {
        $this->setQuery($query ?? Product::query()->filter(HomePageProductFilter::class));
        $this->withMeta($withMeta);
    }

    /**
     * Get stats table name
     *
     * @return string
     */
    protected function getStatsTable()
    {
        return 'product_stats';
    }

    /**
     * Searches for popular products
     *
     * @return self
     */
    public function popularProducts()
    {
        $productIds = DB::table($this->getStatsTable())->selectRaw('sum(count_views) as total_views, sum(count_sales) as total_sales, product_id')
            ->whereBetween('date', [$this->getStartDate(), $this->getEndDate()])
            ->groupBy('product_id')
            ->orderBy('total_views', 'desc')
            ->orderBy('total_sales', 'desc')
            ->paginate($this->limit);

        $this->paginator = $productIds;

        $ids = $productIds->getCollection()->pluck('product_id')->toArray();

        if (! is_array($ids) || count($ids) == 0) {
            $this->query = null;
            $this->paginator = null;

            return $this;
        }

        $this->query = $this->getQuery()
            ->select($this->getSelectFields())
            ->whereIn('id', $ids)
            ->notVariation()
            ->published()
            ->isAvailable()
            ->isActiveVendor()
            ->orderBy(DB::raw('FIELD(id, ' . implode(',', $ids) . ')'));

        return $this;
    }

    /**
     * Searches for best seller products
     *
     * @return self
     */
    public function bestSeller()
    {
        $productIds = DB::table($this->getStatsTable())->selectRaw('sum(count_views) as total_views, sum(count_sales) as total_sales, product_id')
            ->whereBetween('date', [$this->getStartDate(), $this->getEndDate()])
            ->groupBy('product_id')
            ->orderBy('total_sales', 'desc')
            ->orderBy('total_views', 'desc')
            ->paginate($this->limit);

        $this->paginator = $productIds;

        $ids = $productIds->getCollection()->pluck('product_id')->toArray();

        if (! is_array($ids) || count($ids) == 0) {
            $this->query = null;
            $this->paginator = null;

            return $this;
        }

        $this->query = $this->getQuery()
            ->select($this->getSelectFields())
            ->whereIn('id', $ids)
            ->notVariation()
            ->published()
            ->isAvailable()
            ->isActiveVendor()
            ->orderBy('review_average', 'desc')
            ->orderBy('review_count', 'desc')
            ->orderBy(DB::raw('FIELD(id, ' . implode(',', $ids) . ')'));

        return $this;
    }

    /**
     * Searches for featured products
     *
     * @return self
     */
    public function featureProducts()
    {
        $this->query = $this->getQuery()
            ->select($this->getSelectFields())
            ->notVariation()
            ->whereNotNull('featured')
            ->published()
            ->isAvailable()
            ->isActiveVendor()
            ->orderBy('featured', 'desc');

        return $this;
    }

    /**
     * Searches for new arrivals products
     *
     * @return self
     */
    public function newArrivals()
    {
        $this->query = $this->getQuery()
            ->select($this->getSelectFields())
            ->notVariation()
            ->orderBy('id', 'desc')
            ->published()
            ->isAvailable()
            ->isActiveVendor();

        return $this;
    }

    /**
     * Searches for popular products
     *
     * @return self
     */
    public function flashSales()
    {
        $this->addSelectFields([DB::raw('(((regular_price - sale_price) * 100) / regular_price) as sale_rate')]);
        $this->query = $this->getQuery()
            ->select($this->getSelectFields())
            ->notVariation()
            ->published()
            ->isAvailable()
            ->isActiveVendor()
            ->where('sale_price', '>=', 0)
            ->where('regular_price', '>', 0)
            ->whereDate('sale_from', '<=', $this->hasStartDate() ? $this->getStartDate() : now()->toDateString())
            ->whereDate('sale_to', '>=', $this->hasEndDate() ? $this->getEndDate() : now()->toDateString())
            ->orderBy('sale_rate', 'desc')
            ->orderByDesc('sale_price');

        return $this;
    }

    /**
     * Searches for popular products
     *
     * @return self
     */
    public function bestDeals()
    {
        $this->addSelectFields([DB::raw('(((regular_price - sale_price) * 100) / regular_price) as sale_rate')]);
        $this->query = $this->getQuery()
            ->select($this->getSelectFields())
            ->notVariation()
            ->published()
            ->isAvailable()
            ->isActiveVendor()
            ->where('sale_price', '>=', 0)
            ->where('regular_price', '>', 0)
            ->whereDate('sale_from', '<=', $this->hasStartDate() ? $this->getStartDate() : now()->toDateString())
            ->whereDate('sale_to', '>=', $this->hasEndDate() ? $this->getEndDate() : now()->toDateString())
            ->orderByDesc('sale_rate')
            ->orderByDesc('total_sales')
            ->orderByDesc('sale_price');

        return $this;
    }

    /**
     * Provides the final value after implementing service business logic
     *
     * @return mixed
     */
    public function get()
    {
        if ($this->isValidQueryBuilder($this->query)) {
            $this->limit();

            return $this->query->get();
        }

        return null;
    }
}
