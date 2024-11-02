<?php

/**
 * @author TechVillage <support@techvill.org>
 *
 * @contributor Al Mamun <[almamun.techvill@gmail.com]>
 *
 * @created 18-01-2024
 */

namespace App\Http\Controllers;

use App\DataTables\NotificationDataTable;
use App\DataTables\NotificationLogDataTable;
use App\Models\DatabaseNotification;
use App\Models\NotificationLogItem;
use App\Models\NotificationSetting;
use App\Notifications\Notification;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    /**
     * User List
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function index(NotificationDataTable $dataTable)
    {
        return $dataTable->render('admin.notifications.index');
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
        DatabaseNotification::whereNull('read_at')->orderByDesc('created_at')->update(['read_at' => now()]);

        return back()->withSuccess(__('Notification update successfully'));
    }

    /**
     * Header Notification
     */
    public function headerNotification()
    {
        return DatabaseNotification::headerNotification(auth()->user());
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

    /*
    * User List
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function log(NotificationLogDataTable $dataTable)
    {
        $data['users'] = NotificationLogItem::where('notifiable_type', 'App\Models\User')
            ->join('users', 'users.id', 'notification_log_items.notifiable_id')
            ->select('users.id', 'users.name')
            ->distinct()
            ->pluck('users.name', 'users.id')
            ->toArray();

        $data['channels'] = NotificationLogItem::select('channel')->distinct()->get()->mapWithKeys(function ($item) {
            $channelName = ucwords(preg_replace('/(?<=\\w)(?=[A-Z])/', ' $1', class_basename(str_replace('Channel', '', $item->channel))));

            return [$item->channel => $channelName];
        })->toArray();

        $data['types'] = NotificationLogItem::select('notification_type')->distinct()->get()->mapWithKeys(function ($item) {
            $notificationName = ucwords(preg_replace('/(?<=\\w)(?=[A-Z])/', ' $1', str_replace('Notification', '', class_basename($item->notification_type))));

            return [$item->notification_type => $notificationName];
        })->toArray();

        return $dataTable->render('admin.notifications.log', $data);
    }

    /**
     * Delete Notification
     *
     * @param  string  $id
     */
    public function destroyLog(Request $request, $id)
    {
        $notification = NotificationLogItem::where('id', $id);

        if ($notification->exists()) {
            $notification->delete();

            return back()->withSuccess(__('The :x has been successfully deleted.', ['x' => __('Notification Log')]));
        }

        return back()->withErrors(__('Failed to delete :x', ['x' => __('Notification Log')]));
    }

    /**
     * View Notification Setting
     */
    public function setting()
    {
        $data['list_menu'] = 'notification';
        $namespace = 'Notifications/';

        $except = [Notification::class];
        $files = glob(app_path($namespace) . '*.php');

        $classes = collect($files)
            ->map(function ($file) use ($namespace, $except) {
                $class = str_replace('/', '\\', "App\\$namespace" . pathinfo($file, PATHINFO_FILENAME));

                if (class_exists($class) && ! in_array($class, $except)) {
                    return [
                        'class' => $class,
                        'label' => $this->getLabel($class),
                        'channel' => (new $class(request()))->setVia(null),
                    ];
                }
            })->filter()->sortBy('label')->toArray();

        $data['settings'] = NotificationSetting::get()->mapWithKeys(function ($setting) {
            return [
                $setting->notification_type . '_' . str_replace(' ', '', $setting->channel) => $setting->is_active,
            ];
        })->toArray();

        $data['classes'] = $classes;
        $data['channels'] = $this->getUniqueChannels($classes);

        return view('admin.notifications.setting', $data);
    }

    /**
     * Get label
     */
    private function getLabel($class)
    {
        try {
            return $class::$label;
        } catch (\Throwable $th) {
            $shortName = class_basename($class);
            $shortClassName = str_replace('Notification', '', $shortName);

            return ucwords(preg_replace('/(?<=\\w)(?=[A-Z])/', ' $1', ucfirst($shortClassName)));
        }
    }

    /**
     * Get unique channels
     */
    private function getUniqueChannels($classes)
    {
        $allChannels = array_merge(...array_map(function ($item) {
            return $item['channel'];
        }, $classes));

        // Get unique channels
        $channels = array_unique($allChannels);

        $formatChannel = [];
        foreach ($channels as $channel) {
            $shortName = class_basename($channel);
            $shortClassName = str_replace('Channel', '', $shortName);

            $formatChannel[$channel] = ucwords(preg_replace('/(?<=\\w)(?=[A-Z])/', ' $1', ucfirst($shortClassName)));
        }

        return $formatChannel;
    }

    /**
     * Update Notification Setting
     */
    public function updateSetting(Request $request)
    {
        try {
            NotificationSetting::updateOrInsert(
                ['notification_type' => $request->notification_type, 'channel' => $request->channel],
                $request->only('notification_type', 'channel', 'is_active')
            );

            return true;
        } catch (\Exception $e) {
            return false;
        }
    }
}
