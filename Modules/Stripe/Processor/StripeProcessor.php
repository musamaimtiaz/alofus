<?php

/**
 * @author TechVillage <support@techvill.org>
 *
 * @contributor Muhammad AR Zihad <[zihad.techvill@gmail.com]>
 *
 * @created 06-02-2022
 */

namespace Modules\Stripe\Processor;

use Modules\Gateway\Services\GatewayHelper;
use Modules\Stripe\Entities\Stripe as StripeModel;
use Modules\Stripe\Response\StripeResponse;
use Stripe\Exception\AuthenticationException;
use Stripe\Exception\OAuth\InvalidRequestException;
use Modules\Gateway\Contracts\{
    PaymentProcessorInterface,
    RequiresCallbackInterface
};

class StripeProcessor implements PaymentProcessorInterface, RequiresCallbackInterface
{
    private $secret;

    private $key;

    private $helper;

    private $purchaseData;

    private $success_url;

    private $cancel_url;

    public function __construct()
    {
        $this->helper = GatewayHelper::getInstance();
    }

    /**
     * Handles payment for stripe
     *
     * @param \Illuminate\Http\Request
     * @return StripeResponse
     */
    public function pay($request)
    {
        $this->stripeSetup($request);

        $charge = $this->charge();
        if (! $charge) {
            throw new \Exception(__('Payment Request failed due to some issues. Please try again later.'));
        }

        $this->setStripeSessionId($charge->id);

        return redirect($charge->url);
    }

    /**
     * Stripe data setup
     *
     * @param \Illuminate\Http\Request
     *
     * return mixed
     */
    private function stripeSetup($request)
    {
        try {
            $this->key = $this->helper->getPaymentCode();
            $stripe = StripeModel::firstWhere('alias', 'stripe')->data;
            $this->secret = $stripe->clientSecret;
            $this->purchaseData = $this->helper->getPurchaseData($this->key);
            $this->success_url = route(moduleConfig('gateway.payment_callback'), withOldQueryIntegrity(['gateway' => 'stripe']));
            $this->cancel_url = route(moduleConfig('gateway.payment_cancel'), withOldQueryIntegrity(['gateway' => 'stripe']));
            \Stripe\Stripe::setApiKey($this->secret);

        } catch (\Exception $e) {
            paymentLog($e);

            throw new \Exception(__('Error while trying to setup stripe.'));
        }
    }

    /**
     * Create charge for payment
     *
     * @return mixed
     */
    private function charge()
    {
        try {
            return \Stripe\Checkout\Session::create([
                'line_items' => [
                    [
                        'price_data' => [
                            'product_data' => [
                                'name' => config('app.name') . ' Payment',
                            ],
                            'unit_amount' => round($this->purchaseData->total * 100, 0),
                            'currency' => $this->purchaseData->currency_code,
                        ],
                        'quantity' => 1,
                    ],
                ],
                'mode' => 'payment',
                'success_url' => $this->success_url,
                'cancel_url' => $this->cancel_url,
            ]);

        } catch (InvalidRequestException $e) {
            throw new \Exception(__('Payment Request failed due to some issues. Please try again later.'));
        } catch (AuthenticationException $e) {
            throw new \Exception(__('Payment Request failed due to credentials mismatch.'));
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }

    private function setStripeSessionId($id)
    {
        session(['stripe_session_id' => $id]);
    }

    private function getStripeSessionId()
    {
        return session('stripe_session_id');
    }

    public function validateTransaction($request)
    {
        $this->stripeSetup($request);
        $line_item = \Stripe\Checkout\Session::retrieve($this->getStripeSessionId());

        return new StripeResponse($this->purchaseData, $line_item);
    }
}
