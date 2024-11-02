"use strict";
let radioSwitch= false;
$('.radio-test').on('click', function() {
   $('.radio-error-msg').hide();
   radioSwitch= true;
});

$('.save-add-func').on('click', function() {
    if(!radioSwitch){
        $('.radio-error-msg').show();
    }
    else{
        $('.radio-error-msg').hide();
    }
})

function formValidation() {
   if ($('.addressForm').find('.error').length > 0) {
      return false;
   } else {
      $('#btnSubmit').attr('disabled','true');
      return true;
   }
}



$(document).ready(function() {

   //select 2
      $('.addressSelect').select2();

      // select2 autofocus
      $(document).on('select2:open', (e) => {
         const selectId = e.target.id

         $(".select2-search__field[aria-controls='select2-" + selectId + "-results']").each(function(
               key,
               value,
         ) {
               value.focus();
         })
      })

   let loader = `<option value="">${jsLang('Loading')}...</option>`;
   let selectCity = `<option value="">${jsLang('Select City')}</option>`;
   let selectState = `<option value="">${jsLang('Select State')}</option>`;
   let errorMsg = jsLang(':x is not available.');

   // initially country loading

   if ($('.address-form , .checkout-address-form').find('#addressForm').length) {
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
   }


   if (oldState != "null") {
      getState(oldCountry);
   }
   if (oldCity != "null") {
      getCity(oldState,oldCountry);
   }


   $('#country').on('change', function() {;
      let str = $(this).find(':selected').html();
      oldCity = "null";

      if (str.length > 0) {
         let selector = this.closest('.validSelect');
         selector.querySelector('.addressSelect').setCustomValidity("");
         if (selector.querySelector('.error')) {
            selector.querySelector('.error').remove();
         }
      }
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

      if (str.length > 0) {
         let selector = this.closest('.validSelect');
         selector.querySelector('.addressSelect').setCustomValidity("");
         if (selector.querySelector('.error')) {
            selector.querySelector('.error').remove();
         }
      }
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
   $('#city').on('change', function() {
         let str = $(this).find(':selected').html();

         if (str.length > 0) {
            let selector = this.closest('.validSelect');
            selector.querySelector('.addressSelect').setCustomValidity("");
            if (selector.querySelector('.error')) {
               selector.querySelector('.error').remove();
            }
         }
   });
});
