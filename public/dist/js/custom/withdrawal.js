"use strict";
if ($('.main-body .page-wrapper').find('#withdrawal-setting-container').length) {
    $('.withdrawal-status').on('click', function() {
        var id = $(this).data('id');
        var status = 'Inactive';
        if (!$(this).siblings('input').prop('checked')) {
            status = 'Active';
        }
        $.ajax({
            url: SITE_URL + "/withdrawal-setting/update",
            type: 'POST',
            data: {
              _token: token,
              id: id,
              status: status
            },
          });
    })
}
if ($('.main-body .page-wrapper').find('#vendor-withdrawal-container').length) {
    // For export pdf and csv
    $(document).on("click", "#csv, #pdf", function(event) {
        event.preventDefault();
        window.location = SITE_URL + "/withdrawals/" + this.id;
    });
}

