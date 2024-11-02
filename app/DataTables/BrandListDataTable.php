<?php
/**
 * @author TechVillage <support@techvill.org>
 *
 * @contributor Sakawat Hossain Rony <[sakawat.techvill@gmail.com]>
 * @contributor Al Mamun <[almamun.techvill@gmail.com]>
 *
 * @created 25-08-2021
 *
 * @modified 04-10-2021
 */

namespace App\DataTables;

use App\Models\{
    Brand
};
use Illuminate\Http\JsonResponse;

class BrandListDataTable extends DataTable
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
        $brands = $this->query();

        return datatables()
            ->of($brands)

            ->addColumn('image', function ($brands) {
                return '<img class="rounded" src="' . $brands->fileUrl() . '" alt="' . __('image') . '" width="40" height="40">';
            })

            ->editColumn('name', function ($brands) {
                return '<a href="' . route('brands.edit', ['id' => $brands->id]) . '">' . wrapIt($brands->name, 10, ['columns' => 2]) . '</a>';
            })
            ->editColumn('product_count', function ($brands) {
                return $brands->product_count;
            })
            ->editColumn('status', function ($brands) {
                return statusBadges(lcfirst($brands->status));
            })->editColumn('created_at', function ($brands) {
                return $brands->format_created_at;
            })
            ->addColumn('action', function ($brands) {
                $edit = '<a title="' . __('Edit') . '" href="' . route('brands.edit', ['id' => $brands->id]) . '" class="action-icon"><i class="feather icon-edit-1"></i></a>';

                $delete = '<form method="post" action="' . route('brands.destroy', ['id' => $brands->id]) . '" id="delete-user-' . $brands->id . '" accept-charset="UTF-8" class="display_inline">
                        ' . csrf_field() . '
                        <a title="' . __('Delete') . '" class="action-icon confirm-delete" type="button" data-id=' . $brands->id . ' data-delete="user" data-label="Delete" data-bs-toggle="modal" data-bs-target="#confirmDelete" data-title="' . __('Delete :x', ['x' => __('Brand')]) . '" data-message="' . __('Are you sure to delete this?') . '">
                        <i class="feather icon-trash"></i>
                        </a>
                        </form>';

                $str = '';
                if ($this->hasPermission(['App\Http\Controllers\BrandController@edit'])) {
                    $str .= $edit;
                }
                if ($this->hasPermission(['App\Http\Controllers\BrandController@destroy'])) {
                    $str .= $delete;
                }

                return $str;
            })

            ->rawColumns(['image', 'name', 'status', 'action'])
            ->filter(function ($instance) {
                if (in_array(request('status'), getStatus())) {
                    $instance->where('status', request('status'));
                }

                if (isset(request('search')['value'])) {
                    $keyword = xss_clean(request('search')['value']);
                    if (! empty($keyword)) {
                        $instance->where(function ($query) use ($keyword) {
                            $query->WhereLike('name', $keyword)
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
        $brands = Brand::query()->withCount('product');

        return $this->applyScopes($brands);
    }

    /*
    * DataTable HTML
    *
    * @return \Yajra\DataTables\Html\Builder
    */
    public function html()
    {
        return $this->builder()

            ->addColumn(['data' => 'image', 'name' => 'image', 'title' => __('Image'), 'orderable' => false, 'searchable' => false, 'className' => 'align-middle text-left', 'width' => '5%'])

            ->addColumn(['data' => 'name', 'name' => 'name', 'title' => __('Name'), 'className' => 'align-middle'])

            ->addColumn(['data' => 'status', 'name' => 'status', 'title' => __('Status'), 'className' => 'align-middle'])

            ->addColumn(['data' => 'product_count', 'name' => 'product_count', 'title' => __('Total Products'), 'className' => 'align-middle'])

            ->addColumn(['data' => 'created_at', 'name' => 'created_at', 'title' => __('Created at'), 'className' => 'align-middle'])

            ->addColumn(['data' => 'action', 'name' => 'action', 'title' => '', 'width' => '10%',
                'visible' => $this->hasPermission(['App\Http\Controllers\BrandController@edit', 'App\Http\Controllers\BrandController@destroy']),
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
