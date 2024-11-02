"use strict";

$('#password_confirm, #password_seller').keyup(function(){
    let password = $("#password_seller").val();
    let confirmPassword = $("#password_confirm").val();
    if (password.length && confirmPassword.length) {
        if (password != confirmPassword) {
            $(".password-validation-match-error").addClass('text-red-500');
            $(".password-validation-match-error").text(jsLang('Passwords does not match!'));
            $(".password-validation-error").text('');
        }
        else {
            $(".password-validation-match-error").text('');
        }
    }
    $(".password-validation-error").text('');
});

function formValidation() {
    var status = true;
    var isPasswordValid = true;
    var errorMsg = "";
    var tmpMsg = [];

    if (uppercase && $(".password-validation").val().search(/[A-Z]/) < 0) {
        tmpMsg.push(jsLang("uppercase"));
        status = isPasswordValid = false;
    }
    if (lowercase && $(".password-validation").val().search(/[a-z]/) < 0) {
        tmpMsg.push(jsLang("lowercase"));
        status = isPasswordValid = false;
    }
    if (number && $(".password-validation").val().search(/[0-9]/) < 0) {
        tmpMsg.push(jsLang("numbers"));
        status = isPasswordValid = false;
    }
    if (
        symbol &&
        $(".password-validation")
            .val()
            .search(/[#?!@$%^&*-]/) < 0
    ) {
        tmpMsg.push(jsLang("symbols"));
        status = isPasswordValid = false;
    }

    if (tmpMsg.length > 0) {
        errorMsg = jsLang("Password must contain :x");
        errorMsg = errorMsg.replace(":x", tmpMsg.join(", "));
    }

    if (length && $(".password-validation").val().length < length) {
        if (errorMsg.length > 0) {
            errorMsg = jsLang(
                "Password must contain :x and :y characters long."
            );
            errorMsg = errorMsg.replace(":x", tmpMsg.join(", "));
            errorMsg = errorMsg.replace(":y", length);
        } else {
            errorMsg = jsLang("Password must be at least :x characters.");
            errorMsg = errorMsg.replace(":x", length);
        }
        status = isPasswordValid = false;
    }

    if (status == false) {
        if (!isPasswordValid) {
            $(".password-validation-error")
                .addClass("text-red-500")
                .text(errorMsg);
        }
        return false;
    }

    if (status == true) {
        return true;
    }
}

$(document).on("click", ".toggle-password", function () {
    let input = $("#password_seller");
    if (input.attr("type") === "password") {
        input.attr("type", "text");
        $(".pass-hide").removeClass("hidden");
        $(".pass-show").addClass("hidden");
    } else {
        input.attr("type", "password");
        $(".pass-show").removeClass("hidden");
        $(".pass-hide").addClass("hidden");
    }
});

$(document).ready(function() {

    //select 2
       $('.addressSelect').select2();
 
    // select2 autofocus 
    $(document).on('select2:open', (e) => {
        const selectId = e.target.id

        $(".select2-search__field[aria-controls='select2-" + selectId + "-results']").each(function(
            key,value,
        ) {
            value.focus();
        })
    })
    
    let loader = `<option value="">${jsLang('Loading')}...</option>`;
    let selectCity = `<option value="">${jsLang('Select City')}</option>`;
    let selectState = `<option value="">${jsLang('Select State')}</option>`;
    let errorMsg = jsLang(':x is not available.');
 
    // initially country loading 
 
    $.ajax({
        url: SITE_URL + "/geo-locale/countries",
        type: "GET",
        dataType: 'json',
        beforeSend: function() {
            $('#country').html(loader);
            $('#country').attr('disabled','true');
        },
        success: function(result) {
            $('#country').html('<option value="">' + jsLang('Select Country') + '</option>');
            $.each(result, function(key, value) {
            $("#country").append(`'<option  ${value.code==oldCountry?'Selected': ''} data-country="${value.code}" value="${ value
                    .code}">${value.name}</option>'`);
            });
            $("#country").removeAttr("disabled");
        }
    });
 
    
    if (oldState != "null") {
       getState(oldCountry);
    }
    if (oldCity != "null") {
       getCity(oldState,oldCountry);
    }
    
 
    $('#country').on('change', function() {;
       let str = $(this).find(':selected').html();
       oldCity = "null";
       getState($('#country').find(':selected').attr('data-country'));
    });
 
    function getState( country_code ) {
 
       if (country_code) {
          $("#state").html('');
          if (oldCity == "null") {
             $('#city').html(selectCity);
          }
          $.ajax({
             url: SITE_URL + "/geo-locale/countries/" + country_code + "/states",
             type: "GET",
             dataType: 'json',
             beforeSend: function() {
                $('#state').attr('disabled','true');
                $('#state').html(loader);
             },
             success: function(result) {
                $('#state').html(selectState);
                $.each(result.data, function(key, value) {
                      $("#state").append(`'<option ${value.code==oldState?'Selected': ''} data-state="${value.code}" value="${value.code}">${value.name}</option>'`);
                });
                $("#state").removeAttr("disabled");
                if (result.length <= 0 && result.data.length <= 0) {
                   errorMsg = errorMsg.replace(":x", 'State');
                  $('#state').html(`<option value="">${errorMsg}</option>`); 
                }
             }
          });
       } else {
          
          $('#state').html(selectState);
          $('#city').html(selectCity);
          
       }
    }
 
    $('#state').on('change', function() {
       let str = $(this).find(':selected').html();
 
       getCity($('#state').find(':selected').attr('data-state'), $('#country').find(':selected').attr('data-country'));
          
    });
 
    function getCity( siso, ciso) {
 
      if (siso && ciso) {
          $("#city").html('');
          $.ajax({
             url: SITE_URL + "/geo-locale/countries/" + ciso + "/states/" + siso +
                "/cities",
             type: "GET",
             dataType: 'json',
             beforeSend: function() {
                $('#city').html(loader);
                $('#city').attr('disabled','true');
             },
             success: function(res) {
                $('#city').html(selectCity);
                $.each(res.data, function(key, value) {
                      $("#city").append(`<option ${value.name == oldCity ? 'Selected': ''} value="${value.name}">${value.name}</option>`);
                });
                $("#city").removeAttr("disabled");
                if (res.length <= 0 && res.data.length <= 0) {
                   errorMsg = errorMsg.replace(":x", 'City');
                  $('#city').html(`<option value="">${errorMsg}</option>`); 
                }
             }
          });
      } else {
          $('#city').html(selectCity);
      }
    }
    
 });

$(document).on('click', "#btnSubmits", function() {
   setTimeout(goToErrorMessage, 0);
})

function goToErrorMessage() {
    $([document.documentElement, document.body]).animate({
        scrollTop: $(".error").offset().top - 170
    }, 500);
}
