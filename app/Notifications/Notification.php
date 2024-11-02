<?php

namespace App\Notifications;

use App\Models\NotificationSetting;

abstract class Notification extends \Illuminate\Notifications\Notification
{
    /**
     * The channels through which the notification should be sent.
     *
     * @var array
     */
    public $via = [];

    /**
     * The notifiable entity that caused the notification to be sent.
     *
     * @var mixed
     */
    public $notifiable;

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        // Set the notifiable entity
        $this->notifiable = $notifiable;

        // Set the via channels
        $this->via = $this->setVia($notifiable);

        // Apply filters to the notification
        $this->applyFilters();

        // Return the channels
        return $this->via;
    }

    /**
     * Set the notification's delivery channels.
     *
     * This method must be implemented in the child class
     * to return an array of channels (e.g., ['database', 'mail']).
     *
     * @param  mixed  $notifiable
     * @return array
     */
    abstract public function setVia($notifiable);

    /**
     * Apply filters to the notification.
     *
     * @return void
     */
    protected function applyFilters()
    {

        $reflect = new \ReflectionClass(get_called_class());

        $channels = NotificationSetting::where('notification_type', $reflect->getName())->pluck('is_active', 'channel')->toArray();

        $this->via = array_filter($this->via, function ($channel) use ($channels) {
            return isset($channels[$channel]) && $channels[$channel] == 1;
        });

        apply_filters('notifications', $this);
    }
}
