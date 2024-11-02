'use strict';

$('.conditional').ifs();
$("#v-pills-general-tab").trigger('click');

$(document).on('change', "input, select", function() {
    changeSetting(this);
});

$(document).on("click", '.tab-name', function () {
    var id = $(this).attr('data-id');
    $('#theme-title').html(id);
    $('.tab-pane[aria-labelledby="home-tab"').addClass('show active')
    $('#' + $(this).attr('id')).addClass('active').attr('aria-selected', true)
});

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
    $.each(data.responseJSON.errors, function(key, value) {
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

// Change switch with value
$(document).on('click', '.cr', function() {
    var value = $(this).closest('.switch').find('input').val();
    if (value == 1) {
        $(this).closest('.switch').find('input').val(0)
    } else {
        $(this).closest('.switch').find('input').val(1)
    }
})

const unblockEverything = () => {
    $(".blockUI").each(function () {
        $(this).parent().unblock();
    });
};

const blockElement = (element, _data = {}) => {
    let options = Object.assign(
        {},
        {
            message: `<div class="spinner-border tax-rate-loader text-warning" role="status"><span class="sr-only">Loading...</span></div>`,
            css: {
                backgroundColor: "transparent",
                border: "none",
            },
        },
        _data
    );
    element.block(options);
};

const triggerNotification = (msg) => {
    $(".notification-msg-bar").find(".notification-msg").html(msg);
    $(".notification-msg-bar").removeClass("smoothly-hide");
    setTimeout(() => {
        $(".notification-msg-bar").addClass("smoothly-hide"),
            $(".notification-msg-bar").find(".notification-msg").html("");
    }, 3000);
};

// Add new tax
$(document).on('click', '.add-btn', function() {
    var classId = $(this).attr('data-id');
    $('input[name="tax_class_id"]').val(classId);
    var randCompound = Math.floor(Math.random() * 100000);
    var randShipping = Math.floor(Math.random() * 100000);
    $('.add-new-data').find('input[name="compound"]').attr('id', 'switch-' + randCompound).closest('.switch').find('label').attr('for', 'switch-' + randCompound);
    $('.add-new-data').find('input[name="shipping"]').attr('id', 'switch-' + randShipping).closest('.switch').find('label').attr('for', 'switch-' + randShipping);
    var data = $('.add-new-data').html();
    var tr = $(this).closest('tr');
    $(tr).closest('tbody').find('td:contains("No tax rate found")').remove();
    tr.html(data);

    tr.closest('table tbody').append(`
        <tr>
            <td colspan="10" class="pt-3">
                <button type="button" data-id="${classId}" class="btn custom-btn-submit btn-sm add-btn">${jsLang('Add New')}</button>
                <button type="submit" data-id="${classId}" class="btn custom-btn-submit btn-sm update-btn">${jsLang('Save')}</button>
            </td>
        </tr>
    `);
})

// Update tax rate
$(document).on('click', '.update-btn', function() {
    var parent = $(this).closest('.parent');

    if (is_demo == 1) {
        triggerNotification(jsLang("Demo Mode! This action can't be perform."));
        return false;
    }

    blockElement(parent)

    var url = SITE_URL + '/tax-rate/update';
    var btn = this;

    $(this).text(jsLang('Saving')).append(`<div class="spinner-border spinner-border-sm ml-2" role="status"></div>`)

    var arr = new Array();
    $(this).closest('.tax-rate-data').find('tr').each((key, value) => {
        if ($(value).find('input, select').length > 10) {
            var obj = new Object();
            var sort_by = 0;
            $(value).find('input, select').each((k, v) => {
                obj[$(v).attr('name')] = $(v).val().trim() == '*' ? '' : $(v).val();

                if ($(v).val().trim() != '' && $(v).val().trim() != '*') {
                    if ($(v).attr('name') == 'country') {
                        sort_by += 8;
                    } else if ($(v).attr('name') == 'state') {
                        sort_by += 4;
                    } else if ($(v).attr('name') == 'city') {
                        sort_by += 2;
                    } else if ($(v).attr('name') == 'postcode') {
                        sort_by += 1;
                    }
                }
                obj['sort_by'] = sort_by;
            })
            obj.country = obj.country.toLowerCase()
            arr.push(obj);
        }
    });

    if (arr.length == 0) {
        arr.push({'tax_class_id': $(btn).attr('data-id')})
    }

    $.ajax({
        url: url,
        type: 'POST',
        data: {
            '_token': token,
            'data': arr
        },
        success: function (data) {
            $('#topNav-v-pills-tabContent').html(data);
            $('a[href="#v-pills-general"]').tab('show');
            $(`a[href="#${$(parent).attr('id')}"]`).tab('show');

            triggerNotification(jsLang('Tax rate has been successfully saved'));
        },
        error: function(data) {
            triggerNotification(jsLang('Something went wrong, please try again.'));
        },
        complete: function(data) {
            unblockEverything();
        }
    });

})

// Remove tax rate
$(document).on('click', '.action-btn', function() {
    changeSetting(this);
    $(this).closest('tr').remove();
})


// Store tax class
var taxClassStoreCount = 0;

$(document).on('submit', '#addTaxClass', function(e) {
    e.preventDefault();
    taxClassStoreCount++;
    if (taxClassStoreCount > 1) {
        return false;
    }

    var form = this;
    var parent = $('.tax-setting-parent');

    $.ajax({
        url: $(form).attr('action'),
        type: 'POST',
        data: $(form).serialize(),
        dataType: 'JSON',
        success: function (data) {
            if (data['status'] == 'success') {
                var tax_class_name = data.name;
                var tax_class_slug = data.slug;

                var classId = data.id;
                successNotification(parent, data.message);
                var classButton = `
                <div class="toast rounded-0 shadow-none text-dark border bg-light mb-2 tax-class w-100">
                    <div class="d-flex justify-content-between align-items-center p-2">
                        <div class="toast-body pe-3 font-bold ps-0 py-0 mr-4 font-weight-bold tax-class-name">
                            ${tax_class_name + ' ' + jsLang('Rates')}
                        </div>
                        <div>
                            <a href="javascript:void(0)"
                                data-bs-toggle="modal"
                                data-bs-target="#edit-tax-class"
                                data-id="${classId}"
                                data-name="${tax_class_name}"
                                data-slug="${tax_class_slug}"
                                class="text-dark edit-tax-class-btn">
                                <span title="${jsLang('Edit')}" class="fa fa-edit neg-transition-scale"> &nbsp;</span>
                            </a>
                            <form method="post" action="tax/delete/${classId}" id="delete-tax-${classId}" accept-charset="UTF-8" class="display_inline delete_tax_class">
                                <input type="hidden" name="_token" value="${token}">
                                <span class="text-dark cursor_pointer delete-button" data-bs-toggle="modal" data-label="Delete" data-delete="tax" data-bs-target="#confirmDelete"
                                    data-id="${classId}" title="${jsLang('Delete Tax')}" data-title="${jsLang('Delete Tax')}" data-message="${jsLang('Are you sure to delete this?')}">
                                    <i class="fa fa-trash"></i>
                                </span>
                            </form>
                        </div>

                    </div>
                </div>
                `;
                $('div.add-new-class').before(classButton);
                $('.nav-pills').append(`
                    <li><a class="nav-link text-left tab-name" id="v-pills-${tax_class_slug}-tab" data-bs-toggle="pill" href="#v-pills-${tax_class_slug}" role="tab" aria-controls="v-pills-standard" aria-selected="true" data-id ="${tax_class_name + ' ' + jsLang('Rates')}">${tax_class_name + ' ' + jsLang('Rates')}</a></li>
                `)

                $('.tax-content').append(`
                <div class="tab-pane fade parent mt-25 tax-rate-data" id="v-pills-${tax_class_slug}" role="tabpanel" aria-labelledby="v-pills-${tax_class_slug}-tab">
                    <div class="noti-alert pad no-print warningMessage mt-2 px-2">
                        <div class="alert warning-message abc">
                            <strong id="warning-msg" class="msg"></strong>
                        </div>
                    </div>
                    <div class="row px-4">
                        <div class="col-sm-12 p-0">
                            <div class="table-responsive">
                                <table class="table table-bordered table-hover">
                                    <thead>
                                        <tr>
                                            <th scope="col">${jsLang('Name')}</th>
                                            <th scope="col">${jsLang('Country')}</th>
                                            <th scope="col">${jsLang('State')}</th>
                                            <th scope="col">${jsLang('City')}</th>
                                            <th scope="col">${jsLang('Post code')}</th>
                                            <th width="100" scope="col">${jsLang('Rate')} %</th>
                                            <th width="100" scope="col">${jsLang('Priority')}</th>
                                            <th width="5" scope="col">${jsLang('Compound')}</th>
                                            <th width="5" scope="col">${jsLang('Shipping')}</th>
                                            <th width="5" scope="col">${jsLang('Action')}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td class="text-center" colspan="10">${jsLang('No tax rate found.')}</td>
                                        </tr>
                                        <tr>
                                            <td colspan="10" class="pt-3">
                                                <button type="button" data-id="${classId}" class="btn custom-btn-submit btn-sm add-btn">${jsLang('Add New')}</button>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                `)

                $('#shipping_tax_class').append(`
                    <option value="${tax_class_slug}">${tax_class_name}</option>
                `)

                $(form).trigger("reset")

            } else {
                failNotification(parent, data.message);
            }
            $(form).closest('.tax-class').remove();
        },
        error: function(data) {
            errorNotification(parent, data);
        },
        complete: function(data) {
            $('.modal').modal('hide')
            $('.spinner-border').remove();
            $('.tax-class-submit').text(jsLang('Save'))
            taxClassStoreCount = 0;
        }
    })

    timeoutNotification(parent);

})

// Edit tax class
$(document).on('click', '.edit-tax-class-btn', function() {
    $('#edit-tax-class').find('input[name="id"]').val($(this).attr('data-id'))
    $('#edit-tax-class').find('input[name="name"]').val($(this).attr('data-name'))
    $('#edit-tax-class').find('input[name="slug"]').val($(this).attr('data-slug'))
})
var editTaxClassBtn = '';
$(document).on('click', '.edit-tax-class-btn', function() {
    editTaxClassBtn = this;
})

// Update tax class
var taxClassUpdateCount = 0;
$(document).on('submit', '#edit-tax-form', function(e) {
    e.preventDefault();

    taxClassUpdateCount++;
    if (taxClassUpdateCount > 1) {
        return false;
    }

    var form = this;
    var parent = $('.tax-setting-parent');

    $.ajax({
        url: $(form).attr('action'),
        type: 'POST',
        data: $(form).serialize(),
        dataType: 'JSON',
        success: function (data) {
            if (data['status'] == 'success') {
                var tax_class_name = data.name;
                var tax_class_slug = data.slug;

                successNotification(parent, data.message);
                var taxName = tax_class_name + ' ' + jsLang('Rates');
                $(editTaxClassBtn).closest('.tax-class').find('.tax-class-name').text(taxName);

                var classTab = $(`#v-pills-${$(editTaxClassBtn).attr('data-slug')}-tab`);
                $('.nav-pills').append(`
                    <li><a class="nav-link text-left tab-name" id="v-pills-${tax_class_slug}-tab" data-bs-toggle="pill" href="#v-pills-${tax_class_slug}" role="tab" aria-controls="v-pills-standard" aria-selected="true" data-id ="${tax_class_name + ' ' + jsLang('Rates')}">${tax_class_name + ' ' + jsLang('Rates')}</a></li>
                `)

                $('#shipping_tax_class')
                    .find(`option[value="${$(editTaxClassBtn).attr('data-slug')}"]`)
                    .attr('value', tax_class_slug)
                    .text(tax_class_name)

                classTab.remove();
                var classRates = $(`#v-pills-${$(editTaxClassBtn).attr('data-slug')}`);
                classRates.attr('aria-labelledby', `v-pills-${tax_class_slug}-tab`);
                classRates.attr('id', `v-pills-${tax_class_slug}`);
                $(editTaxClassBtn).attr('data-name', tax_class_name).attr('data-slug', tax_class_slug)
            } else {
                failNotification(parent, data.message);
            }
        },
        error: function(data) {
            errorNotification(parent, data);
        },
        complete: function(data) {
            $('.modal').modal('hide')
            $('.spinner-border').remove();
            $('.tax-class-submit').text(jsLang('Save'))
            taxClassUpdateCount = 0;
        }
    })

    timeoutNotification(parent);
})

$(document).on('click', '#confirmDeleteSubmitBtn', function() {
    $(this).text(jsLang('Deleting')).append(`<div class="spinner-border spinner-border-sm ml-2" role="status"></div>`)
})

// Delete tax class
var taxDeleteCount = 0;
$(document).on('submit', '.delete_tax_class', function(e) {
    e.preventDefault();
    taxDeleteCount++;
    if (taxDeleteCount > 1) {
        return;
    }

    var parent = $(this).closest('.parent');
    var form = this;
    $.ajax({
        url: $(form).attr('action'),
        type: 'POST',
        data: {
            '_token': token,
        },
        dataType: 'JSON',
        success: function (data) {
            if (data['status'] == 'success') {
                successNotification(parent, data.message);
                $(parent).closest('tr').remove();
                var slug = $(form).closest('div').find('a').attr('data-slug');
                $(`#v-pills-${slug}-tab`).remove()
                $(`#v-pills-${slug}`).remove();
                $('#shipping_tax_class').find(`option[value="${slug}"]`).remove()
            } else {
                failNotification(parent, data.message);
            }
            $(form).closest('.tax-class').remove();
        },
        error: function(data) {
            errorNotification(parent, data);
        },
        complete: function(data) {
            $('.modal').modal('hide')
            taxDeleteCount = 0;
        }
    })

    timeoutNotification(parent);
})

// Update tax setting
var taxUpdateCount = 0;
$(document).on('click', '.tax-setting-btn', function() {
    taxUpdateCount++;
    if (taxUpdateCount > 1) {
        return;
    }
    var parentTr = $(this).closest('tr');
    var parent = $(this).closest('.parent')
    $(this).text(jsLang('Saving')).append(`<div class="spinner-border spinner-border-sm ml-2" role="status"></div>`).addClass('disabled-btn');
    $.ajax({
        url: SITE_URL + '/tax-setting/update',
        type: 'POST',
        data: $('.tax-setting').find('input, select').serialize(),
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
            $('.tax-class-submit').text(jsLang('Save')).removeClass('disabled-btn').find('.spinner-border').remove();
            taxUpdateCount = 0
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

    $('.tab-help').removeClass('active');
    $('.tab-pane').removeClass('show active')
    $(`.tab-pane[aria-labelledby="${$(this).attr('id')}"`).addClass('show active')
   $('.tab-pane[aria-labelledby="home-tab"').addClass('show active')
    $('.tab-help').css('color', '#6c757d');
    if ($(this).text() == 'Options') {
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
    $(this).css('color', '#fcca19');
    activeHelp = true;

})
if ($('.main-body .page-wrapper').find('#tax-container').length) {
    $('.tab-pane[aria-labelledby="v-pills-general-tab"').addClass(
        "show active")
}
