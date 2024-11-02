<?php
/**
 * @author TechVillage <support@techvill.org>
 *
 * @contributor Al Mamun <[almamun.techvill@gmail.com]>
 *
 * @created 19-12-2021
 */

namespace Modules\Coupon\DataTables;

use App\DataTables\DataTable;
use Illuminate\Http\JsonResponse;
use Modules\Coupon\Http\Models\Coupon;

class VendorCouponDataTable extends DataTable
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
        $coupons = $this->query();

        return datatables()
            ->of($coupons)

            ->editColumn('name', function ($coupons) {
                return wrapIt($coupons->name, 10, ['columns' => 2]);
            })->editColumn('code', function ($coupons) {
                return wrapIt($coupons->code, 10, ['columns' => 2]);
            })->editColumn('discount_type', function ($coupons) {
                return $coupons->discount_type;
            })->editColumn('discount_amount', function ($coupons) {
                return $coupons->discount_type == 'Flat' ? formatNumber($coupons->discount_amount) : formatCurrencyAmount($coupons->discount_amount) . '%';
            })->editColumn('start_date', function ($coupons) {
                return timeZoneFormatDate($coupons->start_date);
            })->editColumn('end_date', function ($coupons) {
                return timeZoneFormatDate($coupons->end_date);
            })->editColumn('status', function ($coupons) {
                return statusBadges(lcfirst($coupons->status));
            })->addColumn('action', function ($coupons) {
                $edit = '<a title="' . __('Edit :x', ['x' => __('Coupon')]) . '" href="' . route('vendor.couponEdit', ['id' => $coupons->id]) . '" class="action-icon"><i class="feather icon-edit-1 neg-transition-scale-svg "></i></a>&nbsp';

                $delete = '<form method="post" action="' . route('vendor.couponDelete', ['id' => $coupons->id]) . '" id="delete-coupons-' . $coupons->id . '" accept-charset="UTF-8" class="display_inline">
                        ' . csrf_field() . '
                        <a title="' . __('Delete :x', ['x' => __('Coupon')]) . '" class="action-icon confirm-delete" type="button" data-id=' . $coupons->id . ' data-label="Delete" data-delete="coupons" data-bs-toggle="modal" data-bs-target="#confirmDelete" data-title="' . __('Delete :x', ['x' => __('Coupon')]) . '" data-message="' . __('Are you sure to delete this?') . '">
                        <i class="feather icon-trash"></i>
                        </a>
                        </form>';
                $str = '';
                if ($this->hasPermission(['Modules\Coupon\Http\Controllers\Vendor\CouponController@edit'])) {
                    $str .= $edit;
                }
                if ($this->hasPermission(['Modules\Coupon\Http\Controllers\Vendor\CouponController@destroy'])) {
                    $str .= $delete;
                }

                return $str;
            })

            ->rawColumns(['name', 'code', 'discount_type', 'discount_amount', 'start_date', 'end_date', 'status', 'action'])
            ->filter(function ($instance) {
                if (in_array(request('status'), ['Active', 'Inactive', 'Pending'])) {
                    $instance->where('status', request('status'));
                }

                if (isset(request('search')['value'])) {
                    $keyword = xss_clean(request('search')['value']);
                    if (! empty($keyword)) {
                        $instance->where(function ($query) use ($keyword) {
                            $query->WhereLike('name', $keyword)
                                ->OrWhereLike('code', $keyword)
                                ->OrWhereLike('discount_type', $keyword)
                                ->OrWhereLike('discount_amount', $keyword)
                                ->OrWhereLike('status', $keyword);
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
        $coupons = Coupon::select('id', 'name', 'code', 'discount_type', 'discount_amount', 'start_date', 'end_date', 'status')->where('vendor_id', session()->get('vendorId'));

        return $this->applyScopes($coupons);
    }

    /*
    * DataTable HTML
    *
    * @return \Yajra\DataTables\Html\Builder
    */
    public function html()
    {
        return $this->builder()
            ->addColumn(['data' => 'name', 'name' => 'name', 'title' => __('Name'), 'className' => 'text-left align-middle'])
            ->addColumn(['data' => 'code', 'name' => 'code', 'title' => __('Code'), 'className' => 'align-middle'])
            ->addColumn(['data' => 'discount_type', 'name' => 'discount_type', 'title' => __('Discount Type'), 'visible' => false])
            ->addColumn(['data' => 'discount_amount', 'name' => 'discount_amount', 'title' => __('Discount Amount'), 'className' => 'align-middle text-center'])
            ->addColumn(['data' => 'start_date', 'name' => 'start_date', 'title' => __('Start Date'), 'className' => 'align-middle'])
            ->addColumn(['data' => 'end_date', 'name' => 'end_date', 'title' => __('End Date'), 'className' => 'align-middle'])
            ->addColumn(['data' => 'status', 'name' => 'status', 'title' => __('Status'), 'className' => 'align-middle'])
            ->addColumn(['data' => 'action', 'name' => 'action', 'title' => '', 'width' => '10%',
                'visible' => $this->hasPermission(['Modules\Coupon\Http\Controllers\Vendor\CouponController@edit', 'Modules\Coupon\Http\Controllers\Vendor\CouponController@destroy']),
                'orderable' => false, 'searchable' => false, 'className' => 'text-right align-middle'])
            ->parameters(dataTableOptions(['dom' => 'Bfrtip']));
    }

    public function setViewData()
    {
        $statusCounts = $this->query()
            ->selectRaw('status, COUNT(*) as count')
            ->groupBy('status')
            ->pluck('count', 'status');

        $this->data['groups'] = ['All' => $statusCounts->sum()] + $statusCounts->toArray();
    }
}
