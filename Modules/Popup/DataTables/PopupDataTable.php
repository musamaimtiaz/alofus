<?php
/**
 * @author TechVillage <support@techvill.org>
 *
 * @contributor Al Mamun <[almamun.techvill@gmail.com]>
 *
 * @created 10-03-2022
 */

namespace Modules\Popup\DataTables;

use App\DataTables\DataTable;
use Illuminate\Http\JsonResponse;
use Modules\Popup\Entities\Popup;

class PopupDataTable extends DataTable
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
        $popup = $this->query();

        return datatables()
            ->of($popup)

            ->editColumn('name', function ($popup) {
                return wrapIt($popup->name, 10, ['columns' => 1]);
            })->addColumn('login_enabled', function ($popup) {
                return $popup->login_enabled == 1 ? __('Yes') : __('No');
            })->editColumn('start_date', function ($popup) {
                return ! empty($popup->start_date) ? formatDate($popup->start_date) : '';
            })->editColumn('end_date', function ($popup) {
                return ! empty($popup->end_date) ? formatDate($popup->end_date) : '';
            })->addColumn('status', function ($popup) {
                return statusBadges($popup->status);
            })->addColumn('action', function ($popup) {
                $show = '<a title="' . __('Show') . '" href="' . route('popup.show', ['id' => $popup->id]) . '" class="action-icon pr-5"><i class="feather icon-eye"></i></a>&nbsp';

                $edit = '<a title="' . __('Edit :?', ['?' => __('popup')]) . '" href="' . route('popup.edit', ['id' => $popup->id]) . '" class="action-icon"><i class="feather icon-edit-1 neg-transition-scale-svg "></i></a>&nbsp';

                $delete = '<form method="post" action="' . route('popup.delete', ['id' => $popup->id]) . '" id="delete-popup-' . $popup->id . '" accept-charset="UTF-8" class="display_inline">
                        ' . csrf_field() . '
                        <a title="' . __('Delete :?', ['?' => __('popup')]) . '" class="action-icon confirm-delete" type="button" data-id=' . $popup->id . ' data-label="Delete" data-delete="popup" data-bs-toggle="modal" data-bs-target="#confirmDelete" data-title="' . __('Delete :?', ['?' => __('popup')]) . '" data-message="' . __('Are you sure to delete this?') . '">
                        <i class="feather icon-trash"></i>
                        </a>
                        </form>';
                $str = '';
                if ($this->hasPermission(['Modules\Popup\Http\Controllers\PopupController@show'])) {
                    $str .= $show;
                }
                if ($this->hasPermission(['Modules\Popup\Http\Controllers\PopupController@edit'])) {
                    $str .= $edit;
                }
                if ($this->hasPermission(['Modules\Popup\Http\Controllers\PopupController@destroy'])) {
                    $str .= $delete;
                }

                return $str;
            })

            ->rawColumns(['id', 'name', 'type', 'show_time', 'start_date', 'end_date', 'login_enabled', 'status', 'action'])
            ->make(true);
    }

    /*
    * DataTable Query
    *
    * @return mixed
    */
    public function query()
    {
        $popups = Popup::select('id', 'name', 'type', 'show_time', 'start_date', 'end_date', 'login_enabled', 'status')->filter();

        return $this->applyScopes($popups);
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
            ->addColumn(['data' => 'type', 'name' => 'type', 'title' => __('Type'), 'className' => 'align-middle'])
            ->addColumn(['data' => 'login_enabled', 'name' => 'login_enabled', 'title' => __('Login required'), 'className' => 'align-middle'])
            ->addColumn(['data' => 'start_date', 'name' => 'start_date', 'title' => __('Start Date'), 'className' => 'align-middle'])
            ->addColumn(['data' => 'end_date', 'name' => 'end_date', 'title' => __('End Date'), 'className' => 'align-middle'])
            ->addColumn(['data' => 'status', 'name' => 'status', 'title' => __('Status'), 'className' => 'align-middle'])
            ->addColumn(['data' => 'action', 'name' => 'action', 'title' => __('Action'), 'width' => '12%',
                'visible' => $this->hasPermission(['Modules\Popup\Http\Controllers\PopupController@edit', 'Modules\Popup\Http\Controllers\PopupController@destroy', 'Modules\Popup\Http\Controllers\PopupController@show']),
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
