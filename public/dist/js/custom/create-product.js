"use strict";
$(function () {
    $(document).on("blur", "#item_name", function () {
        blockElement($(this).closest(".blockable"));
        let data = { name: $(this).val(), action: "update_basic_info" };
        $.makeAjaxCall(itemUrl, data, {
            type: "post",
            success: productNameUpdateHandler,
        });
    });

    const productNameUpdateHandler = (param, response) => {
        unblockEverything();
        response.status.message = jsLang("Product name updated.");
        ajaxNotify(response.status);
    };

    $(document).on("click", ".add-new-attribute", function () {
        let attr = $("#attribute-list").val();
        var found = false;
        $(".attr_id").each(function () {
            if ($(this).val() == attr) {
                $(this)
                    .closest(".ui-sortable-handle")
                    .find(".toggle-btn.inactive-sec")
                    .trigger("click");
                found = true;
                return false;
            }
        });
        if (found) {
            return;
        }
        let blockable = $(this).closest(".tab-content");
        blockElement(blockable);
        $.makeAjaxCall(
            itemUrl,
            {
                attr_id: attr,
                index: countHelper.attributes,
                action: "get_attribute_form",
            },
            {
                type: "post",
                success: addNewAttributeHandler,
                callbackParam: { blockable: blockable },
            }
        );
    });

    const addNewAttributeHandler = (params, response) => {
        let html = response.records.form;
        $(".attribute-item-lists").append(html);
        ajaxNotify(response.status);
        params.blockable.unblock();
        refreshCount();
        resetSelect2Fields();
        refreshConditionalTabVisibility();
    };

    $(document).on("keyup", ".attribute-name", function () {
        $(this)
            .closest(".ui-sortable-handle")
            .find(".attribute-box-title")
            .text($(this).val());
    });

    $(document).on("click", ".save_attributes", function () {
        let data = getAttributeData();
        let blockable = $(this).closest(".blockable");
        blockElement(blockable);
        $.makeAjaxCall(
            itemUrl,
            { data: data, action: "add_new_attribute" },
            {
                type: "post",
                success: saveAttributeHandler,
                callbackParam: { blockable: blockable },
            }
        );
    });

    const getAttributeData = () => {
        return $(".attribute-parent-box")
            .find("input,select,textarea")
            .serialize();
    }

    const saveAttributeHandler = (params, response) => {
        params.blockable.unblock();
        if (response.status.code !== 200) {
            ajaxNotify(response.status);
        } else {
            loadVariationRequest({ blockable: params.blockable });
            ajaxNotify(response.status);
        }
    };

    const loadVariationRequest = (params = {}) => {
        $.makeAjaxCall(
            itemUrl,
            {
                action: "load_product_variations",
            },
            {
                type: "post",
                success: handleLoadVariationAction,
                callbackParam: params,
            }
        );
    };

    $(document).on("click", ".save_variations", function () {
        let data = getVariationData()
        let blockable = $(this).closest(".blockable");
        blockElement(blockable);
        $.makeAjaxCall(
            itemUrl,
            { data: data, action: "save_product_variation" },
            {
                success: handleSaveVariationDataAction,
                type: "post",
                callbackParam: { blockable: blockable },
            }
        );
    });

    $(document).on("click", ".save_b2b", function () {
        let data = getB2BData()
        let blockable = $(this).closest(".blockable");
        blockElement(blockable);
        $.makeAjaxCall(
            itemUrl,
            { data: data, action: "save_product_b_2_b" },
            {
                success: handleSaveVariationDataAction,
                type: "post",
                callbackParam: { blockable: blockable },
            }
        );
    });

    const getVariationData = () => {
        return $(".variations-list")
            .find("input,select,textarea")
            .serialize();
    }

    const getB2BData = () => {
        return $(".b2b-prices")
            .find("input,select,textarea")
            .serialize();
    }

    const handleSaveVariationDataAction = (params, response) => {
        loadVariationRequest();
        ajaxNotify(response.status);
    };

    $(document).on("click", ".add-new-variant", function () {
        let blockable = $(this).closest(".tab-content");
        blockElement(blockable);
        $.makeAjaxCall(
            itemUrl,
            {
                type: $(".variation-type").val(),
                action: "add_product_variation",
                index: countHelper.variations,
            },
            {
                type: "post",
                success: handleAddVariationAction,
                callbackParam: { blockable: blockable },
            }
        );
    });

    const handleAddVariationAction = (params, response) => {
        let parent = $(response.records.html);
        renewDatePickers(parent);
        $(".variation-item-lists").append(parent);
        refreshDatePickers();
        ajaxNotify(response.status);
        resetSelect2Fields();
        refreshCount();
        checkPriceCount();
        if (params.blockable) params.blockable.unblock();
    };

    const handleLoadVariationAction = (params, response) => {
        let parent = $(response.records.html);
        renewDatePickers(parent);
        $(".variations-list").html(response.records.html);
        resetSelect2Fields();
        refreshDatePickers();
        unblockEverything();
        checkPriceCount();
    };

    /**
     * Sends delete attribute request
     * @return void
     */
    $(document).on("submit", ".delete_attribute", function (e) {
        e.preventDefault();
        let blockable = $(this).closest(".blockable");
        blockElement(blockable);
        let name = $(this)
            .closest(".ui-sortable-handle")
            .find(".attribute-name")
            .val();
        $.makeAjaxCall(
            itemUrl,
            { attr_name: name, action: "delete_attribute" },
            {
                type: "post",
                success: handleDeleteAttributeAction,
                callbackParam: {
                    attr: $(this).closest(".ui-sortable-handle"),
                    blockable: blockable,
                },
            }
        );
    });

    /**
     * Sends delete attribute request
     * @return void
     */
    $(document).on("submit", ".delete_variation", function (e) {
        e.preventDefault();
        let blockable = $(this).closest(".blockable");
        blockElement(blockable);
        let vi = $(this)
            .closest(".ui-sortable-handle")
            .find(".variable_post")
            .val();
        $.makeAjaxCall(
            itemUrl,
            { vi: vi, action: "delete_variation" },
            {
                type: "post",
                success: handleDeleteVariationAction,
                callbackParam: {
                    var: $(this).closest(".ui-sortable-handle"),
                    blockable: blockable,
                },
            }
        );
    });

    const handleDeleteAttributeAction = (params, response) => {
        if (response.status.code !== 200) {
            unblockEverything();
            return;
        }
        ajaxNotify(response.status);
        params.blockable.unblock();
        params.attr.remove();
        refreshCount();
        loadVariationRequest();
    };

    const handleDeleteVariationAction = (params, response) => {
        if (response.status.code !== 200) {
            unblockEverything();
            return;
        }
        ajaxNotify(response.status);
        params.blockable.unblock();
        params.var.remove();
        refreshCount();
        checkPriceCount();
    };

    $(document).on("click", ".save-permalink", function () {
        let permalink = $(".edit-permalink").val();
        let parent = $(this).closest(".blockable");
        blockElement(parent);
        $.makeAjaxCall(
            itemUrl,
            { permalink: permalink, action: "update_permalink" },
            {
                type: "post",
                success: handleUpdatePermalinkAction,
                callbackParam: {
                    blockable: parent,
                },
            }
        );
    });

    const handleUpdatePermalinkAction = (params, response) => {
        $(".edit-permalink").val(response.records.permalink);
        $(".preview-link").attr("href", response.records.previewUrl);
        $(".edit-permalink").trigger("updated");
        ajaxNotify(response.status);
        params.blockable.unblock();
    };

    $(document).on("change", "#category_id", function () {
        blockElement($(this).closest(".blockable"));
        $.makeAjaxCall(
            itemUrl,
            { category: $(this).val(), action: "update_basic_info" },
            { type: "post", success: categoryUpdateHandler }
        );
    });

    const categoryUpdateHandler = (params, response) => {
        unblockEverything();
        response.status.message = jsLang("Category updated.");
        ajaxNotify(response.status);
    };

    $(document).on("click", ".update-item-button", function () {
        blockElement($(".list-container"));
        removeCodeViewSummerNote();
        // store variations first
        // then go for the product store
        updateProductVariation();
    });

    function removeCodeViewSummerNote()
    {
        if ($('.summernote').summernote('codeview.isActivated')) {
            $('.summernote').summernote('codeview.deactivate');
        }
    }

    const updateProductVariation = () => {
        let data = getVariationData()
        $.makeAjaxCall(
            itemUrl,
            { data: data, action: "save_product_variation" },
            {
                success: updateProductItself,
                failed: updateProductItself,
                type: "post",
            }
        );
    }

    const updateProductItself = () => {
        let data = $(".mini-form-holder")
            .find("input,select,textarea")
            .serialize();
        $(".ajax-form-data").val(data);
        $(".ajax-form-action").val("update_basic_info_web");
        $("#ajaxReloadForm").trigger("submit");
    }

    $(".attribute_sortable").on("sortstop", function (event, ui) {
        let componentOrders = $(".attribute_sortable").sortable("toArray", {
            attribute: "data-serial",
        });
        componentOrders.forEach((it, i) => {
            $(`input[name="attribute_position[${it}]"]`).val(i);
        });
    });

    $(document).on("click", ".save-brand-info", function () {
        blockElement($(this).closest(".blockable"));
        $.makeAjaxCall(
            itemUrl,
            {
                data: $(this)
                    .closest(".mini-form-holder")
                    .find("select,input,textarea")
                    .serialize(),
                action: "update_basic_info",
            },
            { type: "post" }
        );
    });

    $(document).on("click", ".media-store", function () {
        blockElement($(this).closest(".blockable"));
        $.makeAjaxCall(
            itemUrl,
            {
                data: $(this)
                    .closest(".mini-form-holder")
                    .find("input[type=hidden]")
                    .serialize(),
                action: "update_basic_info",
            },
            { type: "post", success: productMediaHandler }
        );
    });

    const productMediaHandler = (params, response) => {
        unblockEverything();
        response.status.message = jsLang("Product media updated.");
        ajaxNotify(response.status);
    };

    $(document).on("change", ".has_impact", function () {
        let names = $(this).data("name").split(",").filter(name => name.trim() !== '');
        let otherImpacters = 0;
        let thisChecked = $(this).is(":checked");
        names.forEach((name) => {
            otherImpacters = $(`.has_impact:checked[data-name=${name}]`).length;
            if (otherImpacters === 1 && thisChecked) {
                $(this)
                    .closest(".impact_parent")
                    .find(`.on_impact[data-name=${name}]`)
                    .show();
                $(this)
                    .closest(".impact_parent")
                    .find(`.off_impact[data-name=${name}]`)
                    .hide();
            } else if (otherImpacters === 0 && !thisChecked) {
                $(this)
                    .closest(".impact_parent")
                    .find(`.on_impact[data-name=${name}]`)
                    .hide();
                $(this)
                    .closest(".impact_parent")
                    .find(`.off_impact[data-name=${name}]`)
                    .show();
            }
        });
    });

    $(document).on("file-attached", ".seo-image", function (e, param) {
        let data = param.data;
        $(this)
            .closest(".preview-parent")
            .find(".preview-image")
            .html(renderFilePreview(data, $(this).data("name")));
    });

    $(document).on("file-attached", ".downloadable-file", function (e, param) {
        let data = param.data[0];
        $(this)
            .closest(".downloadable-row")
            .find(".downloadable-name")
            .val(data.name);
        $(this)
            .closest(".downloadable-row")
            .find(".downloadable-url")
            .val(data.url);
    });

    $(document).on("file-attached", ".product-image", function (e, param) {
        let data = param.data;
        $(this)
            .closest(".preview-parent")
            .find(".preview-image")
            .append(renderFilePreview(data, $(this).data("name")));
    });

    $(document).on("file-attached", ".video-uploader", function (e, param) {
        let data = param.data;
        $(this)
            .closest(".preview-parent")
            .find(".preview-video")
            .append(renderVideoPreview(data, $(this).data("name")));
    });

    $(document).on("file-attached", ".variation-image", function (e, param) {
        $(this)
            .closest(".variation-image-container")
            .html(
                getVariationImagePreview(param.data[0], $(this).data("name"))
            );
    });

    $(document).on("click", ".variation-image-remove", function () {
        $(this)
            .closest(".variation-image-container")
            .html(getVariationImagePreviewDefault($(this).data("name")));
    });

    $(document).on("file-detached", ".media-box", function (e, param) {
        let deletingId = $(this).find("input[name=file_id[]]").val();
    });

    const handleSeoUpdateAction = (params, response) => {
        unblockEverything();
        params.blockable.unblock();
        response.status.message = jsLang("Product seo updated.");
        ajaxNotify(response.status);
    };

    $(document).on("click", ".seo-update", function () {
        let blockable = $(this).closest(".blockable");
        let data = $(this)
            .closest(".mini-form-holder")
            .find("input,select,textarea")
            .serialize();
        blockElement(blockable);
        $.makeAjaxCall(
            itemUrl,
            { data: data, action: "update_basic_info" },
            {
                type: "post",
                success: handleSeoUpdateAction,
                callbackParam: { blockable: blockable },
            }
        );
    });

    $(document).on("change", "input[name=video_input]", function () {
        if ($(this).val() == "file") {
            $(".video-file-upload")
                .closest(".video-uploader")
                .addClass("has-media-manager");
            $(".video-file-upload").removeClass("save-url");
            $(".video-link-upload").attr("disabled", "disabled");
            $(".video-label").text(jsLang("Browse"));
        } else {
            $(".video-file-upload")
                .closest(".video-uploader")
                .removeClass("has-media-manager");
            $(".video-file-upload").addClass("save-url");
            $(".video-label").text(jsLang("Save Url"));
            $(".video-link-upload").attr("disabled", false);
        }
    });

    $(document).on("click", ".save-url", function () {
        addNewVideoUrl();
    });

    $(document).on("keyup", ".video-link-upload", function (e) {
        e.preventDefault();
        if (e.keyCode === 13) {
            addNewVideoUrl();
        }
    });

    $(document).on("submit", "#itemForm", function (e) {
        e.preventDefault();
    });

    const addNewVideoUrl = () => {
        if ($("input[name=video_input]:checked").val() == "file") {
            return;
        }
        let link = $(".video-link-upload").val();
        $(".video-urls").append(getVideoUrlPreview(filterXSS(link)));
    };

    $(document).on("click", ".remove-url", function () {
        $(this).closest(".video-url").remove();
    });

    $(document).on("click", ".remove-product-image", function () {
        $(this).closest(".img-box-two").remove();
    });

    $(document).on("click", ".add-downloadables", function () {
        let count = $(this)
            .closest(".section-downloadable")
            .find(".downloadable-row").length;
        let idx = JSON.stringify($(this).data("idx") ?? "");
        $(this)
            .closest(".section-downloadable")
            .find("tbody")
            .append(getDownloadableRow(count, idx));
    });

    $(document).on("click", ".add-b2b", function () {
        let count = $(this)
            .closest(".enable_b2b")
            .find(".b2b_row").length;
        let idx = JSON.stringify($(this).data("idx") ?? "");
        $(this)
            .closest(".enable_b2b")
            .find(".b2b_div")
            .append(getB2BRow(count, idx));
    });

    $(document).on("click", ".sec-dlt", function () {
        $(this).closest(".downloadable-row").remove();
    });

    $(document).on("click", ".delete_b2b", function () {
        $(this).closest(".b2b_row").remove();
    });

    $(document).on("change", ".product-type", function () {
        let className = "__";
        let val = $(this).val();
        if (val === "Variable Product") {
            className = "not-variable-dom";
        } else if (val === "Simple Product") {
            className = "not-simple-dom";
        } else if (val === "Grouped Product") {
            className = "not-grouped-dom";
        } else if (val === "External/Affiliate Product") {
            className = "not-external-dom";
        }
        toggleConditionalTabVisibility(className);
    });

    const toggleConditionalTabVisibility = (className) => {
        $(".conditional-dom").each(function () {
            if ($(this).hasClass(className)) {
                $(this).addClass("d-none");
            } else {
                $(this).removeClass("d-none");
            }
        });
        switchDataTab(className);
    };

    const switchDataTab = (className) => {
        let existing = $(`.nav-item.conditional-dom.${className} .active`);
        if (existing.length < 1) {
            return;
        }
        $(`.nav-item.conditional-dom`).each(function () {
            if (!$(this).hasClass(className) && !$(this).hasClass("d-none")) {
                $(this).find(".nav-link").tab("show");
                return false;
            }
            return true;
        });
    };

    const refreshConditionalTabVisibility = () => {
        $(".product-type").trigger("change");
    };

    $(document).on("click", "#confirmDeleteSubmitBtn", function () {
        $(this).closest(".modal-footer").find(".close").trigger("click");
    });

    $("#addAttribute").on("show.bs.modal", function (e) {
        let newAttributeButton = $(e.relatedTarget);
        let modal = $(this);
        modal.find(".modal-title").html(newAttributeButton.data("title"));
        modal
            .find(".modal-body label")
            .html(newAttributeButton.data("message"));
        modal.find(".targetAttrId").val(newAttributeButton.data("id"));
        modal.find(".sectionId").val(newAttributeButton.data("section"));
    });

    $(document).on("click", "#confirmAttributeSubmit", function () {
        let modal = $("#addAttribute");
        $.makeAjaxCall(
            itemUrl,
            {
                attribute_id: modal.find(".targetAttrId").val(),
                value: modal.find(".newAttributeValue").val(),
                action: "add_new_attribute_value",
            },
            {
                callbackParam: { aSection: modal.find(".sectionId").val() },
                success: handleAddNewAttributeValue,
                failed: handleAddNewAttributeValue,
            }
        );
    });

    const handleAddNewAttributeValue = (params, response) => {
        if (response?.status?.code == 201) {
            let selectField = $(`#${params.aSection}`).find("select.select2");
            selectField.append(
                $("<option>", {
                    value: response.records.attribute.id,
                    text: response.records.attribute.value,
                    selected: "selected",
                })
            );
        }
        removeButtonLoader();
        $("#addAttribute").find(".close").trigger("click");
        $(".attribute-form").trigger("reset");
        ajaxNotify(response.status);
    };

    $(document).on("keyup change", ".sale_price", function () {
        let sp = Number($(this).val());
        let rp = Number(
            $(this).closest(".price_div").find(".regular_price").val()
        );
        if (isNaN(rp) || rp == 0) {
            $(this).val("");
            addInputErrorMessage(
                $(this).parent(),
                jsLang("Define a valid regular price.")
            );
        } else if (!isNaN(rp) && !isNaN(sp) && rp <= sp) {
            $(this).val("");
            addInputErrorMessage(
                $(this).parent(),
                jsLang("Sell price must be less than regular price.")
            );
        } else {
            removeInputErrorMessage($(this).closest(".price_div"));
        }
    });

    $(document).on("blur change", ".max_qty", function () {
        let max_qty = Number($(this).val());
        let min_qty = Number(
            $(this).closest(".b2b_row").find(".min_qty").val()
        );
        if (isNaN(min_qty) || min_qty == 0) {
            $(this).val("");
            addInputErrorMessage(
                $(this).parent(),
                jsLang("Define a valid minimum quantity.")
            );
        } else if (!isNaN(min_qty) && !isNaN(max_qty) && min_qty >= max_qty) {
            $(this).val("");
            addInputErrorMessage(
                $(this).parent(),
                jsLang("Maximum quantity must be greater than minimum quantity.")
            );
        } else {
            removeInputErrorMessage($(this).closest(".b2b_row"));
        }
    });

    $(document).on("keyup", ".regular_price", function () {
        checkPriceCount();
    });

    /**
     * ============================================================================
     * ======================== Helper functions ==================================
     * ============================================================================
     */

    const removeInputErrorMessage = (div = null) => {
        if (div == null) {
            $(".err-msg").remove();
        } else {
            $(div).find(".err-msg").remove();
        }
    };

    const addInputErrorMessage = (div, message) => {
        if ($(div).find(".err-msg").length > 0) {
            $(div).find(".err-msg").html(message);
        } else {
            $(div).append(
                `<small class="err-msg text-danger">${message}</small>`
            );
        }
    };

    /**
     * Count number of current attributes and variations
     */
    const refreshCount = () => {
        countHelper.attributes = $(".attribute-parent-box").children().length;
        countHelper.variations = $(".variation-item-lists").children().length;
        $(".variation-count").html(countHelper.variations);
        $(".attribute-count").html(countHelper.attributes);
    };

    const blockElement = (element, _data = {}) => {
        let options = Object.assign(
            {},
            {
                message: `<div class="spinner-border text-warning" role="status"><span class="sr-only">Loading...</span></div>`,
                css: {
                    backgroundColor: "transparent",
                    border: "none",
                },
            },
            _data
        );
        element.block(options);
    };

    const resetSelect2Fields = () => {
        $("select.select2").select2({
            allowClear: false,
            placeholder: jsLang("Select an option"),
        });

        $("select.select2clearable").select2({
            allowClear: true,
            placeholder: jsLang("Select an option"),
        });
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
        makeAjaxCall: function (_url, _data = {}, _options = {}) {
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
                data: { _token: token },
            };

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
                    $(".spinner-border").remove();
                    handleCreatedProduct(data.response);
                    defaults.success(defaults.callbackParam, data.response);
                },
                error: function (xhr, status, error) {
                    $(".spinner-border").remove();
                    defaults.failed(xhr, status, error);
                },
            });
        },
    });

    const defaultResponseHandler = (params, response) => {
        unblockEverything();
        ajaxNotify(response?.status ?? {});
    };

    const unblockEverything = () => {
        $(".blockUI").each(function () {
            $(this).parent().unblock();
        });
    };

    const handleCreatedProduct = (response) => {
        if (!response) {
            return;
        }

        if (response.url) {
            itemUrl = response.url;
            $("#ajaxReloadForm").attr("action", response.url);
        }

        if (response.permalink) {
            $(".edit-permalink").val(response.permalink);
            $(".preview-link").attr("href", response.previewUrl);
            $(".edit-permalink").trigger("updated");
            $(".permalink-section").removeClass('d-none');
            $(".permalink-section").addClass('d-flex');
        }

        if (response.name) {
            $("#item_name").val(response.name);
        }
    };

    const renderFilePreview = (files, name) => {
        let html = "";
        if (files.length) {
            files.forEach((file) => {
                html += getFilePreview(file, name);
            });
        } else {
            html = getFilePreview(files, name);
        }
        return html;
    };

    const ajaxNotify = (data) => {
        if (data?.code == 200 || data?.status == 201) {
            return successNotification(
                data?.message ?? jsLang("Process completed successfully.")
            );
        }
        return failedNotification(
            data?.message ??
            jsLang(
                "Failed to process the request. Check network log for more information."
            )
        );
    };

    const successNotification = (msg) => {
        triggerNotification("alert-success", msg);
    };

    const failedNotification = (msg) => {
        triggerNotification("alert-danger", msg);
    };

    const triggerNotification = (className, msg) => {
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
    };

    const renewDatePickers = (element) => {
        element
            .find(".start_date,.end_date")
            .daterangepicker(clearableDateRangePickerConf())
            .on("apply.daterangepicker", function (e, picker) {
                datePickerUpdatedEvent(this);
            });
    };

    const checkPriceCount = () => {
        let emptyPriceCounter = 0;
        $(".variations-list")
            .find(".regular_price")
            .each(function () {
                if ($(this).val() == "") {
                    emptyPriceCounter++;
                    return false;
                }
            });
        if (emptyPriceCounter > 0) {
            $(".no-price-warning").show();
        } else {
            $(".no-price-warning").hide();
        }
    };

    /**
     *
     * ==========================================================================
     * ==================== Document on ready functions =========================
     * ==========================================================================
     *
     */
    $(".select-ajax").select2({
        ajax: {
            url: itemsAjaxSearch,
            dataType: "json",
            delay: 250,
            data: function (params) {
                return {
                    q: params.term, // search term
                    page: params.page,
                };
            },
            processResults: function (data, params) {
                let results = data.data;
                return {
                    results: results,
                };
            },
            cache: true,
        },
        placeholder: jsLang("Search for products by name or slug."),
        minimumInputLength: 3,
    });

    $(".select-ajax-tags").select2({
        ajax: {
            url: tagsAjaxSearch,
            dataType: "json",
            delay: 250,
            data: function (params) {
                return {
                    q: params.term, // search term
                    page: params.page,
                };
            },
            processResults: function (data, params) {
                let results = data.data;
                return {
                    results: results,
                };
            },
            cache: true,
        },
        placeholder: jsLang("Search tags by name"),
        minimumInputLength: 3,
        tags: true,
    });

    $("select.select2clearable").select2({
        allowClear: true,
        placeholder: jsLang("Select an option"),
    });

    resetSelect2Fields();
    refreshCount();
    $(".attribute_sortable").sortable({});
    $(".variation_sortable").sortable({});
    refreshConditionalTabVisibility();
    // permalink

    if ($(".customs-permalink").val().length > 16) {
        $(".permalink-msg").html(
            $(".customs-permalink").val().substring(0, 16) + "..."
        );
    } else {
        $(".permalink-msg").html($(".customs-permalink").val());
    }

    $(".options-add").on("click", function () {
        $(".permalink-msg").hide();
        $(".customs-permalink").removeClass("d-none");
    });
    $(document).on("updated", ".customs-permalink", function () {
        $(".permalink-msg").html($(".customs-permalink").val()).show();
        $(".customs-permalink").addClass("d-none");
        if ($(".customs-permalink").val().length > 16) {
            $(".permalink-msg").html(
                $(".customs-permalink").val().substring(0, 16) + "..."
            );
        }
    });

    $(".cancel-button").on("click", function () {
        $(".permalink-msg").show();
        $(".customs-permalink").addClass("d-none");
    });

    checkPriceCount();

    /**
     *
     * ==========================================================================
     * ============================= HTML Renderers =============================
     * ==========================================================================
     *
     */
    const renderVideoPreview = (videos) => {
        let html = "";
        videos.forEach((video) => {
            html += `<div class="img-box-two video-prev mt-20p">
                        <video controls src="${video.url}">
                            ${jsLang(
                "Sorry, your browser doesn't support embedded videos."
            )}
                        </video>
                        <input type="hidden" name="meta_video_files[]" value="${video.path
                }">
                        <svg class="svg-postion cursor-pointer remove-product-image" width="14" height="14" viewBox="0 0 14 14"
                            fill="none" xmlns="http://www.w3.org/2000/svg">
                            <circle cx="7" cy="7" r="7" fill="#FCCA19" />
                            <path fill-rule="evenodd" clip-rule="evenodd"
                                d="M4.21967 4.21967C4.51256 3.92678 4.98744 3.92678 5.28033 4.21967L9.78033 8.71967C10.0732 9.01256 10.0732 9.48744 9.78033 9.78033C9.48744 10.0732 9.01256 10.0732 8.71967 9.78033L4.21967 5.28033C3.92678 4.98744 3.92678 4.51256 4.21967 4.21967Z"
                                fill="#2C2C2C" />
                            <path fill-rule="evenodd" clip-rule="evenodd"
                                d="M9.78033 4.21967C9.48744 3.92678 9.01256 3.92678 8.71967 4.21967L4.21967 8.71967C3.92678 9.01256 3.92678 9.48744 4.21967 9.78033C4.51256 10.0732 4.98744 10.0732 5.28033 9.78033L9.78033 5.28033C10.0732 4.98744 10.0732 4.51256 9.78033 4.21967Z"
                                fill="#2C2C2C" />
                        </svg>
                    </div>`;
        });
        return html;
    };

    const getFilePreview = (file, name) => {
        if(videoExtensions.map((extension) => file.url.includes(extension)).includes(true)){
            var src = `<video class="fit-boxed neg-transition-scale">
                        <source src="${file.url}" type="video/mp4">
                       </video>`
        }else{
            var src = `<img class="fit-boxed neg-transition-scale" src="${file.url}" alt="${file.name}">`
        }
        return `<div class="img-box-two mt-4">
                    ${src}
                    <input type="hidden" value="${file.path}" name="${name}">
                    <svg class="svg-postion cursor-pointer remove-product-image" width="14" height="14" viewBox="0 0 14 14"
                        fill="none" xmlns="http://www.w3.org/2000/svg">
                        <circle cx="7" cy="7" r="7" fill="#FCCA19">
                        </circle>
                        <path fill-rule="evenodd" clip-rule="evenodd"
                            d="M4.21967 4.21967C4.51256 3.92678 4.98744 3.92678 5.28033 4.21967L9.78033 8.71967C10.0732 9.01256 10.0732 9.48744 9.78033 9.78033C9.48744 10.0732 9.01256 10.0732 8.71967 9.78033L4.21967 5.28033C3.92678 4.98744 3.92678 4.51256 4.21967 4.21967Z"
                            fill="#2C2C2C"></path>
                        <path fill-rule="evenodd" clip-rule="evenodd"
                            d="M9.78033 4.21967C9.48744 3.92678 9.01256 3.92678 8.71967 4.21967L4.21967 8.71967C3.92678 9.01256 3.92678 9.48744 4.21967 9.78033C4.51256 10.0732 4.98744 10.0732 5.28033 9.78033L9.78033 5.28033C10.0732 4.98744 10.0732 4.51256 9.78033 4.21967Z"
                            fill="#2C2C2C"></path>
                    </svg>
                </div>`;
    };

    const getVariationImagePreview = (file, name) => {
        return `<div class="d-flx align-items-center">
                    <div class="position-relative border u-img-box">
                        <input type="hidden" class="variable-image" value="${file.path
            }" name="${name}">
                        <img class="h-100 w-100 object-fit-contain variation-image-placeholder"
                            src="${file.url}" />
                    </div>
                    <a href="javascript:void(0)" data-name="${name}" data-val="single"
                        class="btn-cancels ml-20p variation-image-remove">
                        ${jsLang("Remove")}
                    </a>
                </div>`;
    };

    const getVariationImagePreviewDefault = (name) => {
        return `<div class="d-flx align-items-center rtl:gap-2">
                    <div class="position-relative border u-img-box">
                        <img class="h-100 w-100 object-fit-contain variation-image-placeholder"
                            src="${variationImagePlaceholder}" />
                    </div>
                    <a href="javascript:void(0)" data-name="${name}" data-val="single"
                        class="btn-cancels ml-20p variation-image has-media-manager">
                        ${jsLang("Upload Photo")}
                    </a>
                </div>`;
    };

    const getVideoUrlPreview = (url) => {
        return `<div class="video-url d-flx mt-n2">
                    <span>Video URL:</span>
                    <a class="m-change ml-2" target="_blank" href="${url}">${url}</a>
                    <input type="hidden" name="meta_video_url[]" value="${url}">
                    <span class="remove-url remove-url d-flex align-items-center ml-2">
                    <svg class="cursor-pointer remove-product-image"
                            width="14" height="14" viewBox="0 0 14 14" fill="none"
                            xmlns="http://www.w3.org/2000/svg">
                            <circle cx="7" cy="7" r="7" fill="#FCCA19"></circle>
                            <path fill-rule="evenodd" clip-rule="evenodd"
                                d="M4.21967 4.21967C4.51256 3.92678 4.98744 3.92678 5.28033 4.21967L9.78033 8.71967C10.0732 9.01256 10.0732 9.48744 9.78033 9.78033C9.48744 10.0732 9.01256 10.0732 8.71967 9.78033L4.21967 5.28033C3.92678 4.98744 3.92678 4.51256 4.21967 4.21967Z"
                                fill="#2C2C2C"></path>
                            <path fill-rule="evenodd" clip-rule="evenodd"
                                d="M9.78033 4.21967C9.48744 3.92678 9.01256 3.92678 8.71967 4.21967L4.21967 8.71967C3.92678 9.01256 3.92678 9.48744 4.21967 9.78033C4.51256 10.0732 4.98744 10.0732 5.28033 9.78033L9.78033 5.28033C10.0732 4.98744 10.0732 4.51256 9.78033 4.21967Z"
                                fill="#2C2C2C"></path>
                        </svg></span>
                </div>`;
    };

    const getDownloadableRow = (i, x = "") => {
        x === '""' ? (x = "") : x;
        return (
            '<tr draggable="false" id="option-value-rowid-2" class="ui-sortable-handle downloadable-row attribute-dlt">' +
            '<td colspan="2" class="label">' +
            '<div class="d-flex align-items-center rtl:gap-2">' +
            '<svg class="me-2" width="16" height="11" viewBox="0 0 16 11" fill="none" xmlns="http://www.w3.org/2000/svg"> <rect width="16" height="1" fill="#898989"> </rect> <rect y="5" width="16" height="1" fill="#898989"></rect> <rect y="10" width="16" height="1" fill="#898989"></rect> </svg>' +
            '<input type="text" name="meta_downloadable_files' +
            x +
            "[" +
            i +
            '][name]" value="" class="form-control downloadable-name"></div></td>' +
            '<td colspan="2"><input type="text" name="meta_downloadable_files' +
            x +
            "[" +
            i +
            '][url]" class="form-control downloadable-url" value=""></td>' +
            '<td><div class="position-relative   downloadable-file">' +
            '<a class="add-files-button has-media-manager" data-val="single">' +
            jsLang("Choose file") +
            "</a>" +
            `<svg class="sec-dlt position-absolute top-11p right-n6"
                        width="8" height="8" viewBox="0 0 8 8"
                        fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" clip-rule="evenodd"
                            d="M0.292893 0.292893C0.683417 -0.0976311 1.31658 -0.0976311 1.70711 0.292893L7.70711 6.29289C8.09763 6.68342 8.09763 7.31658 7.70711 7.70711C7.31658 8.09763 6.68342 8.09763 6.29289 7.70711L0.292893 1.70711C-0.0976311 1.31658 -0.0976311 0.683417 0.292893 0.292893Z"
                            fill="#898989"></path>
                        <path fill-rule="evenodd" clip-rule="evenodd"
                            d="M7.70711 0.292893C7.31658 -0.0976311 6.68342 -0.0976311 6.29289 0.292893L0.292893 6.29289C-0.0976315 6.68342 -0.0976315 7.31658 0.292893 7.70711C0.683417 8.09763 1.31658 8.09763 1.70711 7.70711L7.70711 1.70711C8.09763 1.31658 8.09763 0.683417 7.70711 0.292893Z"
                            fill="#898989"></path>
                    </svg>
                </div>
            </td>
        </tr>
        `
        );
    };

    const getB2BRow = (i, x = "") => {
        x === '""' ? (x = "") : x;
        return (
            `<div class="row b2b_row">
                        <div class="col-md-3 pb-4p">
                            <input type="number" placeholder="0" class="form-control inputFieldDesign min_qty" maxlength="8" name="meta_b2b_data${x}[${i}][min_qty]" value="">
                        </div>
                        <div class="col-md-3 pb-4p">
                            <input type="number" placeholder="0" class="form-control inputFieldDesign max_qty" maxlength="8" name="meta_b2b_data${x}[${i}][max_qty]" value="">
                        </div>
                        <div class="col-md-3 pb-4p">
                            <input type="number" placeholder="0" class="form-control inputFieldDesign" maxlength="8" name="meta_b2b_data${x}[${i}][price]" value="">
                        </div>
                        <div class="col-md-3 pb-4p">
                              <svg class="delete_b2b position-absolute mt-14p ml-3"
                                   width="8" height="8" viewBox="0 0 8 8"
                                   fill="none" xmlns="http://www.w3.org/2000/svg">
                                  <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M0.292893 0.292893C0.683417 -0.0976311 1.31658 -0.0976311 1.70711 0.292893L7.70711 6.29289C8.09763 6.68342 8.09763 7.31658 7.70711 7.70711C7.31658 8.09763 6.68342 8.09763 6.29289 7.70711L0.292893 1.70711C-0.0976311 1.31658 -0.0976311 0.683417 0.292893 0.292893Z"
                                        fill="#898989"></path>
                                  <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M7.70711 0.292893C7.31658 -0.0976311 6.68342 -0.0976311 6.29289 0.292893L0.292893 6.29289C-0.0976315 6.68342 -0.0976315 7.31658 0.292893 7.70711C0.683417 8.09763 1.31658 8.09763 1.70711 7.70711L7.70711 1.70711C8.09763 1.31658 8.09763 0.683417 7.70711 0.292893Z"
                                        fill="#898989"></path>
                              </svg>
                          </div>
                    </div>`
        );
    };
});
