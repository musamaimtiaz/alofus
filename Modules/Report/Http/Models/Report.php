<?php
/**
 * @author TechVillage <support@techvill.org>
 *
 * @contributor Kabir Ahmed <[kabir.techvill@gmail.com]>
 *
 * @created 20-03-2022
 */

namespace Modules\Report\Http\Models;

use App\Models\Model;
use Modules\Coupon\Http\Models\Coupon;
use App\Models\{
    Brand, Product,
    Category,
    Tag,
    Order,
    VendorUser,
    Search

};
use Modules\Shipping\Entities\ShippingClass;
use Modules\Commission\Http\Models\OrderCommission;
use DB;

class Report extends Model
{
    /**
     * Report Class
     *
     * @return [type]
     */
    public function reportType()
    {
        return $reportType = [
            'CouponReport' => __('Coupons Report'),
            'CustomerOrderReport' => __('Customers Order Report'),
            'CommissionReport' => __('Commissions Report'),
            'BrandedProductReport' => __('Branded Products Report'),
            'CategorizedProductReport' => __('Categorized Products Report'),
            'ProductStockReport' => __('Product Stock Report'),
            'TaggedProductReport' => __('Tagged Products Report'),
            'SearchReport' => __('Search Report'),
            'SaleReport' => __('Sale Report'),
        ];

    }

    /**
     * Report type for vendor
     *
     * @return [type]
     */
    public function reportTypeForVendor()
    {
        return $reportType = [
            'CouponReport' => __('Coupons Report'),
            'CustomerOrderReport' => __('Customers Order Report'),
            'CommissionReport' => __('Commissions Report'),
            'BrandedProductReport' => __('Branded Products Report'),
            'ProductStockReport' => __('Product Stock Report'),
            'TaggedProductReport' => __('Tagged Products Report'),
            'SaleReport' => __('Sale Report'),
        ];

    }

    /**
     * Column Name
     *
     * @return [type]
     */
    public function tableRow()
    {
        return $products = [
            'CouponReport' => [__('Date'), __('Coupon Name'), __('Coupon Code'), __('Order'), __('Total')],
            'CustomerOrderReport' => [__('Name'), __('Email'), __('Orders'), __('Products'), __('Total')],
            'BrandedProductReport' => [__('Brand'), __('Total Product')],
            'ProductStockReport' => [__('Product'), __('Qty'), __('Availability')],
            'CategorizedProductReport' => [__('Category'), __('Total Product')],
            'TaggedProductReport' => [__('Tag'), __('Product Count')],
            'SaleReport' => [__('Date'), __('Order'), __('Product'), __('Subtotal'), __('Shipping'), __('Discount'), __('Tax'), __('Total')],
            'ShippingReport' => [__('Shipping Methods'), __('Order'), __('Total')],
            'CommissionReport' => [__('Vendor Name'), __('Total Order'), __('Total Commission')],
            'SearchReport' => [__('Keyword'), __('Hits')],
        ];

    }

    /**
     * Determine the user
     *
     * @return bool
     */
    protected function checkVendorUser()
    {
        $user = VendorUser::where('user_id', $this->loggedUserId())->first();
        if ($user && ! str_contains(url()->current(), '/admin')) {
            return $user->vendor_id;
        }

        return false;
    }

    /**
     * get logged user id
     *
     * @return int
     */
    protected function loggedUserId()
    {
        return auth()->user()->id;
    }

    /**
     * Coupon Report
     *
     * @param  null  $from
     * @param  null  $to
     * @param  null  $couponCode
     * @return [type]
     */
    public function getCouponReport($from = null, $to = null, $couponCode = null)
    {
        $coupon = Coupon::has('couponRedeems');
        if (! empty($from)) {
            $coupon->where('start_date', '>=', DbDateFormat($from));
        }
        if (! empty($to)) {
            $coupon->where('start_date', '<=', DbDateFormat($to));
        }
        if (! empty($couponCode)) {
            $coupon->where('code', $couponCode);
        }

        if ($this->checkVendorUser()) {
            $coupon->where('vendor_id', $this->checkVendorUser());
        }

        return $coupon->withSum('couponRedeems', 'discount_amount')->withCount('couponRedeems')->get();
    }

    /**
     * Brand Report
     *
     * @param  null  $brandName
     * @return [type]
     */
    public function getBrandReport($brandName = null)
    {
        $brand = Brand::join('products', 'products.brand_id', 'brands.id')
            ->select('brands.id', 'brands.name', DB::raw('count(products.id) as product_count'))
            ->groupBy('brands.id');

        if (! empty($brandName)) {
            $brand->where('brands.name', $brandName);
        }

        if ($this->checkVendorUser()) {
            $brand->where('products.vendor_id', $this->checkVendorUser());
        }

        return $brand->get();
    }

    /**
     * Categorized Report
     *
     * @param  null  $categoryName
     * @return [type]
     */
    public function getCategorizedProductReport($categoryName = null)
    {
        $category = Category::join('product_categories', 'product_categories.category_id', 'categories.id')
            ->select('categories.id', 'categories.name', DB::raw('count(product_categories.product_id) as product_counts'))
            ->groupBy('product_categories.category_id');

        if (! empty($categoryName)) {
            $category->where('categories.name', $categoryName);
        }

        return $category->get();
    }

    /**
     * Product stock report
     *
     * @param  mixed  $qtyAbove
     * @param  mixed  $qtyBellow
     * @param  mixed  $stockAvailability
     * @return [type]
     */
    public function getProductStockReport($qtyAbove = null, $qtyBellow = null, $stockAvailability = null)
    {
        $data = Product::select('id', 'name', 'status', 'manage_stocks', 'total_stocks')->whereNull('parent_id');

        if (! empty($qtyAbove)) {
            $data->where('total_stocks', '>', $qtyAbove);
        }
        if (! empty($qtyBellow)) {
            $data->where('total_stocks', '<', $qtyBellow);
        }
        if (! empty($stockAvailability)) {
            if ($stockAvailability == 'in_stock') {
                $data->where('total_stocks', '>', 0);
            } else {
                $data->where('total_stocks', '=', 0);
            }
        }

        if ($this->checkVendorUser()) {
            $data->where('vendor_id', $this->checkVendorUser());
        }

        return $data->where(['status' => 'Published', 'manage_stocks' => 1])->get();
    }

    /**
     * Tag report
     *
     * @param  null  $tagName
     * @return [type]
     */
    public function getTagReport($tagName = null)
    {
        $tag = Tag::join('product_tags', 'product_tags.tag_id', 'tags.id')
            ->join('products', 'product_tags.product_id', 'products.id');

        if (! empty($tagName)) {
            $tag->where('tags.name', $tagName);
        }

        if ($this->checkVendorUser()) {
            $tag->where('products.vendor_id', $this->checkVendorUser());
        }

        return $tag->select('tags.id', 'tags.name', DB::raw('count(tags.id) as product_tag_count'))->groupBy('tags.name')->get();
    }

    /**
     * Order report
     *
     * @param  null  $from
     * @param  null  $to
     * @param  null  $customerName
     * @param  null  $customerEmail
     * @param  $orderStatus=  null
     * @return [type]
     */
    public function getCustomerOrderReport($from = null, $to = null, $customerName = null, $customerEmail = null, $orderStatus = null)
    {
        $order = Order::join('order_details', 'orders.id', 'order_details.order_id')
            ->join('users', 'orders.user_id', 'users.id')
            ->select(
                'orders.id as id',
                'orders.user_id as user_id',
                DB::raw('sum(order_details.price) as total'),
                DB::raw('(
                    SUM(IFNULL(order_details.price, 0) * IFNULL(order_details.quantity, 0)) +
                    SUM(IFNULL(order_details.shipping_charge, 0)) +
                    SUM(IFNULL(order_details.tax_charge, 0)) -
                    COALESCE(SUM(IFNULL(order_details.discount_amount, 0)), 0)
                ) as totalAmount'),
                DB::raw('sum(order_details.quantity) as total_quantity'),
                DB::raw('sum(order_details.quantity) as totalQty'),
                DB::raw('count(distinct orders.id) as totalOrder'),
            );

        if (! empty($customerName)) {
            $order->where('users.name', $customerName);
        }

        if (! empty($orderStatus)) {
            $order->where('order_details.order_status_id', $orderStatus);
        }

        if (! empty($customerEmail)) {
            $order->where('users.email', $customerEmail);
        }

        if (! empty($from)) {
            $order->where('order_date', '>=', DbDateFormat($from));
        }

        if (! empty($to)) {
            $order->where('order_date', '<=', DbDateFormat($to));
        }

        if ($this->checkVendorUser()) {
            $order->where('order_details.vendor_id', $this->checkVendorUser());
        }

        return $order->groupBy('orders.user_id')->get();
    }

    /**
     * Shipping report
     *
     * @param  null  $from
     * @param  null  $to
     * @param  $orderStatus=  null
     * @param  null  $shippingMethod
     * @return [type]
     */
    public function getShippingReport($from = null, $to = null, $orderStatus = null, $shippingMethod = null)
    {

        $shippingReport = ShippingClass::has('orderDetails');
        if (! empty($orderStatus)) {
            $shippingReport->WhereHas('orderDetails', function ($query) use ($orderStatus) {
                $query->where('order_status_id', $orderStatus);
            });
        }
        if (! empty($shippingMethod)) {
            $shippingReport->where('id', $shippingMethod);
        }

        return $shippingReport->withSum('orderDetails', 'price')->withCount(['orderDetails' => function ($query) {
            $query->select(DB::raw('count(distinct(order_id))'));
        }])->where('status', 'Active')->get();
    }

    /**
     * commission report
     *
     * @param  null  $vendor
     * @return [type]
     */
    public function getCommissionReport($vendor = null)
    {
        $orderCommission = OrderCommission::with(['OrderDetail:id,product_name,price,quantity', 'vendor:id,name']);
        if (! empty($vendor)) {
            $orderCommission->orWhereHas('vendor', function ($query) use ($vendor) {
                $query->where('name', $vendor);
            });
        }

        if ($this->checkVendorUser()) {
            $orderCommission->where('vendor_id', $this->checkVendorUser());
        }

        return $orderCommission->get();
    }

    /**
     * Sale Report
     *
     * @param  null  $from
     * @param  null  $to
     * @param  null  $orderStatus
     * @return [type]
     */
    public function getSaleReport($from = null, $to = null, $orderStatus = null)
    {
        $order = Order::join('order_details', 'orders.id', 'order_details.order_id')
            ->select(
                'order_details.id as order_detail_id',
                'orders.order_date',
                DB::raw('sum(order_details.price * order_details.quantity) as total'),
                DB::raw('count(distinct orders.id) as totalOrder'),
                DB::raw('FORMAT(sum(order_details.quantity) , 0) as totalProduct'),
                DB::raw('sum(order_details.shipping_charge) as total_shipping_charge'),
                DB::raw('sum(order_details.discount_amount) as total_discount_amount'),
                DB::raw('sum(order_details.tax_charge) as total_tax_charge'),
            );

        if (! empty($orderStatus)) {
            $order->where('order_details.order_status_id', $orderStatus);
        }

        if (! empty($from)) {
            $order->where('order_date', '>=', DbDateFormat($from));
        }
        if (! empty($to)) {
            $order->where('order_date', '<=', DbDateFormat($to));
        }
        if ($this->checkVendorUser()) {
            $order->where('order_details.vendor_id', $this->checkVendorUser());
        }

        return $order->groupBy('order_date')->get();
    }

    /**
     * Search Report
     *
     * @param  null  $name
     * @return [type]
     */
    public function getSearchReport($name = null)
    {
        $search = Search::select('id', 'name', 'total');
        if (! empty($name)) {
            $search->where('name', $name);
        }

        return $search->get();
    }
}
