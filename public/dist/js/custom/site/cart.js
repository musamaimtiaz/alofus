"use strict";
var options = [];
var optionNoLabelId = [];
var optionNoLabel = [];
var qty = 1;
var cartIndex = null;
var couponOffer = $('#couponOffer').text().replace(/,/g, '');
couponOffer = parseFloat(couponOffer.replace(currencySymbol,''));
var couponDiscountType = $('#couponDiscountType').val();
var couponDiscouintAmount = $('#couponDiscountAmount').val();
emptyCart();
let totalAm = $('#cart-total').text().replace(/,/g, '');
totalAm = parseFloat(totalAm.replace(currencySymbol,''));
couponDisplay();
TaxDisplay();

$(document).on('click', '.add-to-cart', function() {
    cartIndex = null;
    let itemCode = $(this).attr('data-itemCode');
    let allOptionRequired = true;
    let dupOptionBox = [];
    let cnt = 0;
    const Toast = Swal.mixin({
        toast: true,
        position: 'bottom-start',
        showConfirmButton: false,
        timer: 3000,
        timerProgressBar: true,
        didOpen: (toast) => {
            toast.addEventListener('mouseenter', Swal.stopTimer)
            toast.addEventListener('mouseleave', Swal.resumeTimer)
        }
    })
    if (itemType == 'Variable Product' && variationId == null) {
        Toast.fire({
            icon: 'error',
            title: jsLang('Please select some product options before adding this product to your cart.')
        })
    } else if (isManageStock == 1 && stockQty <= 0 && backOrders == 0) {
        Toast.fire({
            icon: 'error',
            title: jsLang('Stock is not available.')
        })
    } else {
        ajaxCall("/cart-store", itemCode, true, 'add', false, $(this));
    }
});

function getSelectedIndex()
{
    let index = [];
    $('input[name="items[]"]:checked').each(function() {
        index.push($(this).val());
    });
    return index;
}

$(document).on('click', '#delete-selected-item', function() {
    let items = getSelectedIndex();
    if (items.length > 0) {
        ajaxCall("/cart-selected-delete", items, false, 'selectedRemove');
    }
})

$(document).on('click', '.delete-cart-item', function() {
    cartIndex = $(this).attr('data-index');
    $('.delete-cart-item').css("pointer-events", "none");
    ajaxCall("/cart-delete", null, false, 'remove');
})

$(document).on('click', '#cart_clear_all', function() {
    ajaxCall("/cart-all-delete", null, false, 'removeAll');
})

function deleteShopBox()
{
    $(".shop-box").each(function() {
        let hasItem = 0;
        $(".shop-box .cart-shop").each(function() {
        let vendorId = $(this).attr('data-vendor_id');
        let vendorClass = ".cart-vendor-"+vendorId;
            let hasItemVendor = 0;
            $(vendorClass).each(function() {
                hasItem++;
                hasItemVendor++;
            });
            if (hasItemVendor == 0) {
                $(".vendor-box-before-"+vendorId).remove();
            }
        });
        if (hasItem == 0) {
            $(this).remove();
        }
    });
}

$(document).on('click', '.disable_a_href', function() {
    const Toast = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 3000,
        timerProgressBar: true,
        didOpen: (toast) => {
            toast.addEventListener('mouseenter', Swal.stopTimer)
            toast.addEventListener('mouseleave', Swal.resumeTimer)
        }
    })
    Toast.fire({
        icon: 'error',
        title: jsLang('Stock is not available.')
    })
})

$(document).on('click', '.cart-item-qty-inc', function() {
    let itemCode = $(this).attr('data-itemCode');
    if (parseFloat($('#cart-item-details-'+itemCode+' .cart-item-quantity').text()) >= 1 && parseInt($(this).attr('data-isIndividual')) != 1 || parseFloat($('#cart-item-details-'+itemCode+' .cart-item-quantity').text()) < 1) {
        qty = parseFloat($('#cart-item-details-'+itemCode+' .cart-item-quantity').text()) + 1;
        $('#cart-item-details-'+itemCode+' .cart-item-quantity').text(qty);
    }
})

$(document).on('click', '.cart-item-qty-dec', function() {
    let itemCode = $(this).attr('data-itemCode');
    if (parseFloat($('#cart-item-details-'+itemCode+' .cart-item-quantity').text()) > 1 || isGroupProduct && parseFloat($('#cart-item-details-'+itemCode+' .cart-item-quantity').text()) >= 1) {
        qty = parseFloat($('#cart-item-details-'+itemCode+' .cart-item-quantity').text()) - 1;
        $('#cart-item-details-'+itemCode+' .cart-item-quantity').text(qty);
    }
})

$("#cart-select-all").on('click', function() {
    if(this.checked) {
        document.querySelectorAll('.vendor-parent').forEach(vendor => {
            selectChildItems(vendor);
        });
    } else {
        document.querySelectorAll('.vendor-parent').forEach(vendor => {
            deselectChildItems(vendor);
        });
    }
    this.closest('#selecAllBox').classList.toggle('border-gray-12');
});

$(document).on('click', '.cart-shop', function() {
    let parent = getParentVendor(this);
    toggleChildItems(parent);

    if(allVendorChecked()) {
        $('#selecAllBox').addClass('border-gray-12');
        document.querySelector('#cart-select-all').checked = true;
    } else {
        $('#selecAllBox').removeClass('border-gray-12');
        document.querySelector('#cart-select-all').checked = false;
    }
});

$(document).on('click', '.checkOut', function() {
    if($(this).attr('href') == 'javascript:void(0)') {
        const ToastError = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true,
            didOpen: (toast) => {
                toast.addEventListener('mouseenter', Swal.stopTimer)
                toast.addEventListener('mouseleave', Swal.resumeTimer)
            }
        })
        ToastError.fire({
            icon: 'error',
            title: jsLang('Please select a product first!')
        })
    } else {
        $(this).addClass('pointer-events-none');
        $(this).html(`<span>${jsLang('Proceed to Checkout')}</span>
         <svg class="animate-spin text-gray-700 h-full mx-2 relative" xmlns="http://www.w3.org/2000/svg" width="15" height="10" fill="none" viewBox="0 0 24 24">
            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="#000" stroke-width="3"></circle>
            <path class="opacity-75" fill="#fff" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
        </svg>`);
    }
});


function getGroupSimpleProductQty()
{
    qtyArray = [];
    if (isGroupProduct) {
        $('.cart-item-qty-inc').each(function() {
            let itemCode = $(this).attr('data-itemCode');
            if (parseFloat($('#cart-item-details-'+itemCode+' .cart-item-quantity').text()) > 0 && $(this).attr('data-type') != 'Variable Product') {
                qtyArray.push({code:itemCode, qty:parseFloat($('#cart-item-details-'+itemCode+' .cart-item-quantity').text())});
            }
        })
    }
}

function isShopAllChecked()
{
    let flag = true;
    $('.cart-shop').each(function() {
        if ($(this).prop("checked")) {

        } else {
            flag = false;
        }
    })

    if (flag == true) {
        $("#cart-select-all").prop('checked', true);
    } else {
        $("#cart-select-all").prop('checked', false);
    }
}

function checkingCheckbox(isQtyMultiply = true)
{
    let totalSubPrice = 0;
    let checkOutPgeEnable = false;
    let totalTax = 0;
    let totalShipping = 0;
    $(".cart-shop").each(function() {
        let vendorId = $(this).attr('data-vendor_id');
        let vendorClass = ".cart-vendor-"+vendorId;
        $(vendorClass).each(function() {
            let itemPrice = parseFloat($(this).attr('data-price'));
            let itemQuantity = parseFloat($(this).attr('data-quantity'));
            let tax = parseFloat($(this).attr('data-tax'));
            let shipping = parseFloat($(this).attr('data-shipping'));
            if ($(this).prop("checked")) {
                totalSubPrice = totalSubPrice + (itemPrice * itemQuantity);
                isQtyMultiply == true ? totalTax += tax * itemQuantity : totalTax += tax;
                totalShipping += shipping;
                checkOutPgeEnable = true;
            }
        });
    });
    if (checkOutPgeEnable == true) {
        $(".checkOut").attr("href", SITE_URL+"/checkout");
    } else {
        $(".checkOut").attr("href", "javascript:void(0)");
    }
    totalPriceByChecked(totalSubPrice, totalTax, totalShipping);
}

$(document).on('click', '.cart-item-single', function() {
    let parent = getParentVendor(this);
    if(isAllChildChecked(parent)) {
        parent.classList.add("border-gray-12");
        parent.querySelector('.cart-shop').checked = true;

    } else {
        parent.classList.remove("border-gray-12");
        parent.querySelector('.cart-shop').checked = false;
    }

    if (!this.checked) {
        document.querySelector('#selecAllBox').classList.remove('border-gray-12')
        document.querySelector('#cart-select-all').checked = false;
    }
    updateTotalBox();

    checkingCheckbox();
});


$(document).on('change', '.shipping_method', function() {
    let index = $(this).attr('data-index');
    let address = null;
    if($('#ship_different').is(':checked')){
        address = {
            'address_id' : $(this).attr('data-addressId'),
            'country' :  $('#shipping_address_country').val(),
            'state' :  $('#shipping_address_state').val(),
            'city' :  $('#shipping_address_city').val(),
            'zip' : $('#shipping_address_zip').val(),
            'billing_country' : $('#country').val(),
            'billing_state' :  $('#state').val(),
            'billing_city' :  $('#city').val(),
            'billing_zip' : $('#zip').val(),
            'ship_different' : "on",
        };
    } else if ($('#selected_tab').val() == 'new') {
        address = {
            'address_id' : $(this).attr('data-addressId'),
            'country' :  $('#country').val(),
            'state' :  $('#state').val(),
            'city' :  $('#city').val(),
            'zip' : $('#zip').val(),
        };
    }

    ajaxCall("/cart-select-shipping", index, false, null, true, null, address, 'no');
});

const allVendorChecked = () => {
    let shops = document.querySelectorAll('.cart-shop');
    for (let index = 0; index < shops.length; index++) {
        const element = shops[index];
        if(!element.checked) {
            return false;
        }
    }
    return true;
}

const updateTotalBox = () => {
    if(allVendorChecked()) {
        $('#selecAllBox').addClass('border-gray-12');
        document.querySelector('#cart-select-all').checked = true;
    } else {
        $('#selecAllBox').removeClass('border-gray-12');
        document.querySelector('#cart-select-all').checked = false;
    }
}

const toggleBorder = (parent) => {
    if(parent.classList.value.includes('border-gray-12')) {
        parent.classList.remove("border-gray-12");
        parent.querySelector('.cart-shop').checked = false;
    } else {
        parent.classList.add("border-gray-12");
        parent.querySelector('.cart-shop').checked = true;
    }
}

const getParentVendor = (child) => {
    return child.closest('.vendor-parent');
}

const isAllChildChecked = (parent) => {
    let children = parent.querySelectorAll('.cart-item-single');
    for (let index = 0; index < children.length; index++) {
        let element = children[index];
        if(!element.checked) {
            return false
        }
    }
    return true;
}

const toggleChildItems = (parent) => {
    if(isAllChildChecked(parent)) {
        deselectChildItems(parent)
    } else {
        selectChildItems(parent);
    }
}

const selectChildItems = (parent) => {
    let children = parent.querySelectorAll('.cart-item-single');
    children.forEach(element => {
        element.checked = true;
    });
    parent.classList.add("border-gray-12");
    parent.querySelector('.cart-shop').checked = true;
    checkingCheckbox()
}

const deselectChildItems = (parent) => {
    let children = parent.querySelectorAll('.cart-item-single');
    children.forEach(element => {
        element.checked = false;
    });
    parent.classList.remove("border-gray-12");
    parent.querySelector('.cart-shop').checked = false;
    checkingCheckbox()
}

function isShopAllItemChecked(shopClass, index, shopId)
{
    let flag = true;
    $(shopClass).each(function() {
        if ($(this).prop("checked")) {

        } else {
            flag = false;
        }
    });
    if (flag == true) {
        $('.cart-shop').each(function() {
            if($(this).attr('data-shop_id') == shopId) {
                $(this).prop('checked', true);
            }
        })
    } else {
        $('.cart-shop').each(function() {
            if($(this).attr('data-shop_id') == shopId) {
                $(this).prop('checked', false);
            }
        })
    }
    isShopAllChecked();
}
$(document).on('click', '.cart-page-item-qty-inc', function() {
    cartIndex = $(this).attr('data-index');
    let itemId = $(this).attr('data-itemId');
    let itemCode = $(this).attr('data-code');
    if ($(this).attr('data-type') == 'Variable Product') {
        variationId = itemId;
        itemCode = $(this).attr('data-parent_code');
    }  else {
        variationId = null;
    }
    let price = $(this).attr('data-price');
    qty = 1;
    $('.cart-page-item-qty-inc').css("pointer-events", "none");
    $('.cart-page-item-qty-dec').css("pointer-events", "none");
    ajaxCall("/cart-store", itemCode, false,'qtyIncrement');
})

$(document).on('click', '.cart-page-item-qty-dec', function() {
    cartIndex = $(this).attr('data-index');
    let itemId = $(this).attr('data-itemId');
    let itemCode = $(this).attr('data-code');
    if ($(this).attr('data-type') == 'Variable Product') {
        variationId = itemId;
        itemCode = $(this).attr('data-parent_code');
    }  else {
        variationId = null;
    }
    let price = $(this).attr('data-price');
    let qtyPre = $('#cart-item-'+cartIndex+' .cart-item-quantity').text() != '' ? parseFloat($('#cart-item-'+cartIndex+' .cart-item-quantity').text()) : parseFloat($('#cart-item-header-'+cartIndex+' .cart-item-quantity-header').text());
    if (parseFloat(qtyPre) > 1) {
        qty = parseFloat(qtyPre) - 1;
        $('.cart-page-item-qty-inc').css("pointer-events", "none");
        $('.cart-page-item-qty-dec').css("pointer-events", "none");
        ajaxCall("/cart-reduce-qty", itemCode, false,'qtyDecrement');
    }
})


function ajaxCall(url, itemCode, msgShow = false, action = null, isSelected = false, thisHtml = null, address = null, is_remove = 'yes')
{
    let svg = '';
    getGroupSimpleProductQty();
    const Toast = Swal.mixin({
        toast: true,
        position: 'bottom-start',
        showConfirmButton: false,
        timer: 3000,
        timerProgressBar: true,
        didOpen: (toast) => {
            toast.addEventListener('mouseenter', Swal.stopTimer)
            toast.addEventListener('mouseleave', Swal.resumeTimer)
        }
    })
    $.ajax({
        url: SITE_URL + url,
        data: {
            'code': itemCode,
            'qty' : qty,
            'variation_id' : variationId,
            'group_products' : qtyArray,
            'is_group_product' : isGroupProduct,
            'cartIndex' : cartIndex,
            'attribute_ids' : variationAttributeIds,
            'action' : action,
            'address' : address,
            "_token": token
        },
        type: 'POST',
        dataType: 'JSON',
        beforeSend: function(xhr) {
            if (action == 'add') {
                thisHtml.addClass('pointer-events-none');
                let animateSvg = `<svg class="animate-spin text-gray-700 h-full" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" width="20" height="19">
                                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="#000" stroke-width="3"></circle>
                                        <path class="opacity-75" fill="#fff" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                   </svg>
                                     `;
                if (thisHtml.hasClass('cart-details-page')) {
                    animateSvg += `<span class="pl-2 p-5p dm-bold font-bold text-gray-12 text-lg">${jsLang('Add to Cart')}</span>`;
                    svg = thisHtml.find('button').html();
                    setTimeout(() => {
                        thisHtml.find('button').html(animateSvg);
                    }, 5);
                } else if (thisHtml.hasClass('cart-filter-details-page')) {
                    animateSvg += `<span class="pl-2 dm-bold font-bold text-gray-12 text-sm">${jsLang('Add to Cart')}</span>`;
                    animateSvg = animateSvg.replace('width="17"', '');
                    animateSvg = animateSvg.replace('height="16"', '');
                    svg = thisHtml.find('button').html();
                    setTimeout(() => {
                        thisHtml.find('button').html(animateSvg);
                    }, 5);
                } else {
                    animateSvg = animateSvg.replace('width="20"', '');
                    animateSvg = animateSvg.replace('height="19"', '');
                    svg = thisHtml.find('div').html();
                    thisHtml.find('div').html(animateSvg);
                }
            }

            if (isSelected && $('.checked-loader').length != 0) {
                setTimeout(() => {
                    $(".checked-loader").block({
                        message: `<div class="flex justify-center">
                        <svg class="animate-spin text-gray-700 w-4 h-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="#000" stroke-width="3"></circle>
                        <path class="opacity-75" fill="#fff" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                        </div>`,
                        css: {
                            backgroundColor: "transparent",
                            border: "none",
                        },
                    });
                }, 5);
            }
        },
        success: function (data) {
            if (msgShow == true || data.status == 0) {
                if (data.status == 1) {

                    if (isGroupProduct == "1" && jQuery.isArray(qtyArray)) {
                        $.each(qtyArray, function (i,v) {
                            if (qtyArray.length > 1) {
                                cartAddPopUpMsg(v['code'], data, action, true);
                            } else {
                                cartAddPopUpMsg(v['code'], data, action);
                            }
                        });
                    } else {
                        cartAddPopUpMsg(itemCode, data, action);
                    }
                } else {
                    Toast.fire({
                        icon: 'error',
                        title: jsLang(data.message)
                    })
                }
            } else {
                if (isSelected == true && data.status == 1) {
                    shippingTax(data.tax, data.shipping, data.totalPrice, data.shippingIndex, data.displayTax);
                    if (is_remove == 'yes') {
                        $('#applied-coupon').html('');
                        $('#checkOutMsg').text('');
                    }
                } else if (data.status == 1) {
                    updateCart(data.totalProduct, data.totalPrice, data.carts, itemCode, action)
                    if (typeof data.b2bPriceActive != "undefined" && data.b2bPriceActive == true) {
                        location.reload();
                    }
                }
            }
        },
        error: function() {
            $('.cart-page-item-qty-inc').css("pointer-events", "auto");
            $('.cart-page-item-qty-dec').css("pointer-events", "auto");
            $('.delete-cart-item').css("pointer-events", "auto");
            if (action == 'add') {
                thisHtml.removeClass('pointer-events-none');
                if (thisHtml.hasClass('cart-details-page') || thisHtml.hasClass('cart-filter-details-page')) {
                    thisHtml.find('button').html(svg);
                } else {
                    thisHtml.find('div').html(svg);
                }
            }
            if (isSelected && $('.checked-loader').length != 0) {
                $(".checked-loader").unblock();
            }
            setTotalAmount();
            couponDisplay();
            TaxDisplay();

            Toast.fire({
                icon: 'error',
                title: jsLang('Something went wrong, please try again.')
            })
        },
        complete: function() {
            if (action == 'add') {
                thisHtml.removeClass('pointer-events-none');
                if (thisHtml.hasClass('cart-details-page') || thisHtml.hasClass('cart-filter-details-page')) {
                    thisHtml.find('button').html(svg);
                } else {
                    thisHtml.find('div').html(svg);
                }
            }
            if (isSelected && $('.checked-loader').length != 0) {
                $(".checked-loader").unblock();
            }
            setTotalAmount();
            couponDisplay();
            TaxDisplay();
        }
    });
}

function cartAddPopUpMsg(itemCode, data, action, isGroupProduct = false)
{
    const Toast = Swal.mixin({
        toast: true,
        position: 'bottom-start',
        showConfirmButton: false,
        timer: 3000,
        timerProgressBar: true,
        didOpen: (toast) => {
            toast.addEventListener('mouseenter', Swal.stopTimer)
            toast.addEventListener('mouseleave', Swal.resumeTimer)
        }
    })

    if (isGroupProduct) {
        Toast.fire({
            width: 304,
            html: `
            <div>
                <div class="flex gap-2">
                    <div class="mt-5">
                        <h1 class="dm-sans font-medium text-gray-12 text-base">${jsLang('All product')}</h1>
                        <h3 class="roboto-medium font-medium text-sm text-gray-10 whitespace-nowrap">${jsLang('has been added to cart.')}</h3>
                    </div>
                </div>
                <div class="flex justify-between mt-3">
                    <a href="${SITE_URL + '/carts'}" class="text-center py-2 w-120p border border-gray-2 rounded-sm text-xs dm-bold text-gray-12 font-bold transition ease-in-out duration-200 hover:border-gray-12 hover:text-gray-12">${jsLang('View Cart')}</a>
                    <a href="${SITE_URL + '/checkout?select=all'}" class="text-center py-2 w-120p border border-gray-2 rounded-sm text-xs dm-bold text-white font-bold bg-gray-12 hover:bg-yellow-1 hover:text-gray-12">${jsLang('Checkout')}</a>
                </div>
            </div>
        `,
        });
    } else {
        var item = [];
        for (const key in data.carts) {
            if (data.carts[key].type == 'Variable Product') {
                if (data.carts[key].parent_code == itemCode) {
                    if (data.carts[key].variation_id == variationId) {
                        item = data.carts[key];
                        break;
                    }
                }
            } else {
                if (data.carts[key].code == itemCode) {
                    item = data.carts[key];
                    break;
                }
            }
        }
        Toast.fire({
            width: 304,
            html: `
            <div>
                <div class="flex gap-2">
                    <div class="w-20 h-20 mr-3.5">
                        <img class="h-full w-full" src="${item.photo}" alt="">
                    </div>
                    <div class="mt-5">
                        <h1 class="dm-sans font-medium text-gray-12 text-base">${item.name.substring(0,15)}...</h1>
                        <h3 class="roboto-medium font-medium text-sm text-gray-10 whitespace-nowrap">${jsLang('has been added to cart.')}</h3>
                    </div>
                </div>
                <div class="flex justify-between mt-3">
                    <a href="${SITE_URL + '/carts'}" class="text-center py-2 w-120p border border-gray-2 rounded-sm text-xs dm-bold text-gray-12 font-bold transition ease-in-out duration-200 hover:border-gray-12 hover:text-gray-12">${jsLang('View Cart')}</a>
                    <a href="${SITE_URL + '/checkout?select=all'}" class="text-center py-2 w-120p border border-gray-2 rounded-sm text-xs dm-bold text-white font-bold bg-gray-12 hover:bg-yellow-1 hover:text-gray-12">${jsLang('Checkout')}</a>
                </div>
            </div>
        `,
        });
    }

    updateCart(data.totalProduct, data.totalPrice, data.carts, itemCode, action)
}

function shippingTax(tax = 0, shippingArr = null, totalPrice, shippingIndex = 0, displayTax = null)
{
    let customTax = `<div id="customTax">`;
    let totalTax = 0;
    if (displayTax == 'itemized') {
        $.each(tax, function (i, v) {
            totalTax += v;
            customTax += `
                            <div class="flex justify-between mt-3">
                                <div class="text-sm">${i}</div>
                                    <div class='text-sm text-right'>
                                        <span class="customTax">${decimalNumberFormatWithCurrency(v)}</span>
                                    </div>
                            </div>
                            `;
        });
    } else {
        totalTax += tax;
        customTax += `
                <div class="flex justify-between mt-3">
                    <div class="text-sm">${jsLang('Tax')}</div>
                        <div class='text-sm text-right'>
                            <span class="customTax">${decimalNumberFormatWithCurrency(tax)}</span>
                        </div>
                </div>
                `;
    }
    customTax += `</div>`;
    $('#customTax').replaceWith(customTax);
    let shipping = '';
    $('#shipping_method').empty();
    shipping = `<div id="shipping_method" class="w-full">`;
    shipping += `<div class="text-sm">${jsLang('Shipping')}</div>`
    shipping += `<ul>`
    let shipCount = 0;
    let shipingIntailValue = 0;
    $.each(shippingArr, function (ii, vv) {
        if (shipCount == shippingIndex) {
            shipingIntailValue = vv;
        } else {
            shipCount == 0 ? shipingIntailValue = vv : '';
        }
        shipping += `
                       <li>
                            <div class="mt-2 w-full">
                                <div class="flex justify-between items-center w-full shipping-radio-button-custom">
                                    <div class="flex items-center">
                                        <input type="radio" name="shipping_method" data-value="${vv}" class="shipping_method cursor-pointer" id="${shipCount}" data-index="${shipCount}" ${shipCount == shippingIndex ? 'checked' : ''}><label for="${shipCount}" class="text-sm ml-2 shipping-radio-button-label cursor-pointer">${ii}:</label>
                                    </div>
                                    <label> ${decimalNumberFormatWithCurrency(vv)}</label>
                                </div>
                            </div>
                       </li>
                  `;
        shipCount++;
    });
    shipping += `</ul>`;
    shipping += `</div>`;
    shipCount > 0 ? $('#shipping_method').replaceWith(shipping) : '';
    $('#cart-total').text(decimalNumberFormatWithCurrency((totalPrice - couponOffer) + totalTax + parseFloat(shipingIntailValue)));
    $('#cart-total-d').text(decimalNumberFormatWithCurrency((totalPrice - couponOffer) + totalTax + parseFloat(shipingIntailValue)));
}


function updateCart(totalProduct, totalPrice, carts = [], itemCode = null, action = null)
{
    let qty;
    let cartHeader = '';
    if (parseInt(totalProduct) == 0) {
        $('#totalCartItem').addClass('display-none')
    } else {
        $('#totalCartItem').removeClass('display-none')
    }
    $('#totalCartItem').text(totalProduct);
    $('#totalCartitemPage').text(totalProduct);
    if (action == 'add') {
        cartHeader += `<div class="w-full h-60s padding-bottom-150p px-30p scrollbar-w-2 overflow-auto mt-10p" id="cart-header">`;
        $.each(carts, function (index, value) {
            let optionNames = null;
            let options = null;
            let optionHtml = '';
            let slug = value['type'] == 'Variable Product' ? value['parent_slug'] : value['slug'];
            cartHeader += `
            <div class="flex cursor-pointer border-gray-100 cart-item-header mt-5" id="cart-item-header-${index}">
                <div class="h-72p w-24 border border-gray-2 rounded">
                    <img class="h-full w-full p-0.5 object-cover" src="${value['photo']}" alt="img product">
                </div>
                <div class="flex flex-col justify-center text-sm w-64 ml-5 rtl-mr-20">
                    <a href="${ SITE_URL+'/products/'+slug }"><div class="dm-sans font-medium text-gray-12 text-18 pb-2">${value['name'].substring(0, 16)+'...'}</div></a>
                    ${optionHtml}
                    <div class="cart-item-quantity roboto-medium font-medium text-gray-10 text-base leading-5">${value['quantity']} × ${getDecimalNumberFormat(value['price'])}</div>

                </div>
                <div class="flex flex-col w-18 font-medium justify-center ml-10">
                    <a href="${`javascript:void(0)`}" class="w-4 h-4 rounded-full cursor-pointer text-red-700 delete-cart-item" data-index="${index}">
                        <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 13 13" fill="none">
                            <path fill-rule="evenodd" clip-rule="evenodd" d="M0.455612 0.455612C1.06309 -0.151871 2.04802 -0.151871 2.6555 0.455612L11.9888 9.78895C12.5963 10.3964 12.5963 11.3814 11.9888 11.9888C11.3814 12.5963 10.3964 12.5963 9.78895 11.9888L0.455612 2.6555C-0.151871 2.04802 -0.151871 1.06309 0.455612 0.455612Z" fill="#898989"/>
                            <path fill-rule="evenodd" clip-rule="evenodd" d="M11.9897 0.455612C11.3822 -0.151871 10.3973 -0.151871 9.78981 0.455612L0.45648 9.78895C-0.151003 10.3964 -0.151003 11.3814 0.45648 11.9888C1.06396 12.5963 2.04889 12.5963 2.65637 11.9888L11.9897 2.6555C12.5972 2.04802 12.5972 1.06309 11.9897 0.455612Z" fill="#898989"/>
                        </svg>
                    </a>
                </div>
            </div>
          `;
        });

        cartHeader += `
             <div class="absolute justify-center bg-white flex flex-col inset-x-0 px-30p mt-30p bottom-5">
                    <div class="border-t border-gray-2">
                        <div class="pt-4 pb-30p flex justify-between dm-sans font-medium text-gray-12 text-22">
                            <p class="">${jsLang('Subtotal')}:</p>
                            <p id="cart-item-total-price">${decimalNumberFormatWithCurrency(totalPrice)}</p>
                       </div>
                    </div>

                    <div id="view-cart-display" class="bg-white text-gray-12 border border-gray-2 p-2 w-full rounded mb-10p">
                        <a href="${SITE_URL+"/carts"}" class="flex justify-center px-4 py-2 rounded font-bold cursor-pointer dm-bold text-18">
                        ${jsLang('View Cart')}
                        </a>
                   </div>

                   <div id="checkout-display" class="bg-gray-12 text-white p-2 w-full rounded">
                        <a  href="${SITE_URL+"/checkout?select=all"}" class="flex justify-center px-4 py-2 font-bold cursor-pointer dm-bold text-18">
                            ${jsLang('Go to Checkout')}
                        </a>
                   </div>

                   <div class="text-gray-10 mt-5"
                   aria-label="Clear All" id="cart_clear_all">
                     <div id="clear-all-display" class="flex  justify-center items-center cursor-pointer">
                           <p class="mr-2 rtl-direction-space-left dm-sans font-medium text-gray-10">${jsLang('Clear All')}
                               </p>
                               <svg xmlns="http://www.w3.org/2000/svg" width="15" height="16" viewBox="0 0 15 16" fill="none">
                                   <path fill-rule="evenodd" clip-rule="evenodd" d="M5.83333 11.6667C5.3731 11.6667 5 11.2937 5 10.8334L5 8.33341C5 7.87318 5.3731 7.50008 5.83333 7.50008C6.29357 7.50008 6.66667 7.87318 6.66667 8.33341L6.66667 10.8334C6.66667 11.2937 6.29357 11.6667 5.83333 11.6667Z" fill="#898989"/>
                                   <path fill-rule="evenodd" clip-rule="evenodd" d="M9.16732 11.6667C8.70708 11.6667 8.33398 11.2937 8.33398 10.8334L8.33398 8.33341C8.33398 7.87318 8.70708 7.50008 9.16732 7.50008C9.62755 7.50008 10.0007 7.87318 10.0007 8.33341L10.0007 10.8334C10.0007 11.2937 9.62756 11.6667 9.16732 11.6667Z" fill="#898989"/>
                                   <path fill-rule="evenodd" clip-rule="evenodd" d="M0.8552 5.01385C0.657717 5.00037 0.399686 4.99992 0 4.99992V3.33325C0.00891358 3.33325 0.0177978 3.33325 0.0266526 3.33325C0.0445462 3.33325 0.0623196 3.33325 0.0799725 3.33325H14.92C14.9377 3.33325 14.9555 3.33325 14.9733 3.33325L15 3.33325V4.99992C14.6003 4.99992 14.3423 5.00037 14.1448 5.01385C13.9548 5.02681 13.8824 5.04899 13.8478 5.06335C13.6436 5.14793 13.4813 5.31016 13.3968 5.51435C13.3824 5.54903 13.3602 5.62139 13.3473 5.81139C13.3338 6.00887 13.3333 6.2669 13.3333 6.66659L13.3333 11.7214C13.3334 12.4602 13.3334 13.0967 13.2649 13.6064C13.1914 14.1527 13.0258 14.6763 12.6011 15.101C12.1764 15.5257 11.6528 15.6914 11.1065 15.7648C10.5968 15.8333 9.96027 15.8333 9.22153 15.8333H5.77847C5.03973 15.8333 4.40322 15.8333 3.89351 15.7648C3.34724 15.6914 2.82362 15.5257 2.3989 15.101C1.97418 14.6763 1.80856 14.1527 1.73512 13.6064C1.66659 13.0967 1.66662 12.4602 1.66666 11.7214L1.66667 6.66659C1.66667 6.2669 1.66622 6.00887 1.65274 5.81139C1.63978 5.62139 1.6176 5.54903 1.60323 5.51435C1.51865 5.31016 1.35643 5.14793 1.15224 5.06335C1.11756 5.04899 1.0452 5.02681 0.8552 5.01385ZM11.8107 4.99992H3.18933C3.26749 5.23126 3.29962 5.46462 3.31554 5.69793C3.33335 5.95898 3.33334 6.27439 3.33333 6.63993L3.33333 11.6666C3.33333 12.4758 3.3351 12.9989 3.38692 13.3843C3.43552 13.7458 3.51397 13.8591 3.57741 13.9225C3.64085 13.9859 3.75414 14.0644 4.11559 14.113C4.50101 14.1648 5.0241 14.1666 5.83333 14.1666H9.16667C9.9759 14.1666 10.499 14.1648 10.8844 14.113C11.2459 14.0644 11.3592 13.9859 11.4226 13.9225C11.486 13.8591 11.5645 13.7458 11.6131 13.3843C11.6649 12.9989 11.6667 12.4758 11.6667 11.6666V6.63993C11.6667 6.27439 11.6666 5.95898 11.6845 5.69793C11.7004 5.46462 11.7325 5.23126 11.8107 4.99992Z" fill="#898989"/>
                                   <path fill-rule="evenodd" clip-rule="evenodd" d="M8.67175 0.101025C8.31844 0.0332505 7.90785 0 7.50015 0C7.09245 4.96705e-08 6.68185 0.0332505 6.32855 0.101025C6.15192 0.134907 5.979 0.179406 5.82234 0.238021C5.68005 0.291261 5.48597 0.37965 5.32178 0.532849C4.98526 0.84682 4.96699 1.37414 5.28096 1.71065C5.57723 2.0282 6.06348 2.06237 6.40011 1.8014C6.40204 1.80065 6.40412 1.79985 6.40639 1.799C6.45085 1.78237 6.52809 1.7598 6.64254 1.73785C6.87139 1.69395 7.17407 1.66667 7.50015 1.66667C7.82623 1.66667 8.12891 1.69395 8.35775 1.73785C8.4722 1.7598 8.54944 1.78237 8.59391 1.799C8.59617 1.79985 8.59826 1.80065 8.60018 1.8014C8.93681 2.06237 9.42306 2.0282 9.71933 1.71065C10.0333 1.37414 10.015 0.846819 9.67852 0.532848C9.51432 0.37965 9.32025 0.29126 9.17795 0.23802C9.02129 0.179405 8.84837 0.134907 8.67175 0.101025Z" fill="#898989"/>
                           </svg>
                      </div>
                   </div>
            </div>
        `;
        cartHeader += `</div>`;

        $('#cart-header').replaceWith(cartHeader);
    }
    if (action == 'remove') {
        $('#cart-item-'+cartIndex).remove();
        $('#cart-item-header-'+cartIndex).remove();
        $('.delete-cart-item').css("pointer-events", "auto");
        if (carts.length == 0) {
            $('#cart-items').append(`<h3 class="text-xl mt-4 font-bold dark:text-gray-2 text-center" class="cart-empty">${jsLang('Empty!')}</h3>`);
            $('#checkOut').hide();
            $('#selecAllBox').hide();
            $('#checkout-display a').attr('href','javascript:void(0)');
        }
        totalPriceUpdate(totalPrice);
        checkingCheckbox();
        deleteShopBox();
    }
    if (action == 'selectedRemove') {
        $.each(itemCode, function (i, v){
            $('#cart-item-'+v).remove();
            $('#cart-item-header-'+v).remove();
        });
        if (carts.length == 0) {
            $('#cart-items').append(`<h3 class="text-xl mt-4 font-bold dark:text-gray-2 text-center" class="cart-empty">${jsLang('Empty!')}</h3>`);
            $('#checkOut').hide();
            $('#selecAllBox').hide();
        }
        totalPriceUpdate(totalPrice);
        checkingCheckbox();
        deleteShopBox();

    }
    if (action == 'qtyIncrement') {
        $('.cart-page-item-qty-inc').css("pointer-events", "auto");
        $('.cart-page-item-qty-dec').css("pointer-events", "auto");
        qty = $('#cart-item-'+cartIndex+' .cart-item-quantity').text() != '' ? parseFloat($('#cart-item-'+cartIndex+' .cart-item-quantity').text()) + 1 : parseFloat($('#cart-item-header-'+cartIndex+' .cart-item-quantity-header').text()) + 1;
        quantityPriceUpdate(qty, parseFloat(carts[cartIndex]['price']), totalPrice, parseFloat(carts[cartIndex]['discount_amount']), carts[cartIndex]['discount_type'], carts[cartIndex]['actual_price']);
    }
    if (action == 'qtyDecrement') {
        $('.cart-page-item-qty-inc').css("pointer-events", "auto");
        $('.cart-page-item-qty-dec').css("pointer-events", "auto");
        qty = $('#cart-item-'+cartIndex+' .cart-item-quantity').text() != '' ? parseFloat($('#cart-item-'+cartIndex+' .cart-item-quantity').text()) - 1 : parseFloat($('#cart-item-header-'+cartIndex+' .cart-item-quantity-header').text()) - 1;
        quantityPriceUpdate(qty, parseFloat(carts[cartIndex]['price']), totalPrice, parseFloat(carts[cartIndex]['discount_amount']), carts[cartIndex]['discount_type'], carts[cartIndex]['actual_price']);
    }

    if (action == 'removeAll') {
        $('.cart-item-header').remove();
        if (carts.length == 0) {
            $('#cart-items').append(`<h3 class="text-xl mt-4 font-bold dark:text-gray-2 text-center" class="cart-empty">${jsLang('Empty!')}</h3>`);
            $('#checkOut').hide();
            $('#selecAllBox').hide();
            $('#checkout-display a').attr('href','javascript:void(0)');
        }
        totalPriceUpdate(totalPrice);
        checkingCheckbox();
        deleteShopBox();
    }
    emptyCart();
    $('#applied-coupon').html('');
    $('#checkOutMsg').text('');
}

function quantityPriceUpdate(qty, price, totalPrice, discountAmount, discountType, actualPrice)
{
    $('#cart-item-'+cartIndex+' .cart-item-quantity').text(qty);
    $('#cart-item-'+cartIndex+' .cart-item-quantity').text(qty);

    $('#cart-item-'+cartIndex+' .cart-item-single').removeAttr("data-quantity");
    $('#cart-item-'+cartIndex+' .cart-item-single').attr("data-quantity", qty);

    discountType != "Percent" ? $('#discount-amount-'+cartIndex).text(getDecimalNumberFormat(discountAmount * qty)) : '';

    $('#cart-item-header-'+cartIndex+' .cart-item-quantity').text(qty+ " × "+getDecimalNumberFormat(price));
    $('#cart-item-header-'+cartIndex+' .cart-item-quantity-header').text(qty);
    $('#cart-item-header-'+cartIndex+' .cart-item-price').text(getDecimalNumberFormat(price * qty));
    totalPriceUpdate(totalPrice);
    checkingCheckbox();
}

function totalPriceUpdate(totalPrice)
{
    $('#cart-item-total-price').text(decimalNumberFormatWithCurrency(totalPrice));
}

function totalPriceByChecked(totalPrice, totalTax = 0, totalShipping = 0)
{
    couponOffer = 0;
    $('#couponOffer').text(decimalNumberFormatWithCurrency(couponOffer));
    $('#cart-subtotal').text(decimalNumberFormatWithCurrency(totalPrice));

    setTimeout(() => {
        let index = getSelectedIndex();
        ajaxCall("/cart-selected-store", index, false, null, true);
    }, 500);
}

function emptyCart()
{
    if (parseInt($('#totalCartItem').text()) > 0) {
        $('#emptyCart').hide();

    } else {
        $('#emptyCart').show();
        $('#view-cart-display').hide();
        $('#clear-all-display').hide();
        $('#checkout-display').addClass("text-gray-10 bg-gray-11");
        $('#checkout-display').removeClass("bg-gray-12");
    }
}

$("#checkCoupon").on('click', function(event) {
    let disCountCode = $('#discount_code').val();
    let html = $(this);
    if (disCountCode.length > 0) {
        $.ajax({
            url: SITE_URL + "/check-coupon",
            data: {
                discount_code: disCountCode,
                "_token": token
            },
            type: 'POST',
            dataType: 'JSON',
            beforeSend: function(xhr) {
                html.addClass('pointer-events-none');
                html.find('a').html(`
                   <svg class="animate-spin text-gray-700 h-full" xmlns="http://www.w3.org/2000/svg" height="34" width="34" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="#000" stroke-width="3"></circle>
                        <path class="opacity-75" fill="#fff" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                `)
            },
            success: function (data) {
                let txt = jsLang('Congrats you are eligible for this coupon in this order.');
                if (data.status == 1) {
                    $('#checkOutMsg').removeClass('error');
                    $('#checkOutMsg').addClass('success');

                    couponOffer = 0;
                    let appliedCoupon = ``;
                    $.each(data.data, function (i,v) {
                         appliedCoupon += `
                        <div class="flex justify-between mt-15p delete-coupons-${jsLang(v.id)}">
                                    <div class="flex justify-center items-center">
                                        <div class="delete-button-tooltip delete-icons relative inline-block" data-id="${jsLang(v.id)}"><svg
                                                class="cursor-pointer" xmlns="http://www.w3.org/2000/svg" width="14"
                                                height="15" viewBox="0 0 14 15" fill="none">
                                                <path fill-rule="evenodd" clip-rule="evenodd"
                                                    d="M5.29215 10.584C4.87461 10.584 4.53613 10.2455 4.53613 9.82797L4.53613 7.55993C4.53613 7.1424 4.87461 6.80392 5.29215 6.80392C5.70968 6.80392 6.04816 7.1424 6.04816 7.55993L6.04816 9.82797C6.04816 10.2455 5.70968 10.584 5.29215 10.584Z"
                                                    fill="#898989" />
                                                <path fill-rule="evenodd" clip-rule="evenodd"
                                                    d="M8.31656 10.584C7.89903 10.584 7.56055 10.2455 7.56055 9.82797L7.56055 7.55993C7.56055 7.1424 7.89902 6.80392 8.31656 6.80392C8.73409 6.80392 9.07257 7.1424 9.07257 7.55993L9.07257 9.82797C9.07257 10.2455 8.73409 10.584 8.31656 10.584Z"
                                                    fill="#898989" />
                                                <path fill-rule="evenodd" clip-rule="evenodd"
                                                    d="M0.775851 4.54886C0.596691 4.53664 0.362602 4.53623 0 4.53623V3.0242C0.00808653 3.0242 0.0161464 3.0242 0.0241796 3.0242C0.040413 3.0242 0.0565373 3.0242 0.0725523 3.0242H13.5357C13.5517 3.0242 13.5678 3.0242 13.5841 3.0242L13.6082 3.0242V4.53623C13.2456 4.53623 13.0115 4.53664 12.8324 4.54886C12.66 4.56062 12.5944 4.58074 12.5629 4.59377C12.3777 4.67051 12.2305 4.81768 12.1538 5.00293C12.1407 5.03439 12.1206 5.10003 12.1088 5.2724C12.0966 5.45156 12.0962 5.68565 12.0962 6.04825L12.0962 10.6341C12.0962 11.3043 12.0963 11.8817 12.0341 12.3442C11.9675 12.8397 11.8172 13.3148 11.4319 13.7001C11.0466 14.0854 10.5716 14.2357 10.076 14.3023C9.61356 14.3645 9.03611 14.3644 8.36591 14.3644H5.24232C4.57212 14.3644 3.99467 14.3645 3.53225 14.3023C3.03667 14.2357 2.56163 14.0854 2.17632 13.7001C1.79101 13.3148 1.64075 12.8397 1.57412 12.3442C1.51195 11.8817 1.51199 11.3043 1.51202 10.6341L1.51203 6.04825C1.51203 5.68565 1.51162 5.45156 1.49939 5.2724C1.48763 5.10003 1.46751 5.03439 1.45448 5.00293C1.37775 4.81768 1.23057 4.67051 1.04533 4.59377C1.01387 4.58074 0.94822 4.56062 0.775851 4.54886ZM10.7148 4.53623H2.89341C2.96432 4.7461 2.99347 4.95781 3.00791 5.16948C3.02407 5.4063 3.02406 5.69244 3.02405 6.02407L3.02405 10.5843C3.02405 11.3185 3.02566 11.793 3.07267 12.1427C3.11675 12.4706 3.18793 12.5734 3.24548 12.6309C3.30303 12.6885 3.40581 12.7597 3.73372 12.8038C4.08338 12.8508 4.55794 12.8524 5.29209 12.8524H8.31614C9.05029 12.8524 9.52485 12.8508 9.87451 12.8038C10.2024 12.7597 10.3052 12.6885 10.3627 12.6309C10.4203 12.5734 10.4915 12.4706 10.5356 12.1427C10.5826 11.793 10.5842 11.3185 10.5842 10.5843V6.02407C10.5842 5.69244 10.5842 5.4063 10.6003 5.16948C10.6148 4.95781 10.6439 4.7461 10.7148 4.53623Z"
                                                    fill="#898989" />
                                                <path fill-rule="evenodd" clip-rule="evenodd"
                                                    d="M7.86786 0.0916516C7.54733 0.0301653 7.17484 0 6.80496 0C6.43509 4.50619e-08 6.06259 0.0301654 5.74207 0.0916517C5.58184 0.12239 5.42496 0.16276 5.28283 0.215936C5.15374 0.264236 4.97768 0.344425 4.82871 0.483409C4.52342 0.768248 4.50684 1.24664 4.79168 1.55193C5.06047 1.84001 5.5016 1.87101 5.807 1.63425C5.80874 1.63358 5.81064 1.63285 5.81269 1.63208C5.85303 1.61699 5.9231 1.59652 6.02693 1.5766C6.23454 1.53677 6.50914 1.51203 6.80496 1.51203C7.10079 1.51203 7.37539 1.53677 7.583 1.5766C7.68683 1.59652 7.7569 1.61699 7.79724 1.63208C7.79929 1.63285 7.80119 1.63358 7.80293 1.63425C8.10833 1.87101 8.54946 1.84001 8.81824 1.55193C9.10308 1.24664 9.0865 0.768247 8.78122 0.483408C8.63225 0.344424 8.45619 0.264236 8.32709 0.215936C8.18497 0.162759 8.02809 0.12239 7.86786 0.0916516Z"
                                                    fill="#898989" />
                                            </svg>
                                            <span class="delete-button-tooltiptext bg-gray-12 text-white dm-sans text-14 font-medium">${jsLang('Click to delete the coupon.')}</span>
                                        </div>
                                        <p class="text-gray-12 dm-sans font-medium Uppercase text-sm pl-2">${jsLang('Coupon')}: ${v.code}</p>
                                    </div>
                                    <p class="text-gray-12 dm-sans font-medium text-sm coupon-amount">- ${decimalNumberFormatWithCurrency(v.calculated_discount)}</p>
                                </div>
                        `;
                        couponOffer += parseFloat(v.calculated_discount);
                    });

                    $('#applied-coupon').html(appliedCoupon);
                    $('#couponOffer').text(decimalNumberFormatWithCurrency(couponOffer));
                    shippingTax(data.tax, data.shipping, data.totalPrice, data.shippingIndex, data.displayTax);
                    setTotalAmount();
                } else {
                    txt = jsLang(data.message);
                    $('#checkOutMsg').removeClass('success');
                    $('#checkOutMsg').addClass('error');
                }
                $('#checkOutMsg').text(txt);
                $('#checkOutMsg').show();
                $('#discount_code').val(null);
            },
            complete: function() {
                html.removeClass('pointer-events-none');
                html.find('a').html(`
                   <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 34 34" height="34" width="34">
                        <rect x="0.5" y="0.5" width="33" height="33" rx="1.5" fill="currentColor" stroke="#DFDFDF"></rect>
                        <path fill-rule="evenodd" clip-rule="evenodd" d="M19.0813 13L17.9039 14.2018L19.8128 16.1502H11.8325C11.3727 16.1502 11 16.5307 11 17C11 17.4693 11.3727 17.8498 11.8325 17.8498H19.8128L17.9039 19.7982L19.0813 21L23 17L19.0813 13Z" fill="#2C2C2C"></path>
                    </svg>
                `);

                couponDisplay();
            }
        });
    } else {
        $('#checkOutMsg').removeClass('success')
        $('#checkOutMsg').addClass('error');
        $('#checkOutMsg').text(jsLang('This field is required.'));
        $('#checkOutMsg').show();
    }
});

// delete the coupon
$(document).on('click', '.delete-icons', function () {
    let couponIndex = $(this).attr('data-id');
    let couponAmount = $('.delete-coupons-'+couponIndex).find('.coupon-amount').text().replace(/,/g, '');
    couponAmount = couponAmount.replace(currencySymbol,'');
    couponAmount = parseFloat(couponAmount.replace('-',''));
    $.ajax({
        url: SITE_URL + "/delete-coupon",
        data: {
            index : couponIndex,
            "_token": token
        },
        type: 'POST',
        dataType: 'JSON',
        beforeSend: function(xhr) {
            setTimeout(() => {
                $(".checked-loader").block({
                    message: `<div class="flex justify-center">
                    <svg class="animate-spin text-gray-700 w-4 h-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="#000" stroke-width="3"></circle>
                    <path class="opacity-75" fill="#fff" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
                    </div>`,
                    css: {
                        backgroundColor: "transparent",
                        border: "none",
                    },
                });
            }, 5);
        },
        success: function (data) {
            if (data.status == 1) {
                $('#checkOutMsg').removeClass('error');
                $('#checkOutMsg').removeClass('success');
                $('#checkOutMsg').text('');
                couponOffer = data.coupon_amount;
                $('#couponOffer').text(decimalNumberFormatWithCurrency(couponOffer));
                shippingTax(data.tax, data.shipping, data.totalPrice, data.shippingIndex, data.displayTax);
                setTotalAmount();
            } else {
                let txt = jsLang(data.message);
                $('#checkOutMsg').removeClass('success');
                $('#checkOutMsg').addClass('error');
            }
            $('#discount_code').val(null);
        },
        complete: function() {
            $('.delete-coupons-'+couponIndex).remove();
            $(".checked-loader").unblock();
            couponDisplay();
        }
    });

});

function setTotalAmount()
{
    totalAm = $('#cart-total').text().replace(/,/g, '');
    totalAm = parseFloat(totalAm.replace(currencySymbol,''));
}

if ($('.main-body .page-wrapper').find('#cart-details-container').length) {
    document.querySelectorAll('.vendor-parent').forEach(element => {
        if(isAllChildChecked(element)) {
            element.classList.add("border-gray-12");
            element.querySelector('.cart-shop').checked = true;
        }
    });

    updateTotalBox();

    checkingCheckbox(false);
}

function couponDisplay()
{
    if (parseFloat(couponOffer) > 0) {
        $('.couponOffer').removeClass('display-none');
    } else {
        $('.couponOffer').addClass('display-none');
    }
}

function TaxDisplay()
{
    let tempTax = 0;
    let flag = false;
    $.each($('.customTax'), function (){
        tempTax = $(this).text().replace(/,/g, '');
        tempTax = parseFloat(tempTax.replace(currencySymbol,''));
        if (tempTax > 0) {
            flag = true;
        }
    });
    if (flag) {
        $('#customTax').removeClass('display-none');
    } else {
        $('#customTax').addClass('display-none');
    }
}
