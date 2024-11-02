"use strict";
$("#loginForm").on("submit", function (event) {
    event.preventDefault();
    $("#signin-user").find(".signin-text").hide();
    $("#signin-user").addClass('auth-active-btn');
    $(".login-modal-loader").css("display", "inline");
    
    setDialCode('.phone-email-box', '.phone-email-box input[name="phone"]')
    
    $.ajax({
        url: SITE_URL + "/authenticate",
        type: "post",
        data: new FormData(this),
        dataType: "JSON",
        contentType: false,
        cache: false,
        processData: false,
        success: function (data) {
            if (data.status == 1) {
                $(".login-message").removeClass("border border-reds-3");
                $(".login-message").addClass(
                    "bg-green-2 p-7p md:p-2.5 md:pt-15p mb-3 md:mb-6 rounded border border-green-1 md:h-52p"
                ).html(`
                        <h1 class="roboto-medium font-medium text-11 md:text-15 ml-49p md:ml-52p text-green-1 status-message">${data.message}</h1>
                        <span class="absolute top-7p left-1 md:top-2.5 md:left-2.5 border-r h-4 md:h-30p border-green-1 pl-1.5 pr-3 status-message-svg">
                            <svg class="mt-1p md:mt-2 h-3.5 md:h-5 neg-transition-scale" xmlns="http://www.w3.org/2000/svg" width="19" height="15" viewBox="0 0 19 15" fill="none">
                            <path fill-rule="evenodd" clip-rule="evenodd" d="M18.3163 0.462473C17.5102 -0.242925 16.3121 -0.128557 15.6403 0.717921L8.80424 9.33189C8.14548 10.162 7.77515 10.6215 7.47948 10.9039C7.47564 10.9076 7.47188 10.9112 7.46818 10.9147C7.46419 10.9115 7.46013 10.9083 7.456 10.9051C7.13719 10.6519 6.72875 10.2295 6.00113 9.4654L3.2435 6.56972C2.5015 5.79059 1.29849 5.79059 0.556498 6.56972C-0.185497 7.34886 -0.185497 8.61209 0.556498 9.39123L3.31413 12.2869C3.34002 12.3141 3.36587 12.3412 3.39168 12.3684C4.01203 13.02 4.60881 13.6469 5.16407 14.0878C5.78606 14.5817 6.60062 15.0461 7.6445 14.9963C8.68838 14.9466 9.45955 14.4067 10.0364 13.8557C10.5514 13.3639 11.0916 12.6828 11.6532 11.9749C11.6766 11.9454 11.7 11.9159 11.7235 11.8864L18.5596 3.27239C19.2313 2.42592 19.1224 1.16787 18.3163 0.462473Z" fill="#009651"/>
                            </svg>
                        </span>

                    `);
                function check_cookie(name) {
                    return document.cookie.split(";").some((c) => {
                        return c.trim().startsWith(name + "=");
                    });
                }
                function getCookie(cname) {
                    let name = cname + "=";
                    let decodedCookie = decodeURIComponent(document.cookie);
                    let ca = decodedCookie.split(";");
                    for (let i = 0; i < ca.length; i++) {
                        let c = ca[i];
                        while (c.charAt(0) == " ") {
                            c = c.substring(1);
                        }
                        if (c.indexOf(name) == 0) {
                            return c.substring(name.length, c.length);
                        }
                    }
                    return "";
                }

                if (check_cookie("product_id")) {
                    $.ajax({
                        url: SITE_URL + "/user/wishlist/store",
                        type: "POST",
                        dataType: "JSON",
                        data: {
                            product_id: getCookie("product_id"),
                            store_only: true,
                            _token: token,
                        },
                        success: function (data) {
                            document.cookie = "product_id=; Max-Age=-99999999;";
                            window.location.href = SITE_URL;
                        },
                    });
                }
                if (affiliateRegistration && isActiveAffiliate == 1) {
                    return window.location.href = affiliateReg;
                }
                window.location.href = currentUrl.includes('wishlist/store') ? SITE_URL : currentUrl;
            } else {
                $(".login-message")
                    .addClass(
                        "bg-pinks-2 p-7p md:p-2.5 mb-3 md:mb-18p border border-reds-3 rounded"
                    )
                    .html(
                        `
                        <div class="flex items-center">
                        <span class="ml-1 md:ml-2.5 border-r h-4 md:h-30p border-reds-3 pr-3 error-status-message">
                            <svg class="mt-1p md:mt-1.5 h-3.5 md:h-5 neg-transition-scale" xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" fill="none">
                                <path fill-rule="evenodd" clip-rule="evenodd" d="M0 10C0 15.5228 4.47715 20 10 20C15.5228 20 20 15.5228 20 10C20 4.47715 15.5228 0 10 0C4.47715 0 0 4.47715 0 10ZM11 9V10V16V17H9V16V10V9H11ZM9 5V6H11V5V4V3H9V4V5Z" fill="#C8191C"/>
                            </svg>
                        </span>
                        <h1 class="roboto-medium font-medium text-11 md:text-15 text-reds-3 ml-4 error-message">${data.message}</h1></div>
                    `
                    )
                    .show();
                $(".login-modal-loader").css("display", "none");
                $("#signin-user").find(".signin-text").show();
                $("#signin-user").removeClass('auth-active-btn');
            }
        },
        error: function (data) {
            var error = "";
            $(".login-modal-loader").css("display", "none");
            $("#signin-user").find(".signin-text").show();
            $("#signin-user").removeClass('auth-active-btn');
            if (
                data.responseJSON.errors != undefined &&
                data.responseJSON.errors.gCaptcha != undefined
            ) {
                $(".login-captcha-error-message").text(
                    data.responseJSON.errors.gCaptcha[0]
                );
            }
            if (data.responseJSON.errors.email && data.responseJSON.errors.email[0]) {
                error = data.responseJSON.errors.email[0];
            } else if (data.responseJSON.errors.password && data.responseJSON.errors.password[0] != undefined) {
                error = data.responseJSON.errors.password[0];
            } else if (data.responseJSON.errors.phone && data.responseJSON.errors.phone[0] != undefined) {
                error = data.responseJSON.errors.phone[0];
            }
            if (error != "") {
                $(".login-message")
                    .addClass(
                        "bg-pinks-2 p-7p md:p-2.5 md:pt-15p mb-3 md:mb-18p border border-reds-3 rounded md:h-52p"
                    ).html(`
                        <h1 class="roboto-medium font-medium text-11 md:text-15 text-reds-3 ml-49p md:ml-52p status-message">${error}</h1>
                        <span class="absolute top-7p left-1 md:top-2.5 md:left-2.5 border-r h-4 md:h-30p border-reds-3 pl-1.5 pr-3 status-message-svg">
                            <svg class="mt-1p md:mt-1.5 h-3.5 md:h-5" xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" fill="none">
                                <path fill-rule="evenodd" clip-rule="evenodd" d="M0 10C0 15.5228 4.47715 20 10 20C15.5228 20 20 15.5228 20 10C20 4.47715 15.5228 0 10 0C4.47715 0 0 4.47715 0 10ZM11 9V10V16V17H9V16V10V9H11ZM9 5V6H11V5V4V3H9V4V5Z" fill="#C8191C"/>
                            </svg>
                        </span>
                    `).show();
            }
        },
        complete: function() {
            if (typeof (grecaptcha) != 'undefined') {
                grecaptcha.reset();
            }
        }
    });
});

// Active login part
$(document).on("click", ".login-active", function () {
    $(".register-active").removeClass("is-active");
    $(".login-active").addClass("is-active");
    $(".login-active-border").addClass("active-border");
    $(".register-active-border").removeClass("active-border");
});

// Active registration part
$(document).on("click", ".register-active", function () {
    $(".login-active").removeClass("is-active");
    $(".register-active").addClass("is-active");
    $(".register-active-border").addClass("active-border");
    $(".login-active-border").removeClass("active-border");
    setDialCode('#password-validate-submit', '#password-validate-submit #phone')
});

//password show-hide part
$(".password-hide").on('click', function () {
    $(this).hide();
    $(".password-show").show();
    $(this).closest(".password-container").find(".password-field").get(0).type =
        "text";
});

$(".password-show").on('click', function () {
    $(this).hide();
    $(".password-hide").show();
    $(this).closest(".password-container").find(".password-field").get(0).type =
        "password";
});

// Open modal
$(".open-login-modal").on('click', function () {
    $("#my-modal").css("display", "flex");
    $(".signin-form-container, .c-tabs-nav").show();
    $(".send-email-form-container, .reset-otp-form-container, .confirm-password-form-container, .password-reset-conf-container, .user-verification-form-container").hide();
});
$(".login-close-btn").on('click', function () {
    $("#my-modal").css("display", "none");
});
// Close modal when click outside of the modal
$(document).on("mousedown", function (e) {
    if (
        !(
            $(e.target).closest("#modal-main").length > 0 ||
            $(e.target).closest(".open-login-modal").length > 0
        )
    ) {
        $("#my-modal").css("display", "none");
    }
});

if (loginNeeded == 1) {
    $("#my-modal").css("display", "flex");
}

var debounce = null;
var email = null;
$(".registration-email").on('keyup', function () {
    var tmp = this;
    clearTimeout(debounce);
    debounce = setTimeout(function () {
        email = $(tmp).val();
        
        if (email.length < 7) {
            return;
        }
        
        $.ajax({
            url: SITE_URL + "/check-email-existence/" + email,
            type: "get",
            success: function (data) {
                if (data.status == 1) {
                    $(".email-validation-error")
                        .removeClass("text-green-500")
                        .addClass("text-red-500")
                        .text(data["message"]);
                }
            },
        });
    }, 1000);
});

//Admin login spinner functionality
$(".admin-login-con .sign-in-btn, .login-box-body .send-btn").on('click',
    function () {
        $(".admin-login-con .spin, .login-box-body .spin").show();
    }
);
//Admin Login load functionality
if ($(".auth-wrapper").find("#admin-login-container").length) {
    setTimeout(() => {
        $("#admin-login-container").show();
    }, 300);
}

//Password recovery modal functionality
if (window.location.href.includes('?')) {

    if (window.location.href.split('?')[1] == 'page=reset-password') {
        $(".send-email-form-container").show();
        $(".signin-form-container, .reset-otp-form-container, .confirm-password-form-container, .c-tabs-nav, .user-verification-form-container").hide();

        $('label.send-email-form').removeClass('text-green-400').addClass('text-red-400').text(jsLang('Invalid password token. Please try again.'));
    }

    var url = window.location.href.split('?')[1];
    if (url.includes('&')) {
        var obj = new Object;
        for (const key in url.split('&')) {
            obj[url.split('&')[key].split('=')[0]] = url.split('&')[key].split('=')[1]
        }
        if (obj.page == 'confirm-password') {
            $(".confirm-password-form-container").show().find('input[name="id"]').val(obj.id);
            $(".confirm-password-form-container input[name='token']").val(obj.token);
            $(".signin-form-container, .send-email-form-container, .reset-otp-form-container, .c-tabs-nav, .user-verification-form-container").hide();
        }
    }
}

function resendCode(parent) {
    $(parent).text('30').removeClass('underline cursor-pointer resend-code').css({'border': '2px solid #888', 'height':'30px', 'width':'30px', 'border-radius': '50%', 'display':'block','margin':'auto', 'padding':'1px'})
    var interval = setInterval(() => {
        var text = $(parent).text();
        text--;
        if (text < 10) {
            text = '0' + text;
        }
        $(parent).text(text);
        if (text <= 0) {
            $(parent).text(jsLang('Resend Code')).addClass('underline cursor-pointer resend-code').css({'border': 'unset', 'border-radius': 'unset', 'width':'unset', 'height':'unset', 'padding': 'unset','display':'unset','margin':'unset'})
            clearInterval(interval);
        }
    }, 1000);
}

$(".forgot-pass").on('click', function () {
    $(".send-email-form-container").show();
    $(".signin-form-container, .reset-otp-form-container, .confirm-password-form-container, .c-tabs-nav, .user-verification-form-container").hide();
});

$(".back-signIn").on('click', function () {
    $(".signin-form-container, .c-tabs-nav").show();
    $(".send-email-form-container, .reset-otp-form-container, .confirm-password-form-container, .user-verification-form-container").hide();
});

// Forget Password
var sendBtnClick = 0;
$(".send-btn").on('click', function () {
    if (++sendBtnClick > 1) {
        return;
    }
    
    setDialCode('.send-email-form-container', '.send-email-form-container input[name="phone"]')
    
    var parent = this;
    $(parent).removeClass('bg-gray-12').addClass('primary-bg-color').find('span').text('').siblings('.reset-modal-loader').removeClass('hidden');

    var email = $(this).closest('.form').find('input[name="email"]').val();
    var phone = $(this).closest('.form').find('input[name="dial_code"]').val() + $(this).closest('.form').find('input[name="phone"]').val();
    if (typeof email != 'undefined' && email.length == 0) {
        sendBtnClick = 0;
        $('label.send-email-form').removeClass('text-green-400').addClass('text-red-400').text(jsLang('Email address is required.'));
        setTimeout(() => {
            $('label.send-email-form').text('');
        }, 5000);
    } else if (typeof phone != 'undefined' && phone.length == 0) {
        sendBtnClick = 0;
        $('label.send-email-form').removeClass('text-green-400').addClass('text-red-400').text(jsLang('Phone number is required.'));
        setTimeout(() => {
            $('label.send-email-form').text('');
        }, 5000);
    }

    var contact = typeof email != 'undefined' ? email : phone;
    $.ajax({
        url: SITE_URL + "/valid-mail/" + contact,
        type: "get",
        dataType: "JSON",
        contentType: false,
        cache: false,
        processData: false,
        success: function (data) {
            if (data.status == 'success') {
                if (otpActive == 1) {
                    resendCode($('.resend-code'));
                    $(".reset-otp-form-container").show()
                    $('.resend-contact-info').text(contact)
                    $(".signin-form-container, .send-email-form-container, .confirm-password-form-container, .c-tabs-nav, .user-verification-form-container").hide();
                    $('.otp-input-reset').val('');
                } else {
                    $('label.send-email-form').removeClass('text-red-400').addClass('text-green-400').text(data.message);
                }
            } else {
                $('label.send-email-form').removeClass('text-green-400').addClass('text-red-400').text(data.message);
                setTimeout(() => {
                    $('label.send-email-form').text('');
                }, 5000);
            }
            $(parent).closest('.form').find('input[name="email"]').val('');
        },
        complete: function (data) {
            $(parent).removeClass('primary-bg-color').addClass('bg-gray-12').find('span').text(jsLang('Send').toUpperCase()).siblings('.reset-modal-loader').addClass('hidden');
            sendBtnClick = 0;
        }
    });
});

var userVerificationClick = 0;
$(document).on('click', 'a.user-verification', function() {
    if (++userVerificationClick > 1) {
        return;
    }

    var email = $(this).closest('.signin-form-container').find('input[name="email"]').val();
    var password = $(this).closest('.signin-form-container').find('input[name="password"]').val();
    var letter = email.substring(0,3);
    var domain = email.split('@')[1];
    resendCode(this);
    $.ajax({
        url: SITE_URL + "/resend-verification-code",
        type: "post",
        data: {
            _token: token,
            email: email,
            password: password
        },
        dataType: "JSON",
        success: function (data) {
            if (otpActive == 1) {
                resendCode($('.resend-verification-code'));
                $(".user-verification-form-container").show().find('span.verification-email').attr('data-email', email).text(letter + '...@' + domain);
                $(".signin-form-container, .send-email-form-container, .reset-otp-form-container, .c-tabs-nav, .confirm-password-form-container").hide();
                $('.register-active input[name="email"]').val(email);
                $('.register-active input[name="password"]').val(password);
            } else {
                $('.signin-message').addClass('text-green-400').text(jsLang('A verification link has been sent to the email address.'))
                setTimeout(() => {
                    $('.signin-message').removeClass('text-green-400').text('');
                }, 5000);
            }
        },
        complete: function(data) {
            userVerificationClick = 0;
        }
    });
})

var resetPasswordClick = 0;
$(".reset-password-btn").on('click', function () {
    if (++resetPasswordClick > 1) {
        return;
    }
    var parent = this;
    $(parent).removeClass('bg-gray-12').addClass('primary-bg-color').find('span').text('').siblings('.otp-modal-loader').removeClass('hidden');

    var otp = '';
    $('.otp-input-reset').each((k, v) => {
        otp += $(v).val();
    })
    otp = otp.trim();

    if (otp.length != 4) {
        resetPasswordClick = 0;

        $('label.reset-otp-form-msg').text(jsLang('All fields are required.'));
        $(parent).removeClass('primary-bg-color').addClass('bg-gray-12').find('span').text(jsLang('Reset Password').toUpperCase()).siblings('.otp-modal-loader').addClass('hidden');
        setTimeout(() => {
            $('label.reset-otp-form-msg').text('');
        }, 5000);
        return;
    }
    $.ajax({
        url: SITE_URL + "/password/reset-otp/" + otp,
        type: "get",
        dataType: "JSON",
        contentType: false,
        cache: false,
        processData: false,
        success: function (data) {
            if (data.status == 'success') {
                $(".confirm-password-form-container").show().find('input[name="id"]').val(data.id);
                $(".confirm-password-form-container input[name='token']").val(data.token);
                $(".signin-form-container, .send-email-form-container, .reset-otp-form-container, .c-tabs-nav, .user-verification-form-container").hide();
            } else {
                $('label.reset-otp-form-msg').text(data.message);
                $('.otp-input-reset').val('');
                setTimeout(() => {
                    $('label.reset-otp-form-msg').text('');
                }, 5000);
            }
        },
        complete: function(data) {
            $(parent).removeClass('primary-bg-color').addClass('bg-gray-12').find('span').text(jsLang('Reset Password').toUpperCase()).siblings('.otp-modal-loader').addClass('hidden');
            resetPasswordClick = 0
        }
    });
});

var passwordConfirmClick = 0;
$(".password-confirm-btn").on('click', function () {
    if (++passwordConfirmClick > 1) {
        return;
    }

    var parent = this;
    var status = true;
    var isPasswordValid = true;
    var errorMsg = "";
    var tmpMsg = [];

    if (uppercase && $("#password-reset-validation").val().search(/[A-Z]/) < 0) {
        tmpMsg.push(jsLang("uppercase"));
        status = isPasswordValid = false;
    }
    if (lowercase && $("#password-reset-validation").val().search(/[a-z]/) < 0) {
        tmpMsg.push(jsLang("lowercase"));
        status = isPasswordValid = false;
    }
    if (number && $("#password-reset-validation").val().search(/[0-9]/) < 0) {
        tmpMsg.push(jsLang("numbers"));
        status = isPasswordValid = false;
    }
    if (symbol && $("#password-reset-validation").val().search(/[#?!@$%^&*-]/) < 0) {
        tmpMsg.push(jsLang("symbols"));
        status = isPasswordValid = false;
    }

    if (tmpMsg.length > 0) {
        errorMsg = jsLang("Password must contain :x");
        errorMsg = errorMsg.replace(":x", tmpMsg.join(", "));
    }

    if (length && $("#password-reset-validation").val().length < length) {
        if (errorMsg.length > 0) {
            errorMsg = jsLang(
                "Password must contain :x and :y characters long."
            );
            errorMsg = errorMsg.replace(":x", tmpMsg.join(", "));
            errorMsg = errorMsg.replace(":y", length);
        } else {
            errorMsg = jsLang("Password must be at least :x characters.");
            errorMsg = errorMsg.replace(":x", length);
        }
        status = isPasswordValid = false;
    }

    if (status == false && !isPasswordValid) {
        passwordConfirmClick = 0;
        $(".password-validation-error")
            .removeClass("text-green-500")
            .addClass("text-red-500")
            .text(errorMsg);
    } else {
        var data = $(parent).closest('form').find('input').serialize();
        $(parent).removeClass('bg-gray-12').addClass('primary-bg-color').find('span').text('').siblings('.confirm-password-modal-loader').removeClass('hidden');

        $.ajax({
            url: SITE_URL + "/password/resets",
            type: "post",
            data: data,
            dataType: "JSON",
            success: function (data) {
                if (data.status == 'success') {
                    $(".password-reset-conf-container").show();
                    $(".signin-form-container, .send-email-form-container, .reset-otp-form-container, .confirm-password-form-container, .c-tabs-nav, .user-verification-form-container").hide();
                    setTimeout(function(){
                        $(".signin-form-container, .c-tabs-nav").show();
                        $(".send-email-form-container, .password-reset-conf-container, .reset-otp-form-container, .confirm-password-form-container, .user-verification-form-container").hide();

                        $(".login-message").removeClass("border border-reds-3");
                        $(".login-message").addClass(
                            "bg-green-2 p-2 md:p-2.5 mb-6 rounded border border-green-1"
                        ).html(`
                            <h1 class="roboto-medium font-medium text-11 md:text-15 ml-11 md:ml-52p text-green-1 whitespace-nowrap pass-status-mes">${data.message}</h1>
                            <span class="absolute top-7p left-2.5 md:top-1.5 border-r h-5 md:h-8 border-green-1 pl-0.5 md:pl-1.5 pr-3 pass-status-svg">
                                <svg class="mt-2 h-2 md:h-15p" xmlns="http://www.w3.org/2000/svg" width="19" height="15" viewBox="0 0 19 15" fill="none">
                                <path fill-rule="evenodd" clip-rule="evenodd" d="M18.3163 0.462473C17.5102 -0.242925 16.3121 -0.128557 15.6403 0.717921L8.80424 9.33189C8.14548 10.162 7.77515 10.6215 7.47948 10.9039C7.47564 10.9076 7.47188 10.9112 7.46818 10.9147C7.46419 10.9115 7.46013 10.9083 7.456 10.9051C7.13719 10.6519 6.72875 10.2295 6.00113 9.4654L3.2435 6.56972C2.5015 5.79059 1.29849 5.79059 0.556498 6.56972C-0.185497 7.34886 -0.185497 8.61209 0.556498 9.39123L3.31413 12.2869C3.34002 12.3141 3.36587 12.3412 3.39168 12.3684C4.01203 13.02 4.60881 13.6469 5.16407 14.0878C5.78606 14.5817 6.60062 15.0461 7.6445 14.9963C8.68838 14.9466 9.45955 14.4067 10.0364 13.8557C10.5514 13.3639 11.0916 12.6828 11.6532 11.9749C11.6766 11.9454 11.7 11.9159 11.7235 11.8864L18.5596 3.27239C19.2313 2.42592 19.1224 1.16787 18.3163 0.462473Z" fill="#009651"/>
                                </svg>
                            </span>
                        `);

                        $('.signin-form-container input[name="email"]').val($('.reset-otp-form-container span.email').attr('data-email'));
                        $('.signin-form-container input[name="password"]').val($("#password-reset-validation").val());

                    },3000);
                } else {
                    $('label.reset-otp-form-msg').text(data.message);
                    $('.otp-input-reset').val('');
                    setTimeout(() => {
                        $('label.reset-otp-form-msg').text('');
                    }, 5000);
                }
            },
            complete: function(data) {
                $(parent).removeClass('primary-bg-color').addClass('bg-gray-12').find('span').text(jsLang('Confirm').toUpperCase()).siblings('.confirm-password-modal-loader').addClass('hidden');
                passwordConfirmClick = 0
            }
        });
    }
});

var resendCodeClick = 0;
$('.resend-code').on('click', function() {
    if (++resendCodeClick > 1) {
        return;
    }

    resendCode(this);
    
    var contact = $('.resend-contact-info').text()
    $.ajax({
        url: SITE_URL + "/valid-mail/" + contact,
        type: "get",
        dataType: "JSON",
        contentType: false,
        cache: false,
        processData: false,
        success: function (data) {
        },
        complete: function(data) {
            resendCodeClick = 0
        }
    });
})

var resendVerificationCodeClick = 0;
$('.resend-verification-code').on('click', function() {
    if (++resendVerificationCodeClick > 1) {
        return;
    }
    resendCode(this);
    $.ajax({
        url: SITE_URL + "/resend-verification-code",
        type: "post",
        data: $('#password-validate-submit').find('input').serialize(),
        dataType: "JSON",
        success: function (data) {
        },
        complete: function(data) {
            resendVerificationCodeClick = 0;
        }
    });
})

var userVerificationBtnClick = 0;
$('.user-verification-btn').on('click', function() {
    if (++userVerificationBtnClick > 1) {
        return;
    }
    var parent = this;
    $(parent).removeClass('bg-gray-12').addClass('primary-bg-color').find('span').text('').siblings('.verification-modal-loader').removeClass('hidden');

    var otp = '';
    $('.otp-input-verification').each((k, v) => {
        otp += $(v).val();
    })
    otp = otp.trim();

    $.ajax({
        url: SITE_URL + "/user-verification/" + otp,
        type: "get",
        dataType: "JSON",
        contentType: false,
        cache: false,
        processData: false,
        success: function (data) {
            if (data.status == 'success') {
                $(".signin-form-container, .c-tabs-nav").show();
                $(".send-email-form-container, .reset-otp-form-container, .user-verification-form-container, .confirm-password-form-container").hide();

                $(".login-message").removeClass("border border-reds-3");
                $(".login-message").addClass(
                    "bg-green-2 p-2 md:p-2.5 mb-6 rounded border border-green-1"
                ).html(`
                    <h1 class="roboto-medium font-medium text-11 md:text-15 ml-11 md:ml-52p text-green-1 whitespace-nowrap pass-status-mes">${data.message}</h1>
                    <span class="absolute top-7p left-2.5 md:top-1.5 border-r h-5 md:h-8 border-green-1 pl-0.5 md:pl-1.5 pr-3 pass-status-svg">
                        <svg class="mt-2 h-2 md:h-15p" xmlns="http://www.w3.org/2000/svg" width="19" height="15" viewBox="0 0 19 15" fill="none">
                        <path fill-rule="evenodd" clip-rule="evenodd" d="M18.3163 0.462473C17.5102 -0.242925 16.3121 -0.128557 15.6403 0.717921L8.80424 9.33189C8.14548 10.162 7.77515 10.6215 7.47948 10.9039C7.47564 10.9076 7.47188 10.9112 7.46818 10.9147C7.46419 10.9115 7.46013 10.9083 7.456 10.9051C7.13719 10.6519 6.72875 10.2295 6.00113 9.4654L3.2435 6.56972C2.5015 5.79059 1.29849 5.79059 0.556498 6.56972C-0.185497 7.34886 -0.185497 8.61209 0.556498 9.39123L3.31413 12.2869C3.34002 12.3141 3.36587 12.3412 3.39168 12.3684C4.01203 13.02 4.60881 13.6469 5.16407 14.0878C5.78606 14.5817 6.60062 15.0461 7.6445 14.9963C8.68838 14.9466 9.45955 14.4067 10.0364 13.8557C10.5514 13.3639 11.0916 12.6828 11.6532 11.9749C11.6766 11.9454 11.7 11.9159 11.7235 11.8864L18.5596 3.27239C19.2313 2.42592 19.1224 1.16787 18.3163 0.462473Z" fill="#009651"/>
                        </svg>
                    </span>

                `);

                $('.signin-form-container input[name="email"]').val($('.register-active input[name="email"]').val());
                $('.signin-form-container input[name="password"]').val($('.register-active input[name="password"]').val());
            } else {
                $('label.verification-otp-form-msg').text(data.message);
                $('.otp-input-verification').val('');
                setTimeout(() => {
                    $('label.verification-otp-form-msg').text('');
                }, 5000);
            }
        },
        complete: function(data) {
            $(parent).removeClass('primary-bg-color').addClass('bg-gray-12').find('span').text(jsLang('Verify Account').toUpperCase()).siblings('.verification-modal-loader').addClass('hidden');
            userVerificationBtnClick = 0;
        }
    });
})

// Otp functionality on password recovery modal
let ele = document.querySelectorAll('.otp-input');
for (let i = 0; i < ele.length; i++) {
    ele[i].addEventListener("keyup",function() {
        if (ele[i].value.match(/[0-9]/g)) {
            if ( this.nextElementSibling) {
                this.nextElementSibling.focus();
            }
        }
        else {
            ele[i].value='';
            if(this.previousElementSibling){
                this.previousElementSibling.focus();
            }
        }
    })
 }

 $(document).on('change', '.registration-name', function() {
    $(".name-validation-error").text('');
 })

$(document).on('click', '.one-click-login', function() {
    let type = $(this).attr('data-type');
    demoCredentials = JSON.parse(demoCredentials);
    if (type == 'admin') {
        $('#login-email').val(demoCredentials['admin']['email']);
        $('#login-password').val(demoCredentials['admin']['password']);
    } else if (type == 'vendor') {
        $('#login-email').val(demoCredentials['vendor']['email']);
        $('#login-password').val(demoCredentials['vendor']['password']);
    } else if (type == 'customer') {
        $('#login-email').val(demoCredentials['customer']['email']);
        $('#login-password').val(demoCredentials['customer']['password']);
    }
    $('#loginForm').trigger('submit');
})

function updatePhoneEmailBox(htmlContent) {
    $('.phone-email-box').html(htmlContent);
    
    setDialCode('.phone-email-box', '.phone-email-box input[name="phone"]')
}

function resetPhoneEmailBox(htmlContent) {
    $('.reset-phone-email-box').html(htmlContent);
    $('.reset-phone-email-box').find('div').first().addClass('mt-4')
    $('.reset-phone-email-box').find('.signin-message').replaceWith($('<label>', {class: 'send-email-form'}))
    
    setDialCode('.reset-phone-email-box', '.reset-phone-email-box input[name="phone"]')
}

if ($('.need-login-email-section').length) {
    updatePhoneEmailBox($('.login-email-section').html());
    $('.phone-email-box input').attr('id', 'login-email')
    
    resetPhoneEmailBox($('.login-email-section').html());
    $('.reset-phone-email-box input').attr('name', 'email')
}

if ($('.need-login-phone-section').length) {
    updatePhoneEmailBox($('.login-phone-section').html());
    $('.phone-email-box input').attr('id', 'login-phone')
    
    resetPhoneEmailBox($('.login-phone-section').html());
    $('.reset-phone-email-box input').attr('name', 'phone')
}

$(document).on('click', '.enable-login-email-section, .enable-login-phone-section', function() {
    updatePhoneEmailBox($(this).hasClass('enable-login-email-section') ? $('.login-email-section').html() : $('.login-phone-section').html());
    resetPhoneEmailBox($(this).hasClass('enable-login-email-section') ? $('.login-email-section').html() : $('.login-phone-section').html());
});

$(document).on('keyup', 'input#phone', function () {
    $('.phone-validation-error').html('');
});
