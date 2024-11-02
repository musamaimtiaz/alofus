"use strict";
if ($('.main-body .page-wrapper').find('#order-checkout-container').length) {
    checkedAddress();
    var tabName = "old";
    var defaultAddress = $('#defaultAddress').val();
    checkTab();
    setTimeout(function() {   //calls click event after a certain time
        checkOldAddress()
    }, 1500);
    function checkTab() {
        $(".selected-tab").each(function() {
            if ($(this).hasClass("is-active")) {
                tabName = $(this).attr("data-tab");
                $("#selected_tab").val(tabName);
            }
        });

        if (tabName == "old") {
            hideRequired();
        } else if (tabName == "new") {
            showRequired();
        }
    }
    function checkOldAddress() {
        if (oldCity != 'null' && tabName == 'new') {
            $('#city').trigger("change");
        }

        if (oldShipDifferent == 'on' && tabName == 'new') {
            $('#ship_different').trigger("change");
        }
    }
    $(document).on("keyup", ".positive-int-number", function () {
        var number = $(this).val();
        $(this).val(number.replace(/[^0-9]/g, ""));
    });

    $('#default-address').on('change', function(e) {
        if ($(this).is(":checked")) {
            $.ajax({
                url: SITE_URL + "/user/check-default-address",
                data: {
                    user_id: userId,
                    "_token": token
                },
                type: 'POST',
                dataType: 'JSON',
                success: function (data) {
                        const Toast = Swal.mixin({
                        toast: true,
                        position: 'bottom-start',
                        showConfirmButton: false,
                        timer: 3000,
                        timerProgressBar: true,
                        didOpen: (toast) => {
                            toast.addEventListener('mouseenter', Swal.stopTimer)
                            toast.addEventListener('mouseleave', Swal.resumeTimer)
                        }
                    })
                    if (data.status == 1) {
                        $('#new-address').prop('checked',false);
                        hideRequired();
                    } else {
                        Toast.fire({
                            icon: 'error',
                            title: jsLang('Default address not found! Please create a address & make it default')
                        })
                        showRequired();
                        $('#default-address').prop('checked',false);
                    }
                }
            });
        }
    });

    $(document).on("change", ".address-radio, #city, #zip", function () {
        let address = {
           'address_id' : $(this).attr('data-addressId'),
           'country' :  $('#country').val(),
           'state' :  $('#state').val(),
           'city' :  $('#city').val(),
           'zip' : $('#zip').val(),
        };

        if($('#ship_different').is(':checked') ){
            address = {
                'address_id' : $(this).attr('data-addressId'),
                'country' :  $('#shipping_address_country').val(),
                'state' :  $('#shipping_address_state').val(),
                'city' :  $('#shipping_address_city').val(),
                'zip' : $('#shipping_address_zip').val(),
                'billing_country' : $('#country').val(),
                'billing_state' :  $('#state').val(),
                'billing_city' :  $('#city').val(),
                'billing_zip' : $('#zip').val(),
                'ship_different' : "on",
            };
        }

        getTax(address);
    });

    function getTax(address)
    {
        $.ajax({
            url: SITE_URL + "/order-get-shipping-tax",
            data: {
                address: address,
                "_token": token
            },
            type: 'POST',
            dataType: 'JSON',
            beforeSend: function(xhr) {
                setTimeout(() => {
                    $(".checked-loader").block({
                        message: `<div class="flex justify-center">
                    <svg class="animate-spin text-gray-700 w-4 h-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="#000" stroke-width="3"></circle>
                    <path class="opacity-75" fill="#fff" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
                    </div>`,
                        css: {
                            backgroundColor: "transparent",
                            border: "none",
                        },
                    });
                }, 5);
            },
            success: function (data) {
                if (data.status == 1) {
                    shippingTax(data.tax, data.shipping, data.totalPrice, data.shippingIndex, data.displayTaxTotal);
                }
            },
            complete: function() {
                $(".checked-loader").unblock();
            }
        });
    }

    function hideRequired()
    {
        $('.address-form').hide();
        $.each($('.required-field'), function (){
            $(this).prop('required',false);
            $(this).removeAttr('oninvalid');
            $(this).next("label").remove();
            $(this).attr('readonly', true);
        });
        $.each($('.has-validation-error'), function (){
            $(this).removeClass('has-validation-error');
        });
    }

    function showRequired()
    {
        $('.address-form').show();
        $.each($('.required-field'), function (){
            $(this).prop('required',true);
            $(this).attr('oninvalid', "this.setCustomValidity(jsLang('This field is required.'))");
            $(this).attr('readonly', false);

        });
    }

    $("#addressForm").on('submit', function(event) {
        let typeOfPlaceCheck = true;
        if($('.type_of_place').is(":checked") || tabName == "old") {
            $('#errorMsg').removeClass('error');
            $('#errorMsg').text('');
        } else {
            $('#errorMsg').addClass('error');
            $('#errorMsg').text(jsLang('This field is required.'));
            event.preventDefault();
            typeOfPlaceCheck = false;
        }
        if (tabName == 'old' && defaultAddress == null || tabName == 'old' && defaultAddress == '') {
            event.preventDefault();
            $('#errorMsg_address').removeClass('display-none');
        } else {
            if (typeOfPlaceCheck == true) {
                setTimeout(() => {
                    $('#makePayment').addClass('pointer-events-none');
                    $('#makePayment').html(`
                    <span>${jsLang('Make Payment')}</span><svg class="animate-spin text-gray-700 h-full ml-2" xmlns="http://www.w3.org/2000/svg" width="15" height="10" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="#000" stroke-width="3"></circle>
                        <path class="opacity-75" fill="#fff" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                         `)
                }, 5);
            }
        }
    })

    $('#makePayment').on('click', function(e) {
        if($('.type_of_place').is(":checked")) {
            $('#errorMsg').removeClass('error');
            $('#errorMsg').text('');
        } else {
            $('#errorMsg').addClass('error');
            $('#errorMsg').text(jsLang('This field is required.'));
        }
    });

    $('.type_of_place').on('change', function(e) {
        if ($(this).is(":checked")) {
            $('#errorMsg').removeClass('error');
            $('#errorMsg').text('');
        }
    });

    $('.selected-tab').on('click', function(e) {
        $('#new-address'+defaultAddress).prop('checked',false);
        $('#new-address-border'+defaultAddress).removeClass('border-gray-12');
        $('#new-address-border'+defaultAddress).addClass('border-gray-2');
        $('.s-icon').addClass('hidden');
         tabName = $(this).attr('data-tab');
        if (tabName == 'old') {
            hideRequired();
            shippingRequired('remove');
            $('#ship_different').prop('checked',false);
            $('#ship_different').trigger('change');
        } else {
            showRequired();
            if ($('#country').val() != '') {
                defaultCountry();
            }
            defaultAddress = null;
            if (oldShipDifferent == 'on' && tabName == 'new') {
                $('#ship_different').trigger("change");
            }

            if (oldShipDifferent != 'on' && oldCity != 'null' && tabName == 'new') {
                setTimeout(function() {   //calls click event after a certain time
                    $('#city').trigger("change");
                }, 1500);
            }
        }
        $("#selected_tab").val(tabName);
    });

    function defaultCountry(action = 'tab_validation')
    {
        let loader = `<option value="">${jsLang('Loading')}...</option>`;
        $.ajax({
            url: SITE_URL + "/geo-locale/countries",
            type: "GET",
            dataType: 'json',
            beforeSend: function() {
                if (action != 'tab_validation') {
                    $('#shipping_address_country').html(loader);
                    $('#shipping_address_country').attr('disabled','true');
                } else {
                    $('#country').html(loader);
                    $('#country').attr('disabled','true');
                }
            },
            success: function(result) {
                if (action != 'tab_validation') {
                    $('#shipping_address_country').html('<option value="">' + jsLang('Select Country') + '</option>');
                } else {
                    $('#country').html('<option value="">' + jsLang('Select Country') + '</option>');
                }
                $.each(result, function(key, value) {
                    if (action != 'tab_validation') {
                        $("#shipping_address_country").append(`'<option data-country="${value.code}" value="${ value
                            .code}">${value.name}</option>'`);
                        $("#shipping_address_country").removeAttr("disabled");
                    } else {
                        $("#country").append(`'<option  ${value.code==oldCountry?'Selected': ''} data-country="${value.code}" value="${ value
                            .code}">${value.name}</option>'`);
                        $("#country").removeAttr("disabled");
                    }
                });
            }
        });
    }

    function checkedAddress()
    {
        $(".address-radio").each(function() {
            if ($(this).is(":checked")) {
                let addressId = $(this).attr('data-addressId');
                $("#address_id").val(addressId);
                hideRequired();
            }
        });
    }

    $('.address-radio').click(function(){
        let address_box = $(this).closest("div.adress-container");
        let addressId = $(this).attr('data-addressId');
        defaultAddress = addressId;
        $("#address_id").val(addressId);
        hideRequired();
        $('#errorMsg_address').addClass('display-none');
        $(this).closest("div.adress-container").addClass('border-gray-12').removeClass('border-gray-2');
        address_box.find('.s-icon').removeClass('hidden');
        address_box.find('.ab-name, .ab-label').addClass('text-gray-12').removeClass('text-gray-10');
        let address_container= $(this).closest('div.c-tab');
        let address_box_all=address_container.children();

        for(let i = 0; i<address_box_all.length; i++){
            let a_box = $(address_box_all[i]);
            if(a_box[0] !== address_box[0]){
                a_box.removeClass('border-gray-12');
                a_box.find('.s-icon').addClass('hidden');
                a_box.find('.ab-name, .ab-label').removeClass('text-gray-12').addClass('text-gray-10');
            }
        }
    })

    //Breadcrumbs functionality for checkout page
    function Tabs(options){

        var tabs = document.querySelector(options.el);
        var initCalled = false;
        var tabNavigation = tabs.querySelector(".c-tabs-nav");
        var tabNavigationLinks = tabs.querySelectorAll(".c-tabs-nav__link");
        var tabContentContainers = tabs.querySelectorAll(".c-tab");

        var marker = options.marker ? createNavMarker() : false;

        var activeIndex = 0;

      function init(){
            if (!initCalled){
                initCalled = true;

                for (var i = 0; i < tabNavigationLinks.length; i++){
                    var link = tabNavigationLinks[i];
                    clickHandlerSetup(link, i)
                }

                if (marker){
                    setMarker(tabNavigationLinks[activeIndex]);
                }
            }
        }

        function clickHandlerSetup(link, index){
            link.addEventListener("click", function(e){
                e.preventDefault();
                goToTab(index);
            })
        }

        function goToTab(index){
            if (index >= 0 && index != activeIndex && index <= tabNavigationLinks.length){
                tabNavigationLinks[activeIndex].classList.remove('is-active');
                tabNavigationLinks[index].classList.add('is-active');

                tabContentContainers[activeIndex].classList.remove('is-active');
                tabContentContainers[index].classList.add('is-active');

                if (marker){
                    setMarker(tabNavigationLinks[index]);
                }

                activeIndex = index;
            }
        }

        function createNavMarker(){
            var marker = document.createElement("div");
            marker.classList.add("c-tab-nav-marker");
            tabNavigation.appendChild(marker);
            return marker;
        }

        function setMarker(element){
            marker.style.left = element.offsetLeft +"px";
            marker.style.width = element.offsetWidth + "px";
            }

            return {
                init: init,
                goToTab: goToTab
            }
    }


        var m = new Tabs({
            el: "#tabs",
            marker: true
        });

        m.init();

    $(document).on("change", "#ship_different", function () {

        let address = {};
        if ($(this).is(':checked')) {
            $('#different-address-form').removeClass('display-none');
            $('.shippingAddressSelect').select2();
            defaultCountry('ship_different');
            shippingRequired();

            address = {
                'address_id' : $(this).attr('data-addressId'),
                'country' :  $('#shipping_address_country').val(),
                'state' :  $('#shipping_address_state').val(),
                'city' :  $('#shipping_address_city').val(),
                'zip' : $('#shipping_address_zip').val(),
                'billing_country' : $('#country').val(),
                'billing_state' :  $('#state').val(),
                'billing_city' :  $('#city').val(),
                'billing_zip' : $('#zip').val(),
                'ship_different' : "on",
            };
            oldShipDifferent = 'on';
        } else {
            $('#different-address-form').addClass('display-none');
            shippingRequired('remove');
            address = {
                'address_id' : $(this).attr('data-addressId'),
                'country' :  $('#country').val(),
                'state' :  $('#state').val(),
                'city' :  $('#city').val(),
                'zip' : $('#zip').val(),
            };
            oldShipDifferent = null;
        }
        getTax(address);
    });

    function shippingRequired(type='required')
    {
        if (type == 'remove') {
            $.each($('.shipping_address_required-field'), function (){
                $(this).prop('required',false);
                $(this).removeAttr("oninvalid");
                $(this).next('label').remove();
                $(this).attr('readonly', true);

                $.each($('.validSelectShipping'), function (){
                    $(this).removeClass('has-validation-error');
                });
            });
        } else {
            $.each($('.shipping_address_required-field'), function (){
                $(this).prop('required',true);
                $(this).attr('oninvalid', "this.setCustomValidity(jsLang('This field is required.'))");
                $(this).attr('readonly', false);
            });
        }
    }

    $('#shipping_address_country').on('change', function() {
        let str = $(this).find(':selected').html();

        if (str.length > 0) {
            let selector = this.closest('.validSelectShipping');
            selector.querySelector('.shippingAddressSelect').setCustomValidity("");
            if (selector.querySelector('.error')) {
                selector.querySelector('.error').remove();
            }
        }
        getStateShipping($('#shipping_address_country').find(':selected').attr('data-country'));
    });

    function getStateShipping( country_code ) {

        if (country_code) {
            $("#shipping_address_state").html('');
            if (oldCity == "null") {
                $('#shipping_address_city').html(`<option value="">${jsLang('Select City')}</option>`);
            }
            $.ajax({
                url: SITE_URL + "/geo-locale/countries/" + country_code + "/states",
                type: "GET",
                dataType: 'json',
                beforeSend: function() {
                    $('#shipping_address_state').attr('disabled','true');
                    $('#shipping_address_state').html(`<option value="">${jsLang('Loading')}...</option>`);
                },
                success: function(result) {
                    $('#shipping_address_state').html(`<option value="">${jsLang('Select State')}</option>`);
                    $.each(result.data, function(key, value) {
                        $("#shipping_address_state").append(`'<option ${value.id==oldState?'Selected': ''} data-state="${value.code}" value="${value.code}">${value.name}</option>'`);
                    });
                    $("#shipping_address_state").removeAttr("disabled");
                    if (result.length <= 0 && result.data.length <= 0) {
                        errorMsg = errorMsg.replace(":x", 'State');
                        $('#shipping_address_state').html(`<option value="">${errorMsg}</option>`);
                    }
                }
            });
        } else {

            $('#shipping_address_state').html(`<option value="">${jsLang('Select State')}</option>`);
            $('#shipping_address_city').html(`<option value="">${jsLang('Select City')}</option>`);

        }
    }

    $('#shipping_address_state').on('change', function() {
        let str = $(this).find(':selected').html();

        if (str.length > 0) {
            let selector = this.closest('.validSelectShipping');
            selector.querySelector('.shippingAddressSelect').setCustomValidity("");
            if (selector.querySelector('.error')) {
                selector.querySelector('.error').remove();
            }
        }
        getCityShippping($('#shipping_address_state').find(':selected').attr('data-state'), $('#shipping_address_country').find(':selected').attr('data-country'));

    });

    function getCityShippping( siso, ciso) {

        if (siso && ciso) {
            $("#shipping_address_city").html('');
            $.ajax({
                url: SITE_URL + "/geo-locale/countries/" + ciso + "/states/" + siso +
                    "/cities",
                type: "GET",
                dataType: 'json',
                beforeSend: function() {
                    $('#shipping_address_city').html(`<option value="">${jsLang('Loading')}...</option>`);
                    $('#shipping_address_city').attr('disabled','true');
                },
                success: function(res) {
                    $('#shipping_address_city').html(`<option value="">${jsLang('Select City')}</option>`);
                    $.each(res.data, function(key, value) {
                        $("#shipping_address_city").append(`<option ${value.name == oldCity ? 'Selected': ''} value="${value.name}">${value.name}</option>`);
                    });
                    $("#shipping_address_city").removeAttr("disabled");
                    if (res.length <= 0 && res.data.length <= 0) {
                        errorMsg = errorMsg.replace(":x", 'City');
                        $('#shipping_address_city').html(`<option value="">${errorMsg}</option>`);
                    }
                }
            });
        } else {
            $('#shipping_address_city').html(selectCity);
        }
    }

    $('#shipping_address_city').on('change', function() {
        let str = $(this).find(':selected').html();

        if (str.length > 0) {
            let selector = this.closest('.validSelectShipping');
            selector.querySelector('.shippingAddressSelect').setCustomValidity("");
            if (selector.querySelector('.error')) {
                selector.querySelector('.error').remove();
            }

            let address = {
                'address_id' : $(this).attr('data-addressId'),
                'country' :  $('#shipping_address_country').val(),
                'state' :  $('#shipping_address_state').val(),
                'city' :  $('#shipping_address_city').val(),
                'zip' : $('#shipping_address_zip').val(),
                'billing_country' : $('#country').val(),
                'billing_state' :  $('#state').val(),
                'billing_city' :  $('#city').val(),
                'billing_zip' : $('#zip').val(),
                'ship_different' : "on",
            };
            getTax(address);
        }
    });

    $('#shipping_address_zip').on('change', function() {
        let address = {
            'address_id' : $(this).attr('data-addressId'),
            'country' :  $('#shipping_address_country').val(),
            'state' :  $('#shipping_address_state').val(),
            'city' :  $('#shipping_address_city').val(),
            'zip' : $('#shipping_address_zip').val(),
            'billing_country' : $('#country').val(),
            'billing_state' :  $('#state').val(),
            'billing_city' :  $('#city').val(),
            'billing_zip' : $('#zip').val(),
            'ship_different' : "on",
        };
        getTax(address);
    });

}
