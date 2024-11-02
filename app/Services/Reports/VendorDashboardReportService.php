<?php

/**
 * @author TechVillage <support@techvill.org>
 *
 * @contributor Muhammad AR Zihad <[zihad.techvill@gmail.com]>
 * @contributor Al Mamun <[almamun.techvill@gmail.com]>
 *
 * @created 19-04-2022
 */

namespace App\Services\Reports;

use App\Traits\ApiResponse;
use Illuminate\Support\Facades\DB;
use Modules\Refund\Entities\Refund;
use App\Models\{
    Brand,
    Product, Order, OrderDetail, OrderStatus,
    Review, User, Wallet
};

class VendorDashboardReportService
{
    use ApiResponse;
    use ReportHelperTrait;

    /**
     * Stores vendor id
     */
    private $vendorId = null;

    /**
     * Calculates total orders in last 30 days
     *
     * @param  string|null  $key
     * @return DashboardReportService | array
     */
    public function thisMonthOrdersCount($key = 'thisMonthOrdersCount', $returnSelf = true)
    {
        if ($key == '') {
            $key = 'thisMonthOrdersCount';
        }
        $total = OrderDetail::select('vendor_id', 'order_id', DB::raw('concat("v-", vendor_id, "o-", order_id) as vendor_order'))
            ->join('orders', 'orders.id', 'order_details.order_id')
            ->where('orders.order_date', '>=', $this->offsetDate('-30'))
            ->whereVendorId($this->getVendorId())
            ->groupBy('order_id')
            ->get()->count();

        return $this->complete($total, $key, $returnSelf);
    }

    /**
     * Compare this month orders count against last month orders count
     *
     * @param  string|null  $key
     * @return DashboardReportService
     */
    public function thisMonthOrdersCompare($key = 'thisMonthOrdersCompare')
    {
        $totalLastMonth = OrderDetail::join('orders', 'orders.id', 'order_details.order_id')
            ->where('orders.order_date', '>=', $this->offsetDate('-60'))
            ->where('orders.order_date', '<', $this->offsetDate('-30'))
            ->whereVendorId($this->getVendorId())
            ->groupBy('order_id', 'vendor_id')
            ->get()
            ->count();
        $totalThisMonth = $this->getValue('thisMonthOrdersCount') ?? $this->thisMonthOrdersCount('', false);

        return $this->complete($this->growthRate($totalThisMonth, $totalLastMonth), $key);
    }

    /**
     * Calculates total sales in last 30 days
     *
     * @param  string|null  $key
     * @return DashboardReportService
     */
    public function thisMonthSalesCount($key = 'thisMonthSales', $returnSelf = true)
    {
        if ($key == '') {
            $key = 'thisMonthSales';
        }

        $total = OrderDetail::whereVendorId($this->getVendorId())
            ->leftJoin('orders', 'orders.id', '=', 'order_details.order_id')
            ->where('orders.order_date', '>=', $this->offsetDate('-30'))
            ->where('orders.payment_status', 'Paid')
            ->whereLike('orders.payment_status', 'Paid')
            ->sum(DB::raw('order_details.price * order_details.quantity'));

        return $this->complete($total, $key, $returnSelf);
    }

    /**
     * Compare this month sales count against last month sales count
     *
     * @param  string|null  $key
     * @return DashboardReportService
     */
    public function thisMonthSalesCompare($key = 'thisMonthSalesCompare')
    {
        $totalLastMonth = OrderDetail::join('orders', 'orders.id', 'order_details.order_id')
            ->where('orders.order_date', '>=', $this->offsetDate('-60'))
            ->where('orders.order_date', '<', $this->offsetDate('-30'))
            ->whereVendorId($this->getVendorId())
            ->sum(DB::raw('price * quantity'));
        $totalThisMonth = $this->getValue('thisMonthSales') ?? $this->thisMonthSalesCount('', false);

        return $this->complete($this->growthRate($totalThisMonth, $totalLastMonth), $key);
    }

    /**
     * Finds the most sold products in last 30 days
     *
     * @param  string|null  $key
     * @return DashboardReportService
     */
    public function mostSoldProducts($key = 'mostSoldProducts')
    {
        $products = OrderDetail::select('id', 'product_id', 'parent_id', 'product_name', 'quantity', DB::raw('sum(quantity) as total'))
            ->with('product:id,code')->has('product')->whereHas('order', function ($q) {
                $q->where('order_date', '>=', $this->offsetDate('-30'));
            })
            ->whereVendorId($this->getVendorId())
            ->groupBy('product_name')
            ->orderBy('total', 'desc')
            ->get()
            ->map(function ($orderDetail) {
                if ($orderDetail->parent_id) {
                    $code = $orderDetail?->parentProduct?->code;
                } else {
                    $code = $orderDetail?->product?->code;
                }

                return [
                    'name' => $orderDetail->product_name,
                    'total' => round($orderDetail->total, 5),
                    'url' => route('vendor.product.edit', ['code' => $code]),
                ];
            });

        return $this->complete($products, $key);
    }

    /**
     * Users with most orders by last 30 days
     *
     * @param  string|null  $key
     * @return DashboardReportService
     */
    public function mostActiveUsers($key = 'mostActiveUsers')
    {
        $users = Order::select('id', 'user_id', DB::raw('count(user_id) as total'))
            ->with('user:id,name')
            ->whereNotNull('user_id')
            ->where('order_date', '>=', $this->offsetDate('-60'))
            ->whereHas('orderDetails', function ($q) {
                $q->whereVendorId($this->getVendorId());
            })
            ->groupBy('user_id')
            ->orderBy('total', 'desc')
            ->get()
            ->map(function ($order) {
                return [
                    'name' => $order->user->name,
                    'total' => $order->total,
                    'profile' => route('users.edit', ['id' => $order->user_id]),
                ];
            });

        return $this->complete($users, $key);
    }

    /**
     * New products added into the system in last 30 days
     *
     * @param  string|null  $key
     * @return DashboardReportService
     */
    public function newProductsCount($key = 'newProducts', $returnSelf = true)
    {
        if ($key == '') {
            $key = 'newProducts';
        }
        $count = Product::where('created_at', '>=', $this->offsetDate('-30'))->whereVendorId($this->getVendorId())->count();

        return $this->complete($count, $key, $returnSelf);
    }

    /**
     * Compare last month products count with this month products count
     *
     * @param  string|null  $key
     * @return DashboardReportService
     */
    public function newProductsCountCompare($key = 'newProductsCompare')
    {
        $totalLastMonth = Product::where('created_at', '>=', $this->offsetDate('-60'))->where('created_at', '<', $this->offsetDate('-60'))->whereVendorId($this->getVendorId())->count();
        $totalThisMonth = $this->getValue('newProducts') ?? $this->newProductsCount('', false);

        return $this->complete($this->growthRate($totalThisMonth, $totalLastMonth), $key);
    }

    /**
     * New refund requests in last 30 days
     *
     * @param  string|null  $key
     * @return DashboardReportService
     */
    public function newRefundsCount($key = 'newRefunds', $returnSelf = true)
    {
        if ($key == '') {
            $key = 'newRefunds';
        }
        $count = Refund::whereHas('orderDetail', function ($query) {
            $query->whereVendorId($this->getVendorId());
        })->where('created_at', '>=', $this->offsetDate('-30'))->count();

        return $this->complete($count, $key, $returnSelf);
    }

    /**
     * Compare last month refund requests count with this week refund requests count
     *
     * @param  string|null  $key
     * @return DashboardReportService
     */
    public function newRefundsCountCompare($key = 'newRefundsCompare')
    {
        $dates = $this->lastMonth();
        $totalLastMonth = Refund::WhereHas('orderDetail', function ($query) {
            $query->whereVendorId($this->getVendorId());
        })->where('created_at', '>=', $this->offsetDate('-60'))
            ->where('created_at', '<', $this->offsetDate('-30'))->count();
        $totalThisMonth = $this->getValue('newRefunds') ?? $this->newRefundsCount('', false);

        return $this->complete($this->growthRate($totalThisMonth, $totalLastMonth), $key);
    }

    /**
     * Review in last 30 days
     *
     * @param  string|null  $key
     * @return DashboardReportService
     */
    public function thisMonthReviews($key = 'newReviews', $returnSelf = true)
    {
        if ($key == '') {
            $key = 'newReviews';
        }
        $count = Review::select('reviews.id', 'product_id', 'user_id')->whereHas('product', function ($query) {
            $query->where('vendor_id', auth()->user()->vendor()->vendor_id);
        })->where('created_at', '>=', $this->offsetDate('-30'))->count();

        return $this->complete($count, $key, $returnSelf);
    }

    /**
     * Compare last month refund requests count with this week refund requests count
     *
     * @param  string|null  $key
     * @return DashboardReportService
     */
    public function thisMonthReviewCompare($key = 'newReviewsCompare')
    {
        $dates = $this->lastMonth();
        $totalLastMonth = Review::select('reviews.id', 'product_id', 'user_id', 'reviews.status')->whereHas('product', function ($query) {
            $query->where('vendor_id', auth()->user()->vendor()->vendor_id);
        })->where('created_at', '>=', $this->offsetDate('-60'))
            ->where('created_at', '<', $this->offsetDate('-30'))->count();
        $totalThisMonth = $this->getValue('newReviews') ?? $this->complete('', false);

        return $this->complete($this->growthRate($totalThisMonth, $totalLastMonth), $key);
    }

    /**
     * Orders of different statuses
     *
     * @param  string|null  $key
     * @return DashboardReportService
     */
    public function orderStatusWithCount($key = 'orderStatus')
    {
        $data['status'] = $data['count'] = [];
        OrderStatus::withCount(['orderDetails' => function ($q) {
            $q->join('orders', 'orders.id', 'order_details.order_id')
                ->select(DB::raw('count(distinct(order_id))'))
                ->where('vendor_id', $this->getVendorId())
                ->where('orders.order_date', '>=', $this->offsetDate('-30'));
        }])->get()
            ->map(function ($order) use (&$data) {
                $data['status'][] = $order->name;
                $data['count'][] = $order->order_details_count;
            });

        return $this->complete($data, $key);
    }

    /**
     * Get single product details
     *
     * @param  int  $productId
     * @param  string|null  $key
     * @return DashboardReportService
     */
    public function productDetails($productId, $key = 'productDetails')
    {
        $product = Product::firstWhere('id', $productId);

        return $this->complete(view('admin.dashboxes.partials.product-details', compact('product'))->render(), $key);
    }

    /**
     * Get single user details
     *
     * @param  int  $userId
     * @param  string|null  $key
     * @return DashboardReportService
     */
    public function userDetails($userId, $key = 'userDetails')
    {
        $user = User::findOrFail($userId);

        return $this->complete(view('admin.dashboxes.partials.user-pop', compact('user'))->render(), $key);
    }

    /**
     * Get sales comparison
     *
     * @param  string|null  $key
     * @return DashboardReportService
     */
    public function salesOfTheMonth($key = 'salesComparison')
    {
        $range = $this->getDay($this->offsetDate());
        $dates = range(1, 31);

        $currentMonth = $this->getMonth($this->offsetDate());
        $values[$currentMonth] = array_fill(0, $range - 1, 0);
        $values[$currentMonth - 1] = array_fill(0, 31, 0);
        $values[$currentMonth - 2] = array_fill(0, 31, 0);

        OrderDetail::select('orders.id', 'order_date', DB::raw('sum(price * quantity) as total'))
            ->join('orders', 'orders.id', 'order_details.order_id')
            ->where('order_date', '>=', $this->offsetDate('-' . 60 + $range - 1))
            ->where('order_date', '<', $this->tomorrow())
            ->whereVendorId($this->getVendorId())
            ->groupBy('order_date')
            ->get()
            ->map(function ($sale) use (&$values, $currentMonth) {
                $month = $this->getMonth($sale->order_date);
                if ($currentMonth < 3 && $month > 10) {
                    $month -= 12;
                }

                $values[$month][$this->getDay($sale->order_date) - 1] = $sale->total;
            });

        return $this->complete([
            'dates' => $dates,
            'values' => $values,
            'thisMonth' => date('M Y'),
        ], $key);
    }

    /**
     * Get vendor wallet balance
     *
     * @param  string|null  $key
     * @return DashboardReportService
     */
    public function walletBalances($key = 'walletBalances')
    {
        $balance = Wallet::select('balance', 'currency_id')->where('user_id', auth()->id())->with('currency:id,name,symbol')->get();

        return $this->complete($balance, $key);
    }

    /**
     * Get top selling brands
     *
     * @param  string|null  $key
     * @return DashboardReportService
     */
    public function topSoldBrands($key = 'topSoldBrands')
    {
        $brands = Brand::join('products', 'products.brand_id', 'brands.id')
            ->select('brands.id', 'brands.name', DB::raw('count(products.brand_id) as total'))
            ->where('products.vendor_id', $this->getVendorId())
            ->where('products.total_sales', '>', 0)
            ->orderBy('total', 'desc')->take($this->getLimit())
            ->groupBy('products.brand_id')
            ->get()
            ->map(function ($q) {
                return [
                    'name' => $q->name,
                    'total' => $q->total ?? 0,
                    'url' => '',
                ];
            });

        return $this->complete($brands, $key);
    }

    /**
     * Dashboard widget element
     *
     * @param  string|null  $key
     * @param  bool  $returnSelf
     * @return DashboardReportService | array
     */
    public function dashboardWidgetElement($key = 'dashboardWidgetElement', $returnSelf = true)
    {
        if ($key == '') {
            $key = 'dashboardWidgetElement';
        }
        $data = json_decode(cache()->get('vendor-dashboard-widget-element.' . auth()->user()->id), true);

        return $this->complete($data, $key, $returnSelf);
    }

    /**
     * Dashboard widget option
     *
     * @param  string|null  $key
     * @param  bool  $returnSelf
     * @return DashboardReportService | array
     */
    public function dashboardWidgetOption($key = 'dashboardWidgetOption', $returnSelf = true)
    {
        if ($key == '') {
            $key = 'dashboardWidgetOption';
        }
        $data = json_decode(cache()->get('vendor-dashboard-widget-option.' . auth()->user()->id), true);

        return $this->complete($data, $key, $returnSelf);
    }

    /**
     * Vendor Widget Options
     *
     * 'label', 'visibility' and 'gs' are optional
     * default 'visibility' is true
     */
    public function widget($key = 'widget', $returnSelf = true)
    {
        if ($key == '') {
            $key = 'widget';
        }

        $data = [
            'wallet' => [
                'label' => __('Wallet'),
                'visibility' => true,
                'content' => 'vendor.dashbox.wallet',
                'gs' => ['x' => 0, 'y' => 0, 'width' => 4, 'height' => 1],
            ],
            'this_month_sale' => [
                'label' => __('Total Sales'),
                'content' => 'vendor.dashbox.this-month-sale',
                'gs' => ['x' => 4, 'y' => 0, 'width' => 4, 'height' => 1],
            ],
            'this_month_order_count' => [
                'label' => __('Orders'),
                'content' => 'vendor.dashbox.this-month-order-count',
                'gs' => ['x' => 8, 'y' => 0, 'width' => 4, 'height' => 1],
            ],
            'new_refunds' => [
                'label' => __('Refund Request'),
                'content' => 'vendor.dashbox.new-refunds',
                'gs' => ['x' => 0, 'y' => 1, 'width' => 4, 'height' => 1],
            ],
            'new_products' => [
                'label' => __('Products'),
                'content' => 'vendor.dashbox.new-products',
                'gs' => ['x' => 4, 'y' => 1, 'width' => 4, 'height' => 1],
            ],
            'rating' => [
                'label' => __('Rating'),
                'content' => 'vendor.dashbox.rating',
                'gs' => ['x' => 8, 'y' => 1, 'width' => 4, 'height' => 1],
            ],
            'heatmap' => [
                'label' => __('Sales Per Day'),
                'content' => 'admin.dashboxes.heatmap',
                'gs' => ['x' => 0, 'y' => 2, 'width' => 6, 'height' => 5],
            ],
            'donut_chart' => [
                'label' => __('Monthly Order Status'),
                'content' => 'admin.dashboxes.donut-chart',
                'gs' => ['x' => 6, 'y' => 2, 'width' => 6, 'height' => 5],
            ],
            'most_sold_product' => [
                'label' => __('Most Sold Product'),
                'content' => 'admin.dashboxes.most-sold-products',
                'gs' => ['x' => 0, 'y' => 7, 'width' => 4, 'height' => 4],
            ],
            'most_sold_brand' => [
                'label' => __('Most Sold Brand'),
                'content' => 'admin.dashboxes.most-sold-brands',
                'gs' => ['x' => 4, 'y' => 7, 'width' => 4, 'height' => 4],
            ],
            'most_active_user' => [
                'label' => __('Popular Customer'),
                'content' => 'admin.dashboxes.most-active-users',
                'gs' => ['x' => 8, 'y' => 7, 'width' => 4, 'height' => 4],
            ],
        ];

        $data = apply_filters('vendor_dashboard_widget', $data);

        return $this->complete($data, $key, $returnSelf);
    }
}
