'use strict';

var obj = {
    'coupons': ['calculate_coupon'],
    'reviews_enable_product_review': ['reviews_verified_owner_label', 'review_left', 'rating_enable'],
    'rating_enable': ['rating_required'],
    'manage_stock': ['out_of_stock_visibility', 'stock_threshold', 'notification_out_of_stock', 'notification_low_stock', 'hold_stock'],
    'is_active': ['is_category_based', 'amount'],
    'vendor_category' : ['system_suggestion', 'vendor_cat_commission']
}

function checkDependency() {
    for (const main_element in obj) {
        if ($('#' + main_element).attr('checked')) {
            for (const sub_element in obj[main_element]) {
                $('#' + obj[main_element][sub_element]).closest('.dependency').slideDown(400);
            }
        } else {
            for (const sub_element in obj[main_element]) {
                $('#' + obj[main_element][sub_element]).closest('.dependency').slideUp(400);
            }
        }
    }
}

checkDependency();

$('.checkActivity').on('change', function() {
    if ($(this).attr('checked')) {
        $(this).removeAttr('checked')
    } else {
        $(this).attr('checked', true);
    }
    checkDependency();
});


$('.conditional').ifs();
$('.warningMessage').css("display", "none");
$("#v-pills-general-tab").trigger('click');

$("input").on('change', function() {
    $(this).closest('.parent').find('.warning-message').addClass('alert-secondary');
    $(this).closest('.parent').find('.warningMessage').slideDown(300);
    $(this).closest('.parent').find('#warning-msg').html(jsLang('Settings have changed, you should save them!'));
});

$('.tab-name').on("click", function () {
    var id = $(this).attr('data-id');
    $('#theme-title').html(id);
});

$(".product_setting_form").on('submit', function(event) {
    event.preventDefault();

    $(this).find('button.save-button').attr('type', 'submit').addClass('cursor_not_allowed').find('.product-spinner').removeClass('d-none');
    var url = $(this).attr('action');
    var parent = this;

    $.ajax({
        url: url,
        type: 'POST',
        data: $(this).serialize(),
        success: function (data) {
            if (data['status'] == 'success') {
                $(parent).closest('.parent').find('.abc').addClass('alert-success');
                $(parent).closest('.parent').find('.warningMessage').css("display", "block");
                $(parent).closest('.parent').find('.msg').html(data.message);
            } else {
                $(parent).closest('.parent').find('.abc').addClass('alert-danger');
                $(parent).closest('.parent').find('.warningMessage').css("display", "block");
                $(parent).closest('.parent').find('.msg').html(data.message);
            }
            $(parent).find('button.save-button').attr('type', 'submit').removeClass('cursor_not_allowed').find('.product-spinner').addClass('d-none');
        },
        error: function(data) {
            $(parent).find('button.save-button').attr('type', 'submit').removeClass('cursor_not_allowed').find('.product-spinner').addClass('d-none');
        }
    });

    setTimeout(() => {
         $(parent).closest('.parent').find('.warningMessage').slideUp(500),
         setTimeout(() => {
            $(parent).closest('.parent').find('.abc').removeClass('alert-success'),
            $(parent).closest('.parent').find('.abc').removeClass('alert-danger')
         }, 501);
    }, 5000);

});

var currentUrl = window.location.href;
var splitUrl = currentUrl.split('#');
var fragment = splitUrl[splitUrl.length -1];

var fragmentValue = {
    'vendor': 'v-pills-vendor-tab',
    'inventory': 'v-pills-inventory-tab',
    'general': 'v-pills-general-tab'
}

for (const key in fragmentValue) {
    if (key == fragment) {
        $('#' + fragmentValue[key]).trigger('click');
        break;
    }
}

$("#rating_enable").on('click', function () {
    $("#rating_required").prop("checked", $(this).is(":checked"));
});

