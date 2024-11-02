"use strict";
if (
    $(".main-body .page-wrapper").find("#attribute_group-add-container")
        .length ||
    $(".main-body .page-wrapper").find("#attribute_group-edit-container")
        .length ||
    $(".main-body .page-wrapper").find("#attribute-add-container").length ||
    $(".main-body .page-wrapper").find("#attribute-edit-container").length
) {
    var rowid = 2;
    if (
        $(".main-body .page-wrapper").find("#attribute-edit-container").length
    ) {
        rowid = $("#row_id").val();
    }

    if (
        $(".main-body .page-wrapper").find("#attribute-add-container").length ||
        $(".main-body .page-wrapper").find("#attribute-edit-container").length
    ) {
        $("#values").sortable({
            distance: 5,
            delay: 300,
            opacity: 0.6,
            cursor: "move",
        });
    }
    $(document).on("click", "#btnSubmit", function (event) {
        let arr = ["v-pills-home-tab", "v-pills-profile-tab"];
        setTimeout(() => {
            for (const key in arr) {
                let target = $(`.tab-pane[aria-labelledby="${arr[key]}"]`);
                if ($(target).find(".error").length > 0) {
                    $(`#${arr[key]}`).tab('show');
                    break;
                }
            }
        }, 100);
    });

    $(document).on("click", "#add-new-value", function (event) {
        event.preventDefault();
        addAttributeValue();
    });

    function addAttributeValue() {
        let attributValue = `<tr draggable="false" class="" id="rowid-${rowid}">
                                <td class="text-center">
                                    <i class="fa fa-bars"></i>
                                </td>
                                <td>
                                    <div class="form-group">
                                        <input type="text" name="values[]" class="form-control inputFieldDesign" required id="valueChk-${rowid}">
                                        <span id="value-text-${rowid}" class="validationMsg"></span>
                                        <input type="hidden" name="row_identify[]" value="${rowid}">
                                    </div>
                                </td>
                                <td class="text-center">
                                    <button type="button" class="btn btn-xs btn-danger delete-row" data-row-id="${rowid}" data-bs-toggle="tooltip" data-title="Delete Value" data-original-title="" title="">
                                        <i class="feather icon-trash-2"></i>
                                    </button>
                                </td>
                            </tr>`;
        rowid++;
        $("#values").append(attributValue);
    }

    $(document).on("click", ".delete-row", function (e) {
        e.preventDefault();
        var idtodelete = $(this).attr("data-row-id");
        $("#rowid-" + idtodelete).remove();
    });
}
if ($(".main-body .page-wrapper").find("#attribute-list-container").length) {
    // For export csv
    $(document).on("click", "#csv, #pdf", function (event) {
        event.preventDefault();
        window.location = SITE_URL + "/attributes/" + this.id;
    });
}

if (
    $(".main-body .page-wrapper").find("#attribute_group-list-container").length
) {
    // For export csv
    $(document).on("click", "#csv, #pdf", function (event) {
        event.preventDefault();
        window.location = SITE_URL + "/attribute-groups/" + this.id;
    });
}
