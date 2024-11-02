<?php

namespace Modules\Gateway\Redirect;

use Modules\Gateway\Entities\PaymentLog;
use Modules\Gateway\Facades\GatewayHelper;

class GatewayRedirect
{
    /**
     * Handles redirection from system to payment gateway
     *
     * @param  mixed  $order  Target class object
     * @param  float  $amount  Total amount that needs to be paid
     * @param  string  $currencyCode  Currency code of payable amount (USD)
     * @param  string  $code  An unique key for the order that you will store in your database
     * @return redirect
     */
    public static function paymentRoute($order, $amount, $currencyCode, $code, $request, $payMentId = null, $paymentType = null)
    {
        if (is_null($payMentId)) {
            $log = PaymentLog::create([
                'total' => $amount,
                'currency_code' => $currencyCode,
                'sending_details' => json_encode($order),
                'code' => $order->id,
                'status' => 'pending',
            ]);
        } else {
            $log = PaymentLog::select('total', 'currency_code', 'sending_details', 'code', 'status')->where('id', $payMentId)->first();
        }
        GatewayHelper::storeDataLocally($code, $log);

        GatewayHelper::setPaymentCode($order->id);

        if ((! is_null($request) && $request->wantsJson()) || request()->payer == 'guest') {
            request()->query->add(withOldQueryString(['code' => techEncrypt($code), 'redirect' => 'confirmation']));

            return route('gateway.payment', withOldQueryString(['code' => techEncrypt($code), 'redirect' => 'confirmation', 'integrity' => getIntegrityKey(), 'paymentType' => $paymentType]));
        }
        request()->query->add(withOldQueryString(['code' => techEncrypt($code), 'payer' => 'user']));

        return route('gateway.payment', withOldQueryString(['integrity' => getIntegrityKey(), 'paymentType' => $paymentType]));
    }

    /**
     * Generates payment link for guests
     *
     * @param  string|int  $code  Identifier for payment log
     * @param  array|null  $options  query parameters
     * @return string|null
     */
    public static function generateGuestPaymentLink($code, $options = [])
    {
        $paymentLog = PaymentLog::where('code', $code)->where('status', '!=', 'completed')->first();

        if (! $paymentLog) {
            return null;
        }

        $params = [
            'code' => techEncrypt($code),
            'payer' => 'guest',
            'to' => techEncrypt('site.orderpaid.guest'),
        ];

        $params = array_merge($params, $options);

        request()->query->add($params);

        return route('gateway.payment', withOldQueryString(['integrity' => getIntegrityKey()]));
    }

    public static function confirmationRedirect()
    {
        return route('gateway.confirmation', withOldQueryString());
    }

    public static function failedRedirect($error = '')
    {
        return route('gateway.failed', withOldQueryString(['error' => $error]));
    }
}
