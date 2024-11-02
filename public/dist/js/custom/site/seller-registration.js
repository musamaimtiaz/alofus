"use strict";
imgInp.onchange = evt => {
    const [file] = imgInp.files
    if (file) {
        blah.src = URL.createObjectURL(file)
    }
}
$('.pass-hide').on('click', function() {
    $(this).hide();
    $(".pass-show").show();
    $(this).closest('.pass').find('.pass-field').get(0).type = "text";
});

$('.pass-show').on('click', function() {
    $(this).hide();
    $(".pass-hide").show();
    $(this).closest('.pass').find('.pass-field').get(0).type = "password";
});
