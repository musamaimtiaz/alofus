'use strict';
// customer project details
if (($('.main-body .page-wrapper').find('#customer-panel-details-container').length)) {
    $(window).on('load', function() {
        var windowSize = $(window).width();
        if (windowSize < 576) {
            $('#border-right-1').removeClass("border-right");
            $('div.card-block.m-t-10').addClass("ml-2");
        }
    });

    $('.progressbar').each(function() {
        var elementPos = $(this).offset().top;
        var topOfWindow = $(window).scrollTop();
        var percent = $(this).find('.circle').attr('data-percent');
        var percentage = parseInt(percent, 10) / parseInt(100, 10);
        var animate = $(this).data('animate');

        $(this).data('animate', true);
        $(this).find('.circle').circleProgress({
            startAngle: -Math.PI / 2,
            value: percent / 100,
            thickness: 14,
            fill: {
                color: '#1dc4e8'
            }
        }).on('circle-animation-progress', function(event, progress, stepValue) {
            $(this).find('div').text((stepValue * 100).toFixed(1) + "%");
        }).stop();

    });

    $('#show_more').on('click', function(event) {
        if ($(this).text() === 'SHOW MORE') {
            $(this).text(jsLang('SHOW LESS'));
            $('#projectDetailsLess').hide();
        } else {
            $(this).text(jsLang('SHOW MORE'));
            $('#projectDetailsLess').show();
        }
    });
    if ($(window).width() >= 320 && $(window).width() <= 425) {
        $('.progressbar').addClass('center');
        $('.resDate').remove('f-16').addClass('f-14');
    } else if ($(window).width() >= 1440) {
        $('.progressbar').remove('center').addClass('float-right');
        $('.resDate').remove('f-14').addClass('f-16');
    } else {
        $('.progressbar').remove('center');
        $('.resDate').remove('f-14').addClass('f-16');
    }
}

// customer panel project list
if (($('.main-body .page-wrapper').find('#cus-panel-project-list-container').length)) {
    $(document).on("click", "#csv, #pdf", function(event) {
        event.preventDefault();
        window.location = SITE_URL + "/customer-panel/projects-" + this.id + "?to=" + $('#endto').val() + "&from=" + $('#startfrom').val() + "&customer=" + $('#customer').val() + "&status=" + $('#status').val();
    });
    $('#dataTableBuilder').addClass('customer-panel-project-list-styles');
}

// customer panel ticket add
if (($('.main-body .page-wrapper').find('#cus-panel-ticket-add-container').length)) {
    $(".select2").select2();
    $("body").on("click", ".delete_file_field", function() {
        $(this).parents(".control-group").remove();
    });
    validateCKEditor('#ticket_messages', '#ticket_messages-error');
    $('#ticket_form').validate({
        ignore: [],
        rules: {
            subject: {
                required: true
            },
            department_id: {
                required: true
            },
            message: {
                CKEditorRequired: true
            },
        }
    });

    $(document).ready(function() {
        $('select').on("change", function() {
            if ($(this).val() != "") {
                $(this).valid();
            }
        });
    });
    deleteAttachment(SITE_URL + "/customer-panel/file/remove?type=ticket_reply");
    uploadAttachment(SITE_URL + "/customer-panel/file/upload?type=ticket_reply", '#customer_id');
    $('#btnSubmit').on('click', function() {
        if ($("#ticket_form").valid() == true) {
            /* load spinner */
            $(".spinner").show();
            $(".spinner").css('line-height', '0');
            $("#spinnerText").text(jsLang('Please wait...'));
            /* end of spinner */
            $(this).attr("disabled", true);
            $("#ticket_form").trigger('submit');
        }
    });
}

// customer panel ticket reply
if (($('.main-body .page-wrapper').find('#cus-panel-ticket-reply-container').length)) {
    var stack = [];
    $('.select2').select2();
    validateCKEditor('#ticket_messages', '#ticket_messages-error');

    var editorValue;
    ClassicEditor.create(document.querySelector('#txtMessage'))
        .then(editor => {
            editorValue = editor;
            theEditor = intialData = editor.getData(); // Save for later use.
            editor.model.document.on('change', () => {
                let editorData = intialData = editor.getData();
                editorData = editorData.replace(/&nbsp;/g, '').replace('<p>', '').replace('</p>', '').replace(/^\s+|\s+$/g, "");
                theEditor = editorData;
                if (editorData.length == 0) {
                    $('#txtMessage-error').show().html(jsLang('This field is required.'));
                    return false;
                } else {
                    $('#txtMessage-error').hide().html('');
                }
            });
        }).catch(error => {});

    $(".edit-btn").on('click', function() {
        editorValue.setData($(this).attr('data-message'));
        $("#reply_id").val($(this).attr('data-id'));
    });


    $('#replyModal').validate({
        rules: {
            message: {
                CKEditorRequired: true
            },
        },
        submitHandler: function() {
            if ($('#txtMessage').text() == "<p> </p>") {
                $('#txtMessage-error').show().html(jsLang('This field is required.'));
                return false;
            } else {
                $('#txtMessage-error').hide();
                return true;
            }
        }
    });


    $('#reply_form').validate({
        ignore: [],
        rules: {
            message: {
                CKEditorRequired: true
            },
        },
        submitHandler: function() {
            /* load spinner */
            $(".spinner").show();
            $(".spinner").css('line-height', '0');
            $("#spinnerText").text(jsLang('Please wait...'));
            /* end of spinner */
            $('#btnSubmit').attr("disabled", true);
            return true;
        }
    });

    $("body").on("click", ".delete_file_field", function() {
        $(this).parents(".control-group").remove();
    });
    deleteAttachment(SITE_URL + "/customer-panel/file/remove");
    uploadAttachment(SITE_URL + "/customer-panel/file/upload?type=ticket_reply", '#customer_id');
    $(document).ready(function() {
        if ($(window).width() <= 320) {
            $('.card-header h5').css('width', '54%');
        } else if ($(window).width() >= 375 && $(window).width() <= 425) {
            $('.card-header h5').css('width', '44%');
        }
    });
}

// customer panle ticket list
if (($('.main-body .page-wrapper').find('#cus-panel-ticket-list-container').length)) {
    $(document).on("click", "#csv, #pdf", function(event) {
        event.preventDefault();
        window.location = SITE_URL + "/customer-ticket-filtering-" + this.id + "?to=" + $('#endto').val() + "&from=" + $('#startfrom').val() + "&customer=" + customerName + "&customerID=" + customerID + "&project=" + $('#project').val() + "&status=" + $('#status').val() + "&department_id=" + $('#department_id').val();
    });
    $("#dataTableBuilder").addClass('customer-panel-support');
    $(document).on('click', ".ticket_status_change", function() {
        var statusId = $(this).attr('data-id');
        var ticketId = $(this).attr('ticket_id');
        ticketStatusChange(SITE_URL + '/customer-panel/ticket/change-status', statusId, ticketId);
    });
}
// customer panel invoice list
if (($('.main-body .page-wrapper').find('#cus-panel-invoice-list-container').length)) {
    $(document).ready(function() {
        $(document).on("click", "#csv, #pdf", function(event) {
            event.preventDefault();
            window.location = SITE_URL + "/customer-panel/sales-report-" + this.id + "?to=" + $('#endto').val() + "&from=" + $('#startfrom').val() + "&customer=" + $('#customer').val() + "&pay_status_type=" + $('#pay_status_type').val();
        });
    });
    $("#dataTableBuilder").addClass('customer-panel-quotation');
}

// customer panel invoice payment
if (($('.main-body .page-wrapper').find('#cus-panel-payment-container').length)) {
    $(document).ready(function() {
        $(document).on("click", "#csv, #pdf", function(event) {
            event.preventDefault();
            window.location = SITE_URL + "/customer-panel/payment/customer-" + this.id + "?to=" + $('#endto').val() + "&from=" + $('#startfrom').val() + "&customer=" + customerID + "&method=" + $('#method').val();
        });
    });
    $("#dataTableBuilder").addClass('customer-panel-payment');
}

// customer panel sales order
if (($('.main-body .page-wrapper').find('#cus-panel-sale-order-container').length)) {
    $(document).on("click", "#csv, #pdf", function(event) {
        event.preventDefault();
        window.location = SITE_URL + "/customer-panel-quotation-filtering-" + this.id + "?to=" + $('#endto').val() + "&from=" + $('#startfrom').val() + "&customer=" + customerName + "&debtor_no=" + customerID;
    });
    $("#dataTableBuilder").addClass('customer-panel-quotation');
}

// customer panel profile
if (($('.main-body .page-wrapper').find('#cus-panel-profile-container').length)) {
    $(".select2").select2();
    $('#password-form').validate({
        rules: {
            password: {
                required: true,
                minlength: 5
            },
            password_confirmation: {
                required: true,
                minlength: 5,
                equalTo: '[name="password"]'
            }
        }
    });

    $('#user-form').validate({
        rules: {
            first_name: {
                required: true,
                regxForName: true
            },
            last_name: {
                required: true,
                regxForName: true
            },
            phone: {
                required: false,
                regxPhone: true
            }
        }
    });

    jQuery.extend(jQuery.validator.messages, {
        equalTo: jsLang('Password did not match')
    });

    jQuery.validator.addMethod("regxForName", function(value, element) {
        var regExp = new RegExp(/^[a-zA-Z-'\s]+[a-zA-Z-'\.?\s]+$/);
        return this.optional(element) || regExp.test(value);
    }, jsLang('Enter a valid name'));

    jQuery.validator.addMethod("regxPhone", function(value, element) {
        var regExp = new RegExp(/^((\+\d{1,4}(-| )?\(?\d\)?(-| )?\d{1,9})|(\(?\d{2,9}\)?))(-| )?(\d{3,4})(-| )?(\d{4})(( x| ext)\d{1,5}){0,1}$/);
        var regExp2 = new RegExp(/^[+0-9 () \-]{8,20}$/);
        return this.optional(element) || regExp.test(value) || regExp2.test(value);
    }, jsLang('Enter a valid phone number'));
}

// customer view invoice
if (($('.main-body .page-wrapper').find('#cus-viewinvoice-container').length)) {
    $('#notifications .noti-alert').addClass('px-3');
    $('#stripe').on('show.bs.modal', function() {
        cardNumber.clear();
        cardExpiry.clear();
        cardCvc.clear();
        $('.error-alert').css('display', 'none');
    });

    // Create a Stripe client
    var stripe = Stripe(publishableKey);

    // Create an instance of Elements
    var elements = stripe.elements();

    // Custom styling can be passed to options when creating an Element.
    var elementStyles = {
        base: {
            color: '#32325D',
            fontWeight: 500,
            fontFamily: 'Source Code Pro, Consolas, Menlo, monospace',
            fontSize: '16px',
            fontSmoothing: 'antialiased',
            '::placeholder': {
                color: '#cfd7df',
            },
            ':-webkit-autofill': {
                color: '#e39f48',
            },
        },
        invalid: {
            color: '#721c24',
            '::placeholder': {
                color: '#cfd7df',
            },
        },
    };

    var elementClasses = {
        focus: 'focused',
        empty: 'empty',
        invalid: 'invalid',
    };

    // Create an instance of the card Element
    var cardNumber = elements.create('cardNumber', {
        style: elementStyles,
        classes: elementClasses,
    });
    cardNumber.mount('#card-number');

    var cardExpiry = elements.create('cardExpiry', {
        style: elementStyles,
        classes: elementClasses,
    });
    cardExpiry.mount('#card-expiry');

    var cardCvc = elements.create('cardCvc', {
        style: elementStyles,
        classes: elementClasses,
    });
    cardCvc.mount('#card-cvc');

    function stripeTokenHandler(token) {
        // Insert the token ID into the form so it gets submitted to the server
        var form = document.getElementById('payment-form');
        var hiddenInput = document.createElement('input');
        hiddenInput.setAttribute('type', 'hidden');
        hiddenInput.setAttribute('name', 'stripeToken');
        hiddenInput.setAttribute('value', token.id);
        form.appendChild(hiddenInput);
        // Submit the form
        $('#payment-form').trigger('submit');
    }

    // Create a token
    function createToken() {
        stripe.createToken(cardNumber).then(function(result) {
            if (result.error) {
                // Inform the user if there was an error
                $('#card-errors').css('display', 'block');
                var errorElement = document.getElementById('card-errors');
                errorElement.textContent = result.error.message;
            } else {
                $("#stripe-submit-btn").attr("disabled", true);
                $('.fa-spin').addClass('show-spin');
                // Send the token to your server
                stripeTokenHandler(result.token);
            }
        });
    };

    // Create a token when the form is submitted.
    var form = document.getElementById('payment-form');
    form.addEventListener('submit', function(e) {
        e.preventDefault();
        createToken();
    });

    cardNumber.on('change', function(event) {
        var displayError = document.getElementById('card-errors');
        if (event.error) {
            $(".fa-spin").hide();
            $('#card-errors').css('display', 'block');
            displayError.textContent = event.error.message;
        } else {
            $('#card-errors').css('display', 'none');
            displayError.textContent = '';
        }
    });
    /*Stripe End*/

    var paymentMethodName = '';


    $('.js-example-basic').select2({
        dropdownParent: $('#payModal')
    });


    $('#payment_date').daterangepicker(dateSingleConfig());
    $('#payModal').on('hidden.bs.modal', function() {
        $('#payForm').validate().resetForm();
        $('#payment_date').removeClass('error');
    });


    $("#payForm").validate({
        rules: {
            payment_date: {
                required: true
            }
        }
    });

    $(document).on('click', '#pay-button', function() {
        if ($("#payForm").valid() == true) {
            $(this).attr('disabled', 'disabled');
            $("#payForm").trigger('submit');
        }
    });

    // Email modal validation
    $('#sendOrderInfo').validate({
        rules: {
            email: {
                required: true
            },
            subject: {
                required: true,
            },
            message: {
                required: true,
            }
        }
    });

    // SMS modal validation
    $('#sendOrderInfoSMS').validate({
        rules: {
            phoneno: {
                required: true
            },
            message: {
                required: true
            }
        }
    });
    uploadAttachment(SITE_URL + "/customer-panel/file/upload?type=payment", '#customer_id');
    deleteAttachment(SITE_URL + "/customer-panel/file/remove");
}