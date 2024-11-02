<?php
/**
 * @author TechVillage <support@techvill.org>
 *
 * @contributor Al Mamun <[almamun.techvill@gmail.com]>
 *
 * @created 28-11-2021
 */

namespace Modules\Coupon\DataTables;

use App\DataTables\DataTable;
use Illuminate\Http\JsonResponse;
use Modules\Coupon\Http\Models\CouponRedeem;

class CouponRedeemDataTable extends DataTable
{
    /*
    * DataTable HTML
    *
    * @return \Yajra\DataTables\Html\Builder
    */
    public function ajax(): JsonResponse
    {
        $redeem = $this->query();

        return datatables()
            ->of($redeem)

            ->editColumn('coupon', function ($redeem) {
                if (is_null($redeem->coupon)) {
                    return wrapIt($redeem->coupon_code, 10, ['columns' => 3]);
                }

                return '<a target="_blank" href="' . route('coupon.edit', ['id' => $redeem->coupon_id]) . '">' . wrapIt($redeem->coupon_code, 10, ['columns' => 3]) . '</a>';
            })->editColumn('user', function ($redeem) {
                if (is_null($redeem->user)) {
                    return wrapIt(__('Guest'), 10, ['columns' => 3]);
                }

                return '<a target="_blank" href="' . route('users.edit', ['id' => $redeem->user_id]) . '">' . wrapIt($redeem->user_name, 10, ['columns' => 3]) . '</a>';
            })->editColumn('order', function ($redeem) {
                if (is_null($redeem->order)) {
                    return wrapIt($redeem->order_code, 10, ['columns' => 3]);
                }

                return '<a target="_blank" href="' . route('order.view', ['id' => $redeem->order_id]) . '">' . wrapIt($redeem->order_code, 10, ['columns' => 3]) . '</a>';
            })->editColumn('discount_amount', function ($redeem) {
                return formatNumber($redeem->discount_amount);
            })->addColumn('created_at', function ($redeem) {
                return $redeem->format_created_at;
            })

            ->rawColumns(['coupon', 'user', 'order', 'discount_amount'])
            ->make(true);
    }

    /*
    * DataTable Query
    *
    * @return mixed
    */
    public function query()
    {
        $couponRedeems = CouponRedeem::select('*')->with(['user:id,name', 'order:id,reference', 'coupon:id,name'])->filter();

        return $this->applyScopes($couponRedeems);
    }

    /*
    * DataTable HTML
    *
    * @return \Yajra\DataTables\Html\Builder
    */
    public function html()
    {
        return $this->builder()
            ->addColumn(['data' => 'coupon', 'name' => 'coupon_code', 'title' => __('Coupon'), 'className' => 'align-middle'])
            ->addColumn(['data' => 'user', 'name' => 'user_name', 'title' => __('Customer'), 'className' => 'align-middle'])
            ->addColumn(['data' => 'order', 'name' => 'order_code', 'title' => __('Order'), 'className' => 'align-middle'])
            ->addColumn(['data' => 'discount_amount', 'name' => 'discount_amount', 'title' => __('Discount Amount'), 'className' => 'align-middle'])
            ->addColumn(['data' => 'created_at', 'name' => 'created_at', 'title' => __('Created at'), 'className' => 'text-right align-middle'])
            ->parameters(dataTableOptions(['dom' => 'Bfrtip']));
    }
}
