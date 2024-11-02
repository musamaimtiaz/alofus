<?php

namespace Modules\Gateway\Http\Controllers;

use App\Models\Order;
use Modules\Gateway\Contracts\RequiresWebHookValidationInterface;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Modules\Gateway\Contracts\CryptoResponseInterface;
use Modules\Gateway\Contracts\HasDataResponseInterface;
use Modules\Gateway\Contracts\RequiresCallbackInterface;
use Modules\Gateway\Entities\GatewayModule;
use Modules\Gateway\Entities\PaymentLog;
use Modules\Gateway\Facades\GatewayHandler;
use Modules\Gateway\Redirect\GatewayRedirect;
use Modules\Gateway\Services\GatewayHelper;

class GatewayController extends Controller
{
    private $helper;

    public function __construct()
    {
        $this->helper = GatewayHelper::getInstance();
    }

    /**
     * Display payable payment gateway.
     *
     * @return Renderable
     */
    public function paymentGateways(Request $request)
    {
        if (! checkRequestIntegrity()) {
            return redirect(GatewayRedirect::failedRedirect('integrity'));
        }

        $query = $request->query->all() ?? [];
        $paymentType = request()->paymentType ? request()->paymentType . 'PayableGateways' : 'payableGateways';
        $purchaseData = $this->helper->getPurchaseData();
        $gateways = (new GatewayModule())->$paymentType();

        if ($purchaseData->status == 'completed') {
            $message = __('Already paid for the order.');

            return view('gateway::pay', compact('gateways', 'purchaseData', 'message'));
        }

        return view('gateway::pay', compact('gateways', 'purchaseData'));
    }

    /**
     * Displays the payment page for specific payment gateway
     *
     * @param \Illuminate\Http\Request
     * @return Renderable
     */
    public function pay(Request $request)
    {
        if (! checkRequestIntegrity()) {
            return redirect(GatewayRedirect::failedRedirect('integrity'));
        }
        if (moduleAvailable($request->gateway) && $this->helper->isModuleActive($request->gateway)) {
            $viewClass = GatewayHandler::getView($request->gateway);

            return $viewClass::paymentView($this->helper->getPaymentCode());
        }

        return redirect(route('gateway.payment', withOldQueryString()))->withErrors(__('Payment method not found.'));
    }

    /**
     * Process the payment for specific gateway
     *
     * @param \Illuminate\Http\Request
     * @return redirect
     */
    public function makePayment(Request $request)
    {
        if (! checkRequestIntegrity()) {
            return redirect(GatewayRedirect::failedRedirect('integrity'));
        }
        if (moduleAvailable($request->gateway)) {
            try {
                $code = $this->helper->getPaymentCode();

                if (! $this->helper->getPaymentLog($code)) {
                    return redirect()->route('site.cart')->withErrors(__(':x does not exist.', ['x' => __('Order')]));
                }

                $processor = GatewayHandler::getProcessor($request->gateway);

                $response = $processor->pay($request);

                if ($processor instanceof RequiresWebHookValidationInterface) {
                    PaymentLog::where('code', $code)->update($this->getUpdateData($response));

                    return redirect($response->getUrl());
                }
                if ($processor instanceof RequiresCallbackInterface) {
                    return $response;
                }
                PaymentLog::where('code', $code)->update($this->getUpdateData($response));
            } catch (\Exception $e) {
                return redirect(route('gateway.payment', withOldQueryIntegrity()))->withErrors($e->getMessage());
            }

            return redirect()->route(techDecrypt(request()->to), withOldQueryIntegrity());
        }

        return redirect(route('gateway.payment', withOldQueryIntegrity()))->withErrors(__('Payment method not available.'));
    }

    /**
     * This function handle response of redirected payment callbacks
     *
     * @param \Illuminate\Http\Request
     * @return redirect
     */
    public function paymentCallback(Request $request)
    {
        try {
            $processor = GatewayHandler::getProcessor($request->gateway);
            $response = $processor->validateTransaction($request);
            $code = $this->helper->getPaymentCode();
            PaymentLog::where('code', $code)->update($this->getUpdateData($response));

            return redirect(route(techDecrypt(request()->to), withOldQueryIntegrity()));
        } catch (\Exception $e) {
            return redirect(route('gateway.payment', withOldQueryIntegrity()))->withErrors($e->getMessage());
        }
    }

    /**
     * Handles cancelled payment request
     *
     * @param \Illuminate\Http\Request
     * @return redirect
     */
    public function paymentCancelled(Request $request)
    {
        try {
            $processor = GatewayHandler::getProcessor($request->gateway);
            $processor->cancel($request);
        } catch (\Exception $e) {
            return redirect(route('gateway.payment'))->withErrors($e->getMessage());
        }
    }

    /**
     * Process payment from gateways which sends response to the hook URL
     *
     * @param \Illuminate\Http\Request
     * @return bool
     */
    public function paymentHook(Request $request)
    {
        try {
            $processor = GatewayHandler::getProcessor($request->gateway);
            $payment = $processor->validatePayment($request);
            if (! $payment) {
                return false;
            }
        } catch (\Exception $e) {
            paymentLog([$e, $request->all()]);

            return false;
        }

        return true;
    }

    /**
     * Process payment response
     *
     * @param \Modules\Gateway\Response\Response
     * @return array
     */
    private function getUpdateData($response)
    {
        $array['gateway'] = $response->getGateway();
        $array['status'] = $response->getStatus();
        if ($response instanceof HasDataResponseInterface) {
            $array['response'] = $response->getResponse();
            $array['response_raw'] = $response->getRawResponse();
        }
        if ($response instanceof CryptoResponseInterface) {
            $array['unique_code'] = $response->getUniqueCode();
        }

        return $array;
    }

    public function paymentConfirmation(Request $request)
    {
        $code = techDecrypt($request->code);
        $order = Order::where('reference', $code)->first();
        $purchaseData = PaymentLog::where('code', $order->id)->orderBy('id', 'desc')->first();

        return view('gateway::confirmation', compact('purchaseData'));
    }

    public function paymentFailed(Request $request)
    {
        $errors = [
            'integrity' => __('Invalid payment request authentication failed. Please retry payment from the start.'),
            'error' => __('Payment processing failed.'),
        ];
        $data = [];
        if (isset($errors[$request->error])) {
            $data['message'] = $errors[$request->error];
        }

        return view('gateway::failed-payment', $data);
    }
}
