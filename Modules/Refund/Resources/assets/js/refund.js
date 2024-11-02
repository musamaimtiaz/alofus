'use strict';

const refundDt = new DataTransfer();
var refundObj = {};

imgInp.onchange = evt => {
    var files = imgInp.files, filesLength = files.length;

    for (var i = 0; i < filesLength; i++) {
        var f = files[i];
        if (i < 5 && refundDt.files.length < 5) {
            refundDt.items.add(f)

            var rand = (Math.random() + 1).toString(36).substring(7);
            refundObj[rand] = f;

            var fileReader = new FileReader();
            fileReader.onload = (function(e) {
                $('#refund_image').append(`
                    <div class="refund-image mt-5">
                        <img data-file="${rand}" class="r-img w-16 h-16 object-cover neg-transition-scale" src="${e.target.result}"/>
                        <span>&#10060</span>
                    </div>
                `);
            });
            fileReader.readAsDataURL(f);
        }
    }
    imgInp.files = refundDt.files;
}

$(document).on('click', '.refund-image span', function() {
    var file_key = $(this).siblings('.r-img').attr('data-file');
    var file = refundObj.file_key;
    refundDt.items.remove(file);
    $('#imgInp')[0].files = refundDt.files;
    $(this).closest('div.refund-image').remove();
})

function quantitySelect() {
    var qty = $("select[name='order_items']").find(':selected').data('quantity');
    var orderDetailId = $("select[name='order_items']").find(':selected').data('order_detail_id');
    $('input[name="order_detail_id"]').val(orderDetailId)
    $("select[name='quantity_sent']").html(`<option value="">${jsLang('Select one')}</option>`);
    for (let index = 1; index <= qty; index++) {
        $("select[name='quantity_sent']").append(`
            <option value="${index}">${index}</option>
        `)
    }
}
var itemFind = false;
function findProducts(reference) {
    $.ajax({
        url: SITE_URL + "/user/refund-products/" + reference,
        type: 'GET',
        dataType: 'JSON',
        success: function (data) {
            $('#order_items').html(`<option value="">${jsLang('Select one')}</option>`);
            for (const key in data[reference]) {
                $('#order_items').append(`
                    <option ${product_id == data[reference][key].product_id ? 'selected' : ''} data-order_detail_id="${data[reference][key].id}" data-quantity="${data[reference][key].quantity}" value="${data[reference][key].product_id}">${data[reference][key].product_name}</option>
                `)
            }
            itemFind = true;
        }
    })

}

if (product_id > 0) {
    findProducts($("select[name='order_reference']").val());
    var refund_count = 1;
    var intervals = setInterval(() => {
        refund_count++;
        if (itemFind == true) {
            quantitySelect();
            clearInterval(intervals);
        }
        if (refund_count == 300) {
            clearInterval(intervals);
        }
    }, 100);

}

$("select[name='order_reference']").on('change',function() {
    var tmp = this;
    clearTimeout(debounce );
    var debounce = setTimeout(function() {
        var reference = $(tmp).val();
        if (reference) {
            findProducts(reference);
        } else {
            $('#order_items').html(`<option value="">${jsLang('Select one')}</option>`)
            $("select[name='quantity_sent']").html(`<option value="">${jsLang('Select one')}</option>`);
        }

    }, 100);
})

$("select[name='order_items']").on('change', function() {
    quantitySelect();
});

// Message box scroll bar move to bottom
var messageBox = $('.message-box');
messageBox.scrollTop(messageBox.prop("scrollHeight"));


$('.refund-select').select2();