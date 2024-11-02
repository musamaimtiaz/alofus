<?php

namespace App\Notifications\Channel;

use App\Models\DatabaseNotification;
use App\Models\User;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Str;

class AdminDatabaseChannel
{
    /**
     * Notifiable type
     *
     * @var string
     */
    private $notifiableType = User::class;

    /**
     * Send the given notification.
     */
    public function send(object $notifiable, Notification $notification): void
    {
        if (! method_exists($notification, 'toAdmin')) {
            return;
        }

        $message = $notification->toAdmin($notifiable);

        $users = User::whereHas('roles', function ($query) {
            $query->where('slug', 'super-admin');
        })->get();

        $data = [];

        foreach ($users as $user) {
            $data[] = [
                'id' => Str::uuid()->toString(),
                'type' => get_class($notification),
                'notifiable_type' => $this->notifiableType,
                'notifiable_id' => $user->id,
                'data' => json_encode($message),
                'read_at' => null,
                'created_at' => now(),
            ];
        }

        if (! empty($data)) {
            DatabaseNotification::insert($data);
        }
    }
}
