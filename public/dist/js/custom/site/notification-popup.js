"use strict";
$(function() {
    setTimeout(function() {
        $(".hide-notification-popup").fadeOut(1000);
    }, 3000)
})

$(function() {
    $('.notific-toggle').on('click',function(e) {
        e.stopPropagation();
        $(this).next('.notific-contnet').slideToggle();
    });

    $(document).on('click',function(e) {
        var target = e.target;
        var dropdown = $('.notific-contnet');
            if (!$(target).is('.notific-toggle') && !$.contains(dropdown[0], target)) {
            dropdown.slideUp();
        }
    });
});
    
