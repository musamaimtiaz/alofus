"use strict";

function getDecimalNumberFormat(num = 0)
{
    if (thousand_separator != null && decimal_digits != null && num != null) {
        var numArray = num.toString().split('.');
        if (numArray.length > 1) {
            num = numArray[0] + '.' + numArray[1].substring(0, decimal_digits);
        }
        num = parseFloat(num).toFixed(decimal_digits);
        if (thousand_separator == '.') {
            num = numberWithDot(num);
        } else if (thousand_separator == ',') {
            num = numberWithCommas(num);
        }
    }
    return num;
}

function numberWithCommas(x)
{
    var parts = x.toString().split(".");
    parts[0] = parts[0].replace(/\B(?=(\d{3})+(?!\d))/g, ",");
    return parts.join(".");
}

function decimalNumberFormatWithCurrency(number = 0) {
    var num = getDecimalNumberFormat(number);
    if (symbol_position == 'before') {
        return currencySymbol + num;
    } else {
        return num + currencySymbol;
    }
}

function numberWithDot(x)
{
    var parts = x.toString().split(".");
    parts[0] = parts[0].replace(/\B(?=(\d{3})+(?!\d))/g, ".");
    return parts.join(",");
}
