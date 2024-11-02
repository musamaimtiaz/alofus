'use strict';

// Filter
$('#dataTableBuilder_length').addClass('p-0');
$('#dataTableBuilder').removeAttr('style');

$(document).on('click', '.filterbtn', function(){
    $(this).toggleClass('btn-primary active');
});

$(document).on('change', '.filter', function() {
    var urlQuery = '?';

    $('.group-filter').each(function(){
        if ($(this).hasClass('active') && $(this).data('filter-value') !== 'All') {
            urlQuery += $(this).data('filter-key') + '=' + $(this).data('filter-value') + '&';
        }
        urlQuery += $(this).attr('name') + '=' + $(this).val() + '&';
    });

    $('.filter').each(function(){
        urlQuery += $(this).attr('name') + '=' + $(this).val() + '&';
    });

    $(`#dataTableBuilder`).DataTable().ajax.url(urlQuery).load();
});

$(document).on('click', '.group-filter', function() {
    if ($(this).hasClass('active')) {
        return false;
    }

    $(this).toggleClass('active').siblings().removeClass('active');

    var urlQuery = '?';
    if ($(this).data('filter-value') !== 'All') {
        urlQuery += $(this).data('filter-key') + '=' + $(this).data('filter-value') + '&';
    }

    $('#dataTableBuilder').DataTable().ajax.url(urlQuery).load();
    console.log(urlQuery, $(this).data('filter-value') , $(this).data('filter-value') !== 'All');
});


// cutom search filter for datatables
// $('#dataTableSearch').keypress(function(){
//     var table = $('#dataTableBuilder').DataTable();
//     table.search($(this).val()).draw();
// });

$('#dataTableSearch').on('input keypress', function(event) {     
    var table = $('#dataTableBuilder').DataTable();
    table.search($(this).val()).draw();
});

// Batch Delete
const characters ='ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz';

function generateString(length) {
    let result = '';
    const charactersLength = characters.length;
    for (let i = 0; i < length; i++) {
        result += characters.charAt(Math.floor(Math.random() * charactersLength));
    }

    return result;
}

function headerCheckBox() {
    $('.need-batch-operation').find('table thead tr').prepend(`
        <th class="batch-header" width="2%">
            <input type="checkbox" id="header_checkbox" class="header-checkbox">
        </th>
    `)
}

function bodyCheckBox() {
    let id = '';
    let value = 0;

    $('.need-batch-operation').find('table tbody tr').each((k, v) => {
        id = generateString(10);

        value = $(v).find('.confirm-delete').attr('data-id');

        $(v).prepend(`
            <td class="batch-body align-middle" width="2%">
                <div class="checkbox checkbox-warning d-block me-0 p-0">
                    <input class="body-checkbox" type="checkbox" id="${id}" value="${value}">
                    <label class="cr" for="${id}"></label>
                </div>
            </td>
        `)
    })
}

function tableContent() {
    if ($('.need-batch-operation').find('table tbody tr td').length <= 1) {
        $('.batch-header').remove();
        return false;
    }

    if ($('.need-batch-operation').find('table thead tr .batch-header').length == 0) {
        headerCheckBox()
    } else {
        needCheckHeader(false);
    }

    if ($('.need-batch-operation').find('table tbody tr .batch-body').length == 0) {
        bodyCheckBox();
    } else {
        needCheckBody(false);
    }
};

function needCheckBody(checked = true) {
    $('.need-batch-operation').find('table tbody tr .batch-body input').prop('checked', checked);
}

function needCheckHeader(checked = true) {
    $('.batch-header input').prop('checked', checked);
}

function checkCount() {
    return $('.batch-body input:checked').length;
}

function hideBatchDeleteButton() {
    $('.batch-delete-count').closest('a').addClass('d-none');
}

function showBatchDeleteButton() {
    $('.batch-delete-count').closest('a').removeClass('d-none');
}

function batchOperation() {
    $('.batch-delete-count').text(checkCount());

    checkCount() ? showBatchDeleteButton() : hideBatchDeleteButton();
}

$(document).ajaxComplete(function(event, xhr, settings) {
    if (settings.url.split('?')[0] == '' || window.location.href.split('?')[0] == settings.url.split('?')[0]) {
        tableContent()

        hideBatchDeleteButton()
    }
});

$(document).on('change', '.batch-header input', function() {
    needCheckBody(this.checked);

    batchOperation()
});

$(document).on('change', '.batch-body input', function () {
    needCheckHeader($('.batch-body').length == checkCount());

    batchOperation()
});

$(document).on('click', '.batch-delete-operation', function () {
    var records = [];

    $(this).text(jsLang('Deleting')).append(`<div class="spinner-border spinner-border-sm ml-2"></div>`).addClass('disabled-btn');

    $('.batch-body input:checked').each((k, v) => {
        if ($(v).val() != 'undefined') {
            records.push($(v).val())
        }
    })

    $.ajax({
        url: ADMIN_SITE_URL + '/batch/delete',
        type: 'POST',
        dataType: "json",
        data: {
            _token: token,
            records: records,
            namespace: $('.need-batch-operation').attr('data-namespace'),
            column: $('.need-batch-operation').attr('data-column'),
        },
        success: function (data) {
            if (data.status == 'success') {
                $(`#dataTableBuilder`).DataTable().ajax.reload(null, false);
                $('.top-notification').removeClass('d-none').find('.alert').addClass('alert-success').removeClass('alert-danger').find('.alertText').text(data.message);
            } else {
                $('.top-notification').removeClass('d-none').find('.alert').addClass('alert-danger').removeClass('alert-success').find('.alertText').text(data.message);
            }
            $('.top-notification').siblings('.noti-alert').remove();
        },
        error: function (xhr, status, error) {
            $('.failed-notification').removeClass('d-none').find('.alertText').text(error);
        },
        complete: function () {
            $('.batch-delete-operation').text(jsLang('Yes, Confirm')).removeClass('disabled-btn').find('.spinner-border').remove();
            bootstrap.Modal.getOrCreateInstance(document.getElementById('batchDelete')).hide();
        }
    });
})


function updateDataTableTranslations() {
    $('#dataTableBuilder_previous').html(jsLang('Previous'));
    $('#dataTableBuilder_next').html(jsLang('Next'));
    $('.dataTables_empty').eq(0).html(jsLang('No data available in table'));
    $('#btnGroupDrop1').html(jsLang('Export'));

    let info = $('#dataTableBuilder_info').html();

    if (info) {
        let infoNumbers = info.match(/[\d\.]+/g);
        info = `${jsLang('Showing')} ${infoNumbers[0]} ${jsLang('to')} ${infoNumbers[1]} ${jsLang('of')} ${infoNumbers[2]} ${jsLang('entries')}`;
        $('#dataTableBuilder_info').html(info);
    }
}

$(() => {
    $('#dataTableBuilder')
        .on('draw.dt', () => updateDataTableTranslations());
})
