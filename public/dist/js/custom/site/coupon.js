"use strict";

    var showChar = 200; // How many characters are shown by default
    var ellipsesText = "...";
    var moreText = jsLang("Show more");
    var lessText = jsLang("Show less");

    $('.more').each(function() {
        var content = $(this).html().trim();
        if (content.length > showChar) {

            var c = content.substr(0, showChar);
            var h = content.substr(showChar, content.length - showChar);
            var html = c + '<span class="moreellipses">' + ellipsesText +
                '&nbsp;</span><span class="more-content"><span>' + h +
                '</span>&nbsp;&nbsp;<a href="#" class="more-link roboto-medium text-gray-12 underline">' +
                moreText + '</a></span>';
            $(this).html(html);
        }

    });

    $(".more-link").on('click', function() {
        if ($(this).hasClass("less")) {
            $(this).removeClass("less");
            $(this).html(moreText);
        } else {
            $(this).addClass("less");
            $(this).html(lessText);
        }
        $(this).parent().prev().toggle();
        $(this).prev().toggle();
        return false;
    });


new WOW().init();
function copyToClipboard(element) {
  var $temp = $("<input>");
  $("body").append($temp);
  $temp.val($(element).text()).select();
  document.execCommand("copy");
  $temp.remove();
}
$('.copy-button').on('click', function() {
    copyToClipboard($($(this).closest('.coupon-card')).find('#coupon-code'));
    let copyText = $($(this).closest('.coupon-card')).find('#copied-message');
    copyText.html("Copied!");
    copyText.css("display", "block")
    setTimeout(function() {
        copyText.fadeOut();
    }, 1000);
});

function movement(iconId) {
    let el = document.getElementById(iconId)
    const height = el.clientHeight
    const width = el.clientWidth
    el.addEventListener('mousemove', handleMove)

    function handleMove(e) {
        const xVal = e.layerX
        const yVal = e.layerY
        const yRotation = 30 * ((xVal - width / 2) / width)
        const xRotation = -30 * ((yVal - height / 2) / height)
        const string = 'perspective(500px) scale(1.1) rotateX(' + xRotation + 'deg) rotateY(' + yRotation + 'deg)'
        el.style.transform = string
    }
    el.addEventListener('mouseout', function() {
        el.style.transform = 'perspective(500px) scale(1) rotateX(0) rotateY(0)'
    })
    el.addEventListener('mousedown', function() {
        el.style.transform = 'perspective(500px) scale(0.5) rotateX(0) rotateY(0)'
    })
    el.addEventListener('mouseup', function() {
        el.style.transform = 'perspective(500px) scale(1.1) rotateX(0) rotateY(0)'
    })
}
movement('shopping_bag');
movement('cart');
movement('hand');