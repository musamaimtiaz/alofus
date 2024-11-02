<?php

/**
 * @author TechVillage <support@techvill.org>
 *
 * @contributor Al Mamun <[almamun.techvill@gmail.com]>
 *
 * @created 25-01-2024
 */

namespace App\Http\Controllers\Site;

use App\Filters\NotificationDateFilter;
use App\Filters\NotificationTypeFilter;
use App\Http\Controllers\Controller;
use App\Models\DatabaseNotification;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Pipeline\Pipeline;

class NotificationController extends Controller
{
    /**
     * User List
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function index(Request $request)
    {
        $notificationsQuery = DatabaseNotification::query()
            ->where('notifiable_type', User::class)
            ->where('notifiable_id', auth()->user()->id)
            ->orderBy('read_at')
            ->orderByDesc('created_at');

        $notifications = app(Pipeline::class)
            ->send($notificationsQuery)
            ->through([
                NotificationDateFilter::class,
                NotificationTypeFilter::class,
            ])
            ->thenReturn()
            ->paginate(preference('row_per_page'));

        return view('site.notification.index', compact('notifications'));
    }

    /**
     * Delete Notification
     *
     * @param  string  $id
     */
    public function destroy($id)
    {
        $notification = DatabaseNotification::where('id', $id);

        if ($notification->exists()) {
            $notification->delete();

            return back()->withSuccess(__('The :x has been successfully deleted.', ['x' => __('Notification')]));
        }

        return back()->withErrors(__('Failed to delete :x', ['x' => __('Notification')]));
    }

    /**
     * Mark a specific notification as read.
     *
     * @param  int  $id  The ID of the notification.
     * @return int The number of affected rows (0 or 1).
     */
    public function markAsRead($id)
    {
        return DatabaseNotification::where('id', $id)->update(['read_at' => now()]);
    }

    /**
     * Mark a specific notification as unread.
     *
     * @param  int  $id  The ID of the notification.
     * @return int The number of affected rows (0 or 1).
     */
    public function markAsUnread($id)
    {
        return DatabaseNotification::where('id', $id)->update(['read_at' => null]);
    }

    /**
     * Mark all unread notifications as read.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function markAsReadAll()
    {
        DatabaseNotification::where('notifiable_id', auth()->user()->id)
            ->whereNull('read_at')
            ->update(['read_at' => now()]);

        return back()->withSuccess(__('Notification update successfully'));
    }

    /**
     * Header Notification
     */
    public function headerNotification()
    {
        $data['notifications'] = auth()->user()->notifications->whereNull('read_at')->sortByDesc('created_at')->take(10);

        if ($data['notifications']->count() == 0) {
            return response()->json([
                'data' => '<div class="flex justify-center h-[200px] items-center">
                    <p>' . __('No notification found') . '</p>
                </div>',
            ]);
        }

        return response()->json([
            'data' => view('site/layouts/includes/header-notification-ajax', $data)->render(),
        ]);
    }

    /**
     * View Notification
     */
    public function view($id)
    {
        DatabaseNotification::where('id', $id)->update(['read_at' => now()]);

        if (! isset(request()->url)) {
            return back();
        }

        return redirect()->intended(request()->url);
    }
}
