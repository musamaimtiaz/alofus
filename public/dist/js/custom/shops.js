"use strict";

if ($('.main-body .page-wrapper').find('#shop-add-container, #shop-list-container').length || $('.main-body .page-wrapper').find('#shop-edit-container').length) {
    $(".select2").select2();
}

if ($('.main-body .page-wrapper').find('#shop-list-container').length) {
    // For export csv and pdf
    $(document).on("click", "#csv, #pdf", function(event) {
        event.preventDefault();
        window.location = SITE_URL + "/shop/" + this.id;
    });
}

if ($('.main-body .page-wrapper').find('#vendor-shop-list-container').length) {
    // For export csv and pdf
    $(document).on("click", "#csv, #pdf", function(event) {
        event.preventDefault();
        window.location = SITE_URL + "shop/" + this.id + '/' + vendor_id;
    });
}
