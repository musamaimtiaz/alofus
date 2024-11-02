<?php

/**
 * @author TechVillage <support@techvill.org>
 *
 * @contributor Muhammad AR Zihad <[zihad.techvill@gmail.com]>
 *
 * @created 15-2-22
 */

namespace Modules\Paypal\Views;

use Modules\Gateway\Contracts\PaymentViewInterface;
use Modules\Gateway\Facades\GatewayHelper;
use Modules\Paypal\Entities\Paypal;

class PaypalView implements PaymentViewInterface
{
    public static function paymentView($key)
    {
        $helper = GatewayHelper::getInstance();

        try {
            $paypal = Paypal::firstWhere('alias', 'paypal')->data;

            return view('paypal::pay', [
                'instruction' => $paypal->instruction,
                'purchaseData' => $helper->getPurchaseData($key),
            ]);
        } catch (\Exception $e) {
            return back()->withErrors(['error' => __('Purchase data not found.')]);
        }
    }
}
