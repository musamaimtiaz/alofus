'use strict';

var countrySearch = '';
var stateSearch = '';
$(document).on('input', '.geolocale-country', function() {
    if ($(this).val() != '' && $(this).val() != '*' && countrySearch != $(this).val().charAt(0)) {
        countrySearch = $(this).val().charAt(0);
        $('#country-list').find('option').remove();
        $.ajax({
            url: ADMIN_SITE_URL + '/country-search/' + countrySearch,
            type: 'GET',
            success: function (data) {
                for (const key in data) {
                    $('#country-list').append(`
                        <option value="${data[key].code}">${data[key].name} (${data[key].code})</option>
                    `)
                }
            }
        });
    }
})

$(document).on('input', '.geolocale-state', function() {
    if ($(this).val() != '' && $(this).val() != '*' && stateSearch != $(this).val().charAt(0)) {
        var countryCode = $(this).closest('tr').find('.geolocale-country').val();
        stateSearch = $(this).val().charAt(0);

        var url = ADMIN_SITE_URL + '/state-search/' + stateSearch;

        if (countryCode != '' && countryCode != '*') {
            url = url + '/' + countryCode;
        }

        $('#state-list').find('option').remove();

        $.ajax({
            url: url,
            type: 'GET',

            success: function (data) {
                for (const key in data) {
                    $('#state-list').append(`
                        <option value="${data[key].code}">${data[key].name} (${data[key].code})</option>
                    `)
                }
            }
        });
    }
})


