"use strict";
const sellerImages = $('.seller-images').children();
for (let i = 0; i < sellerImages.length; i++) {
    $(sellerImages[i]).css({
        'z-index': sellerImages.length - i
    });
}

let titles = document.querySelectorAll('.accordion__title');
for (let i = 0; i < titles.length; i++) {
  titles[i].addEventListener('click', e => {
    for (let x of titles) {
      if (x !== e.target) {
        x.classList.remove('accordion__title--active');
        x.nextElementSibling.style.maxHeight = 0;
        x.nextElementSibling.style.padding = 0;
      }
    }
    e.target.classList.toggle('accordion__title--active');
    let description = e.target.nextElementSibling;

    if (e.target.classList.contains('accordion__title--active')) {
      description.style.maxHeight = description.scrollHeight + 'px';
    } else {
      description.style.maxHeight = 0;
      description.style.padding = 0;
    }
  });
}

let resendClick = 0;
  $('.resend-verification-code-seller').on('click', function() {
      if (++resendClick > 1) {
          return;
      }

      resendCode(this);
      var email = $(".login-box-body").find('#email').val();
      $.ajax({
          url: SITE_URL + "/seller/resend-otp/" + email,
          type: "get",
          dataType: "JSON",
          contentType: false,
          cache: false,
          processData: false,
          success: function (data) {
          },
          complete: function(data) {
              resendClick = 0
          }
      });
  })
  function resendCode(parent) {
      $(parent).text('30').removeClass('underline cursor-pointer resend-code').css({'border': '2px solid #888', 'height':'30px', 'width':'30px', 'border-radius': '50%', 'display':'block','margin':'auto', 'padding':'1px'})
      var interval = setInterval(() => {
          var text = $(parent).text();
          text--;
          if (text < 10) {
              text = '0' + text;
          }
          $(parent).text(text);
          if (text <= 0) {
              $(parent).text(jsLang('Resend Code')).addClass('underline cursor-pointer resend-code').css({'border': 'unset', 'border-radius': 'unset', 'width':'unset', 'height':'unset', 'padding': 'unset','display':'unset','margin':'unset'})
              clearInterval(interval);
          }
      }, 1000);
  }

//otp spinner functionality
$(document).on('click', '.login-box-body .otp-btn', function() {
    $(".login-box-body .spin").show();
})