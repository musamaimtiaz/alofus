<?php

namespace App\Services;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\AnonymousNotifiable;
use Illuminate\Notifications\Events\NotificationSending;
use Illuminate\Notifications\Notification;
use App\Models\NotificationLogItem;
use Exception;

class NotificationLogService
{
    /**
     * Handle the notification sending event.
     */
    public function execute(NotificationSending $event): ?NotificationLogItem
    {
        return NotificationLogItem::create([
            'notification_type' => $this->getNotificationType($event),
            'notifiable_type' => $this->getNotifiableType($event),
            'notifiable_id' => $this->getNotifiableKey($event),
            'channel' => $event->channel,
            'fingerprint' => $this->getFingerPrint($event),
            'extra' => $this->getExtra($event),
            'anonymous_notifiable_properties' => $this->getAnonymousNotifiableProperties($event),
        ]);
    }

    /**
     * Determine if the notification should be logged.
     *
     *
     * @return bool
     */
    protected function getNotifiableType(NotificationSending $event): ?string
    {
        $notifiable = $event->notifiable;

        return $notifiable instanceof Model ? $notifiable->getMorphClass() : null;
    }

    /**
     * Get the notifiable key.
     */
    protected function getNotifiableKey(NotificationSending $event): mixed
    {
        $notifiable = $event->notifiable;

        return $notifiable instanceof Model ? $notifiable->getKey() : null;
    }

    /**
     * Get the notification type.
     */
    protected function getNotificationType(NotificationSending $event): string
    {
        $notification = $event->notification;

        return $this->getNotificationTypeForNotification($notification, $event->notifiable);
    }

    /**
     * Get the notification type for the given notification.
     *
     * @param  mixed  $notifiable
     * @return string
     */
    public function getNotificationTypeForNotification(Notification $notification, $notifiable)
    {
        if (method_exists($notification, 'logType')) {
            return $notification->logType($notifiable);
        }

        return get_class($notification);
    }

    /**
     * Get the fingerprint for the notification.
     *
     *
     * @return string|null
     */
    protected function getModelClass(NotificationSending $event): string
    {
        return NotificationLogItem::class;
    }

    /**
     * Get the fingerprint for the notification.
     */
    protected function getFingerprint(NotificationSending $event): ?string
    {
        $notification = $event->notification;

        return $this->getFingerprintForNotification($notification, $event->notifiable);
    }

    /**
     * Get the fingerprint for the given notification.
     *
     * @param  mixed  $notifiable
     * @return string|null
     */
    public function getFingerprintForNotification(Notification $notification, $notifiable)
    {
        if (method_exists($notification, 'fingerprint')) {
            return $notification->fingerprint($notifiable);
        }

        return null;
    }

    /**
     * Get the extra payload for the notification.
     */
    protected function getExtra(NotificationSending $event): array
    {
        $notification = $event->notification;

        if (method_exists($notification, 'logExtra')) {
            $extra = $notification->logExtra($event);

            if (! is_array($extra)) {
                throw Exception::make('logExtra should return an array');
            }

            return $extra;
        }

        return [];
    }

    /**
     * Get the anonymous notifiable properties.
     */
    protected function getAnonymousNotifiableProperties(NotificationSending $event): ?array
    {
        if (! $event->notifiable instanceof AnonymousNotifiable) {
            return null;
        }

        return $event->notifiable->routes;
    }
}
