"use strict";
let loader = `<ul class="h-full flex items-center">
                <svg class="" id="loading-spinner" width="40" height="40"
                    viewBox="0 0 80 80" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <circle id="loading-circle-large" cx="40" cy="40"
                        r="36" stroke="var(--primary-color)" stroke-width="8"></circle>
                </svg>
            </ul>`;
$(document).on('click', '.filter', function() {
    $('.filter-value').text($(this).text());
    let star = $(this).data('star');
    $('.filter-value').data("filter-star", star);
    let vendor_id = $(this).data('item');
    $('.filter').children().removeClass('primary-text-color')
    $('.filter span.text-md').addClass('ml-3');
    $('.filter span.text-md').text('');
    $(this).prepend(
        `<span class="primary-text-color -mr-3 text-md">✓</span>`
    )
    $(this).children().addClass('primary-text-color')
    $.ajax({
        url: SITE_URL + "/site/review/search",
        data: {rating: star, vendor_id: vendor_id, _token: token},
        type: 'POST',
        beforeSend: function() {
            $('#load_review').html(loader);
        },
        success: function (data) {
            $('#load_review').html(data.response.records.data);
        }
    });
});

$('.rating-width').each((index, item) => {
    $(item).css('width', $(item).data('width') + "%");
});

$(document).on('click', '#review-paginate a', function(e) {
     e.preventDefault();
    var page = $(this).attr('href').split('page=')[1];
    
    $.ajax({
        url: SITE_URL + "/site/review/search?page="+page,
        data: {rating: $('.filter-value').data("filter-star"), vendor_id: $('#vendor_id').val(), _token: token},
        type: 'POST',
        beforeSend: function() {
            $('#load_review').html(loader);
            $([document.documentElement, document.body]).animate({
                scrollTop: $("#review-section").offset().top - 100
            }, 1000);
        },
        success: function (data) {
            $('#load_review').html(data.response.records.data);
        }
    });
});