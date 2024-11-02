"use strict";
if ($('.main-body .page-wrapper').find('#vendor-add-container, #vendor-list-container, #vendor-edit-container').length) {

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
        var validImageTypes = ["image/jpg", "image/jpeg", "image/png"];
        if ($.inArray(fileType, validImageTypes) < 0) {
            $('#divNote').show();
            $('#note_txt_1').hide();
            $('#note_txt_2').html('<h6> <span class="text-danger font-weight-bolder">' +jsLang('Invalid file extension') + '</span> </h6> <span class="badge badge-danger">' + jsLang('Note') + '!</span> ' + jsLang('Allowed File Extensions: jpg, png, gif, bmp'));
            $('#note_txt_2').show();
            return false;
        } else {
            $('#note_txt_2, #note_txt_1').hide();
            return true;
        }
    });
}
if ($('.main-body .page-wrapper').find('#vendor-list-container').length) {
    // For export csv
    $(document).on("click", "#csv, #pdf", function(event) {
        event.preventDefault();
        window.location = SITE_URL + "/vendors/" + this.id;
    });
}

if ($('.main-body .page-wrapper').find('#shop-table').length) {
    // For export csv
    $(document).on("click", "#csv, #pdf", function(event) {
        event.preventDefault();
        window.location = SITE_URL + "/shop/" + this.id + "/" + vendor_id;
    });

    // Data table
    function dataTable(tableSeclector, target)
    {
        $(tableSeclector).DataTable({
            "columnDefs": [{
                "targets": target,
                "orderable": false
            }],
            "language": {
                "url": app_locale_url
            },
            "pageLength": row_per_page
        });
    }

    dataTable('#dataTableBuilder', 6);
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

    $('form').find(':submit').text(jsLang('Creating')).append(`<div class="spinner-border spinner-border-sm ml-2" role="status">`);
    $('form').find(':submit').addClass('disabled-btn');
    return true;
}

if ($('.main-body .page-wrapper').find('#vendor-add-container, #vendor-edit-container').length) {
    $('#btnSubmit').on('click', function() {
        setTimeout(() => {
            if ($('body').find('.error').length > 0) {
                $('.error').first().closest('.form-group').find('.form-control').focus();
            }
        }, 100);

    })

    $(document).on('keypress', function(event){
        setTimeout(() => {
            var keycode = (event.keyCode ? event.keyCode : event.which);
            if(keycode == '13' && $('body').find('.error').length > 0){
                $('.error').first().closest('.form-group').find('.form-control').focus();
            }
        }, 100);
    });
}


$(document).on("file-attached", ".custom-file", function (e, param) {
    let data = param.data;
    if (data) {
        $(this).closest(".preview-parent").find(".custom-file-input").val(data[0].id);
    }
});
