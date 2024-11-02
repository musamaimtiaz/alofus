"use strict";
var country= '';
var state = '';
var city ='';
let loader = `<option value="">${jsLang('Loading')}...</option>`;
let selectCity = `<option value="">${jsLang('Select City')}</option>`;
let selectState = `<option value="">${jsLang('Select State')}</option>`;
var selectedCountry = '';
var selectedState = '';
var selectedCity = '';
let errorMsg = jsLang(':x is not available.');

$(".change-toggle-button").click(function(e){
     e.stopPropagation();
     $.ajax({
         url: SITE_URL + "/geo-locale/countries",
         type: "GET",
         dataType: 'json',
         beforeSend: function () {
             $('#country').html(loader);
             $('#country').attr('disabled', 'true');
         },
         success: function (result) {
             $("#country").empty();
             $.each(result, function (key, value) {
                 $("#country").append(`<li class="country-name cursor-pointer py-3 primary-bg-hover hover:text-gray-12 px-2.5" data-country="${value.code}" data-value="${value
                     .code}">${value.name}</li>`);
             });
             $("#country").removeAttr("disabled");
             reloadClick();
         }
     });
    $(".delivery-content").slideToggle();
});
$(".delivery-content").click(function(e){
    e.stopPropagation();
});
$(document).click(function(){
    $(".delivery-content").slideUp();
});

$(".search-name-country").on("keyup", function() {
    var value = this.value.toLowerCase().trim();
    $(".list-country li").show().filter(function() {
        return $(this).text().toLowerCase().trim().indexOf(value) == -1;
    }).hide();
});
$(".search-name-state").on("keyup", function() {
    var value = this.value.toLowerCase().trim();
    $(".list-state li").show().filter(function() {
        return $(this).text().toLowerCase().trim().indexOf(value) == -1;
    }).hide();
});
$(".search-name-city").on("keyup", function() {
    var value = this.value.toLowerCase().trim();
    $(".list-city li").show().filter(function() {
        return $(this).text().toLowerCase().trim().indexOf(value) == -1;
    }).hide();
});

function reloadClick()
{
    $('.country-name').click( function() {
        country= $(this).text();
        selectedCountry = $(this).attr('data-country');
        $(".view-country").removeClass('hidden').html(country +`<img class="mx-2 my-1 neg-transition-scale" src="${SITE_URL}/public/frontend/assets/img/product/arrow-right.svg" alt="">`);
        $(".state-list , .state-name").show();
        $(".country-list, .city-list").hide();

        oldCity = "null";

        getState($(this).attr('data-country'));

    });

    $(".state-name").on('click', function() {
        state= $(this).text();
        selectedState = $(this).attr('data-state');
        $(".view-state").removeClass('hidden').html( state + `<img class="mx-2 my-1 neg-transition-scale" src="${SITE_URL}/public/frontend/assets/img/product/arrow-right.svg" alt="">`);
        $(".state-list , .country-list").hide();
        $(".city-list , .city-name").show();
        getCity(selectedState, selectedCountry);
    });
    $(".city-name").on('click', function() {
        city= $(this).text();
        selectedCity = $(this).attr('data-city');
        $(".view-city").removeClass('hidden').html(city);
        $('#address-view').text(country +',' + state +','+city);
        $(".country-list").show();
        $(".city-list , .delivery-content").hide();
        $(".view-city , .view-state , .view-country").addClass('hidden');
        getShipping();
    });
    $(".view-country").on('click', function() {
        $(".country-list").show();
        $(".city-list , .city-name , .state-list , .state-name").hide();
        $(".view-city , .view-state").addClass('hidden');
    });
    $(".view-state").on('click', function(){
        $(".country-list , .city-list").hide();
        $(".state-list , .view-country").show();
        $(".view-city").addClass('hidden');
    });
}


function getState( country_code ) {

    if (country_code) {
        $("#stateHtml").html('');
        if (oldCity == "null") {
            $('#city').html(selectCity);
        }
        $.ajax({
            url: SITE_URL + "/geo-locale/countries/" + country_code + "/states",
            type: "GET",
            dataType: 'json',
            beforeSend: function() {
                $('#state').attr('disabled','true');
                $('#state').html(loader);
            },
            success: function(result) {
                $('#state').empty();
                $.each(result.data, function(key, value) {
                    $("#state").append(`<li class="state-name cursor-pointer py-3 primary-bg-hover hover:text-gray-12 px-2.5" data-state="${value.code}">${value.name}</li>`);
                });
                $("#state").removeAttr("disabled");
                if (result.length <= 0 && result.data.length <= 0) {
                    errorMsg = errorMsg.replace(":x", 'State');
                    $('#state').html(`<li class="state-name cursor-pointer py-3 primary-bg-hover hover:text-gray-12 px-2.5">${errorMsg}</li>`);
                }
                reloadClick();
            }
        });
    } else {

        $('#state').html(selectState);
        $('#city').html(selectCity);

    }
}

function getCity( siso, ciso) {

    if (siso && ciso) {
        $("#city").html('');
        $.ajax({
            url: SITE_URL + "/geo-locale/countries/" + ciso + "/states/" + siso +
                "/cities",
            type: "GET",
            dataType: 'json',
            beforeSend: function() {
                $('#city').html(loader);
                $('#city').attr('disabled','true');
            },
            success: function(res) {
                $('#city').empty();
                $.each(res.data, function(key, value) {
                    $("#city").append(`<li class="city-name cursor-pointer py-3 primary-bg-hover hover:text-gray-12 px-2.5" data-city="${value.name}">${value.name}</li>`);
                });
                $("#city").removeAttr("disabled");
                if (res.length <= 0 && res.data.length <= 0) {
                    errorMsg = errorMsg.replace(":x", 'City');
                    $('#city').html(`<li class="city-name cursor-pointer py-3 primary-bg-hover hover:text-gray-12 px-2.5">${errorMsg}</li>`);
                }
                reloadClick();
            }
        });
    } else {
        $('#city').html(selectCity);
    }
}

function getShipping()
{
    $.ajax({
        url: SITE_URL + "/get-shipping",
        type: "GET",
        data:{
            'product_id' : itemId,
            'country' : selectedCountry,
            'state' : selectedState,
            'city' : selectedCity,
        },
        dataType: 'json',
        success: function(data) {
            if(data['status'] == 1) {
                $('#shipping-name').text(data['name']);
                $('#shippingAmount').text(decimalNumberFormatWithCurrency(data['amount']));
            } else {
                $('#shipping-name').text(jsLang('Not Applicable'));
                $('#shippingAmount').text(decimalNumberFormatWithCurrency(0));
            }
        }
    });
}
