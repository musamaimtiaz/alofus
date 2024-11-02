"use strict";
$(document).ready(function() {
    togglemenu();
    menuhrres();
    $('[data-toggle="tooltip"]').tooltip();
    $('[data-toggle="popover"]').popover();
    $(".mobile-menu").on('click', function() {
        var $this = $(this);
        $this.toggleClass('on');
    });

    $(".search-btn").on('click', function() {
        var $this = $(this);
        $(".main-search").addClass('open');
        $(".main-search .form-control").css({
            'width': '168px'
        });
    });
    $(".search-close").on('click', function() {
        var $this = $(this);
        $(".main-search").removeClass('open');
        $(".main-search .form-control").css({
            'width': '0'
        });
    });

    // Menu scroll
    if (!$('.pcoded-navbar').hasClass('theme-horizontal')) {
        var vw = $(window)[0].innerWidth;
        if (vw < 992 || $('.pcoded-navbar').hasClass('menupos-static')) {
            $(".navbar-content").slimScroll({
                setTop: "1px",
                size: '5px',
                wheelStep: 10,
                alwaysVisible: false,
                allowPageScroll: true,
                color: 'rgba(0,0,0,0.5)',
                height: "100%",
                width: "100%",
            });
        }else{
            $(".navbar-content").slimScroll({
                setTop: "1px",
                size: '5px',
                wheelStep: 10,
                alwaysVisible: false,
                allowPageScroll: true,
                color: 'rgba(0,0,0,0.5)',
                height: "calc(100vh - 70px)",
                width: "100%",
            });
        }
    }

    // apply matchHeight to each item container's items

    // remove pre-loader start
    setTimeout(function() {
        $('.loader-bg').fadeOut('slow', function() {
            $(this).remove();
        });
    }, 400);
    // remove pre-loader end

});
// Menu Dropdown icon
function drpicon(temp) {
    if (temp == "style1") {
        $('.pcoded-navbar').removeClassPrefix('drp-icon-');
    } else {
        $('.pcoded-navbar').removeClassPrefix('drp-icon-');
        $('.pcoded-navbar').addClass('drp-icon-' + temp);
    }
}
// Menu subitem icon
function menuitemicon(temp) {
    if (temp == "style1") {
        $('.pcoded-navbar').removeClassPrefix('menu-item-icon-');
    } else {
        $('.pcoded-navbar').removeClassPrefix('menu-item-icon-');
        $('.pcoded-navbar').addClass('menu-item-icon-' + temp);
    }
}
// ===============
$(window).on('resize', function() {
    togglemenu();
    menuhrres();
});
// menu [ horizontal configure ]
function menuhrres() {
    var vw = $(window)[0].innerWidth;
    if (vw < 768) {
        setTimeout(function() {
            $(".sidenav-horizontal-wrapper").addClass("sidenav-horizontal-wrapper-dis").removeClass("sidenav-horizontal-wrapper");
            $(".theme-horizontal").addClass("theme-horizontal-dis").removeClass("theme-horizontal");
        }, 400);
    } else {
        setTimeout(function() {
            $(".sidenav-horizontal-wrapper-dis").addClass("sidenav-horizontal-wrapper").removeClass("sidenav-horizontal-wrapper-dis");
            $(".theme-horizontal-dis").addClass("theme-horizontal").removeClass("theme-horizontal-dis");
        }, 400);
    }
}
var ost = 0;
$(window).on('scroll', function() {
    var vw = $(window)[0].innerWidth;
    if (vw >= 768) {
        var cOst = $(this).scrollTop();
        if (cOst == 400) {
            $('.theme-horizontal').addClass('top-nav-collapse');
        } else if (cOst > ost && 400 < ost) {
            $('.theme-horizontal').addClass('top-nav-collapse').removeClass('default');
        } else {
            $('.theme-horizontal').addClass('default').removeClass('top-nav-collapse');
        }
        ost = cOst;
    }
});

// toggle full screen
function toggleFullScreen() {
    var a = $(window).height() - 10;

    if (!document.fullscreenElement && // alternative standard method
        !document.mozFullScreenElement && !document.webkitFullscreenElement) { // current working methods
        if (document.documentElement.requestFullscreen) {
            document.documentElement.requestFullscreen();
        } else if (document.documentElement.mozRequestFullScreen) {
            document.documentElement.mozRequestFullScreen();
        } else if (document.documentElement.webkitRequestFullscreen) {
            document.documentElement.webkitRequestFullscreen(Element.ALLOW_KEYBOARD_INPUT);
        }
    } else {
        if (document.cancelFullScreen) {
            document.cancelFullScreen();
        } else if (document.mozCancelFullScreen) {
            document.mozCancelFullScreen();
        } else if (document.webkitCancelFullScreen) {
            document.webkitCancelFullScreen();
        }
    }
    $('.full-screen > i').toggleClass('icon-maximize');
    $('.full-screen > i').toggleClass('icon-minimize');
}
// =============  layout builder   =============
$.fn.pcodedmenu = function(settings) {
    var oid = this.attr("id");
    var defaults = {
        themelayout: 'vertical',
        MenuTrigger: 'click',
        SubMenuTrigger: 'click',
    };
    var settings = $.extend({}, defaults, settings);
    var PcodedMenu = {
        PcodedMenuInit: function() {
            PcodedMenu.HandleMenuTrigger();
            PcodedMenu.HandleSubMenuTrigger();
            PcodedMenu.HandleOffset();
        },
        HandleSubMenuTrigger: function() {
            var $window = $(window);
            var newSize = $window.width();
            if ($('.pcoded-navbar').hasClass('theme-horizontal') == true) {
                if (newSize >= 768) {
                    var $dropdown = $(".pcoded-inner-navbar .pcoded-submenu > li.pcoded-hasmenu");
                    $dropdown.off('click').off('mouseenter mouseleave').hover(
                        function() {
                            $(this).addClass('pcoded-trigger');
                        },
                        function() {
                            $(this).removeClass('pcoded-trigger');
                        }
                    );
                } else {
                    var $dropdown = $(".pcoded-inner-navbar .pcoded-submenu > li > .pcoded-submenu > li");
                    $dropdown.off('mouseenter mouseleave').off('click').on('click',
                        function() {
                            var str = $(this).closest('.pcoded-submenu').length;
                            if (str === 0) {
                                if ($(this).hasClass('pcoded-trigger')) {
                                    $(this).removeClass('pcoded-trigger');
                                    $(this).children('.pcoded-submenu').slideUp();
                                } else {
                                    $('.pcoded-submenu > li > .pcoded-submenu > li.pcoded-trigger').children('.pcoded-submenu').slideUp();
                                    $(this).closest('.pcoded-inner-navbar').find('li.pcoded-trigger').removeClass('pcoded-trigger');
                                    $(this).addClass('pcoded-trigger');
                                    $(this).children('.pcoded-submenu').slideDown();
                                }
                            } else {
                                if ($(this).hasClass('pcoded-trigger')) {
                                    $(this).removeClass('pcoded-trigger');
                                    $(this).children('.pcoded-submenu').slideUp();
                                } else {
                                    $('.pcoded-submenu > li > .pcoded-submenu > li.pcoded-trigger').children('.pcoded-submenu').slideUp();
                                    $(this).closest('.pcoded-submenu').find('li.pcoded-trigger').removeClass('pcoded-trigger');
                                    $(this).addClass('pcoded-trigger');
                                    $(this).children('.pcoded-submenu').slideDown();
                                }
                            }
                        });
                    $(".pcoded-submenu > li").on('click', function(e) {
                        e.stopPropagation();
                        var str = $(this).closest('.pcoded-submenu').length;
                        if (str === 0) {
                            if ($(this).hasClass('pcoded-trigger')) {
                                $(this).removeClass('pcoded-trigger');
                                $(this).children('.pcoded-submenu').slideUp();
                            } else {
                                $('.pcoded-hasmenu li.pcoded-trigger').children('.pcoded-submenu').slideUp();
                                $(this).closest('.pcoded-inner-navbar').find('li.pcoded-trigger').removeClass('pcoded-trigger');
                                $(this).addClass('pcoded-trigger');
                                $(this).children('.pcoded-submenu').slideDown();
                            }
                        } else {
                            if ($(this).hasClass('pcoded-trigger')) {
                                $(this).removeClass('pcoded-trigger');
                                $(this).children('.pcoded-submenu').slideUp();
                            } else {
                                $('.pcoded-hasmenu li.pcoded-trigger').children('.pcoded-submenu').slideUp();
                                $(this).closest('.pcoded-submenu').find('li.pcoded-trigger').removeClass('pcoded-trigger');
                                $(this).addClass('pcoded-trigger');
                                $(this).children('.pcoded-submenu').slideDown();
                            }
                        }
                    });
                }
            }
            switch (settings.SubMenuTrigger) {
                case 'click':
                    $('.pcoded-navbar .pcoded-hasmenu').removeClass('is-hover');
                    $(".pcoded-inner-navbar .pcoded-submenu > li > .pcoded-submenu > li").on('click', function(e) {
                        e.stopPropagation();
                        var str = $(this).closest('.pcoded-submenu').length;
                        if (str === 0) {
                            if ($(this).hasClass('pcoded-trigger')) {
                                $(this).removeClass('pcoded-trigger');
                                $(this).children('.pcoded-submenu').slideUp();
                            } else {
                                $('.pcoded-submenu > li > .pcoded-submenu > li.pcoded-trigger').children('.pcoded-submenu').slideUp();
                                $(this).closest('.pcoded-inner-navbar').find('li.pcoded-trigger').removeClass('pcoded-trigger');
                                $(this).addClass('pcoded-trigger');
                                $(this).children('.pcoded-submenu').slideDown();
                            }
                        } else {
                            if ($(this).hasClass('pcoded-trigger')) {
                                $(this).removeClass('pcoded-trigger');
                                $(this).children('.pcoded-submenu').slideUp();
                            } else {
                                $('.pcoded-submenu > li > .pcoded-submenu > li.pcoded-trigger').children('.pcoded-submenu').slideUp();
                                $(this).closest('.pcoded-submenu').find('li.pcoded-trigger').removeClass('pcoded-trigger');
                                $(this).addClass('pcoded-trigger');
                                $(this).children('.pcoded-submenu').slideDown();
                            }
                        }
                    });
                    $(".pcoded-submenu > li").on('click', function(e) {
                        e.stopPropagation();
                        var str = $(this).closest('.pcoded-submenu').length;
                        if (str === 0) {
                            if ($(this).hasClass('pcoded-trigger')) {
                                $(this).removeClass('pcoded-trigger');
                                $(this).children('.pcoded-submenu').slideUp();
                            } else {
                                $('.pcoded-hasmenu li.pcoded-trigger').children('.pcoded-submenu').slideUp();
                                $(this).closest('.pcoded-inner-navbar').find('li.pcoded-trigger').removeClass('pcoded-trigger');
                                $(this).addClass('pcoded-trigger');
                                $(this).children('.pcoded-submenu').slideDown();
                            }
                        } else {
                            if ($(this).hasClass('pcoded-trigger')) {
                                $(this).removeClass('pcoded-trigger');
                                $(this).children('.pcoded-submenu').slideUp();
                            } else {
                                $('.pcoded-hasmenu li.pcoded-trigger').children('.pcoded-submenu').slideUp();
                                $(this).closest('.pcoded-submenu').find('li.pcoded-trigger').removeClass('pcoded-trigger');
                                $(this).addClass('pcoded-trigger');
                                $(this).children('.pcoded-submenu').slideDown();
                            }
                        }
                    });
                    break;
            }
        },
        HandleMenuTrigger: function() {
            var $window = $(window);
            var newSize = $window.width();
            if ($('.pcoded-navbar').hasClass('theme-horizontal') == true) {
                var $dropdown = $(".pcoded-inner-navbar > li");
                if (newSize >= 768) {
                    $dropdown.off('click').off('mouseenter mouseleave').hover(
                        function() {
                            $(this).addClass('pcoded-trigger');
                            if ($('.pcoded-submenu', this).length) {
                                var elm = $('.pcoded-submenu:first', this);
                                var off = elm.offset();
                                var l = off.left;
                                var w = elm.width();
                                var docH = $(window).height();
                                var docW = $(window).width();

                                var isEntirelyVisible = (l + w <= docW);
                                if (!isEntirelyVisible) {
                                    var temp = $('.sidenav-inner').attr('style');
                                    $('.sidenav-inner').css({'margin-left': (parseInt(temp.slice(12, temp.length - 3)) - 80)});
                                    $('.sidenav-horizontal-prev').removeClass('disabled');
                                } else {
                                    $(this).removeClass('edge');
                                }
                            }
                        },
                        function() {
                            $(this).removeClass('pcoded-trigger');
                        }
                    );
                } else {
                    $dropdown.off('mouseenter mouseleave').off('click').on('click',
                        function() {
                            if ($(this).hasClass('pcoded-trigger')) {
                                $(this).removeClass('pcoded-trigger');
                                $(this).children('.pcoded-submenu').slideUp();
                            } else {
                                $('li.pcoded-trigger').children('.pcoded-submenu').slideUp();
                                $(this).closest('.pcoded-inner-navbar').find('li.pcoded-trigger').removeClass('pcoded-trigger');
                                $(this).addClass('pcoded-trigger');
                                $(this).children('.pcoded-submenu').slideDown();
                            }
                        }
                    );
                }
            }
            switch (settings.MenuTrigger) {
                case 'click':
                    $('.pcoded-navbar').removeClass('is-hover');
                    $(".pcoded-inner-navbar > li ").on('click', function() {
                        if ($(this).hasClass('pcoded-trigger')) {
                            $(this).removeClass('pcoded-trigger');
                            $(this).children('.pcoded-submenu').slideUp();
                        } else {
                            $('li.pcoded-trigger').children('.pcoded-submenu').slideUp();
                            $(this).closest('.pcoded-inner-navbar').find('li.pcoded-trigger').removeClass('pcoded-trigger');
                            $(this).addClass('pcoded-trigger');
                            $(this).children('.pcoded-submenu').slideDown();
                        }
                    });
                    break;
            }
        },
        HandleOffset: function() {
            switch (settings.themelayout) {
                case 'horizontal':
                    var trigger = settings.SubMenuTrigger;
                    if (trigger === "hover") {
                        $("li.pcoded-hasmenu").on('mouseenter mouseleave', function(e) {
                            if ($('.pcoded-submenu', this).length) {
                                var elm = $('.pcoded-submenu:first', this);
                                var off = elm.offset();
                                var l = off.left;
                                var w = elm.width();
                                var docH = $(window).height();
                                var docW = $(window).width();

                                var isEntirelyVisible = (l + w <= docW);
                                if (!isEntirelyVisible) {
                                    $(this).addClass('edge');
                                } else {
                                    $(this).removeClass('edge');
                                }
                            }
                        });
                    } else {
                        $("li.pcoded-hasmenu").on('click', function(e) {
                            e.preventDefault();
                            if ($('.pcoded-submenu', this).length) {
                                var elm = $('.pcoded-submenu:first', this);
                                var off = elm.offset();
                                var l = off.left;
                                var w = elm.width();
                                var docH = $(window).height();
                                var docW = $(window).width();

                                var isEntirelyVisible = (l + w <= docW);
                                if (!isEntirelyVisible) {
                                    $(this).toggleClass('edge');
                                }
                            }
                        });
                    }
                    break;
                default:
            }
        },
    };
    PcodedMenu.PcodedMenuInit();
};
$("#pcoded").pcodedmenu({
    MenuTrigger: 'click',
    SubMenuTrigger: 'click',
});
// menu [ Mobile ]
$("#mobile-collapse,#mobile-collapse1").click(function(e) {
    var vw = $(window)[0].innerWidth;
    if (vw < 992) {
        $(".pcoded-navbar").toggleClass('mob-open');
        e.stopPropagation();
    }
});
$(window).ready(function() {
    $('#mobile-collapse,.navbar-collapsed~.pcoded-main-container,.pcoded-main-container:before, .navbar-collapsed~.pcoded-header,.pcoded-header:before').on("click tap", function() {
    });
    var vw = $(window)[0].innerWidth;
    $(".pcoded-navbar").on('click tap', function(e) {
        e.stopPropagation();
    });
    $('.pcoded-main-container,.pcoded-header').on("click", function() {
        if (vw < 992) {
            if ($(".pcoded-navbar").hasClass("mob-open") == true) {
                $(".pcoded-navbar").removeClass('mob-open');
                $("#mobile-collapse,#mobile-collapse1").removeClass('on');
            }
        }
    });
    // mobile header
    $("#mobile-header").on('click', function() {
        $(".navbar-collapse,.m-header").slideToggle();
    });
});

$("#mobile-collapse").on('click', function() {
    var navbarCollapsed = 'closed';
    if ($(".pcoded-navbar").hasClass("navbar-collapsed")) {
        navbarCollapsed = 'open';
    }
    localStorage.setItem("is-navbar-collapsed", navbarCollapsed);
    $(".pcoded-navbar").toggleClass("navbar-collapsed");
});

// menu [ compact ]
function togglemenu() {
    var vw = $(window)[0].innerWidth;
    if ($(".pcoded-navbar").hasClass('theme-horizontal') == false) {
        var navbarCollapsed = localStorage.getItem("is-navbar-collapsed");
        if (vw >= 992 && navbarCollapsed == 'closed') {
            $(".pcoded-navbar").addClass("navbar-collapsed");
        } else if (vw <= 1280 && navbarCollapsed == null) {
            $(".pcoded-navbar").addClass("navbar-collapsed");
        } else {
            $(".pcoded-navbar").removeClass("navbar-collapsed");
        }
        if (vw < 992) {
            $(".pcoded-navbar").removeClass("navbar-collapsed");
        }
    }
}

var preNumber = 0;

$(document).on("keydown", ".positive-float-number", function () {
    preNumber = $(this).val();
    if (preNumber == "") {
        preNumber = 0;
    }
})

$(document).on("keyup", ".positive-int-number", function () {
    var number = $(this).val();
    $(this).val(number.replace(/[^0-9]/g, ""));
});
$(document).on("keyup", ".phone-number", function () {
    var phone = $(this).val();
    $(this).val(phone.replace(/[^0-9\-\,\+ ]/g, ""));
});

$(document).on("keyup", ".positive-float-number", function () {
    var number = $(this).val();
    if (thousand_separator == '.') {
        if (number.split(",").length > 2 || number.split("-").length > 1) {
            $(this).val(preNumber).trigger("keyup");
        } else {
            $(this).val(number.replace(/[^0-9,]/g, ""));
        }
    } else {
        if (number.split(".").length > 2 || number.split("-").length > 1) {
            $(this).val(preNumber).trigger("keyup");
        } else {
            $(this).val(number.replace(/[^0-9.]/g, ""));
        }
    }
});

function decimalNumberFormatWithCurrency(number = 0) {
    var num = getDecimalNumberFormat(number);
    if (symbol_position == 'before') {
        return currencySymbol + num;
    } else {
        return num + currencySymbol;
    }
}

function getDecimalNumberFormat(num = 0)
{
    if (thousand_separator != null && decimal_digits != null && num != null) {
        var numArray = num.toString().split('.');
        if (numArray.length > 1) {
            num = numArray[0] + '.' + numArray[1].substring(0, decimal_digits);
        }
        num = parseFloat(num).toFixed(decimal_digits);
        if (thousand_separator == '.') {
            num = numberWithDot(num);
        } else if (thousand_separator == ',') {
            num = numberWithCommas(num);
        }
    }
    return num;
}

function numberWithCommas(x)
{
    var parts = x.toString().split(".");
    parts[0] = parts[0].replace(/\B(?=(\d{3})+(?!\d))/g, ",");
    return parts.join(".");
}

function numberWithDot(x)
{
    var parts = x.toString().split(".");
    parts[0] = parts[0].replace(/\B(?=(\d{3})+(?!\d))/g, ".");
    return parts.join(",");
}

function validateNumbers(number) {
    if (number != "" && number != undefined) {
        if (thousand_separator == ".") {
            number = number.replace(/\./g, '');
            number = (number.toString()).replace(",", ".");
        } else {
            number = number.replace(/\,/g, '');
        }
        return number.replace(/[^0-9,.]+/g, "");
    }
    return 0;
}

function getMonthNumber(month) {
    var months = ["January", "February", "March", "April", "May", "June",
      "July", "August", "September", "October", "November", "December"
    ];
    var monthNumber = months.indexOf(month);
    return ++monthNumber;
}

    $(".navbar-content").slimScroll({
        setTop: "1px",
        size: '5px',
        wheelStep: 10,
        alwaysVisible: false,
        allowPageScroll: true,
        color: 'rgba(0,0,0,0.5)',
        height: "calc(100vh - 70px)",
        width: "100%",
        start: "bottom",
    });

// jQuery plugin to prevent double submission of forms
jQuery.fn.preventDoubleSubmission = function() {
  $(this).on('submit',function(e){
    var $form = $(this);

    if ($form.data('submitted') === true) {
      // Previously submitted - don't submit again
      e.preventDefault();
    } else {
      // Mark it so that the next submit can be ignored
      $form.data('submitted', true);
    }
  });

  // Keep chainability
  return this;
};

// Sanitize string
function jsSanitize(string) {
  return String(string).replace(/<(|\/|[^>\/bi]|\/[^>bi]|[^\/>][^>]+|\/[^>][^>]+)>/g, '');
}

$(".card-option .close-card").on('click', function() {
    var $this = $(this);
    $this.parents('.card').addClass('anim-close-card');
    $this.parents('.card').animate({
        'margin-bottom': '0',
    });
    setTimeout(function() {
        $this.parents('.card').children('.card-block').slideToggle();
        $this.parents('.card').children('.card-body').slideToggle();
        $this.parents('.card').children('.card-header').slideToggle();
        $this.parents('.card').children('.card-footer').slideToggle();
    }, 600);
    setTimeout(function() {
        $this.parents('.card').remove();
    }, 1500);
});
// reload card
$(".card-option .reload-card").on('click', function() {
    var $this = $(this);
    $this.parents('.card').addClass("card-load");
    $this.parents('.card').append('<div class="card-loader"><i class="pct-loader1 anim-rotate"></div>');
    setTimeout(function() {
        $this.parents('.card').children(".card-loader").remove();
        $this.parents('.card').removeClass("card-load");
    }, 3000);
});
// collpased and expaded card
$(".card-option .minimize-card").on('click', function() {
    var $this = $(this);
    var port = $($this.parents('.card'));
    var card = $(port).children('.card-block').slideToggle();
    var card = $(port).children('.card-body').slideToggle();
    if (!port.hasClass('full-card')) {
        $(port).css("height", "auto");
    }
    $(this).children('a').children('span').toggle();
});
// full card
$(".card-option .full-card").on('click', function() {
    var $this = $(this);
    var port = $($this.parents('.card'));
    port.toggleClass("full-card");
    $(this).children('a').children('span').toggle();
    if (port.hasClass('full-card')) {
        $('body').css('overflow', 'hidden');
        $('html,body').animate({
            scrollTop: 0
        }, 1000);
        var elm = $(port, this);
        var off = elm.offset();
        var l = off.left;
        var t = off.top;
        var docH = $(window).height();
        var docW = $(window).width();
        port.animate({
            'marginLeft': l - (l * 2),
            'marginTop': t - (t * 2),
            'width': docW,
            'height': docH,
        });
    } else {
        $('body').css('overflow', '');
        port.removeAttr('style');
        setTimeout(function() {
            $('html,body').animate({
                scrollTop: $(port).offset().top
            }, 500);
        }, 400);
    }
});

// Check minimum number
function minimumNumber(inputField) {
    var value = Number($(inputField).val());
    var min = Number($(inputField).attr('data-min'));
    if (value < min) {
        $(inputField).val(min);
    }
}

// Check maximum number
function maximumNumber(inputField) {
    var value = Number($(inputField).val());
    var max = Number($(inputField).attr('data-max'));
    if (value > max) {
        $(inputField).val(max);
    }
}

$(document).on('blur', '.input-box-limit', function() {
    minimumNumber(this);
    maximumNumber(this);
})

$(document).on('keyup', '.input-box-limit', function() {
    maximumNumber(this);
})
