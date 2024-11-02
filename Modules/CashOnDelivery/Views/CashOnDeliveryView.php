<?php

namespace Modules\CashOnDelivery\Views;

use Modules\CashOnDelivery\Entities\CashOnDelivery;
use Modules\Gateway\Contracts\PaymentViewInterface;
use Modules\Gateway\Services\GatewayHelper;
use Modules\Gateway\Traits\ApiResponse;

class CashOnDeliveryView implements PaymentViewInterface
{
    use ApiResponse;

    public static function paymentView($key)
    {
        $helper = GatewayHelper::getInstance();

        try {
            $cod = CashOnDelivery::firstWhere('alias', 'cashondelivery')->data;

            return view('cashondelivery::pay', [
                'instruction' => $cod->instruction,
                'purchaseData' => $helper->getPurchaseData($key),
            ]);
        } catch (\Exception $e) {
            return back()->withErrors(['error' => __('Purchase data not found.')]);
        }
    }

    public static function paymentResponse($key)
    {
        $helper = GatewayHelper::getInstance();

        $cod = CashOnDelivery::firstWhere('alias', 'cashondelivery')->data;

        return [
            'instruction' => $cod->instruction,
            'purchaseData' => $helper->getPurchaseData($key),
        ];
    }
}
