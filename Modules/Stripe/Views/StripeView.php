<?php

/**
 * @author TechVillage <support@techvill.org>
 *
 * @contributor Muhammad AR Zihad <[zihad.techvill@gmail.com]>
 *
 * @created 06-02-2022
 */

namespace Modules\Stripe\Views;

use Modules\Gateway\Contracts\PaymentViewInterface;
use Modules\Gateway\Services\GatewayHelper;
use Modules\Gateway\Traits\ApiResponse;
use Modules\Stripe\Entities\Stripe;

class StripeView implements PaymentViewInterface
{
    use ApiResponse;

    public static function paymentView($key)
    {
        $helper = GatewayHelper::getInstance();

        try {
            $stripe = Stripe::firstWhere('alias', 'stripe')->data;

            return view('stripe::pay', [
                'publishableKey' => $stripe->publishableKey,
                'instruction' => $stripe->instruction,
                'purchaseData' => $helper->getPurchaseData($key),
            ]);
        } catch (\Exception $e) {
            return back()->withErrors(['error' => __('Purchase data not found.')]);
        }
    }

    public static function paymentResponse($key)
    {
        $helper = GatewayHelper::getInstance();

        $stripe = Stripe::firstWhere('alias', 'stripe')->data;

        return [
            'publishableKey' => $stripe->publishableKey,
            'instruction' => $stripe->instruction,
            'purchaseData' => $helper->getPurchaseData($key),
        ];
    }
}
