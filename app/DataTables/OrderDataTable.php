<?php
/**
 * @author TechVillage <support@techvill.org>
 *
 * @contributor Sakawat Hossain Rony <[sakawat.techvill@gmail.com]>
 *
 * @created 19-01-2022
 */

namespace App\DataTables;

use App\Models\Order;
use Illuminate\Http\JsonResponse;

class OrderDataTable extends DataTable
{
    /**
     * Handle the AJAX request for attribute groups.
     *
     * This function queries attribute groups and returns the data in a format suitable
     * for DataTables to consume via AJAX.
     *
      @return \Illuminate\Http\JsonResponse
     */
    public function ajax(): JsonResponse
    {
        $orders = $this->query();

        return datatables()
            ->of($orders)

            ->editColumn('customer', function ($orders) {
                if (! is_null(optional($orders->user)->id)) {
                    return '<a target="_blank" href="' . route('users.edit', ['id' => optional($orders->user)->id]) . '">' . wrapIt(optional($orders->user)->name, 10, ['columns' => 2]) . '</a>';
                }

                return wrapIt(__('Guest'), 10, ['columns' => 2]);
            })->editColumn('total', function ($orders) {
                return formatNumber($orders->total, optional($orders->currency)->symbol);
            })->editColumn('reference', function ($orders) {
                return '<a href="' . route('order.view', ['id' => $orders->id]) . '">' . $orders->reference . '</a>';
            })->editColumn('status', function ($orders) {
                return '<span class="f-w-600 f-12 text-muted text-uppercase">' . optional($orders->orderStatus)->name . '</span>';
            })->addColumn('created_at', function ($orders) {
                return $orders->format_created_at;
            })->editColumn('payment_status', function ($orders) {
                return statusBadges($orders->payment_status);
            })->addColumn('vendor', function ($orders) {
                return $orders->vendorName($orders->id);
            })

            ->addColumn('action', function ($orders) {
                $view = '<a title="' . __('Show') . '" href="' . route('order.view', ['id' => $orders->id]) . '" class="action-icon view-order" data-id=' . $orders->id . ' data-payment=' . $orders->payment_status . '><i class="feather icon-eye"></i></a>';
                $delete = '<form method="post" action="' . route('order.destroy', ['id' => $orders->id]) . '" id="delete-order-' . $orders->id . '" accept-charset="UTF-8" class="display_inline">
                        ' . method_field('DELETE') . '
                        ' . csrf_field() . '
                        <a title="' . __('Delete') . '" class="action-icon confirm-delete" type="button" data-id=' . $orders->id . ' data-delete="order" data-label="Delete" data-bs-toggle="modal" data-bs-target="#confirmDelete" data-title="' . __('Delete :x', ['x' => __('Order')]) . '" data-message="' . __('Are you sure to delete this?') . '">
                        <i class="feather icon-trash"></i>
                        </a>
                        </form>';

                $str = '';
                if ($this->hasPermission(['App\Http\Controllers\AdminOrderController@view'])) {
                    $str .= $view;
                }
                if ($this->hasPermission(['App\Http\Controllers\AdminOrderController@destroy'])) {
                    $str .= $delete;
                }

                return $str;
            })

            ->rawColumns(['customer', 'total', 'status', 'created_at', 'reference', 'action', 'payment_status', 'vendor'])
            ->make(true);
    }

    /*
    * DataTable Query
    *
    * @return mixed
    */
    public function query()
    {
        $orders = Order::select('orders.id', 'user_id', 'reference', 'order_date', 'currency_id', 'other_discount_amount', 'other_discount_type', 'shipping_charge', 'tax_charge', 'total', 'paid', 'order_status_id', 'payment_status', 'orders.created_at')->with(['orderDetails:id,product_id,order_id,vendor_id,shop_id,price,quantity,discount_amount,discount_type,order_status_id', 'orderStatus:id,slug,name', 'user:id,name'])->filter();

        return $this->applyScopes($orders);
    }

    /*
    * DataTable HTML
    *
    * @return \Yajra\DataTables\Html\Builder
    */
    public function html()
    {
        return $this->builder()

            ->addColumn(['data' => 'id', 'name' => 'id', 'title' => __('Id'), 'visible' => false, 'className' => 'text-left align-middle'])
            ->addColumn(['data' => 'reference', 'name' => 'reference', 'title' => __('Order'), 'className' => 'align-middle'])

            ->addColumn(['data' => 'customer', 'name' => 'user.name', 'title' => __('Customer'), 'className' => 'align-middle'])

            ->addColumn(['data' => 'vendor', 'name' => 'vendor', 'title' => __('Vendors'), 'orderable' => false, 'searchable' => false, 'className' => 'align-middle'])

            ->addColumn(['data' => 'total', 'name' => 'total', 'title' => __('Total'), 'className' => 'align-middle'])

            ->addColumn(['data' => 'status', 'name' => 'orderStatus.name', 'title' => __('Order Status'), 'className' => 'align-middle'])

            ->addColumn(['data' => 'payment_status', 'name' => 'payment_status', 'title' => __('Payment Status'), 'className' => 'align-middle'])

            ->addColumn(['data' => 'created_at', 'name' => 'created_at', 'title' => __('Created'), 'className' => 'align-middle'])

            ->addColumn(['data' => 'action', 'name' => 'action', 'title' => '', 'width' => '8%',
                'visible' => $this->hasPermission(['App\Http\Controllers\AdminOrderController@view', 'App\Http\Controllers\AdminOrderController@destroy']),
                'orderable' => false, 'searchable' => false, 'className' => 'text-right align-middle'])

            ->parameters(dataTableOptions(['dom' => 'Bfrtip']));
    }

    public function setViewData()
    {
        $statusCounts = \DB::table('orders')
            ->join('order_statuses', 'orders.order_status_id', '=', 'order_statuses.id')
            ->selectRaw('order_statuses.name, COUNT(*) as count')
            ->groupBy('order_statuses.name')
            ->pluck('count', 'order_statuses.name');

        $this->data['groups'] = ['All' => $statusCounts->sum()] + $statusCounts->toArray();
    }
}
