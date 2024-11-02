"use strict";
if ($('.main-body .page-wrapper').find('#vendor-transaction-container').length || $('.main-body .page-wrapper').find('#transaction-list-container').length) {
    $('#daterange-btn').daterangepicker(daterangeConfig('undefined', 'undefined'), cbRange);
    cbRange('undefined', 'undefined');
    $(document).on("click", ".applyBtn, .ranges ul li:nth-child(1), .ranges ul li:nth-child(2), .ranges ul li:nth-child(3), .ranges ul li:nth-child(4), .ranges ul li:nth-child(5), .ranges ul li:nth-child(6), .ranges ul li:nth-child(7)", function (event) {
        event.preventDefault();
        let startFrom = $("#startfrom").val();
        let endto = $("#endto").val();
        var newOptions = {
            startFrom: startFrom,
        };
        var newOptionsTwo = {
            endto: endto,
        };
        let startDate = $("#start_date");
        let end_date = $("#end_date");
        startDate.empty(); // remove old options
        end_date.empty(); // remove old options
        $.each(newOptions, function(key,value) {
            startDate.append($("<option></option>")
                .attr("value", value).text(key));
        });
        $.each(newOptionsTwo, function(key,value) {
            end_date.append($("<option></option>")
                .attr("value", value).text(key));
        });
        $("#start_date option:first").attr('selected','selected');
        $("#end_date option:first").attr('selected','selected');
        $("#start_date").trigger("change");
    });
}

if ($('.main-body .page-wrapper').find('#vendor-transaction-container').length) {
    $(document).on("click", "#csv, #pdf", function (event) {
        event.preventDefault();
        window.location = SITE_URL + "/transactions/" + this.id;
    });
}
