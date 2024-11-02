<?php

namespace App\Notifications;

use App\Notifications\Channel\AdminDatabaseChannel;
use App\Notifications\Channel\SmsChannel;
use App\Services\Mail\UserMailService;
use Illuminate\Bus\Queueable;

class WelcomeUserNotification extends Notification
{
    use Queueable;

    private $request;

    /**
     * Notification Label
     */
    public static $label = 'User Registration';

    /**
     * Image
     *
     * @var string
     */
    public static $image = 'public/frontend/img/user.png';

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
        return ['mail', 'database', SmsChannel::class, AdminDatabaseChannel::class];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable)
    {
        return (new UserMailService())->send($this->request);
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'id' => $notifiable->id,
            'label' => static::$label,
            'url' => '',
            'message' => 'Welcome! Your registration was successful. Thank you for joining us!',
        ];
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toAdmin(object $notifiable): array
    {
        return [
            'id' => $notifiable->id,
            'label' => static::$label,
            'url' => route('users.edit', ['id' => $notifiable->id]),
            'message' => "$notifiable->name has been successfully registered.",
        ];
    }

    /**
     * Get the SMS representation of the notification.
     */
    public function toSms(object $notifiable): array
    {
        return [
            'to' => $notifiable->phone,
            'message' => __('A new user has been register'),
        ];
    }

    /**
     * Replace SMS variables in the given SMS body.
     *
     * @param  string  $body
     * @return string
     */
    public function replaceSmsVariables($body)
    {
        $data = [
            '{logo}' => '',
            '{company_name}' => preference('company_name'),
            '{support_mail}' => preference('company_email'),
            '{user_name}' => $this->request->name,
            '{company_url}' => route('site.index'),
        ];

        return str_replace(array_keys($data), $data, $body);
    }
}
