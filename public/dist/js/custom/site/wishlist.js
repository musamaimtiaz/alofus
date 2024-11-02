"use strict";
var wishlistClick = 0;
$(document).on('click', '.wishlist', function() {
    if (++wishlistClick > 1) {
        return false;
    }

    var item_id = $(this).data('id');
    document.cookie = "product_id="+ item_id;
    var wishlist = $(this);

    var svg = $(this).html();
    setTimeout(() => {
        $(this).html(`
        <svg class="animate-spin text-gray-700 w-full h-full" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="#000" stroke-width="3"></circle>
            <path class="opacity-75" fill="#fff" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
        </svg>
    `)
    }, 5);
    $.ajax({
        url: SITE_URL + "/user/wishlist/store",
        type: 'POST',
        dataType: 'JSON',
        data:{
            product_id: item_id,
            "_token": token
        },
        success: function (data) {
            document.cookie = "product_id=; Max-Age=-99999999;";
            if ($(svg).hasClass('text-gray-10')) {
                svg = svg.replace('text-gray-10', 'color_fill svg-bg')
                $('#totalWishlistItem').text(Number($('#totalWishlistItem').text()) + 1);
                $('#totalWishlistItem').addClass('w-4 h-4');
            } else if ($(svg).hasClass('color_fill')) {
                svg = svg.replace('color_fill svg-bg', 'text-gray-10')
                $('#totalWishlistItem').text(Number($('#totalWishlistItem').text()) - 1);
                if ($('#totalWishlistItem').text() == 0) {
                    $('#totalWishlistItem').text('');
                    $('#totalWishlistItem').removeClass('w-4 h-4');
                }
            } else if (wishlist.find('.fa-heart-o').length) {
                wishlist.find('i').removeClass('fa-heart-o text-black');
                wishlist.find('i').addClass('fa-heart text-green-500')
                wishlist.find('span').text(jsLang('Remove from wishlist'));
                $('#totalWishlistItem').text(Number($('#totalWishlistItem').text()) + 1);
            } else if (wishlist.hasClass('add-wishlist')) {
                wishlist.addClass('remove-wishlist primary-bg-color');
                wishlist.removeClass('add-wishlist');
                $('#totalWishlistItem').text(Number($('#totalWishlistItem').text()) + 1);
                $('#totalWishlistItem').addClass('w-4 h-4');
            } else if (wishlist.hasClass('remove-wishlist')) {
                wishlist.addClass('add-wishlist');
                wishlist.removeClass('remove-wishlist primary-bg-color');
                $('#totalWishlistItem').text(Number($('#totalWishlistItem').text()) - 1);
                if ($('#totalWishlistItem').text() == 0) {
                    $('#totalWishlistItem').text('');
                    $('#totalWishlistItem').removeClass('w-4 h-4');
                }
            }
            else {
                wishlist.find('i').removeClass('fa-heart text-gray-10')
                wishlist.find('i').addClass('fa-heart-o text-black');
                wishlist.find('span').text(jsLang('Add to wishlist'));
                $('#totalWishlistItem').text(Number($('#totalWishlistItem').text()) - 1);
                if ($('#totalWishlistItem').text() == 0) {
                        $('#totalWishlistItem').text('');
                }
            }
        },
        error: function (xhr, ajaxOptions, thrownError) {
            if (xhr.status == '401') {
                window.location.href = SITE_URL + "/user/login";
            }
        },
        complete: function() {
            wishlist.html(svg);
            wishlistClick = 0
        }
    })
})

/** Shop Profile start **/
$('.shop-search-icon').on('click', function() {
    if (window.innerWidth <= 624) {
        $(".search-in-store").toggle();
        $(".shop-menu").toggle();
    }
});
/** Shop Profile end **/

// Prevent multiple click on delete button;
var clickCount = 0;
function preventMultipleClick() {
    if (++clickCount > 1) {
        return false;
    }
}
