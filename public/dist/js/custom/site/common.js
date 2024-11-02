"use strict";
/* It's using for actual form data where need not necessary any kind of change */
function clickOnSaveForm(url = null, method = null, data = [], successMessage = null, redirect = null)
{
    $.ajax({
        type: method,
        url: SITE_URL + url,
        data:data,
        dataType:'JSON',
        contentType: false,
        cache: false,
        processData: false,
        success: function (data) {
            const Toast = Swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true,
                didOpen: (toast) => {
                    toast.addEventListener('mouseenter', Swal.stopTimer)
                    toast.addEventListener('mouseleave', Swal.resumeTimer)
                }
            });
            if (data.status == 1) {
                if (successMessage != null && successMessage.length > 0) {
                    Toast.fire({
                        icon: 'success',
                        title: jsLang(successMessage)
                    })

                } else {
                    Toast.fire({
                        icon: 'success',
                        title: jsLang('Successfully Saved')
                    })
                }
                if (redirect != null && redirect.length > 0) {
                    window.location.href = SITE_URL + redirect;
                }
            } else if(typeof (data.error != undefined)) {
                Toast.fire({
                    icon: 'error',
                    title: data.error
                })
            } else {
                Toast.fire({
                    icon: 'error',
                    title: jsLang('Something went wrong, please try again.')
                })
            }
        }
    });

}


function setCookie(cname, cvalue, exdays) {
    const d = new Date();
    d.setTime(d.getTime() + (exdays * 24 * 60 * 60 * 1000));
    let expires = "expires="+d.toUTCString();
    document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/";
}

function getCookie(cname) {
    let name = cname + "=";
    let ca = document.cookie.split(';');
    for(let i = 0; i < ca.length; i++) {
      let c = ca[i];
      while (c.charAt(0) == ' ') {
        c = c.substring(1);
      }
      if (c.indexOf(name) == 0) {
        return c.substring(name.length, c.length);
      }
    }
    return "";
}

/**Cookies Modal functionality  start**/
setTimeout(function () {
    if (!getCookie("cookiePermission")) {
        $('.cookies-modal').show();
    }
}, 500);

function cookiesModalHidden() {
    setCookie("cookiePermission", true, 30);
    $('.cookies-modal').hide();
}
/**Cookies Modal functionality  end**/

if ($('.main-body .page-wrapper').find('#user-dashboard-container').length) {
    $('#removeWelcome').on('click', function() {
        $.ajax({
            url: SITE_URL + '/user/hide-welcome-message',
            type: "GET"
        });
    })

    var currentTime = new Date();
    var hours = currentTime.getHours();
    if (hours >= 1 && hours <= 11) {
        $('.welcome-message').text(jsLang('Good Morning'));
    } else if (hours > 11 && hours <= 14) {
        $('.welcome-message').text(jsLang('Good Noon'));
    } else if (hours > 14 && hours <= 17) {
        $('.welcome-message').text(jsLang('Good Afternoon'));
    } else {
        $('.welcome-message').text(jsLang('Good Evening'));
    }

}

