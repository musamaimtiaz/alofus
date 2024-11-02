"use strict";

$(document).ready(function() {
    $('.custom-design-container').hide();
    $('.loading-dots').hide();

    let pageLoaded = false;

    function setSearchData(id, data) {
        if (data == '') {
            $(id).closest('.parent-search-section').hide();
            return;
        }
        $('.custom-design-container').show();
        $(id).closest('.parent-search-section').show()
        $(id).html(data);
    }
    // Function to generate the Popular Suggestions section
    function generatePopularSuggestions(data) {
        let suggestion = '';
        data.forEach(item => {
            suggestion += `<li><a href="${SITE_URL + '/search-products?keyword=' + item}" class="text-[13px] text-gray-12 font-medium line-clamp-1 px-3">${item}</a></li>`;
        });
        
        setSearchData('#popular_suggestions_list', suggestion);
    }
    
    // Function to generate the Popular Categories section
    function generatePopularCategories(data) {
        let categories = '';
        for (const key in data) {
            categories += `<li><a href="${SITE_URL + '/search-products?categories=' + key}" class="text-[13px] text-gray-12 font-medium line-clamp-1 px-3">${data[key]}</a></li>`;
        }
        
        setSearchData('#category_suggestion_list', categories);
    }
    
    function generateSearchProduct(data) {
        let products = '';
        data.forEach(item => {
            products += `<li>
                <a href="${SITE_URL + '/products/' + item.slug}">
                    <div class="flex gap-3 px-3 py-2">
                        <img class="w-[40px] object-cover rounded" src="${item.image}">
                        <div>
                        <p class="text-[13px] text-gray-12 font-medium line-clamp-1">${item.title}</p>
                        <span class="text-[13px] text-gray-12">${item.price}</span>
                        </div>
                    </div>
                </a>
            </li>`;
            });
            
        setSearchData('#product_search_list', products);
    }
    
    function generateSearchShop(data) {
        let shops = '';
        data.forEach(item => {
            shops += `<li>
                    <a href="${SITE_URL + '/shop/' + item.alias}">
                        <div class="flex gap-3 py-2 px-3">
                            <img class="w-[40px] h-[40px] object-cover rounded-full neg-transition-scale" src="${item.image}" alt="avatar">
                            <div>
                            <p class="text-[13px] text-gray-12 font-medium line-clamp-1">${item.title}</p>
                            <span class="text-[13px] text-gray-10"> Phone: ${item.phone}</span>
                            </div>
                        </div>
                    </a>
                </li>`;
        });
            
        setSearchData('#shop_search_list', shops);
    }
    

    // Function to fetch data and show loader only on page load
    function fetchDataOnPageLoad() {
        if (!pageLoaded && $('#itemSearch').val().length) {
            $('.loading-dots').show();
            
            $.ajax({
                url: SITE_URL + "/get-search-data",
                dataType: "json",
                type: "POST",
                data: {
                    _token: token,
                    search: $('#itemSearch').val(),
                },
                success: function(data) {
                    $('.loading-dots').hide();

                    if (data.status == 1) {

                        let parseData = JSON.parse(data.searchData);

                        if (parseData.popularSuggestion.length === 0 &&
                            parseData.popularCategories.length === 0 &&
                            parseData.products.length === 0 &&
                            parseData.shops.length === 0) {
                                
                            $('.not-found-content').text($('#itemSearch').val());
                            $('.parent-search-section').hide();
                            $('.empty-search').show();


                        } else {
                            generatePopularSuggestions(parseData.popularSuggestion);
                            generatePopularCategories(parseData.popularCategories);
                            generateSearchProduct(parseData.products);
                            generateSearchShop(parseData.shops);
                            $('.empty-contnet').hide();
                            $('.empty-search').hide();
                        }
                    } else {
                        $('.parent-search-section').hide();
                    }
                },
                error: function() {
                    $('.parent-search-section').hide();
                },
                complete: function() {
                    $('.loading-dots').hide();
                }
            });

            pageLoaded = true;
        }
    }

    // Show the custom design on search bar focus
    $("#itemSearch").on('click', function() {
        if ($('#itemSearch').val().length) {
            $('.custom-design-container').show();
            fetchDataOnPageLoad(); 
        }
    });

    $(document).on('click', function(event) {
        if (!$(event.target).closest('#itemSearch').length && !$(event.target).closest('.custom-design-container').length) {
            $('.custom-design-container').hide();
        }
    });
    
    $('.custom-design-container').on('click', function(event) {
        event.stopPropagation();
    });
    
    
    $("#itemSearch").on('keyup', function() {
        pageLoaded = false;
        if ($(this).val().length === 0) {
            $('.custom-design-container').hide();
        } else {
            $('.custom-design-container').show();
        }
    })

    $("#itemSearch").autocomplete({
        delay: 500,
        position: { my: "left top", at: "left bottom", collision: "flip" },
        source: function(request, response) {
            fetchDataOnPageLoad(); 
        },
        select: function(event, ui) {
            let e = ui.item;
            window.location.href = SITE_URL + "/search-products?keyword=" + encodeURI(e.value).replace(/%20/g, "+");
        },
        minLength: 0,
        autoFocus: false
    });
});

$(document).ready(function() {
    function setCookie(cname, cvalue, exdays) {
        const d = new Date();
        d.setTime(d.getTime() + (exdays * 24 * 60 * 60 * 1000));
        let expires = "expires="+d.toUTCString();
        document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/";
    }

    function getCookie(cname) {
        let name = cname + "=";
        let ca = document.cookie.split(';');
        for(let i = 0; i < ca.length; i++) {
          let c = ca[i];
          while (c.charAt(0) == ' ') {
            c = c.substring(1);
          }
          if (c.indexOf(name) == 0) {
            return c.substring(name.length, c.length);
          }
        }
        return "";
    }
    $('.custom-modal-over .close-modal').each(function() {
        var popupName = $(this).attr('data-popupName');
        var loginRequired = $(this).attr('data-loginRequired');
        var isLogin = $(this).attr('data-isLogin');
        var popupShowAfter = $(this).attr('data-popupShowAfter');
        var popupPage = $(this).attr('data-popupPage');

        if (!getCookie(popupName) && popupPage == 'true') {
            if (loginRequired == '1') {
                if (isLogin == 'true') {
                    setTimeout(() => {
                        $(this).closest('.custom-modal-over').show();
                    }, popupShowAfter * 1000);
                }
            } else {
                setTimeout(() => {
                    $(this).closest('.custom-modal-over').show();
                }, popupShowAfter * 1000);
            }
        }

        $('.custom-modal-over .close-modal').on('click', function() {
            $(this).closest('.custom-modal-over').hide();
        });

        $('.custom-modal-over .close-popup-window').on('click', function() {
            setTimeout(() => {
                $(this).closest('.custom-modal-over').hide();
            }, 5000);
            setCookie(popupName, true, 1);
        });
    });
})

$(document).on('submit', '#subscribe', function(e) {
    e.preventDefault();
    $('.send-btn').css('display', 'none');
    $('.subscribe-loader').css('display', 'inline');
    $('.subscribe-message').text('');
    $.ajax({
        type: 'post',
        url: subscribeUrl,
        data: new FormData(this),
        dataType:'JSON',
        contentType: false,
        cache: false,
        processData: false,
        success: function (data) {
            $('.subscribe-message').text(data.message);
            $('.subscribe-loader').css('display', 'none');
            $('.send-btn').css('display', 'block');
        },
        error: function (data) {
            $('.subscribe-message').text(data.responseJSON.errors.email[0]);
            $('.subscribe-loader').css('display', 'none');
            $('.send-btn').css('display', 'block');
        }
    })
})

$(document).ready(function() {
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

    if (sessionFail != '') {
       Toast.fire({
            icon: 'error',
            title: sessionFail
        })
    }

    if (sessionSuccess != '') {
       Toast.fire({
            icon: 'success',
            title: sessionSuccess
        })
    }

    $('.menu.dropdown-enable').each(function() {
        if ($(this).find('button .primary-bg-color').length > 0) {
            $(this).closest('li').find('a').first().addClass('active-border-bottom');
        }
    })
})

// for blog post sidebar archieve accordion

let titles = document.querySelectorAll('.accordion__header');
for (let i = 0; i < titles.length; i++) {
    titles[i].addEventListener('click', e => {
        for (let x of titles) {
            if (x !== e.target) {
                x.classList.remove('accordion__header--active');
                x.nextElementSibling.style.maxHeight = 0;
                x.nextElementSibling.style.padding = 0;
            }
        }
        e.target.classList.toggle('accordion__header--active');
        let description = e.target.nextElementSibling;

        if (e.target.classList.contains('accordion__header--active')) {
            description.style.maxHeight = description.scrollHeight + 'px';
        } else {
            description.style.maxHeight = 0;
            description.style.padding = 0;
        }
    });
}
