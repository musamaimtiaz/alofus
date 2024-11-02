<?php
/**
 * @author TechVillage <support@techvill.org>
 *
 * @contributor Sakawat Hossain Rony <[sakawat.techvill@gmail.com]>
 * @contributor Al Mamun <[almamun.techvill@gmail.com]>
 *
 * @created 06-09-2021
 *
 * @modified 04-10-2021
 */

namespace App\DataTables;

use App\Models\{
    AttributeGroup
};
use Illuminate\Http\JsonResponse;

class AttributeGroupDataTable extends DataTable
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
        $attributeGroups = $this->query();

        return datatables()
            ->of($attributeGroups)

            ->addColumn('name', function ($attributeGroups) {
                return '<a href="' . route('attributeGroup.edit', ['id' => $attributeGroups->id]) . '">' . wrapIt($attributeGroups->name, 10, ['columns' => 2, 'trim' => true, 'trimLength' => 20]) . '</a>';
            })

            ->addColumn('created_at', function ($attributes) {
                return $attributes->format_created_at;
            })

            ->addColumn('vendor', function ($attributeGroups) {
                return wrapIt(optional($attributeGroups->vendor)->name, 10, ['columns' => 2]);
            })->addColumn('status', function ($attributeGroups) {
                return statusBadges(lcfirst($attributeGroups->status));
            })->addColumn('action', function ($attributeGroups) {
                $edit = '<a title="' . __('Edit') . '" href="' . route('attributeGroup.edit', ['id' => $attributeGroups->id]) . '" class="btn btn-xs btn-primary"><i class="feather icon-edit neg-transition-scale-svg "></i></a>&nbsp;';

                $delete = '<form method="post" action="' . route('attributeGroup.destroy', ['id' => $attributeGroups->id]) . '" id="delete-user-' . $attributeGroups->id . '" accept-charset="UTF-8" class="display_inline">
                        ' . method_field('DELETE') . '
                        ' . csrf_field() . '
                        <button title="' . __('Delete') . '" class="btn btn-xs btn-danger confirm-delete" type="button" data-id=' . $attributeGroups->id . ' data-delete="user" data-label="Delete" data-bs-toggle="modal" data-bs-target="#confirmDelete" data-title="' . __('Delete :x', ['x' => __('Attribute Group')]) . '" data-message="' . __('Are you sure to delete this?') . '">
                        <i class="feather icon-trash-2"></i>
                        </button>
                        </form>';

                $str = '';
                if ($this->hasPermission(['App\Http\Controllers\AttributeGroupController@edit'])) {
                    $str .= $edit;
                }
                if ($this->hasPermission(['App\Http\Controllers\AttributeGroupController@destroy'])) {
                    $str .= $delete;
                }

                return $str;
            })

            ->rawColumns(['vendor', 'name', 'status', 'action'])
            ->filter(function ($instance) {
                if (in_array(request('status'), getStatus())) {
                    $instance->where('status', request('status'));
                }
                if (request('vendor')) {
                    $instance->whereHas('vendor', function ($query) {
                        $query->where('id', request('vendor'));
                    });
                }
                if (isset(request('search')['value'])) {
                    $keyword = xss_clean(request('search')['value']);
                    if (! empty($keyword)) {
                        $instance->where(function ($query) use ($keyword) {
                            $query->WhereLike('name', $keyword)
                                ->OrWhereLike('status', $keyword)
                                ->orWhereHas('vendor', function ($query) use ($keyword) {
                                    $query->WhereLike('name', $keyword);
                                });
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
        $attributeGroups = AttributeGroup::query()->with(['vendor']);

        return $this->applyScopes($attributeGroups);
    }

    /*
    * DataTable HTML
    *
    * @return \Yajra\DataTables\Html\Builder
    */
    public function html()
    {
        return $this->builder()

            ->addColumn(['data' => 'name', 'name' => 'name', 'title' => __('Name')])

            ->addColumn(['data' => 'vendor', 'name' => 'vendor', 'title' => __('Vendor')])

            ->addColumn(['data' => 'status', 'name' => 'status', 'title' => __('Status')])

            ->addColumn(['data' => 'created_at', 'name' => 'created_at', 'title' => __('Created at')])

            ->addColumn(['data' => 'action', 'name' => 'action', 'title' => __('Action'), 'width' => '5%',
                'visible' => $this->hasPermission(['App\Http\Controllers\AttributeGroupController@edit', 'App\Http\Controllers\AttributeGroupController@destroy']),
                'orderable' => false, 'searchable' => false])

            ->parameters(dataTableOptions());
    }
}
