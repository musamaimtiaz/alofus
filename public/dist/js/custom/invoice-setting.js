"use strict";
if ($('.main-body .page-wrapper').find('#invoice-setting-container').length) {
    $(document).ready(function(){
        $('.conditional').ifs();
        $('#success-message').css("display", "none");
        $('#warning-message').css("display", "none");

        if (window.location.hash != '') {
            $(window.location.hash + '-tab').trigger('click');
            $(window.location.hash + '-tab').closest('ul').siblings('a').trigger('click')
        } else if (appearance_menu == 'layout') {
            $("#v-pills-layout-tab").trigger('click');
        } else {
            $("#v-pills-social-share-tab").trigger('click');
        }

        $(document).on('change keyup', "input", function() {
            $('.warning-message').addClass('alert-secondary');
            $('#warning-message').css("display", "block");
            $('#warning-msg').html(jsLang('Settings have changed, you should save them!'));
          });
    });

    $(document).on("click", ".folding", function () {
        let parent = this.closest(".ui-state-default");
        if (this.classList.contains("closed")) {
            $(parent).find(".dd-content").removeClass("card-hide");
            $(this).removeClass("closed");
        } else {
            $(parent).find(".dd-content").addClass("card-hide");
            $(this).addClass("closed");
        }
    });

    $(document).on("click", ".header-text", function () {
        $(this).closest(".ui-state-default").find(".folding").trigger("click");
    });

    // Change switch with value
    $(document).on('click', '.cr', function() {
        var value = $(this).closest('.switch').find('input').val();
        if (value == 1) {
            $(this).closest('.switch').find('input').val(0)
        } else {
            $(this).closest('.switch').find('input').val(1)
        }
    })

    const blockElement = (element, _data = {}) => {
        let options = Object.assign(
            {},
            {
                message: `<div class="spinner-border appearance-loader text-warning" role="status"><span class="sr-only">Loading...</span></div>`,
                css: {
                    backgroundColor: "transparent",
                    border: "none",
                },
            },
            _data
        );
        element.block(options);
    };

    // Show title with data-id attr
    $(document).on("click", '.tab-name', function () {
        setTimeout(() => {
            $('.nav-link.active').closest('ul').addClass('show').siblings('a').removeClass('collapses').attr('aria-expanded', true);
        }, 100);
        var id = $(this).attr('data-id');
        $('#theme-title').html(id);
        $('.tab-pane').removeClass('show active')
        $(`.tab-pane[aria-labelledby="${$(this).attr('id')}"`).addClass('show active')

        $('.tab-name').removeClass('active').attr('aria-selected', false);
        $(this).addClass('active').attr('aria-selected', true);

        if ($(this).is('#v-pills-layout-tab')) {
            $('.modal-footer.appearance').hide();
        } else {
            $('.modal-footer.appearance').show();
        }
    });

    var cmsSaveCount = 0;
    $(document).on('click', ".invoice-option-save-btn", function (event) {
        event.preventDefault();
        if (++cmsSaveCount > 1) {
            return false;
        }
        var btn = this;

        $(this).text(jsLang('Saving')).append(`<div class="spinner-border spinner-border-sm ml-2" role="status">`)
        var i = 0;
        $('#sortable.footer-main').find('li').each((k, v) => {
            $(v).find('.sort-data').val(++i);
        })

        // textarea to input field
        $('textarea.custom').each((k, v) => {
            console.log(k, v);
            var value = $(v).val().replace(/<style.*>|<script.*>/, '').replace(/"/g, 'double_quotation')
            $(v).closest('.row').append(`
                <input type="hidden" name="${$(v).attr('name')}" value="${value}">
            `);
        })

        $('.custom-file-input').each((k, v) => {
            $(v).val($(v).closest('.form-group').find('input[name="file_id[]"').val())
        })

        $.ajax({
            url: SITE_URL + "/invoice-setting",
            type: 'POST',
            data: {
                _token: token,
                enctype: 'multipart/form-data',
                data: $("#optionForm").find('input, select').serialize()
            },
            success: function (data) {
                var cls = 'alert-danger';
                if (data.status == 1) {
                    cls = 'alert-success';
                }
                $('.abc').addClass(cls);
                $('#success-message, #warning-message').css("display", "block");
                $('#warning-msg').html(data.message);
            },
            complete: function (data) {
                $(btn).text(jsLang('Save')).find('.spinner-border').remove();
                cmsSaveCount = 0;
            }
        });

        setTimeout(() => {
            $('#success-message, #warning-message').slideUp(500)
            $('.abc').removeClass('alert-success alert-danger')
        }, 5000);
    });



    // Remove widget title and link
    $(document).on('click', '.remove-widget-title', function() {
        $(this).closest('.row').remove();
    })

    // Sortable
    $(function() {
        $("#sortable").sortable({
            axis: "y",
            cursor: "move",
        });
    });

    $(document).on('keyup', '.widget-title', function() {
        $(this).closest('li').find('.header-title').text($(this).val());
    })

    $(document).on('click', '.img-delete-icon', function() {
        var id = $(this).attr('data-objectId');
        $('#optionForm').prepend(`
            <input type="hidden" name="delete_file_ids[]" value="${id}" />
        `)
        $(this).closest('div.old-image').remove();
    })

    $(function() {
        var dd1 = new dropDown($('#myAppearanceDropdown'));

        $(document).on('click', function() {
          $('.appearance-dropdown').removeClass('active');
        });
    });

    function dropDown(el) {
        this.dd = el;
        this.placeholder = this.dd.children('span');
        this.opts = this.dd.find('ul.dropdown > li');
        this.val = '';
        this.index = -1;
        this.initEvents();
    }
    dropDown.prototype = {
        initEvents: function() {
            var obj = this;

            obj.dd.on('click', function() {
                $(this).toggleClass('active');
                return false;
            });

            obj.opts.on('click', function() {
                changeLayout($(this).attr('data-val'));
                var opt = $(this);
                obj.val = opt.text();
                obj.index = opt.index();
                obj.placeholder.text(obj.val);
            });
        }
    }

    $(document).on('click', 'ul.nav.nav-list > li', function(e) {
        if (! e.target.href) {
            return false;
        }
        window.location.replace(e.target.href);
    })
}


$(document).on('click', '#v-pills-topNav-tab', function() {
    $('.tab-pane').removeClass('show active')
    $('#' + $(this).attr('id')).addClass('active').attr('aria-selected', true)
    $(`.tab-pane[aria-labelledby="${$(this).attr('id')}"`).addClass('show active')
})

$(document).on('click', '.nav-list .nav-link', function() {
    var target = $(".tab-pane");

    $([document.documentElement, document.body]).animate(
        {
        scrollTop: $(target).offset().top - 350,
        },
        350
    );
})

setTimeout(() => {
    $('.nav-link.active').closest('ul').addClass('show').siblings('a').removeClass('collapses').attr('aria-expanded', true);
}, 100);

$(document).on("file-attached", ".custom-file", function (e, param) {
    let data = param.data;
    if (data) {
        $(this).closest(".preview-parent").find(".custom-file-input").val(data[0].id);
    }
});

$(document).on("click", ".remove-product-image", function () {
    $(this).closest(".img-box-two").remove();
});

