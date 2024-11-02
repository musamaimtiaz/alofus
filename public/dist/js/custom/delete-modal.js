'use strict';

if ($('.main-body .page-wrapper').find('.list-container').length) {
  var deleteButtonForModal;
  $(document).on("click", "#tablereload", function(event) {
    event.preventDefault();
    $("#dataTableBuilder").DataTable().ajax.reload();
  });

  $('#confirmDelete').on('show.bs.modal', function(e) {
    deleteButtonForModal = $(e.relatedTarget);
    var modal = $(this);
    $('#confirmDeleteSubmitBtn').attr('data-task', '').removeClass('delete-task-btn');
    if (deleteButtonForModal.data("label") == 'Delete') {
      modal.find('#confirmDeleteSubmitBtn').addClass('delete-task-btn').attr('data-id', deleteButtonForModal.data('id')).show();
      modal.find('#confirmDeleteLabel').text(deleteButtonForModal.data('title'));
      modal.find('.modal-body').text(deleteButtonForModal.data('message'));
    }

    $('#confirmDeleteSubmitBtn').on('click', function() {
        if (deleteButtonForModal) {   
            $('#delete-' + deleteButtonForModal.attr('data-delete') + '-' + $(this).attr('data-id')).trigger('submit');
            deleteButtonForModal = undefined;
        }
    })
  });
}
