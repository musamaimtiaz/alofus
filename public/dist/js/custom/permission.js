"use strict";
// Permission
function permission(pdf, csv) {
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
}

permission(pdf, csv);

function exportPdfCsv(id, url) {
    if ($('.main-body .page-wrapper').find(id).length) {
        // For export pdf and csv
        $(document).on("click", "#csv, #pdf", function(event) {
            event.preventDefault();
            window.location = SITE_URL + url + this.id;
        });
    }
}
exportPdfCsv('#refund-list-container', '/refund-request/');
exportPdfCsv('#vendor-refund-list-container', '/refund-request/');
exportPdfCsv('#transaction-list-container', '/transactions/');
exportPdfCsv('#withdrawal-list-container', '/withdrawals/');
exportPdfCsv('#subscriber-list-container', '/subscribers/');

