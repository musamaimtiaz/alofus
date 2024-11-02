<?php

namespace App\Listeners;

use App\Services\NotificationLogService;
use Illuminate\Notifications\Events\NotificationSending;
use Illuminate\Notifications\Events\NotificationSent;
use WeakMap;

class NotificationEventSubscriber
{
    /**
     * The sent notifications.
     */
    protected static ?WeakMap $sentNotifications = null;

    /**
     * Create a new event subscriber instance.
     *
     * @return void
     */
    public function __construct()
    {
        if (! self::$sentNotifications) {
            self::$sentNotifications = new WeakMap();
        }
    }

    /**
     * Handle the notification sending event.
     */
    public function handleNotificationSending(NotificationSending $event): void
    {
        if (! $this->shouldLog($event)) {
            return;
        }

        $convertEventToModelAction = $this->convertEventToModelAction();

        $logItem = $convertEventToModelAction->execute($event);

        if ($logItem) {
            self::$sentNotifications[$event->notification] = $logItem;
        }

        self::$sentNotifications[$event->notification] = $logItem;
    }

    /**
     * Handle the notification sent event.
     */
    public function handleNotificationSent(NotificationSent $event): void
    {
        if (! self::$sentNotifications->offsetExists($event->notification)) {
            return;
        }

        self::$sentNotifications[$event->notification]->markAsSent();
    }

    /**
     * Determine if the notification should be logged.
     */
    protected function shouldLog(NotificationSending $event): bool
    {
        $notification = $event->notification;

        if (method_exists($notification, 'shouldLog')) {
            return $notification->shouldLog($event);
        }

        return config('notification.log_all_by_default') ?? true;
    }

    /**
     * Get the events and handlers.
     *
     * @return array<string, string>
     */
    public function subscribe(): array
    {
        return [
            NotificationSending::class => 'handleNotificationSending',
            NotificationSent::class => 'handleNotificationSent',
        ];
    }

    /**
     * Convert the event to a model action.
     */
    public static function convertEventToModelAction(): NotificationLogService
    {
        return app(NotificationLogService::class);
    }
}
