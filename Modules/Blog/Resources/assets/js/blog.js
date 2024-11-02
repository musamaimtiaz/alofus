"use strict";

if ($('.main-body .page-wrapper').find('#page-container').length) {

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


    $(document).on("file-attached", ".has-thumbnail", function (e, data) {
        $("#blog-image").html(data.html)
    });

    $(document).on("file-attached", ".editor-img-btn", function (e, data) {
        data.data.forEach((element) => {
            $('#summernote').summernote('pasteHTML', ' <span><img src="' + element.url + '" style="width: 200px;"/><br></span>');
        });
    });

    $(document).on('keyup', '#title', function() {
        var str = this.value.replace(/[&\/\\#@,+()$~%.'":*?<>{}]/g, "");
        $('#slug').val(str.trim().toLowerCase().replace(/\s/g, "-"));
        $(this).siblings('.error').remove();
        $('#slug').siblings('.error').remove();
    });

    $(document).on('keyup', '#slug', function() {
        var str = this.value.replace(/[&\/\\#@,+()$~%.'":*?<>{}]/g, "");
        $('#slug').val(str.trim().toLowerCase().replace(/\s/g, "-"));
    });

     $(document).on('keyup', '.note-editable', function() {
         $(this.closest(".form-group")).find(".error").remove();
    });

    $(document).on('keyup', '#summary', function() {
        $(this).siblings('.error').remove();
    });

    $(document).on("submit","#blogForm",function(e){
        if ($('#summernote').summernote('codeview.isActivated')) {
            $('#summernote').summernote('codeview.deactivate');
        }
    });

}

function formValidation() {
    let status = true;
    let ids = ['#category_id' , '#title' , '#slug' , '#summernote' , '#summary'];

    for (const key in ids) {
        if ($(ids[key]).val().length == '' && $(ids[key]).siblings('.error').length == 0) {

            $(ids[key]).parent().append(`
                    <label class="error">${jsLang('This field is required.')}</label>
            `);

            status = false;

        } else if ($(ids[key]).val().length == '') {
            status = false;
        }
    }

   if (status == false) {
        return false;
    }

    $('#btnSubmit').text(jsLang('Creating')).append(`<div class="spinner-border spinner-border-sm ml-2" role="status"></div>`).addClass('disabled-btn');

    return true;
}
