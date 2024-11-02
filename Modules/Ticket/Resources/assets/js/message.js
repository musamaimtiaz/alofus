"use strict";
const SITE_URL_ORIGIN = window.location.origin;
if ($(".main-body .page-wrapper").find("#add-ticket-container").length) {
    $(document).ready(function () {
        $("#summernote").summernote({
            tabsize: 2,
            height: 120,
            blockquoteBreakingLevel: 2,
            styleTags: [
                "p",
                {
                    title: "Blockquote",
                    tag: "blockquote",
                    className: "blockquote",
                    value: "blockquote",
                },
                "pre",
                "h1",
                "h2",
                "h3",
                "h4",
                "h5",
                "h6",
            ],
            toolbar: [
                ["style", ["style"]],
                ["font", ["bold", "underline", "clear"]],
                ["color", ["color"]],
                ["para", ["ul", "ol", "paragraph"]],
                ["table", ["table"]],
                ["insert", ["link"]],
                ["view", ["fullscreen", "codeview", "help"]],
            ],
            codeviewFilter: true,
            codeviewFilterRegex: summernote_regex,
            callbacks:
            {
                onInit: function()
                {
                    var button = '<button id="makeSnote" type="button" class="note-btn editor-img-btn btn btn-default btn-sm has-media-manager" data-val="single" tabindex="-1" title="" aria-label="Picture" data-original-title="Picture" aria-describedby="tooltip682862"><i class="note-icon-picture"></i></button>';
                    var fileGroup = '<div class="note-file btn-group note-btn-group">' + button + '</div>';
                    $(fileGroup).appendTo($('.note-toolbar'));
                    // Button tooltips
                    $('#makeSnote').tooltip({
                      container: 'body',
                      placement: 'bottom'
                    });
                },
                    onChange: function() { }    // callback as option

            }

        });

        $(document).on("change", "#customer_id", function () {
            $("#assign_name").val($("option:selected", this).attr("data-name"));
            $("#assign_email").val(
                $("option:selected", this).attr("data-email")
            );
        });


        $(document).on("click", "#add_ticket_btn", function () {
            if ($('#summernote').summernote('isEmpty')) {
                $('#ticket_messages-error').show().text('This field is required.')
                return false;
              } else {
                $('#ticket_messages-error').hide()
                return true;
              }
        });

    });
}
$("#summernote").on("summernote.change", function (e) {   // callback as jquery custom event
    $('#ticket_messages-error').hide()
});

$(document).on("file-attached", ".editor-img-btn", function (e, data) {
    data.data.forEach((element) => {
        $('#summernote').summernote('pasteHTML', ' <p><img src="' + element.url + '" style="width: 200px;"/><br></p>');
    });
});

$(document).on("file-attached", ".has-thumbnail", function (e, data) {
   $("#ticket-image").append(data.html)
});

if ($(".main-body .page-wrapper").find("#reply-ticket-container").length) {
    $(document).ready(function () {
        $("#summernote").summernote({
            tabsize: 2,
            height: 120,
            blockquoteBreakingLevel: 2,
            styleTags: [
                "p",
                {
                    title: "Blockquote",
                    tag: "blockquote",
                    className: "blockquote",
                    value: "blockquote",
                },
                "pre",
                "h1",
                "h2",
                "h3",
                "h4",
                "h5",
                "h6",
            ],
            toolbar: [
                ["style", ["style"]],
                ["font", ["bold", "underline", "clear"]],
                ["color", ["color"]],
                ["para", ["ul", "ol", "paragraph"]],
                ["table", ["table"]],
                ["insert", ["link"]],
                ["view", ["codeview", "help"]],
            ],
            codeviewFilter: true,
            codeviewFilterRegex: summernote_regex,
            callbacks:
            {
                onInit: function()
                {
                    var button = '<button id="makeSnote" type="button" class="note-btn editor-img-btn btn btn-default btn-sm has-media-manager" data-val="single" tabindex="-1" title="" aria-label="Picture" data-original-title="Picture" aria-describedby="tooltip682862"><i class="note-icon-picture"></i></button>';
                    var fileGroup = '<div class="note-file btn-group note-btn-group">' + button + '</div>';
                    $(fileGroup).appendTo($('.note-toolbar'));
                },
                onChange: function() { }    // callback as option

            }
        });
    });

    $(document).on("click", "#add_ticket_btn", function () {
        if ($('#summernote').summernote('isEmpty')) {
            $('#ticket_messages-error').show().text('This field is required.')
            return false;
          } else {
            $('#ticket_messages-error').hide()
            return true;
          }
    });
}

if ($(".main-body .page-wrapper").find("#edit-ticket-container").length) {
    $(document).ready(function () {
        $(function () {
            var name = $("#vendor_id option:selected").attr("data-name");
            var email = $("#vendor_id option:selected").attr("data-email");
            $("#assign_name").val(name);
            $("#assign_email").val(email);
        });

        $(document).on("change", "#vendor_id", function () {
            $("#assign_name").val($("option:selected", this).attr("data-name"));
            $("#assign_email").val($("option:selected", this).attr("data-email"));
        });
    });
}
$(document).on("click", ".ticket_priority_change", function () {
    var priorityId = $(this).attr("data-id");
    var ticketId = $(this).attr("ticket_id");
    var ticketName = $(this).attr("data-value");
    ticketPriorityChange(
        SITE_URL + "/ticket/priority-status",
        priorityId,
        ticketId,
        ticketName
    );
});

function ticketPriorityChange(url, priorityId, ticketId, ticketName) {
    $.ajax({
        url: url,
        method: "get",
        data: {
            priorityId: priorityId,
            ticketId: ticketId,
            _token: token,
        },
        dataType: "json",
        success: function (data) {
            if (data.status == 1) {
                $("#removeLiPriority ul").empty();
                $("#removeLiPriority ul").append(data.output);
                $(".priority-color").html(ticketName);
                var priority = {
                    Low: "#e1e0e0",
                    Medium: "#fae39f",
                    High: "#f2d2d2",
                };
                $(".priority-color").css(
                    "background-color",
                    priority[$.trim(ticketName)]
                );
            } else {
                var html =
                    '<div class="alert alert-danger">' +
                    '<button type="button" class="close" data-dismiss="alert">×</button>' +
                    "<strong>Something went wrong, please try again.</strong>" +
                    "</div>";
                $(".noti-alert").append(html);
                $("#notifications").css("display", "block");
            }
        },
    });
}

$(document).on("change", "#assignee", function () {
    var user_id = $("#assignee").val() ? $("#assignee").val() : null;
    var url = SITE_URL + "/ticket/change-assignee";
    $.ajax({
        url: url,
        method: "POST",
        data: {
            user_id: user_id,
            ticket_id: $("#ticketId").val(),
            _token: token,
        },
        dataType: "json",
        beforeSend: function () {
            swal({
                title: jsLang("Loading..."),
                text:
                    $("#assignee option:selected").text() +
                    ", " +
                    jsLang("assigning to this ticket"),
                buttons: false,
            });
        },
        success: function (data) {
            if (data.status == "1") {
                $("#assignee").val(user_id).trigger("change");
                swal(
                    $("#assignee option:selected").text() +
                        jsLang(" successfully assigned"),
                    {
                        icon: "success",
                        buttons: [false, jsLang("Ok")],
                    }
                );
            } else if (data.status == "2") {
                $("#assignee").val(user_id).trigger("change");
                swal(jsLang(" please check your email configuration"), {
                    icon: "error",
                    buttons: [false, jsLang("Ok")],
                });
            }
        },
    });
});

$(document).on("click", ".ticket_status_change", function () {
    var statusId = $(this).attr("data-id");
    var ticketId = $(this).attr("ticket_id");
    ticketStatusChange(SITE_URL + "/ticket/change-status", statusId, ticketId);
});

$(document).on("click", ".admin_ticket_status_change", function () {
    var statusId = $(this).attr("data-id");
    var ticketId = $(this).attr("ticket_id");
    ticketStatusChange(SITE_URL + "/ticket/change-status", statusId, ticketId);
});

function ticketStatusChange(url, statusId, ticketId) {
    $.ajax({
        url: url,
        method: "POST",
        data: {
            status_id: statusId,
            ticketId: ticketId,
            _token: token,
        },
        dataType: "json",
        success: function (data) {
            if (data.status == 1) {
                $('#status_label').html(data.newName);
				$('#status_label').css("color", data.newStatusColor);
				$('#ticket-status').html(data.newName);
          		$('#ticket-status').removeClass('text-white').css("color", data.newStatusColor);
                if ($("#dataTableBuilder").length) {
                    $("#dataTableBuilder").DataTable().ajax.reload();

                }
            }
        },
    });
}

$(document).on(
    "click",
    ".applyBtn, .ranges ul li:nth-child(1), .ranges ul li:nth-child(2), .ranges ul li:nth-child(3), .ranges ul li:nth-child(4), .ranges ul li:nth-child(5), .ranges ul li:nth-child(6), .ranges ul li:nth-child(7)",
    function (event) {
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
        $.each(newOptions, function (key, value) {
            startDate.append(
                $("<option></option>").attr("value", value).text(key)
            );
        });
        $.each(newOptionsTwo, function (key, value) {
            end_date.append(
                $("<option></option>").attr("value", value).text(key)
            );
        });
        $("#start_date option:first").attr("selected", "selected");
        $("#end_date option:first").attr("selected", "selected");
        $("#start_date").trigger("change");
    }
);

$(document).on("keyup", "#slug", function () {
    var str = this.value.replace(/[&\/\\#@,+()$~%.'":*?<>{}]/g, "");
    $("#slug").val(str.trim().toLowerCase().replace(/\s/g, "-"));
});

if ($(".main-body .page-wrapper").find("#ticket-list-container").length) {
    $(document).ready(function () {
        $(document).on("click", "#csv", function (event) {
            event.preventDefault();
            window.location =
                SITE_URL +
                "/ticket/csv?from=" +
                $("#startfrom").val() +
                "&to=" +
                $("#endto").val() +
                "&department_id=" +
                $("#department_id").val() +
                "&status=" +
                $("#status").val() +
                "&assignee=" +
                $("#assignee").val();
        });
        $(document).on("click", "#pdf", function (event) {
            event.preventDefault();
            window.location =
                SITE_URL +
                "/ticket/pdf?from=" +
                $("#startfrom").val() +
                "&to=" +
                $("#endto").val() +
                "&department_id=" +
                $("#department_id").val() +
                "&status=" +
                $("#status").val() +
                "&assignee=" +
                $("#assignee").val();
        });

        $("#daterange-btn").daterangepicker(
            daterangeConfig(startDate, endDate),
            cbRange
        );
        cbRange(startDate, endDate);
    });
    $('input[name="from"]').daterangepicker(dateSingleConfig());
    $('input[name="to"]').daterangepicker(dateSingleConfig());
}

$(".edit-btn").on("click", function () {
    $(document).ready(function () {
        $("#summernote1").summernote({
            tabsize: 2,
            height: 120,
            blockquoteBreakingLevel: 2,
            styleTags: [
                "p",
                {
                    title: "Blockquote",
                    tag: "blockquote",
                    className: "blockquote",
                    value: "blockquote",
                },
                "pre",
                "h1",
                "h2",
                "h3",
                "h4",
                "h5",
                "h6",
            ],
            toolbar: [
                ["style", ["style"]],
                ["font", ["bold", "underline", "clear"]],
                ["color", ["color"]],
                ["para", ["ul", "ol", "paragraph"]],
                ["table", ["table"]],
                ["insert", ["link"]],
                ["view", ["codeview", "help"]],
            ],
            codeviewFilter: true,
            codeviewFilterRegex: summernote_regex,
        });
    });
    $("#reply_id").val($(this).attr("data-id"));
    $("#update_type").val($(this).attr("data-message"));
    $("#summernote1").val($(this).attr("data-message"));
});

if (
    $(".main-body .page-wrapper").find("#vendor-ticket-list-container").length
) {
    $(document).ready(function () {
        $(document).on("click", "#csv", function (event) {
            event.preventDefault();
            window.location =
                SITE_URL +
                "/ticket/csv?from=" +
                $("#startfrom").val() +
                "&to=" +
                $("#endto").val() +
                "&department_id=" +
                $("#department_id").val() +
                "&status=" +
                $("#status").val();
        });
        $(document).on("click", "#pdf", function (event) {
            event.preventDefault();
            window.location =
                SITE_URL +
                "/ticket/pdf?from=" +
                $("#startfrom").val() +
                "&to=" +
                $("#endto").val() +
                "&department_id=" +
                $("#department_id").val() +
                "&status=" +
                $("#status").val();
        });

        $("#daterange-btn").daterangepicker(
            daterangeConfig(startDate, endDate),
            cbRange
        );
        cbRange(startDate, endDate);
    });
    $('input[name="from"]').daterangepicker(dateSingleConfig());
    $('input[name="to"]').daterangepicker(dateSingleConfig());
}

$(document).on("submit","#add_ticket_form,#reply_form,#replyModal",function(e){
    if ($('#summernote').summernote('codeview.isActivated')) {
        $('#summernote').summernote('codeview.deactivate');
    }
    if ($('#summernote1').summernote('codeview.isActivated')) {
        $('#summernote1').summernote('codeview.deactivate');
    }
});
