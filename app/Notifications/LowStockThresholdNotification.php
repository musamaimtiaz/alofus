<?php

namespace App\Notifications;

use App\Notifications\Channel\AdminDatabaseChannel;
use App\Notifications\Channel\SmsChannel;
use App\Services\Mail\LowStockThreshold as MailLowStockThreshold;
use App\Traits\NotificationTrait;
use Illuminate\Bus\Queueable;

class LowStockThresholdNotification extends Notification
{
    use NotificationTrait;
    use Queueable;

    private $request;

    /**
     * Notification Label
     */
    public static $label = 'Low Stock Threshold';

    /**
     * Image
     *
     * @var string
     */
    public static $image = 'public/frontend/img/stock.png';

    public function __construct($request)
    {
        $this->request = $request;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public static function getVia()
    {
        return [
            'mail' => 'Mail',
            'database' => 'Database',
            SmsChannel::class => 'SMS',
            AdminDatabaseChannel::class => 'Admin Database',
        ];
    }

    /**
     * Get Label
     */
    public static function getLabel()
    {
        return static::$label;
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
        return (new MailLowStockThreshold())->send($this->request);
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
            'url' => route('vendor.products'),
            'message' => "Some products have reached the low stock threshold value: {$this->request->product_list}.",
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
            'url' => route('product.index'),
            'message' => "Some products belonging to {$notifiable->name} have reached the low stock threshold value: {$this->request->product_list}.",
        ];
    }

    /**
     * Get the SMS representation of the notification.
     */
    public function toSms(object $notifiable): array
    {
        return [
            'to' => $notifiable->phone,
            'message' => $this->getSmsData('low-stock-threshold'),
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
            '{user_name}' => $this->request['vendor_name'],
            '{company_url}' => route('site.index'),
            '{product_list}' => $this->request['product_list'],
        ];

        return str_replace(array_keys($data), $data, $body);
    }
}
