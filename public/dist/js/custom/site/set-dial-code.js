"use strict";

function setDialCode(parent, identifier) {
    if ($(identifier).length == 0) {
        return;
    }
    
    if ($(parent).find('.iti__flag-container').length == 0) {
        window.intlTelInput($(identifier).get(0), {
            utilsScript: utilJs,
            showSelectedDialCode: true,
        });
    
        $('.iti--allow-dropdown').addClass('w-full w-100')
        
        fixBdCode();
    }
    
    var dialCode = $(parent).find('.iti__selected-dial-code').text();
    
    if ($(parent).find('input[name="dial_code"]').length) {
        $(parent).find('input[name="dial_code"]').val(dialCode)
        return;
    }
    
    $(parent).append('<input type="hidden" name="dial_code" value="' + dialCode + '" />');
}

$(document).on('keyup', 'input[name="phone"]', function() {
    $(this).val($(this).val().replace(/\D/g, ''))
})

function fixBdCode() {
    var countryData = window.intlTelInputGlobals.getCountryData();
    for (var i = 0; i < countryData.length; i++) {
        var country = countryData[i];
        if (country.iso2 == 'bd') {
            country.dialCode = '88';
        }
    }
    
    $('#iti-0__item-bd').attr('data-dial-code', '88');
    $('#iti-0__item-bd .iti__dial-code').text('+88');
    
    if ($('.iti__selected-dial-code').text() == '+880') {
        $('.iti__selected-dial-code').text('+88')
    }
    
    setTimeout(() => {
        $('input[name="phone"]').each(function () {
            var currentValue = $(this).val();
            var sanitizedValue = currentValue.replace(/\D/g, '');
            $(this).val(sanitizedValue);
        });
    }, 1000);
}

function setupDialCode(containerId, inputName) {
    if ($(containerId).length) {
        setDialCode(containerId, `${containerId} input[name="${inputName}"]`);

        $(`${containerId} input[name="${inputName}"]`).on("countrychange", function (e, countryData) {
            setDialCode(containerId, `${containerId} input[name="${inputName}"]`);
        });
    }
}

setupDialCode('#edit_user_profile_form', 'phone');
setupDialCode('#userEdit', 'phone');
setupDialCode('#userAdd', 'phone');
setupDialCode('#vandorAdd', 'phone');
setupDialCode('#vandorEdit', 'phone');
