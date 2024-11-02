"use strict";

if ($('.main-body .page-wrapper').find('#invoice-view-container').length) {
    var maxQty = 1;

    let orderDate = $('#order_date').val();
    $('#order_date').daterangepicker(selectFromTo(orderDate.length > 0 ? orderDate : null));
    let deliveryDate = $('#deliveryDate').val();
    if (typeof deliveryDate != 'undefined') {
        $('#deliveryDate').daterangepicker(selectFromTo(deliveryDate.length > 0 ? deliveryDate : null));
    }
    $('.select2').select2();

    $(document).on('click', '#refundApply', function(e) {
        e.preventDefault();
        let orderDetailId = $(this).attr('data-detailId');
        $('#order_detail_id').val(orderDetailId);
        maxQty = parseInt($(this).attr('data-qty'));
        $('#refundQty').text(1);
        $('#refund-store').modal('show');
    });

    $(document).on('click', '#refundQtyDec', function(e) {
        e.preventDefault();
        let qty = parseInt($('#refundQty').text());
        qty = qty - 1;
        if (qty > 0) {
            $('#refundQty').text(qty);
        }
        $('#quantity_sent').val(qty);
    });
    $(document).on('click', '#refundQtyInc', function(e) {
        e.preventDefault();
        let qty = parseInt($('#refundQty').text());
        qty = qty + 1;
        if (qty <= maxQty) {
            $('#refundQty').text(qty);
        }
        $('#quantity_sent').val(qty);
    });


}
if ($('.main-body .page-wrapper').find('#vendor-order-view-container, #invoice-view-container').length) {
    $(".accordion").on('click', function() {
        $(this).siblings().toggle(500);
        var icon = $(this).find('.drop-down-icon');
        if (icon.hasClass('rotate-180')) {
            icon.removeClass('rotate-180');
            icon.addClass('rotate-0');
        } else {
            icon.removeClass('rotate-0');
            icon.addClass('rotate-180');
        }
    });
}

if ($('.main-body .page-wrapper').find('#vendor-invoice-view-container').length) {
    (function () {
        var previous;
        $(".status").on('focus', function () {
            previous = this.value;
        }).on('change', function() {
            swal({
                title: jsLang('Are you sure?'),
                icon: "warning",
                buttons: true,
                dangerMode: true,
            })
                .then((willDelete) => {
                    if (willDelete) {
                        let status = $(this).val();
                        let detailId = $(this).attr('data-id');
                        let data = {
                            'id' : detailId,
                            'status_id' : status,
                        };
                        clickOnSave("/orders/change-status", "POST", data);
                        if (paymentStatus != "Paid" && finalOrderStatus == status) {
                            $(this).val(previous);
                        } else if (finalOrderStatus == status && paymentStatus == "Paid") {
                            $(this).attr('disabled', 'disabled');
                        }
                    } else {
                        $(this).val(previous);
                        swal(jsLang('Your data is safe!'));
                    }
                });
        });
    })();
}
