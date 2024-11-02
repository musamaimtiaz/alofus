<?php

/**
 * @author TechVillage <support@techvill.org>
 *
 * @contributor Kabir Ahmed <[kabir.techvill@gmail.com]>
 *
 * @created 29-12-2021
 */

namespace Modules\Blog\DataTables;

use App\DataTables\DataTable;
use Illuminate\Http\JsonResponse;
use Modules\Blog\Http\Models\BlogCategory;

class BlogCategoryDataTable extends DataTable
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
        $category = $this->query();

        return datatables()
            ->of($category)

            ->editColumn('name', function ($category) {
                return wrapIt(ucfirst($category->name), 30);
            })->editColumn('status', function ($category) {
                return statusBadges(lcfirst($category->status));
            })->editColumn('created_at', function ($category) {
                return $category->format_created_at;
            })->addColumn('action', function ($category) {
                $edit = '<a title="' . __('Edit :x', ['x' => __('Category')]) . '" href="javascript:void(0) " class="action-icon edit-blog-category" data-bs-toggle="modal" data-bs-target="#edit-payment" id="' . $category->id . '" name="' . $category->name . '" status="' . $category->status . '"><i class="feather icon-edit-1 neg-transition-scale-svg  edit-blog-category"></i></a>&nbsp';

                $delete = '<form method="post" action="' . route('blog.category.delete', ['id' => $category->id]) . '" id="delete-Category-' . $category->id . '" accept-charset="UTF-8" class="display_inline">
                        ' . csrf_field() . '
                        <a title="' . __('Delete :x', ['x' => __('Category.')]) . '" class="action-icon confirm-delete" type="button" data-id=' . $category->id . ' data-label="Delete" data-delete="Category" data-bs-toggle="modal" data-bs-target="#confirmDelete" data-title="' . __('Delete :x', ['x' => __('Category')]) . '" data-message="' . __('Are you sure to delete this?') . '">
                        <i class="feather icon-trash"></i>
                        </a>
                        </form>';
                $str = '';
                if ($this->hasPermission(['Modules\Blog\Http\Controllers\BlogCategoryController@update'])) {
                    $str .= $edit;
                }
                if ($this->hasPermission(['Modules\Blog\Http\Controllers\BlogCategoryController@delete']) && $category->id != 1) {
                    $str .= $delete;
                }

                return $str;
            })

            ->rawColumns(['name', 'status', 'action'])
            ->filter(function ($instance) {
                if (request('status') && (request('status') == 'Active' || request('status') == 'Inactive')) {
                    $instance->where('status', request('status'));
                }
                if (request('category_id')) {
                    $instance->where('id', request('category_id'));
                }
                if (isset(request('search')['value'])) {
                    $keyword = xss_clean(request('search')['value']);
                    if (! empty($keyword)) {
                        $instance->where(function ($query) use ($keyword) {
                            $query->Where('name', 'like', '%' . $keyword . '%');
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
        $category = BlogCategory::getAllBlogCategory();

        return $this->applyScopes($category);
    }

    /*
    * DataTable HTML
    *
    * @return \Yajra\DataTables\Html\Builder
    */
    public function html()
    {
        return $this->builder()

            ->addColumn(['data' => 'name', 'name' => 'name', 'title' => __('Name'), 'className' => 'align-middle'])
            ->addColumn(['data' => 'status', 'name' => 'status', 'title' => __('Status'), 'orderable' => false, 'searchable' => false, 'className' => 'align-middle'])
            ->addColumn(['data' => 'created_at', 'name' => 'created_at', 'title' => __('Created At'), 'className' => 'align-middle'])
            ->addColumn([
                'data' => 'action', 'name' => 'action', 'title' => '', 'width' => '10%',
                'visible' => $this->hasPermission(['Modules\Blog\Http\Controllers\BlogCategoryController@edit', 'Modules\Blog\Http\Controllers\BlogCategoryController@delete']),
                'orderable' => false, 'searchable' => false, 'className' => 'text-right align-middle',
            ])
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
