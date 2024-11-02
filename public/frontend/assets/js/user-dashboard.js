"use strict";

var preNumber = 0;

$(document).on("keydown", ".positive-float-number", function () {
    preNumber = $(this).val();
    if (preNumber == "") {
        preNumber = 0;
    }
})

$(document).on("keyup", ".positive-int-number", function () {
    var number = $(this).val();
    $(this).val(number.replace(/[^0-9]/g, ""));
});

$(document).on("keyup", ".positive-float-number", function () {
    var number = $(this).val();
    if (thousand_separator == '.') {
        if (number.split(",").length > 2 || number.split("-").length > 1) {
            $(this).val(preNumber).trigger("keyup");
        } else {
            $(this).val(number.replace(/[^0-9,]/g, ""));
        }
    } else {
        if (number.split(".").length > 2 || number.split("-").length > 1) {
            $(this).val(preNumber).trigger("keyup");
        } else {
            $(this).val(number.replace(/[^0-9.]/g, ""));
        }
    }
});

function decimalNumberFormatWithCurrency(number = 0) {
    var num = getDecimalNumberFormat(number);
    if (symbol_position == 'before') {
        return currencySymbol + num;
    } else {
        return num + currencySymbol;
    }
}

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
if (language_direction == 'rtl'){
    document.documentElement.dir = 'rtl';
}
