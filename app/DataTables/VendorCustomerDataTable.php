<?php

/**
 * @author TechVillage <support@techvill.org>
 *
 * @contributor Md. Mostafijur Rahman <[mostafijur.techvill@gmail.com]>
 *
 * @created 26-10-2023
 */

namespace App\DataTables;

use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;

class VendorCustomerDataTable extends DataTable
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
        $users = $this->query();

        return datatables()
            ->of($users)
            ->editColumn('customer', function ($users) {
                if (! is_null($users->id)) {
                    return wrapIt($users->user_name, 10, ['columns' => 2]);
                }

                return wrapIt(__('Guest'), 10, ['columns' => 2]);
            })
            ->editColumn('email', function ($users) {
                if (! is_null($users->id)) {
                    return $users->email;
                }

                return wrapIt(__('Guest'), 10, ['columns' => 2]);
            })
            ->editColumn('total_orders', function ($users) {

                return $users->total_orders;
            })
            ->rawColumns(['customer', 'email', 'total_orders'])
            ->filter(function ($instance) {
                if (isset(request('search')['value'])) {
                    $keyword = xss_clean(request('search')['value']);
                    if (! empty($keyword)) {
                        $instance->where(function ($query) use ($keyword) {
                            $query->where('users.name', 'like', "%{$keyword}%")
                                ->orWhere('users.email', 'like', "%{$keyword}%");
                        });
                    }
                }
            })
            ->make(true);
    }

    /*
    * DataTable Query
    *
    * @return mixed
    */
    public function query()
    {
        $vendorId = session('vendorId');
        $users = DB::table('vendors')
            ->join('order_details', 'vendors.id', '=', 'order_details.vendor_id')
            ->join('orders', 'order_details.order_id', '=', 'orders.id')
            ->join('users', 'orders.user_id', '=', 'users.id')
            ->select('vendors.id as id', 'users.name as user_name', 'users.email', DB::raw('count(distinct orders.id) as total_orders'))
            ->where('vendors.id', $vendorId)
            ->groupBy('users.name', 'users.email');

        return $this->applyScopes($users);
    }

    /*
    * DataTable HTML
    *
    * @return \Yajra\DataTables\Html\Builder
    */
    public function html()
    {
        return $this->builder()
            ->addColumn(['data' => 'id', 'name' => 'id', 'title' => __('Id'), 'visible' => false, 'searchable' => false])
            ->addColumn(['data' => 'customer', 'name' => 'user_name', 'title' => __('Customer')])
            ->addColumn(['data' => 'email', 'name' => 'user.email', 'title' => __('Email'), 'orderable' => false])
            ->addColumn(['data' => 'total_orders', 'name' => 'total_orders', 'title' => __('Total Orders'), 'width' => '15%', 'searchable' => false, 'className' => 'align-middle text-center'])
            ->parameters(dataTableOptions(['dom' => 'Bfrtip', 'order' => [3]]));
    }
}
