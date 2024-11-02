"use strict";
if ($('.main-body .page-wrapper').find('#user-download-list').length) {
    if (isFound) {
        $('#downloadData').removeClass('display-none');
    } else {
        $('#downloadData').addClass('display-none');
    }
}
