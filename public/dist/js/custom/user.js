"use strict";
if ($('.main-body .page-wrapper').find('#user-add-container').length || $('.main-body .page-wrapper').find('#user-edit-container').length) {

	$("#validatedCustomFile").on('change', function() {
        //get uploaded filename
        var files = [];
        for (var i = 0; i < $(this)[0].files.length; i++) {
            files.push($(this)[0].files[i].name);
        }
        $(this).next('.custom-file-label').html(files.join(', '));

        //image validation
        var file = this.files[0];
        var fileType = file["type"];
        var validImageTypes = ["image/gif", "image/jpeg", "image/png", "image/bmp"];
        if ($.inArray(fileType, validImageTypes) < 0) {
            $('#divNote').show();
            $('#note_txt_1').hide();
            $('#note_txt_2').html('<h6> <span class="text-danger font-weight-bolder">' +jsLang('Invalid file extension') + '</span> </h6> <span class="badge badge-danger">' + jsLang('Note') + '!</span> ' + jsLang('Allowed File Extensions: jpg, png, gif, bmp'));
            $('#note_txt_2').show();
            $('#prvw').hide();
            return false;
        } else {
            $('#prvw').show();
            $('#note_txt_2, #note_txt_1').hide();
            return true;
        }
    });
}

if ($('.main-body .page-wrapper').find('#user-import-container').length) {
    $("#fileRequest").on("click", function() {
        window.location = SITE_URL.replace("/admin", "") + "/public/dist/downloads/user_sheet.csv";
    });

    $('.error, #note_txt_2').hide();
    $("#validatedCustomFile").on('change', function() {
        //get uploaded filename
        var files = [];
        for (var i = 0; i < $(this)[0].files.length; i++) {
            files.push($(this)[0].files[i].name);
        }
        $(this).next('.custom-file-label').html(files.join(', '));

        //image validation
        var fileName = files.toString();
        var ext      = fileName.split('.').pop();
        if ($.inArray(ext, ['csv']) == -1) {
            $('#note_txt_1, .error').hide();
            $('#note_txt_2').show();
            $('#note_txt_2').html('<h6> <span class="text-danger font-weight-bolder">' + jsLang('Invalid file extension') +' </span> </h6> <span class="badge badge-info note-style">' + jsLang('Note') +'</span><small class="text-info"> ' + jsLang('Allowed File Extensions: csv')) + '</small>';
            } else {
                $('#note_txt_1, #note_txt_2').hide();
            }
        });
}

function passwordValidation() {
    var status = true;
    var errorMsg = '';
    var tmpMsg = [];
    if (uppercase && $('.password-validation').val().search(/[A-Z]/) < 0) {
        tmpMsg.push(jsLang('uppercase'));
        status = false;
    }
    if (lowercase && $('.password-validation').val().search(/[a-z]/) < 0) {
        tmpMsg.push(jsLang('lowercase'));
        status = false;
    }
    if (number && $('.password-validation').val().search(/[0-9]/) < 0) {
        tmpMsg.push(jsLang('numbers'));
        status = false;
    }
    if (symbol && $('.password-validation').val().search(/[#?!@$%^&*-]/) < 0) {
        tmpMsg.push(jsLang('symbols'));
        status = false;
    }

    if (tmpMsg.length > 0) {
        errorMsg = jsLang('Password must contain :x');
        errorMsg = errorMsg.replace(":x", tmpMsg.join(', '));
    }


    if (length && $('.password-validation').val().length < length) {
        if (errorMsg.length > 0) {
            errorMsg = jsLang('Password must contain :x and :y characters long.');
            errorMsg = errorMsg.replace(":x", tmpMsg.join(', '));
            errorMsg = errorMsg.replace(":y", length);

        } else {
            errorMsg = jsLang('Password must be at least :x characters.');
            errorMsg = errorMsg.replace(":x", length);
        }
        status = false;
    }

    if (status == false) {
        $('.password-validation-error').addClass('text-red').text(errorMsg);
        return false;
    }

    if ($('#password').val().localeCompare($('#confirm_password').val() ?? $('#password').val()) != 0 ) {
        $('.password-validation-error').addClass('text-red').text(jsLang('Passwords does not match!'));
        return false; 
    }

    $('form').find(':submit').text($('.admin-password-update').length ? jsLang('Updating') : jsLang('Creating')).append(`<div class="spinner-border spinner-border-sm ml-2" role="status">`);
    $('form').find(':submit').addClass('disabled-btn');

    return true;
}

if ($('.main-body .page-wrapper').find('#site-user-edit-container').length) {
    var oldImage = null;
    imgInp.onchange = evt => {

        const [file] = imgInp.files
        if (file) {
            oldImage = imgInp.files;
            blah.src = URL.createObjectURL(file)
        }
        if (imgInp.files.length == 0 && oldImage != null) {
            imgInp.files = oldImage;
        }
    }
}

$(document).on("file-attached", ".custom-file", function (e, param) {
    let data = param.data;
    if (data) {
        $(this).closest(".preview-parent").find(".custom-file-input").val(data[0].id);
    }
});

$(document).ready(function () {
    if ($('.main-body .page-wrapper').find('#user-edit-container').length) {
        if (window.location.hash != '') {
            $(window.location.hash + '-tab').trigger('click');
        } else {
            $("#user-info-tab").trigger('click');
            $('html,body').scrollTop(0);
        }
    }
})

$(document).on('click', 'ul.nav li', function(e) {
    if (e.target.href == '') {
        return false;
    }
    window.location.replace(e.target.href);
    $('html,body').scrollTop(0);
})

$(document).on('keyup', '#password,#confirm_password', function() {
    $('.password-validation-error').text('');
})
$(".genderSelect").select2({
    minimumResultsForSearch: Infinity
});
