"use strict";
$(document).on( 'init.dt', function () {
    $(".dataTables_length").remove();
    $('#dataTableBuilder').removeAttr('style');
});
// currency settings js
if ($('.main-body .page-wrapper').find('#currency-settings-container').length) {
    dataTable('#dataTableBuilder', 3);
    $('.js-example-basic-single-1').select2();

    $('.js-example-basic-single-2').select2();

    $('#add-currency').on('hidden.bs.modal', function() {
        $('input[name=name]').removeClass('error');
        $('input[name=symbol]').removeClass('error');
        $('input[name=exchange_rate]').removeClass('error');
    });

    $("#edit-unit").on("show.bs.modal", function () {
        $("#curr_name, #curr_symbol, #exchange_rate").removeClass("error");
        $("#curr_name-error, #curr_symbol-error, #exchange_rate-error").hide();
    });

    $(document).on('click', '.edit_currency', function () {
        var id = $(this).attr("id");
        $.ajax({
            url: SITE_URL + "/currencies/edit",
            data: {
                id: id,
                "_token": token
            },
            type: 'POST',
            dataType: 'JSON',
            success: function (data) {
                $('#curr_name').val(data.name);
                $('#curr_symbol').val(data.symbol);
                $('#curr_id').val(data.id);
                var exchangeRateFormate = getDecimalNumberFormat(data.exchange_rate);
                $('#exchange_rate').val(exchangeRateFormate);
                $('#exchange_from').val(data.exchange_from).trigger('change');

                $('#edit-unit').modal();
            }
        });
    });

    $('#add-currency').on('hidden.bs.modal', function (e) {
        $(this).find('input[name = name]').val('');
        $(this).find('input[name = symbol]').val('');
        $(this).find('input[name = exchange_rate]').val('');
    });

    $('.btn-group').hide();
    confirmDelete('#confirmDelete', '#confirmDeleteSubmitBtn', '#confirmDeleteLabel', '#delete-currency-');
    $("#dataTableBuilder").addClass('taxes');
    $('#add_exchange_from').on('change', function() {
        if ($(this).find('option:selected').text() == "api") {
            $('#note').show();
        } else {
            $('#note').hide();
        }
    })

    $('#exchange_from').on('change', function() {
        if ($(this).find('option:selected').text() == "api") {
            $('#note_edit').show();
        } else {
            $('#note_edit').hide();
        }
    })

    $("#currency-converter").on("show.bs.modal", function () {
        $('#add-unit').modal('hide');
        $('#edit-unit').modal('hide');
    });
}


// Tax js
if ($('.main-body .page-wrapper').find('#tax-settings-container').length) {
    dataTable('#dataTableBuilder', 3);
    $('.select2').select2();
    $('#add-tax').on('hidden.bs.modal', function() {
        $(".has-validation-error label").remove();
    });

    $("#edit-tax").on("show.bs.modal", function () {
        $(".has-validation-error label").remove();
    });
    $(document).on('click', '.edit_currency', function () {
        var id = $(this).attr("id");
        $.ajax({
            url: SITE_URL + "/taxes/edit",
            data: {
                id: id,
                "_token": token
            },
            type: 'POST',
            dataType: 'JSON',
            success: function (data) {
                $('#name').val(data.name);
                $('#tax_id').val(data.id);
                var tax_rate = getDecimalNumberFormat(data.tax_rate);
                $('#tax_rate').val(tax_rate);
                $('#is_default').val(data.is_default).trigger('change');

                $('#edit-tax').modal();
            }
        });
    });

    $('#add-tax').on('hidden.bs.modal', function (e) {
        $(this).find('input[name = name]').val('');
        $(this).find('input[name = tax_rate]').val('');
        $(this).find('input[name = is_default]').val('');
    });

    $('.btn-group').hide();
    confirmDelete('#confirmDelete', '#confirmDeleteSubmitBtn', '#confirmDeleteLabel', '#delete-currency-');
}


