"use strict";
if ($(".main-body .page-wrapper").find("#item-list-container").length || $('.main-body .page-wrapper').find('#vendor-item-list-container').length) {

    $(document).on("change", ".product_type", function (event) {
        if ($(this).val() == 'Simple Product' || $(this).val() == 'Variable Product') {
            $('.sub_type').removeClass('display_none');
        } else {
            $('select[name="sub_type"]').val("").change();
            $('.sub_type').addClass('display_none');
        }
    });
}
