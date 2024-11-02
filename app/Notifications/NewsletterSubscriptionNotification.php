<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;

class NewsletterSubscriptionNotification extends Notification
{
    use Queueable;

    private $request;

    /**
     * Newsletter Label
     */
    public static $label = 'Newsletter';

    /**
     * Image
     *
     * @var string
     */
    public static $image = 'public/frontend/img/newsletter.png';

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

    }

    /**
     * Replace SMS variables in the given SMS body.
     *
     * @param  string  $body
     * @return string
     */
    public function replaceSmsVariables($body)
    {

    }
}
