'use strict';

function handleNotificationAction(parent, id, isRead, title) {
    parent.css("pointer-events", "none");
    var addIconClass = isRead ? 'icon-eye' : 'icon-eye-off';
    var removeIconClass = isRead ? 'icon-eye-off' : 'icon-eye';
    var url = isRead ? markReadUrl : markUnreadUrl;

    $.ajax({
        url: url + id,
        type: 'patch',
        dataType: "json",
        data: {
            _token: token
        },
        success: function (data) {
            if (data === 1) {
                parent.css("pointer-events", "all");

                if ($('#user_notification_container').length) {
                    parent.find('img').attr('src', function (i, src) {
                        return src.replace(removeIconClass, addIconClass);
                    });
                } else {
                    parent.attr('data-bs-original-title', title);
                    parent.find('i').toggleClass(removeIconClass + ' ' + addIconClass);
                    
                    $(parent).tooltip('dispose').tooltip('show');
                }
            }
        },
    });
}

$(document).on('click', '.marked-toggle', function (e) {
    var id = $(this).data('id');
    var isRead = $(this).find('i').hasClass('icon-eye-off')

    handleNotificationAction($(this), id, isRead, jsLang('Mark As Unread'));
});

if ($('#user_notification_container').length) {
    $(document).on('click', '.marked-action', function (e) {
        var id = $(this).data('id');
        var isRead = $(this).find('img').attr('src').includes('icon-eye-off');

        handleNotificationAction($(this), id, isRead);
    });
}

$(document).on('click', '.prms', function(){

    var p_icon = $(this).find('.p-prms').attr('id');
    var check = false;

    if ($('#' + p_icon).hasClass('fa-check text-success')) {
      $('#' + p_icon).removeClass('fa-check text-success');
      check = true;
    }

    if ($('#' + p_icon).hasClass('fa-times text-danger')) {
      $('#' + p_icon).removeClass('fa-times text-danger');
    }

    $('#' + p_icon).addClass('fa-spinner prms-loader');

    $.ajax({
      url: SITE_URL + "/notifications/setting",
      type: 'POST',
      data: {
        _token: token,
        notification_type: $(this).data('notification_type'),
        channel: $(this).data('channel'),
        is_active: check ? 0 : 1
      },
      success: function(result){
        if ($('#' + p_icon).hasClass('fa-spinner prms-loader')) {
          $('#' + p_icon).removeClass('fa-spinner prms-loader');
        }

        if (result) {
          if (check) {
            $('#' + p_icon).addClass('fa-times text-danger');
          } else {
            $('#' + p_icon).addClass('fa-check text-success');
          }
        } else {
          if (check) {
            $('#' + p_icon).addClass('fa-check text-success');
          } else {
            $('#' + p_icon).addClass('fa-times text-danger');
          }
        }
      }
    });
  });
