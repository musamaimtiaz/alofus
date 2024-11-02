<?php

namespace App\Notifications;

use App\Notifications\Channel\AdminDatabaseChannel;
use App\Notifications\Channel\SmsChannel;
use App\Services\Mail\UserSetPasswordMailService;
use App\Traits\NotificationTrait;
use Illuminate\Bus\Queueable;

class UserPasswordSetNotification extends Notification
{
    use NotificationTrait;
    use Queueable;

    private $request;

    /**
     * Notification Label
     */
    public static $label = 'User Password Set';

    /**
     * Image
     *
     * @var string
     */
    public static $image = 'public/frontend/img/password.png';

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
        return (new UserSetPasswordMailService())->send($this->request);
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
            'message' => 'Your password has been reset successfully.',
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
            'message' => "The password for {$notifiable->name} has been reset successfully.",
        ];
    }

    /**
     * Get the SMS representation of the notification.
     */
    public function toSms(object $notifiable): array
    {
        return [
            'to' => $notifiable->phone,
            'message' => $this->getSmsData('new-password-set'),
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
            '{user_name}' => $this->request->user_name,
            '{user_id}' => $this->request->email,
            '{user_pass}' => $this->request->raw_password,
            '{company_url}' => route('site.login'),
            '{company_name}' => preference('company_name'),
            '{support_mail}' => preference('company_email'),
            '{logo}' => '',
        ];

        return str_replace(array_keys($data), $data, $body);
    }
}
