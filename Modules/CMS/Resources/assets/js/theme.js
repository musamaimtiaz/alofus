"use strict";
if ($('.main-body .page-wrapper').find('#theme-container').length) {
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

    function changeLayout(layout) {
        var fragmentation = window.location.hash;
        blockElement($('#main-appearance'))
        $.ajax({
            url: ADMIN_SITE_URL + '/theme/list',
            data: {
                'layout': layout
            },
            type: 'GET',
            dataType: 'JSON',
            success: function (data) {
                $('#main-appearance').html(data.data);
                $('#v-pills-social-share-tab').trigger('click');
                $('#success-message').css("display", "none");
                $('#warning-message').css("display", "none");

                $(".select2-hide-search").select2({
                    minimumResultsForSearch: Infinity
                });
                
                if (layout != 'default') {
                    $("li a.header").trigger('click');
                    $('#v-pills-social-share-tab').closest('li').remove()
                    $('#v-pills-custom-css-js-tab').closest('li').remove()
                    $('#v-pills-page-config-tab').closest('li').remove()

                    if (fragmentation.includes('social') || fragmentation.includes('page-config') || fragmentation.includes('custom-css-js')) {
                        $("#v-pills-topNav-tab").trigger('click');
                    } else {
                        $(fragmentation + '-tab').trigger('click');
                        $(fragmentation + '-tab').closest('ul').siblings('a').trigger('click')
                    }

                } else {
                    $(fragmentation + '-tab').trigger('click');
                    $(fragmentation + '-tab').closest('ul').siblings('a').trigger('click')
                }
                $(function() {
                    $("#sortable").sortable({
                        axis: "y",
                        cursor: "move",
                    });
                });
            },
            complete: function() {
                $('.conditional').ifs();
                $(function() {
                    var dd1 = new dropDown($('#myAppearanceDropdown'));
                })
            }
        })
    }

    // change layout
    $(document).on('click', '#layout-setting', function() {
        changeLayout($(this).attr('data-val'));
    })

    // Edit layout
    $(document).on('click', '#layout-edit', function() {
        $('#edit-layout').find('input[name="name"], input[name="old_layout"]').val($(this).attr('data-layout'));
    })

    // Save cms theme
    var cmsSaveCount = 0;
    $(document).on('click', ".theme-option-save-btn", function(event) {
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
            var value = $(v).val().replace(/<style.*>|<script.*>/, '').replace(/"/g, 'double_quotation')
            $(v).closest('.row').append(`
                <input type="hidden" name="${$(v).attr('name')}" value="${value}">
            `);
        })

        $('.custom-file-input').each((k, v) => {
            $(v).val($(v).closest('.form-group').find('input[name="file_id[]"').val())
        })

        $.ajax({
            url: SITE_URL + "/theme/store",
            type: 'POST',
            data: {
                _token: token,
                enctype: 'multipart/form-data',
                data: $("#optionForm" ).find('input, select').serialize()
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
            complete: function(data) {
                $(btn).text(jsLang('Save')).find('.spinner-border').remove();
                cmsSaveCount = 0;
            }
        });

        setTimeout(() => {
            $('#success-message, #warning-message').slideUp(500)
            $('.abc').removeClass('alert-success alert-danger')
        }, 5000);
    });

    // Add new widget title and link
    $(document).on('click', '.add-new-widget-title', function() {
        var widget = $(this).attr('data-widget');
        $(this).closest('.row').before(`
            <div class="form-group row">
                <div class="col-sm-5">
                    <div class="input-group bg-transparent">
                        <input type="text" class="form-control" name="${layout}_template_footer[main][${widget}][data][${$(this).attr('data-id')}][label]" value="" maxlength="40">
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="input-group bg-transparent">
                        <input type="text" class="form-control" name="${layout}_template_footer[main][${widget}][data][${$(this).attr('data-id')}][link]" value="">
                    </div>
                </div>
                <div class="col-sm-1 ps-0">
                    <div class="input-group bg-transparent cursor_pointer remove-widget-title">
                        <span class="input-group-text rounded"><i class="feather icon-trash-2 fa-2x"></i></span>
                    </div>
                </div>
            </div>
        `);
        $(this).attr('data-id', Number($(this).attr('data-id')) + 1)
    })

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

    // Update primary color
    var debounce = null;
    $(document).on('change', '.layout-primary-color', function() {
        var name = $(this).attr('name');
        var value = $(this).val();
        clearTimeout(debounce);
        debounce = setTimeout(function () {
            $.ajax({
                url: SITE_URL + "/theme/store/primary-color",
                type: 'POST',
                data: {
                    _token: token,
                    name: name,
                    value: value
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
                complete: function() {
                    setTimeout(() => {
                        $('#success-message, #warning-message').slideUp(500)
                        $('.abc').removeClass('alert-success alert-danger')
                    }, 5000);
                }
            });
        }, 1000);
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

