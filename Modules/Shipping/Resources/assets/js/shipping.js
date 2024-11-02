'use strict';

$('.conditional').ifs();
$("#v-pills-general-tab").trigger('click');

$(document).on("click", '.tab-name', function () {
    var id = $(this).attr('data-id');
    $('#theme-title').html(id);
    $('.tab-pane[aria-labelledby="home-tab"').addClass('show active')
    $('#' + $(this).attr('id')).addClass('active').attr('aria-selected', true)
});

$(document).on('keyup', '.float-validation', function() {
    var number = $(this).val();
    if (number == '') {
        return;
    }

    var split = number.split('.');
    var first = split[0] ?? 0;
    var second = split[1] ?? 0;
    if (split[0].length > 8) {
        first = split[0].substring(0, 8);
    }
    if (split.length > 1 && split[1].length > 8) {
        second = split[1].substring(0, 8);
    }

    if (split.length > 1) {
        $(this).val(first + '.' + second);
    } else {
        $(this).val(first);
    }
})

// Change switch with value
$(document).on('click', '.cr', function() {
    var value = $(this).closest('.switch').find('input').val();
    if (value == 1) {
        $(this).closest('.switch').find('input').val(0)
    } else {
        $(this).closest('.switch').find('input').val(1)
    }
})

$(document).on('click', 'label.free_shipping_checkbox', function() {
    if ($(this).siblings('input').attr('checked') == 'checked') {
        $(this).siblings('input').val(0).attr('checked', false)
    } else {
        $(this).siblings('input').val(1).attr('checked', 'checked');
    }
})
$('select[name="free_shipping_requirement"]').each((k, v) => {
    freeShippingRequirement($(v));
})

$(document).on('change', 'select[name="free_shipping_requirement"]', function() {
    freeShippingRequirement(this);
})

function freeShippingRequirement(parent) {
    if ($(parent).val() != '' && $(parent).val() != 'coupon') {
        $(parent).closest('.form-group').siblings('.free_shipping_condition').removeClass('d-none');
    } else {
        $(parent).closest('.form-group').siblings('.free_shipping_condition').addClass('d-none');
    }
}

function changeSetting(parent) {
    $(parent).closest('.parent').find('.warning-message').addClass('alert-secondary');
    $(parent).closest('.parent').find('.warningMessage').slideDown(300);
    $(parent).closest('.parent').find('#warning-msg').html(jsLang('Settings have changed, you should save them!'));
}

function successNotification(parent, message) {
    parent.find('.abc').addClass('alert-success');
    parent.find('.warningMessage').slideDown();
    parent.find('.msg').html(message);
}

function failNotification(parent, message) {
    parent.find('.abc').addClass('alert-danger');
    parent.find('.warningMessage').slideDown();
    parent.find('.msg').html(message);
}

function errorNotification(parent, data) {
    parent.find('.abc').addClass('alert-danger');
    parent.find('.warningMessage').slideDown();
    $.each(data.responseJSON.errors, function(key,value) {
        parent.find('.msg').html(value);
    });
}

function timeoutNotification(parent) {
    setTimeout(() => {
        parent.closest('.parent').find('.warningMessage').slideUp(500),
         setTimeout(() => {
            parent.closest('.parent').find('.abc').removeClass('alert-success alert-danger')
         }, 501);
    }, 5000);
}

// Show message when you have change a field
$(document).on('change', "input, select", function() {
    changeSetting(this);
});

// Remove location
$(document).on('click', '.action-btn', function() {
    changeSetting(this);
    $(this).closest('tr').remove();
})

$(document).on('click', '.add-new-location', function() {
    $(this).closest('tr').before($('.add-new-location-data tbody').html());
    $(this).closest('tbody').find("tr td:contains('No location found.')").closest('tr').remove();
})

$(document).on('click', '.add-new-class', function() {
    $(this).closest('tr').before($('.add-new-class-data tbody').html());
    $(this).closest('tbody').find('td:contains("No shipping class found.")').closest('tr').remove();
})

// Remove shipping zone
$(document).on('click', '.delete-button', function () {
    $(this).closest('.accordion').remove();
})

var shippingZoneSaveCount = 0;
function saveShippingZone(main) {
    shippingZoneSaveCount++;
    if (shippingZoneSaveCount > 1) {
        return false;
    }

    var parent = $(main).closest('.parent');
    var arr = new Array();
    var btn = main;

    $(main).text(jsLang('Saving')).append(`<div class="spinner-border spinner-border-sm ml-2" role="status">`)

    $(main).closest('.accordion-parent').find('.accordion').each((k, value) => {
        var obj = new Object();
        $(value).find('select, input').each((k, v) => {
            var name = $(v).attr('name')
            if (name != 'country' && name != 'city' && name != 'state' && name != 'zip') {
                obj[$(v).attr('name')] = $(v).val();
            }
        })
        var location = new Array();
        $(value).find('table tr').each((k, tr) => {
            var locationObj = new Object();
            $(tr).find('input').each((k, location) => {
                locationObj[$(location).attr('name')] = $(location).val();
            })

            if (Object.keys(locationObj).length > 0) {
                location.push(locationObj);
            }

        })
        obj['location'] = location;

        var classes = new Array();
        $(value).find('.shipping_classes .class').each((k, shipping_class) => {
            var classesObj = new Object();
            $(shipping_class).find('select, input').each((k, classes) => {
                classesObj[$(classes).attr('name')] = $(classes).val();
            })

            if (Object.keys(classesObj).length > 0) {
                classes.push(classesObj);
            }
        })
        obj['classes'] = classes;
        arr.push(obj);
    })

    $.ajax({
        url: SITE_URL + '/shipping-zone/store',
        type: 'POST',
        data: {
            '_token': token,
            'data': JSON.stringify(arr)
        },
        dataType: 'JSON',
        success: function (data) {
            if (data['status'] == 'success') {
                successNotification(parent, data.message);
                $('.save-shipping-zone').trigger('click');
                if ($(btn).closest('.accordion-parent').find('.accordion').length) {
                    $(btn).closest('div').siblings('.no_shipping_zone').remove();
                } else {
                    $(btn).closest('div').before(`
                        <div class="border p-2 no_shipping_zone">
                            <h4 class="text-center">${jsLang('No shipping zone found.')}</h4>
                        </div>
                    `);
                }

            } else {
                failNotification(parent, data.message);
            }
        },
        error: function(data) {
            errorNotification(parent, data);
        },
        complete: function(data) {
            $(btn).text(jsLang('Save')).find('.spinner-border').remove();
            shippingZoneSaveCount = 0;
        }
    });
    timeoutNotification(parent);
}
// shipping method
$(document).on('click', '.nav-list-button', function() {

	var tabID = $(this).attr('data-tab');

	$(this).addClass('active').siblings().removeClass('active');

	$('#tab-'+tabID).addClass('active').siblings().removeClass('active');
});

// Add shipping zone
$(document).on('click', '.add-shipping-zone', function() {

    $(this).closest('div').siblings('.no_shipping_zone').remove();
    var variable = ['main', 'location', 'method', 'flat', 'local', 'free'];
    var rand = {};
    for (const key in variable) {
        rand[variable[key]] = Math.floor(Math.random() * 10000000);
    }

    var data = `
    <div id="content-${rand.main}">
        ${$('.new-zone-content').html()}
    </div>
`;
$(this).closest('div').before(data);
$('#content-' + rand.main).find('input[name="id"]').val(rand.main);
$('#content-' + rand.main).find('.location-btn').attr('data-bs-target', '#flush-collapse-' + rand.location).closest('.accordion').attr('id', 'accordionFlush-' + rand.main).find('#flush-collapseTwo').attr({'id': 'flush-collapse-' + rand.location, 'data-bs-parent': '#accordionFlush-' + rand.main});
$('#content-' + rand.main).find('.method-btn').attr('data-bs-target', '#flush-collapse-' + rand.method).closest('.accordion').find('#flush-collapseOne').attr({'id': 'flush-collapse-' + rand.method, 'data-bs-parent': '#accordionFlush-' + rand.main});
$('#content-' + rand.main).find('.methods .free-shipping').attr({'href': '#free_shipping-' + rand.free, 'aria-controls': 'free_shipping-' + rand.free}).closest('div').find('#free_shipping').attr('id', 'free_shipping-' + rand.free);
$('#content-' + rand.main).find('.methods .local-pickup').attr({'href': '#local_pickup-' + rand.local, 'aria-controls': 'local_pickup-' + rand.local}).closest('div').find('#local_pickup').attr('id', 'local_pickup-' + rand.local);
$('#content-' + rand.main).find('.methods .flat-rate').attr({'href': '#flat_rate-' + rand.flat, 'aria-controls': 'flat_rate-' + rand.flat}).closest('div').find('#flat_rate').attr('id', 'flat_rate-' + rand.flat);
$('#content-' + rand.main).find('#flat_rate_status').attr('id', 'flat_rate_status-' + rand.main).siblings('label').attr('for', 'flat_rate_status-' + rand.main);
$('#content-' + rand.main).find('#local_pickup_status').attr('id', 'local_pickup_status-' + rand.main).siblings('label').attr('for', 'local_pickup_status-' + rand.main);
$('#content-' + rand.main).find('#free_shipping_status').attr('id', 'free_shipping_status-' + rand.main).siblings('label').attr('for', 'free_shipping_status-' + rand.main);
})

// Save shipping zone

$(document).on('click', '.save-shipping-zone', function() {
    saveShippingZone(this);
})

// Save shipping class
var shippingClassClickCount = 0;
$(document).on('click', '.save-class', function() {
    shippingClassClickCount++;
    if (shippingClassClickCount > 1) {
        return false;
    }

    var parent = $(this).closest('.parent');
    var tr = $(this).closest('tr');
    var url = SITE_URL + '/shipping-class/store';
    var btn = this;
    var arr = new Array();

    $(this).text(jsLang('Saving')).append(`<div class="spinner-border spinner-border-sm ml-2" role="status">`)
    $(this).closest('tbody').find('tr').each((key, value) => {
        if ($(value).find('input, select').length > 2) {
            var obj = new Object();
            $(value).find('input, select').each((k, v) => {
                obj[$(v).attr('name')] = filterXSS($(v).val());
            })
            arr.push(obj);
        }
    });

    $.ajax({
        url: url,
        type: 'POST',
        data: {
            '_token': token,
            'data': arr
        },
        dataType: 'JSON',
        success: function (data) {
            if (data['status'] == 'success') {
                successNotification(parent, data.message);

                $(btn).closest('tbody').find('td:contains("No shipping class found.")').closest('tr').remove();
                if ($(btn).closest('tbody').find('tr').length <= 2) {
                    $(btn).closest('tr').before(`
                        <tr>
                            <td class="text-center" colspan="5">${jsLang('No shipping class found.')}</td>
                        </tr>
                    `)
                }

                var zoneClassList = new Array();
                $('.shipping_classes:first').find('input, select').each((k, v) => {
                    if ($(v).attr('name') == 'slug') {
                        zoneClassList.push($(v).val());
                    }
                })
                // Add new class in flat rate if not exist when main class saved
                var mainClassList = new Array();
                for (const key in arr) {
                    mainClassList.push(arr[key].slug);
                    if (!zoneClassList.includes(arr[key].slug) && arr[key].slug != '') {
                        if ($('.flat_rate_status').siblings('.shipping_classes').length == 0) {
                            $('.flat_rate_status').after(`
                                <div class="shipping_classes">
                                    <div class="row bg-light-gray py-3 mt-14 mb-4 class_description">
                                        <div class="col-12">
                                            <h5 class="d-block">${jsLang('Shipping class costs')}</h5>
                                            <p class="text-dark m-0">${jsLang('These costs can optionally be added based on the product shipping class.')}</p>
                                        </div>
                                    </div>
                                    <div class="form-group row class">
                                        <label for="" class="col-3 control-label">${jsLang('No class shipping cost')}</label>
                                        <div class="col-4">
                                            <div class="input-group flex-wrap h-44p">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text rounded-0 border-radius h-44p">${currencySymbol}</span>
                                                </div>
                                                <input type="hidden" name="slug" value="no-class">
                                                <input type="text" class="form-control positive-float-number float-validation" name="cost" placeholder="N/A" value="">
                                            </div>
                                        </div>
                                        <div class="col-4">
                                            <select class="select form-control" name="cost_type">
                                                <option value="cost_per_order">${jsLang('Cost per order')}</option>
                                                <option value="cost_per_quantity">${jsLang('Cost per quantity')}</option>
                                                <option value="percent_sub_total_item_price">${jsLang('Percent sub total of product price')}</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group row flat_rate_calculation_type">
                                    <label for="" class="col-3 control-label">${jsLang('Calculation Type')}</label>
                                    <div class="col-4">
                                        <select class="form-control" name="flat_rate_calculation_type">
                                            <option value="class">${jsLang('Per class: Charge shipping for each shipping class individually')}</option>
                                            <option value="order">${jsLang('Per order: Charge shipping for the most expensive shipping class')}</option>
                                        </select>
                                    </div>
                                </div>
                            `);
                        }

                        $('.class_description').after(`
                        <div class="form-group row class">
                            <label for="" class="col-3 control-label text-left">${(arr[key].name == '' ? arr[key].slug : arr[key].name) + ' ' + jsLang('Class shipping cost')}</label>
                            <div class="col-4">
                                <div class="input-group flex-wrap h-44p">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text rounded-0 border-radius h-44p">${currencySymbol}</span>
                                    </div>
                                    <input type="hidden" name="slug" value="${arr[key].slug}">
                                    <input type="text" class="form-control" name="cost" placeholder="N/A" value="">
                                </div>
                            </div>
                            <div class="col-4">
                                <select class="select form-control" name="cost_type">
                                    <option value="cost_per_order">${jsLang('Cost per order')}</option>
                                    <option value="cost_per_quantity">${jsLang('Cost per quantity')}</option>
                                    <option value="percent_sub_total_item_price">${jsLang('Percent sub total of product price')}</option>
                                </select>
                            </div>
                        </div>
                        `);
                    }
                }

                // Remove class if it is not exist in main class when main class save.
                for (const key in zoneClassList) {
                    if (arr.length < 2) {
                        $('.shipping_classes').remove();
                        $('.flat_rate_calculation_type').remove();
                    }
                    if (!mainClassList.includes(zoneClassList[key])) {
                        $(`input[value="${zoneClassList[key]}"`).closest('.class').remove();
                    }
                }

                saveShippingZone($('.save-shipping-zone'));

            } else {
                failNotification(parent, data.message);
            }
        },
        error: function(data) {
            errorNotification(parent, data);
        },
        complete: function(data) {
            $(btn).text(jsLang('Save')).find('.spinner-border').remove();
            shippingClassClickCount = 0;
        }
    });
    timeoutNotification(tr);
})

// Update shipping setting
var shippingSettingCount = 0;
$(document).on('click', '.shipping-setting-btn', function() {
    shippingSettingCount++;
    if (shippingSettingCount > 1) {
        return;
    }
    $(this).text(jsLang('Saving')).append(`<div class="spinner-border spinner-border-sm ml-2" role="status">`)
    var parentTr = $(this).closest('tr');
    var parent = $(this).closest('.parent')
    $.ajax({
        url: SITE_URL + '/shipping-setting/store',
        type: 'POST',
        data: $('.shipping-setting').find('input, select').serialize(),
        dataType: 'JSON',
        success: function(data) {
            if (data['status'] == 'success') {
                successNotification(parent, data.message);
                parentTr.remove();
            } else {
                failNotification(parent, data.message);
            }
        },
        error: function(data) {
            errorNotification(parent, data);
        },
        complete: function() {
            $('.shipping-setting-btn').text(jsLang('Save')).find('.spinner-border').remove();
            shippingSettingCount = 0
        }
    })

    timeoutNotification(parent);
})

var currentTab = 'v-pills-general-tab';
var activeHelp = false;
// Help Icon
$(document).on('click', '.tab-name', function() {
    if ($(this).attr('id') != 'v-pills-help-tab') {
        currentTab = $(this).attr('id');
        activeHelp = false;
    }
    $('.tab-pane').removeClass('show active')
    $(`.tab-pane[aria-labelledby="${$(this).attr('id')}"`).addClass('show active')
    $('.tab-pane[aria-labelledby="home-tab"').addClass('show active')

    $('.tab-help').css('color', '#6c757d');
    if ($(this).text() == 'Tax Option') {
        $('.tab-help').hide();
    } else {
        $('.tab-help').show();
    }

})


// Help text
$(document).on('click', '.tab-name.tab-help', function() {
    if (activeHelp) {
        $('#' + currentTab).trigger('click');
        return false;
    }

    $('.tab-name').removeClass('active');
    $(this).addClass('active')
    $(`.tab-pane[aria-labelledby="${$(this).attr('id')}"`).addClass('show active')
    $(this).css('color', '#fcca19');
    activeHelp = true;
})
// add new shipping methods
$(document).on('click', '.nav-list-buttons', function(){

	var tabID = $(this).attr('data-tab');

	$(this).addClass('active').siblings().removeClass('active');

	$('#tab-'+tabID).addClass('active').siblings().removeClass('active');
});
