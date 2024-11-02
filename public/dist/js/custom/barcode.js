'use strict';
if ($('.main-body .page-wrapper').find('#barcode-generate-container').length) {
    stack = JSON.parse(stack);
    checkProductTableData();

    function in_array(search, array) {
        var i;
        for (i = 0; i < array.length; i++) {
            if(array[i] ==search ) {
                return true;
            }
        }
        return false;
    }

    function autoCompleteSource(request, response, url) {

        if ($('#vendor_id').val() == '' || $('#from_location_id').val() == '') {
            $('#error_message').text(jsLang('Please select vendor & origin first'));
            return false;
        } else {
            $('#error_message').text('');
        }

        $.ajax({
            url: url,
            dataType: "json",
            type: "POST",
            data: {
                _token: token,
                search: request.term,
                vendorId : $('#vendor_id').val(),
                fromLocationId : $('#from_location_id').val(),
            },
            success: function (data) {
                if (data.status == 1) {
                    var data = data.products;
                    $('#no_div').css('display', 'none');
                    response($.map(data, function (products) {
                        return {
                            id: products.id,
                            value: products.name,
                            sku: products.sku,
                            slug: products.slug
                        }
                    }));
                } else {
                    $('.ui-menu-item').remove();
                    $("#no_div").css('top', $("#search").position().top + 35);
                    $("#no_div").css('left', $("#search").position().left);
                    $("#no_div").css('width', $("#search").width());
                    $("#no_div").css('display', 'block');
                }
                //end
            }
        })
    }

    $("#search").autocomplete({
        delay: 500,
        position: {my: "left top", at: "left bottom", collision: "flip"},
        source: function (request, response) {
            autoCompleteSource(request, response, SITE_URL + '/barcode/product-search');
        },
        select: function (event, ui) {
            var e = ui.item;
            if (e.id) {
                if (!in_array(e.id, stack)) {
                    stack[e.id] = e.id;
                    var new_row = `<tbody id="rowId-${rowNo}">
                          <input type="hidden" name="product_id[]" value="${e.id}">
                          <input type="hidden" name="product_slug[]" value="${e.slug}">
                          <input type="hidden" name="product_name[]" value="${e.value}">
                          <tr class="itemRow rowNo-${rowNo}" id="productId-${e.id}"  data-row-no="${rowNo}">
                              <td class="pl-1">
                                  <a href="${HomePageUrl+'/products/'+e.slug}" target="_blank">${e.value}</a>
                              </td>
                              
                              <td class="sku">
                                  <input id="sku_${rowNo}" name="product_sku[]" class="form-control text-center" type="text" readonly value="${e.sku}">
                              </td>
                              
                              <td class="productQty">
                                  <input name="product_qty[${e.id}]" id="product_qty_${rowNo}" class="inputQty form-control text-center" type="number" value="1" data-rowId = ${rowNo}>
                              </td>
                              <td class="text-center" style="padding-top: 15px !important;">
                                  <a href="javascript:void(0)" class="closeRow" data-row-id="${rowNo}" data-id = "${e.id}"><i class="feather icon-trash"></i></a>
                              </td>
                          </tr>
                          
                      </tbody>`;
                    $('#product-table').append(new_row);
                    checkProductTableData();
                    rowNo++;
                }
                $('#productId-' + e.id).find('.inputQty').trigger("blur");
                return false;
            }
        },
        minLength: 1,
        autoFocus: true
    }).autocomplete( "instance" )._renderItem = function( ul, item ) {
        if (!in_array(item.id, stack)) {
            return $( "<li>" )
                .append( "<div>" + item.value + "</div>" )
                .appendTo( ul );
        } else {
            return $( "<li style='pointer-events:none;opacity:0.6;'>" )
                .append( "<div>" + item.value + "</div>" )
                .appendTo( ul );
        }
    };

    $(document).on("click", ".closeRow", function (e) {
        e.preventDefault();
        let selector = '#rowId-'+$(this).attr("data-row-id");
        let pId= $(this).attr('data-id');
        let i = 0;
        $(selector).remove();

        for (i = 0; i < stack.length; i++) {
            if(stack[i] == pId ) {
                stack.splice(i, 1, 0);
            }
        }
        
        checkProductTableData();
    });

    $(document).ready(function() {
        $("#printBtn").on('click', function() {
            var mode = 'iframe';
            var close = mode == "popup";
            var options = {
                mode: mode,
                popClose: close
            };
            $("div.barcode").printArea(options);
        });
    });

    function checkProductTableData()
    {
        if ($('.closeRow').length == 0) {
            stack = [];
            $('#product-table').addClass('display_none');
        } else {
            $('#product-table').removeClass('display_none');
        }
    }
}
