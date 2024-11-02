<?php

/**
 * @author TechVillage <support@techvill.org>
 *
 * @contributor Al Mamun <[almamun.techvill@gmail.com]>
 * @contributor Al Mamun <[almamun.techvill@gmail.com]>
 *
 * @created 18-01-2024
 */

namespace App\DataTables;

use App\Models\{
    DatabaseNotification
};
use Illuminate\Http\JsonResponse;

class NotificationDataTable extends DataTable
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
        $notifications = $this->query();

        return datatables()
            ->of($notifications)

            ->addColumn('picture', function ($notifications) {
                return '<img class="rounded" src="' . asset($notifications->type::$image) . '" 
                    alt="' . __('image') . '" width="40" height="40">';
            })
            ->editColumn('label', function ($notifications) {
                return '<a href=' . (! empty($notifications->data['url']) ? route('notifications.view', ['id' => $notifications->id, 'url' => $notifications->data['url']]) : '') . '>' . $notifications->data['label'] . '</a>';
            })
            ->editColumn('message', function ($notifications) {
                return $notifications->data['message'];
            })
            ->editColumn('created_at', function ($notifications) {
                return timeToGo($notifications->created_at, false, 'ago');
            })
            ->addColumn('action', function ($notifications) {

                $mark = '<a data-bs-toggle="tooltip" title=" ' . ($notifications->read_at ? __('Mark As Unread') : __('Mark As Read')) . '" href="javascript:void(0)" data-id="' . $notifications->id . '" class="action-icon marked-toggle"><i class="feather feather ' . ($notifications->read_at ? 'icon-eye' : 'icon-eye-off') . ' "></i></a>';

                $delete = '<form method="post" action="' . route('notifications.destroy', ['id' => $notifications->id]) . '" id="delete-notification-' . $notifications->id . '" accept-charset="UTF-8" class="display_inline">
                        ' . csrf_field() . '
                        ' . method_field('delete') . '
                        <a title="' . __('Delete') . '" class="action-icon confirm-delete" type="button" data-id=' . $notifications->id . ' data-delete="notification" data-label="Delete" data-bs-toggle="modal" data-bs-target="#confirmDelete" data-title="' . __('Delete :x', ['x' => __('Notification')]) . '" data-message="' . __('Are you sure to delete this?') . '">
                        <i class="feather icon-trash"></i>
                        </a>
                        </form>';

                $str = '';
                if ($this->hasPermission(['App\Http\Controllers\NotificationController@markAsRead'])) {
                    $str .= $mark;
                }

                if ($this->hasPermission(['App\Http\Controllers\NotificationController@destroy'])) {
                    $str .= $delete;
                }

                return $str;
            })
            ->rawColumns(['picture', 'label', 'message', 'action'])
            ->make(true);
    }

    /*
    * DataTable Query
    *
    * @return mixed
    */
    public function query()
    {
        $userId = request()->user_id ?? auth()->user()->id;

        $notifications = DatabaseNotification::where('notifiable_id', $userId)
            ->orderBy('read_at')
            ->orderByDesc('created_at')
            ->filter();

        return $this->applyScopes($notifications);
    }

    /*
    * DataTable HTML
    *
    * @return \Yajra\DataTables\Html\Builder
    */
    public function html()
    {
        return $this->builder()
            ->addColumn(['data' => 'id', 'name' => 'id', 'title' => __('Id'), 'visible' => false])
            ->addColumn(['data' => 'picture', 'name' => 'picture', 'title' => __('Picture'), 'orderable' => false, 'searchable' => false, 'className' => 'align-middle text-left', 'width' => '4%'])
            ->addColumn(['data' => 'label', 'name' => 'data', 'title' => __('Name'), 'className' => 'align-middle', 'orderable' => false, 'searchable' => false, 'width' => '12%'])
            ->addColumn(['data' => 'message', 'name' => 'data', 'orderable' => false, 'searchable' => false, 'width' => '25%'])
            ->addColumn(['data' => 'created_at', 'name' => 'created_at', 'orderable' => false, 'searchable' => false, 'width' => '8%', 'className' => 'align-middle'])
            ->addColumn([
                'data' => 'action', 'name' => 'action', 'title' => '', 'width' => '5%',
                'visible' => $this->hasPermission(['App\Http\Controllers\NotificationController@destroy']),
                'orderable' => false, 'searchable' => false, 'className' => 'text-right align-middle',
            ])
            ->parameters(dataTableOptions(['dom' => 'Bfrtip']));
    }
}
