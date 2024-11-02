"use strict";
/* It's using for actual form data where need not necessary any kind of change */
function clickOnSaveForm(url = null, method = null, data = [], successMessage = null, redirect = null)
{
    $.ajax({
        type: method,
        url: SITE_URL + url,
        data:data,
        dataType:'JSON',
        contentType: false,
        cache: false,
        processData: false,
        success: function (data) {
            if (data.status == 1) {
                if (successMessage != null && successMessage.length > 0) {
                    swal(jsLang(successMessage), {
                        icon: "success",
                        buttons: [false, jsLang('Ok')],
                    });
                } else {
                    swal(jsLang('Successfully Saved'), {
                        icon: "success",
                        buttons: [false, jsLang('Ok')],
                    });
                }
                if (redirect != null && redirect.length > 0) {
                    window.location.href = SITE_URL + redirect;
                }
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

/* it's using for changes form data or add extra data */
function clickOnSave(url = null, method = null, data = [])
{
    return $.ajax({
        type: method,
        url: SITE_URL + url,
        data: {
            "_token": token,
            data: data,
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

function dataTable(tableSelector, target)
{
    $(tableSelector).DataTable({
        "columnDefs": [{
            "targets": target,
            "orderable": false
        }],
        "language": {
            "url": app_locale_url
        },
        "pageLength": parseInt(row_per_page)
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

function confirmDeleteAjax(url = null, method = null, id = null, doReload = null) {
    swal({
        title: jsLang("Are you sure?"),
        text: jsLang("Once deleted, you will not be able to recover this file."),
        icon: "warning",
        buttons: true,
        dangerMode: true,
    })
        .then((willDelete) => {
            if (willDelete) {
                $.ajax({
                    type: method,
                    url: SITE_URL + url,
                    data: {
                        "_token": token,
                        id: id,
                    },
                    success: function (data) {
                        if (data.status == 1) {
                            swal(jsLang('Deleted Successfully'), {
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

                        if (doReload == 'resfreshJSTree') {
                            resfreshJSTree();
                        }
                    }
                });
            } else {
                swal("Your data is safe!");
            }
        });
}
