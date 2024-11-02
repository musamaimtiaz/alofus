"use strict";
if ($('.main-body .page-wrapper').find('#review-list-container, #vendor-review-list-container').length) {
    $("#edit-unit").on("show.bs.modal", function () {
        $("#edit_status, #is_public, #review_id").removeClass("error");
        $("#edit_status-error, #edit_status-error, #edit_status-error").hide();
    });
    $(document).on('click', '.edit_review', function () {
        var id = $(this).data("id");
        var url = "/reviews/edit"
        $.ajax({
            url: SITE_URL + url,
            data: {
                id: id,
                "_token": token
            },
            type: 'POST',
            dataType: 'JSON',
            success: function (data) {
                $('#edit_status').val(data.status);
                $('#is_public').val(data.is_public);
                $('#review_id').val(data.id);
                $('#edit-review').modal();
            }
        });
    });
}
if ($('.main-body .page-wrapper').find('#review-list-container').length) {
    // For export csv
    $(document).on("click", "#csv, #pdf", function(event) {
        event.preventDefault();
        window.location = SITE_URL + "/reviews/" + this.id;
    });
}
if ($('.main-body .page-wrapper').find('#vendor-review-list-container').length) {
    // For export csv
    $(document).on("click", "#csv, #pdf", function(event) {
        event.preventDefault();
        window.location = SITE_URL + "/reviews/" + this.id;
    });
}
