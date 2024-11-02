"use strict";
if ($('.main-body .page-wrapper').find('#email-configuration-settings-container').length) {

    function configuration() {
        var type = $('#type').val();
        if (type == 'smtp') {
            $("#smtp_form").show();
            $("#type_val").attr('value', 'smtp');
            $('input').prop('required', true)
        } else {
            $("#smtp_form").hide();
            $("#type_val").attr('value', 'sendmail');
            $('input').prop('required', false)

            $('input').each((k, v) => {
                v.setCustomValidity('');
            })
        }
    }

    $("#type").on('change', configuration);

    $(window).on('load', configuration)
}
