'use strict';
var clickedOnce = 0;
var currentSection = '';
var lastCatgeoryId = $('#category_id').val();
var currentSectionClick = false;
var buttonIsDisable = true;
var preParentCategory = [];
var preTextCurrentSection = '';
var isButtonClear = false;
var tempActiveForSection = '';
var prebuttonIsDisable = false;
var hasSubMenuActiveFirstClick = 0;
(function(){
    let firstFlag = 0;
    function $(selector, context){
        context = context || document;
        return context["querySelectorAll"](selector);
    }

    function forEach(collection, iterator){
        for(var key in Object.keys(collection)){
            iterator(collection[key]);
        }
    }

    function showMenu(menu){
        var menu = this;
        var ul = $("ul", menu)[0];
        let selectedList = $("li>a", menu)[0];


        if(!ul || ul.classList.contains("-visible")) return;

        menu.classList.add("-active");
        ul.classList.add("-animating");
        ul.classList.add("-visible");
        setTimeout(function(){
            ul.classList.remove("-animating")
        }, 25);
    }

    function hideMenu(menu){
        var menu = this;
        var ul = $("ul", menu)[0];

        if(!ul || !ul.classList.contains("-visible")) return;

        menu.classList.remove("-active");
        ul.classList.add("-animating");
        setTimeout(function(){
            ul.classList.remove("-visible");
            ul.classList.remove("-animating");
        }, 300);
    }

    function hideAllInactiveMenus(menu){
        var menu = this;
        if (currentSectionClick == false) {
            forEach(
                $("li.-hasSubmenu.-active:not(:hover)", menu.parent),
                function(e){
                    e.hideMenu && e.hideMenu();
                }
            );
        }
        let list = document.querySelectorAll('.-hasSubmenu.-active');
        let listSelection = document.querySelectorAll('.breadcrumb-item');
        let selectedInput = document.querySelector('input:focus');
        var listTag = document.getElementsByTagName("li");
        if(firstFlag && list.length === 0 && !selectedInput) {
            var x = document.getElementById("myDIV");
            setTimeout(function(){
                x.style.display = "none";
                firstFlag = 0;
                removeAllActive();
                pathSelect(false);
            }, 500);
        } else {
            firstFlag = 1;
        }
    }

    window.addEventListener("load", function(){

        forEach($(".Menu li.-hasSubmenu"), function(e){
            e.showMenu = showMenu;
            e.hideMenu = hideMenu;
        });

        forEach($(".Menu > div > li.-hasSubmenu"), function(e){
            e.addEventListener("click", showMenu);
        });

        forEach($(".Menu > div> li.-hasSubmenu li"), function(e){
            e.addEventListener("click", hideAllInactiveMenus);
        });

        forEach($(".Menu > div> li.-hasSubmenu li.-hasSubmenu"), function(e){
            e.addEventListener("click", showMenu);
        });

        document.addEventListener("click", hideAllInactiveMenus);
    });
    document.getElementById('custom-show').addEventListener("click", function(){
        var x = document.getElementById("myDIV");

        if (x.style.display === "none" || x.style.display === "") {
            x.style.display = "block";
            document.getElementById("categorySubmit").disabled = true;
            confirmTextCurrentSection != '' ? buttonIsDisable = false : '';
            if (isButtonClear == false) {
                selectedParentCategory(false);
            }
            isButtonClear = false;
        } else {
            x.style.display = "none";
        }
    });

})();

$(document).ready(function() {

    var link = $('#navbar-scroll a.dot');
    // Move to specific section when click on menu link
    link.on('click', function(e) {
      var target = $($(this).attr('href'));
      $('html, body').animate({
        scrollTop: target.offset().top
      }, 600);
      $(this).addClass('custom-active');
      e.preventDefault();
    });

    // Run the scrNav when scroll
    $(window).on('scroll', function(){
      scrNav();
    });

    // scrNav function
    // Change active dot according to the active section in the window
    function scrNav() {
      var sTop = $(window).scrollTop();
      $('.section').each(function() {
        var id = $(this).attr('id'),
            offset = $(this).offset().top-1,
            height = $(this).height();
        if(sTop >= offset && sTop < offset + height) {
          link.removeClass('custom-active');
          $('#navbar-scroll').find('[data-scroll="' + id + '"]').addClass('custom-active');
        }
      });
    }
    scrNav();
  });

$(document).on('keyup', '.category-search', function(e) {
    let categorySearchId = $(this).attr('data-seId');
    let seValue = this.value.toLowerCase().trim();
    let liSelector = "#categorySearchDiv-"+categorySearchId+' '+ '.categorySearchDiv-'+categorySearchId;
    $(liSelector).show().filter(function() {
        return $(this).text().toLowerCase().trim().indexOf(seValue) == -1;
    }).hide();
});
$('.category-list').click(function(e) {
    if (hasSubMenuActiveFirstClick == 0) {
        removeSubmenuActive();
    }
    currentSectionClick = false;
       if ($(this).hasClass("-hasSubmenu")) {
               removeActive();
               prebuttonIsDisable = true;
               $('#categorySubmit').prop("disabled",true);
       } else {
           if (clickedOnce == 0) {
               removeActive();
               $(this).addClass('-active');
               removeMultipleActive();
               $('#categorySubmit').prop("disabled",false);
               prebuttonIsDisable = false;
           } else {
               prebuttonIsDisable = true;
               $('#categorySubmit').prop("disabled",true);
           }
       }
       if (tempActiveForSection != '') {
           $(".category-list").each(function() {
               let dataCatId = $(this).attr('data-catid');
               if (dataCatId == tempActiveForSection) {
                   $(this).removeClass("-active");
                   tempActiveForSection = '';
               }
           });
       }
    setTimeout(function(){
        pathSelect();
    }, 500);
    if (!$(this).hasClass("-hasSubmenu")) {
        if ($(this)) {
            e.stopPropagation();
        }
    }
});

function removeSubmenuActive()
{
    hasSubMenuActiveFirstClick = 1;
    $(".-active").each(function() {
        if ($(this).hasClass('-hasSubmenu')) {
            $(this).removeClass('-active');
            $(this).closest('ul').removeClass("-animating");
            $(this).closest('ul').removeClass("-visible");
        }
    });
}

function removeActive()
{
    clickedOnce = 0;
    $(".-active").each(function() {
        if (!$(this).hasClass('-hasSubmenu')) {
            $(this).removeClass('-active');
        }
    });
}

function removeAllActive()
{
    $(".-active").each(function() {
            $(this).removeClass('-active');
            $(this).closest('ul').removeClass("-animating");
            $(this).closest('ul').removeClass("-visible");
    });
}

function removeMultipleActive()
{
    let ct = 0;
    $(".categorySearchDiv-0").each(function() {
        if ($(this).hasClass('-active')) {
            ct ++;
            if (ct == 2) {
                hideAllSubMenu();
            }
        }
    });
}

function hideAllSubMenu()
{
    $(".-hasSubmenu").each(function() {
        if ($(this).hasClass('-active')) {
            var menu = this;
            var ul = $("ul", menu)[0];

            if(!ul || !ul.classList.contains("-visible")) return;

            menu.classList.remove("-active");
            ul.classList.add("-animating");
            setTimeout(function(){
                ul.classList.remove("-visible");
                ul.classList.remove("-animating");
            }, 300);
        }
    });
}

$('#categoryCancel').click(function(e) {
    e.preventDefault();
    var x = document.getElementById("myDIV");
    setTimeout(function(){
        x.style.display = "none";
    }, 500);
});

$('#categoryClear').click(function(e) {
    $('.ajax-loader').css("visibility", "visible");
    e.preventDefault();
    clickedOnce = 1;
    isButtonClear = true;
    categoryReset();
    $('#categorySearchDiv-0 li .clicked').trigger('click');
    setTimeout(function(){
        $('#custom-show').trigger('click');
        pathSelect(false);
        removeActive();
        $(".category-list[data-catid=1]").trigger("click");
        $("#custom-show").prop("value", $(".category-list[data-catid=1]").data("name"));
        $('.ajax-loader').css("visibility", "hidden");
    }, 700);
});

function categoryReset()
{
    $(".category-search").each(function() {
        let categorySearchId = $(this).attr('data-seId');
        let seValue = '';
        $(this).val(seValue);
        let liSelector = "#categorySearchDiv-"+categorySearchId+' '+ '.categorySearchDiv-'+categorySearchId;
        $(liSelector).show().filter(function() {
            return $(this).text().toLowerCase().trim().indexOf(seValue) == -1;
        }).hide();
    });
}

function pathSelect(reWrite = true)
{
    $(".breadcrumb-item").remove();
    if (reWrite) {
        preParentCategory = [];
        currentSection = '';
        let text = '';
        let avoidFirst = 0;
        let countCatgeory = 0;
        $(".category-list").each(function(i, v) {
            let classList = $(this).attr('class');
            if (classList.indexOf('-active') != -1) {
                let catId = $(this).attr('data-catid');
                text += `<li class="breadcrumb-item" data-catId = ${catId}><a class="custom-a" href="javascript:void(0)">${$(this).attr('data-name')}</a></li>`;
                preParentCategory[countCatgeory++] = catId;
                if (avoidFirst == 1) {
                    currentSection += " / ";
                } else {
                    avoidFirst = 1;
                }
                currentSection += $(this).attr('data-name');
                lastCatgeoryId = $(this).attr('data-catId');
            }
        });
        preTextCurrentSection = text;
        $('.current-section ol span').after(text);
        loadListProduct();
    }
}


$('#categorySubmit').click(function(e) {
    changeCategory();
});

function changeCategory()
{
    currentSectionClick = false;
    $('#custom-show').val(currentSection);
    $('#category_id').val(lastCatgeoryId);
    $('#category_id').trigger('change');
    parentCategoryId = preParentCategory;
    confirmTextCurrentSection = preTextCurrentSection;
    buttonIsDisable = prebuttonIsDisable;
    selectedParentCategory();
}

$('#custom-show').keydown(function() {
    return false;
});

function loadListProduct (isPathCall = true)
{
    var elements = document.getElementsByClassName("breadcrumb-item");

    var myFunction = function() {
        currentSectionClick = true;
        let currId = $(this).attr('data-catid');
        $(".-hasSubmenu").each(function() {
            let subCatId = $(this).attr('data-catid');
            if (currId == subCatId) {
                let liId = $(this).attr('id');
                $('#'+liId+' '+'.-active').removeClass('-active');
                $('#'+liId+' '+'.-visible').removeClass('-visible');
                hideCurrMenu(this);
                isPathCall == true ? pathSelect() : '';
                $(this).removeClass('-active');
                if ($(this).hasClass('-hasSubmenu')) {
                    $(this).addClass('-active');
                    tempActiveForSection = subCatId;
                    prebuttonIsDisable = true;
                    $('#categorySubmit').prop("disabled",true);
                }
            }
        });
    };

    for (var k = 0; k < elements.length; k++) {
        elements[k].addEventListener('click', myFunction, false);
    }
}

function hideCurrMenu(menu)
{
    var menu = menu;
    var ul = $("ul", menu)[0];

    if(!ul || !ul.classList.contains("-visible")) return;

    menu.classList.remove("-active");
    ul.classList.add("-animating");
    setTimeout(function(){
        ul.classList.remove("-visible");
        ul.classList.remove("-animating");
    }, 300);

}

function selectedParentCategory(action = true)
{
    currentSectionClick = true;
    let firstFlag = 0;
    $.each(parentCategoryId , function (i, v) {
    $(".category-list").each(function() {
        let dataCatId = $(this).attr('data-catid');
        if (dataCatId == v) {
            $(this).addClass("-active");
            $(this).closest('ul').addClass("-animating");
            $(this).closest('ul').addClass("-visible");
        }
    });
    });
    $(".breadcrumb-item").remove();
    $('.current-section ol span').after(confirmTextCurrentSection);
    loadListProduct();

    if (buttonIsDisable == false) {
        $('#categorySubmit').prop("disabled",false);
    }
    setTimeout(function(){
        currentSectionClick = false;
        if (action == true) {
            var x = document.getElementById("myDIV");
            if (x.style.display === "block") {
                setTimeout(function() {
                    x.style.display = "none";
                    firstFlag = 0;
                    removeAllActive();
                    pathSelect(false);
                }, 500);
            }
        }
    }, 300);

}

$('#categoryWarning').on('hidden.bs.modal', function () {
    currentSectionClick = false;
})
