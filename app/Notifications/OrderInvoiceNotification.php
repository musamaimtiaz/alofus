<?php

namespace App\Notifications;

use App\Notifications\Channel\AdminDatabaseChannel;
use App\Notifications\Channel\SmsChannel;
use App\Services\Mail\UserInvoiceMailService;
use App\Traits\NotificationTrait;
use Illuminate\Bus\Queueable;

class OrderInvoiceNotification extends Notification
{
    use NotificationTrait;
    use Queueable;

    private $request;

    /**
     * Notification Label
     */
    public static $label = 'Order Invoice';

    /**
     * Image
     *
     * @var string
     */
    public static $image = 'public/frontend/img/order.png';

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
        return (new UserInvoiceMailService())->send($this->request);
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
            'url' => route('site.orderDetails', ['reference' => $this->request->reference]),
            'message' => "Your order {$this->request->reference} has been confirmed. Your order is being prepared for delivery. To track your order, use the code: {$this->request->track_code}",
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
            'url' => route('order.view', ['id' => $this->request->id]),
            'message' => "The order with reference {$this->request->reference} for {$notifiable->name} has been confirmed.",
        ];
    }

    /**
     * Get the SMS representation of the notification.
     */
    public function toSms(object $notifiable): array
    {
        return [
            'to' => $notifiable->phone,
            'message' => $this->getSmsData('order'),
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
        $address = $this->request->getShippingAddress();

        $shippingAddress = "Name: $address->first_name $address->last_name, Email: $address->email, Phone: $address->phone, Address: $address->address_1, Address2:$address->address_2, $address->city, $address->state, $address->country";

        $data = [
            '{order_number}' => $this->request->reference,
            '{user_name}' => ! is_null(optional($this->request->user)->name) ? $this->request->user->name : $address->first_name . ' ' . $address->last_name,
            '{company_url}' => route('site.index'),
            '{company_name}' => preference('company_name'),
            '{order_confirm_date}' => timeZoneFormatDate($this->request->order_date),
            '{contact_number}' =>  preference('company_phone'),
            '{order_track_url}' => route('site.trackOrder', ['code' => $this->request->track_code]),
            '{products}' => implode(',', $this->request->orderDetails->pluck('product_name')->toArray()),
            '{currency_symbol}' => optional($this->request->currency)->symbol,
            '{subtotal}' => formatCurrencyAmount(($this->request->total + $this->request->other_discount_amount) - ($this->request->shipping_charge + $this->request->tax_charge)),
            '{shipping_charge}' => formatCurrencyAmount($this->request->shipping_charge),
            '{grand_total}' => formatCurrencyAmount($this->request->total),
            '{shipping_address}' => $shippingAddress,
            '{payment_method}' => ! empty($this->request->paymentMethod->gateway) ? $this->request->paymentMethod->gateway : __('Unknown'),
            '{support_mail}' => preference('company_email'),
            '{tax_charge}' => formatCurrencyAmount($this->request->tax_charge),
            '{discount_amount}' => formatCurrencyAmount($this->request->other_discount_amount),
            '{track_code}' => $this->request->track_code,
            '{download}' => '',
        ];

        return str_replace(array_keys($data), $data, $body);
    }
}
