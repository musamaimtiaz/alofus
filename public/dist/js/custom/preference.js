'use strict';
// General preference js here
if ($('.main-body .page-wrapper').find('#preference-settings-container').length) {
    $(".select").select2();
    $('.input-group').css('background-color', 'white');
}

// Theme preference js here
if ($('.main-body .page-wrapper').find('#appearance-settings-container').length) {
    // reset-appearance
    $('#reset-appearance').on('click', function(){
    $('body, header, nav').removeClass();
    $('nav').addClass('pcoded-navbar');
    $('header').addClass('navbar pcoded-header navbar-expand-lg');
    $('#default_theme, #default_header, #default_menu, #default_menu_brand, #default_menu_item, #navbar_image_none, #menu_list_icon-1, #dropdown_icon-1').prop("checked", true);
    $('#menu-icon-colored, #menu-fixed, #header-fixed, #box-layout').prop("checked", false);
    });

    // To get Body Classes
    $('input[name="box-layout"]').on('click', function(){
    $('body').toggleClass("container box-layout");
    });

    // To get Header Classes
    $('input[name="header_background"], input[name="header-fixed"]').on('click', function(){
    var headerCls = $('input[name="header_background"]:checked').val();
    headerCls = (headerCls != 'default') ? headerCls : '';

    var headerFixedCls = $('input[name="header-fixed"]').val();
    headerFixedCls = ($('input[name="header-fixed"]').is(':checked')) ? headerFixedCls : '';

    $('header').removeClass();
    $('header').addClass('navbar pcoded-header navbar-expand-lg ' + headerCls + ' ' + headerFixedCls);
    });

    // Menu Background Exception
    $('input[name="menu_background"]').on('click', function(){
    var navImageBgCls = $('input[name="navbar_image"]:checked').val();
    if (navImageBgCls != 'default') {
        swal({
            icon: 'success',
            title: jsLang('Please select menu image NONE to work menu background color'),
            buttons: [false, jsLang('Ok')],
        });
    }
    });

    // Dark mode notification
    $('#dark_theme').on('click', function() {
    swal({
        icon: 'success',
        title: jsLang('Dark mode will work completely, after saving theme preferences'),
        buttons: [false, jsLang('Ok')],
    });
    });

    // To get Navbar Classes
    $('input[name="menu_background"], input[name="menu_brand_background"], input[name="menu_item_color"], input[name="navbar_image"], input[name="menu_list_icon"], input[name="menu_dropdown_icon"], input[name="menu-icon-colored"], input[name="menu-fixed"], input[name="theme_mode"]').on('click', function(){
    $('nav').removeClass();
    $('nav').addClass(getNavbarClass());
    });

    function getNavbarClass(){
    var navCls = $('input[name="menu_background"]:checked').val();
    navCls = (navCls != 'default') ? navCls : '';

    var brandCls = $('input[name="menu_brand_background"]:checked').val();
    brandCls = (brandCls != 'default') ? brandCls : '';

    var activeItemCls = $('input[name="menu_item_color"]:checked').val();
    activeItemCls = (activeItemCls != 'default') ? activeItemCls : '';

    var navImageCls = $('input[name="navbar_image"]:checked').val();
    navImageCls = (navImageCls != 'default') ? navImageCls : '';

    var listIconCls = $('input[name="menu_list_icon"]:checked').val();
    listIconCls = (listIconCls != 'default') ? listIconCls : '';

    var themeModeCls = $('input[name="theme_mode"]:checked').val();
    themeModeCls = (themeModeCls != 'default') ? themeModeCls : '';

    var dropDownIconCls = $('input[name="menu_dropdown_icon"]:checked').val();
    dropDownIconCls = (dropDownIconCls != 'default') ? dropDownIconCls : '';

    var iconColorCls = $('input[name="menu-icon-colored"]').val();
    iconColorCls = ($('input[name="menu-icon-colored"]').is(':checked')) ? iconColorCls : '';

    var menuFixedCls = $('input[name="menu-fixed"]').val();
    menuFixedCls = ($('input[name="menu-fixed"]').is(':checked')) ? menuFixedCls : '';

    var allClasses = 'pcoded-navbar ' + navCls + ' ' + brandCls + ' ' + activeItemCls + ' ' + navImageCls + ' ' + listIconCls + ' ' + dropDownIconCls + ' ' + iconColorCls + ' ' + menuFixedCls + ' ' + themeModeCls;

    return allClasses;
    }

}

//file extension
$("#extension_loading").show();
$(".tagsinput").hide();
$("#extension_action_div").show();
$('.tagsinput').each(function(){
    $(this).removeAttr('font-family');
});

$("#preference_form").on('keypress', function (e) {
    if (e.keyCode == 13) {
        e.preventDefault();
        saveTags()
    };
})

function saveTags() {
    var items = $('#tags-input').tagsinput('items');
    items = items.map(function (x) { return x.toLowerCase(); });
    var csrf_token = $('meta[name="csrf-token"]').attr('content');

    $.ajax({
        type: 'POST',
        url: SITE_URL + '/extension-store',
        data: {
            "_token": csrf_token,
            "data": items
        },
        dataType: "JSON",
    });
}

$(document).ready(function () {
    $.ajax({
        type: 'GET',
        url: SITE_URL + '/get-extension-in-ajax',
        dataType: "json",
        success: function (data) {
            $("#extension_loading").hide();
            $(".tagsinput").show();
            if (data.status == 200) {
                $.each(data.extensions, function (key, item) {
                    $("#tags-input").tagsinput("add", item);
                    $("#tags-input").tagsinput({
                        allowDuplicates: false,
                    });
                });
            } else {
                var unsuccessHtml = '<div><label class="text-warning">' + data.extensions + '</label></div>'
                $("#extension_action_div").hide();
                $("#extension_notification").html(unsuccessHtml);
            }
        }
    });
});

$('#tags-input').on('beforeItemAdd', function (event) {
    var alNumRegex = /^([a-zA-Z0-9]+)$/;
    if (!alNumRegex.test(event.item)) {
        var unsuccessHtml = '<div class="alert alert-danger alert-dismissible fade show" role="alert">' + '<strong>Extension name not valid</strong>' + '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>';
        $('#extension_notification').html(unsuccessHtml).delay(3000).fadeOut('slow')
        event.cancel = true;
    }
    else {
        event.cancel = false;
    }
});

