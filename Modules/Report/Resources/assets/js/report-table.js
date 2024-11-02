"use strict";
$(document).ready(function() {
    $('#report-table').DataTable({ 
        "language": {
            "url": app_locale_url
        },
        "pageLength": parseInt(row_per_page)
    });
});