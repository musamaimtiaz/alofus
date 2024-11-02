<?php

namespace App\Services\Mail;

use App\Models\Order;
use App\Services\Actions\OrderAction;

class VendorInvoiceMailService extends TechVillageMail
{
    /**
     * Send mail to user
     *
     * @param  object  $request
     * @return array $response
     */
    public function send($request)
    {
        $response = ['status' => false, 'message' => __('Vendor email not found.')];
        $email = $this->getTemplate(preference('dflt_lang'), 'order');

        if (! $email['status']) {
            return $email;
        }

        $address = $request->getShippingAddress();
        $shippingAddress = <<<END
            <p style="margin-bottom:0;padding-bottom:0">$address->first_name $address->last_name</p>
            <p style="margin:0;padding:0">$address->email</p>
            <p style="margin-top:0;padding-top:0">$address->phone</p>
            <p style="margin:0;padding:0">$address->address_1</p>
            <p style="margin:0;padding:0">$address->address_2</p>
            <p style="margin:0;padding:0">$address->city, $address->state, $address->country</p>
        END;

        $detail = $request->orderDetails->where('vendor_id', $request->vendor_id);

        if (empty($detail->first())) {
            return;
        }
        $subTotal = 0;
        $shippingCharge = 0;
        $taxCharge = 0;
        $products = '';
        $vendorId = $detail->first()->vendor_id;
        $discount = $request->vendorCouponDiscount($vendorId);

        foreach ($detail as $key => $item) {
            $quantity = (int) $item->quantity;
            $price = formatNumber($item->price);
            $name = $item->product_name;
            $vendor = optional($item->vendor)->name;
            $subTotal += $item->quantity * $item->price;
            $shippingCharge += $item->shipping_charge;
            $taxCharge += $item->tax_charge;

            $attributes = '';
            if ($item->payloads != null) {
                $option = (array) json_decode($item->payloads);
                $itemCount = count($option);
                $i = 0;
                foreach ($option as $key => $value) {
                    $attributes .= $key . ': ' . $value . (++$i == $itemCount ? '' : ', ');
                }
            }
            $orderAction = (new OrderAction())->getProductInfo($item);

            $products .= <<<END
            <tr>
                <td style="border-bottom: 1px solid #DFDFDF; width: 300px;">
                    <img style="width: 21px; height: 21px; padding: 10.5px; background-color: #F1F1F1; border-radius: 2px; margin-left: 18px; margin-top: 24px; margin-bottom: 24px;float:left"
                        src="{$orderAction['image']}" alt=" ">
                    <div style="float:left; width: 220px; padding-bottom: 24px;">
                        <p style="font-family:'DM Sans', sans-serif; font-style: normal; font-weight: 500; font-size: 14px; margin-left: 12px; line-height: 20px; color: #2C2C2C; margin-top: 20px;">
                            {$name}
                        </p>
                        <p style="font-family: 'Roboto', sans-serif; font-style: normal;font-weight: 500; font-size: 12px;line-height: 13px; color: #898989; margin-left: 12px; margin-top: 4px;">
                            {$attributes}
                        </p>
                    </div>
                    <div style="clear: both;"></div>
                </td>
                <td style="font-family:'DM Sans', sans-serif; border-bottom: 1px solid #DFDFDF;font-style: normal; font-weight: 500; font-size: 12px; width: 100px; line-height: 16px; color: #2C2C2C; vertical-align: baseline; padding-top: 22px">
                    {$vendor}
                </td>
                <td style="font-family:'DM Sans', sans-serif; border-bottom: 1px solid #DFDFDF; font-style: normal; padding-left: 24px; font-weight: 500; font-size: 14px; line-height: 18px; text-align: left;  margin-left: 10px; color: #2C2C2C; vertical-align: baseline; padding-top: 22px">
                    {$quantity}
                </td>
                <td style="font-family:'DM Sans', sans-serif;  border-bottom: 1px solid #DFDFDF; font-style: normal; margin-left: 10px; font-weight: 500;font-size: 14px;line-height: 18px;color: #2C2C2C; vertical-align: baseline; padding-top: 22px">
                    {$price}
                </td>
            </tr>
        END;
        }

        // Replacing template variable
        $subject = str_replace(['{company_name}', '{invoice_reference_no}'], [preference('company_name'), $request->reference], $email->subject);
        $data = [
            '{logo}' => $this->logo,
            '{order_number}' => $request->reference,
            '{user_name}' => optional($detail->first()->vendor)->name,
            '{company_url}' => route('site.index'),
            '{company_name}' => preference('company_name'),
            '{order_confirm_date}' => timeZoneFormatDate($request->order_date),
            '{contact_number}' =>  preference('company_phone'),
            '{order_track_url}' => route('site.trackOrder', ['code' => $request->track_code]),
            '{products}' => $products,
            '{currency_symbol}' => optional($request->currency)->symbol,
            '{subtotal}' => formatCurrencyAmount($subTotal),
            '{shipping_charge}' => formatCurrencyAmount($shippingCharge),
            '{grand_total}' => formatCurrencyAmount($subTotal + $taxCharge + $shippingCharge - $discount),
            '{shipping_address}' => $shippingAddress,
            '{payment_method}' => ! empty($request->paymentMethod->gateway) ? $request->paymentMethod->gateway : __('Unknown'),
            '{support_mail}' => preference('company_email'),
            '{tax_charge}' => formatCurrencyAmount($taxCharge),
            '{discount_amount}' => formatCurrencyAmount($discount),
            '{track_code}' => $request->track_code,
            '{download}' => '',
        ];

        $message = str_replace(array_keys($data), $data, $email->body);
        $vendorEmail = optional($detail->first()->vendor)->email;
        $vendorOrder = Order::where('id', $request->id)->whereHas('orderDetails', function ($q) use ($vendorId) {
            $q->where('vendor_id', $vendorId);
        })->with('orderDetails')->first();

        if (! empty($vendorOrder) && ! empty($vendorEmail)) {
            $invoiceName = $request->reference . '.pdf';
            (new Order())->invoicePdfEmail($vendorOrder, $invoiceName, 'vendor', $vendorId);
            $response = $this->email->sendEmailWithAttachment($vendorEmail, $subject, $message, $invoiceName, preference('company_name'));
        }

        return $response;
    }
}
