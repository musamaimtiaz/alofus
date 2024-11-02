"use strict";

$("#pageName").on("keyup", function () {
    let slug = $(this)
        .val()
        .toLowerCase()
        .replace(/ /g, "-")
        .replace(/[^\w-]+/g, "");
    $("#pageSlug").val(slug);
});

const updateFormFields = (form, data, values) => {
    values.forEach((item) => {
        if (item.type == "val") {
            $(form).find(item.id).val(data[item.key]);
        } else if (item.type == "prop") {
            $(form)
                .find(item.id)
                .prop("checked", data[item.key] == item.val);
        }
    });
};

$(document).on('click', ".delete-section-btn", function () {
    $(".delete-loading").removeClass("d-none");
    $("#internal_form").attr("action", deletePageUrl.replace("__id__", tempId));
    $("#internal_form").trigger("submit");
});

$(document).on('click', ".delete-button", function () {
    tempId = $(this).data("id");
    $("#confirmDelete").modal("show");
});

$(".default_c").on("change", function () {
    if (!$(".status_c").is(":checked")) {
        $(this).prop("checked", false);
    }
});

$(".status_c").on("change", function () {
    if (!$(this).is(":checked")) {
        $(".default_c").prop("checked", false);
    }
});

$(document).on("click", ".has-spinner-loader", function () {
    let button = $(this);
    if (button.closest("form").length > 0) {
        setTimeout(() => {
            let btn = button;
            if (btn.closest("form").find(".error").length < 1) {
                btn.append(
                    '<div class="spinner-border spinner-border-sm ml-2" role="status"><span class="sr-only">Loading...</span></div>'
                );
                btn.addClass("disabled-btn");
            }
        }, 50);
    } else {
        $(this).append(
            '<div class="spinner-border spinner-border-sm ml-2" role="status"><span class="sr-only">Loading...</span></div>'
        );
        $(this).addClass("disabled-btn");
    }
});

window.onpageshow = function (event) {
    if (event.persisted) {
        $(".disabled-btn").removeClass("disabled-btn");
        $(".spinner-border").remove();
    }
};


$(document).on('click', '.homepage-container .editable', function() {
    tempId = $(this).data('id');
    let page = pages.find(page => page.id == tempId);
    updateFormFields(updateForm, page, [{
            id: '#pageName',
            type: 'val',
            key: 'name'
        },
        {
            id: '#pageSlug',
            type: 'val',
            key: 'slug'
        },
        {
            id: '#switch-1',
            type: 'prop',
            key: 'status',
            val: 'Active'
        },
        {
            id: '#switch-2',
            type: 'prop',
            key: 'default',
            val: 1
        }
    ]);
    updateForm.attr('action', updatePageUrl.replace('__id__', tempId));
    $('#updatePage').modal('show');
});

$(document).on('click', '.pages-container .editable', function() {
    tempId = $(this).data('id');
    let page = pages.find(page => page.id == tempId);
    updateForm.attr('action', updatePageUrl.replace('__id__', tempId));
    updateFormFields(updateForm, page, [{
            id: '#pageName',
            type: 'val',
            key: 'name'
        },
        {
            id: '#pageSlug',
            type: 'val',
            key: 'slug'
        },
        {
            id: '#switch-1',
            type: 'prop',
            key: 'status',
            val: 'Active'
        }
    ]);

    $('#updatePage').modal('show');
});

if ($('#admin-home-builder-container').length) {
    let x = document.getElementById("addons-form-container");
    document.getElementById('addon-install-btn').onclick=function(){
        const p = x.closest('.addon-form-hide');
        if(p){
            p.classList.remove('addon-form-hide');
        }
        x.classList.toggle('addon-form-show');
    };

    document.getElementById('cancel-addform').onclick=function(){
        x.classList.remove('addon-form-show');
    };
}


$(document).on("change", "input[type='file']", function (e) {
    $('.custom-file-name-level').text(this?.files[0]?.name ?? jsLang('Choose file'));
});
