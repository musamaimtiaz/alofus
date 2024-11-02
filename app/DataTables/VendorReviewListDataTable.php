<?php
/**
 * @author TechVillage <support@techvill.org>
 *
 * @contributor Al Mamun <[almamun.techvill@gmail.com]>
 *
 * @created 19-12-2021
 */

namespace App\DataTables;

use App\Models\Review;
use Illuminate\Http\JsonResponse;

class VendorReviewListDataTable extends DataTable
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
        $reviews = $this->query();

        return datatables()
            ->of($reviews)
            ->editColumn('product.name', function ($reviews) {
                return trimWords(optional($reviews->product)->name, 40);
            })
            ->editColumn('comments', function ($reviews) {
                return trimWords($reviews->comments, 40);
            })
            ->editColumn('user', function ($reviews) {
                return wrapIt(optional($reviews->user)->name, 10, ['columns' => 3]);
            })
            ->editColumn('status', function ($reviews) {
                return statusBadges(lcfirst($reviews->status));
            })
            ->addColumn('created_at', function ($reviews) {
                return timeZoneFormatDate($reviews->created_at);
            })
            ->addColumn('action', function ($reviews) {
                $edit = '<a title="' . __('Edit') . '" href="' . route('vendor.reviewEdit', ['id' => $reviews->id]) . '" class="action-icon pr-5 edit_review" data-bs-toggle="modal" data-bs-target="#edit-review" data-id=' . $reviews->id . '><i class="feather icon-edit-1 neg-transition-scale-svg "></i></a>&nbsp;';

                $view = '<a title="' . __('Show') . '" href="' . route('vendor.reviewView', ['id' => $reviews->id]) . '" class="action-icon me-1"><i class="feather icon-eye"></i></a>&nbsp;';

                $delete = '<form method="post" action="' . route('vendor.reviewDestroy', ['id' => $reviews->id]) . '" id="delete-review-' . $reviews->id . '" accept-charset="UTF-8" class="display_inline">
                        ' . csrf_field() . '
                        <a title="' . __('Delete') . '" class="action-icon confirm-delete" type="button" data-id=' . $reviews->id . ' data-delete="review" data-label="Delete" data-bs-toggle="modal" data-bs-target="#confirmDelete" data-title="' . __('Delete :x', ['x' => __('Review')]) . '" data-message="' . __('Are you sure to delete this?') . '">
                        <i class="feather icon-trash"></i>
                        </a>
                        </form>';

                $str = '';
                if ($this->hasPermission(['App\Http\Controllers\Vendor\ReviewController@view'])) {
                    $str .= $view;
                }
                if ($this->hasPermission(['App\Http\Controllers\Vendor\ReviewController@edit'])) {
                    $str .= $edit;
                }
                if ($this->hasPermission(['App\Http\Controllers\Vendor\ReviewController@destroy'])) {
                    $str .= $delete;
                }

                return $str;
            })

            ->rawColumns(['comments', 'product.name', 'user', 'status', 'created_at', 'action'])
            ->make(true);
    }

    /*
    * DataTable Query
    *
    * @return mixed
    */
    public function query()
    {
        $reviews = Review::select('reviews.id', 'comments', 'product_id', 'user_id', 'rating', 'reviews.status')->whereHas('product', function ($query) {
            $query->where('vendor_id', auth()->user()->vendor()->vendor_id);
        })->with(['product:id,name', 'user:id,name'])->filter();

        return $this->applyScopes($reviews);
    }

    /*
    * DataTable HTML
    *
    * @return \Yajra\DataTables\Html\Builder
    */
    public function html()
    {
        return $this->builder()
            ->addColumn(['data' => 'comments', 'name' => 'comments', 'title' => __('Comments'), 'className' => 'align-middle'])
            ->addColumn(['data' => 'product.name', 'name' => 'product.name', 'title' => __('Product'), 'className' => 'align-middle'])
            ->addColumn(['data' => 'user', 'name' => 'user.name', 'title' => __('Customer'), 'className' => 'align-middle'])
            ->addColumn(['data' => 'rating', 'name' => 'rating', 'title' => __('Rating'), 'className' => 'text-center align-middle'])
            ->addColumn(['data' => 'status', 'name' => 'status', 'title' => __('Status'), 'className' => 'align-middle'])
            ->addColumn(['data' => 'created_at', 'name' => 'created_at', 'title' => __('Created')])
            ->addColumn(['data' => 'action', 'name' => 'action', 'title' => '', 'width' => '11%',
                'visible' => $this->hasPermission(['App\Http\Controllers\Vendor\ReviewController@edit', 'App\Http\Controllers\Vendor\ReviewController@show', 'App\Http\Controllers\Vendor\ReviewController@destroy']),
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
