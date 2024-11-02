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
    DatabaseNotification,
    NotificationLogItem
};
use Illuminate\Http\JsonResponse;

class NotificationLogDataTable extends DataTable
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

            ->addColumn('user', function ($notifications) {
                if ($notifications->notifiable_type == 'App\Models\User') {
                    return $notifications?->notifiable ? '<a href="' . (string) route('users.edit', ['id' => $notifications?->notifiable->id]) . '">' . $notifications?->notifiable?->name . '</a>' : 'N/A';
                }

                return $notifications?->notifiable?->name;
            })
            ->editColumn('notification', function ($notifications) {
                $className = $notifications->notification_type;
                $shortClassName = str_replace('Notification', '', class_basename($className));

                return ucwords(preg_replace('/(?<=\\w)(?=[A-Z])/', ' $1', $shortClassName));
            })
            ->editColumn('channel', function ($notifications) {
                $classNameParts = explode('\\', $notifications->channel);
                $shortName = end($classNameParts);
                $shortClassName = str_replace('Channel', '', class_basename($shortName));

                return ucwords(preg_replace('/(?<=\\w)(?=[A-Z])/', ' $1', ucfirst($shortClassName)));
            })
            ->editColumn('confirmed_at', function ($notifications) {
                return timeToGo($notifications->confirmed_at, false, 'ago');
            })
            ->addColumn('action', function ($notifications) {
                $str = '';

                if ($this->hasPermission(['App\\Http\\Controllers\\NotificationController@destroyLog'])) {
                    $str .= '<form method="post" action="' . route('notifications.log.destroy', ['id' => $notifications->id]) . '" id="delete-notification-' . $notifications->id . '" accept-charset="UTF-8" class="display_inline">
                    ' . csrf_field() . '
                    ' . method_field('delete') . '
                    <a title="' . __('Delete') . '" class="action-icon confirm-delete" type="button" data-id=' . $notifications->id . ' data-delete="notification" data-label="Delete" data-bs-toggle="modal" data-bs-target="#confirmDelete" data-title="' . __('Delete :x', ['x' => __('Notification Log')]) . '" data-message="' . __('Are you sure to delete this?') . '">
                    <i class="feather icon-trash"></i>
                    </a>
                    </form>';
                }

                return $str;
            })
            ->rawColumns(['user', 'notification', 'channel', 'confirmed_at', 'action'])
            ->make(true);
    }

    /*
    * DataTable Query
    *
    * @return mixed
    */
    public function query()
    {
        $notifications = NotificationLogItem::with('notifiable')->filter();

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
            ->addColumn(['data' => 'user', 'name' => 'user', 'title' => __('User'), 'orderable' => false, 'searchable' => false, 'className' => 'align-middle text-left', 'width' => '12%'])
            ->addColumn(['data' => 'notification', 'name' => 'notification_type', 'title' => __('Notification'), 'className' => 'align-middle', 'orderable' => false, 'searchable' => false, 'width' => '12%'])
            ->addColumn(['data' => 'channel', 'name' => 'channel', 'title' => __('Channel'), 'orderable' => false, 'searchable' => false, 'width' => '25%'])
            ->addColumn(['data' => 'confirmed_at', 'name' => 'confirmed_at', 'orderable' => false, 'searchable' => false, 'width' => '8%', 'className' => 'align-middle'])
            ->addColumn([
                'data' => 'action', 'name' => 'action', 'title' => '', 'width' => '5%',
                'visible' => $this->hasPermission(['App\Http\Controllers\NotificationController@destroyLog']),
                'orderable' => false, 'searchable' => false, 'className' => 'text-right align-middle',
            ])
            ->parameters(dataTableOptions(['dom' => 'Bfrtip']));
    }
}
