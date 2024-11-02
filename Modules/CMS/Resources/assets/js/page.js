"use strict";

if ($(".main-body .page-wrapper").find("#page-container").length) {
    $(document).ready(function () {
        $("#summernote").summernote({
            tabsize: 2,
            height: 240,
            styleWithCSS: true,
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
}


$(document).on("keyup", "#name", function () {
    var str = this.value.replace(/[&\/\\#@,+()$~%.'":*?<>{}]/g, "");
    let slug = document.querySelector("#slug");
    slug.value = str.trim().toLowerCase().replace(/\s/g, "-");
    if (str.length > 0 && slug.parentNode.querySelector(".error")) {
        slug.setCustomValidity("");
        slug.parentNode.querySelector(".error").remove();
    }

});

$(document).on("keyup", ".note-editable", function () {
    let str = $(this).html();
    if (str.length > 0) {
        let textarea = this.closest(".editor").querySelector(".sm_note");
        textarea.setCustomValidity("");
        if (textarea.closest(".editor").querySelector(".error")) {
            textarea.closest(".editor").querySelector(".error").remove();
        }
    }
});

$("#btnSubmit").on("click", function (e) {
    if (
        $("#name").val() == "" ||
        $("#slug").val() == "" ||
        $("#description").val() == ""
    ) {
        $("#home").addClass("active show");
        $('[href="#home"]').tab("show").addClass("active");
        $("#profile").removeClass("active show");
        $("#home").attr("aria-labelledby").val("home-tab");
        e.preventDefault();
    }
});

$(".page-submit").click(function (e) {
    var arr = ["#home", "#profile"];
    setTimeout(() => {
        for (const key in arr) {
            if ($(arr[key]).find(".error").length) {
                var target = $(arr[key]).attr("aria-labelledby");
                console.log(target)
                $("#" + target).trigger("click");
                break;
            }
        }
    }, 100);
});


$(document).on("file-attached", ".editor-img-btn", function (e, data) {
    data.data.forEach((element) => {
        $("#summernote").summernote(
            "pasteHTML",
            ' <p><img src="' + element.url + '" style="width: 100%;"/><br></p>'
        );
    });
});
