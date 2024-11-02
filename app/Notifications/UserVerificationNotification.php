<?php

namespace App\Notifications;

use App\Notifications\Channel\AdminDatabaseChannel;
use App\Notifications\Channel\SmsChannel;
use App\Services\Mail\UserVerificationCodeMailService;
use App\Traits\NotificationTrait;
use Illuminate\Bus\Queueable;

class UserVerificationNotification extends Notification
{
    use NotificationTrait;
    use Queueable;

    private $request;

    /**
     * Notification Label
     */
    public static $label = 'User Verification';

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
        return (new UserVerificationCodeMailService())->send($this->request);
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
            'message' => 'Congratulations! Your email has been successfully verified. You can now enjoy all the features of our platform.',
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
            'message' => "The email for {$notifiable->name} has been successfully verified.",
        ];
    }

    /**
     * Get the SMS representation of the notification.
     */
    public function toSms(object $notifiable): array
    {
        return [
            'to' => $notifiable->phone,
            'message' => $this->getSmsData('email-verification'),
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
            '{verification_url}' => route('site.verify', ['token' => $this->request->activation_code, 'from' => $this->request->from]),
            '{company_name}' => preference('company_name'),
            '{verification_otp}' => $this->request->activation_otp,
            '{support_mail}' => preference('company_email'),
            '{otp_active}' => '',
            '{token_active}' => '',
            '{token_otp_active}' => '',
        ];

        return str_replace(array_keys($data), $data, $body);
    }
}
