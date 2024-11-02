<?php

namespace App\Notifications;

use App\Notifications\Channel\AdminDatabaseChannel;
use App\Notifications\Channel\SmsChannel;
use App\Services\Mail\SellerRequestMailService;
use App\Traits\NotificationTrait;
use Illuminate\Bus\Queueable;

class SellerRequestToAdminNotification extends Notification
{
    use NotificationTrait;
    use Queueable;

    private $request;

    /**
     * Notification Label
     */
    public static $label = 'Seller Request to Admin';

    /**
     * Image
     *
     * @var string
     */
    public static $image = 'public/frontend/img/seller.png';

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
        return (new SellerRequestMailService())->send($this->request);
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
            'message' => 'You have submitted a request to join as a seller.',
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
            'url' => route('vendors.index'),
            'message' => "The request to join as a seller has been submitted by {$notifiable->name}.",
        ];
    }

    /**
     * Get the SMS representation of the notification.
     */
    public function toSms(object $notifiable): array
    {
        return [
            'to' => $notifiable->phone,
            'message' => $this->getSmsData('seller-request-for-admin'),
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
            '{user_name}' => 'Admin',
            '{company_name}' => preference('company_name'),
            '{support_mail}' => preference('company_email'),
            '{logo}' => '',
        ];

        return str_replace(array_keys($data), $data, $body);
    }
}
