"use strict";
emptyShow();
$(document).on('click', '.add-to-compare', function() {
    let itemId = $(this).attr('data-itemId');
    compareAjaxCall("/compare-store", itemId, this);
});

$(document).on('click', '.compare-remove', function() {
    let itemId = $(this).attr('data-itemId');
    compareAjaxCall("/compare-delete", itemId, this);
});

var compareClick = 0;
function compareAjaxCall(url, itemId, parent)
{
    if (++compareClick > 1) {
        return false;
    }

    var svg = $(parent).html();
    setTimeout(() => {
        $('div[data-itemid=' + itemId +']').html(`
        <svg class="animate-spin text-gray-700 w-full h-full" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="#000" stroke-width="3"></circle>
            <path class="opacity-75" fill="#fff" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
        </svg>
    `)
    }, 5);

    $.ajax({
        url: SITE_URL + url,
        data: {
            product_id: itemId,
            "_token": token
        },
        type: 'POST',
        dataType: 'JSON',
        success: function (data) {
            if (data.status == 1) {
                updateCompare(data.totalProduct, itemId);
                if (url == '/compare-store') {
                    $('div[data-itemid=' + itemId +']').addClass('compare-remove').removeClass('add-to-compare');
                } else {
                    $('div[data-itemid=' + itemId +']').addClass('add-to-compare').removeClass('compare-remove');
                }
            }
        },
        complete: function() {
            $('div[data-itemid=' + itemId +']').html(svg);
            compareClick = 0
        }
    });
}

function emptyShow(itemId = null)
{
  if (parseInt($('#totalCompareItem').text()) > 0 ) {
      $('.value-'+itemId).remove();
      $('#compareEmpty').hide();
      $('.compare-table').removeClass('display-none');
  } else {
      $('.compare-table').remove();
      $('#compareEmpty').show();
      $('#totalCompareItem').removeClass('w-4 h-4');
  }
}

function updateCompare(total = 0, itemId)
{
    if (parseInt(total) > 0) {
        $('#totalCompareItem').html(total);
        $('#totalCompareItem').addClass('w-4 h-4');
    } else {
        $('#totalCompareItem').html('');
    }
    emptyShow(itemId);
}
