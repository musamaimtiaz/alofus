// Open modal
"use strict";
var defaultPrice = $("#item_priceV").text();
var selectedIds = [];
var discountInPercent = 0;
var actualArray = [];
possbileVariations = JSON.parse(possbileVariations);
defaultSelectV();
if (itemType != 'Variable Product') {
    getCountDownV(formatedSaleTo, offerFlag);
}
$(".placeholder-loader").css("display", "none");
$(document)
    .off("click", ".open-view-modal")
    .on("click", ".open-view-modal", function () {
        $(".placeholder-loader").css("display", "block");
        $(".item-view-content").css("display", "none");
        $("#view-modal").css("display", "flex");
        var itemCode = $(this).attr("data-itemCode");
        $.ajax({
            url: SITE_URL + "/product/quick-view/" + itemCode,
            type: "GET",
            success: function (data) {
                isGroupProduct = 0;
                $(".placeholder-loader").css("display", "none");
                $(".item-view-content").css("display", "block");
                $("#item-view-load").html(data);
                $("#view-modal").css("display", "flex");
            },
        });
    });

// Close modal when click outside of the modal

$(document).on("click", function (e) {
    if (
        !(
            $(e.target).closest("#view-modal-main").length > 0 ||
            $(e.target).closest(".open-view-modal").length > 0
        )
    ) {
        if (tempIsGroupProduct) {
            qty = 1;
        }
        itemType = tempItemType;
        isGroupProduct = tempIsGroupProduct;
        $("#view-modal").css("display", "none");
        $(".placeholder-loader").css("display", "block");
        $(".item-view-content").css("display", "none");
    }
});

$(document).on("click", ".open-view-modal-close", function (e) {
    qty = 1;
    isGroupProduct = tempIsGroupProduct;
    itemType = tempItemType;
    $("#view-modal").css("display", "none");
    $(".placeholder-loader").css("display", "block");
    $(".item-view-content").css("display", "none");
});

var mainPriceV = $("#item_priceV").text().replace(/,/g, "");
var amountV = [];

function enableAddToCartV(optionRealId) {
    let allOption = [];
    $.each($(".option_priceV"), function (i, v) {
        allOption[i] =
            typeof $(this).find(":selected").attr("data-optionRealId") !=
            "undefined"
                ? $(this).find(":selected").attr("data-optionRealId")
                : $(this).attr("data-optionRealId");
    });
    if (!jQuery.inArray(optionRealId, allOption)) {
        $("#item-add-to-cartV").addClass("add-to-cart");
        $("#item-add-to-cartV").removeClass("disable_a_href");
    }
}

$(".singleCheckBoxV").on("click", function () {
    let selectedOptionId = $(this).attr("data-optionId");
    let selectedOption = $(this).attr("data-option");
    $(".multiChkV-" + selectedOption).each(function () {
        if ($(this).attr("data-optionId") != selectedOptionId) {
            $(this).prop("checked", false);
        }
    });
});
// slider and zoom
var galleryThumbs = new Swiper(".gallery-thumbsV", {
    observer: true,
    observeParents: true,
    spaceBetween: 17,
    slidesPerView: 4,
    freeMode: true,
    watchSlidesVisibility: true,
    watchSlidesProgress: true,
    preloadImages: false,
    breakpoints: {
        1024: {
            slidesPerView: 5,
            spaceBetween: 17,
        },
    },
});

var swiper = new Swiper(".swiper-container-mainV", {
    observer: true,
    observeParents: true,
    observeChildren: true,
    pagination: {
        el: ".swiper-pagination",
        clickable: true,
    },
    navigation: {
        nextEl: ".swiper-button-next",
        prevEl: ".swiper-button-prev",
    },
    preloadImages: false,
    keyboard: {
        enabled: true,
    },
    effect: "coverflow",
    coverflowEffect: {
        rotate: 60,
        slideShadows: false,
    },
    thumbs: {
        swiper: galleryThumbs,
    },
});

$(".zoom").mousemove(function (e) {
    var offsetX, offsetY, x, y;
    var zoomer = e.currentTarget;
    e.offsetX ? (offsetX = e.offsetX) : (offsetX = e.touches[0].pageX);
    e.offsetY ? (offsetY = e.offsetY) : (offsetX = e.touches[0].pageX);
    x = (offsetX / zoomer.offsetWidth) * 100;
    y = (offsetY / zoomer.offsetHeight) * 100;
    zoomer.style.backgroundPosition = x + "% " + y + "%";
});
// slider and zoom end
$("#clear-variationV").on('click', function () {
    removeAllhiddenV(true);
    $("#clear-variationV").addClass("display-none");
    $("#stock_qtyV").addClass("display-none");
    $("#item_priceV").addClass("display-none");
    $("#countDownV").addClass("display-none");
    $('#varMinMaxPriceV').removeClass("display-none");
    $('#b2b_tableV').html('');
    variationImageV("", "default");
    variationId = null;
    variationAttributeIds = [];
});

$(document).on("change", ".item-variationsV", function (event) {
    if ($(this).val().length != 0) {
        getPossibleIdV(
            $("option:selected", this).attr("data-id"),
            $("option:selected", this).attr("data-position")
        );
    } else {
        removeAllhiddenV();
    }
    getVariationIdsV();
    attributePriceV();
    if (checkOneSelectedV() == true) {
        $("#clear-variationV").removeClass("display-none");
    } else {
        $("#clear-variationV").addClass("display-none");
    }
});

function defaultSelectV()
{
    $.each($('.item-variationsV option'), function () {
        if((this.selected)) {
            if ($(this).val().length != 0) {
                getPossibleIdV($('option:selected', this).attr('data-id'), $('option:selected', this).attr('data-position'));
            } else {
                removeAllhiddenV();
            }
            getVariationIdsV();
            attributePriceV();
            if (checkOneSelectedV() == true) {
                $('#clear-variationV').removeClass('display-none');
            } else {
                $('#clear-variationV').addClass('display-none');
            }
        }
    })
}

function attributePriceV() {
    let parseAttributePriceWithId;
    let flag = true;
    parseAttributePriceWithId = JSON.parse(attributePriceWithId);
    $.each(parseAttributePriceWithId, function (i, v) {
        if (getPossbileAttributeWithPriceV(v.attributeIds)) {
            flag = false;
            selectedIds = [];
            $("#availabilityV").addClass("display-none");
            $("#item_priceV").removeClass("display-none");
            $("#item_priceV").text(decimalNumberFormatWithCurrency(v.price));
            $('#varMinMaxPriceV').addClass("display-none");
            variationId = v.variation_id;
            variationAttributeIds = v.attributeIds;
            backOrders = v.backOrders;
            if (v.priceType == "sale") {
                discountInPercent = v.discountInPercent;
                offerFlag = true;
                getCountDownV(v.saleTo, true);
            } else {
                offerFlag = false;
                $("#countDownV").addClass("display-none");
            }
            variationImageV(v.images);

            if (v.is_enable_b2b == "1") {
                $('#b2b_tableV').html('');
                showB2BDataV(v.b2b_data);
            } else {
                $('#b2b_tableV').html('');
            }

            if (
                v.manage_stocks == 1 &&
                stockHide == 0 &&
                parseInt(v.stock_quantity) >= 0
            ) {
                $("#stock_qtyV").removeClass("display-none");
                if (stockDisplayFormat == 'always_show') {
                    var message = jsLang(":x items remaining"); message = message.replace(':x' , v.stock_quantity);
                    $('#stock_qtyV').html("<span class='text-green-1 capitalize leading-4 bg-green-2 px-4 py-2 text-sm roboto-medium font-medium rounded mr-2.5 rtl-direction-space-left'>"+ jsLang('In Stock') +"</span> " + message);
                } else if (stockDisplayFormat == 'sometime_show' && parseInt(v.stock_quantity) <= parseInt(v.lowStockThreshold) && parseInt(v.stock_quantity) != 0) {
                    var msg = jsLang('Only :x left in stock');
                    msg = msg.replace(':x', v.stock_quantity);
                    $('#stock_qtyV').text(msg);
                }
            } else if (
                v.manage_stocks == 1 &&
                stockHide == 0 &&
                parseInt(v.stock_quantity) <= 0 &&
                backOrders == 0
            ) {
                $("#stock_qtyV").removeClass("display-none");
                if (stockDisplayFormat == 'always_show' || stockDisplayFormat == 'sometime_show') {
                    $('#stock_qtyV').html('<span class="text-reds-3 leading-4 bg-pinks-2 px-4 py-2 text-sm roboto-medium font-medium rounded capitalize">' + jsLang("Out Of Stock") + '</span>');
                }
            } else {
                $("#stock_qtyV").addClass("display-none");
            }
            return false;
        }
    });
    if (flag == true) {
        variationId = null;
        variationAttributeIds = [];
        $("#item_priceV").addClass("display-none");
        $("#stock_qtyV").addClass("display-none");
        $('#varMinMaxPriceV').removeClass("display-none");
        checkAllSelectedV() == true
            ? $("#availabilityV").removeClass("display-none")
            : "";
        variationImageV(null, "default");
    }
}

function showB2BDataV(b2bData)
{
    let b2bRow = ``;
    $.each(b2bData, function (i,b2b){
        if (b2b['min_qty'] && b2b['max_qty'] && b2b['price']) {
            b2bRow += `<tr class="py-4 px-6 border">
                        <td class="py-4 px-6 border">${ b2b['min_qty'] }</td>
                        <td class="py-4 px-6 border">${ b2b['max_qty'] }</td>
                        <td class="py-4 px-6 border">${ b2b['price'] }</td>
                    </tr>`;
        }
    });

    let b2bTable = `<table class="text-left w-full border-collapse border text-sm md:text-13 mt-10p">
                            <tbody class="text-gray-10 roboto-medium">
                              <th class="py-4 px-6 border">${ jsLang('Min Qty') }</th>
                              <th class="py-4 px-6 border">${ jsLang('Max Qty') }</th>
                              <th class="py-4 px-6 border">${ jsLang('B2B prices') }</th>
                              ${b2bRow}
                            </tbody>
                          </table>`;

    $('#b2b_tableV').append(b2bTable);
}

function checkAllSelectedV() {
    let flag = true;
    $(".item-variationsV").each(function (i, v) {
        if ($(this).val().length != 0) {
            flag != false ? (flag = true) : "";
        } else {
            flag = false;
        }
    });
    return flag;
}
function checkOneSelectedV() {
    let flag = false;
    $(".item-variationsV").each(function (i, v) {
        if ($(this).val().length != 0) {
            flag = true;
        }
    });
    return flag;
}

function getPossibleIdV(value, position) {
    let selectableId = possbileVariations[value];
    if (typeof actualArray != 'undefined' && actualArray.length == 0) {
        actualArray = selectableId;
    }

    $(".item-variationsV option").each(function (i, v) {
        if (!$(this).is(":selected") && $(this).val().length != 0) {
            if (jQuery.inArray($(this).attr("data-id"), actualArray) != -1) {
                $(this).removeClass("display-none");
            } else {
                if ($(this).attr("data-position") == 1) {
                    checkPositionV($(this).attr("data-position")) == false
                        ? $(this).addClass("display-none")
                        : "";
                } else {
                    $(this).addClass("display-none");
                }
            }
        }
    });
}

function checkPositionV(position) {
    let flag = true;
    if (position == 1) {
        $(".item-variationsV option").each(function (i, v) {
            if (
                $(this).is(":selected") &&
                $(this).attr("data-position") == position
            ) {
                flag != false ? (flag = true) : "";
            } else {
                if ($(this).is(":selected") && $(this).val().length != 0) {
                    flag = false;
                }
            }
        });
    }
    return flag;
}

function removeAllhiddenV(isAll = false) {
    let flag = true;
    $(".item-variationsV").each(function (i, v) {
        if ($(this).val().length == 0) {
            flag != false ? (flag = true) : "";
        } else {
            flag = isAll;
        }
    });
    if (flag == true) {
        actualArray = [];
        $(".item-variationsV option").each(function (i, v) {
            $(this).removeClass("display-none");
        });
        if (isAll == true) {
            $(".item-variationsV").each(function (i, v) {
                $(this).val("");
            });
        }
    }
}

function variationImageV(images, action = "variation") {
    let sliderImage = ``;
    let zoomImage = ``;
    let cnt = 0;
    let featuredHtml = ``;
    let reviewAvgHtml = ``;
    let discountHtml = ``;
    if (parseInt(featured) == 1) {
        featuredHtml = `<p class="primary-bg-color h-5 w-max mb-2.5 justify-center text-white px-2 flex items-center text-center rounded-sm leading-3 roboto-medium font-medium text-11">${jsLang(
            "Featured"
        )}</p>`;
    }
    if (parseInt(reviewAvg) == 5) {
        reviewAvgHtml = `<div class="flex justify-center items-center px-1.5 whitespace-nowrap mb-2.5 bg-green-5 h-5 leading-3 roboto-medium font-medium text-white text-11 w-max rounded-sm">
                            <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 12 12" fill="none">
                                <path d="M5 0L6.12257 3.45492H9.75528L6.81636 5.59017L7.93893 9.04508L5 6.90983L2.06107 9.04508L3.18364 5.59017L0.244718 3.45492H3.87743L5 0Z" fill="white"/>
                            </svg>
                            <p>${jsLang("Top Rated")}</p>
                        </div>`;
    }
    if (offerFlag == true) {
        discountHtml = `<p class="primary-bg-color h-5 text-gray-12 px-2 mb-2.5 justify-center flex items-center rounded-sm leading-3 roboto-medium w-max font-medium text-11 whitespace-nowrap uppercase">${discountInPercent}% ${jsLang(
            "off"
        )}</p>`;
    }
    if (action == "variation") {
        cnt++;
        sliderImage += `
                     <div class="swiper-slide flex justify-center items-center border-gray-2 rounded-sm swiper-slide-thumbs">
                        <img class="p-1.5 object-contain h-12 cursor-pointer" src="${images}" alt="">
                    </div>
                `;
        zoomImage += `
                    <div class="absolute z-10 left-3.5 top-3.5">
                        ${featuredHtml}
                        ${reviewAvgHtml}
                        ${discountHtml}
                    </div>
                     <div class="swiper-slide minimum-height neg-transition-scale w-full zoom" style="background-image: url(${images})">
                            <img class="swiper-slide-img neg-transition-scale" src="${images}" alt="...">
                      </div>
                `;
        $("#zoomImageV").html(zoomImage);
        $("#sliderImageV").html(sliderImage);
    } else if (action == "default") {
        let defaultParse = "";
        discountHtml = ``;
        defaultParse = JSON.parse(defaultImages);
        $.each(defaultParse, function (i, v) {
            cnt++;
            if(videoExtensions.map((extension) => v.includes(extension)).includes(true)){
                var src = `<video
                preload="auto"
                >
                <source src="${v}" type="video/mp4">
            </video>`
            }
            else{
                var src = `<img class="p-1.5 object-contain h-12 cursor-pointer" src="${v}" alt="...">`
            }
            if(defaultParse.length>1){
            sliderImage += `
                        <div class="swiper-slide flex justify-center items-center border-gray-2 rounded-sm swiper-slide-thumbs">
                            ${src}
                        </div>
                `;
            }
            if(videoExtensions.map((extension) => v.includes(extension)).includes(true)){
                var isImg = false;
                var src = `<video
                class="w-full h-[336px] md:h-[370px]"
                controls
                autoplay
                muted
                loop
                >
                <source src="${v}" type="video/mp4">
            </video>`
            }
            else{
                var isImg = true;
                var src = `<img class="swiper-slide-img neg-transition-scale" src="${v}" alt="...">`
            }
            zoomImage += `
                        <div class="absolute z-10 left-3.5 top-3.5">
                            ${featuredHtml}
                            ${reviewAvgHtml}
                            ${discountHtml}
                        </div>
                        <div class="swiper-slide  minimum-height w-full ${isImg ? 'zoom' : ''} neg-transition-scale" style="background-image: url(${v})">
                            ${src}
                        </div>
                `;
        });
        $("#zoomImageV").html(zoomImage);
        $("#sliderImageV").html(sliderImage);
    }
    slideImagecount = cnt;

    // *product slider and zoom*
    var galleryThumbs = new Swiper(".gallery-thumbsV", {
        spaceBetween: 17,
        slidesPerView: 4,
        freeMode: true,
        watchSlidesVisibility: true,
        watchSlidesProgress: true,
        preloadImages: false,
        breakpoints: {
            1024: {
                slidesPerView: 5,
                spaceBetween: 17,
            },
        },
    });

    var swiper = new Swiper(".swiper-container-mainV", {
        observer: true,
        observeParents: true,
        observeChildren: true,
        pagination: {
            el: ".swiper-pagination",
            clickable: true,
        },
        navigation: {
            nextEl: ".swiper-button-next",
            prevEl: ".swiper-button-prev",
        },
        preloadImages: false,
        keyboard: {
            enabled: true,
        },
        effect: "coverflow",
        coverflowEffect: {
            rotate: 60,
            slideShadows: false,
        },
        thumbs: {
            swiper: galleryThumbs,
        },
    });

    $(".zoom").mousemove(function (e) {
        var offsetX, offsetY, x, y;
        var zoomer = e.currentTarget;
        e.offsetX ? (offsetX = e.offsetX) : (offsetX = e.touches[0].pageX);
        e.offsetY ? (offsetY = e.offsetY) : (offsetX = e.touches[0].pageX);
        x = (offsetX / zoomer.offsetWidth) * 100;
        y = (offsetY / zoomer.offsetHeight) * 100;
        zoomer.style.backgroundPosition = x + "% " + y + "%";
    });
}
// end product slider and zoom
function getVariationIdsV() {
    let cnt = 0;
    $(".item-variationsV option").each(function (i, v) {
        if ($(this).is(":selected") && $(this).val().length != 0) {
            selectedIds[cnt++] = $(this).attr("data-id");
        }
    });
}

function getPossbileAttributeWithPriceV(attributeIds) {
    let flag = true;
    $.each(attributeIds, function (i, v) {
        if (jQuery.inArray(v, selectedIds) != -1) {
            if (flag != false) {
                flag = true;
            }
        } else {
            flag = false;
            updateProductPriceV(defaultPrice, null);
        }
    });
    if (flag) {
        return flag;
    }
}

function updateProductPriceV(price, action = "variation") {
    if (action == "variation") {
        $("#item_priceV").text(decimalNumberFormatWithCurrency(price));
    } else {
        $("#item_priceV").text(price);
    }
}

function getCountDownV(saleDate, isActive) {
    clearInterval(offerTimer);
    if (isActive == true) {
        let isValid = false;
        var countDownDate = new Date(saleDate).getTime();

        // Update the count down every 1 second
        offerTimer = setInterval(function () {
            // Get today's date and time
            var now = new Date().getTime();

            // Find the distance between now and the count down date
            var distance = countDownDate - now;

            // Time calculations for days, hours, minutes and seconds
            var days = Math.floor(distance / (1000 * 60 * 60 * 24));
            var hours = Math.floor(
                (distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60)
            );
            var minutes = Math.floor(
                (distance % (1000 * 60 * 60)) / (1000 * 60)
            );
            var seconds = Math.floor((distance % (1000 * 60)) / 1000);

            // Output the result in an element with id="demo"
            if (days >= 0 && $("#count_daysV").length > 0 && $("#count_othersV").length > 0) {
                isValid = true;
                document.getElementById("count_daysV").innerHTML =
                    days + jsLang("Days");
                document.getElementById("count_othersV").innerHTML =
                    hours +
                    " " +
                    jsLang("hrs") +
                    " : " +
                    minutes +
                    " " +
                    jsLang("mins") +
                    " : " +
                    +seconds +
                    " " +
                    jsLang("sec");
            }
        }, 1000);
        setTimeout(function () {
            if (isValid) {
                $("#countDownV").removeClass("display-none");
            } else {
                $("#countDownV").addClass("display-none");
            }
        }, 1000);
    }
}
