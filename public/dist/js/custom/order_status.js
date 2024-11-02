"use strict";
if ($('.main-body .page-wrapper').find('#order-status-container').length) {
    $(document).on( 'init.dt', function () {
        $(".dataTables_length").remove();
        $('#dataTableBuilder').removeAttr('style');
    });
    dataTable('#dataTableBuilder', [4]);
    $(document).on('click', '.edit_status', function () {
        var id = $(this).attr("id");
        $.ajax({
            url: SITE_URL + "/order-statuses/edit",
            data: {
                id: id,
                "_token": token
            },
            type: 'POST',
            dataType: 'JSON',
            success: function (data) {
                $('#status_id').val(data.id);
                $('#status_name').val(data.name);
                $('#status_orderBy').val(data.order_by);
                $('#status_is_default').val(data.is_default).trigger('change');
                if (data.is_core == true) {
                    $('#payment_scenario').attr('disabled','disabled');
                } else {
                    $('#payment_scenario').removeAttr('disabled');
                    $('#payment_scenario').val(data.payment_scenario).trigger('change');
                }
                $('#status_color').val(data.color);
                $('#status_role_id').val(data.roleIds).trigger('change');
                $('#edit-status').modal();
            }
        });

    });
    $('#edit_default').on('change', function() {
        if ($(this)[0].checked) {
            $('#edit_status').val('Active').trigger('change');
        }
    });
    $('#default').on('change', function() {
        if ($(this)[0].checked) {
            $('#status').val('Active').trigger('change');
        }
    });

    $('#add-language').on('show.bs.modal', function (e) {
        $(this).find(".error").hide();
    });

    $('#add-language').on('hidden.bs.modal', function (e) {
        $(this).find("select").val('').trigger('change');
        $('#default').prop('checked', false);
    });

    $('#blah_add').hide();
    $('#confirmDelete').on('show.bs.modal', function (e) {
        var button = $(e.relatedTarget);
        var modal = $(this);
        $('#confirmDeleteSubmitBtn').attr('data-task', '').removeClass('delete-task-btn');
        if (button.data("label") == 'Delete') {
            modal.find('#confirmDeleteSubmitBtn').addClass('delete-task-btn').attr('data-task', button.data('id')).text(jsLang('Yes, Confirm')).show();
            modal.find('#confirmDeleteLabel').text(button.data('title'));
            modal.find('.modal-body').text(button.data('message'));
        }
        $('#confirmDeleteSubmitBtn').on('click', function () {
            $('#delete-language-' + $(this).data('task')).trigger('submit');
        });
    });
    $(document).on("click", "#tablereload", function (event) {
        event.preventDefault();
        $("#dataTableBuilder").DataTable().ajax.reload();
    });

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
            "pageLength": row_per_page,
            "order" :  [[ 2, 'asc' ]]
        });
    }
}
