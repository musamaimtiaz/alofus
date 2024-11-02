"use strict";
function nextSlide() {
    let activeSlide = document.querySelector(".slide.translate-x-0");
    activeSlide.classList.remove("translate-x-0");
    activeSlide.classList.add("-translate-x-full");

    let nextSlide = activeSlide.nextElementSibling;
    nextSlide.classList.remove("translate-x-full");
    nextSlide.classList.add("translate-x-0");
}

function previousSlide() {
    let activeSlide = document.querySelector(".slide.translate-x-0");
    activeSlide.classList.remove("translate-x-0");
    activeSlide.classList.add("translate-x-full");

    let previousSlide = activeSlide.previousElementSibling;
    previousSlide.classList.remove("-translate-x-full");
    previousSlide.classList.add("translate-x-0");
}

$(".offer").each((i, d) => {
    var seconds = $(d).data("offer_end");
    var countdownTimer = setInterval(() => {
        var days = Math.floor(seconds / 24 / 60 / 60);
        var hoursLeft = Math.floor(seconds - days * 86400);
        var hours = Math.floor(hoursLeft / 3600);
        var minutesLeft = Math.floor(hoursLeft - hours * 3600);
        var minutes = Math.floor(minutesLeft / 60);
        var remainingSeconds = seconds % 60;
        function pad(n) {
            return n < 10 ? "0" + n : n;
        }

        $(".offer .days").text(pad(days));
        $(".offer .hours").text(pad(hours));
        $(".offer .minutes").text(pad(minutes));
        $(".offer .seconds").text(pad(remainingSeconds));

        if (seconds == 0) {
            clearInterval(countdownTimer);
        } else {
            seconds--;
        }
    }, 1000);
});

if($('.category-list-decoration').length > 8){
  $(".category-list-decoration").last().addClass( "mb-11" );
}
else{
    $(".category-list-decoration").last().removeClass( "mb-11" );
}
$(document).on('click', '.expand-button', function () {
    if ($(".menu-full-details").find(".add").length) {
        $(".menu-full-details").removeClass("height-437p");
        $(".menu-full-details").addClass("h-auto");
        $(".expand-button").removeClass("add");
        $(".expand-button svg").addClass("rotated-view");
        $(".expand-button span").text(jsLang("See Less Categories"));
    } else {
        $(".menu-full-details").addClass("height-437p");
        $(".menu-full-details").removeClass("h-auto");
        $(".expand-button").addClass("add");
        $(".expand-button svg").removeClass("rotated-view");
        $(".expand-button span").text(jsLang("See All Categories"));
    }
});

// dropdown in homepage
    function checkScroll() {
        if(getComputedStyle(document.getElementById('nav-wrap')).direction=="ltr"){
          for (let i = 0; i < firstDropDown.length; i++) {
           firstDropDown[i].style.transform ="translateX(-" + scroller.scrollLeft + "px)"  ;
        }
    }
    else if(getComputedStyle(document.getElementById('nav-wrap')).direction=="rtl"){
          for (let i = 0; i < firstDropDown.length; i++) {
       firstDropDown[i].style.transform ="translateX(+" + scroller.scrollLeft * (-1) + "px)"  ;
    }
        }
  }
  const scroller = document.querySelector(".nav-wrap");
    if (scroller) {
        const firstDropDown = document.querySelectorAll(".first-dropdown");
        scroller.addEventListener("scroll", checkScroll);
    }
