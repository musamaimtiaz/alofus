<?php

use Illuminate\Support\Facades\Log;
use Modules\Gateway\Entities\GatewayModule;

if (! function_exists('getPaymentGateways')) {
    /**
     * Returns the payment gateway modules
     *
     * @param  Countable  $addons
     * @return array
     */
    function getPaymentGateways($addons)
    {
        $gateways = [];
        foreach ($addons as $addon) {
            if ($addon->get('gateway')) {
                $gateways[] = $addon;
            }
        }

        return $gateways;
    }
}

if (! function_exists('moduleAvailable')) {
    /**
     * Check if the gateway module is active
     *
     * @param  string  $name
     * @return bool
     */
    function moduleAvailable($name)
    {
        try {
            return GatewayModule::findOrFail($name)->isEnabled();
        } catch (\Exception $e) {
            return false;
        }
    }
}

if (! function_exists('paymentLog')) {
    /**
     * Log in payment.log file
     *
     * @param  mixed  $e
     * @return void
     */
    function paymentLog($e)
    {
        if (is_array($e)) {
            $e = json_encode($e);
        }
        Log::channel('payment')->error($e);
    }
}

if (! function_exists('convert_currency')) {
    /**
     * Convert the currency
     */
    function convert_currency($from, $to, $amount)
    {
        return $amount;
    }
}

if (! function_exists('commaStringArray')) {
    /**
     * Convert comma string to array
     *
     * @param  string  $string
     * @param  bool  $keepSpace
     * @return array
     */
    function commaStringArray($string, $keepSpace = true)
    {
        if (! $keepSpace) {
            $string = str_replace(' ', '', $string);
        } else {
            $string = trim($string);
        }

        return array_map('trim', array_filter(explode(',', $string)));
    }
}

if (! function_exists('arrayCommaString')) {
    function arrayCommaString($array, $delimiter = ',')
    {
        return implode($delimiter, $array);
    }
}

if (! function_exists('getValueForForm')) {
    function getValueForForm($module, $name)
    {
        if (isset($module) && isset($module->$name)) {
            if (is_array($module->$name)) {
                return arrayCommaString($module->$name);
            } else {
                return $module->$name;
            }
        }

        return null;
    }
}

if (! function_exists('bdcrypt')) {
    /**
     * Base64 decode string
     *
     * @param  string  $string
     * @return string
     */
    function bdcrypt($string)
    {
        return base64_decode($string);
    }
}

if (! function_exists('bncrypt')) {
    /**
     * Base64 encode string
     *
     * @param  string  $string
     * @return string
     */
    function bncrypt($string)
    {
        return base64_encode($string);
    }
}

if (! function_exists('withOldQueryString')) {
    /**
     * Merge existing query string with the provided array
     *
     * @param  array  $params
     * @return array
     */
    function withOldQueryString($params = [])
    {
        return array_merge(request()->only(['to', 'payer', 'code']), $params);
    }
}

if (! function_exists('checkRequestIntegrity')) {
    /**
     * Checks if the required query strings has been modified or not
     *
     * @return bool
     */
    function checkRequestIntegrity()
    {
        return getIntegrityKey() == request()->integrity;
    }
}

if (! function_exists('getIntegrityKey')) {
    /**
     * Creates a new encrypted integrity key from original query strings
     *
     * @param  array  $override
     * @return string
     */
    function getIntegrityKey($override = [])
    {
        $query = array_merge(request()->only(['to', 'payer', 'code']), $override);
        $route = implode('', $query);

        return techEncrypt($route);
    }
}

if (! function_exists('withOldQueryIntegrity')) {
    /**
     * Merge existing query string with the provided array
     *
     * @param  array  $params
     * @return array
     */
    function withOldQueryIntegrity($params = [])
    {
        return array_merge(request()->only(['to', 'payer', 'code', 'integrity']), $params);
    }
}
