<?php

/**
 * @author TechVillage <support@techvill.org>
 *
 * @contributor Muhammad AR Zihad <[zihad.techvill@gmail.com]>
 *
 * @created 09/02/2022
 */

namespace Modules\Gateway\Services;

use Modules\Gateway\Entities\Gateway;
use Modules\Gateway\Entities\PaymentLog;

class GatewayHelper
{
    public static $instance;

    public static function getInstance()
    {
        if (self::$instance == null) {
            self::$instance = new GatewayHelper();
        }

        return self::$instance;
    }

    /**
     * Set payment code
     *
     * @return mixed
     */
    public function getPaymentCode()
    {
        $key = session('order_code') ?? request()->query->get('code') ??  null;
        if (! $key) {
            throw new \Exception(__('Purchase data not found.'));
        }

        return techDecrypt($key);
    }

    /**
     * Set payment code to session
     *
     * @param  string  $code
     */
    public function setPaymentCode($code)
    {
        return session(['order_code' => techEncrypt($code)]);
    }

    /**
     * Returns purchase data
     *
     * @return mixed
     */
    public function getPurchaseData($key = null)
    {
        if (! $key) {
            $key = $this->getPaymentCode();
        }

        try {
            if (moduleConfig('gateway.driver') == 'session') {
                $purchaseData = session($key);
            } else {
                $purchaseData = cache('purchaseData.' . $key);
            }
            if ($purchaseData) {
                return unserialize($purchaseData);
            } else {
                return PaymentLog::where('code', $key)->first();
            }
        } catch (\Exception $e) {
            throw new \Exception(__('Purchase data not found.'));
        }
    }

    /**
     * Stores data locally
     *
     * @param  string  $key
     * @param  \Modules\Gateway\Entities\PaymentLog  $details
     */
    public function storeDataLocally($key, $details)
    {
        if (moduleConfig('gateway.driver') == 'session') {
            session([$key => serialize($details)]);
        } else {
            cache('purchaseData.' . $key, serialize($details), 600);
        }
    }

    /**
     * Check if the module is activated by the user
     *
     * @return bool
     */
    public function isModuleActive($alias)
    {
        try {
            return Gateway::select(['alias', 'status'])->firstWhere('alias', strtolower($alias))->status;
        } catch (\Exception $e) {
            return false;
        }
    }

    /**
     * Convert currency
     *
     * @param  string  $from  (Current currency code)
     * @param  string  $to  (Expected currency code)
     * @return float
     */
    public function convertCurrency($from, $to, $amount)
    {
        /**
         * convert currency
         * do your math
         *
         * this method internal mechanism may change from project to project
         */

        return $amount;
    }

    public function getData($key)
    {
        return session($key);
    }

    public function getPaymentStatus()
    {
        return $this->getData('payment_status');
    }

    public function getPaidGateway()
    {
        return $this->getData('gateway');
    }

    public function getPaymentLog($code)
    {
        return PaymentLog::firstWhere('code', $code);
    }
}
