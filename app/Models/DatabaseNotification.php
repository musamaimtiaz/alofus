<?php

namespace App\Models;

use App\Traits\ModelTrait;
use Illuminate\Notifications\DatabaseNotification as BaseDatabaseNotification;

class DatabaseNotification extends BaseDatabaseNotification
{
    use ModelTrait;

    /**
     * Header Notification
     */
    public static function headerNotification($user)
    {
        $data['notifications'] = $user?->notifications->whereNull('read_at')->sortByDesc('created_at')->take(10);

        if ($data['notifications']?->count() == 0) {
            return response()->json([
                'data' => '<div class="d-flex justify-content-center align-items-center h-100">
                    <p>' . __('No notification found') . '</p>
                </div>',
            ]);
        }

        return response()->json([
            'data' => view('admin/layouts/includes/header-notification-ajax', $data)->render(),
        ]);
    }
}
