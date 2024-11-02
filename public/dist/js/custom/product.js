"use strict";
if (
    $(".main-body .page-wrapper").find("#item-add-container").length ||
    $(".main-body .page-wrapper").find("#item-edit-container").length
) {
    $(document).on("change", ".errorChk", function (event) {
        if ($(this).hasClass("err1") && $(this).val != "") {
            $(this).removeClass("err1");
            let id = $(this).attr("id");
            $("#" + id)
                .next("span")
                .text("");
        }
    });

    $(".select2").select2({
        placeholder: jsLang("Nothing selected"),
        allowClear: false,
    });

    // [ Tagging Support ] start
    $("#item_tags").select2({
        tags: true,
    });

    $(".select2_tags").select2({
        tags: true,
    });

    /* drag and drop function */
    function dragAndDrop(selector) {
        $(selector).sortable({
            distance: 2,
            delay: 300,
            opacity: 0.8,
            cursor: "move",
        });
    }

    /*Drag and drop attribute table column*/
    dragAndDrop(".drag_and_drop");

    function jump() {
        $("html, body").animate(
            {
                scrollTop: $(".err1").offset().top,
            },
            1000
        );
    }
}

if ($(".main-body .page-wrapper").find("#item-list-container").length) {
    $(document).on("click", "#csv, #pdf", function (event) {
        event.preventDefault();
        window.location = SITE_URL + "/items/" + this.id;
    });
}
if ($(".main-body .page-wrapper").find("#vendor-item-list-container").length) {
    $(document).on("click", "#csv, #pdf", function (event) {
        event.preventDefault();
        window.location = SITE_URL + "/items/" + this.id;
    });
}

// change text
function Schedule() {
    var btn = document.getElementById("myButton");

    if (btn.value == "Cancel") {
        btn.value = "Schudle";
        btn.innerHTML = "Schedule";
    } else {
        btn.value = "Cancel";
        btn.innerHTML = "Cancel";
    }
}

$(".myButton").on("click", function () {
    var btn = $(".myButton").val();
    if (btn.value == "Cancel") {
        btn.value = "Schedule";
        btn.innerHTML = "Schedule";
    } else {
        btn.value = "Cancel";
        btn.innerHTML = "Cancel";
    }
});

var fold_count = 1;
$(".fold_p").on("click", function () {
    setTimeout(() => {
        let sd = $(this).find(".date-schedular");
        if ($(this).attr("aria-expanded") == "true") {
            $(this).find(".inner_text").text("Cancel");
            if (sd) {
                $(sd).val(1);
            }
        } else {
            if (sd) {
                $(sd).val(0);
            }
            $(this).find(".inner_text").text("Schedule");
        }
    }, 100);
});

$(".select-btn").on("click", function () {
    var value = $(".status-select").val();
    $(".show-status").text(value);
});

// file upload
$(".addfiles").on("click", function () {
    $("#fileupload").click();
    return false;
});

$(document).on("click", ".toggle_collapse", function () {
    $(this).toggleClass("hideMe");
});

$(document).on("click", ".toggle_collapse_cancel", function () {
    $(this)
        .closest(".collapse-parent")
        .find(".toggle_collapse")
        .trigger("click");
});

// edit permalink
var tem_text = "";
$(".save-button, .cancel-button").hide();
$(window).on("load", function () {
    $(".save-button").on("click", save_onclick);
    $(".cancel-button").on("click", cancel_onclick);
    $(".edit-button").on("click", edit_onclick);
});

function edit_onclick() {
    tem_text = $(this).closest(".close-parent").find("input").val();
    setFormMode($(this).closest(".close-parent"), "edit");
    $(this).closest(".close-parent").find(".edit-input").trigger("focus");
}

function cancel_onclick() {
    $(this).closest(".close-parent").find("input").val(tem_text);
    setFormMode($(this).closest(".close-parent"), "view");
}

function save_onclick() {
    setFormMode($(this).closest(".close-parent"), "view");
}

function setFormMode($form, mode) {
    switch (mode) {
        case "view":
            $form.find(".save-button, .cancel-button").hide();
            $form.find(".edit-button").show();
            $form.find("input, select").prop("disabled", true);
            break;
        case "edit":
            $form.find(".save-button, .cancel-button").show();
            $form.find(".edit-button").hide();
            $form.find("input, select").prop("disabled", false);
            break;
    }
}

$(document).ready(function () {
    $(".sec-dlt").click(function () {
        $(this).closest(".attribute-dlt").remove();
    });
});

$(document).on("click", ".opt-select", function () {
    $(this)
        .closest(".attr")
        .find("select.select2")
        .find("option")
        .prop("selected", "selected");
    $(".attr").find("select.select2").trigger("change");
});

$(document).on("click", ".options-deselect", function () {
    $(this)
        .closest(".attr")
        .find("select.select2")
        .find("option")
        .prop("selected", false);
    $(".attr").find("select.select2").trigger("change");
});

// Attribute all collapse hide and show
$(document).ready(function () {
    $(document).on("click", ".collapse-expand", function () {
        $(this)
            .closest(".tab-pane")
            .find(".toggle-btn.inactive-sec")
            .trigger("click");
    });
    $(document).on("click", ".collapse-collapse", function () {
        $(this)
            .closest(".tab-pane")
            .find(".toggle-btn.active")
            .trigger("click");
    });
});

$(document).on(
    "click",
    ".toggle-btn.inactive-sec,.toggle-btn.active",
    function () {
        if ($(this).hasClass("inactive-sec")) {
            $(this)
                .removeClass("inactive-sec collapsed")
                .addClass("active")
                .attr("aria-expanded", true);
        } else {
            $(this)
                .removeClass("active")
                .addClass("inactive-sec collapsed")
                .attr("aria-expanded", false);
        }
    }
);

$(document).on("click", ".collapse-header", function (e) {
    if (e.target.localName == "div") {
        $(this)
            .closest(".ui-sortable-handle")
            .find(".toggle-btn")
            .trigger("click");
    }
});

$(".addAttrs").click(function () {
    $(".loder-content").block({
        message: `<div class="spinner-border text-warning" role="status"><span class="sr-only">Loading...</span></div>`,
        css: {
            backgroundColor: "transparent",
            border: "none",
        },
        timeout: 2000,
    });
});

// icon rotaed

$(document).ready(function () {
    $(".c-click").click(function () {
        $(".s-hide").toggle();
    });
});

// Bs collapse store localStorage
$( function() {
    $(".collapse")
    .on("hidden.bs.collapse", function () {
        if (this.id) {
            localStorage[this.id] = "true";
        }
    })
    .on("shown.bs.collapse", function () {
        if (this.id) {
            localStorage.removeItem(this.id);
        }
    })
    .each(function () {
        if (this.id && localStorage[this.id] === "true") {
            $(this).collapse("hide");
        }
    });
   });

// tab option hide show
function showDiv(divId, element) {
    var condition =
        element.value == "External/Affiliate Product" ? "block" : "none";
    if (element.value == "Variable Product") {
        $(".hidden_di").css("display", "block");
    }
    if (
        element.value == "Grouped Product" ||
        element.value == "Variable Product" ||
        element.value == "External/Affiliate Product"
    ) {
        $(".div_element, .div_h").css("display", "none");
        $(".inventory").trigger("click");
    }
    if (
        element.value == "Simple Product" ||
        element.value == "External/Affiliate Product"
    ) {
        $(".div_element").css("display", "block");
        $(".simple").trigger("click");
    }
    if (element.value == "Simple Product") {
        $(".div_h").css("display", "block");
    }
    $("." + divId).css("display", condition);
}

$(function () {
    $("#sortable .common_c ").each(function (index, domEle) {
        $(domEle).attr("id", "item_" + index);
    });

    $("#sortable").sortable({
        placeholder: "ui-state-highlight",
        update: function (event, ui) {
            localStorage.setItem("sorted", $("#sortable").sortable("toArray"));
        },
    });

    restoreSorted();
});

function restoreSorted() {
    var sorted = localStorage["sorted"];
    if (sorted == undefined) return;

    var elements = $("#sortable");
    var sortedArr = sorted.split(",");
    for (var i = 0; i < sortedArr.length; i++) {
        var el = elements.find("#" + sortedArr[i]);
        $("#sortable").append(el);
    }
}

$("#sortable").sortable({
    revert: true,
    cancel: "#sortable .txt-enable",
});

$(document).ready(function () {
    $(".summernote").summernote({
        tabsize: 2,
        height: 280,
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
        callbacks: {
            onInit: function () {
                var button =
                    '<button id="makeSnote" type="button" class="note-btn editor-img-btn btn btn-default btn-sm has-media-manager" data-val="single" tabindex="-1" title="" aria-label="Picture" data-original-title="Picture" aria-describedby="tooltip682862"><i class="note-icon-picture"></i></button>';
                var fileGroup =
                    '<div class="note-file btn-group note-btn-group">' +
                    button +
                    "</div>";
                $(fileGroup).appendTo($(".note-toolbar"));
                // Button tooltips
                $("#makeSnote").tooltip({
                    container: "body",
                    placement: "bottom",
                });
            },
        },
    });
});
$( function() {
   $(".date-ranges-picker").daterangepicker(clearableDateRangePickerConf());
  });
const refreshDatePickers = () => {
    $(".date-ranges-picker").on(
        "cancel.daterangepicker",
        function (ev, picker) {
            $(this).val("");
            datePickerUpdatedEvent(this);
        }
    );

    $(".date-ranges-picker, .start_end, .end_date").on(
        "apply.daterangepicker",
        function (ev, picker) {
            $(this).val(picker.startDate.format(dateFormatForMoment));
        }
    );
};

refreshDatePickers();

$(".start_date,.end_date").on("apply.daterangepicker", function (e, picker) {
    datePickerUpdatedEvent(this);
});

const datePickerUpdatedEvent = (element) => {
    let _end_date = $(element)
        .closest(".date-container")
        .find(".end_date.date-ranges-picker")
        .val();
    let _start_date = $(element)
        .closest(".date-container")
        .find(".start_date.date-ranges-picker")
        .val();
    if ($(element).closest(".date-container").find(".err-msg").length > 0) {
        $(element).closest(".date-container").find(".err-msg").remove();
    }
    if (
        (_start_date.length === 0 && _end_date.length === 10) ||
        (_start_date.length === 10 &&
            _start_date.length === _end_date.length &&
            new Date(_start_date) >= new Date(_end_date))
    ) {
        if (_start_date.length === 0) {
            addInputErrorMessage(
                $(element).parent(),
                jsLang("Please select an starting date.")
            );
        } else {
            addInputErrorMessage(
                $(element).parent(),
                jsLang("End date must be greater than end date.")
            );
        }
    }
    updatePublishedStatus(element);
};

$(document).on("file-attached", ".editor-img-btn", function (e, data) {
    data.data.forEach((element) => {
        $(".summernote").summernote(
            "pasteHTML",
            ' <p><img src="' + element.url + '" style="width: 100%;"/><br></p>'
        );
    });
});


const updatePublishedStatus = (element) => {

    if (! $(element).hasClass("schedule_start")) {
        return;
    }

    let _start_date = $(element)
        .closest(".date-container")
        .find(".start_date.date-ranges-picker")
        .val();

    if (_start_date.length === 0 || _start_date.length !== 10) {
        return;
    }

    let _date = new Date(_start_date);

    let _today = new Date();

    if (_date > _today) {
        $('.schedule_status').html(moment(_date).format(dateFormat.toUpperCase()));
    } else {
        $('.schedule_status').html(jsLang("Immediately"));
    }
}
