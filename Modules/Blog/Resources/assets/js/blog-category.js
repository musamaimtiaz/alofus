"use strict";

if ($('.main-body .page-wrapper').find('#item-list-container').length) {
    $('#edit-payment').on('show.bs.modal', function (e) {
        $('#edit-id').val($(e.relatedTarget).attr('id'));
        $('#name').val($(e.relatedTarget).attr('name'));
        $('#edit_status').val($(e.relatedTarget).attr('status'));
        if ($(e.relatedTarget).attr('status') == 'Active') {
            $('.is_default').attr('checked', 'checked');
        }
    });

    var checked = false;
    $(document).on('click', '.cr', function() {
        checked = checked == 'checked' ? false : 'checked';
        $('.is_default').attr('checked', checked);
        if (checked == 'checked') {
            $('#edit_status').val('Active');
        }
    })

}
