"use strict";
$(function () {
    $(".error").hide();
    document.cookie = "scrwid=" + window.innerWidth;
    document.cookie =
        "collapsedNavbar=" +
        $(".pcoded-navbar").hasClass("navbar-collapsed").toString();

    if ($('.select2default').length > 0) {
        $(".select2default").select2();
    }
    if ($('.select2-hide-search').length > 0) {
        $(".select2-hide-search").select2({
            minimumResultsForSearch: Infinity
        });
    }
    });

// customer_header.blade.php
$('.lang').on('click', function() {
    var lang = $(this).data('shortname');
    var url = ADMIN_SITE_URL + '/change-lang';
    $.ajax({
        url: url,
        data: {
            _token: token,
            lang: lang,
            type: "admin",
        },
        type: "POST",
        success: function (data) {
            if (data == 1) {
                location.reload();
            }
            if (data.status == 'info') {
                $('.top-notification').removeClass('d-none').find('.alert').addClass('alert-info').removeClass('alert-danger').find('.alertText').text(data.message);
            }
        },
        error: function (xhr, desc, err) {
            return 0;
        },
    });
});

// header.blade.php
$(document).on("click", "#itemNotifications", function () {
    $("#notifications").html(
        '<img id="itemNotificationsLoader" src="' +
            SITE_URL +
            '/public/dist/img/loader/spiner.gif" />'
    );
    $.ajax({
        url: SITE_URL + "/item-notifications",
        method: "GET",
        success: function (data) {
            var itemNotifications = JSON.parse(data);
            var liElements = "";
            var counter = 0;
            $.each(itemNotifications, function (index, value) {
                liElements +=
                    '<li class="notification">' +
                    '<div class="media">' +
                    '<i class="fas fa-exclamation-triangle triangle-exclamation"></i>' +
                    '<div class="media-body">' +
                    '<p class="mr-20">Item Name :<strong>' +
                    value.name +
                    '</strong><span class="n-time text-muted"></p>' +
                    "<p>Quantity : <strong>" +
                    value.qty +
                    "</strong></p>" +
                    "</div>" +
                    "</div>" +
                    "</li>";
                counter++;
            });
            $("#itemCount").text(counter);
            $("#notifications").html(liElements);
        },
    });
});


/**
 * Dashboard POPUP handler
 */
$(function () {
    const dashPopup = $(".dash-popup-modal");
    const popUpContent = $(".dash-popup-modal .card-content");
    const popupLoader = $(".dash-popup-modal .card-loader");
    const dashboardPopupData = {};


    $(document).on("mouseenter", ".has-dash-popup", function (event) {
        setTimeout(() => {
            if (this.matches(":hover")) {
                var cord = this.getBoundingClientRect();
                dashPopup[0].style.left = cord.x + "px";
                dashPopup[0].style.top = cord.y + 40 + "px";
                dashPopup.addClass("popup-active");
                fillPopupData($(this).data("url"));
            }
        }, 1000);
    });

    $(document).on("mouseleave", ".has-dash-popup", function () {
        setTimeout(() => {
            clearPopup(this);
        }, 500);
    });

    dashPopup.mouseout(function () {
        setTimeout(() => {
            clearPopup(dashPopup[0]);
        }, 500);
    });

    const clearPopup = async (item = null) => {
        if (!item.matches(":hover") && !dashPopup[0].matches(":hover")) {
            dashPopup.removeClass("popup-active");
            popUpContent[0].innerHTML = "";
            popupLoader.removeClass("d-none");
        }
    };

    const fillPopupData = (url) => {
        if (dataAlreadyFetched(url)) {
            return updatePopupContent(getFromFetchedData(url));
        }
        fetch(url, {
            headers: {
                "Content-Type": "application/json",
                Accept: "application/json",
            },
        })
            .then((res) => res.json())
            .then((val) => {
                updatePopupContent(val.response.records);
                dashboardPopupData[url] = val.response.records;
            });
    };
    const updatePopupContent = async (_data) => {
        await popUpContent.html(_data);
        await popupLoader.addClass("d-none");
        let cords = getPlaceableCords(dashPopup[0].getBoundingClientRect());
        dashPopup[0].style.left = cords.x + "px";
        dashPopup[0].style.top = cords.y + "px";
    };

    const getPlaceableCords = (_cord) => {
        let wCord = {
            h: window.innerHeight,
            w: window.innerWidth,
        };
        return {
            x: getXCord(wCord, _cord),
            y: getYCord(wCord, _cord),
        };
    };

    const getXCord = (_wCord, _cord) => {
        if (_cord.x + _cord.width + 10 <= _wCord.w) {
            return _cord.x;
        }
        return getXCord(_wCord, {
            x: _cord.x - 10,
            width: _cord.width,
        });
    };

    const getYCord = (_wCord, _cord) => {
        if (_cord.y + _cord.height + 10 <= _wCord.h) {
            return _cord.y;
        }
        return getYCord(_wCord, {
            y: _cord.y - 10,
            height: _cord.height,
        });
    };

    function dataAlreadyFetched(url) {
        if (dashboardPopupData[url] == undefined) {
            return false;
        }
        return true;
    }

    function getFromFetchedData(url) {
        return dashboardPopupData[url];
    }
});

let currentValue = null ;
let buttonValue = '';
let deleteValue = $('#confirmDeleteSubmitBtn').text();

$(document).on('submit', 'form', function() {
    if ($(this).hasClass("silent-form")) {
        return;
    }
    currentValue = $(this);
    buttonValue = $(this).find(':submit').text();
   let buttonText = buttonValue.toLowerCase().trim();
    if (!this.hasAttribute("onsubmit")) {

       if (buttonText == 'update') {
            setText($(this), 'Updating')
        } else if (buttonText == 'save') {
            setText($(this), 'Saving')
        } else if (buttonText == 'submit') {
            setText($(this), 'Submitting')
        } else if (buttonText == 'open') {
            setText($(this), 'Opening')
        }else if (buttonText == 'reply') {
            setText($(this), 'Replying')
        } else if (buttonText == 'create') {
            setText($(this), 'Creating')
        } else {
            setText($(this), buttonValue)
        }
        $(this).find(':submit').addClass('disabled-btn');
    }

});

function setText(selector, value) {
    selector.find(':submit').text(jsLang(value)).append(`<div class="spinner-border spinner-border-sm ml-2" role="status"></div>`);
}

$(document).on('click', '#confirmDeleteSubmitBtn', function() {
    deleteValue = $(this).text()
    let buttonText = deleteValue.toLowerCase().trim();
    $(this).text(jsLang('Deleting')).append(`<div class="spinner-border spinner-border-sm ml-2" role="status"></div>`).addClass('disabled-btn');
    if (buttonText == 'yes') {
        $(this).text(jsLang('Updating')).append(`<div class="spinner-border spinner-border-sm ml-2" role="status"></div>`).addClass('disabled-btn');
    }

});

$( document ).ajaxStop(function() {
    if (currentValue != null) {
        currentValue.find(':submit').removeClass('disabled-btn');
        currentValue.find(':submit').text(jsLang(buttonValue));
    }
    $('.spinner-border').remove();
    $('#confirmDeleteSubmitBtn').text(deleteValue).removeClass('disabled-btn');
});


if ($(".import-table").length > 0) {
    $(".import-table .select2").select2();
}

if (!$(".main-body .page-wrapper").find("#export-container").length) {
    $(".select2").select2({})
}

$(".select2-hide-search").select2({
    minimumResultsForSearch: Infinity
});

$('.notification-close').on('click', function () {
    $(this).closest('.top-notification').addClass('d-none');
})
// Add the following code if you want the name of the file appear on select
$(".custom-file-input").on("change", function() {
    var fileName = $(this).val().split("\\").pop();
    $(this).siblings(".custom-file-label").addClass("selected").html(fileName);
});


$(".custom-file-label").attr("data-before", `${jsLang('Browse')}`);

$('.btn-loader').on('click', function() {
    $(this).append(`<span class="spinner-border spinner-border-sm ml-1" role="status"></span>`);

    setTimeout(() => {
        $(this).find('.spinner-border').remove();
    }, 5000);
})

function loadToolTip() {
    // Tooltip initialize
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
    tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl)
    })
}

function loadPopOver() {
   // Popover initialize
   var popoverTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="popover"]'))
   popoverTriggerList.map(function (popoverTriggerEl) {
       return new bootstrap.Popover(popoverTriggerEl)
   }) 
}

if ($('.yajra-data-table-main').length) {
    $(document).ajaxComplete(function(event, xhr, settings) {
        if (settings.url.split('?')[0] == '' || window.location.href.split('?')[0] == settings.url.split('?')[0]) {
            loadToolTip();
            loadPopOver();
        }
    });
} else {
    loadToolTip();
    loadPopOver();
}

$('.header-notification-icon').on('click', function() {
    if ($(this).attr('data-bs-toggle') !== 'dropdown' || !$(this).hasClass('show')) {
        return;
    }
    
    $(this).attr('data-bs-toggle', 'dropdown-change');
    $.ajax({
        url: SITE_URL + '/notifications/ajax-loading',
        type: "GET",
        beforeSend: function() {
            $('.header-notification-body').html($('.notification-loader').html());
        },
        success: function (data) {
            $('.header-notification-body').html(data.data);
        },
        complete: function () {
            $('.header-notification-icon').attr('data-bs-toggle', 'dropdown');
        },
    });
})
