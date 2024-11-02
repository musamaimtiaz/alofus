"use strict";
if ($('.main-body .page-wrapper').find('#refund-edit-container, #refund-list-container, #vendor-refund-list-container').length) {
    $('.select2').select2();
}
if ($('.main-body .page-wrapper').find('#order-refund-container').length) {
    $(document).on('click', '.decrement-item', function() {
        let item_quantity = $('input[name="quantity_sent"]').val();
        if (item_quantity > 1) {
            $('.item-quantity').text(item_quantity - 1);
            $('input[name="quantity_sent"]').val(item_quantity - 1)
        }
    })
    $(document).on('click', '.increment-item', function() {
        let item_quantity = $('input[name="quantity_sent"]').val();
        if (item_quantity < max_quantity) {
            $('.item-quantity').text(++item_quantity);
            $('input[name="quantity_sent"]').val(item_quantity++)
        }
    })
}

$(document).ready(function() {
    // Message box scroll bar move to bottom
    var messageBox = $('.message-box')
    messageBox.scrollTop(messageBox.prop("scrollHeight"));
})
