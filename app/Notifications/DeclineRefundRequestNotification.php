<?php

namespace App\Notifications;

use App\Models\Currency;
use App\Models\User;
use App\Models\Vendor;
use App\Notifications\Channel\AdminDatabaseChannel;
use App\Notifications\Channel\SmsChannel;
use App\Services\Mail\RefundMailService;
use App\Traits\NotificationTrait;
use Illuminate\Bus\Queueable;
use Modules\Refund\Entities\Refund;

class DeclineRefundRequestNotification extends Notification
{
    use NotificationTrait;
    use Queueable;

    private $request;

    /**
     * Notification Label
     */
    public static $label = 'Decline Refund Request';

    /**
     * Product
     */
    private static $product;

    /**
     * Image
     *
     * @var string
     */
    public static $image = 'public/frontend/img/refund.png';

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
        return (new RefundMailService())->send($this->request);
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        self::$product = Refund::find($this->request->id)?->getProduct();

        return [
            'id' => $notifiable->id,
            'label' => static::$label,
            'url' => route('site.refundDetails', ['id' => $this->request->id]),
            'message' => 'Your request for the refund of the product: ' . self::$product?->name . ' is decline',
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
            'url' => route('refund.edit', ['id' => $this->request->id]),
            'message' => 'The refund request for the product ' . self::$product?->name . " made by {$notifiable->name} has been declined.",
        ];
    }

    /**
     * Get the SMS representation of the notification.
     */
    public function toSms(object $notifiable): array
    {
        return [
            'to' => $notifiable->phone,
            'message' => $this->getSmsData('decline-refund-request'),
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
        $userInfo = User::where('id', $this->request->user_id)->first();

        $refund = Refund::find($this->request->id);
        $product = $refund->getProduct();

        $vendor = Vendor::select('id', 'name', 'phone')->where('email', $this->request->vendor_email)->first();

        $data = [
            '{logo}' => '',
            '{user_name}' => $userInfo->name,
            '{product_image}' => $product->getFeaturedImage('small'),
            '{product_name}' => $product->name,
            '{vendor_name}' => $vendor?->name,
            '{product_qty}' => $refund->quantity_sent,
            '{currency_symbol}' => Currency::getDefault()->symbol,
            '{price}' => $this->request->total,
            '{contact_number}' => $vendor?->phone,
            '{product_details_url}' => route('site.productDetails', ['slug' => $product->slug]),
            '{support_mail}' => $this->request->vendor_email,
            '{company_name}' => preference('company_name'),
        ];

        return str_replace(array_keys($data), $data, $body);
    }
}
