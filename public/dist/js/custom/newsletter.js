'use strict';

if ($('.main-body .page-wrapper').find('#subscriber-edit-container').length) {
    $('input[name="confirmation_date"]').daterangepicker(dateSingleConfig($('input[name="confirmation_date"]').val()));
}
