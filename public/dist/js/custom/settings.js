"use strict";
function readURL(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.readAsDataURL(input.files[0]);
    }
}
if ($('.main-body .page-wrapper').find('#company-settings-container').length) {
    $(".js-example-basic-single").select2();

    $('#dflt_lang').on('change', function() {
      var languageId = $( "#dflt_lang option:selected" ).attr('data-rel');
      $.ajax({
        url: SITE_URL + "/languages/translation/" + languageId,
        type: "get",
        data: {
            '_token': token,
            'type':'company_setting'
        }
      });
    });

    $('#company_name').on('blur', function () {
        if ($(this).val() == "") {
            $('#site_short_name').val("");
        } else {
            var company_name = $(this).val().split(' ');
            if (company_name.length == 1) {
                $('#site_short_name').val(company_name[0][0].toUpperCase() + company_name[0][1].toUpperCase());
            } else if (company_name.length == 2) {
                $('#site_short_name').val(company_name[0][0].toUpperCase() + company_name[1][0].toUpperCase());
            } else {
                $('#site_short_name').val(company_name[0][0].toUpperCase() + company_name[1][0].toUpperCase() + company_name[2][0].toUpperCase());
            }
        }
    });
}

// SMS Set up
if ($('.main-body .page-wrapper').find('#sms-settings-container').length) {
    $('.select').select2();
}

// Language
if ($('.main-body .page-wrapper').find('#language-settings-container').length) {
    $(document).on( 'init.dt', function () {
        $(".dataTables_length").remove();
        $('#dataTableBuilder').removeAttr('style');
    });
    dataTable('#dataTableBuilder', [2,3,4]);

    $(document).on('click', '.edit_language', function () {
        var id = $(this).attr("id");
        $.ajax({
            url: SITE_URL + "/languages/edit",
            data: {
                id: id,
                "_token": token
            },
            type: 'POST',
            dataType: 'JSON',
            success: function (data) {
                $('#edit_language_name').val(data.language_name);
                $('#edit_short_name').val(data.short_name);
                $('#edit_status').val(data.status).trigger('change');
                $('#edit_direction').val(data.direction).trigger('change');
                $('#language_id').val(data.id);
                $('#editImg').attr('src', data.flag);

                if (data.is_default == 1) {
                    $("#edit_default").prop("checked", true);
                } else {
                    $("#edit_default").prop("checked", false);
                }
                $('#edit_language').modal();
            }
        });

    });
    $('#edit_default').on('change', function() {
        if ($(this)[0].checked) {
            $('#edit_status').val('Active').trigger('change');
        }
    });
    $('#default').on('change', function() {
        if ($(this)[0].checked) {
            $('#status').val('Active').trigger('change');
        }
    });

    $('#add-language').on('show.bs.modal', function (e) {
        $(this).find(".error").hide();
    });

    $('#add-language').on('hidden.bs.modal', function (e) {
        $(this).find("select").val('').trigger('change');
        $('#default').prop('checked', false);
    });

    $('#blah_add').hide();
    $('#confirmDelete').on('show.bs.modal', function (e) {
        var button = $(e.relatedTarget);
        var modal = $(this);
        $('#confirmDeleteSubmitBtn').attr('data-task', '').removeClass('delete-task-btn');
        if (button.data("label") == 'Delete') {
            modal.find('#confirmDeleteSubmitBtn').addClass('delete-task-btn').attr('data-task', button.data('id')).text(jsLang('Yes, Confirm')).show();
            modal.find('#confirmDeleteLabel').text(button.data('title'));
            modal.find('.modal-body').text(button.data('message'));
        }
        $('#confirmDeleteSubmitBtn').on('click', function () {
            $('#delete-language-' + $(this).data('task')).trigger('submit');
        });
    });
    $(document).on("click", "#tablereload", function (event) {
        event.preventDefault();
        $("#dataTableBuilder").DataTable().ajax.reload();
    });
    $('.js-example-basic-single-1').select2({
        dropdownParent: $('#edit_language')
    });

    $('.js-example-basic-single-2').select2({
        dropdownParent: $('#add-language')
    });
}

// translation js
if ($('.main-body .page-wrapper').find('#translation-settings-container').length) {
    dataTable('#dataTableBuilder', 1);
}

// Currency Converter Setup
if ($('.main-body .page-wrapper').find('#currency-converter-settings-container').length) {
    $("input:radio[name=customRadio]").click(function() {
        if ($(this).attr("id") == "customRadio2") {
            $('#exchange_rate_api').val('Active');
            $('#currency_converter_api').val('Inactive');
        } else if ($(this).attr("id") == "customRadio1") {
            $('#exchange_rate_api').val('Inactive');
            $('#currency_converter_api').val('Active');
        }
    })
}

// SSO Set up
if ($('.main-body .page-wrapper').find('#sso-settings-container').length) {
    $('.removeSpace').keyup(function(e){
         let data = $(this).val();
        data = data.replace(/\s/g, '');
        $(this).val(data);
    });
}

$(document).on('click', ".custom-file", function() {
    if ($(this).closest('#iconTop').length) {
        $('.btn-file-add').attr('dataFavicon', 'icon');
    }
})

$(document).on('click', ".custom-file", function() {
    if ($(this).closest('#logo').length) {
        $('.btn-file-add').attr('dataFavicon', 'logo');
    }
})


$(document).on('click', "#btnSubmits", function() {
   setTimeout(goToErrorMessage, 0);
})

function goToErrorMessage() {
    $([document.documentElement, document.body]).animate({
        scrollTop: $(".error").offset().top - 50
    }, 500);
}

if ($('.main-body .page-wrapper').find('#translation-settings-container').length) {

    $(document).on('blur', 'input', function(){
        let value = $(this).val();
        let name = $(this).data('name');
        if ($('#language_from').find(`input[name="${name}"]`).length > 0) {
            $('#language_from').find(`input[name="${name}"]`).val(value);
        } else {
           $('#language_from').append(`<input type="hidden" name="${name}" value="${value}">`);
        }
    });
}

$(document).on("file-attached", ".custom-file", function (e, param) {
    let data = param.data;
    if (data) {
        $(this).closest(".preview-parent").find(".custom-file-input").val(data[0].id);
    }
});

$('#customer_signup, #vendor_signup').on('change', function() {
    if ($(this).val() == "0") {
        $(this).attr('value', '1');
    } else {
        $(this).attr('value', '0');
    }
});

function searchCurrency() {
    $(".select-currency").select2({
        ajax: {
            url: SITE_URL + '/find-currency-in-ajax',
            dataType: "json",
            delay: 250,
            data: function (params) {
                return {
                    q: params.term, // search term
                    page: params.page,
                };
            },
            processResults: function (data, params) {
                let results = data.data;
                return {
                    results: results
                };
            },
            cache: true,
        },
        placeholder: jsLang("Search for currency"),
        minimumInputLength: 1,
    });
}

if ($('.main-body .page-wrapper').find('#company-settings-container').length) {

    searchCurrency()
    $('.select-currency').html(`<option selected value="${currencyId}">${currencyName}</option>`);


    let loader = `<option value="">${jsLang('Loading')}...</option>`;
    let selectCity = `<option value="">${jsLang('Select City')}</option>`;
    let selectState = `<option value="">${jsLang('Select State')}</option>`;
    let errorMsg = jsLang(':x is not available.');
    $('.addressSelect').select2();

    $.ajax({
        url: url + "/geo-locale/countries",
        type: "GET",
        dataType: 'json',
        beforeSend: function() {
            $('#company_country').html(loader);
            $('#company_country').attr('disabled','true');
        },
        success: function(result) {
            $('#company_country').html('<option value="">' + jsLang('Select Country') + '</option>');
            $.each(result, function(key, value) {
                $("#company_country").append(`'<option  ${value.code==oldCountry?'Selected': ''} data-country="${value.code}" value="${ value.code}">${value.name}</option>'`);
            });
            $("#company_country").removeAttr("disabled");
        }
    });

    if (oldState != "null") {
        getState(oldCountry);
    }
    if (oldCity != "null") {
        getCity(oldState,oldCountry);
    }


    $('#company_country').on('change', function() {
        oldCity = "null";
        getState($('#company_country').find(':selected').attr('data-country'));
    });

    function getState( country_code ) {

        if (country_code) {
            $("#company_state").html('');
            if (oldCity == "null") {
                $('#company_city').html(selectCity);
            }
            $.ajax({
                url: url + "/geo-locale/countries/" + country_code + "/states",
                type: "GET",
                dataType: 'json',
                beforeSend: function() {
                    $('#company_state').attr('disabled','true');
                    $('#company_state').html(loader);
                },
                success: function(result) {
                    $('#company_state').html(selectState);

                    $.each(result.data, function(key, value) {
                        $("#company_state").append(`'<option ${value.code==oldState?'Selected': ''} data-state="${value.code}" value="${value.code}">${value.name}</option>'`);
                    });

                    $("#company_state").removeAttr("disabled");

                    if (result.length <= 0 && result.data.length <= 0) {
                        errorMsg = errorMsg.replace(":x", 'State');
                        $('#company_state').html(`<option value="">${errorMsg}</option>`);
                    }
                }
            });
        } else {

            $('#company_state').html(selectState);
            $('#company_city').html(selectCity);
        }
   }

    $('#company_state').on('change', function() {
        getCity($('#company_state').find(':selected').attr('data-state'), $('#company_country').find(':selected').attr('data-country'));
    });

    function getCity( siso, ciso) {

        if (siso && ciso) {
            $("#company_city").html('');
            $.ajax({
                url: url + "/geo-locale/countries/" + ciso + "/states/" + siso +
                "/cities",
                type: "GET",
                dataType: 'json',
                beforeSend: function() {
                    $('#company_city').html(loader);
                    $('#company_city').attr('disabled','true');
                },
                success: function(res) {
                    $('#company_city').html(selectCity);
                    $.each(res.data, function(key, value) {
                        $("#company_city").append(`<option ${value.name == oldCity ? 'Selected': ''} value="${value.name}">${value.name}</option>`);
                    });
                    $("#company_city").removeAttr("disabled");
                    if (res.length <= 0 && res.data.length <= 0) {
                        errorMsg = errorMsg.replace(":x", 'City');
                        $('#company_city').html(`<option value="">${errorMsg}</option>`);
                    }
                }
            });

        } else {
            $('#company_city').html(selectCity);
        }
    }
}
