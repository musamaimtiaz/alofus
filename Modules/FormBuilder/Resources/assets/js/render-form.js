"use strict";

jQuery(function () {
    if (
        window._form_builder_content &&
        Array.isArray(window._form_builder_content)
    ) {
        window._form_builder_content.map((item) => {
            if (
                item.type == "file" &&
                item.hasOwnProperty("value") &&
                item.required == true
            ) {
                item.required = false;
            }
            return item;
        });
    }

    var fbRenderOptions = {
        container: false,
        dataType: "json",
        formData: window._form_builder_content
            ? window._form_builder_content
            : "",
        render: true,
    };

    try {
        $("#fb-render").formRender(fbRenderOptions);
    } catch (error) {
        // handle exception
    } finally {
        $("input[type=file]").each(function () {
            const title = $(this).data("title");
            const url = $(this).data("url");
            if (url && url.length > 0) {
                $(this)
                    .parent()
                    .append(
                        `<div class="d-block mt-2">${jsLang(
                            "File"
                        )}: <a href="${url}" target="__blank" class="d-inline mt-2"><i class="feather icon-file-text mr-1"></i>${title}</a></div>`
                    );
            }
        });
    }
});
