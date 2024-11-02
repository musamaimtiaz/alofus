"use strict";
// Permission
function permission(pdf, csv, refresh = 0) {
    if (pdf == 1 || csv == 1) {
        var show = setInterval(() => {
            if ($("#btnGroupDrop1").length) {
                $("#btnGroupDrop1").css('display','inline-block')
                $(".btn-group").css({'display':'inline-flex'})
                $("#dataTableBuilder_length").css({'margin-top':'0px'});

                (pdf == 1) ? $("#pdf").show() : $("#pdf").hide();
                (csv == 1) ? $("#csv").show() : $("#csv").hide();

                clearInterval(show);
            }
        }, 100);
    } else {
        var hide = setInterval(() => {
            if ($("#btnGroupDrop1").length) {
                $("#btnGroupDrop1").css('display','none')
                $(".btn-group").css({'display':'inline-block'})
                $("#dataTableBuilder_length").css({'margin-top':'-20px'})
                clearInterval(hide);
            }
        }, 100);
    }
    if (refresh == 0) {
        let refresh_hide = setInterval(() => {
           $(".btn-group").find('.form-control').css({'visibility':'hidden'})
            clearInterval(refresh_hide);
        }, 100);
    }
}

permission(0, 0, 1);

if ($('.main-body .page-wrapper').find('#translation-settings-container').length
) {
    permission(0, 0, 0);
}


