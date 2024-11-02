<?php

/**
 * @author TechVillage <support@techvill.org>
 *
 * @contributor Al Mamun <[almamun.techvill@gmail.com]>
 *
 * @created 18-01-2024
 */

namespace App\Http\Controllers\Vendor;

use App\DataTables\VendorNotificationDataTable;
use App\Http\Controllers\Controller;
use App\Models\DatabaseNotification;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    /**
     * User List
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function index(VendorNotificationDataTable $dataTable)
    {
        return $dataTable->render('vendor.notifications.index');
    }

    /**
     * Delete Notification
     *
     * @param  string  $id
     */
    public function destroy(Request $request, $id)
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
        DatabaseNotification::where('notifiable_id', session('vendorId'))
            ->whereNull('read_at')
            ->orderByDesc('created_at')
            ->update(['read_at' => now()]);

        return back()->withSuccess(__('Notification update successfully'));
    }

    /**
     * Header Notification
     */
    public function headerNotification()
    {
        return DatabaseNotification::headerNotification(auth()->user()->vendors()->first());
    }
}
