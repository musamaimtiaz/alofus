'use strict';
$('.select2').select2();
if ($('.main-body .page-wrapper').find('#add-ticket-container').length) {
	var theEditor;
	function selectedCustomer() {
		$('#assign_name').val($('#customer_id option:selected').attr('data-name'));
		$('#assign_email').val($('#customer_id option:selected').attr('data-email'));
	}

	$(document).on('change', '#customer_id', function() {
		selectedCustomer();
	});

	if (projectId != '') {
		$('#project_id, #customer_id').prop("disabled", true);
	}

	$("body").on("click", ".delete_file_field", function() {
		$(this).parents(".control-group").remove();
	});

	validateCKEditor('#ticket_messages', '#ticket_messages-error');

	$('#add_ticket_form').validate({
		ignore: [],
		rules: {
			subject: {
				required: true
			},
			project_id: {
				required: true
			},
			assign_id: {
				required: true
			},
			department_id: {
				required: true
			},
			priority_id: {
				required: true
			},
			customer_id: {
				required: function(element) {
					return ($('#flag').val() == 'yes') ? false : true;
				}
			},
			message: {
				CKEditorRequired: true
			},
		},
	});

	$('select').on("change", function() {
		if ($(this).val() != "") {
			$(this).valid();
		}
		$('#project_id').on('change', function() {
			var project_id = $('#project_id').val();
			$.ajax({
					method: "get",
					url: SITE_URL + "/ticket/check-inhouse-project",
					data: {
						'id': project_id
					}
				})
				.done(function(msg) {
					if (msg == 'yes') {
						$('.select-customer-div, .customer-info-div').hide();
						$('#flag').val('yes');
					} else {
						$('.select-customer-div, .customer-info-div').show();
						$('#flag').val('no');
					}
				});
		});

	});
	deleteAttachment(SITE_URL + "/file/remove?type=ticket_reply");
	uploadAttachment(SITE_URL + "/file/upload?type=ticket_reply", '#customer_id');
	$("#add_ticket_btn").on('click', function() {
		if ($("#add_ticket_form").valid() == true) {
			$(".spinner").show().css('line-height', '0');
			$("#spinnerText").text(jsLang('Please wait...'));
			$(this).attr("disabled", true);
			$("#add_ticket_form").trigger('submit');
		}
	});
}

if ($('.main-body .page-wrapper').find('#edit-ticket-container').length) {
	$(function() {
		$('#assign_name').val($('#customer_id option:selected').attr('data-name'));
		$('#assign_email').val($('#customer_id option:selected').attr('data-email'));
	});

	$(document).on('change', '#customer_id', function() {
		$('#assign_name').val($('option:selected', this).attr('data-name'));
		$('#assign_email').val($('option:selected', this).attr('data-email'));
	});

	$("body").on("click", ".delete_file_field", function() {
		$(this).parents(".control-group").remove();
	});

	$('#edit-ticket-form').validate({
		ignore: [],
		rules: {
			subject: {
				required: true
			},
			project_id: {
				required: true
			},
			assign_id: {
				required: true
			},
			department_id: {
				required: true
			},
			priority_id: {
				required: true
			},
			customer_id: {
				required: true
			},
		},
	});

	$('select').on("change", function() {
		if ($(this).val() != "") {
			$(this).valid();
		}
	});
}

if ($('.main-body .page-wrapper').find('#ticket-list-container').length) {
	$('#daterange-btn').daterangepicker(daterangeConfig(startDate, endDate), cbRange);
	cbRange(startDate, endDate);

	$(document).on("click", "#csv", function(event) {
		event.preventDefault();
		window.location = SITE_URL + "/ticket_csv?from=" + $('#startfrom').val() + "&to=" + $('#endto').val() +"&project=" + $('#project').val() + "&department_id=" + $('#department_id').val() + "&status=" + $('#status').val() + "&assignee=" + $('#assignee').val();
	});
	$(document).on("click", "#pdf", function(event) {
		event.preventDefault();
		window.location = SITE_URL + "/ticket_pdf?from=" + $('#startfrom').val() + "&to=" + $('#endto').val() + "&project=" + $('#project').val() + "&department_id=" + $('#department_id').val() + "&status=" + $('#status').val() + "&assignee=" + $('#assignee').val();
	});

	$('#theModal').on('show.bs.modal', function(e) {
		var button = $(e.relatedTarget);
		var modal = $(this);
		$('#theModalSubmitBtn').attr('data-task', '').removeClass('delete-task-btn');
		if (button.data("label") == 'Delete') {
			modal.find('#theModalSubmitBtn').addClass('delete-task-btn').attr('data-task', button.data('id')).text(jsLang('Delete')).show();
			modal.find('#theModalLabel').text(button.data('title'));
			modal.find('.modal-body').text(button.data('message'));
		} else {
			modal.find('.modal-body').html('<div class="spinner"><div class="bounce1"></div><div class="bounce2"></div><div class="bounce3"></div></div>');
			modal.find('.modal-body').load(button.data("remote"));
		}
	});

	$('#theModalSubmitBtn').on('click', function() {
		$('#delete-item-' + $(this).data('task')).trigger('submit');
	})

	$(window).on('load', function() {
		if ($(window).width() < 576) {
			$("#headerDiv").addClass("pb-3");
		}
	});

	$('body').tooltip({
		selector: '[data-toggle="tooltip"]'
	});

	$(document).on('click',".ticket_status_change", function () {
 		var statusId = $(this).attr('data-id');
    	var ticketId = $(this).attr('ticket_id');
    	var ticketName = $(this).attr('data-value');
		ticketStatusChange(SITE_URL + '/ticket/change-status', statusId, ticketId, ticketName);
	});
}

if ($('.main-body .page-wrapper').find('#reply-ticket-container1').length) {
    var stack = [];
    hideNoDiv();
	$(document).on('click', ".status_change", function() {
		var status_id = $(this).attr('data-id');
		var ticketId = $(this).attr('ticket_id');
		$.ajax({
			url: SITE_URL + "/ticket/change-status",
			method: "POST",
			data: {
				'status_id': status_id,
				'ticketId': ticketId,
				'_token': token
			},
			dataType: "json",
			success: function(data) {
				if (data.status == 1) {
					$('#status_label').html(data.newName);
					$('#status_label').css("color", data.newStatusColor);
					$('#ticket-status').html(data.newName);
          			$('#ticket-status').removeClass('text-white').css("color", data.newStatusColor);
					var statusName = data.newName;
					$.ajax({
						url: SITE_URL + "/ticket/get-status",
						method: "POSt",
						data: {
							'statusName': statusName,
							'ticketId': ticketId,
							'_token': token
						},
						dataType: "json",
						success: function(data) {
							if (data.status == 1) {
								$('#removeLi ul').empty();
								$('#removeLi ul').append(data.output);
							} else {
								swal(jsLang('Something went wrong, please try again.'), {
						           icon: "error",
						           buttons: [false, jsLang('Ok')],
						        });
							}
						}
					});
				} else {
					swal(jsLang('Something went wrong, please try again.'), {
			          icon: "error",
			          buttons: [false, jsLang('Ok')],
			        });
				}
			}
		});
	});

	validateCKEditor('#ticket_messages', '#ticket_messages-error');

	$('#reply_form').validate({
		ignore: [],
		rules: {
			message: {
				CKEditorRequired: true
			},
		},
		submitHandler: function() {
			$(".spinner").show().css('line-height', '0');
			$("#spinnerText").text(jsLang('Please wait...'));
			$('#btnSubmit').attr("disabled", true);
			return true;
		}
	});

	$(function() {
		var name = $('#customer_id option:selected').attr('data-name');
		var email = $('#customer_id option:selected').attr('data-email');
		$('#assign_name').val(name);
	});

	var editorValue;
	ClassicEditor.create(document.querySelector('#reply-modal'))
	.then(editor => {
	  editorValue = editor;
	  theEditor = intialData = editor.getData(); // Save for later use.
	  editor.model.document.on('change', () => {
	    let editorData = intialData = editor.getData();
	    editorData = editorData.replace(/&nbsp;/g, '').replace('<p>', '').replace('</p>', '').replace(/^\s+|\s+$/g, "");
	    theEditor = editorData;
	    if (editorData.length == 0) {
	      $('#reply-modal-error').show().html(jsLang('This field is required.'));
	      return false;
	    } else {
	      $('#reply-modal-error').hide().html('');
	    }
	  });
	}).catch(error => {});

	$(".edit-btn").on('click', function() {
		editorValue.setData($(this).attr('data-message'));
		var temp = $(".ck-content").children("p.first").val();
		$("#reply_id").val($(this).attr('data-id'));
		$("#update_type").val($(this).attr('data-type'));
	});
	$('#replyModal').validate({
		ignore: [],
		rules: {
			message: {
				CKEditorRequired: true
			},
		}
	});

	var editorNote;
	ClassicEditor.create(document.querySelector('#txtAreaNote'))
	.then(editor => {
	  editorNote = editor;
	  theEditor = intialData = editor.getData(); // Save for later use.
	  editor.model.document.on('change', () => {
	    let editorData = intialData = editor.getData();
	    editorData = editorData.replace(/&nbsp;/g, '').replace('<p>', '').replace('</p>', '').replace(/^\s+|\s+$/g, "");
	    theEditor = editorData;
	    if (editorData.length == 0) {
	      $('#txtAreaNote-error').show().html(jsLang('This field is required.'));
	      return false;
	    } else {
	      $('#txtAreaNote-error').hide().html('');
	    }
	  });
	}).catch(error => {});

	$('#noteForm').validate({
		ignore: [],
		rules: {
			message: {
				CKEditorRequired: true
			},
		}
	});

	$("#modal-note").on("show.bs.modal", function () {
		editorNote.setData($('#txtAreaNote').attr('data-message'));
	    $('#txtAreaNote-error').hide();
	});

	$(document).on('change', '#assignee', function() {
		var user_id = $("#assignee").val() ? $("#assignee").val() : null;
		var customer_id = $("#customer_id").val();
		var url = SITE_URL + "/admin/ticket/change-assignee";
		$.ajax({
			url: url,
			method: "POST",
			data: {
				'user_id': user_id,
				'customer_id': customer_id,
				'ticket_id': ticket_id,
				'_token': token
			},
			dataType: "json",
			beforeSend: function() {
				swal({
					title: jsLang('Loading...'),
					text: $('#assignee option:selected').text() + ", " + jsLang('assigning to this ticket'),
					buttons: false
				});
			},
			success: function(data) {
				if (data.status == '1') {

                    $('#assignee').val(user_id).trigger('change');
                    swal($('#assignee option:selected').text() + jsLang(' successfully assigned'), {
                        icon: "success",
                        buttons: [false, jsLang('Ok')],
                    });

				} else if (data.status == '2') {
                    $('#assignee').val(user_id).trigger('change');
                    swal(jsLang(' please check your email configuration'), {
                        icon: "error",
                        buttons: [false, jsLang('Ok')],
                    });
                }
			}
		});
	});

	$("body").on("click", ".delete_file_field", function() {
		$(this).parents(".control-group").remove();
	});
	deleteAttachment(SITE_URL + "/file/remove");
	uploadAttachment(SITE_URL + "/file/upload?type=ticket_reply", '#customer_id');

	$(document).on('click',".ticket_priority_change", function () {
	    var priorityId = $(this).attr('data-id');
	    var ticketId = $(this).attr('ticket_id');
	    var ticketName = $(this).attr('data-value');
	    ticketPriorityChange(SITE_URL + '/admin/ticket/priority-status', priorityId, ticketId, ticketName);
  	});
    $('#reply_form').validate({
        ignore: [],
        rules: {
            message: {
                CKEditorRequired: true
            },
        }
    });
	$(document).on('click',".project-name-change", function () {
	    var projectName = $(this).attr('data-value');
        var url = SITE_URL + "/ticket/change-project";
        var newUrl = SITE_URL + "/project/details/"+ $(this).attr('data-id');
        $.ajax({
            url:url,
            method:"post",
            data:{
                'projectId':$(this).attr('data-id'),
                'ticketId':$(this).attr('ticket_id'),
                '_token':token
            },
            dataType:"json",
            success:function(data) {
                if (data.status == 1) {
                    $('#removeLiProject ul').empty();
                    $('#removeLiProject ul').append(data.output);
                    $('.project-name').html(projectName);
                    $('.project-url').html(projectName);
                    $('.project-url').attr('href', newUrl);
                } else {
                    var html = '<div class="alert alert-danger">' +
                        '<button type="button" class="close" data-dismiss="alert">×</button>' +
                        '<strong>Something went wrong, please try again.</strong>' +
                        '</div>';
                    $('.noti-alert').append(html);
                    $('#notifications').css('display', 'block');
                }
            }
        });
  	});
}
