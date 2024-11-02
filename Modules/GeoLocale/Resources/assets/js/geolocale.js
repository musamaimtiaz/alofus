'use strict';
$('.search-table').on('keyup', function() {
    var input, filter, table, tr, td, i, txtValue;
    input = $(this).val();
    filter = input.toUpperCase();
    table = $(this).closest('.table-auto');
    tr = $(this).closest('.table-auto').find("tbody tr");
    for (i = 0; i < tr.length; i++) {
        td = tr[i].querySelector(".search");
        if (td) {
            txtValue = td.textContent || td.innerText;
            if (txtValue.toUpperCase().indexOf(filter) > -1) {
                tr[i].style.display = "";
            } else {
                tr[i].style.display = "none";
            }
        }
    }
})
// Get country list
$('.countries-tb').html(`
    <ul class="addon-form-loading pt-160">
        <div id="addon-res-loader">
            <svg class="" id="loading-spinner" width="80" height="80" viewBox="0 0 80 80" fill="none" xmlns="http://www.w3.org/2000/svg">
                <circle id="loading-circle-large" cx="40" cy="40" r="36" stroke="#FCCA19" stroke-width="8"></circle>
            </svg>
        </div>
    </ul>
`);
$.ajax({
    url: SITE_URL + "/countries",
    type: 'GET',
    dataType: 'JSON',
    success: function (data) {
        var content = '';

        for (const key in data) {
            content += `
                <tr>
                    <td class="search py-2 px-3 d-flex justify-content-between">
                        <div>
                            <span class="text-dark font-weight-bold">${data[key].name} <small class="text-uppercase">(${data[key].code})</small></span>
                        </div>
                        <div class="action-button">
                            <form method="post" action="country/delete/${data[key].id}" id="delete-country-${data[key].id}" accept-charset="UTF-8" class="display_inline">
                                    <input type="hidden" name="_token" value="${token}">
                                    <span title="${jsLang('Delete')}"
                                        data-id="${data[key].id}"
                                        data-label="Delete" data-delete="country"
                                        data-bs-toggle="modal"
                                        data-bs-target="#confirmDelete"
                                        data-title="${jsLang('Delete Country')}"
                                        data-message="${jsLang('Are you sure to delete this?')}">
                                        <i class="fa fa-trash delete"></i>
                                    </span>
                                </form>
                                <span title="${jsLang('Edit')}"
                                    class="edit-country"
                                    data-id="${data[key].id}"
                                    data-name="${!data[key].name ? '' : data[key].name}"
                                    data-fullName="${!data[key].full_name ? '' : data[key].full_name}"
                                    data-capital="${!data[key].capital ? '' : data[key].capital}"
                                    data-code="${!data[key].code ? '' : data[key].code}"
                                    data-codeAlpha3="${!data[key].code_alpha3 ? '' : data[key].code_alpha3}"
                                    data-codeNumeric="${!data[key].code_numeric ? '' : data[key].code_numeric}"
                                    data-emoji="${!data[key].emoji ? '' : data[key].emoji}"
                                    data-currencyCode="${!data[key].currency_code ? '' : data[key].currency_code}"
                                    data-currencyName="${!data[key].currency_name ? '' : data[key].currency_name}"
                                    data-currencySymbol="${!data[key].currency_symbol ? '' : data[key].currency_symbol}"
                                    data-tld="${!data[key].tld ? '' : data[key].tld}"
                                    data-callingCode="${!data[key].callingcode ? '' : data[key].callingcode}"
                                    data-bs-toggle="modal"
                                    data-bs-target="#edit-country">
                                    <i class="fa fa-edit edit neg-transition-scale"></i>
                                </span>
                            <span class="find-state cursor_pointer" data-countryId data-code="${data[key].id}">
                                <svg viewBox="0 0 20 20" fill="currentColor" class="arrow-circle-right neg-transition-scale">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-8.707l-3-3a1 1 0 00-1.414 1.414L10.586 9H7a1 1 0 100 2h3.586l-1.293 1.293a1 1 0 101.414 1.414l3-3a1 1 0 000-1.414z" clip-rule="evenodd"></path>
                                </svg>
                            </span>
                        </div>
                    </td>
                </tr>
            `;
        }
        $('.countries-tb').html(content);
    }
})

// Get states via country code
var country_code = null;
$(document).on('click', '.find-state', function() {
    $('.add-city').css('display', 'none');
    $('.add-state').css('display', 'inline');
    $('.action-button').hide();
    $(this).closest('tbody').find('tr').css('background', 'unset');
    $(this).closest('tr').css('background', '#ddd');

    country_code = $(this).attr('data-code');
    $('#add-state input[name="country_id"]').val(country_code);
    $('.states-tb').html(`
        <ul class="addon-form-loading pt-160">
            <div id="addon-res-loader">
                <svg class="" id="loading-spinner" width="80" height="80" viewBox="0 0 80 80" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <circle id="loading-circle-large" cx="40" cy="40" r="36" stroke="#FCCA19" stroke-width="8"></circle>
                </svg>
            </div>
        </ul>
    `);
    $('.cities-tb').html(`
        <tr>
            <td class="search py-2 px-3 d-flex justify-content-between">
                <div>
                    <span class="text-dark font-weight-bold">${jsLang('Select a state')}</span>
                </div>
            </td>
        </tr>
    `)

    $.ajax({
        url: SITE_URL + "/countries/" + country_code + "/states",
        type: 'GET',
        dataType: 'JSON',
        success: function (data) {
            $('.action-button').show();
            $('.cities-tb').html(`
                <tr>
                    <td class="search py-2 px-3 d-flex justify-content-between">
                        <div>
                            <span class="text-dark font-weight-bold">${jsLang('Select a state')}</span>
                        </div>
                    </td>
                </tr>
            `);

            var state = '';

            if (data.data.length === 0) {
                state += `
                    <tr>
                        <td class="search py-2 px-3 d-flex justify-content-between">
                            <div>
                                <span class="font-weight-bold text-warning">${jsLang('The country has no state. Select different one.')}</span>
                            </div>
                        </td>
                    </tr>
                `;
            }

            for (const key in data.data) {
                state += `
                    <tr>
                        <td class="search py-2 px-3 d-flex justify-content-between">
                            <div>
                                <span class="text-dark font-weight-bold">${data.data[key].name} <small>(${data.data[key].code})</small></span>
                            </div>
                            <div class="action-button">
                                <form method="post" action="state/delete/${data.data[key].id}" id="delete-state-${data.data[key].id}" accept-charset="UTF-8" class="display_inline">
                                    <input type="hidden" name="_token" value="${token}">
                                    <span title="${jsLang('Delete')}"
                                        data-id="${data.data[key].id}"
                                        data-label="Delete"
                                        data-delete="state"
                                        data-bs-toggle="modal"
                                        data-bs-target="#confirmDelete"
                                        data-title="${jsLang('Delete State')}"
                                        data-message="${jsLang('Are you sure to delete this?')}">
                                        <i class="fa fa-trash delete"></i>
                                    </span>
                                </form>
                                <span title="${jsLang('Edit')}"
                                    class="edit-state"
                                    data-id="${data.data[key].id}"
                                    data-countryId="${data.data[key].country_id}"
                                    data-name="${data.data[key].name}"
                                    data-fullName="${data.data[key].full_name}"
                                    data-code="${data.data[key].code}"
                                    data-bs-toggle="modal"
                                    data-bs-target="#edit-state">
                                    <i class="fa fa-edit edit neg-transition-scale"></i>
                                </span>
                                <span class="find-city cursor_pointer" data-ciso="${country_code}" data-siso="${data.data[key].id}">
                                    <svg viewBox="0 0 20 20" fill="currentColor" class="arrow-circle-right neg-transition-scale">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-8.707l-3-3a1 1 0 00-1.414 1.414L10.586 9H7a1 1 0 100 2h3.586l-1.293 1.293a1 1 0 101.414 1.414l3-3a1 1 0 000-1.414z" clip-rule="evenodd"></path>
                                    </svg>
                                </span>
                            </div>
                        </td>
                    </tr>
                `;
            }
            $('.states-tb').html(state);
        }
    })
})

// Get cities via country code and division code
$(document).on('click', '.find-city', function() {
    $('.add-city').css('display', 'inline');

    $('.action-button').hide();
    $(this).closest('tbody').find('tr').css('background', 'unset');
    $(this).closest('tr').css('background', '#ddd');

    var siso = $(this).attr('data-siso');
    var ciso = $(this).attr('data-ciso');

    $('#add-city input[name="country_id"]').val(ciso);
    $('#add-city input[name="division_id"]').val(siso);

    $('.cities-tb').html(`
        <ul class="addon-form-loading pt-160">
            <div id="addon-res-loader">
                <svg class="" id="loading-spinner" width="80" height="80" viewBox="0 0 80 80" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <circle id="loading-circle-large" cx="40" cy="40" r="36" stroke="#FCCA19" stroke-width="8"></circle>
                </svg>
            </div>
        </ul>
    `);
    $.ajax({
        url: SITE_URL + "/countries/" + ciso + "/states/" + siso + "/cities",
        type: 'GET',
        dataType: 'JSON',
        success: function (data) {
            $('.action-button').show();

            var state = '';
            if (data.data.length === 0) {
                state += `
                    <tr>
                        <td class="search py-2 px-3 d-flex justify-content-between">
                            <div>
                                <span class="font-weight-bold text-warning">${jsLang('The state has no city. Select different one.')}</span>
                            </div>
                        </td>
                    </tr>
                `;
            }
            for (const key in data.data) {
                state += `
                    <tr>
                        <td class="search py-2 px-3 d-flex justify-content-between">
                            <div>
                                <span class="text-dark font-weight-bold">${data.data[key].name}</span>
                            </div>
                            <div class="action-button">
                                <form method="post" action="city/delete/${data.data[key].id}" id="delete-city-${data.data[key].id}" accept-charset="UTF-8" class="display_inline">
                                    <input type="hidden" name="_token" value="${token}">
                                    <span title="${jsLang('Delete')}"
                                        data-id="${data.data[key].id}"
                                        data-label="Delete" data-delete="city"
                                        data-bs-toggle="modal"
                                        data-bs-target="#confirmDelete"
                                        data-title="${jsLang('Delete City')}"
                                        data-message="${jsLang('Are you sure to delete this?')}">
                                        <i class="fa fa-trash delete"></i>
                                    </span>
                                </form>
                                <span title="${jsLang('Edit')}"
                                    class="edit-city"
                                    data-countryId="${data.data[key].country_id}"
                                    data-divisionId="${data.data[key].division_id}"
                                    data-name="${data.data[key].name}"
                                    data-fullName="${data.data[key].full_name}"
                                    data-code="${data.data[key].code}"
                                    data-ianaTimezone="${data.data[key].iana_timezone}"
                                    data-id="${data.data[key].id}"
                                    data-bs-toggle="modal"
                                    data-bs-target="#edit-city">
                                    <i class="fa fa-edit edit neg-transition-scale"></i>
                                </span>
                            </div>
                        </td>
                    </tr>
                `;
            }
            $('.cities-tb').html(state);
        }
    })
})

$(document).on('click', '.edit-city', function() {
    var edit_city = {
        'country_id': $(this).attr('data-countryId') != 'null' ? $(this).attr('data-countryId') : '',
        'division_id': $(this).attr('data-divisionId') != 'null' ? $(this).attr('data-divisionId') : '',
        'name': $(this).attr('data-name') != 'null' ? $(this).attr('data-name') : '',
        'full_name': $(this).attr('data-fullName') != 'null' ? $(this).attr('data-fullName') : '',
        'code': $(this).attr('data-code') != 'null' ? $(this).attr('data-code') : '',
        'iana_timezone': $(this).attr('data-ianaTimezone') != 'null' ? $(this).attr('data-ianaTimezone') : '',
    }
    for (const key in edit_city) {
        $('#edit-city').find('#' + key).val(edit_city[key])
        $('#edit-city').find('form').attr('action', 'city/update/' + $(this).attr('data-id'))

    }
})

$(document).on('click', '.edit-state', function() {
    var edit_state = {
        'country_id': $(this).attr('data-countryId') != 'null' ? $(this).attr('data-countryId') : '',
        'name': $(this).attr('data-name') != 'null' ? $(this).attr('data-name') : '',
        'full_name': $(this).attr('data-fullName') != 'null' ? $(this).attr('data-fullName') : '',
        'code': $(this).attr('data-code') != 'null' ? $(this).attr('data-code') : '',
    }
    for (const key in edit_state) {
        $('#edit-state').find('#' + key).val(edit_state[key])
        $('#edit-state').find('form').attr('action', 'state/update/' + $(this).attr('data-id'))

    }
})

$(document).on('click', '.edit-country', function() {
    var edit_country = {
        'name'          : $(this).attr('data-name') != 'null' ? $(this).attr('data-name') : '',
        'full_name'     : $(this).attr('data-fullName') != 'null' ? $(this).attr('data-fullName') : '',
        'capital'       : $(this).attr('data-capital') != 'null' ? $(this).attr('data-capital') : '',
        'code'          : $(this).attr('data-code') != 'null' ? $(this).attr('data-code') : '',
        'code_alpha3'   : $(this).attr('data-codeAlpha3') != 'null' ? $(this).attr('data-codeAlpha3') : '',
        'code_numeric'  : $(this).attr('data-codeNumeric') != 'null' ? $(this).attr('data-codeNumeric') : '',
        'emoji'         : $(this).attr('data-emoji') != 'null' ? $(this).attr('data-emoji') : '',
        'currency_code' : $(this).attr('data-currencyCode') != 'null' ? $(this).attr('data-currencyCode') : '',
        'currency_name' : $(this).attr('data-currencyName') != 'null' ? $(this).attr('data-currencyName') : '',
        'currency_symbol' : $(this).attr('data-currencySymbol') != 'null' ? $(this).attr('data-currencySymbol') : '',
        'tld'           : $(this).attr('data-tld') != 'null' ? $(this).attr('data-tld') : '',
        'callingcode'   : $(this).attr('data-callingCode') != 'null' ? $(this).attr('data-callingCode') : '',
    }
    for (const key in edit_country) {
        $('#edit-country').find('#' + key).val(edit_country[key])
        $('#edit-country').find('form').attr('action', 'country/update/' + $(this).attr('data-id'))

    }
})
