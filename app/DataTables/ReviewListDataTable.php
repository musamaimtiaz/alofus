<?php
/**
 * @author TechVillage <support@techvill.org>
 *
 * @contributor Sakawat Hossain Rony <[sakawat.techvill@gmail.com]>
 *
 * @created 15-11-2021
 */

namespace App\DataTables;

use App\Models\Review;
use Illuminate\Http\JsonResponse;

class ReviewListDataTable extends DataTable
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
                return '<a target="_blank" href="' . route('site.productDetails', ['slug' => $reviews->product->slug]) . '">' . trimWords(optional($reviews->product)->name, 40) . '</a>';
            })

            ->editColumn('comments', function ($reviews) {
                return trimWords($reviews->comments, 40);
            })

            ->editColumn('user.name', function ($reviews) {
                return '<a target="_blank" href="' . route('users.edit', ['id' => ($reviews->user)->id]) . '">' . wrapIt(($reviews->user)->name, 10, ['columns' => 3]) . '</a>';
            })
            ->editColumn('status', function ($reviews) {
                return statusBadges($reviews->status);
            })
            ->editColumn('rating', function ($reviews) {
                return $reviews->rating;
            })
            ->editColumn('created_at', function ($reviews) {
                return $reviews->format_created_at;
            })

            ->addColumn('action', function ($reviews) {
                $edit = '<a title="' . __('Edit') . '" href="' . route('review.edit', ['id' => $reviews->id]) . '" class="action-icon pr-5 edit_review" data-bs-toggle="modal" data-bs-target="#edit-review" data-id=' . $reviews->id . '><i class="feather icon-edit-1 neg-transition-scale-svg "></i></a>&nbsp;';

                $view = '<a data-bs-toggle="tooltip" title="' . __('Show') . '" href="' . route('review.view', ['id' => $reviews->id]) . '" class="action-icon me-1"><i class="feather icon-eye"></i></a>&nbsp;';

                $delete = '<form method="post" action="' . route('review.destroy', ['id' => $reviews->id]) . '" id="delete-review-' . $reviews->id . '" accept-charset="UTF-8" class="display_inline">
                        ' . csrf_field() . '
                        <a title="' . __('Delete') . '" class="action-icon confirm-delete" type="button" data-id=' . $reviews->id . ' data-delete="review" data-label="Delete" data-bs-toggle="modal" data-bs-target="#confirmDelete" data-title="' . __('Delete :x', ['x' => __('Review')]) . '" data-message="' . __('Are you sure to delete this?') . '">
                        <i class="feather icon-trash"></i>
                        </a>
                        </form>';

                $str = '';
                if ($this->hasPermission(['App\Http\Controllers\ReviewController@view'])) {
                    $str .= $view;
                }
                if ($this->hasPermission(['App\Http\Controllers\ReviewController@edit'])) {
                    $str .= $edit;
                }
                if ($this->hasPermission(['App\Http\Controllers\ReviewController@destroy'])) {
                    $str .= $delete;
                }

                return $str;
            })

            ->rawColumns(['comments', 'product.name', 'user.name', 'status', 'rating', 'action', 'created_at'])
            ->make(true);
    }

    /*
    * DataTable Query
    *
    * @return mixed
    */
    public function query()
    {
        $reviews = Review::select('reviews.id', 'comments', 'product_id', 'user_id', 'rating', 'reviews.status', 'reviews.created_at')->with(['product:id,name,slug', 'user:id,name'])->whereHas('product')->filter();

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

            ->addColumn(['data' => 'id', 'name' => 'id', 'title' => __('#'), 'visible' => false])

            ->addColumn(['data' => 'comments', 'name' => 'comments', 'title' => __('Comments'), 'className' => 'align-middle'])

            ->addColumn(['data' => 'product.name', 'name' => 'product.name', 'title' => __('Product'), 'className' => 'align-middle'])

            ->addColumn(['data' => 'user.name', 'name' => 'user.name', 'title' => __('Customer'), 'className' => 'align-middle'])

            ->addColumn(['data' => 'rating', 'name' => 'rating', 'title' => __('Rating'), 'className' => 'align-middle'])

            ->addColumn(['data' => 'status', 'name' => 'status', 'title' => __('Status'), 'className' => 'align-middle'])

            ->addColumn(['data' => 'created_at', 'name' => 'created_at', 'title' => __('Created'), 'className' => 'align-middle', 'width' => '12%'])

            ->addColumn(['data' => 'action', 'name' => 'action', 'title' => __('Action'), 'width' => '10%',
                'visible' => $this->hasPermission(['App\Http\Controllers\ReviewController@edit', 'App\Http\Controllers\ReviewController@destroy']),
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
