"use strict";
if ($('.main-body .page-wrapper').find('#email-template-add-container').length || $('.main-body .page-wrapper').find('#email-template-edit-container').length || $('.main-body .page-wrapper').find('#sms-template-add-container').length || $('.main-body .page-wrapper').find('#sms-template-edit-container').length) {

    if ($('.main-body .page-wrapper').find('#email-template-add-container').length || $('.main-body .page-wrapper').find('#email-template-edit-container').length){
        var editor = CodeMirror.fromTextArea(document.getElementById("body"), {
            lineNumbers: true,
            mode: "text/html",
            matchBrackets: true,
        });
        editor.on('change', (editor) => {
            var text = editor.doc.getValue();
            if (text != '') {
                $("#body").get(0).setCustomValidity('');
                $("#body").next('label').remove();
                $('#body').text(text);
            }
        });

        var j;
        var length = $('#nthLoop').attr('data-rel');
        for (j = 1; j <= length - 1; j++) {
            var translateEditor = CodeMirror.fromTextArea(document.getElementById("translateBody-" + j), {
                lineNumbers: true,
                mode: "text/html",
                matchBrackets: true,
            });
        }
    }

  if ($('.main-body .page-wrapper').find('#email-template-edit-container').length) {
    $(".previewButton").on('click', function (e) {
      var emailBodyContent = editor.getValue();
      emailBodyContent = emailBodyContent.replaceAll('script', 'span');
      $("#preview").html(emailBodyContent);
      $("a").on('click', function () {
        e.preventDefault();
        return false;
        });
      });

    $('#previewModal').on('hidden.bs.modal', function (e) {
      $("a").off('click');
    });
  }

  $(document).on('keyup', '#name', function() {
    var str = this.value.replace(/[&\/\\#@,+()$~%.'":*?<>{}]/g, "");
    $('#slug').val(str.trim().toLowerCase().replace(/\s/g, "-"));
  });

  $(document).on('keyup', '#slug', function() {
    var str = this.value.replace(/[&\/\\#@,+()$~%.'":*?<>{}]/g, "");
    $('#slug').val(str.trim().toLowerCase().replace(/\s/g, "-"));
  });

  $(document).on('click', '#btnSubmit', function() {
    if ($('label').hasClass('error')) {
      $('#information').addClass('active show');
      $('[href="#information"]').tab('show').addClass('active');
      $('#translate').removeClass('active show');
      $('#information').attr('aria-labelledby', 'information-tab');
    }
  });
}

if ($('.main-body .page-wrapper').find('#email-template-list-container').length) {
  $('#dataTableBuilder').addClass('email-template-list');
}
