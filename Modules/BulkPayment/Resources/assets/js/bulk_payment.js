'use strict';
if ($('.main-body .page-wrapper').find('#order-list-container, #vendor-order-list-container').length) {
    
    $(document).on('change', '.batch-body input', function () {
        checkBulkOrder();
    });

    $(document).on('change', '.batch-header input', function () {
        checkBulkOrder();
    });

    function checkBulkOrder() {
       
        $('.batch_payment_count').text('');
        let totalSelect = 0;

            $.each($('.batch-body'), function (){                 
                if (typeof $(this).find('input:checked').val() != 'undefined') {
                    let pId = $(this).find('input:checked').val();
                    console.log(pId);
                    $.each($('.view-order'), function (){ 
                        if ($(this).attr('data-id') == pId && $(this).attr('data-payment') == 'Unpaid' || $(this).attr('data-id') == pId && $(this).attr('data-payment') == 'Partial') {
                            totalSelect++;
                            if (parseInt(totalSelect) <= parseInt(countBulkPayment)) {
                                $('.batch_payment_count').text('(' + totalSelect + ')');
                            }
                        }
                    });
                }
            });
            
            if (totalSelect > 0) {
                $('#batch_payment_btn').removeClass('display_none');
            } else {
                $('#batch_payment_btn').addClass('display_none'); 
            }
        
    }

    $(document).on('click', '#batch_payment_btn', function () {

        var records = [];
        let cnt = 1;

            $.each($('.batch-body'), function (){
            if (typeof $(this).find('input:checked').val() != 'undefined') {
                let pId = $(this).find('input:checked').val();

                $.each($('.view-order'), function (){
                    if ($(this).attr('data-id') == pId && $(this).attr('data-payment') == 'Unpaid' || $(this).attr('data-id') == pId && $(this).attr('data-payment') == 'Partial') {
                        if (parseInt(cnt) <= parseInt(countBulkPayment)) {
                            cnt++;
                            records.push(pId)
                        }
                    }
                });
            }
        });

        $.ajax({
            url: SITE_URL + '/bulk-payment/order',
            type: 'GET',
            dataType: "json",
            data: {
                _token: token,
                records: records,
            },
            success: function (data) {
                $('#unpaid_order_list').html(data.html);
            },
            error: function (xhr, status, error) {
                $('#unpaid_order_list').html(`<div class="alert alert-danger">
                        <strong class="alertText">${jsLang('Something went wrong, please try again.')}</strong>
                    </div>`);
            },
            complete: function () {
                $('#batchPaymentModal').modal('show');
                $('.transaction_date').daterangepicker(dateSingleConfig());
            }
        });
    });

    $(document).on('change', '.amount_receive', function () {
        let maxVal = parseFloat($(this).attr('max'));
        if (parseFloat($(this).val()) > maxVal) {
            $(this).val(maxVal);
        } else if (parseFloat($(this).val()) < 0) {
            $(this).val(0);
        }
    });

}
