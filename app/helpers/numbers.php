<?php

use App\Models\Currency;

if (! function_exists('formatCurrencyAmount')) {
    function formatCurrencyAmount($value)
    {
        if (is_string($value)) {
            $value = (float) $value;
        }

        if (! is_int($value)) {
            $array = explode('.', $value);
            $value = substr($value, 0, (strlen($array[0]) + 1 + preference('decimal_digits')));
        }

        $decimal_digits = preference('decimal_digits');
        if (preference('hide_decimal') == 1 && count(explode('.', $value)) == 1) {
            $decimal_digits = 0;
        }

        if (preference('thousand_separator') == '.') {
            return number_format((float) $value, $decimal_digits, ',', '.');
        }

        return number_format((float) $value, $decimal_digits, '.', ',');
    }
}

if (! function_exists('formatNumber')) {
    function formatNumber($value, $symbol = null)
    {
        $amount = formatCurrencyAmount($value);
        if (empty($symbol)) {
            $symbol = Currency::getAll()->where('id', preference('dflt_currency_id'))->first()->symbol;
        }
        if (preference('symbol_position') == 'before') {
            return $symbol . $amount;
        }

        return $amount . $symbol;
    }
}

if (! function_exists('validateNumbers')) {
    function validateNumbers($number)
    {
        if (preference('thousand_separator') == '.') {
            $number = str_replace('.', '', $number);
        } else {
            $number = str_replace(',', '', $number);
        }
        $number = floatval(str_replace(',', '.', $number));

        return $number;
    }
}

if (! function_exists('formatDecimal')) {
    function formatDecimal($value)
    {
        $decimal_digits = preference('decimal_digits');
        if (preference('hide_decimal') == 1 && count(explode('.', $value)) == 1) {
            $decimal_digits = 0;
        }

        return round($value, $decimal_digits);
    }
}
