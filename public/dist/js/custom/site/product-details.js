"use strict";
if ($(".main-body .page-wrapper").find("#item-details-container").length) {
    var ratingValue = 0;
    var amount = [];
    var rateClickEnable = false;

    var defaultPrice = $("#item_price").text();
    var selectedIds = [];
    var outOfStockVisible = 0;
    possbileVariations = JSON.parse(possbileVariations);
    defaultAttributes = JSON.parse(defaultAttributes);
    if (itemType != 'Variable Product') {
        getCountDown(formatedSaleTo, offerFlag);
    }
    var actualArray = [];
    defaultSelect();
    var discountInPercent = 0;
    hasB2BData();
    $(document).ready(function () {
        /* 1. Visualizing things on Hover - See next part for action on click */
        $("#stars li")
            .on("mouseover", function () {
                var onStar = parseInt($(this).data("value"), 10); // The star currently mouse on

                // Now highlight all the stars that's not after the current hovered star
                $(this)
                    .parent()
                    .children("li.star")
                    .each(function (e) {
                        if (e < onStar) {
                            $(this).addClass("hover");
                        } else {
                            $(this).removeClass("hover");
                        }
                    });
            })
            .on("mouseout", function () {
                $(this)
                    .parent()
                    .children("li.star")
                    .each(function (e) {
                        $(this).removeClass("hover");
                    });
            });

        /* 2. Action to perform on click */
        $(document).on("click", "#stars li", function () {
            var onStar = parseInt($(this).data("value"), 10); // The star currently selected
            var stars = $(this).parent().children("li.star");

            for (let i = 0; i < stars.length; i++) {
                $(stars[i]).removeClass("selected");
            }

            for (let i = 0; i < onStar; i++) {
                $(stars[i]).addClass("selected");
            }

            ratingValue = $(this).attr('data-value')
            rateClickEnable = true;
        });
    });

    function enableAddToCart(optionRealId) {
        let allOption = [];
        $.each($(".option_price"), function (i, v) {
            allOption[i] =
                typeof $(this).find(":selected").attr("data-optionRealId") !=
                "undefined"
                    ? $(this).find(":selected").attr("data-optionRealId")
                    : $(this).attr("data-optionRealId");
        });
        if (!jQuery.inArray(optionRealId, allOption)) {
            $("#item-add-to-cart").addClass("add-to-cart");
            $("#item-add-to-cart").removeClass("disable_a_href");
        }
    }

    function disableAddToCart() {
        $("#item-add-to-cart").removeClass("add-to-cart");
        $("#item-add-to-cart").addClass("disable_a_href");
    }

    function removeArrayElement(type, itemId) {
        if (type == "relate") {
            delete preVDuplicateRelate[itemId];
        } else if (type == "cross") {
            delete preVDuplicateCross[itemId];
        } else if (type == "up") {
            delete preVDuplicateUp[itemId];
        }
    }

    $(document).on("click", ".image-thumbnail", function () {
        var src = $(this).data("src");

        $(".preview-image img").attr("src", src);
        $(".preview-body").show();

        var preview = $(".preview-body");
        $(".preview-body").remove();
        $("body").append(preview);
        $(".preview-body").animate({ opacity: "1" }, "slow");
    });

    $(document).on("click", ".preview-image span", function () {
        $(".preview-body").animate({ opacity: "0" }, "slow");
        setTimeout(() => {
            $(".preview-body").hide();
        }, 1000);
    });

    var gImgObj = [];
    var j = 0,
        k = 0,
        deletedFiles = [];
    $(document).on("change", "#image", function (e) {
        var parent = this;
        if (!validate()) {
            $("#message").show(200);
            $("#message").html(
                '<span class="font-bold text-red-600">' +
                    jsLang("Please upload valid images") +
                    "</span>"
            );
            $("#image").val("");
            $(".error").remove();
            return 0;
        } else if (validate() == 2) {
            $("#message").show(200);
            $("#message").html(
                '<span class="font-bold text-red-600">' +
                    jsLang("Maximum file size 2MB") +
                    "</span>"
            );
            $("#image").val("");
            $(".error").remove();
            return 0;
        } else {
            $("#message").hide(200);
        }
        $(".error").remove();
        var files = e.target.files,
            filesLength = files.length;
        for (var i = 0; i < filesLength; i++) {
            var f = files[i];
            gImgObj[k++] = f.name;
            var fileReader = new FileReader();
            fileReader.onload = function (e) {
                $(parent).closest('form').find("#imgs").append(`
                    <div class="pip error">
                        <div class="relative inline-block">
                            <img class="imageThumb object-cover h-24 w-24 border-2" src="${
                                e.target.result
                            }"/>
                            <span data-id="${j++}" class="removes absolute rounded-full bg-red-200 px-2 cursor-pointer -top-3 -right-3 text-bold text-red-700">x</span>
                        </div>
                    </div>
                `);
            };
            fileReader.readAsDataURL(f);
        }
    });

    $(document).on("click", ".removes", function () {
        Swal.fire({
            title: jsLang("Are you sure?"),
            text: jsLang("You won't be able to revert this!"),
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: jsLang("Yes, delete it!"),
        }).then((result) => {
            if (result.isConfirmed) {
                var pid = $(this).data("id");
                $(this).closest(".pip").remove();
                if (typeof pid !== "undefined") {
                    deletedFiles.push(gImgObj[pid]);
                    $("#deleted-files").val(deletedFiles);
                }
            }
        });
    });

    $("#view-more").css(
        "background",
        "linear-gradient(0deg, rgba(255,255,255,1) 0%, rgba(255,255,255,1) 65%, rgba(255,255,255,0) 100%)"
    );
    $(document).on("click", "#view-more span", function () {
        if ($(".item-full-details").find(".add").length) {
            $("#item-details-section")[0].scrollIntoView({
                behavior: "smooth",
                block: "start",
                inline: "nearest",
            });
            $(".item-full-details").addClass("h-full");
            $(".item-full-details").removeClass("h-96");
            $("#view-more").addClass("remove");
            $("#view-more svg").addClass("rotated-view");
            $("#view-more").removeClass("add");
            $("#hidden_description").removeClass("display-none");
            $("#view-more span").text(jsLang("See Less"));
            $('#hidden_summary').addClass('display-none');
        } else {
            $("#item-details-section")[0].scrollIntoView({
                behavior: "smooth",
                block: "start",
                inline: "nearest",
            });
            $(".item-full-details").removeClass("h-full");
            $(".item-full-details").addClass("h-96");
            $("#view-more").removeClass("remove");
            $("#view-more svg").removeClass("rotated-view");
            $("#view-more").addClass("add");
            $("#hidden_description").addClass("display-none");
            $("#view-more span").text(jsLang("See More"));
            $('#hidden_summary').removeClass('display-none');
            setTimeout(() => {
                $(document).scrollTop($(document).scrollTop() - 100);
            }, 1000);
        }
    });

    $(".rating-width").each((index, item) => {
        $(item).css("width", $(item).data("width") + "%");
    });

    $("span span.text-gray-500").css("background", "#eee");

    function fetch_data(page) {
        var _token = token;
        var url = reviewUrl+'?page='+page;
        var item_id = itemId;
        $.ajax({
            url: url,
            method: "POST",
            data: { _token: _token, page: page, product_id: item_id },
            success: function (data) {
                $("#load_review").html(data);
                $("span span.text-gray-500").css("background", "#eee");
            },
        });
        return 1;
    }

    function validate() {
        var uploadImg = document.getElementById("image");
        for (var i = 0; i < uploadImg.files.length; i++) {
            var f = uploadImg.files[i];
            if (!allowExtension.includes(f.name.split(".").pop())) {
                return false;
            }
            if (f.size > 2048000) {
                return 2;
            }
        }
        return true;
    }

    $("#reviewFrom").on("submit", function (event) {
        event.preventDefault();
        let rate = ratingValue;
        if (rate == 0 && rattingRequired == 1) {
            $("#message")
                .show(500)
                .html(
                    '<span class="font-bold text-red-600">' +
                        jsLang("Rating field is required") +
                        "</span>"
                );
        } else if ($("#imgs").find(".pip").length > 15) {
            $("#message").show(200);
            $("#message").html(
                '<span class="font-bold text-red-600">' +
                    jsLang("You can only upload a maximum of 15 files.") +
                    "</span>"
            );
            return 0;
        } else {
            $('.save-review').addClass('flex').html(`
                ${jsLang('Submitting')}
                <svg class="animate-spin text-gray-700 w-4 h-4 ml-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="#ddd" stroke-width="3"></circle>
                    <path class="opacity-75" fill="#fff" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
            `)

            let comments = $("#comments").val();
            var formData = new FormData(this);
            formData.append("rating", rate);
            formData.append("comments", comments);
            formData.append("product_id", itemId);
            $.ajax({
                url: SITE_URL + "/user/review-store",
                type: "POST",
                dataType: "JSON",
                data: formData,
                contentType: false,
                cache: false,
                processData: false,
                success: function (data) {
                    if (data.status == 1) {
                        setTimeout(() => {
                            $(".review-store-section").hide(500);
                            fetch_data(1);
                        }, 3000);

                        $("#imgs").html("");
                        $("#message").show(200);
                        $("#message").html(
                            '<span class="font-bold text-green-600">' +
                                jsLang(data.message) +
                                "</span>"
                        );
                        $("#comments").val(null);
                        $(".star").removeClass("selected");
                        deletedFiles = [];
                        gImgObj = [];
                        j = 0;
                        k = 0;
                    } else {
                        $("#message").show(200);
                        $("#message").html(
                            '<span class="font-bold text-red-600">' +
                                jsLang(data.message) +
                                "</span>"
                        );
                    }
                },
                error: function (xhr, ajaxOptions, thrownError) {
                    if (xhr.status == 401) {
                        $("#message").show(200);
                        $("#message").html(
                            '<span class="font-bold text-red-600">' +
                                jsLang(
                                    "To give a review, you need to login first."
                                ) +
                                "</span>"
                        );
                    } else {
                        $("#message").show(200);
                        $("#message").html(
                            '<span class="font-bold text-red-600">' +
                                jsLang(thrownError) +
                                "</span>"
                        );
                    }
                },
                complete: function() {
                    $('.save-review').removeClass('flex').html(`
                        ${jsLang('Submit Reveiw')}
                    `)
                }
            });
        }
        setTimeout(() => {
            $("#message").hide(500);
        }, 5000);
    });

    var ratingUpdate = null;
    $(document).on("click", "#stars li", function () {
        ratingUpdate = true;
    });

    $(document).on("submit", "#reviewUpdateFrom", function (e) {
        e.preventDefault();
        var form = this;
        if ($("#imgs").find(".pip").length > 15) {
            $("#message").show(200);
            $("#message").html(
                '<span class="font-bold text-red-600">' +
                jsLang("You can only upload a maximum of 15 files.") +
                "</span>"
            );
            return 0;
        } else {
            var formData = new FormData(this);

            $('.review-submit-modal-btn').html(`
                ${jsLang('Submitting')}
                <svg class="animate-spin text-gray-700 w-4 h-4 ml-1 mt-1" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="#000" stroke-width="3"></circle>
                    <path class="opacity-75" fill="#fff" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
            `)
            if (ratingUpdate) {
                formData.append("rating", ratingValue);
            }
            $.ajax({
                url: SITE_URL + "/site/review/update",
                type: "POST",
                dataType: "JSON",
                data: formData,
                contentType: false,
                cache: false,
                processData: false,
                success: function (data) {
                    if (data.status == 1) {
                        deletedFiles = [];
                        gImgObj = [];
                        j = 0;
                        k = 0;
                        var page_no = Number(
                            $(
                                "span.relative.inline-flex.items-center.px-4.py-2.-ml-px"
                            ).text()
                        );

                        if (fetch_data(1000)) {
                            fetch_data(page_no);
                        }

                        $("#imgs").hide();
                        $("#message").show(200);
                        $("#message").html(
                            '<span class="font-bold text-green-600">' +
                                jsLang(data.message) +
                                "</span>"
                        );
                        setTimeout(() => {
                            fetch_data(
                                $(
                                    "span.relative.inline-flex.items-center.px-4.py-2.-ml-px"
                                ).text()
                            );
                            $("#message").hide();
                            $("#imgs").show();
                            $(form).find('.review-close-modal-btn').trigger('click');
                        }, 2500);
                    } else {
                        $("#message").show(200);
                        $("#message").html(
                            '<span class="font-bold text-red-600">' +
                                jsLang(data.message) +
                                "</span>"
                        );
                    }
                },
                error: function (xhr, ajaxOptions, thrownError) {
                    if (xhr.status == 401) {
                        $("#message").show(200);
                        $("#message").html(
                            '<span class="font-bold text-red-600">' +
                                jsLang(
                                    "To give a review, you need to login first."
                                ) +
                                "</span>"
                        );
                    } else {
                        $("#message").show(200);
                        $("#message").html(
                            '<span class="font-bold text-red-600">' +
                                jsLang(thrownError) +
                                "</span>"
                        );
                    }
                },
                complete: function() {
                    $('.review-submit-modal-btn').html(`
                        ${jsLang('Submit')}
                    `)
                }
            });
        }
    });

    $(document).on("click", ".remove-review-image", function () {
        var file = $(this).data("path");
        var image = $(this);
        var key = $(this).data("key");

        Swal.fire({
            title: jsLang("Are you sure?"),
            text: jsLang("You won't be able to revert this!"),
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#2c2c2c",
            cancelButtonColor: "#d33",
            confirmButtonText: jsLang("Yes, delete it!"),
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: SITE_URL + "/site/review/destroy",
                    data: { path: file, _token: token },
                    type: "POST",
                    dataType: "JSON",
                    success: function (data) {
                        image.closest(".pip").remove();
                        $("body #review-image-" + key).closest('div').hide();
                    },
                });
            }
        });
    });

    $(document).on("click", ".filter", function () {
        $(".filter-value").text($(this).text());
        let star = $(this).data("star");
        let item_id = $(this).data("item");
        $(".filter-value").data('filter-star', star);
        $(".filter").children().removeClass("primary-text-color");
        $(".filter span.text-md").addClass("ml-3");
        $(".filter span.text-md").text("");
        $(this).prepend(`<span class="primary-text-color -mr-3 text-md">✓</span>`);
        $(this).children().addClass("primary-text-color");

        blockElement($("#load_review"));
        fetchReview(star, item_id);
    });

    $("#rating").click(function () {
        $("#load_review")[0].scrollIntoView({
            behavior: "smooth",
            block: "end",
            inline: "nearest",
        });
    });

    $("#clear-variation").click(function () {
        removeAllhidden(true);
        $("#clear-variation").addClass("display-none");
        $("#stock_qty").addClass("display-none");
        $("#item_offer_price").addClass("display-none");
        $("#item_price").addClass("display-none");
        $("#countDown").addClass("display-none");
        $('#varMinMaxPrice').removeClass("display-none");
        $('#b2b_table').html('');
        variationImage("", "default");
        variationId = null;
        variationAttributeIds = [];
    });

    $(document).on("change", ".item-variations", function (event) {
        if ($(this).val().length != 0) {
            getPossibleId(
                $("option:selected", this).attr("data-id"),
                $("option:selected", this).attr("data-position")
            );
        } else {
            removeAllhidden();
        }
        getVariationIds();
        attributePrice();
        if (checkOneSelected() == true) {
            $("#clear-variation").removeClass("display-none");
        } else {
            $("#clear-variation").addClass("display-none");
        }
    });

    function defaultSelect()
    {
        $.each($('.item-variations option'), function () {
            if((this.selected)) {
                if ($(this).val().length != 0) {
                    getPossibleId($('option:selected', this).attr('data-id'), $('option:selected', this).attr('data-position'));
                } else {
                    removeAllhidden();
                }
                getVariationIds();
                attributePrice();
                if (checkOneSelected() == true) {
                    $('#clear-variation').removeClass('display-none');
                } else {
                    $('#clear-variation').addClass('display-none');
                }
            }
        })
    }

    function attributePrice() {
        let parseAttributePriceWithId;
        let flag = true;
        parseAttributePriceWithId = JSON.parse(attributePriceWithId);
        $.each(parseAttributePriceWithId, function (i, v) {
            if (getPossbileAttributeWithPrice(v.attributeIds)) {
                flag = false;
                selectedIds = [];
                $("#availability").addClass("display-none");
                $("#item_price").removeClass("display-none");
                $("#item_price").text(decimalNumberFormatWithCurrency(v.price));
                $('#varMinMaxPrice').addClass("display-none");
                variationId = v.variation_id;
                variationAttributeIds = v.attributeIds;
                backOrders = v.backOrders;
                if (v.priceType == "sale") {
                    discountInPercent = v.discountInPercent;
                    offerFlag = true;
                } else {
                    offerFlag = false;
                }
                outOfStockVisible = v.isOutOfStock['outOfStockVisibility'];
                variationImage(v.images);

                if (v.is_enable_b2b == "1") {
                    $('#b2b_table').html('');
                    showB2BData(v.b2b_data);
                } else {
                    $('#b2b_table').html('');
                }

                let weight = "";
                let dimension = "";
                if (v.weight != "") {
                    weight = `<tr id="weightRow">
                    <td class="py-4 px-6 border">${jsLang('Weight')}</td>
                    <td class="py-4 px-6 border">${v.weight} ${messurementWeight}</td>
                      </tr>`
                    $('#weightRow').replaceWith(weight);
                }

                if (
                    v.dimensions["length"] != "" ||
                    v.dimensions["width"] != "" ||
                    v.dimensions["height"] != ""
                ) {
                    dimension = `
                    <tr id="dimensionsRow">
                        <td class="py-4 px-6 border">${jsLang('Dimensions')}</td>
                        <td class="py-4 px-6 border">${ v.dimensions['length'] != '' ? v.dimensions['length'] : null } ${ v.dimensions['width'] != '' ? "× " + v.dimensions['width']  : '' }
                          ${ v.dimensions['height'] != '' ? "× " + v.dimensions['height'] : '' } ${messurementDimension}</td>
                    </tr>
                    `;
                    $("#dimensionsRow").replaceWith(dimension);
                }
                if (v.manage_stocks == 1 && stockHide == 0 && parseInt(v.stock_quantity) >= 0 ) {
                    $('#stock_qty').removeClass("display-none");
                    if (stockDisplayFormat == 'always_show') {
                        var message = jsLang(":x items remaining");
                        message = message.replace(':x' , v.stock_quantity);
                        $('#stock_qty').html("<span class='text-green-1 capitalize leading-4 bg-green-2 px-4 py-2 text-sm roboto-medium font-medium rounded mr-2.5 rtl-direction-space-left'>" + jsLang('In Stock') + "</span>" + message);
                    } else if (stockDisplayFormat == 'sometime_show' && parseInt(v.stock_quantity) <= parseInt(v.lowStockThreshold) && parseInt(v.stock_quantity) != 0) {
                        var msg = jsLang('Only :x left in stock');
                        msg = msg.replace(':x', v.stock_quantity);
                            $('#stock_qty').text(msg);
                    }
                } else if (v.manage_stocks == 1 && stockHide == 0 && parseInt(v.stock_quantity) <= 0 && backOrders == 0) {
                    $('#stock_qty').removeClass("display-none");
                    if (stockDisplayFormat == 'always_show' || stockDisplayFormat == 'sometime_show') {
                        $('#stock_qty').html('<span class="text-reds-3 leading-4 bg-pinks-2 px-4 py-2 text-sm roboto-medium font-medium rounded capitalize">' + jsLang("Out Of Stock") + '</span>');
                    }
                } else {
                    $("#stock_qty").addClass("display-none");
                }
                if (v.priceType == "sale") {
                    $("#item_offer_price").text(
                        decimalNumberFormatWithCurrency(v.regular)
                    );
                    $("#item_offer_price").removeClass("display-none");
                    getCountDown(v.saleTo, true);
                } else {
                    $("#item_offer_price").addClass("display-none");
                    $("#countDown").addClass("display-none");
                }
                return false;
            }
        });
        if (flag == true) {
            variationId = null;
            variationAttributeIds = [];
            outOfStockVisible = 0;
            $("#item_offer_price").addClass("display-none");
            $("#item_price").addClass("display-none");
            $("#stock_qty").addClass("display-none");
            $('#varMinMaxPrice').removeClass("display-none");
            checkAllSelected() == true
                ? $("#availability").removeClass("display-none")
                : "";
            variationImage(null, "default");
        }
    }

    function showB2BData(b2bData)
    {
        let b2bRow = ``;
        $.each(b2bData, function (i,b2b){
            if (b2b['min_qty'] && b2b['max_qty'] && b2b['price']) {
                b2bRow += `<tr class="py-4 px-6 border b2b_table">
                        <td class="py-4 px-6 border">${ b2b['min_qty'] }</td>
                        <td class="py-4 px-6 border">${ b2b['max_qty'] }</td>
                        <td class="py-4 px-6 border">${ b2b['price'] }</td>
                    </tr>`;
            }
         });

        let b2bTable = `<table class="text-left w-full border-collapse border text-sm md:text-13 mt-10p" id="b2b-table">
                            <tbody class="text-gray-10 roboto-medium">
                              <th class="py-4 px-6 border">${ jsLang('Min Qty') }</th>
                              <th class="py-4 px-6 border">${ jsLang('Max Qty') }</th>
                              <th class="py-4 px-6 border">${ b2bData.length == 1 ? jsLang('B2B price') : jsLang('B2B prices') }</th>
                              ${b2bRow}
                            </tbody>
                          </table>`;

        $('#b2b_table').append(b2bTable);
        hasB2BData();
    }

    function hasB2BData()
    {
        $("#b2b-table").removeClass('display-none');
        if (typeof $(".b2b_table").length != 'undefined') {
            if ($(".b2b_table").length == 0) {
                $("#b2b-table").addClass('display-none');
            }
        } else if (typeof $(".b2b_table").length == 'undefined') {
            $("#b2b-table").addClass('display-none');
        }
    }

    function checkAllSelected() {
        let flag = true;
        $(".item-variations").each(function (i, v) {
            if ($(this).val().length != 0) {
                flag != false ? (flag = true) : "";
            } else {
                flag = false;
            }
        });
        return flag;
    }
    function checkOneSelected() {
        let flag = false;
        $(".item-variations").each(function (i, v) {
            if ($(this).val().length != 0) {
                flag = true;
            }
        });
        return flag;
    }

    function getPossibleId(value, position) {
        let selectableId = possbileVariations[value];
        if (typeof actualArray != 'undefined' && actualArray.length == 0) {
            actualArray = selectableId;
        }

        $(".item-variations option").each(function (i, v) {
            if (!$(this).is(":selected") && $(this).val().length != 0) {
                if (
                    jQuery.inArray($(this).attr("data-id"), actualArray) != -1
                ) {
                    $(this).removeClass("display-none");
                } else {
                    if ($(this).attr("data-position") == 1) {
                        checkPosition($(this).attr("data-position")) == false
                            ? $(this).addClass("display-none")
                            : "";
                    } else {
                        $(this).addClass("display-none");
                    }
                }
            }
        });
    }

    function checkPosition(position) {
        let flag = true;
        if (position == 1) {
            $(".item-variations option").each(function (i, v) {
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

    function removeAllhidden(isAll = false) {
        let flag = true;
        $(".item-variations").each(function (i, v) {
            if ($(this).val().length == 0) {
                flag != false ? (flag = true) : "";
            } else {
                flag = isAll;
            }
        });
        if (flag == true) {
            actualArray = [];
            $(".item-variations option").each(function (i, v) {
                $(this).removeClass("display-none");
            });
            if (isAll == true) {
                $(".item-variations").each(function (i, v) {
                    $(this).val("");
                });
            }
        }
    }

    function variationImage(images, action = "variation") {
        let sliderImage = ``;
        let zoomImage = ``;
        let cnt = 0;
        let featuredHtml = ``;
        let reviewAvgHtml = ``;
        let discountHtml = ``;
        let outOfStock = ``;
        if (parseInt(outOfStockVisible) == 1) {
            outOfStock = `<p class="bg-pinks-2 relative z-10 h-4 text-reds-3 mb-2.5 px-1.5 w-max flex items-center rounded-sm leading-3 roboto-medium font-medium pt-2p text-11 whitespace-nowrap">
                            ${jsLang('Stock Out')}
                         </p>`;
        }
        if (parseInt(featured) == 1 && parseInt(outOfStockVisible) == 0) {
            featuredHtml = `<p class="primary-bg-color h-5 w-max mb-2.5 justify-center text-white px-2 flex items-center text-center rounded-sm leading-3 roboto-medium font-medium text-11">${jsLang(
                "Featured"
            )}</p>`;
        }
        if (parseInt(reviewAvg) == 5 && parseInt(outOfStockVisible) == 0) {
            reviewAvgHtml = `<div class="flex justify-center items-center px-1.5 whitespace-nowrap my-2.5 bg-green-5 h-5 leading-3 roboto-medium font-medium text-white text-11 rounded-sm w-max">
                                <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 12 12" fill="none">
                                    <path d="M5 0L6.12257 3.45492H9.75528L6.81636 5.59017L7.93893 9.04508L5 6.90983L2.06107 9.04508L3.18364 5.59017L0.244718 3.45492H3.87743L5 0Z" fill="white"/>
                                </svg>
                                <p>${jsLang("Top Rated")}</p>
                            </div>`;
        }
        if (offerFlag == true && parseInt(outOfStockVisible) == 0) {
            discountHtml = `<p class="primary-bg-color h-5 text-gray-12 px-2 justify-center flex items-center rounded-sm leading-3 roboto-medium font-medium text-11 whitespace-nowrap w-max uppercase">${discountInPercent}% ${jsLang(
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
                      <div class="relative">
                        <div class="absolute z-10 left-3.5 top-3.5">
                           ${outOfStock}
                           ${featuredHtml}
                           ${reviewAvgHtml}
                           ${discountHtml}
                        </div>
                    </div>
                     <div class="swiper-slide minimum-height neg-transition-scale w-full zoom" style="background-image: url(${images})">
                        <img class="swiper-slide-img neg-transition-scale" src="${images}" alt="...">
                      </div>
                `;
            $("#zoomImage").html(zoomImage);
            $("#sliderImage").html(sliderImage);
        }  else if (action == "default") {
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
                     <div class="relative">
                        <div class="absolute z-10 left-3.5 top-3.5">
                           ${featuredHtml}
                           ${reviewAvgHtml}
                           ${discountHtml}
                        </div>
                    </div>
                     <div class="swiper-slide  minimum-height w-full ${isImg ? 'zoom' : ''} neg-transition-scale" style="background-image: url(${v})">
                        ${src}
                      </div>
                `;
            });
            $("#zoomImage").html(zoomImage);
            $("#sliderImage").html(sliderImage);
        }
        slideCounts = cnt;

        setTimeout(() => {
            $(".product-thumbs").css("opacity", "1");
        }, 5);

        var galleryThumbs = new Swiper(".gallery-thumbs", {
            spaceBetween: 20,
            slidesPerView: 4,
            freeMode: true,
            watchSlidesVisibility: true,
            watchSlidesProgress: true,
            preloadImages: false,
            breakpoints: {
                1152: {
                    slidesPerView: 5,
                    spaceBetween: 20,
                },
            },
        });

        var swiper = new Swiper(".swiper-container-main", {
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

    function getVariationIds() {
        let cnt = 0;
        $(".item-variations option").each(function (i, v) {
            if ($(this).is(":selected") && $(this).val().length != 0) {
                selectedIds[cnt++] = $(this).attr("data-id");
            }
        });
    }

    function getPossbileAttributeWithPrice(attributeIds) {
        let flag = true;
        $.each(attributeIds, function (i, v) {
            if (jQuery.inArray(v, selectedIds) != -1) {
                if (flag != false) {
                    flag = true;
                }
            } else {
                flag = false;
                updateProductPrice(defaultPrice, null);
            }
        });
        if (flag) {
            return flag;
        }
    }

    function updateProductPrice(price, action = "variation") {
        if (action == "variation") {
            $("#item_price").text(decimalNumberFormatWithCurrency(price));
        } else {
            $("#item_price").text(price);
        }
    }

    function getCountDown(saleDate, isActive) {
        clearInterval(offerTimerDetailsPage);
        if (isActive == true) {
            let isValid = false;
            var countDownDate = new Date(saleDate).getTime();

            // Update the count down every 1 second
            offerTimerDetailsPage = setInterval(function () {
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
                if (days >= 0 && $("#count_days").length > 0 && $("#count_others").length > 0) {
                    isValid = true;
                    document.getElementById("count_days").innerHTML =
                        days + jsLang("Days");
                    document.getElementById("count_others").innerHTML =
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
                    $("#countDown").removeClass("display-none");
                } else {
                    $("#countDown").addClass("display-none");
                }
            }, 1000);
        }
    }
}

//* description-review tab
function Tabs(options, active = 0) {
    var tabs = document.querySelector(options.el);
    var initCalled = false;
    var tabNavigation = tabs.querySelector(".c-tabs-nav");
    var tabNavigationLinks = tabs.querySelectorAll(".c-tabs-nav__link");
    var tabContentContainers = tabs.querySelectorAll(".c-tab");
    var marker = options.marker ? createNavMarker() : false;
    var activeIndex = active;

    function init() {
        if (!initCalled) {
            initCalled = true;

            for (var i = 0; i < tabNavigationLinks.length; i++) {
                var link = tabNavigationLinks[i];
                clickHandlerSetup(link, i);
            }

            if (marker) {
                setMarker(tabNavigationLinks[activeIndex]);
            }
        }
    }

    function clickHandlerSetup(link, index) {
        link.addEventListener("click", function (e) {
            e.preventDefault();
            goToTab(index);
        });
    }

    function goToTab(index) {
        if (
            index >= 0 &&
            index != activeIndex &&
            index <= tabNavigationLinks.length
        ) {
            tabNavigationLinks[activeIndex].classList.remove("is-active");
            tabNavigationLinks[index].classList.add("is-active");

            tabContentContainers[activeIndex].classList.remove("is-active");
            tabContentContainers[index].classList.add("is-active");

            if (marker) {
                setMarker(tabNavigationLinks[index]);
            }

            activeIndex = index;
        }
    }

    function createNavMarker() {
        var marker = document.createElement("div");
        marker.classList.add("c-tab-nav-marker");
        tabNavigation.appendChild(marker);
        return marker;
    }

    function setMarker(element) {
        if (initialTab != -1) {
            marker.style.left = element.offsetLeft + "px";
            marker.style.width = element.offsetWidth + "px";
        }
    }

    return {
        init: init,
        goToTab: goToTab,
    };
}
initialTab = parseInt(initialTab);
var m = new Tabs({
    el: "#tabs",
    marker: true,
});

m.init();
tabCssChange(initialTab);

function tabCssChange(initialTab) {
    if (initialTab == 1) {
        $("#product-specification").addClass("is-active");
        $("#product-specification-panel").addClass("is-active");
    } else if (initialTab == 2) {
        $("#product-description").removeClass("is-active");
        $("#product-description-panel").removeClass("is-active");
        $("#product-vendor-info").addClass("is-active");
        $("#product-vendor-info-panel").addClass("is-active");
    } else if (initialTab == 3) {
        $("#product-description").removeClass("is-active");
        $("#product-description-panel").removeClass("is-active");
        $("#product-review").addClass("is-active");
        $("#product-review-panel").addClass("is-active");
    } else if (initialTab == -1) {
        $("#nav-line").removeClass("c-tabs-nav");
    }
}

$("#rating").click(function () {
    let n = new Tabs(
        {
            el: "#tabs",
            marker: true,
        },
        ratingTab
    );
    n.init();
    $("#product-description").removeClass("is-active");
    $("#product-description-panel").removeClass("is-active");
    $("#product-specification").removeClass("is-active");
    $("#product-specification-panel").removeClass("is-active");
    $("#product-vendor-info").removeClass("is-active");
    $("#product-vendor-info-panel").removeClass("is-active");
    $("#product-review").addClass("is-active");
    $("#product-review-panel").addClass("is-active");
    let cnt = 0;
    $.each($(".c-tab-nav-marker"), function () {
        if (cnt == 0) {
            $(this).remove();
        }
        cnt++;
    });
    $("html, body").animate(
        {
            scrollTop: $("#product-review-panel").offset().top,
        },
        1000
    );
});

// *product slider and zoom*
setTimeout(() => {
    $(".product-thumbs").css("opacity", "1");
}, 5);

var galleryThumbs = new Swiper(".gallery-thumbs", {
    spaceBetween: 20,
    slidesPerView: 4,
    freeMode: true,
    watchSlidesVisibility: true,
    watchSlidesProgress: true,
    preloadImages: false,
    breakpoints: {
        1152: {
            slidesPerView: 5,
            spaceBetween: 20,
        },
    },
});

var swiper = new Swiper(".swiper-container-main", {
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
// end product slider and zoom

$(document).on("click", "a.review", function () {
    $("a").removeClass("is-acive");
    $(this).addClass("is-active");
    $("div.c-tab").removeClass("is-active");
    $("div.c-tab.review").addClass("is-active");
    $(document).scrollTop($("#item-details-section").offset().top - 100);
});
if ("{!! request('reviewRequired') !== null ? true : false !!}") {
    $("a.review").trigger("click");
}

/* when modal is opened */
$(document).on("click", "#review-open-modal-btn", function () {
    $("body").css("overflow", "hidden");
    var edit_modal = $(".edit-modal");
    $(".edit-modal").remove();
    $("body").append(edit_modal);
});

/* when modal is closed */
$(document).on(
    "click",
    ".review-close-modal-btn, .review-submit-modal-btn",
    function () {
        $("body").css("overflow", "visible");
    }
);

/* review pagination */

$(document).on('click', '#review-paginate a', function(e) {
    e.preventDefault();
    blockElement($("#load_review"));

    fetchReview($(".filter-value").data("filter-star"),$(".filter-value").data("item"),$(this).attr('href').split('page=')[1])
});

function fetchReview(star = 0, item_id = 1 , page = 1) {
    $.ajax({
        url: SITE_URL + "/site/review/filter?page="+page,
        data: { rating: star, product_id: item_id, _token: token },
        type: "POST",
        success: function (data) {
            $("#load_review").html(data);
        },
        complete: function(data) {
            unblockEverything();
        }
    });
}

const unblockEverything = () => {
    $(".blockUI").each(function () {
        $(this).parent().unblock();
    });
};

const blockElement = (element, _data = {}) => {
    let options = Object.assign(
        {},
        {
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
        },
        _data
    );
    element.block(options);
};
