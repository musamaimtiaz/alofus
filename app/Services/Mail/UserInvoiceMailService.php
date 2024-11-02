<?php

namespace App\Services\Mail;

use App\Models\Order;
use App\Models\User;
use App\Services\Actions\OrderAction;

class UserInvoiceMailService extends TechVillageMail
{
    /**
     * Send mail to user
     *
     * @param  object  $request
     * @return array $response
     */
    public function send($request)
    {
        $email = $this->getTemplate(preference('dflt_lang'), 'order');

        if (! $email['status']) {
            return $email;
        }

        // Send pdf with mail
        createDirectory('public/uploads/invoices');
        $invoiceName = $request->reference . '.pdf';
        (new Order())->invoicePdfEmail($request, $invoiceName);

        $address = $request->getShippingAddress();
        $user = User::whereId($request->user_id)->first();
        $shippingAddress = <<<END
            <p style="margin-bottom:0;padding-bottom:0">$address->first_name $address->last_name</p>
            <p style="margin:0;padding:0">$address->email</p>
            <p style="margin-top:0;padding-top:0">$address->phone</p>
            <p style="margin:0;padding:0">$address->address_1</p>
            <p style="margin:0;padding:0">$address->address_2</p>
            <p style="margin:0;padding:0">$address->city, $address->state, $address->country</p>
        END;

        $products = '';
        foreach ($request->orderDetails as $key => $item) {
            $quantity = (int) $item->quantity;
            $price = formatNumber($item->price);
            $name = $item->product_name;
            $vendor = optional($item->vendor)->name;

            $attributes = '';
            if ($item->payloads != null) {
                $option = (array) json_decode($item->payloads);
                $itemCount = count($option);
                $i = 0;
                foreach ($option as $key => $value) {
                    $attributes .= $key . ': ' . $value . (++$i == $itemCount ? '' : ', ');
                }
            }

            $purchaseNote = $item->productMeta->where('key', 'meta_purchase_note')->first();
            $orderAction = (new OrderAction())->getProductInfo($item);

            if (! empty($purchaseNote) && ! empty($purchaseNote->value) && $purchaseNote->value != '') {
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
               <tr><td colspan="4" style="font-family:'DM Sans', sans-serif;  border-bottom: 1px solid #DFDFDF; font-style: normal; margin-left: 10px; font-weight: 500;font-size: 14px;line-height: 18px;color: #2C2C2C; vertical-align: baseline; padding-top: 22px">{$purchaseNote->value}</td></tr>
            END;
            } else {
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

            $downloadData = $request->download_data;
            $downloadHtml = '';

            if (is_array($downloadData) && ! empty($downloadData)) {
                $downloadHtmlRow = '';
                $col1 = __('Product');
                $col2 = __('Download expiry');
                $col3 = __('Download');
                $fileTxt = __('File');
                $downloadHtml .= <<<END
                        <div style="clear: both;"></div>
                            <div style="margin:14px 20px;">
                            <table class="tables" id="customers" border="0" cellpadding="0" cellspacing="0"
                            width="100%" style="text-align: left;">
                            <tr style="align-items:left;">
                            <th style="padding-left: 18px;">{$col1}</th>
                            <th>{$col2}</th>
                            <th style="padding-left:18px;">{$col3}</th>
                            </tr>
                            'download_data'
                            <td></td>
                              </table>
                        </div>
                        END;
                foreach ($request->download_data as $key => $data) {
                    if (($data['is_accessible'] == 1)) {
                        $downloadExpire = $data['download_expiry'] == '' ? __('Never') : formatDate($request->created_at->addDays($data['download_expiry']));
                        $downloadLink = route('site.downloadProduct', ['link' => \Crypt::encrypt($data['link']), 'file' => $data['id'] . ',' . $request['id']]);
                        $downloadHtmlRow .= <<<END
                <tr>
                    <td style="font-family:'DM Sans', sans-serif; border-bottom: 1px solid #DFDFDF;font-style: normal; font-weight: 500; font-size: 12px; width: 100px; line-height: 16px; color: #2C2C2C; vertical-align: baseline; padding-top: 22px">
                        {$data['name']}
                    </td>
                    <td style="font-family:'DM Sans', sans-serif; border-bottom: 1px solid #DFDFDF; font-style: normal; padding-left: 24px; font-weight: 500; font-size: 14px; line-height: 18px; text-align: left;  margin-left: 10px; color: #2C2C2C; vertical-align: baseline; padding-top: 22px">
                        {$downloadExpire}
                    </td>
                    <td style="font-family:'DM Sans', sans-serif;  border-bottom: 1px solid #DFDFDF; font-style: normal; margin-left: 10px; font-weight: 500;font-size: 14px;line-height: 18px;color: #2C2C2C; vertical-align: baseline; padding-top: 22px">
                        <a href="{$downloadLink}">{$fileTxt}</a>
                    </td>
                </tr>
            END;

                    }
                }
                $downloadHtml = str_replace('download_data', $downloadHtmlRow, $downloadHtml);
            }

        }

        // Replacing template variable
        $subject = str_replace(['{company_name}', '{invoice_reference_no}'], [preference('company_name'), $request->reference], $email->subject);

        $data = [
            '{logo}' => $this->logo,
            '{order_number}' => $request->reference,
            '{user_name}' => ! is_null(optional($request->user)->name) ? $request->user->name : $address->first_name . ' ' . $address->last_name,
            '{company_url}' => route('site.index'),
            '{company_name}' => preference('company_name'),
            '{order_confirm_date}' => timeZoneFormatDate($request->order_date),
            '{contact_number}' =>  preference('company_phone'),
            '{order_track_url}' => route('site.trackOrder', ['code' => $request->track_code]),
            '{products}' => $products,
            '{currency_symbol}' => optional($request->currency)->symbol,
            '{subtotal}' => formatCurrencyAmount(($request->total + $request->other_discount_amount) - ($request->shipping_charge + $request->tax_charge)),
            '{shipping_charge}' => formatCurrencyAmount($request->shipping_charge),
            '{grand_total}' => formatCurrencyAmount($request->total),
            '{shipping_address}' => $shippingAddress,
            '{payment_method}' => ! empty($request->paymentMethod->gateway) ? $request->paymentMethod->gateway : __('Unknown'),
            '{support_mail}' => preference('company_email'),
            '{tax_charge}' => formatCurrencyAmount($request->tax_charge),
            '{discount_amount}' => formatCurrencyAmount($request->other_discount_amount),
            '{track_code}' => $request->track_code,
            '{download}' => $downloadHtml,
        ];

        $message = str_replace(array_keys($data), $data, $email->body);
        if (! empty($user->email)) {
            return $this->email->sendEmailWithAttachment($user->email, $subject, $message, $invoiceName, preference('company_name'));
        } elseif (! empty($address->email)) {
            return $this->email->sendEmailWithAttachment($address->email, $subject, $message, $invoiceName, preference('company_name')); // if user will guest
        }

        return ['status' => false, 'message' => __('User email not found.')];
    }
}
