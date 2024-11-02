<?php

/**
 * @author TechVillage <support@techvill.org>
 *
 * @contributor Muhammad AR Zihad <[zihad.techvill@gmail.com]>
 * @contributor Al Mamun <[almamun.techvill@gmail.com]>
 *
 * @created 11-04-2022
 */

namespace App\Services\Reports;

use App\Traits\ApiResponse;
use Illuminate\Support\Facades\DB;
use Modules\Commission\Http\Models\OrderCommission;
use Modules\Refund\Entities\Refund;
use App\Models\{
    Brand, Product, Order, OrderDetail, OrderStatus,
    Transaction, User, Vendor
};
use Modules\Ticket\Http\Models\Thread;

class AdminDashboardReportService
{
    use ApiResponse;
    use ReportHelperTrait;

    /**
     * Calculates total orders in this month
     *
     * @param  string|null  $key
     * @param  bool  $returnSelf
     * @return DashboardReportService | array
     */
    public function thisMonthOrdersCount($key = 'thisMonthOrdersCount', $returnSelf = true)
    {
        if ($key == '') {
            $key = 'thisMonthOrdersCount';
        }
        $total = Order::where('order_date', '>=', $this->offsetDate('-30'))->count();

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
        $totalLastMonth = Order::where('order_date', '>=', $this->offsetDate('-60'))->where('order_date', '<', $this->offsetDate('-30'))->count();
        $totalThisMonth = $this->getValue('thisMonthOrdersCount') ?? $this->thisMonthOrdersCount('', false);

        return $this->complete($this->growthRate($totalThisMonth, $totalLastMonth), $key);
    }

    /**
     * Calculates total sales in this month
     *
     * @param  string|null  $key
     * @return DashboardReportService
     */
    public function thisMonthSalesCount($key = 'thisMonthSales', $returnSelf = true)
    {
        if ($key == '') {
            $key = 'thisMonthSales';
        }

        $total = Order::where('order_date', '>=', $this->offsetDate('-30'))->where('payment_status', 'Paid')->sum('total');

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
        $totalLastMonth = Order::where('order_date', '>=', $this->offsetDate('-60'))->where('order_date', '<', $this->offsetDate('-30'))->where('payment_status', 'Paid')->sum('total');
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
        $products = OrderDetail::select('id', 'product_id', 'parent_id', 'quantity', DB::raw('sum(quantity) as total'))
            ->with('product:id,name,code')->has('product')->whereHas('order', function ($q) {
                $q->where('order_date', '>=', $this->offsetDate('-30'));
            })
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
                    'name' => $orderDetail?->product?->name,
                    'total' => round($orderDetail->total, 5),
                    'url' => route('product.edit', ['code' => $code]),
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

        $count = Product::where('created_at', '>=', $this->offsetDate('-30'))
            ->whereNull('parent_id')
            ->count();

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
        $totalLastMonth = Product::where('created_at', '>=', $this->offsetDate('-30'))->where('created_at', '<', $this->offsetDate('-60'))->count();
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

        $count = Refund::where('created_at', '>=', $this->offsetDate('-30'))->count();

        if ($returnSelf) {
            return $this->complete($count, $key);
        }

        $this->setReturn($count, $key);

        return $count;
    }

    /**
     * Compare last month refund requests count with this month refund requests count
     *
     * @param  string|null  $key
     * @return DashboardReportService
     */
    public function newRefundsCountCompare($key = 'newRefundsCompare')
    {
        $totalLastMonth = Refund::where('created_at', '>=', $this->offsetDate('-60'))->where('created_at', '<', $this->offsetDate('-30'))->count();
        $totalThisMonth = $this->getValue('newRefunds') ?? $this->newRefundsCount('', false);

        return $this->complete($this->growthRate($totalThisMonth, $totalLastMonth), $key);
    }

    /**
     * New users registered in last 30 days
     *
     * @param  string|null  $key
     * @return DashboardReportService
     */
    public function newUsersCount($key = 'newUsersCount', $returnSelf = true)
    {
        if ($key == '') {
            $key = 'newUsers';
        }

        $count = User::where('created_at', '>=', $this->offsetDate('-30'))
            ->where('activation_code', null)
            ->count();

        if ($returnSelf) {
            return $this->complete($count, $key);
        }

        $this->setReturn($count, $key);

        return $count;
    }

    /**
     * Compare new users count against last 30 days
     *
     * @param  string|null  $key
     * @return DashboardReportService
     */
    public function newUsersCompare($key = 'newUsersCompare')
    {
        $totalLastMonth = User::where('created_at', '>=', $this->offsetDate('-60'))->where('created_at', '<', $this->offsetDate('-30'))
            ->where('activation_code', null)
            ->count();
        $totalThisMonth = $this->getValue('newUsers') ??  $this->newUsersCount('', false);

        return $this->complete($this->growthRate($totalThisMonth, $totalLastMonth), $key);
    }

    /**
     * New users registered in last 30 days
     *
     * @param  string|null  $key
     * @return DashboardReportService
     */
    public function newVendors($key = 'newVendors', $returnSelf = true)
    {
        if ($key == '') {
            $key = 'newVendors';
        }

        $count = Vendor::where('created_at', '>=', $this->offsetDate('-30'))->count();

        if ($returnSelf) {
            return $this->complete($count, $key);
        }

        $this->setReturn($count, $key);

        return $count;
    }

    /**
     * Compare new vendors count against last 30 days
     *
     * @param  string|null  $key
     * @return DashboardReportService
     */
    public function newVendorsCompare($key = 'newVendorsCompare')
    {
        $totalLastMonth = Vendor::where('created_at', '>=', $this->offsetDate('-60'))->where('created_at', '<', $this->offsetDate('-30'))->count();
        $totalThisMonth = $this->getValue('newVendors') ?? $this->newVendors('', false);

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
        $data = [];
        OrderStatus::withCount(['orders' => function ($q) {
            $q->where('order_date', '>', $this->offsetDate('-30'));
        }])
            ->get()
            ->map(function ($order) use (&$data) {
                $data['status'][] = $order->name;
                $data['count'][] = $order->orders_count;
            });

        return $this->complete($data, $key);
    }

    /**
     * Vendor stats
     *
     * @param  string|null  $key
     * @return DashboardReportService
     */
    public function vendorStats($key = 'vendorStats', $type = null)
    {
        $data = Vendor::take($this->getLimit())
            ->select(
                'vendors.id as id',
                'vendors.name as name',
                'orders.order_date',
                DB::raw('count(orders.id) as totalOrder'),
                DB::raw('sum(orders.total) as sales'),
                DB::raw('sum(products.review_average) / count(products.id) as ratings')
            )->join('order_details', 'vendors.id', 'order_details.vendor_id')
            ->join('orders', 'order_details.order_id', 'orders.id')
            ->join('products', 'order_details.product_id', 'products.id')
            ->groupBy('vendors.id')
            ->orderByDesc('totalOrder');

        if ($type == 'daily') {
            $data->where('orders.order_date', $this->offsetDate());
        } elseif ($type == 'weekly') {
            $data->where('orders.order_date', '>=', $this->offsetDate('-7'));
            $data->where('orders.order_date', '<=', $this->offsetDate());
        } elseif ($type == 'monthly') {
            $data->where('orders.order_date', '>=', $this->offsetDate('-30'));
            $data->where('orders.order_date', '<=', $this->offsetDate());
        } elseif ($type == 'yearly') {
            $data->where('orders.order_date', '>=', $this->offsetDate('-365'));
            $data->where('orders.order_date', '<=', $this->offsetDate());
        }

        $data = $data->get()
            ->map(function ($vendor) {
                return [
                    'id' => $vendor->id,
                    'name' => $vendor->name,
                    'ratings' => round($vendor->ratings),
                    'orders' => $vendor->totalOrder,
                    'sales' => formatNumber($vendor->sales),
                    'edit' => route('vendors.edit', ['id' => $vendor->id]),
                    'url' => route('users.user-data', ['uid' => $vendor->id, 'type' => 'vendor']),
                ];
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
        if (request()->type == 'vendor') {
            $user = Vendor::findOrFail($userId);
            $route = route('vendors.edit', ['id' => $userId]);
        } else {
            $user = User::findOrFail($userId);
            $route = route('users.edit', ['id' => $userId]);
        }

        return $this->complete(view('admin.dashboxes.partials.user-pop', compact('user', 'route'))->render(), $key);
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
        $values[$currentMonth - 2] = array_fill(0, 31, 0);
        $values[$currentMonth - 1] = array_fill(0, 31, 0);
        $values[$currentMonth] = array_fill(0, $range - 1, 0);

        Order::select('id', 'order_date', DB::raw('sum(total) as total'))
            ->where('order_date', '>=', $this->offsetDate('-' . 60 + $range - 1))
            ->where('order_date', '<', $this->tomorrow())
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
     * Get top selling brands
     *
     * @param  string|null  $key
     * @return DashboardReportService
     */
    public function topSoldBrands($key = 'topSoldBrands')
    {
        $brands = Brand::join('products', 'products.brand_id', 'brands.id')
            ->select('brands.id', 'brands.name', DB::raw('sum(products.total_sales) as total'))
            ->orderBy('total', 'desc')->take($this->getLimit())
            ->groupBy('products.brand_id')
            ->get()
            ->map(function ($q) {
                return [
                    'name' => $q->name,
                    'total' => $q->total ?? 0,
                    'url' => route('brands.edit', ['id' => $q->id]),
                ];
            });

        return $this->complete($brands, $key);
    }

    /**
     * Get commissions of the month
     *
     * @param  string|null  $key
     * @return mixed
     */
    public function commissionThisMonth($key = 'commissionThisMonth', $returnSelf = true)
    {
        $key = $key ?? 'commissionThisMonth';
        $commissions = OrderCommission::join('order_details', 'order_commissions.order_details_id', 'order_details.id')
            ->where('order_commissions.status', 'Approve')
            ->where('order_commissions.created_at', '>=', $this->offsetDate('-30'))
            ->sum(DB::raw('order_commissions.amount * (order_details.price * order_details.quantity) / 100'));
        $refundCommission = Transaction::where('transaction_type', 'Refund_commission')
            ->where('created_at', '>=', $this->offsetDate('-30'))
            ->sum('total_amount');

        return $this->complete($commissions - $refundCommission, $key, $returnSelf);
    }

    /**
     * Compare commissions of the month
     *
     * @param  string|null  $key
     * @return mixed
     */
    public function commissionThisMonthCompare($key = 'commissionThisMonthCompare')
    {
        $commissions = OrderCommission::join('order_details', 'order_commissions.order_details_id', 'order_details.id')
            ->where('order_commissions.status', 'Approve')
            ->where('order_commissions.created_at', '<', $this->offsetDate('-30'))
            ->where('order_commissions.created_at', '>=', $this->offsetDate('-60'))
            ->sum(DB::raw('order_commissions.amount * (order_details.price * order_details.quantity) / 100'));

        $refundCommission = Transaction::where('transaction_type', 'Refund Commission')
            ->where('created_at', '<', $this->offsetDate('-30'))
            ->where('created_at', '>=', $this->offsetDate('-60'))
            ->sum('total_amount');

        $totalLastMonth = $commissions - $refundCommission;

        $totalThisMonth = $this->getValue('commissionThisMonth') ?? $this->commissionThisMonth(null, false);

        return $this->complete($this->growthRate($totalThisMonth, $totalLastMonth), $key);
    }

    /**
     * Get vendor request list
     *
     * @param  string|null  $key
     * @return mixed
     */
    public function vendorRequestList($key = 'vendorReq')
    {
        $data = Vendor::take($this->getLimit())
            ->where('status', 'Pending')
            ->orderBy('created_at', 'ASC')
            ->get()
            ->map(function ($user) {
                return [
                    'id' => $user->id,
                    'name' => $user->name,
                    'file_url' => $user->fileUrl(),
                    'created_at' => $user->format_created_at,
                    'url' => route('users.user-data', ['uid' => $user->id, 'type' => 'vendor']),
                    'view' => route('vendors.edit', ['id' => $user->id]),
                    'accept' => route('dashboard.changeStatus', ['status' => 'accept', 'id' => $user->id]),
                    'reject' => route('dashboard.changeStatus', ['status' => 'reject', 'id' => $user->id]),
                ];
            });

        return $this->complete($data, $key);
    }

    /**
     * Open ticket count
     *
     * @param  string|null  $key
     * @param  bool  $returnSelf
     * @return DashboardReportService | array
     */
    public function openTicketsCount($key = 'openTicketCount', $returnSelf = true)
    {
        if ($key == '') {
            $key = 'openTicketCount';
        }

        $total = Thread::join('thread_statuses', 'thread_statuses.id', 'threads.thread_status_id')
            ->where('thread_statuses.name', 'Open')->count();

        return $this->complete($total, $key, $returnSelf);
    }

    /**
     * Pending withdrawal request count
     *
     * @param  string|null  $key
     * @param  bool  $returnSelf
     * @return DashboardReportService | array
     */
    public function pendingWithdrawalRequestsCount($key = 'withdrawalRequestCount', $returnSelf = true)
    {
        if ($key == '') {
            $key = 'withdrawalRequestCount';
        }

        $total = Transaction::where(['transaction_type' => 'Withdrawal', 'status' => 'Pending'])->count();

        return $this->complete($total, $key, $returnSelf);
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
        $data = json_decode(cache()->get('dashboard-widget-element.' . auth()->user()->id), true);

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
        $data = json_decode(cache()->get('dashboard-widget-option.' . auth()->user()->id), true);

        return $this->complete($data, $key, $returnSelf);
    }

    /**
     * Admin dashboard widget
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
            'this_month_sale' => [
                'label' => __('Total Sales'),
                'visibility' => true,
                'content' => 'admin.dashboxes.this-month-sale',
                'gs' => ['x' => 0, 'y' => 0, 'width' => 4, 'height' => 1],
            ],
            'commission_this_month' => [
                'label' => __('Commission'),
                'content' => 'admin.dashboxes.commission-this-month',
                'gs' => ['x' => 4, 'y' => 0, 'width' => 4, 'height' => 1],
            ],
            'this_month_order_count' => [
                'label' => __('Orders'),
                'content' => 'admin.dashboxes.this-month-order-count',
                'gs' => ['x' => 8, 'y' => 0, 'width' => 4, 'height' => 1],
            ],
            'new_refunds' => [
                'label' => __('Refund Request'),
                'content' => 'admin.dashboxes.new-refunds',
                'gs' => ['x' => 0, 'y' => 1, 'width' => 4, 'height' => 1],
            ],
            'new_products' => [
                'label' => __('Products'),
                'content' => 'admin.dashboxes.new-products',
                'gs' => ['x' => 4, 'y' => 1, 'width' => 4, 'height' => 1],
            ],
            'new_vendors' => [
                'label' => __('Vendors'),
                'content' => 'admin.dashboxes.new-vendors',
                'gs' => ['x' => 8, 'y' => 1, 'width' => 4, 'height' => 1],
            ],
            'new_users' => [
                'label' => __('Users'),
                'content' => 'admin.dashboxes.new-users',
                'gs' => ['x' => 0, 'y' => 2, 'width' => 4, 'height' => 1],
            ],
            'open_ticket_count' => [
                'label' => __('Open Tickets'),
                'content' => 'admin.dashboxes.open-ticket-count',
                'gs' => ['x' => 4, 'y' => 2, 'width' => 4, 'height' => 1],
            ],
            'withdrawal_request_count' => [
                'label' => __('Withdrawal Request'),
                'content' => 'admin.dashboxes.withdrawal-request-count',
                'gs' => ['x' => 8, 'y' => 2, 'width' => 4, 'height' => 1],
            ],
            'donut_chart' => [
                'label' => __('Monthly Order Status'),
                'content' => 'admin.dashboxes.donut-chart',
                'gs' => ['x' => 0, 'y' => 3, 'width' => 5, 'height' => 5],
            ],
            'heatmap' => [
                'label' => __('Sales Per Day'),
                'content' => 'admin.dashboxes.heatmap',
                'gs' => ['x' => 5, 'y' => 3, 'width' => 7, 'height' => 5],
            ],
            'top_vendor' => [
                'label' => __('Top Vendor'),
                'content' => 'admin.dashboxes.vendor-stats',
                'gs' => ['x' => 0, 'y' => 8, 'width' => 6, 'height' => 5],
            ],
            'vendor_request' => [
                'label' => __('Vendor Request'),
                'content' => 'admin.dashboxes.vendor-request',
                'gs' => ['x' => 6, 'y' => 8, 'width' => 6, 'height' => 5],
            ],
            'most_sold_product' => [
                'label' => __('Most Sold Product'),
                'content' => 'admin.dashboxes.most-sold-products',
                'gs' => ['x' => 0, 'y' => 13, 'width' => 4, 'height' => 4],
            ],
            'most_sold_brand' => [
                'label' => __('Most Sold Brand'),
                'content' => 'admin.dashboxes.most-sold-brands',
                'gs' => ['x' => 4, 'y' => 13, 'width' => 4, 'height' => 4],
            ],
            'most_active_user' => [
                'label' => __('Popular Customer'),
                'content' => 'admin.dashboxes.most-active-users',
                'gs' => ['x' => 8, 'y' => 13, 'width' => 4, 'height' => 4],
            ],
        ];

        $data = apply_filters('admin_dashboard_widget', $data);

        return $this->complete($data, $key, $returnSelf);
    }
}
