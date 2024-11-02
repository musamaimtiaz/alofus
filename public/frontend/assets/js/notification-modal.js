'use strict';
$('.header-notification-icon').on('click', function() {
    
    if ($('.notific-contnet').attr('style') === 'display: block;' || !$(this).hasClass('notific-toggle')) {
        return;
    }
    
    $(this).removeClass('notific-toggle');
    $.ajax({
        url: SITE_URL + '/user/notifications/ajax-loading',
        type: "GET",
        beforeSend: function() {
            $('.header-notification-body').html($('.notification-loader').html());
        },
        success: function (data) {
            $('.header-notification-body').html(data.data);
        },
        complete: function () {
            $('.header-notification-icon').addClass('notific-toggle');
        },
    });
})
