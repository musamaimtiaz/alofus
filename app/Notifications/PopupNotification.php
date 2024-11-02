<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Modules\Popup\Services\Mail\PopupMailService;

class PopupNotification extends Notification
{
    use Queueable;

    private $request;

    /**
     * Notification Label
     */
    public static $label = 'Popup';

    /**
     * Image
     *
     * @var string
     */
    public static $image = 'public/frontend/img/mail.png';

    public function __construct($request)
    {
        $this->request = $request;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function setVia($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable)
    {
        return (new PopupMailService())->send($this->request);
    }
}
