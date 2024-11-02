<?php

/**
 * @author TechVillage <support@techvill.org>
 *
 * @contributor Sakawat Hossain Rony <[sakawat.techvill@gmail.com]>
 * @contributor Al Mamun <[almamun.techvill@gmail.com]>
 *
 * @created 07-09-2021
 *
 * @modified 04-10-2021
 */

namespace App\DataTables;

use App\Models\{
    Attribute
};
use Illuminate\Http\JsonResponse;

class AttributeDataTable extends DataTable
{
    /**
     * Handle the AJAX request for attribute groups.
     *
     * This function queries attribute groups and returns the data in a format suitable
     * for DataTables to consume via AJAX.
     */
    public function ajax(): JsonResponse
    {
        $this->dataTable
            ->editColumn('name', fn ($attributes) => '<a href="' . route('attribute.edit', ['id' => $attributes->id]) . '">' . wrapIt($attributes->name, 10, ['columns' => 2, 'trim' => true, 'trimLength' => 20]) . '</a>')
            ->editColumn('status', fn ($attributes) => statusBadges(lcfirst($attributes->status)))->addColumn('action', function ($attributes) {
                $edit = '<a data-bs-toggle="tooltip" title="' . __('Edit') . '" href="' . route('attribute.edit', ['id' => $attributes->id]) . '" class="action-icon"><i class="feather icon-edit-1 neg-transition-scale-svg"></i></a>&nbsp;';

                $delete = '<form method="post" action="' . route('attribute.destroy', ['id' => $attributes->id]) . '" id="delete-user-' . $attributes->id . '" accept-charset="UTF-8" class="display_inline">
                        ' . method_field('DELETE') . '
                        ' . csrf_field() . '
                        <a data-bs-toggle="tooltip" title="' . __('Delete') . '" class="action-icon confirm-delete" type="button" data-id=' . $attributes->id . ' data-delete="user" data-label="Delete" data-bs-toggle="modal" data-bs-target="#confirmDelete" data-title="' . __('Delete :x', ['x' => __('Attribute')]) . '" data-message="' . __('Are you sure to delete this?') . '">
                        <i class="feather icon-trash"></i>
                        </a>
                        </form>';

                $str = '';
                if ($this->hasPermission(['App\Http\Controllers\AttributeController@edit'])) {
                    $str .= $edit;
                }
                if ($this->hasPermission(['App\Http\Controllers\AttributeController@destroy'])) {
                    $str .= $delete;
                }

                return $str;
            })
            ->rawColumns(['group', 'name', 'status', 'is_filterable', 'action'])
            ->filter(function ($instance) {
                if (in_array(request('status'), getStatus())) {
                    $instance->where('status', request('status'));
                }
                if (request('group')) {
                    $instance->whereHas('attributeGroup', function ($query) {
                        $query->where('id', request('group'));
                    });
                }

                if (isset(request('search')['value'])) {
                    $keyword = xss_clean(request('search')['value']);
                    if (! empty($keyword)) {
                        $instance->where(function ($query) use ($keyword) {
                            $query->WhereLike('name', $keyword)
                                ->OrWhereLike('status', $keyword)
                                ->OrWhereLike('type', $keyword)
                                ->orWhereHas('attributeGroup', function ($query) use ($keyword) {
                                    $query->WhereLike('name', $keyword);
                                });
                        });
                    }
                }
            });

        return $this->makeAjax();
    }

    /*
    * DataTable Query
    *
    * @return mixed
    */
    public function query()
    {
        return $this->applyScopes(Attribute::query()->with(['attributeGroup']));
    }

    /*
    * DataTable HTML
    *
    * @return \Yajra\DataTables\Html\Builder
    */
    public function html()
    {
        $this->builder->addColumn(['data' => 'name', 'name' => 'name', 'title' => __('Name')])
            ->addColumn(['data' => 'status', 'name' => 'status', 'title' => __('Status')])
            ->addColumn(['data' => 'action', 'name' => 'action', 'title' => '', 'visible' => $this->hasPermission(['App\Http\Controllers\AttributeController@edit', 'App\Http\Controllers\AttributeController@destroy']), 'orderable' => false, 'searchable' => false, 'className' => 'text-right align-middle'])
            ->parameters(dataTableOptions(['dom' => 'Bfrtip']));

        return $this->makeHtml();
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
