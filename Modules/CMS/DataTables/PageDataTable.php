<?php

/**
 * @author TechVillage <support@techvill.org>
 *
 * @contributor Kabir Ahmed <[kabir.techvill@gmail.com]>
 *
 * @created 27-12-2021
 */

namespace Modules\CMS\DataTables;

use App\DataTables\DataTable;
use Illuminate\Http\JsonResponse;
use Modules\CMS\Http\Models\Page;

class PageDataTable extends DataTable
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
        $pages = $this->query();

        return datatables()
            ->of($pages)

            ->addColumn('name', function ($pages) {
                return '<a href="' . route('page.edit', ['id' => $pages->id]) . '">' . ucfirst($pages->name) . '</a>';
            })->addColumn('status', function ($pages) {
                return statusBadges(ucfirst($pages->status));
            })->addColumn('type', function ($pages) {
                if (! $pages->type || $pages->type == 'page') {
                    return __('Page');
                } elseif ($pages->type && $pages->default && $pages->type == 'home') {
                    return ucfirst($pages->type) . '<span class="badge btn-success text-white f-12 ml-2">' . __('Default') . '</span>';
                }

                return ucfirst($pages->type);
            })->addColumn('created_at', function ($pages) {
                return $pages->format_created_at;
            })->addColumn('action', function ($pages) {

                $edit = '<a title="' . __('Edit :x', ['x' => __('Page')]) . '" href="' . route('page.edit', ['id' => $pages->id]) . '" class="btn btn-xs btn-primary"><i class="feather icon-edit neg-transition-scale-svg "></i></a>&nbsp';
                $view = '<a title="' . __('View page') . '" href="' . route('site.page', $pages->slug) . '" target="_blank" class="btn btn-xs btn-outline-warning"><i class="feather icon-eye"></i></a>&nbsp';

                $delete = '<form method="post" action="' . route('page.delete', ['id' => $pages->id]) . '" id="delete-Pages-' . $pages->id . '" accept-charset="UTF-8" class="display_inline">
                        ' . csrf_field() . '
                        <button title="' . __('Delete :x', ['x' => __('Page.')]) . '" class="btn btn-xs btn-danger" type="button" data-id=' . $pages->id . ' data-label="Delete" data-delete="Pages" data-bs-toggle="modal" data-bs-target="#confirmDelete" data-title="' . __('Delete :x', ['x' => __('Page')]) . '" data-message="' . __('Are you sure to delete this?') . '">
                        <i class="feather icon-trash-2"></i>
                        </button>
                        </form>';
                $str = '';
                if ($this->hasPermission(['Modules\CMS\Http\Controllers\CMSController@edit'])) {
                    $str .= $edit;
                }
                $str .= $view;
                if ($this->hasPermission(['Modules\CMS\Http\Controllers\CMSController@delete'])) {
                    $str .= $delete;
                }

                return $str;
            })

            ->rawColumns(['name', 'status', 'action', 'type'])
            ->make(true);
    }

    /*
    * DataTable Query
    *
    * @return mixed
    */
    public function query()
    {
        $pages = Page::get();

        return $this->applyScopes($pages);
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
            ->addColumn(['data' => 'status', 'name' => 'status', 'title' => __('Status')])
            ->addColumn(['data' => 'type', 'name' => 'type', 'title' => __('Type')])
            ->addColumn(['data' => 'created_at', 'name' => 'Crete', 'title' => __('Created At')])
            ->addColumn([
                'data' => 'action', 'name' => 'action', 'title' => __('Action'), 'width' => '5%',
                'visible' => $this->hasPermission(['Modules\CMS\Http\Controllers\CMSController@edit', 'Modules\CMS\Http\Controllers\CMSController@delete']),
                'orderable' => false, 'searchable' => false,
            ])
            ->dom('Bfrtip')
            ->parameters(dataTableOptions());
    }
}
