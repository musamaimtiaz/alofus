'use strict';
$(document).ready(function(){
    $('#success-message').css("display", "none");
    $('#warning-message').css("display", "none");
    $("#v-pills-general-tab").trigger("click");

    $("input").on('change', function() {
        $('.warning-message').addClass('alert-secondary');
        $('#warning-message').css("display", "block");
        $('#warning-msg').html(jsLang('Settings have changed, you should save them!'));
      });
});


// Change switch with value
$(document).on('click', '.cr', function() {
    var value = $(this).closest('.switch').find('input').val();
    if (value == 1) {
        $(this).closest('.switch').find('input').val(0)
    } else {
        $(this).closest('.switch').find('input').val(1)
    }
})

// Show title with data-id attr
$('.tab-name').on("click", function () {
    var id = $(this).attr('data-id');
    $('#theme-title').html(id);
});

$('#discount_amount').on('keyup change', function() {
    if ($(this).attr('placeholder') == jsLang('Discount Percentage') && $(this).val() > 100) {
        $(this).val(100);
    }
})

if ($('.main-body .page-wrapper').find('#coupon-add-container, #coupon-edit-container, #vendor-coupon-add-container, #vendor-coupon-edit-container, #coupon-list-container, #vendor-coupon-list-container').length) {
    $('.tab-pane[aria-labelledby="v-pills-general-tab"').addClass(
        "show active")
    $('#discount_type').on('change', function() {
        if ($(this).val() == 'Percentage') {
            $('.discount_amount_label').text(jsLang('Discount Percentage'))
            $('#discount_amount').attr("placeholder", jsLang('Discount Percentage'))
            $('#discount_amount').val() >= 100 ? $('#discount_amount').val(100) : '';
        } else {
            $('.discount_amount_label').text(jsLang('Discount Amount'))
            $('#discount_amount').attr("placeholder", jsLang('Discount Amount'))
        }
    })
}
// Coupon module
function discount() {
    if ($('select[name="discount_type"]').val() != "Percentage" ) {
        $('#max_discount').hide();
    } else {
        $('.discount_amount_label').text(jsLang('Discount Percentage'))
    }

    $('select[name="discount_type"]').on('change', function(e) {
        if (e.target.value == 'Percentage') {
            $('#max_discount').show();
        } else {
            $('#max_discount').hide();
        }
    })
}

function searchVendor() {
    $(".select-vendor").select2({
        ajax: {
            url: SITE_URL + '/find-vendors-with-ajax',
            dataType: "json",
            delay: 250,
            data: function (params) {
                return {
                    q: params.term, // search term
                    page: params.page,
                };
            },
            processResults: function (data, params) {
                let results = data.data;
                return {
                    results: results
                };
            },
            cache: true,
        },
        placeholder: jsLang("Search for vendor by name."),
        minimumInputLength: 3,
        allowClear: true,
    });
}

$(".select_affiliate_user").select2({
    ajax: {
        url: SITE_URL + '/affiliate/find-affiliate-user-in-ajax',
        dataType: "json",
        delay: 250,
        data: function (params) {
            return {
                q: params.term, // search term
                page: params.page,
            };
        },
        processResults: function (data, params) {
            let results = data.data;
            return {
                results: results
            };
        },
        cache: true,
    },
    placeholder: jsLang("Search for an affiliate users."),
    minimumInputLength: 3,
    allowClear: true,
});

function searchProducts() {
    $(".select-products").select2({
        ajax: {
            url: SITE_URL + '/find-products-in-ajax',
            dataType: "json",
            delay: 250,
            data: function (params) {
                return {
                    q: params.term, // search term
                    page: params.page,
                    vendor_id: $('#vendor_id').val(),
                };
            },
            processResults: function (data, params) {
                let results = data.data;
                return {
                    results: results
                };
            },
            cache: true,
        },
        placeholder: jsLang("Search for products by name."),
        minimumInputLength: 3,
    });
}

// If old item exist
function oldProduct() {
    if (!(Array.isArray(old_item) && old_item.length)) {
        return false;
    }

    $.ajax({
        url: oldProductUrl,
        type: 'GET',
        dataType: "json",
        data: {
            product_ids: old_item
        },
        success: function (data) {
            var option = '';
            const products = data.data;
            for (const key in products) {
                option += `<option selected value="${products[key].id}">${products[key].text}</option>`
            }

            $('.select-products').html(option);
        },
    });
}

// If old vendor exist
function oldVendor() {
    if (old_vendor == '') {
        return false;
    }

    $.ajax({
        url: SITE_URL + '/coupon/old-vendor',
        type: 'GET',
        dataType: "json",
        data: {
            vendor_id: old_vendor
        },
        success: function (data) {
            $('.select-vendor').html(`<option selected value="${data.id}">${data.text}</option>`);
        },
    });
}

$('#vendor_id').on('change', function() {
    $('#product_id').empty();
})

// Coupon add section (Admin panel)
if ($('.main-body .page-wrapper').find('#coupon-add-container').length) {
    $('input[name="start_date"]').daterangepicker(dateSingleConfig());
    $('input[name="end_date"]').daterangepicker(dateSingleConfig());
}

// Coupon edit section (Admin panel)
if ($('.main-body .page-wrapper').find('#coupon-edit-container').length) {
    $('input[name="start_date"]').daterangepicker(dateSingleConfig($('input[name="start_date"]').val()));
    $('input[name="end_date"]').daterangepicker(dateSingleConfig($('input[name="end_date"]').val()));

}

// Coupon add and edit section (Admin panel)
if ($('.main-body .page-wrapper').find('#coupon-add-container, #coupon-edit-container').length) {
    discount();
    searchVendor();
    searchProducts()
    oldProduct()
    oldVendor()
}
// Coupon add and edit section (Vendor panel)
if ($('.main-body .page-wrapper').find('#vendor-coupon-add-container, #vendor-coupon-edit-container').length) {
    discount();
    oldProduct();
    searchProducts()
}

if ($('.main-body .page-wrapper').find('#vendor-coupon-add-container').length) {
    $('input[name="start_date"]').daterangepicker(dateSingleConfig());
    $('input[name="end_date"]').daterangepicker(dateSingleConfig());
}

if ($('.main-body .page-wrapper').find('#vendor-coupon-edit-container').length) {
    $('input[name="start_date"]').daterangepicker(dateSingleConfig($('input[name="start_date"]').val()));
    $('input[name="end_date"]').daterangepicker(dateSingleConfig($('input[name="end_date"]').val()));
}

if ($('.main-body .page-wrapper').find('#coupon-list-container').length) {
    // For export csv and pdf
    $(document).on("click", "#csv, #pdf", function(event) {
        event.preventDefault();
        window.location = SITE_URL + "/coupon/" + this.id;
    });
}

if ($('.main-body .page-wrapper').find('#coupon-redeem-list-container').length) {
    // For export csv and pdf
    $(document).on("click", "#csv, #pdf", function(event) {
        event.preventDefault();
        window.location = SITE_URL + "/coupon-redeem/" + this.id;
    });
}

if ($('.main-body .page-wrapper').find('#vendor-coupon-list-container').length) {
    // For export csv and pdf
    $(document).on("click", "#csv, #pdf", function(event) {
        event.preventDefault();
        window.location = SITE_URL + "/coupon/" + this.id;
    });
}

$('.coupon-submit-button').on('click', function (e) {
    var arr = ['#v-pills-general', '#v-pills-restriction', '#v-pills-limit']
    setTimeout(() => {
        for (const key in arr) {
            if($(arr[key]).find('.error').length) {
                var target = $(arr[key]).attr('aria-labelledby');
                $('#' + target).tab('show');
                tabTitle(target);
                break;
            }
        }
    }, 100);
});
function tabTitle(id){
    var title = $('#'+ id).attr('data-id');
    $('#theme-title').html(title);
}
$('button.switch-tab').on('click', function() {
    $('#' + $(this).attr('data-id')).tab('show');
    var titleName = $(this).attr('data-id');
    tabTitle(titleName);
    $('.tab-pane[aria-labelledby="home-tab"').addClass('show active')
    $('#' + $(this).attr('id')).addClass('active').attr('aria-selected', true)
})
