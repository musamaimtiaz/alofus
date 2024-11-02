"use strict";

if ($('.main-body .page-wrapper').find('#role-add-container').length || $('.main-body .page-wrapper').find('#role-edit-container').length) {
 	$(document).on('keyup', '#name', function() {
 		if ($('#slug').hasClass('readonly') === false) {
 			var str = this.value.replace(/[&\/\\#@,+()$~%.'":*?<>{}]/g, "");
 			$('#slug').val(str.trim().toLowerCase().replace(/\s/g, "-"));
 		}
 	});

 	$(document).on('keyup', '#slug', function() {
 		if ($(this).hasClass('readonly') === false) {
 			var str = this.value.replace(/[&\/\\#@,+()$~%.'":*?<>{}]/g, "");
 			$('#slug').val(str.trim().toLowerCase().replace(/\s/g, "-"));
 		}
 	});
}

if ($('.main-body .page-wrapper').find('#role-list-container').length) {
	$('#confirmDelete').on('show.bs.modal', function(e) {
		var button = $(e.relatedTarget);
		var modal = $(this);
		$('#confirmDeleteSubmitBtn').attr('data-task', '').removeClass('delete-task-btn');
		if (button.data("label") == 'Delete') {
			modal.find('#confirmDeleteSubmitBtn').addClass('delete-task-btn').attr('data-id', button.data('id')).text(jsLang('Yes, Confirm')).show();
			modal.find('#confirmDeleteLabel').text(button.data('title'));
			modal.find('.modal-body').text(button.data('message'));
		}
		$('#confirmDeleteSubmitBtn').on('click', function() {
			$('#delete-role-' + $(this).attr('data-id')).trigger('submit');
		})
	});

	$(document).on('init.dt', function () {
    	$('.btn-group').remove();
    	$('#dataTableBuilder').removeAttr('style');
  	});
}

if ($('.main-body .page-wrapper').find('#permission-list-container').length) {

	$('.prms-loader').hide();

    $(document).on('click', '.accordion-toggle', function() {
        setTimeout(() => {
            if ($(this).attr('aria-expanded') == 'true') {
                $(this).find('.arrow-icon').addClass('fa-minus');
                $(this).find('.arrow-icon').removeClass('fa-plus');
            } else {
                $(this).find('.arrow-icon').addClass('fa-plus');
                $(this).find('.arrow-icon').removeClass('fa-minus');
            }
        }, 100);
    });

	  $(document).on('click', '.prms', function(){

	    var p_icon = $(this).find('.p-prms').attr('id');
	    var check = false;

	    if ($('#' + p_icon).hasClass('fa-check text-success')) {
	      $('#' + p_icon).removeClass('fa-check text-success');
	      check = true;
	    }

	    if ($('#' + p_icon).hasClass('fa-times text-danger')) {
	      $('#' + p_icon).removeClass('fa-times text-danger');
	    }

	    $('#' + p_icon).addClass('fa-spinner prms-loader');

	    $.ajax({
	      url: SITE_URL + "/assign-permission",
	      type: 'POST',
	      data: {
	        _token: token,
	        role_id: $(this).data('role_id'),
	        permission_id: $(this).data('permission_id')
	      },
	      success: function(result){
	        if ($('#' + p_icon).hasClass('fa-spinner prms-loader')) {
	          $('#' + p_icon).removeClass('fa-spinner prms-loader');
	        }

	        if (result) {
	          if (check) {
	            $('#' + p_icon).addClass('fa-times text-danger');
	          } else {
	            $('#' + p_icon).addClass('fa-check text-success');
	          }
	        } else {
	          if (check) {
	            $('#' + p_icon).addClass('fa-check text-success');
	          } else {
	            $('#' + p_icon).addClass('fa-times text-danger');
	          }
	        }
	      }
	    });
	  });

    $(document).on('click', '.main-group',function(event) {
        if ($(event.target).is(".search-table")) {
            return
        }
        if ($(this).find('.fa-minus').length) {
            $(".sub-group[data-value=" + $(this).data('value') + "]").hide('slow');
            $(this).attr('aria-expanded', false);
            $('.accordian-body').removeClass('show');
            $('.sub-group i').removeClass('fa-minus').addClass('fa-plus');
        } else {
            $(".sub-group[data-value=" + $(this).data('value') + "]").show('slow');
            $(this).attr('aria-expanded', true);
        }
    })

    $('.search-table').on('keyup', function() {
        var input, filter, table, tr, td, i, txtValue;
        var mainGroup = $(this).closest('tr');
        input = $(this).val();
        filter = input.toUpperCase();
        table = $(".myTable");
        tr = $(".myTable tr[data-value=" + $(this).closest('tr').data('value') + "]");
        for (i = 0; i < tr.length; i++) {
            td = tr[i].querySelector(".search");
            if (td) {
                txtValue = td.textContent || td.innerText;

                if (txtValue.toUpperCase().indexOf(filter) > -1) {
                    tr[i].style.display = "table-row";
                } else {
                    tr[i].style.display = "none";
                }
            }
        }

        mainGroup.find('i').removeClass('fa-minus').addClass('fa-plus');
        $(".sub-group[data-value=" + $(this).closest('tr').data('value') + "]").each(function(k, v) {
            if ($(v).attr('style') == 'display: table-row;') {
                mainGroup.find('i').removeClass('fa-plus').addClass('fa-minus');
            }
        })
    })
}
