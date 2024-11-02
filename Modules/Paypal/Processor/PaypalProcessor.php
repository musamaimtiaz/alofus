<?php

/**
 * @author TechVillage <support@techvill.org>
 *
 * @contributor Muhammad AR Zihad <[zihad.techvill@gmail.com]>
 *
 * @created 15-2-22
 */

namespace Modules\Paypal\Processor;

use Modules\Gateway\Contracts\PaymentProcessorInterface;
use Modules\Gateway\Contracts\RequiresCallbackInterface;
use Modules\Gateway\Contracts\RequiresCancelInterface;
use Modules\Gateway\Facades\GatewayHelper;
use Modules\Paypal\Entities\Paypal;
use Modules\Paypal\Response\PaypalResponse;
use Modules\Paypal\Services\Core\PayPalHttpClient;
use Modules\Paypal\Services\Core\ProductionEnvironment;
use Modules\Paypal\Services\Core\SandboxEnvironment;
use Modules\Paypal\Services\Orders\OrdersCreateRequest;
use Modules\Paypal\Services\Orders\OrdersCaptureRequest;
use PayPalHttp\HttpException;

class PaypalProcessor implements PaymentProcessorInterface, RequiresCallbackInterface, RequiresCancelInterface
{
    private $paypal;

    private $data;

    private $code;

    public function pay($request)
    {
        $this->setup();

        try {
            $orderRequest = new OrdersCreateRequest();
            $orderRequest->prefer('return=representation');
            $orderRequest->body = $this->getRequestBody();
            $response = $this->client()->execute($orderRequest);
        } catch (HttpException $e) {
            paymentLog($e);

            throw new \Exception(__('Paypal payment request failed.'));
        }

        $links = $response->result->links;
        $this->setOrderId($response->result->id);

        foreach ($links as $link) {
            if ($link->rel == 'approve') {
                return redirect($link->href);
            }
        }
    }

    private function setup()
    {
        $this->paypal = Paypal::firstWhere('alias', 'paypal')->data;
        $this->code = GatewayHelper::getPaymentCode();
        $this->data = GatewayHelper::getPurchaseData($this->code);
    }

    private function environment()
    {
        if (! $this->paypal->sandbox) {
            return new ProductionEnvironment($this->paypal->clientId, $this->paypal->secretKey);
        }

        return new SandboxEnvironment($this->paypal->clientId, $this->paypal->secretKey);
    }

    private function client()
    {
        return new PayPalHttpClient($this->environment());
    }

    private function getRequestBody()
    {
        return [
            'intent' => 'CAPTURE',
            'purchase_units' => [
                [
                    'reference_id' => $this->code,
                    'amount' => [
                        'currency_code' => $this->data->currency_code,
                        'value' => strval(round($this->data->total, 2)),
                    ],
                ],
            ],
            'application_context' => [
                'brand_name' => moduleConfig('gateway.app_name'),
                'return_url' => route(moduleConfig('gateway.payment_callback'), withOldQueryIntegrity(['gateway' => 'paypal'])),
                'cancel_url' => route(moduleConfig('gateway.payment_cancel'), withOldQueryIntegrity(['gateway' => 'paypal'])),
                'user_action' => 'PAY_NOW',
            ],
        ];
    }

    private function setOrderId($id)
    {
        session(['paypal_order_id' => $id]);
    }

    private function getOrderId()
    {
        return session('paypal_order_id');
    }

    public function validateTransaction($request)
    {
        $this->setup();

        try {
            $request = new OrdersCaptureRequest($this->getOrderId());
            $request->prefer('return=representation');
            $response = $this->client()->execute($request);
        } catch (HttpException $e) {
            paymentLog($e);

            throw new \Exception($e->getMessage());
        }

        return new PaypalResponse($this->data, $response->result);
    }

    public function cancel($request)
    {
        throw new \Exception(__('Payment cancelled from paypal.'));
    }
}
