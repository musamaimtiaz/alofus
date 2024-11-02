"use strict";
$(document).ready(function() {
    hideNoDiv();
    $( "#cannedLink_search" ).autocomplete({
        delay: 500,
        position: {my: "left top", at: "left bottom", collision: "flip"},
        source: function (request, response) {
            autoCompleteSource(request, response, SITE_URL + '/canned/search/'+'link', '#cannedLink_search', '#no_div_link');
        },
        select: function (event, ui) {
            var e = ui.item;
            if (e.id) {
                let setText;
                if ((e.value.length) > 13) {
                    setText = e.value + e.fullValue;
                } else {
                    setText = e.fullValue;
                }
                $('.txtAreaCanned').summernote('pasteHTML' , setText);
                this.value = "";
                return false;
            }
        },
        minLength: 1,
        autoFocus: true
    });

    $( "#cannedMsg_search" ).autocomplete({
        delay: 500,
        position: {my: "left top", at: "left bottom", collision: "flip"},
        source: function (request, response) {
            autoCompleteSource(request, response, SITE_URL + '/canned/search/'+'message', '#cannedMsg_search', '#no_div_msg');
        },
        select: function (event, ui) {
            var e = ui.item;
            if (e.id) {
                let setText;
                if ((e.value.length) > 13) {
                    setText = e.value + e.fullValue;
                } else {
                    setText = e.fullValue;
                }
                $('.txtAreaCanned').summernote('pasteHTML' , setText);
                this.value = "";
                return false;
            }
        },
        minLength: 1,
        autoFocus: true
    });

    $(document).on("blur", "#cannedMsg_search, #cannedLink_search", function () {
        $(this).attr('id') == 'cannedMsg_search' ? $('#no_div_msg').hide() :  $('#no_div_link').hide();
    });
    function autoCompleteSource(request = null, response = null, url = null, selector = null, divSelector = null) {
        let text = $(selector).val();
        $.ajax({
            url: url,
            dataType: "json",
            type: "POST",
            data: {
                _token:token,
                search: text,
            },
            success: function(data) {
                if(data.status_no == 1) {
                    var data = data.canned;
                    response($.map( data, function( canned ) {
                        return {
                            id: canned.id,
                            value: canned.filter_data,
                            fullValue: canned.data,
                        }
                    }));
                } else {
                    $('.ui-menu-item').remove();
                    $(divSelector).css('top',$(selector).position().top+35);
                    $(divSelector).css('left',$(selector).position().left);
                    $(divSelector).css('width',$(selector).width());
                    $(divSelector).css('display','block');
                }
                //end
            }
        })
    }
});
function clickOnSave(url = null, method = null, data = [])
{
    $.ajax({
        type: method,
        url: SITE_URL + url,
        data: {
            "_token": token,
            array_value: data,
        },
        success: function (data) {
            if (data.status == 1) {
                swal(jsLang('Successfully Saved'), {
                    icon: "success",
                    buttons: [false, jsLang('Ok')],
                });
            } else if(typeof (data.error != undefined)) {
                    swal(data.error, {
                        icon: "error",
                        buttons: [false, jsLang('Ok')],
                    });
                } else {
                    swal(jsLang('Something went wrong, please try again.'), {
                        icon: "error",
                        buttons: [false, jsLang('Ok')],
                    });
                }
        }
    });
}

function hideNoDiv() {
    $('#no_div_msg').hide();
    $('#no_div_link').hide();
}

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

function confirmDelete(modalId, buttonId, lebelId, formId)
{
    $(modalId).on('show.bs.modal', function (e) {
        var button = $(e.relatedTarget);
        var modal = $(this);
        $(buttonId).attr('data-task', '').removeClass('delete-task-btn');
        if (button.data("label") == 'Delete') {
            modal.find(buttonId).addClass('delete-task-btn').attr('data-task', button.data('id')).text(jsLang('Delete')).show();
            modal.find(lebelId).text(button.data('title'));
            modal.find('.modal-body').text(button.data('message'));
        }
        $('#confirmDeleteSubmitBtn').on('click', function () {
            $(formId + $(this).data('task')).trigger('submit');
        });
    });
}

var jsonData = [];

$("#cannedForm").on('submit', function(event) {
    event.preventDefault();
        let title = $('#title').val();
        if ($('.txtAreaCanned').summernote('codeview.isActivated')) {
            $('.txtAreaCanned').summernote('codeview.deactivate');
        }

        jsonData = {
            'title': title,
            'message':  $('.txtAreaCanned:last').summernote('code'),
        }
        clickOnSave("/canned/messages/save", "POST", jsonData);
        $('#modal-canned').modal('hide');
        document.getElementById("cannedForm").reset();

        if (typeof $('#type').val() !== 'undefined' && $('#type').val() == 'list') {
            setTimeout(location.reload.bind(location), 1500);
        }
});
function isUrlValid(userInput) {
    var res = userInput.match(/(http(s)?:\/\/.)?(www\.)?[-a-zA-Z0-9@:%._\+~#=]{2,256}\.[a-z]{2,6}\b([-a-zA-Z0-9@:%_\+.~#?&//=]*)/g);
    if(res == null)
        return false;
    else
        return true;
}
function customLinkValidation() {
    let title = 0, text_link_check, link, title_ch, link_ch, link_val, title_character_count, link_character_count, link_vlidation;
    let rowId = $("input[name='row_identify[]']")
        .map(function(){return $(this).val();}).get();
    for (let i = 0; i < rowId.length; i++) {
        text_link_check = 0;
        title_character_count = 0;
        link_character_count = 0;
        link_vlidation = 0;
        let text_link_title_check = 0;
        $.each($("#link-title-" + rowId[i]), function() {
            if ($(this).val()) {
                if ($(this).val().length < 150) {
                    title_character_count = 1;
                }
                text_link_title_check = 1;
            }
            if ($("#link-" + rowId[i]).val()) {
                if($("#link-" + rowId[i]).val().length < 255) {
                    link_character_count = 1;
                }
                if(isUrlValid($("#link-" + rowId[i]).val()))
                {
                    link_vlidation = 1;
                }
                text_link_check = 1;
            }
        });

        if (text_link_check == 0 && link_character_count == 0 && link_vlidation == 0) {
            $("#link-" + rowId[i]).addClass('err1');
            $('#link-text-' + rowId[i]).text(jsLang('This field is required.'));
            link = 1;
        } else if (text_link_check == 1 && link_character_count == 0 && link_vlidation == 0) {
            $("#link-" + rowId[i]).addClass('err1');
            $('#link-text-' + rowId[i]).text(jsLang('Please provide at most 255 characters.'));
            link_ch = 1;
        } else if (text_link_check == 1 && link_character_count == 1 && link_vlidation == 0) {
            $("#link-" + rowId[i]).addClass('err1');
            $('#link-text-' + rowId[i]).text(jsLang('Please enter a valid link.'));
            link_val = 1;
        } else {
            $("#link-" + rowId[i]).removeClass('err1');
            $('#link-text-' + rowId[i]).text('');
        }

        if (text_link_title_check == 0 && title_character_count == 0) {
            $("#link-title-" + rowId[i]).addClass('err1');
            $('#link-title-text-' + rowId[i]).text(jsLang('This field is required.'));
            title = 1;
        } else if (text_link_title_check == 1 && title_character_count == 0) {
            $("#link-title-" + rowId[i]).addClass('err1');
            $('#link-title-text-' + rowId[i]).text(jsLang('Please provide at most 150 characters.'));
            title_ch = 1;
        } else {
            $("#link-title-" + rowId[i]).removeClass('err1');
            $('#link-title-text-' + rowId[i]).text('');
        }
    }

    if (link == 1 || title == 1 || title_ch == 1 || link_ch == 1 || link_val == 1) {
        return false;
    } else {
        return true;
    }
}

$(document).on('click', '.deleteCustomLink', function(e) {
    e.preventDefault();
    var idtodelete = $(this).attr('data-row-id');
    $('#rowid-' + idtodelete).remove();
});

$("#linkForm").on('submit', function(event) {
    event.preventDefault();
    let link;
    let title;
    let flag = 0;
    let reload = 0;
    if (typeof $('#type').val() !== 'undefined' && $('#type').val() == 'reply') {
        if(customLinkValidation() == true) {
            link = $("input[name='link[]']")
                .map(function(){return $(this).val();}).get();
            title = $("input[name='title[]']")
                .map(function(){return $(this).val();}).get();
            flag = 1;
            jsonData = {
                'title' : title,
                'editorValue': link,
            }
        }
    } else if ($("#linkForm").valid() == true) {
        link = $('#link').val();
        title = $('#title').val();
        flag = 1;
        reload = 1
        jsonData = {
            'title' : title,
            'editorValue': link,
            'status': "link_list"
        }
    }

    if (flag == 1) {
        clickOnSave("/canned/links/save", "POST", jsonData);
        $('#modal-link').modal('hide');
        if (reload == 1) {
            setTimeout(location.reload.bind(location), 1500);
        }
    }
});


// Canned Message List
if ($('.main-body .page-wrapper').find('#canned-message-settings-container').length) {
    $(document).on('click', '.edit_canned_message', function () {
        var id = $(this).attr("id");
        $.ajax({
            url: SITE_URL + "/canned/messages/edit",
            data: {
                id: id,
                "_token": token
            },
            type: 'POST',
            dataType: 'JSON',
            success: function (data) {
                $('#edit_title').val(data.title);
                $('#canned_id').val(data.id);
                cannedEditorValueEdit.setData(data.message);
            }
        });
    });


    $('#editMessageForm').validate({
        ignore: [],
        rules: {
            canned_message: {
                CKEditorRequired: true
            }, title: {
                required: true,
                maxlength: 150,
            },
        }
    });

    $("#editMessageForm").on('submit', function(event) {
        event.preventDefault();
        if ($("#editMessageForm").valid() == true) {
            let title = $('#edit_title').val();
            let id = $('#canned_id').val();
            jsonData = {
                'id' : id,
                'title': title,
                'editorValue': cannedEditorValueEdit.getData(),
            }
            clickOnSave("/canned/messages/update", "POST", jsonData);
            $('#edit-canned-message').modal('hide');
            setTimeout(location.reload.bind(location), 1500);
        }
    });

    $('#modal-canned').on('hidden.bs.modal', function (e) {
        $(this).find('input[name=title]').val('');
        $(this).find('textarea[name=canned_message]').text('');
        $('#cannedForm').validate().resetForm();
        $(this).find('input[name=title]').removeClass('error');
        $(this).find('textarea[name=canned_message]').removeClass('error');
        $('#txtAreaCanned').code("");
    });
    $('#edit-canned-message').on('show.bs.modal', function (e) {
        $('#editMessageForm').validate().resetForm();
    });
    $('#edit-lead-source').on('hidden.bs.modal', function (e) {
        $(this).find('input[name=title]').removeClass('error');
        $(this).find('textarea[name=canned_message]').removeClass('error');
    });

    dataTable('#dataTableBuilder', 3);
    confirmDelete('#confirmDelete', '#confirmDeleteSubmitBtn', '#confirmDeleteLabel', '#delete-canned-');
}

// Canned Link List
if ($('.main-body .page-wrapper').find('#canned-links-settings-container').length) {
    $(document).on('click', '.edit_canned_link', function () {
        var id = $(this).attr("id");
        $.ajax({
            url: SITE_URL + "/canned/links/edit",
            data: {
                id: id,
                "_token": token
            },
            type: 'POST',
            dataType: 'JSON',
            success: function (data) {
                $('#edit_link').val(data.link);
                $('#edit_title').val(data.title);
                $('#link_id').val(data.id);
            }
        });
    });

    $('#editLinkForm').validate({
        ignore: [],
        rules: {
            link: {
                required: true,
                regexLink:true,
                maxlength: 255,
            }, title: {
                required: true,
                maxlength: 150,
            },
        }
    });

    $("#editLinkForm").on('submit', function(event) {
        event.preventDefault();
        if ($("#editLinkForm").valid() == true) {
            let title = $('#edit_title').val();
            let link = $('#edit_link').val();
            let linkId = $('#link_id').val();
            jsonData = {
                'id': linkId,
                'title' : title,
                'editorValue': link,
                'status': "link_list",
            }
            clickOnSave("/canned/links/update", "POST", jsonData);
            $('#edit-canned-link').modal('hide');
            setTimeout(location.reload.bind(location), 1500);
        }
    });

    $('#modal-link').on('hidden.bs.modal', function (e) {
        $(this).find('input[name=title]').val('');
        $(this).find('input[name=link]').val('');
        $('#linkForm').validate().resetForm();
        $(this).find('input[name=title]').removeClass('error');
        $(this).find('input[name=link]').removeClass('error');
    });
    $('#edit-canned-link').on('show.bs.modal', function (e) {
        $('#editLinkForm').validate().resetForm();
    });
    $('#edit-canned-link').on('hidden.bs.modal', function (e) {
        $(this).find('input[name=title]').removeClass('error');
        $(this).find('input[name=link]').removeClass('error');
    });

    dataTable('#dataTableBuilder', 3);
    confirmDelete('#confirmDelete', '#confirmDeleteSubmitBtn', '#confirmDeleteLabel', '#delete-canned-');
}

// Canned in ticket reply
if ($('.main-body .page-wrapper').find('#reply-ticket-container').length || $('.main-body .page-wrapper').find('#cus-panel-ticket-reply-container').length) {

    function urlify(text) {
        let link = [];
        var urlRegex = /(http(s)?:\/\/.)?(www\.)?[-a-zA-Z0-9@:%._\+~#=]{2,256}\.[a-z]{2,6}\b([-a-zA-Z0-9@:%_\+.~#?&//=]*)/g;
        let i = 0;
        text.replace(urlRegex, function(url) {
            link[i++] = url;
        })
        return link;
    }

    if ($('.main-body .page-wrapper').find('#reply-ticket-container').length) {
        $(".canned-btn").on('click', function() {
            var temp = $(".ck-content").children("p.first").val();
        });

        $(document).on('click', '#canned_msg', function(event) {
            event.preventDefault();
        });

        $(document).on('click', '#canned_link', function(event) {
            event.preventDefault();
                let getLink = urlify($('.txtAreaCanned').summernote('code'));
                if (getLink.length > 0) {
                    jsonData = {
                        'editorValue': getLink,
                    }
                    let customLink ='';
                    let rowid = 1;
                    for (let i = 0; i < getLink.length; ++i) {
                         customLink += `
                          <div class="row customLinkDiv" id="rowid-${rowid}">
                             <div class="col-md-5 col-sm-5 padding-bottom">
                                <label class="col-sm-2 control-label require">${jsLang('Title')}</label>
                                <input type="text" data-rel="${rowid}" data-text="link-title-text" name="title[]" class="form-control" id="link-title-${rowid}">
                                <span id="link-title-text-${rowid}" class="validationMsg"></span>
                             </div>
                             <div class="col-md-6 col-sm-6">
                                 <label class="col-sm-2 control-label require">${jsLang('Link')}</label>
                                <input type="text" data-rel="${rowid}" data-text="link-text" name="link[]" value="${getLink[i]}" class="form-control" id="link-${rowid}">
                                <span id="link-text-${rowid}" class="validationMsg"></span>
                             </div>
                             <input type="hidden" name="row_identify[]" value="${rowid}">
                             <div class="col-md-1 co-sm-1">
                                <label>${jsLang('Action')}</label>
                                <button type="button" data-row-id="${rowid}" class="btn btn-xs btn-danger m-t-5 deleteCustomLink"><i class="fa fa-trash"></i></button>
                             </div>
                           </div>`;
                        rowid++;
                    }
                    $('#custom_link').empty();
                    $('#custom_link').append(customLink);
                    $('#modal-link').modal('show');

                } else {
                    swal(jsLang('Does not find any link!'), {
                        icon: "error",
                        buttons: [false, jsLang('Ok')],
                    });
                }
        });
    }

    $("#modal-canned").on("show.bs.modal", function (e) {
        $('#txtAreaCanned').summernote({
            codeviewFilter: true,
            codeviewFilterRegex: summernote_regex,
        });
        if ($(e.relatedTarget).attr("data-id")) {
           $('#txtAreaCanned').summernote('code', $(e.relatedTarget).attr("data-message"));
        } else {
            $('#txtAreaCanned').summernote('code', $('.txtAreaCanned').summernote('code').replace(summernote_regex, ''));
        }
    });
}
