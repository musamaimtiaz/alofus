"use strict";

window.FormBuilder = window.FormBuilder || {};

window._form_replace_fields = [
    {
        type: "radio-group",
        inline: true,
        label: "Radio",
    },
    {
        type: "checkbox-group",
        inline: true,
        label: "Checkbox Group",
    },
];

jQuery(function () {
    $("#visibility").change(function (e) {
        e.preventDefault();
        var ref = $(this);

        if (ref.val() == "" || ref.val() == "PUBLIC") {
            $("#allows_edit_DIV").addClass("d-none");
        } else {
            $("#allows_edit_DIV").slideDown().removeClass("d-none");
            $("#allows_edit").val("0");
        }
    });

    // create the form editor
    var fbEditor = $(document.getElementById("fb-editor"));
    var formBuilder;
    var fbOptions = {
        dataType: "json",
        formData: window._form_builder_content
            ? window._form_builder_content
            : "",
        controlOrder: [
            "header",
            "paragraph",
            "text",
            "textarea",
            "select",
            "number",
            "date",
            "autocomplete",
            "file",
        ],
        disableFields: [],

        disabledAttrs: ["access", "requireValidOption"],

        typeUserDisabledAttrs: {
            file: ["multiple"],
            "checkbox-group": ["other"],
        },
        disabledSubtypes: {
            textarea: ["tinymce", "quill"],
            file: ["fineuploader"],
            paragraph: ["address", "blockquote", "canvas","output"]
        },

        replaceFields: [
            {
                type: "radio-group",
                inline: true,
                label: "Radio",
            },
            {
                type: "checkbox-group",
                inline: true,
                label: "Checkbox",
            },
        ],
        showActionButtons: false, // show the actions buttons at the bottom
        disabledActionButtons: ["data"], // get rid of the 'getData' button
        sortableControls: false, // allow users to re-order the controls to their liking
        editOnAdd: false,
        fieldRemoveWarn: false,
        roles: null,
        notify: {
            error: function (message) {
                return swal(jsLang("Error"), message, "error");
            },
            success: function (message) {
                return swal(jsLang("Success"), message, "success");
            },
            warning: function (message) {
                return swal(jsLang("Warning"), message, "warning");
            },
        },
        i18n: {
            override: {
               'en-US': {
                    "addOption": jsLang("Add Option") + " +",
                    "allFieldsRemoved": jsLang("All fields were removed."),
                    "allowMultipleFiles": jsLang("Allow users to upload multiple files"),
                    "autocomplete": jsLang("Finish it for me"),
                    "button": jsLang("Button"),
                    "cannotBeEmpty": jsLang("This field cannot be empty"),
                    "checkboxGroup": jsLang("Checkboxes"),
                    "checkbox": jsLang("Checkbox"),
                    "checkboxes": jsLang("Checkboxes"),
                    "className": jsLang("Class"),
                    "clearAllMessage": jsLang("Are you sure you want to clear all fields?"),
                    "clear": jsLang("Remove everything"),
                    "close": jsLang("Close"),
                    "content": jsLang("Content"),
                    "copy": jsLang("Copy To Clipboard"),
                    "copyButton": "&#43;",
                    "copyButtonTooltip": jsLang("Copy"),
                    "dateField": jsLang("Pick a date"),
                    "description": jsLang("Help Text"),
                    "descriptionField": jsLang("Description"),
                    "devMode": jsLang("Developer Mode"),
                    "editNames": jsLang("Edit Names"),
                    "editorTitle": jsLang("Form Elements"),
                    "editXML": jsLang("Edit XML"),
                    "enableOther": "Enable &quot;Other&quot",
                    "enableOtherMsg": jsLang("Let users to enter an unlisted option"),
                    "fieldNonEditable": jsLang("This field cannot be edited."),
                    "fieldRemoveWarning": jsLang("Are you sure you want to remove this field?"),
                    "fileUpload": jsLang("File Upload"),
                    "formUpdated": jsLang("Form Updated"),
                    "getStarted": jsLang("Drag a field from the right to this area"),
                    "header": jsLang("Header"),
                    "hide": jsLang("Edit"),
                    "hidden": jsLang("Hidden Input"),
                    "inline": jsLang("Inline"),
                    "inlineDesc": jsLang("Display {type} inline"),
                    "label": jsLang("Label"),
                    "labelEmpty": jsLang("Field Label cannot be empty"),
                    "limitRole": jsLang("Limit access to one or more of the following roles:"),
                    "mandatory": jsLang("Mandatory"),
                    "maxlength": jsLang("Max Length"),
                    "minOptionMessage": jsLang("This field requires a minimum of 2 options"),
                    "multipleFiles": jsLang("Multiple Files"),
                    "name": jsLang("Name"),
                    "no": jsLang("No"),
                    "noFieldsToClear": jsLang("There are no fields to clear"),
                    "number": jsLang("Number"),
                    "off": jsLang("Off"),
                    "on": jsLang("On"),
                    "option": jsLang("Option"),
                    "options": jsLang("Options"),
                    "optional": jsLang("optional"),
                    "optionLabelPlaceholder": jsLang("Label"),
                    "optionValuePlaceholder": jsLang("Value"),
                    "optionEmpty": jsLang("Option value required"),
                    "other": jsLang("Other"),
                    "paragraph": jsLang("Paragraph"),
                    "placeholder": jsLang("Placeholder"),
                    "placeholders.value": jsLang("Value"),
                    "placeholders.label": jsLang("Label"),
                    "placeholders.text": "",
                    "placeholders.textarea": "",
                    "placeholders.email": jsLang("Enter you email"),
                    "placeholders.placeholder": "",
                    "placeholders.className": jsLang("space separated classes"),
                    "placeholders.password": jsLang("Enter your password"),
                    "preview": jsLang("Preview"),
                    "radioGroup": jsLang("Radio Group"),
                    "radio": jsLang("Radio"),
                    "removeMessage": jsLang("Remove Element"),
                    "removeOption": jsLang("Remove Option"),
                    "remove": "&#215;",
                    "required": jsLang("Required"),
                    "richText": jsLang("Rich Text Editor"),
                    "roles": jsLang("Access"),
                    "rows": jsLang("Rows"),
                    "save": jsLang("Save"),
                    "selectOptions": jsLang("Options"),
                    "select": jsLang("Select"),
                    "selectColor": jsLang("Select Color"),
                    "selectionsMessage": jsLang("Allow Multiple Selections"),
                    "size": jsLang("Size"),
                    "size.xs": jsLang("Extra Small"),
                    "size.sm": jsLang("Small"),
                    "size.m": jsLang("Default"),
                    "size.lg": jsLang("Large"),
                    "style": jsLang("Style"),
                    "styles.btn.default": jsLang("Default"),
                    "styles.btn.danger": jsLang("Danger"),
                    "styles.btn.info": jsLang("Info"),
                    "styles.btn.primary": jsLang("Primary"),
                    "styles.btn.success": jsLang("Success"),
                    "styles.btn.warning": jsLang("Warning"),
                    "subtype": jsLang("Type"),
                    "text": jsLang("Text Field"),
                    "textArea": jsLang("Text Area"),
                    "toggle": jsLang("Toggle"),
                    "warning": jsLang("Warning") + "!",
                    "value": jsLang("Value"),
                    "viewJSON": "{  }",
                    "viewXML": "&lt;/&gt;",
                    "yes": jsLang("Yes")
                }
            }
        },
        onSave: function () {},
    };

    formBuilder = fbEditor.formBuilder(fbOptions);

    var fbClearBtn = $(".fb-clear-btn");
    var fbShowDataBtn = $(".fb-showdata-btn");
    var fbSaveBtn = $(".fb-save-btn");

    // setup the buttons to respond to save and clear
    fbClearBtn.click(function (e) {
        e.preventDefault();

        if (!formBuilder.actions.getData().length) return;

        sConfirm(
            jsLang("Are you sure you want to clear all fields from the form?"),
            function () {
                formBuilder.actions.clearFields();
            }
        );
    });

    fbShowDataBtn.click(function (e) {
        e.preventDefault();
        formBuilder.actions.showData();
    });

    fbSaveBtn.click(function (e) {
        e.preventDefault();

        var form = $("#createFormForm");

        // make sure the form is valid
        if (!form.parsley().validate()) return;

        // make sure the form builder is not empty
        if (!formBuilder.actions.getData().length) {
            swal({
                title: jsLang("Error"),
                text: jsLang("The form builder cannot be empty"),
                icon: "error",
            });
            return;
        }

        // ask for confirmation
        sConfirm("Save this form definition?", function () {
            fbSaveBtn.attr("disabled", "disabled");
            fbClearBtn.attr("disabled", "disabled");

            var formBuilderJSONData = formBuilder.actions.getData("json");

            var postData = {
                name: $("#name").val(),
                visibility: $("#visibility").val(),
                allows_edit: $("#allows_edit").val(),
                type: $("#type").val(),
                form_builder_json: formBuilderJSONData,
                _token: window.FormBuilder.csrfToken,
            };

            var method = form.data("formMethod") ? "PUT" : "POST";
            jQuery
                .ajax({
                    url: form.attr("action"),
                    processData: true,
                    data: postData,
                    method: method,
                    cache: false,
                })
                .then(
                    function (response) {
                        fbSaveBtn.removeAttr("disabled");
                        fbClearBtn.removeAttr("disabled");

                        if (response.success) {
                            // the form has been created
                            // send the user to the form index page
                            swal({
                                title: jsLang("Form Saved!"),
                                text: response.details || "",
                                icon: "success",
                            }).then(function() {
                                window.location = response.dest;
                            });

                        } else if (response.status = 'info') {
                            swal({
                                title: response.message,
                                text: response.details || "",
                                icon: "info",
                            });

                        } else {
                            swal({
                                title: jsLang("Error"),
                                text: response.details || jsLang("Error"),
                                icon: "error",
                            });
                        }
                    },
                    function (error) {
                        handleAjaxError(error);

                        fbSaveBtn.removeAttr("disabled");
                        fbClearBtn.removeAttr("disabled");
                    }
                );
        });
    });

    // show the clear and save buttons
    $("#fb-editor-footer").slideDown().removeClass("d-none");
});
