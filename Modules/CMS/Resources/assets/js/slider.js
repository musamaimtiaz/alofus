"use strict";

if ($('.main-body .page-wrapper').find('#slider-list-container').length) {
    $(".select2").select2();

    $('#edit-slider').on('show.bs.modal', function (e) {
        $('#edit-id').val($(e.relatedTarget).attr('id'));
        $('#name').val($(e.relatedTarget).attr('name'));
        $('#edit_status').val($(e.relatedTarget).attr('status'));

        if ($(e.relatedTarget).attr('status') == 'Active') {
            $('.is_default').attr('checked', 'checked');
        } else {
            $('.is_default').attr('checked', false);
        }
    });

    var checked = false;
    $(document).on('click', '.cr', function() {
        checked = checked == 'checked' ? false : 'checked';
        $('.is_default').attr('checked', checked);
        if (checked == 'checked') {
            $('#edit_status').val('Active');
        }
    })
}

if ($('.main-body .page-wrapper').find('#slide-add-container').length) {
    $('.conditional').ifs();
    $('.tab-pane').removeClass('show active')
    $('.tab-pane[aria-labelledby="v-pills-general-tab"').addClass('show active')

    $(document).on('click', 'button.switch-tab', function() {
        $('.tab-pane').removeClass('show active')
        $(`.tab-pane[aria-labelledby="${$(this).attr('data-id')}"`).addClass('show active')
        $('.tab-name').removeClass('active').attr('aria-selected', false)
        $('#' + $(this).attr('data-id')).addClass('active').attr('aria-selected', true)
    })

    // Load another slide
    function slideAjax(url, parent) {
        if ($(parent).find('.active').length == 0 && !$(parent).hasClass('submitting')) {
            $(parent).addClass('submitting');
            $(parent).find('.boxes').removeClass('d-none');
            var slider_id = $('select[name="slider_id"]').val();
            $.ajax({
                url: url,
                type: 'GET',
                dataType: 'JSON',
                success: function (data) {
                    $('.tab-name').removeClass('active').attr('aria-selected', false)
                    $('.tab-name[aria-controls="v-pills-image-and-button"').addClass('active')
                    $('#load-slide-data').html(data.data);
                    $('#v-pills-title-tab').trigger('click');
                    $('#v-pills-general-tab').trigger('click');
                    $('.slide li').removeClass('active');
                    $(parent).find('li').addClass('active');
                    $('.tab-pane[aria-labelledby="v-pills-general-tab"').addClass('show active')
                    $('#general-settings').text(jsLang('Add Slide'));
                    if ($(parent).hasClass('slide-edit')) {
                        $('#general-settings').text(jsLang('Edit Slide'));
                    }

                    $('select[name="slider_id"]').append(`
                        <option value="${slider_id}" selected>${jsLang('Slider')}</option>
                    `);
                },
                complete: function() {
                    $(parent).find('.boxes').addClass('d-none');
                    $(parent).removeClass('submitting');
                    $('.select2-hide-search').select2({
                        minimumResultsForSearch:1/0
                    })
                }
            })
        }
    }

    $('.slide-edit').on('click', function() {
        var url = SITE_URL + "/slide/edit/" + $(this).attr('data-id');
        slideAjax(url, this);
    })

    $('.slide-create').on('click', function() {
        var url = SITE_URL + "/slide/create";
        slideAjax(url, this);
    })

    $(document).on('keyup change', '.validation-sec', function() {
        if ($(this).val() > 4) {
            $(this).val(4);
        }
    })
}
