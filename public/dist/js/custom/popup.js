"use strict";
$(document).ready(function(){
    $("#v-pills-general-tab").trigger("click");
});
if ($(".main-body .page-wrapper").find("#popup-add-container").length) {
    function popupBackground() {
        if ($("#background").val() == "Image") {
            $("#popup_image")
                .closest("div")
                .attr("style", "display: block !important");
            $("#popup_bg_color")
                .closest("div")
                .attr("style", "display: none !important");
        } else if ($("#background").val() == "Color") {
            $("#popup_bg_color")
                .closest("div")
                .attr("style", "display: block !important");
            $("#popup_image")
                .closest("div")
                .attr("style", "display: none !important");
        } else {
            $("#popup_bg_color")
                .closest("div")
                .attr("style", "display: none !important");
            $("#popup_image")
                .closest("div")
                .attr("style", "display: none !important");
        }
    }
    popupBackground();
    $("#background").on('change', popupBackground);

    function resetPopup() {
        $(".default_content").attr("style", "display: block !important");
        $("#page_links").attr("style", "display: none !important");
        $("#mail").attr("style", "display: none !important");
        $("#subscription").attr("style", "display: none !important");
    }
    function checkType() {
        if ($("#popup_type").val() == "Information") {
            resetPopup();
        } else if ($("#popup_type").val() == "Another page link") {
            resetPopup();
            $("#page_links").attr("style", "display: block !important");
        } else if ($("#popup_type").val() == "Send mail") {
            resetPopup();
            $("#mail").attr("style", "display: block !important");
        } else if ($("#popup_type").val() == "Subscribed") {
            resetPopup();
            $("#subscription").attr("style", "display: block !important");
        } else {
            resetPopup();
            $(".default_content").attr("style", "display: none !important");
        }
    }
    checkType();
    $("#popup_type").on("change", checkType);

    $('input[name="start_date"]').daterangepicker(dateSingleConfig());
    $('input[name="end_date"]').daterangepicker(dateSingleConfig());
}

if ($(".main-body .page-wrapper").find("#popup-edit-container").length) {
    $('input[name="start_date"]').daterangepicker(
        dateSingleConfig($('input[name="start_date"]').val())
    );
    $('input[name="end_date"]').daterangepicker(
        dateSingleConfig($('input[name="end_date"]').val())
    );

    $("#background").on("change", function () {
        if ($(this).val() == "Image") {
            $("#popup_image")
                .closest(".popup-image-parent")
                .attr("style", "display: block !important");
            $("#popup_bg_color")
                .closest("div")
                .attr("style", "display: none !important");
            $(".old_image").show();
        } else if ($(this).val() == "Color") {
            $("#popup_bg_color")
                .closest("div")
                .attr("style", "display: block !important");
            $("#popup_image")
                .closest(".popup-image-parent")
                .attr("style", "display: none !important");
            $(".old_image").hide();
        } else {
            $("#popup_bg_color")
                .closest("div")
                .attr("style", "display: none !important");
            $("#popup_image")
                .closest(".popup-image-parent")
                .attr("style", "display: none !important");
            $(".old_image").hide();
        }
    });
}

$("#add_text").on("click", function () {
    var id = $(this).data("id");
    $(this).data("id", id + 1);
    $("#text").append(`
        <div class="text-area border p-3">
         <div class="popup-content-remove d-flex justify-content-end align-items-end">
            <span class="remove-text cursor-pointer py-2">x</span>
        </div>
            <div class="form-group row">

                <label class="col-sm-2 control-label" for="text[text1]text">${jsLang(
                    "Text"
                )}</label>
                    <div class="row col-sm-10 col-12 margin-auto padding-0">
                        <div class="col-lg-7 col-9">
                            <input type="text" maxlength="300" placeholder="${jsLang(
                                "Text"
                            )}" class="form-control inputFieldDesign" id="text${id}" name="text[text${id}][text]">
                        </div>
                        <div class="col-lg-1 p-0 col-2">
                            <input type="color" class="w-100 cursor-pointer p-1" name="text[text${id}][text_color]" id="text${id}_color">
                        </div>
                        <div class="col-lg-4 col-12 mt-lg-0 mt-3">
                            <div class="input-group">
                                <input type="text" maxlength="3" placeholder="${jsLang(
                                    "Font size"
                                )}" class="form-control positive-int-number inputFieldDesign" id="text${id}_size" name="text[text${id}][text_size]">
                                <div class="input-group-append">
                                    <button class="border-0 btn-sm h-40" type="button">Px</button>
                                </div>
                            </div>
                        </div>
                    </div>
            </div>

            <div class="form-group row">
                <label class="col-sm-2 col-12 control-label text-left" for="text${id}_margin_left">${jsLang("Text Margin")}</label>
                <div class="col-sm-7 col-12 margin-auto row">
                    <div class="col-sm-6 padding-0 col-12">
                        <div class="input-group">
                            <input type="text" maxlength="3" placeholder="${jsLang(
                                "Left"
                            )}" class="form-control positive-int-number inputFieldDesign" id="text${id}_margin_left" name="text[text${id}][text_margin_left]" value="">
                            <div class="input-group-append">
                                <button class="border-0 btn-sm h-40" type="button">Px</button>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6 padding-0 col-12 mt-sm-0 mt-3">
                        <div class="input-group">
                            <input type="text" maxlength="3" placeholder="${jsLang(
                                "Top"
                            )}" class="form-control positive-int-number inputFieldDesign" id="text${id}_margin_top" name="text[text${id}][text_margin_top]" value="">
                            <div class="input-group-append">
                                <button class="border-0 btn-sm h-40" type="button">Px</button>
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-6 padding-0 col-12 mt-3">
                        <div class="input-group">
                            <input type="text" maxlength="3" placeholder="${jsLang(
                                "Right"
                            )}" class="form-control positive-int-number inputFieldDesign" id="text${id}_margin_right" name="text[text${id}][text_margin_right]" value="">
                            <div class="input-group-append">
                                <button class="border-0 btn-sm h-40" type="button">Px</button>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6 padding-0 mt-3 col-12">
                        <div class="input-group">
                            <input type="text" maxlength="3" placeholder="${jsLang(
                                "Bottom"
                            )}" class="form-control positive-int-number inputFieldDesign" id="text${id}_margin_bottom" name="text[text${id}][text_margin_bottom]" value="">
                            <div class="input-group-append">
                                <button class="border-0 btn-sm h-40" type="button">Px</button>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-sm-3 ps-sm-0 mt-2 mt-sm-0">

                    <div class="col-12 col-sm-12 mb-3 p-0">
                        <select class="form-select inputFieldDesign sl_common_bx" id="text${id}_alignment" name="text[text${id}][text_alignment]">
                            <option value="left">${jsLang("Left")}</option>
                            <option value="center">${jsLang("Center")}</option>
                            <option value="right">${jsLang("Right")}</option>
                        </select>
                    </div>

                    <div class="col-12 col-sm-12 p-0">
                        <select class="form-select inputFieldDesign sl_common_bx" id="text${id}_font_weight" name="text[text${id}][text_font_weight]">
                            <option value="normal">${jsLang("Normal")}</option>
                            <option value="bold">${jsLang("Bold")}</option>
                            <option value="italic">${jsLang("Italic")}</option>
                        </select>
                    </div>

                </div>

            </div>
        </div>
    `);
});
function tabTitle(id){
    var title = $('#'+ id).attr('data-id');
    $('#theme-title').html(title);
}
$(".popup-store-button").on("click", function (e) {
    var arr = [
        "#v-pills-setting",
        "#v-pills-target",
        "#v-pills-display",
        "#v-pills-content",
        "#v-pills-popupType",
    ];
    setTimeout(() => {
        for (const key in arr) {
            if ($(arr[key]).find(".error").length) {
                var target = $(arr[key]).attr("aria-labelledby");
                $('#' + target).tab('show');
                tabTitle(target);
                break;
            }
        }
    }, 100);
});


$(document).on("click", ".remove-text", function () {
    $(this).closest(".text-area").remove();
});

$("button.switch-tab").on("click", function () {
    $('#' + $(this).attr('data-id')).tab('show');
    var titleName = $(this).attr('data-id');
    tabTitle(titleName);
});

$(".tab-name").on("click", function () {
    var id = $(this).attr("data-id");
    $("#theme-title").html(id);
});

if ($(".main-body .page-wrapper").find("#popup-add-container, #popup-edit-container").length) {
    $('.tab-pane[aria-labelledby="v-pills-general-tab"').addClass(
        "show active"
    );
}
