"use strict";
if ($('.main-body .page-wrapper').find('#item-filter-container-mobile').length || $('.main-body .page-wrapper').find('#item-filter-container-desktop').length) {
    var categorySelected = false
    var searchKeyword = null;
    var categoryData = null;
    var brandData = '';
    var url = new URL(window.location.href);
    var sortBy = "Price Low to High";
    const defaultShowing = 12;
    var showing = defaultShowing;
    var rating = '';
    var min = null;
    var max = null;
    var filterBox = null;
    var scrollDiv = 'filter_box';
    var onceCount = true;
    var dummyDataOnce = true;
    var loaderHeight = 1538;
    var keyWordChange = '';
    var brandClick = false, ratingClick = false, attributesClick = false, priceRangeClick = false, categoryClick = false, sortByClick = false, showingClick = false, b2bClick = false;
    var related_ids = '';

    setDefaultData();
    getFilterData();
    $(document).on('click', '.selected-category', function() {
        if ($(this).hasClass("text-color-black")) {
            $(this).removeClass('text-color-black');
        } else {
            $(this).addClass('text-color-black');
            $('.selected-category').closest(".show-details").removeClass("h-64").find(".expand-more").hide();
            categorySelected = true

        }
        categoryClick = true;
        getFilterData();
    });

    $(document).on('keyup', '#itemSearch', function() {
        let urlSearch = window.location.search;
        if (urlSearch.indexOf("keyword=") >= 0) {
            const replacement = "keyword="+encodeURIComponent($(this).val());
            const regex = /keyword=(.*?)(?=&|$)/g;
            const result = urlSearch.replace(regex, replacement);
            window.history.replaceState(null, null, result);
        } else {
            const resultAdd = urlSearch += "keyword="+encodeURIComponent($(this).val());
            window.history.replaceState(null, null, resultAdd);
        }
        keyWordChange = encodeURIComponent($(this).val());
    });

    $(document).on('click', '.button-update', function(event) {
        event.preventDefault();
        let priceRange = [];
        if (typeof $('#price_minimum').val() != 'undefined' && $('#price_minimum').val() != '') {
            priceRange.push($('#price_minimum').val());
        } else if(typeof $('#price_maximum').val() != 'undefined' && $('#price_maximum').val() != '') {
            priceRange.push(0);
        }
        if (typeof $('#price_maximum').val() != 'undefined' && $('#price_maximum').val() != '') {
            priceRange.push($('#price_maximum').val());
        }
        priceRangeClick = true;
        getFilterData(null, priceRange);
    });
    $(document).on('click', '.option-checkbox', function(el) {
        let oldId = $(this).attr('id');
        let oldOption = $(this).attr('data-option');
        $('#filter_box > .option-checkbox').each(function () {
            let newId = $(this).attr('id');
            $('#'+newId).prop('checked', false);
        });
        $('#filter_box_result .option-checkbox').each(function () {
            let newId = $(this).attr('id');
            let newOption = $(this).attr('data-option');
            if (oldId != newId && oldOption == newOption) {
                $('#'+newId).prop('checked', false);
            }
        });
        attributesClick = true;
        getFilterData();
    });
    $(document).on('click', '.item-brand', function() {
        brandClick = true;
        getFilterData();
    });
    $(document).on('click', '.b2b-checkbox', function() {
        b2bClick = true;
        getFilterData();
    });
    $(document).on('click', '.item-ratings', function() {
        rating = $(this).attr('data-rating');
        $('#rating_star').remove();
        ratingClick = true;
        getFilterData();
    });
    $(document).on('click', '.sort_by', function(event) {
        sortBy = $(this).attr('id');
        sortByClick = true;
        getFilterData();
        $('.sort_by').removeClass('primary-bg-color text-gray-12')
        $('.sort_by span.text-md').addClass('ml-3');
        $('.sort_by span.text-md').text('');
        $(this).addClass('primary-bg-color text-gray-12');
        $('.animation_showing').html(showing);
        $('.animation_sort_by').html(sortBy);
    });

    $(document).on('click', '.price_range', function() {
        min = $(this).attr('data-min');
        max = $(this).attr('data-max');

        getFilterData(null, [min,max]);
    });

    $(document).on('change', '.min_desktop', function() {
        min = $('.min_desktop').val();
    });

    $(document).on('change', '.max_desktop', function() {
        max = $('.max_desktop').val();
    });

    $(document).on('click', '.reset_all', function() {
        searchKeyword = typeof url.searchParams.get("keyword") != "undefined" && url.searchParams.get("keyword") != null ? url.searchParams.get("keyword") : null;
        categoryData = typeof url.searchParams.get("categories") != "undefined" && url.searchParams.get("categories") != null ? url.searchParams.get("categories") : null;
        brandData = typeof url.searchParams.get("brands") != "undefined" && url.searchParams.get("brands") != null ? url.searchParams.get("brands") : null;
         sortBy = "Price Low to High";
         showing = defaultShowing;
         rating = '';
         brandClick = true, ratingClick = true, attributesClick = true, priceRangeClick = true, categoryClick = true, sortByClick = true, showingClick = true, b2bClick = true;
         ajaxCall("/api/user/products", 1, "reset");
    });

    $(document).on('click', '.Showing', function(event) {
        showing = $(this).attr('id');
        showingClick = true;
        getFilterData();
        $('.Showing').removeClass('primary-bg-color text-gray-12')
        $('.Showing span.text-md').addClass('');
        $('.Showing span.text-md').text('');
        $(this).addClass('primary-bg-color text-gray-12');
        $('.animation_showing').html(showing);
        $('.animation_sort_by').html(sortBy);
    });

    $(document).on('click', '.pagintion', function(event) {
        start = $(this).attr('data-start');
        let pageNumber = $(this).attr('data-pageNumber');

        getFilterData(null, [], pageNumber);
    });
    $(document).on('click', '.page-prev', function(event) {
        if (parseInt(start) - 1 >= 0) {
            let dataStrt = $('#pagination').find('.bg-green-500.text-white.color_switch_bac').attr('data-start');
            let page = $('#pagination').find('.bg-green-500.text-white.color_switch_bac').attr('data-pageNumber');
            page = parseInt(page) - 1;
            start = parseInt(dataStrt) - parseInt(totalProductPerPage);

            getFilterData(null, [], page);
        }
    });
    $(document).on('click', '.page-next', function(event) {
            let dataStrt = $('#pagination').find('.bg-green-500.text-white.color_switch_bac').attr('data-start');
            let page = $('#pagination').find('.bg-green-500.text-white.color_switch_bac').attr('data-pageNumber');
            page = parseInt(page) + 1;
            start = parseInt(dataStrt) + parseInt(totalProductPerPage);

            getFilterData(null, [], page);
    });

    function setDefaultData()
    {
        searchKeyword = typeof url.searchParams.get("keyword") != "undefined" && url.searchParams.get("keyword") != null ? url.searchParams.get("keyword") : null;
        categoryData = typeof url.searchParams.get("categories") != "undefined" && url.searchParams.get("categories") != null ? url.searchParams.get("categories") : null;
        brandData = typeof url.searchParams.get("brands") != "undefined" && url.searchParams.get("brands") != null ? url.searchParams.get("brands") : null;
    }

    function animationViewChange()
    {
        filterBox = $('#filter_box_result').html();
        $('#filter_box').html(filterBox);
    }

    function getFilterData(ReqRating = null, priceRange = [], page = 1)
    {
        let attributesVal = [];
        let brands = [];
        let b2b = '';
        let category = [];
        ReqRating = rating;
        let inc = 0;
        $('#filter_box_result').find('.option-checkbox').each(function() {
            let id = $(this).attr('id');
            if ($('#filter_box_result, #'+id).is(':checked')) {
                attributesVal[inc++] = $(this).val();
            }
            });
        brands = $('input[name="brands[]"]:checked').map(function(){return encodeURIComponent($(this).val());}).get();
        if($('input[name="b2b"]:checked').length > 0) {
            b2b = $('input[name="b2b"]:checked').val();
        }

        $.each($('.selected-category'), function () {
            if ($(this).hasClass('text-color-black')) {
                category.push(encodeURIComponent($(this).attr('data-category')));
            }
        });
        $.each($('.price_range'), function () {
            if ($(this).hasClass('text-color-black')) {
                $(this).attr('data-min') != '' ? priceRange.push($(this).attr('data-min')) : null;
                $(this).attr('data-max') != '' ? priceRange.push($(this).attr('data-max')) : null;
            }
        });

        brands = brands.join(",");
        category = category.join(",");
        attributesVal = attributesVal.join(";");
        priceRange.length != 0 ? priceRange = priceRange.join(",") : '';
        let params = '';
        let categoriesParam = typeof url.searchParams.get("categories") != "undefined" && url.searchParams.get("categories") != null ? url.searchParams.get("categories") : '';
        if (categoriesParam != '' && categoriesParam.length != 0 && categoryClick == false) {
            params+= "?categories="+encodeURIComponent(categoriesParam);
            $('#selectedCategory').val(categoriesParam);
        } else {
            if (category.length != 0) {
                params+= "?categories="+category;
            } else {
                let keyW = typeof url.searchParams.get("keyword") != "undefined" && url.searchParams.get("keyword") != null ? url.searchParams.get("keyword") : '';
                if (keyW == '' && related_ids.length == 0) {
                    params+= "?categories="+encodeURIComponent(categoriesParam);
                    $('#selectedCategory').val(category);
                } else if (related_ids.length == 0) {
                    params+= "?categories="+category;
                } else {
                    params+= "?categories=";
                }
            }
        }
        let keywordParam = typeof url.searchParams.get("keyword") != "undefined" && url.searchParams.get("keyword") != null ? url.searchParams.get("keyword") : '';
        if (keywordParam != '' && keyWordChange == '') {
            params+= "&keyword="+encodeURIComponent(keywordParam);
            $('#itemSearch').val(keywordParam);
        } else if (keyWordChange != '') {
            params+= "&keyword="+encodeURIComponent(keyWordChange);
        } else {
            params+= "&keyword=";
        }
        let brandsParam = typeof url.searchParams.get("brands") != "undefined" && url.searchParams.get("brands") != null ? url.searchParams.get("brands") : '';
        if (brandsParam != '' && brandsParam.length != 0 && brandClick == false) {
            params+= "&brands="+encodeURIComponent(brandsParam);
        } else {
            params+= "&brands="+brands;
        }
        if (parseInt(isActiveB2B) == 1) {
            let b2bParam = typeof url.searchParams.get("b2b") != "undefined" && url.searchParams.get("b2b") != null ? url.searchParams.get("b2b") : '';
            if (b2bParam != '' && b2bParam.length != 0 && b2bClick == false) {
                params+= "&b2b="+encodeURIComponent(b2bParam);
            } else {
                params+= "&b2b="+b2b;
            }
        }
        let attributesParam = typeof url.searchParams.get("attributes") != "undefined" && url.searchParams.get("attributes") != null ? url.searchParams.get("attributes") : '';
        if (attributesParam != '' && attributesParam.length != 0 && attributesClick == false) {
            params+= "&attributes="+attributesParam;
        } else {
            params+= "&attributes="+attributesVal;
        }
        let priceRangeParam = typeof url.searchParams.get("price_range") != "undefined" && url.searchParams.get("price_range") != null ? url.searchParams.get("price_range") : '';
        if (priceRangeParam != '' && priceRangeParam.length != 0 && priceRangeClick == false) {
            params+= "&price_range="+priceRangeParam;
        } else {
            params+= "&price_range="+priceRange;
        }

        related_ids = typeof url.searchParams.get("related_ids") != "undefined" && url.searchParams.get("related_ids") != null ? url.searchParams.get("related_ids") : '';
        if (related_ids != '' && related_ids.length != 0) {
            params+= "&related_ids="+encodeURIComponent(related_ids);
        }

        if (ratingClick == false) {
            rating = typeof url.searchParams.get("rating") != "undefined" && url.searchParams.get("rating") != null ? url.searchParams.get("rating") : '';
        }
        if (sortByClick == false) {
            sortBy = typeof url.searchParams.get("sort_by") != "undefined" && url.searchParams.get("sort_by") != null ? url.searchParams.get("sort_by") : 'Price Low to High';
        }
        if (showingClick == false) {
            showing = typeof url.searchParams.get("showing") != "undefined" && url.searchParams.get("showing") != null ? url.searchParams.get("showing") : defaultShowing;
        }

        setParams(params);
        ajaxCall("/api/user/products", page);
    }

    function setParams(params = null)
    {
        if (params != null) {
            window.history.replaceState(null, null, params+"&rating="+rating+"&sort_by="+sortBy+"&showing="+showing);
        } else {
            window.history.replaceState(null, null, "?rating="+rating+"&sort_by="+sortBy+"&showing="+showing);
        }
    }

    $(document).on('click', '.page-link', function(event) {
        event.preventDefault();
        var page = $(this).attr('href').split('page=')[1];
        let priceRange = [];

        if (priceRangeClick) {
            if (typeof $('#price_minimum').val() != 'undefined' && $('#price_minimum').val() != '') {
                priceRange.push($('#price_minimum').val());
            } else if(typeof $('#price_maximum').val() != 'undefined' && $('#price_maximum').val() != '') {
                priceRange.push(0);
            }
            if (typeof $('#price_maximum').val() != 'undefined' && $('#price_maximum').val() != '') {
                priceRange.push($('#price_maximum').val());
            }
        }

        getFilterData(null, priceRange, page);
    });

    function ajaxCall(url, page = 1, action = null)
    {
        if (action == 'reset') {
            if (searchKeyword != null && searchKeyword.length != 0) {
                setParams("?keyword="+encodeURIComponent(searchKeyword));
                $('#itemSearch').val(searchKeyword);
            } else if (categoryData != null && categoryData.length != 0 && related_ids.length == 0) {
                setParams("?categories="+encodeURIComponent(categoryData != null ? categoryData : ''));
                $('#itemSearch').val('');
            } else if (related_ids.length != 0) {
                setParams("?related_ids="+encodeURIComponent(related_ids));
                $('#itemSearch').val('');
            } else {
                setParams("?brands="+encodeURIComponent(brandData != null ? brandData : ''));
                $('#itemSearch').val('');
            }
        }
        let params = window.location.search.replace('?', '');
        $.ajax({
            url: SITE_URL + url,
            data: params+'&from=web&page='+page+'&user_id='+authUserId,
            method:"GET",
            beforeSend: function() {
                $(window).scrollTop(1);
                if (dummyDataOnce == true) {
                    dummyDataOnce = false;
                    $(".ajax-load").removeClass('display-none');
                }
                $('#res-loader-html').css("height", 1538);
                $('#res-loader-result').removeClass('display-none');
                $('.product-result').addClass('display-none');
            },
            success: function (data) {
               $('#loadHtml').html(data);
                if (onceCount == true) {
                    onceCount = false;
                    $('#found_total_item_animation').html($('#found_total_item').text());
                }
                categoryPath = JSON.parse(categoryPath);
                let path = ``;
                if (categoryPath != 'null' && categoryPath != null && categoryPath.length != 0) {
                    $('#search_result_path').addClass('display-none');
                    $('.all_categories_path').remove();
                    let pathLength = categoryPath.length;
                    pathLength = pathLength - 1;
                    $.each(categoryPath, function (i,v) {
                        if (pathLength == i) {
                            path += `<li class="flex items-center" id="all_categories_path">
                                        <a href="javascript:void(0)" class="text-gray-12">${v['name']}</a>
                                    </li>`;
                        } else {
                            path += `<li class="flex items-center all_categories_path">
                                        <a href="${SITE_URL+"/search-products?categories="+encodeURIComponent(v['name'])}">${v['name']}</a>
                                        <p class="px-2">/</p>
                                    </li>`;
                        }
                    });
                } else {
                    $('.all_categories_path').remove();
                    path = `<li class="flex items-center" id="all_categories_path">
                                    <a href="javascript:void(0)">${jsLang('All Categories')}</a>
                                    <p class="px-2">/</p>
                                </li>`;
                    $('#search_result_path').removeClass('display-none');
                }
                $('#all_categories_path').replaceWith(path);
            },
            complete: function() {
                $(".ajax-load").empty();
                $(".ajax-load").addClass('display-none');
                $('#res-loader-result').addClass('display-none');
                $('.product-result').removeClass('display-none');
                if(categorySelected){
                    $('.selected-category').closest(".show-details").removeClass("h-64 pb-10").find(".expand-more").hide();
                    categorySelected = false
                }
            }
        });
        return 1;
    }

    $(document).on("keyup", ".positive-int-number", function () {
        var number = $(this).val();
        $(this).val(number.replace(/[^0-9]/g, ""));
    });
}


$(document).on('click', '.expand-more', function () {

    var expandParent = $(this).closest(".show-details")
    if (expandParent.find(".expand-more.add").length) {

        curHeight = expandParent.height();
        autoHeight = expandParent.css('height', 'auto').height();
        expandParent.height(curHeight).animate({height: autoHeight}, 1000);
        expandParent.find(".expand-more").removeClass("add");
        expandParent.find(".expand-more span").text(jsLang("See Less"));
    } else {

        var expandParent = expandParent,
        curHeight = expandParent.height(),
        autoHeight = expandParent.css('height', '305').height();
        expandParent.height(curHeight).animate({height: autoHeight}, 1000);
        expandParent.find(".expand-more").addClass("add");
        expandParent.find(".expand-more span").text(jsLang("See All"));
    }
});
