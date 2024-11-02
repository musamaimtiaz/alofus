"use strict";

$("#exported_column").select2({
    placeholder: jsLang('Export all columns'),
});

$("#product_types").select2({
    placeholder: jsLang('Export all products'),
});

$("#categories").select2({
    placeholder: jsLang('Export all categories'),
});

$("#vendors").select2({
    placeholder: jsLang('Export all vendors'),
});

$(document).on('change', '#product_types', function() {
    hideCategory();
});

/*hide category if product type has variation*/
function hideCategory()
{
    let productTypes = $('#product_types').val();
    $.each(productTypes, function (i, v){
       if (v == 'Variation') {
           $('#category_div').addClass('display_none');
       } else {
           $('#category_div').removeClass('display_none');
       }
    });
}

$("#export").on("click",function(){
    setTimeout(() => {
    $(".spinner-border").remove();
    $(this).removeClass('disabled-btn');
    $('#export').append(`<i class="feather icon-upload-cloud m-0 ms-2"></i>`)
    }, 1000);
});


