<?php

namespace App\Notifications;

use App\Notifications\Channel\AdminDatabaseChannel;
use App\Notifications\Channel\SmsChannel;
use App\Services\Mail\VendorInvoiceMailService;
use App\Traits\NotificationTrait;
use Illuminate\Bus\Queueable;

class VendorOrderInvoiceNotification extends Notification
{
    use NotificationTrait;
    use Queueable;

    private $request;

    public static $vendor;

    /**
     * Notification Label
     */
    public static $label = 'Vendor Order Invoice';

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
        self::$vendor = $notifiable;

        return ['mail', 'database', SmsChannel::class, AdminDatabaseChannel::class];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable)
    {
        $this->request['vendor_id'] = $notifiable->id;

        return (new VendorInvoiceMailService())->send($this->request);
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
            'url' => route('vendorOrder.view', ['id' => $this->request->id]),
            'message' => "A new order {$this->request->reference} has been confirmed",
        ];
    }

    /**
     * Get the SMS representation of the notification.
     */
    public function toSms(object $notifiable): array
    {
        return [
            'to' => $notifiable->phone,
            'message' => $this->getSmsData('vendor-invoice'),
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

        $details = $this->request->orderDetails->where('vendor_id', self::$vendor->id);

        $subTotal = 0;
        $shippingCharge = 0;
        $taxCharge = 0;
        $vendorId = $details->first()->vendor_id;
        $discount = $this->request->vendorCouponDiscount($vendorId);

        foreach ($details as $item) {
            $subTotal += $item->quantity * $item->price;
            $shippingCharge += $item->shipping_charge;
            $taxCharge += $item->tax_charge;
        }

        $data = [
            '{logo}' => '',
            '{order_number}' => $this->request->reference,
            '{user_name}' => self::$vendor->name,
            '{company_url}' => route('site.index'),
            '{company_name}' => preference('company_name'),
            '{order_confirm_date}' => timeZoneFormatDate($this->request->order_date),
            '{contact_number}' =>  preference('company_phone'),
            '{order_track_url}' => route('site.trackOrder', ['code' => $this->request->track_code]),
            '{products}' => implode(',', $this->request->orderDetails->pluck('product_name')->toArray()),
            '{currency_symbol}' => optional($this->request->currency)->symbol,
            '{subtotal}' => formatCurrencyAmount($subTotal),
            '{shipping_charge}' => formatCurrencyAmount($shippingCharge),
            '{grand_total}' => formatCurrencyAmount($subTotal + $taxCharge + $shippingCharge - $discount),
            '{shipping_address}' => $shippingAddress,
            '{payment_method}' => ! empty($this->request->paymentMethod->gateway) ? $this->request->paymentMethod->gateway : __('Unknown'),
            '{support_mail}' => preference('company_email'),
            '{tax_charge}' => formatCurrencyAmount($taxCharge),
            '{discount_amount}' => formatCurrencyAmount($discount),
            '{track_code}' => $this->request->track_code,
            '{download}' => '',
        ];

        return str_replace(array_keys($data), $data, $body);
    }
}
