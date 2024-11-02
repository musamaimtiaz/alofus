"use strict";
var type;
var customType;
var acceptedFiles;
var ids = [];
var currentImageInput;
let initialPaginationLinks = '';
var loader = `<div class="placeholder wave p-0" style="height: 16px"><div class="square"></div></div>`;

$(document).on("click", "#image-status,.has-media-manager", function () {
    customType = $(this).attr("data-type");
    $("#exampleModalCenter").modal("show");
    currentImageInput = this;
});

$("#exampleModalCenter").on("show.bs.modal", function (e) {
    $("#file-id").val($(e.relatedTarget).attr("id"));
    $("#file-name").val($(e.relatedTarget).attr("name"));
    $("#file-type").val($(e.relatedTarget).attr("type"));
    $("#file-size").val($(e.relatedTarget).attr("size"));
    $("#uploaded-by").val($(e.relatedTarget).attr("user"));
    $("#uploaded-date").val($(e.relatedTarget).attr("time"));
    $("#file-id").val($(e.relatedTarget).attr("id"));
    $("#download-image").attr("href", SITE_URL + "/uploaded-files/download/"+ $(e.relatedTarget).attr("id"));
    $(".page-link").addClass("modal-paginator");
    $("#file-type").hide();
    $(".dz-message").show();
    $(".dz-image-preview").hide();

    type = $(e.relatedTarget).attr("data-type");
    type = typeof customType !== 'undefined' ? customType : type;
    fetch_data(1, type);

    $(".sort-option-modal").prop("selectedIndex", 0);
    $('#search-input').val('');
});

$('#exampleModalCenter').on('hidden.bs.modal', function () {
    ids = [];
});

if ($(".main-body .page-wrapper").find("#exampleModalCenter").length) {
    $(document).ready(function () {
        $(".pagination li a").addClass("custom-paginator");
    });
}

let images = [];
const image_show = () => {
    let image = "";
    images.forEach((i) => {
        image += `<div class="image_container d-flex flex-column justify-content-center align-items-start position-relative m-3">
              <img src= ${i.url} alt="Image">
              <p class="m-1">${
                  i.name.slice(0, 15).split(".")[0] +
                  "." +
                  i.file.type.split("/")[1]
              }</p>
              <small class="ml-1">${(i.size * 0.001).toFixed(2)} kb</small>
              <span class="position-absolute rounded-circle text-center img-remove-icon img-del" onclick="delete_image(${images.indexOf(
                  i
              )})">&times;</span>
          </div>`;
    });
    return image;
};

const delete_image = (e) => {
    if (images.length < 2) {
        addFiles();
    }
    images.splice(e, 1);
    document.getElementById("img-container").innerHTML = image_show();
};

const addFiles = () => {
    $("#add-files").css("display", "flex");
    $("#add-more-files").addClass("add-more-files");
};

const check_duplicate = (name) => {
    let image = true;
    if (images.length > 0) {
        for (let img of images) {
            if (img.name === name) {
                image = false;
                break;
            }
        }
    }
    return image;
};

$(document).on("click", "#clear-items", function () {
    addFiles();
    images = [];
    image_show();
    removeAllChildNodes(document.getElementById("img-container"));
});

function removeAllChildNodes(parent) {
    while (parent.firstChild) {
        parent.removeChild(parent.firstChild);
    }
}

$(document).on("click", ".img-remove-icon", function () {
    $(this).parent().remove();
});

$(document).on("click", ".close", function () {
    $(".item-border").remove();
});

$(document).on("click", ".image-card", function () {
    if ($.trim($(currentImageInput).attr("data-val")) == "single") {
        ids = [];
        $(".image-card").each(function () {
            $(this).removeClass("item-border");
        });
        $(this).toggleClass("item-border");

        if($(this).hasClass("item-border")) {
            ids.push($(".item-border").attr('id'))
        }
    } else {
        $(this).toggleClass("item-border");
        $(this).hasClass("item-border") ? ids.push(this.id) : ids.splice( $.inArray(this.id, ids), 1 );
    }
    var numItems = $(".item-border").length;
    $("#add-file-count").text(numItems);
});

$(document).on("click", "#clear-item", function () {
    $(".image-card").removeClass("item-border");
    $("#add-file-count").text(0);
    ids = [];
});

$(document).on("click", "#select-file", function () {
    $("#select-items, #file-count, #upload-card-header, #modal-pagination-container, #clear-item, #img-container").show();
    $("#browse-file, #clear-items, #file-type").hide();
    $(this).addClass("modal-title-color");
    $("#upload-new").removeClass("modal-title-color");
    $("#img-container").show();
});

$(document).on("click", "#upload-new", function () {
    if (type != '') {
        $("#accepted-type").text(type);
    }
    let dropzone = Dropzone.instances[0];
    if (type != '' && type != undefined) {
        dropzone.options.acceptedFiles = '.' + type.split(",").join(",.");
    }

    if (dropzone) {
        dropzone.on("complete", (file) => {
            if (file.status == 'success') {
                type = typeof customType !== 'undefined' ? customType : type;
                fetch_data(1, type);
            }
        });
    }
    $("#select-items, #modal-pagination-container, #upload-card-header, #file-count, .dz-image-preview, #clear-item").hide();
    $("#browse-file, #file-type, .dz-message ").show();

    $(this).addClass("modal-title-color");
    $("#select-file").removeClass("modal-title-color");
});

$(document).on("click", ".btn-file-add", function () {
    getImages($(currentImageInput).attr("data-val"));
    $("#exampleModalCenter").modal("hide");
});

function getImages(type) {
    if (ids.length != 0) {
        $.ajax({
            type: "POST",
            dataType: "json",
            url: SITE_URL + "/media-manager/files/upload",
            data: {
                file_id: ids,
                _token: token,
            },
            success: function (data) {
                if ($("#img-container").length > 0 && type != 'multiple') {
                    $("#img-container").html(data.html)
                } else if ($("#img-container").length > 0) {
                    $("#img-container").append(data.html)
                }
                $(currentImageInput).trigger('file-attached', data);
            },
        });
    }
}

$(document).on("click", ".modal-paginator", function (event) {
    event.preventDefault();
    type = typeof customType !== "undefined" ? customType : type;

    let page = $(this).attr("href").split("page=")[1];
    let queryStringWithPageNumber = page;
    let sortByValue = $(".sort-option-modal").find("option:selected").val();

    if (sortByValue !== undefined && sortByValue !== null) {
        queryStringWithPageNumber = `${page}&sort_value=${sortByValue}`;
    }

    let searchString = $('#search-input').val();
    queryStringWithPageNumber = queryStringWithPageNumber + `&search_value=${searchString}`;

    fetch_data(queryStringWithPageNumber, type);
});

function fetch_data(page, imageType) {
    $.ajax({
        url: SITE_URL + "/paginate-data?page=" + page,

        beforeSend:function () {
            $('#loader').show();
       },
        method: "POST",
        data: {
            sort: $(this).val(),
            imageType: imageType,
            _token: token,
        },
        success: function (data) {
            $("#image-card-container").html(data);
            $('#loader').hide();
            $("#modal-pagination-container").html($("#latest-pagination-data-container").html());
            $(".pagination li a").addClass("modal-paginator");
        },
    });
}

$(document).on("change", ".sort-option", function () {
    $("#media-list").submit();
    $.ajax({
        type: "get",
        dataType: "html",
        url: SITE_URL + "/uploaded-files",
        data: {
            sort: $(this).val(),
            imageType: type,
            _token: token,
        },
        success: function (data) {
            $("#blog-image").append(data);
        },
    });
});

$(document).on("change", ".sort-option-modal", function () {
    $.ajax({
        type: "get",
        dataType: "html",
        beforeSend:function () {
            $('#loader').show();
       },
        url: SITE_URL + "/sort-files",
        data: {
            imageType: type,
            sort_value: $(this).val(),
        },
        success: function (data) {
            $("#select-items").html("");
            $("#select-items").append(data);
            $('#loader').hide();
        },
    });
});

$(document).on("keyup", ".search-image", function () {
    $.ajax({
        type: "get",
        dataType: "html",
        url: SITE_URL + "/sort-files",
        data: {
            sort_name: $(this).val(),
            imageType: type,
        },
        success: function (data) {
            $("#select-items").html("");
            $("#select-items").append(data);
        },
    });
});

$(document).on("click", ".copy-link", function () {
    let url = $(this).attr("data-url").replaceAll("\\", "/");

    if (window.isSecureContext && navigator.clipboard) {
        navigator.clipboard.writeText(url);
        swal(jsLang("Link copied to clipboard"), {
            icon: "success",
            buttons: [false, jsLang("Ok")],
        });
    } else {
        swal(jsLang("Domain not secure! You have to copy it manually:"), {
            icon: "error",
            content: {
                element: "input",
                attributes: {
                    value: url,
                    type: "text",
                },
            },
            closeOnClickOutside: false,
            buttons: [false, jsLang("Close")],
        });
    }
});

$(document).on("click", ".delete-image", function () {
    var r = swal({
        title: jsLang('Are you sure?'),
        icon: "warning",
        buttons: [jsLang('Cancel'), jsLang('Ok')],
        dangerMode: true,
    }).then((willDelete) => {
      if (willDelete) {
      $.ajax({
        dataType: 'json',

        data: {
          id: $(this).attr("data-id"),
          _token: token
        },

        url: SITE_URL + "/delete-image",
        type: 'POST',
        success: function(response) {
            if (response.resp == 'success') {
                swal(jsLang('Successfully deleted.'), {
                icon: "success",
                buttons: [false, jsLang('Ok')],
                }).then(function(){
                window.location.reload();
                })
            } else if(response.status == 'info') {
                swal(response.message, {
                    icon: "info",
                    buttons: [false, jsLang('Ok')],
                });
            } else  {
                swal(jsLang('Something went wrong, please try again.'), {
                    icon: "error",
                    buttons: [false, jsLang('Ok')],
                });
            }
        }
      });
      }
    });
});

$("#exampleModal").on("show.bs.modal", function (e) {
    $("#file-id").val($(e.relatedTarget).attr("id"));
    $("#file-name").val($(e.relatedTarget).attr("name"));
    $("#file-type").val($(e.relatedTarget).attr("type"));
    $("#file-size").val($(e.relatedTarget).attr("size"));
    $("#uploaded-by").val($(e.relatedTarget).attr("user"));
    $("#uploaded-date").val($(e.relatedTarget).attr("time"));
    $("#file-id").val($(e.relatedTarget).attr("id"));
    $("#download-image").attr("href", SITE_URL + "/uploaded-files/download/"+ $(e.relatedTarget).attr("id"));
    $(".page-link").addClass("modal-paginator");
});

const getFilePreview = (file, name) => {
    return `<div class="img-box-two mt-15p"> <img class="fit-boxed" src="${file.url}" alt="${file.name}"> <input type="hidden" value="${file.id}" name="file_id[]"> <svg class="svg-postion remove-product-image" width="14" height="14" viewBox="0 0 14 14" fill="none" xmlns="http://www.w3.org/2000/svg"> <circle cx="7" cy="7" r="7" fill="#FCCA19"> </circle> <path fill-rule="evenodd" clip-rule="evenodd" d="M4.21967 4.21967C4.51256 3.92678 4.98744 3.92678 5.28033 4.21967L9.78033 8.71967C10.0732 9.01256 10.0732 9.48744 9.78033 9.78033C9.48744 10.0732 9.01256 10.0732 8.71967 9.78033L4.21967 5.28033C3.92678 4.98744 3.92678 4.51256 4.21967 4.21967Z" fill="#2C2C2C"></path> <path fill-rule="evenodd" clip-rule="evenodd" d="M9.78033 4.21967C9.48744 3.92678 9.01256 3.92678 8.71967 4.21967L4.21967 8.71967C3.92678 9.01256 3.92678 9.48744 4.21967 9.78033C4.51256 10.0732 4.98744 10.0732 5.28033 9.78033L9.78033 5.28033C10.0732 4.98744 10.0732 4.51256 9.78033 4.21967Z" fill="#2C2C2C"></path> </svg> </div>`;
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

$(document).on("file-attached", ".media-manager-img", function (e, param) {
    let data = param.data;
    $(this)
        .closest(".preview-parent")
        .find(".preview-image")
        .html(renderFilePreview(data, $(this).data("name")));
});

$(".pagination > .page-item > .page-link").on("click", (e) => {
    e.preventDefault();
    let url = e.target.href;
    let sortByValue = '';
    let sortName = $("input[name='sort_name']").val();

    if (("select[class='sort-option']").length) {
        sortByValue = $(".sort-option").find('option:selected').val();
    }

    window.location.href = `${url}&sort_value=${sortByValue}&sort_name=${sortName}`;
});

$(() => {
    initialPaginationLinks = `<nav> <ul class="pagination"> <li class="page-item disabled" aria-disabled="true"> <span class="page-link">Previous</span> </li><li class="page-item"> <a class="page-link f-14 modal-paginator" href="${SITE_URL}/paginate-data?page=2" rel="next">Next</a> </li></ul> </nav>`;
});

$(".sort-option-modal").on("change", () => {
    $("#modal-pagination-container").html(initialPaginationLinks);
    $('#search-input').val('');
});
