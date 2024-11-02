"use strict";

var pendingForm;
const alertBox = $(".js-alert");

$(function() {
    $("#sortable").sortable({
        axis: "y",
        cursor: "move",
        cancel: '.dd-content'
    });
});

$(document).on("submit", "form#layout_selector", function (e) {
    e.preventDefault();
    let url = this.action.replace(
        "__file",
        this.querySelector("#l_layout").value
    );
    updateFormButton(this);
    ajaxRequest($(this), url, replaceForm);
});

$(document).on("change", ".category_type", function () {
    if (this.value == "selectedCategories") {
        this.closest("form").querySelector(".cats").classList.remove("d-none");
    } else {
        this.closest("form").querySelector(".cats").classList.add("d-none");
    }
});

$(document).on("change", "#brand_type", function () {
    if (this.value == "selectedBrands") {
        this.closest("form").querySelector(".cats").classList.remove("d-none");
    } else {
        this.closest("form").querySelector(".cats").classList.add("d-none");
    }
});

$(document).on("change", "#blog_type", function () {
    if (this.value == "selectedBlogs") {
        this.closest("form").querySelector(".cats").classList.remove("d-none");
    } else {
        this.closest("form").querySelector(".cats").classList.add("d-none");
    }
});

$(document).on("submit", "form.component_form", function (e) {
    e.preventDefault();
    let url = this.action.replace("__id", __page);
    updateFormButton(getDraggableParent(this));
    $.makeAjaxCall($(this), url, {
        success: updateComponent,
        failed: updateComponent,
        type: "post",
    });
});

$(document).on("keyup", ".section_name", function () {
    let parent = getDraggableParent(this);
    parent.find(".header-title").html(filterXSS(this.value));
});

$(document).on("click", "#update_page", function (e) {
    
    if ($('#sortable').children().length == 0) {
        setTimeout(() => {
            removeButtonLoader();
        }, 200);
        return;
    }
    
    $(this).find(".loading-spinner").toggleClass("d-none");
    
    var counter = 0;
    $("#sortable")
        .find("form.component_form")
        .each(function () {
            let data = $(this).find("input,select,textarea").serialize();
            $("#internal_form").append(
                `<input type="hidden" class="temp-input" name="component[${counter++}]" value="${data}">`
            );
        });
    $.makeAjaxCall($("#internal_form"), __savePageUrl, {
        success: pageUpdated,
        type: "post",
    });
});

$(document).on("click", "#add-new-widget", function () {
    sortable.append(selector);
    $("html, body").animate({ scrollTop: $(document).height() }, "slow");
    updateSelect2Fields();
});

$(document).on("change", "#l_category", function () {
    $(this).closest("form").find(".layoutBlocks").addClass("d-none");
    $(this).closest("form").find("#" + this.value).removeClass("d-none");
});

const ajaxRequest = (form, url, callBack, method = "get") => {
    let serializedData = {};
    if (form) {
        var $inputs = form.find("input, select, button, textarea");
        form.serializeArray().forEach((x) => {
            let [name, value] = [x.name, x.value];
            if (name.endsWith("[]")) {
                name = name.slice(0, -2);
                if (!serializedData[name]) {
                    serializedData[name] = [];
                }
                serializedData[name].push(value);
            } else {
                serializedData[name] = value;
            }
        });
        $inputs.prop("disabled", true);
    }
    pendingForm = form;

    $.ajax({
        url: url,
        type: method,
        dataType: "json",
        data: serializedData,
        success: function (data) {
            callBack(form, data.body);
            $inputs.prop("disabled", false);
            ajaxUpdated();
            removeButtonLoader();
        },
        error: function (xhr, status, error) {
            $inputs.prop("disabled", false);
            operationFailed(jsLang("Operation failed."));
            updateAjaxMessage(form, jsLang("Operation failed."), "danger");
            updateFormButton(form);
            ajaxFailed();
            removeButtonLoader();
            throw error;
        },
    });
};

const replaceForm = (child, html) => {
    let parent = getDraggableParent(child);
    parent.find(".header-title").html(html.title);
    parent.find(".header-text").append(html.header);
    parent.attr("data-id", html.level);
    parent.find(".dd-content").remove();
    parent.append(html.html);
    $("#sortable").trigger("sortstop");
    $("#update_page .loading-spinner").toggleClass("d-none");
    operationSuccess(
        jsLang(
            "Section added. Please fill up the section information and save."
        )
    );

    updateSelect2Fields();
};

const updateComponent = (param, response) => {
    let $child = $(param.form);
    $child.closest(".ui-state-default").find(".delete-button").attr("data-component-id", response.body);
    $child.find(".component").prop("value", response.body);
    updateFormButton(getDraggableParent($child));
    updateAjaxMessage(getDraggableParent($child), jsLang("Section updated."));
    operationSuccess(jsLang("Section Updated"));
};

const getDraggableParent = (child) => {
    return $(child).closest(".ui-state-default");
};

const deletedGrid = (response) => {
    if (response) {
        operationSuccess(jsLang("Section deleted"));
    } else {
        operationFailed(jsLang("Couldn't delete the section"));
    }
};

const updateCustomForm = (value) => {
    document.querySelector("#internal_form #data").value = value;
};

const pageUpdated = (form, value) => {
    $("#update_page .loading-spinner").toggleClass("d-none");
    $(".temp-input").remove();
    window.location.reload();
};

const operationSuccess = (msg) => {
    showNotification("success", jsLang(msg));
};

const operationFailed = (msg) => {
    showNotification("danger", jsLang(msg));
};

const showNotification = (css_class, msg) => {
    alertBox.find(".alertText").html(msg);
    alertBox.find(".alert").attr("class", `alert alert-${css_class}`);
    alertBox.removeClass("d-none");
};

$(".close").click(function () {
    alertBox.addClass("d-none");
});

const showSliderOptions = (radio) => {
    let p = getDraggableParent(radio);
    $(p).find(".sliderOptions").removeClass("d-none").addClass("d-flex");
    hideBannerOptions(p);
    hideFlashOptions(p);
};

const hideSliderOptions = (p) => {
    $(p).find(".sliderOptions").addClass("d-none").removeClass("d-flex");
};

const showBannerOptions = (radio) => {
    let p = getDraggableParent(radio);
    $(p).find(".bannerOptions").removeClass("d-none").addClass("d-flex");
    hideSliderOptions(p);
    hideFlashOptions(p);
};

const hideBannerOptions = (p) => {
    $(p).find(".bannerOptions").removeClass("d-flex").addClass("d-done");
};

const showFlashOptions = (radio) => {
    let p = getDraggableParent(radio);
    $(p).find(".flashOptions").addClass("d-flex").removeClass("d-none");
    hideSliderOptions(p);
    hideBannerOptions(p);
};

const hideFlashOptions = (p) => {
    $(p).find(".flashOptions").addClass("d-none").removeClass("d-flex");
};

const hideAllOptions = (radio) => {
    let p = getDraggableParent(radio);
    hideSliderOptions(p);
    hideBannerOptions(p);
    hideFlashOptions(p);
    toggleSidebar(radio, false);
};

const updateSelect2Fields = () => {
    $("select.select2").select2({
        placeholder: jsLang("Select an option"),
    });
    $(".select3").select2({
        placeholder: jsLang("Select an option"),
    });
};

$(document).on("select2:select", "select.select2", function (evt) {
    var element = evt.params.data.element;
    var $element = $(element);

    $element.detach();
    $(this).append($element);
    $(this).trigger("change");
});

updateSelect2Fields();

$(document).on("change", ".sidebar_options", function () {
    if (this.value == "0") {
        hideAllOptions(this);
    } else if (this.value == "slide") {
        showBannerOptions(this);
        toggleSidebar(this, true);
    } else if (this.value == "slider") {
        showSliderOptions(this);
        toggleSidebar(this, true);
    } else if (this.value == "flash_sale") {
        showFlashOptions(this);
        toggleSidebar(this, true);
    }
    $(".product-col").trigger("change");
});

$(document).ready(function () {
    updateSelect2Fields();
    $(".select2").on("select2:select", function (evt) {
        var element = evt.params.data.element;
        var $element = $(element);

        $element.detach();
        $(this).append($element);
        $(this).trigger("change");
    });
});

$(document).on("click", ".folding", function () {
    let parent = this.closest(".ui-state-default");
    if (this.classList.contains("closed")) {
        $(parent).find(".dd-content").removeClass("card-hide");
        $(this).removeClass("closed");
    } else {
        $(parent).find(".dd-content").addClass("card-hide");
        $(this).addClass("closed");
    }
});

$(document).on("click", ".header-text", function () {
    $(this).closest(".ui-state-default").find(".folding").trigger("click");
});

$(document).on("click", ".delete-button", function () {
    $("#component-title").html(filterXSS($(this).data("component")));
    deletingSection = this.closest(".ui-state-default");
    deletingSectionId = $(this).data("component-id");
});

$(document).on("click", ".delete-section-btn", function () {
    toggleDeleteLoading();
    updateCustomForm(deletingSectionId);
    if (deletingSectionId === "0" || deletingSectionId === 0) {
        gridDeleted(null, true);
    } else {
        ajaxRequest($("#internal_form"), __gridDeleteUrl, gridDeleted, "post");
    }
});

const toggleDeleteLoading = () => {
    $(".delete-loading").toggleClass("d-none");
};

const gridDeleted = (form, data) => {
    $(".modal").modal("hide");
    toggleDeleteLoading();
    $(".delete-section-btn .spinner-border").remove();
    $(".delete-section-btn").removeClass("disabled-btn");
    $(".delete-section-btn").text(jsLang("Delete"));
    if (data) {
        deletingSection.remove();
        operationSuccess("Section deleted");
    } else {
        operationFailed("Section couldn't be deleted.");
    }
    deletingSection = undefined;
    deletingSectionId = undefined;
};

const updateFormButton = (form) => {
    $(form).find(".loading-spinner").toggleClass("d-none");
    $("#update_page .loading-spinner").toggleClass("d-none");
};

const updateAjaxMessage = (form, msg, className = "success") => {
    $(form).find(".message").html(msg);
    $(form).find(".message").addClass(`text-${className}`);
    setTimeout((form) => {
        $(form).find(".message").html("");
    }, 3000);
};

$(".img-delete-icon").click(function () {
    let group = $(this).closest(".form-group");
    $(group).find(".custom-file-input").val("");
    $(this).closest(".preview-image").html("");
});

const toggleSidebar = (child, show = true) => {
    let parent = getDraggableParent(child);
    if (show) {
        $(parent).find(".sidebarOption").removeClass("d-none");
    } else {
        $(parent).find(".sidebarOption").addClass("d-none");
    }
};

$(document).on("change", ".seeMore", function () {
    let parent = getDraggableParent(this);
    $(parent).find(".moreLink").toggleClass("d-none");
});

$(document).on("click", ".selectable", function () {
    $(this).closest('form').find(".selectable").removeClass("selectedBox");
    $(this).closest('form').find("#l_layout").val($(this).data("val"));
    $(this).addClass("selectedBox");
});

$(document).on("file-attached", ".media-manager", function (e, data) {
    let image = data.data[0];
    let name = $(this).data("name");
    $($(this).closest(".form-group"))
        .find(".preview-image")
        .html(imagePreview(image, name));
});

const imagePreview = (image, name) => {
    return `<div class="d-flex flex-wrap mt-2">
                <div class="position-relative border boder-1 media-box p-1 mr-2 rounded mt-2">
                    <div class="position-absolute rounded-circle text-center img-remove-icon"><i class="fa fa-times"></i>
                    </div>
                    <img class="upl-img neg-transition-scale" class="p-1"
                        src="${image.url}" alt="">
                    <input type="hidden" name="${name}" value="${image.path}">
                </div>
            </div>`;
};

$("#sortable").on("sortstop", function (event, ui) {
    let componentOrders = $("#sortable").sortable("toArray", {
        attribute: "data-id",
    });
    componentOrders.forEach((className, i) => {
        $(`.${className}`).val(i + 1);
    });
});

const addRowButton = (index, parent) => {
    return `<span class="accordion-row-action add-row-btn" data-parent="${parent}" data-index="${index}"><i class="feather icon-plus"></i>
        </span>`;
};

const removeRowButton = (index, parent) => {
    return `<span class="accordion-row-action remove-row-btn" data-parent="${parent}" data-index="${index + 1
        }"><i class="feather icon-minus"></i>
    </span>`;
};

const getCtaForm = (index, parent) => {
    let rs = getRandomString("id_");

    return `<div class="card cta-card mb-3">
                <div class="card-header p-2" id="headingOne">
                    <div class="mb-0 ac-switch d-flex closed justify-content-between align-items-center w-full curson-pointer" data-bs-toggle="collapse" data-bs-target="#${rs}" aria-expanded="true" aria-controls="${rs}">
                        <div>${jsLang("Call To Action")}</div>
                        <span class="b-icon">
                            <i class="feather icon-chevron-down collapse-status"></i>
                            <span class="accordion-action-group">
                                <span class="accordion-row-action remove-row-btn"
                                    data-index="${index + 1
        }" data-parent="${parent}" data-parent="${parent}"><i
                                        class="feather icon-minus"></i></span>
                                <span class="accordion-row-action add-row-btn" data-index="${index + 1
        }" data-parent="${parent}">
                                    <i class="feather icon-plus"></i>
                                </span>
                            </span>
                        </span>
                    </div>
                </div>
                <div id="${rs}" class="card-body parent-class collapse show" aria-labelledby="headingOne" data-parent=".${parent}" style="">
                    <div class="form-group row">
                        <div class="col-md-6">
                            <div class="form-group row">
                                <label class="col-sm-12 control-label">${jsLang(
            "Upper Subtitle"
        )}</label>
                                <div class="col-sm-12">
                                    <input type="text" class="form-control inputFieldDesign" value="" name="cta[${index}][upper_st]">
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group row">
                                <label class="col-sm-12 control-label">${jsLang(
            "Lower Subtitle"
        )}</label>
                                <div class="col-sm-12">
                                    <input type="text" class="form-control inputFieldDesign" value="" name="cta[${index}][lower_st]">
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group row">
                                <label class="col-sm-12 control-label">${jsLang(
            "Title"
        )}</label>
                                <div class="col-sm-12">
                                    <input type="text" class="form-control inputFieldDesign" value="" name="cta[${index}][title]">

                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group row">
                                <label class="col-sm-12 control-label">${jsLang(
            "Image"
        )}</label>
                                <div class="col-md-12">
                                    <div class="custom-file media-manager" data-val="single" id="image-status" data-name="cta[${index}][image]">
                                        <input class="custom-file-input form-control d-none inputFieldDesign" id="validatedCustomFile${uniqueNumber}" maxlength="50" accept="image/*" value="">
                                        <label class="custom-file-label overflow_hidden position-relative d-flex align-items-center" for="validatedCustomFile${uniqueNumber}">${jsLang(
            "Upload image"
        )}</label>
                                    </div>
                                    <div class="preview-image">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group row">
                                <label class="col-sm-12 control-label">${jsLang(
            "Button Text"
        )}</label>
                                <div class="col-sm-12">
                                    <input type="text" class="form-control inputFieldDesign" value="" name="cta[${index}][btn_text]">
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group row">
                                <label class="col-sm-12 control-label">${jsLang(
            "Button Link"
        )}</label>
                                <div class="col-sm-12">
                                    <input type="text" class="form-control inputFieldDesign" value="" name="cta[${index}][btn_link]">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>`;
};

const getSliderForm = (index, parent) => {
    let rs = getRandomString("id_");

    return `<div class="card cta-card mb-3">
                <div class="card-header p-2" id="headingOne">
                    <div class="mb-0 ac-switch d-flex closed justify-content-between align-items-center w-full curson-pointer collapsed" data-bs-toggle="collapse" data-bs-target="#${rs}" aria-expanded="false" aria-controls="${rs}">
                        <div>${jsLang("Slider")}</div>
                        <span class="b-icon">
                            <i class="feather icon-chevron-down collapse-status"></i>
                            <span class="accordion-action-group">
                                <span class="accordion-row-action remove-row-btn"
                                    data-index="${index + 1
        }" data-parent="${parent}" data-parent="${parent}"><i
                                        class="feather icon-minus"></i></span>
                                <span class="accordion-row-action add-row-btn" data-index="${index + 1
        }" data-parent="${parent}">
                                    <i class="feather icon-plus"></i>
                                </span>
                            </span>
                        </span>
                    </div>
                </div>
                <div id="${rs}" class="card-body collapse" aria-labelledby="headingOne" data-parent=".${parent}" style="">
                    <div class="form-group row">
                        <div class="col-md-6">
                            <div class="form-group row">
                                <label class="col-sm-12 control-label">${jsLang(
            "Upper Subtitle"
        )}</label>
                                <div class="col-sm-12">
                                    <input type="text" class="form-control inputFieldDesign" name="slider[${index}][u_subtitle]">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group row">
                                <label class="col-sm-12 control-label">${jsLang(
            "Lower Subtitle"
        )}</label>
                                <div class="col-sm-12">
                                    <input type="text" class="form-control inputFieldDesign" name="slider[${index}][l_subtitle]">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12 row parent-class m-0 p-0">
                            <div class="col-md-6">
                                <div class="form-group row">
                                    <label class="col-sm-12 control-label">${jsLang(
            "Title"
        )}</label>
                                    <div class="col-sm-12">
                                        <input type="text" class="form-control inputFieldDesign" name="slider[${index}][title]">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group row">
                                    <label class="col-sm-12 control-label">${jsLang(
            "Image"
        )}</label>
                                    <div class="col-sm-12">
                                        <div class="custom-file media-manager" data-name="slider[${index}][image]" data-val="single" id="image-status">
                                            <input class="custom-file-input form-control d-none inputFieldDesign" id="validatedCustomFile${uniqueNumber}" maxlength="50" accept="image/*">
                                            <label class="custom-file-label overflow_hidden position-relative d-flex align-items-center" for="validatedCustomFile${uniqueNumber}">${jsLang(
            "Upload image"
        )}</label>
                                        </div>
                                        <div class="preview-image">

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group row">
                                <label class="col-sm-12 control-label">${jsLang(
            "Button Text"
        )}</label>
                                <div class="col-sm-12">
                                    <input type="text" class="form-control inputFieldDesign" value="" name="slider[${index}][button_text]">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group row">
                                <label class="col-sm-12 control-label">${jsLang(
            "Link"
        )}</label>
                                <div class="col-sm-12">
                                    <input type="text" class="form-control inputFieldDesign" value="" name="slider[${index}][button_link]">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>`;
};

const getIconboxForm = (index, parent) => {
    let rs = getRandomString("id_");

    return `<div class="card cta-card mb-3">
                <div class="card-header p-2" id="headingOne">
                    <div class="mb-0 ac-switch d-flex closed justify-content-between align-items-center w-full curson-pointer" data-bs-toggle="collapse" data-bs-target="#${rs}" aria-expanded="true" aria-controls="${rs}">
                        <div>${jsLang("Icon Box")}</div>
                        <span class="b-icon">
                            <i class="feather icon-chevron-down collapse-status"></i>
                            <span class="accordion-action-group">
                                <span class="accordion-row-action remove-row-btn"
                                    data-index="${index + 1
        }" data-parent="${parent}" data-parent="${parent}"><i
                                        class="feather icon-minus"></i></span>
                                <span class="accordion-row-action add-row-btn" data-index="${index + 1
        }" data-parent="${parent}">
                                    <i class="feather icon-plus"></i>
                                </span>
                            </span>
                        </span>
                    </div>
                </div>
                <div id="${rs}" class="card-body parent-class collapse show" aria-labelledby="headingOne" data-parent=".${parent}" style="">
                    <div class="form-group row">
                        <div class="col-md-12">
                            <div class="form-group row">
                                <div class="col-md-12">
                                    <div class="preview-image">
                                    </div>
                                </div>
                                <label class="col-sm-12 control-label">${jsLang(
            "Icon"
        )}</label>
                                <div class="col-md-12">
                                    <div class="custom-file media-manager" data-name="iconbox[${index}][image]" data-val="single" id="image-status">
                                        <input class="custom-file-input form-control d-none inputFieldDesign" id="validatedCustomFile${uniqueNumber}" maxlength="50" value="">
                                        <label class="custom-file-label overflow_hidden position-relative d-flex align-items-center" for="validatedCustomFile${uniqueNumber}">Upload image</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group row">
                                <label class="col-sm-12 control-label">${jsLang(
            "Title"
        )}</label>
                                <div class="col-sm-12">
                                    <input type="text" class="form-control inputFieldDesign" value="" name="iconbox[${index}][title]">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group row">
                                <label class="col-sm-12 control-label">${jsLang(
            "Subtitle"
        )}</label>
                                <div class="col-sm-12">
                                    <input type="text" class="form-control inputFieldDesign" value="" name="iconbox[${index}][subtitle]">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>`;
};

var uniqueNumber = 11111111;
$(document).on("click", ".add-row-btn", function (e) {
    if ($(this).hasClass("__private")) {
        return;
    }

    e.stopPropagation();

    let index = parseInt($(this).data("index"));

    let parentId = $(this).data("parent");

    if (
        $(this).closest(".accordion-action-group").find(".remove-row-btn")
            .length == 0
    ) {
        $(removeRowButton(index, parentId)).insertAfter($(this));
    }

    uniqueNumber++;

    if ($(this).closest(".cta-accordion").length > 0) {
        $(this).closest(".cta-accordion").append(getCtaForm(index, parentId));
    } else if ($(this).closest(".slider-accordion").length > 0) {
        $(this)
            .closest(".slider-accordion")
            .append(getSliderForm(index, parentId));
    } else if ($(this).closest(".iconbox-accordion").length > 0) {
        $(this)
            .closest(".iconbox-accordion")
            .append(getIconboxForm(index, parentId));
    }

    $(this).remove();
});

$(document).on("click", ".remove-row-btn", function () {
    if ($(this).hasClass("__private")) {
        return;
    }
    if (
        $(this).closest(".accordion-action-group").find(".add-row-btn").length >
        0
    ) {
        let index = parseInt($(this).data("index"));

        let parentId = $(this).data("parent");

        let previousCardActionGroup = $(this)
            .closest(".cta-card")
            .prev()
            .find(".accordion-action-group");

        previousCardActionGroup.append(addRowButton(index, parentId));
    }
    let accordions = $(this).closest(".accordion").children();

    $(this).closest(".cta-card").remove();

    if (accordions.length === 2) {
        accordions.find(".remove-row-btn").remove();
    }
});

const getRandomString = (_prefix = "") => {
    return _prefix + (Math.random() + 1).toString(36).substring(7);
};

jQuery.extend({
    /**
     * @param {string} _url Request url
     * @param {object} _data Data needed to pass along
     * @param {*} _options={method,datatype,success,failed,callbackParam}
     * @ _options: {
     * @    type: get ["get", "post"]
     * @    dataType: "json" [String]
     * @    success: undefined [Callback]
     * @    failed: Closure [Callback]
     * @    callbackParam: false [Any]
     * @    formdata: false
     * @ }
     */
    makeAjaxCall: function (form, _url, _options = {}, _data = {}) {
        let { defaults, data } = {
            defaults: {
                type: "get",
                dataType: "json",
                processData: false,
                contentType: "json",
                success: defaultResponseHandler,
                failed: defaultResponseHandler,
                callbackParam: false,
                formdata: false,
            },
            data: {
                _token: token,
                data: form.find("input,select,textarea").serialize(),
            },
        };

        defaults.callbackParam = { form: form };

        $("input,textarea,select").prop("disabled", true);

        defaults = Object.assign({}, defaults, _options);

        if (defaults.formdata) {
            data = defaults.formdata;
        } else {
            data = Object.assign({}, data, _data);
        }

        $.ajax({
            url: _url,
            type: defaults.type,
            dataType: defaults.dataType,
            data: data,
            success: function (data) {
                defaults.success(defaults.callbackParam, data);
                ajaxUpdated();
            },
            error: function (xhr, status, error) {
                defaults.failed(xhr, status, error);
                ajaxFailed();
            },
            complete: function (jXhr, textStatus) {
                removeButtonLoader();
            },
        });
    },
});

const defaultResponseHandler = (params, response) => {
    unblockEverything();
};

const ajaxUpdated = () => {
    triggerNotification(jsLang("Action completed."));
};

const ajaxFailed = () => {
    triggerNotification(
        jsLang("Request failed. Check network tab for details.")
    );
};

const triggerNotification = (msg) => {
    $(".notification-msg-bar").find(".notification-msg").html(msg);
    $(".notification-msg-bar").removeClass("smoothly-hide");
    setTimeout(() => {
        $(".notification-msg-bar").addClass("smoothly-hide"),
            $(".notification-msg-bar").find(".notification-msg").html("");
    }, 1500);
};

$(document).on("click", ".has-spinner-loader", function () {
    $(this).append(
        '<div class="spinner-border spinner-border-sm ml-2" role="status"><span class="sr-only">Loading...</span></div>'
    );
    $(this).addClass("disabled-btn");
});

const removeButtonLoader = () => {
    $(".has-spinner-loader").removeClass("disabled-btn");
    $(".spinner-border").remove();
    $(".spinner-border-sm").remove();
    $("input,textarea,select").prop("disabled", false);
};

$(document).on("change", ".product-type", function () {
    if ($(this).val() == "queryProducts") {
        $(this)
            .closest(".component_form")
            .find(".queryOptions")
            .addClass("d-flex").removeClass("d-none");
    } else {
        $(this)
            .closest(".component_form")
            .find(".queryOptions")
            .addClass("d-none").removeClass("d-flex");
    }
});

$(document).on("change", ".product-col, .product-row", function () {
    let row = $(this).closest(".product-count").find(".product-row").val();
    let col = $(this).closest(".product-count").find(".product-col").val();

    if (row && row > 12) {
        row = 12;
    } else if (row && row <= 0) {
        row = 1;
    }

    if (col && col > 12) {
        col = 12;
    } else if (col && col <= 0) {
        col = 1;
    }

    $(this).closest(".product-count").find(".product-row").prop("value", row);
    $(this).closest(".product-count").find(".product-col").prop("value", col);

    let total = row * col;

    if (
        $(this).closest(".component_form").find(".sidebar_options").val() ==
        "flash_sale"
    ) {
        total++;
    }
    $(this)
        .closest(".product-count")
        .find(".product-quantity")
        .prop("value", total);
});

