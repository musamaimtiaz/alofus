"use strict";

$(function () {
    let inputNamePrefix;

    $(document).on("select2:select", ".filter-column", function (e) {
        e.stopPropagation();

        inputNamePrefix = $(this)
            .closest(".filter-query-container")
            .data("prefix");

        let option = $(this).val();

        let type = queryType(
            $(this)
                .closest(".filter-query-container")
                .find(".filter-type")
                .val()
        );

        if (!queryOperations[type].hasOwnProperty(option)) {
            return;
        }

        let operationOptions =
            type === "query"
                ? generateOptions(queryOperations.query[option])
                : generateOrderOptions();

        let containerClass = type === "query" ? "operation" : "order";

        let replacingClass = type === "query" ? "order" : "operation";

        $(this)
            .closest(".filter-query-container")
            .find(".filter-" + replacingClass + "-container")
            .removeClass("filter-" + replacingClass + "-container")
            .addClass("filter-" + containerClass + "-container");

        $(this)
            .closest(".filter-query-container")
            .find(".filter-" + containerClass + "-container")
            .html(operationOptions);

        $(this)
            .closest(".filter-query-container")
            .find(".filter-" + containerClass)
            .select2();

        $(this)
            .closest(".filter-query-container")
            .find(".filter-value-container")
            .html("");
    });

    const generateOrderOptions = () => {
        return `
            <select class="select2 filter-order" name="${nameWithPrefix(
                "order"
            )}">
                <option value="asc">${jsLang("ASC")}</option>
                <option value="desc">${jsLang("DESC")}</option>
            </select>
        `;
    };

    const getQueryType = (input) => {
        return queryType($(input).val());
    };

    const queryType = (name) => {
        return name === "where" || name === "orWhere" ? "query" : "order";
    };

    $(document).on("select2:selecting", ".filter-type", function (e) {
        $(this).attr("data-prev", $(this).val());
    });

    $(document).on("select2:select", ".filter-type", function (e) {
        e.stopPropagation();

        if (
            $(this).attr("data-prev") &&
            queryType($(this).attr("data-prev")) == queryType($(this).val())
        ) {
            return;
        }

        inputNamePrefix = $(this)
            .closest(".filter-query-container")
            .data("prefix");

        let type = getQueryType(this);

        if (!queryOperations.hasOwnProperty(type)) {
            return;
        }

        let operationOptions = generateColumns(queryOperations[type]);

        $(this)
            .closest(".filter-query-container")
            .find(".filter-column-container")
            .html(operationOptions);

        $(this)
            .closest(".filter-query-container")
            .find(".filter-column")
            .select2({});

        $(this)
            .closest(".filter-query-container")
            .find(
                ".filter-value-container, .filter-order-container, .filter-operation-container"
            )
            .html("");
    });

    const generateColumns = (columns) => {
        let select = `<select class="select2 filter-column" name="${nameWithPrefix(
            "column"
        )}">`;

        select += `<option value="" selected disabled>${jsLang(
            "Column"
        )}</option>`;

        for (const col in columns) {
            select += `<option value="${col}">${columns[col].name}</option>`;
        }
        return (select += `</select>`);
    };

    const generateOptions = (operation) => {
        let operations = operation.operations;

        let options = `<select class="select2 filter-operation" name="${nameWithPrefix(
            "operation"
        )}">`;

        options += `<option value="" selected disabled>${jsLang(
            "Operation"
        )}</option>`;
        for (const opName in operations) {
            options += createSingleOption(operations[opName]);
        }

        options += `</select>`;

        return options;
    };

    const createSingleOption = (option) => {
        return templateOptionField(option);
    };

    const templateOptionField = (option) => {
        return `<option value="${option.value}">${option.name}</option>`;
    };

    const nameWithPrefix = (name) => {
        return `${inputNamePrefix}[${name}]`;
    };

    const generateInputBox = (inputContainer) => {
        let input = inputContainer.input;

        let inputNode;

        if (input.type == "select") {
            if (input.ajax == true) {
                input.class += ` has-ajax-query`;
            }

            inputNode = generateSelectField(input);

            if (input.options) {
                $(inputNode).append(generateSelectOptions(input));
            }
        } else if (input.type == "date") {
            inputNode = generateDateInputBox(input);
        }

        return inputNode;
    };

    const generateDateInputBox = (input) => {
        return `
            <input class="single-date-picker form-control filter-value ${
                input.class
            }" placeholder="${input.placeholder}" name="${nameWithPrefix(
            "value"
        )}">
        `;
    };

    const updateDateField = (container) => {
        $(container)
            .find(".single-date-picker")
            .daterangepicker(
                clearableDateRangePickerConf({
                    autoUpdateInput: true,
                    showDropdowns: true,
                    minDate: null,
                })
            );
    };

    const generateSelectOptions = (input) => {
        let options = "";
        for (const key in input.options) {
            options += `<option value="${key}">${input.options[key]}</option>`;
        }
        return options;
    };

    const generateSelectField = (select) => {
        return $(
            `<select class="select2 filter-value ${
                select.class
            }" placeholder="${select.placeholder ?? ""}" name="${
                nameWithPrefix("value") +
                (select.multiple == "multiple" ? "[]" : "")
            }" ${select.multiple == "multiple" ? "multiple" : ""}></select>`
        );
    };

    $(document).on("select2:select", ".filter-operation", function () {
        let column = $(this)
            .closest(".filter-query-container")
            .find(".filter-column")
            .val();

        inputNamePrefix = $(this)
            .closest(".filter-query-container")
            .data("prefix");

        let operation = $(this).val();

        let inputOption = queryOperations.query[column].operations[operation];

        if (!inputOption == undefined) {
            return;
        }

        let input = generateInputBox(inputOption);

        $(this)
            .closest(".filter-query-container")
            .find(".filter-value-container")
            .html(input);

        postProcessInputField($(this).closest(".filter-query-container"));
    });

    const postProcessInputField = (container) => {
        let inputField = $(container).find(".filter-value");
        if (inputField.hasClass("has-ajax-query")) {
            let query = getQueryStrings(container);
            $(container)
                .find(".filter-value")
                .select2({
                    ajax: {
                        url: ajaxResourceUrl + query,
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
                                results: results,
                            };
                        },
                        cache: true,
                    },
                    placeholder: jsLang("Search by name"),
                    minimumInputLength: 3,
                    tags: false,
                });
        } else if (inputField.hasClass("single-date-picker")) {
            updateDateField(container);
        } else if (inputField.hasClass("select2")) {
            $(container).find(".filter-value").select2({});
        }
    };

    const getQueryStrings = (container) => {
        let query = "?";

        query += `column=${encodeURIComponent(
            $(container).find(".filter-column").val()
        )}`;

        return query;
    };

    $(".filter-query-container").each(function () {
        postProcessInputField(this);
    });

    $(document).on("click", ".__query.add-row-btn", function () {
        let index = $(this).data("index");

        if (index == undefined) {
            return;
        }

        let row = $(queryRowHTML({ index: parseInt(index) }));

        $(this).closest(".filter-query-container").parent().append(row);

        $(row).find(".select2").select2({});

        if (
            $(this).closest(".accordion-action-group").find(".remove-row-btn")
                .length == 0
        ) {
            $(removeQueryRowButton(index)).insertAfter($(this));
        }

        $(this).remove();
    });

    const queryRowHTML = (data = {}) => {
        return data.index == undefined
            ? false
            : `
    <div class="card mb-3 filter-query-container" data-prefix="query[${
        data.index
    }]" data-next="${data.index + 1}">
                    <div class="card-header p-2" id="headingOne">
                        <div class="mb-0 row">
                            <div class="col-md-2 col-12 filter-type-container">
                                <select name="query[${
                                    data.index
                                }][type]" class="select2 filter-type">
                                <option value="" disabled selected>${jsLang(
                                    "Query"
                                )}</option>
                                    <option value="where">${jsLang(
                                        "Where"
                                    )}</option>
                                    <option value="orWhere">${jsLang(
                                        "Or Where"
                                    )}</option>
                                    <option value="orderBy">${jsLang(
                                        "Order By"
                                    )}</option>
                                </select>
                            </div>
                            <div class="col-md-4 col-12 filter-column-container">
                            </div>
                            <div class="col-md-2 col-12 filter-operation-container">
                            </div>
                            <div class="col-md-4 col-12 filter-value-container">
                            </div>
                            <span class="b-icon">
                                <span class="accordion-action-group">
                                    <span class="accordion-row-action add-row-btn __query __private"
                                        data-index="${
                                            data.index + 1
                                        }"><i class="feather icon-plus"></i>
                                    </span>
                                    <span class="accordion-row-action remove-row-btn __private __query"  data-index="${
                                        data.index + 1
                                    }"><i class="feather icon-minus"></i>
                                    </span>
                                </span>
                            </span>
                        </div>
                    </div>
                </div>
    `;
    };

    const removeQueryRowButton = (index) => {
        return `<span class="accordion-row-action remove-row-btn __private __query"  data-index="${
            index + 1
        }"><i class="feather icon-minus"></i>
    </span>`;
    };

    const addQueryRowButton = (index) => {
        return `<span class="accordion-row-action add-row-btn __query __private"
            data-index="${index + 1}"><i class="feather icon-plus"></i>
        </span>`;
    };

    $(document).on("click", ".__query.remove-row-btn", function () {
        if (
            $(this).closest(".accordion-action-group").find(".add-row-btn")
                .length > 0
        ) {
            let index = parseInt($(this).data("index"));

            let previousCardActionGroup = $(this)
                .closest(".filter-query-container")
                .prev()
                .find(".accordion-action-group");

            previousCardActionGroup.append(addQueryRowButton(index));
        }
        let accordions = $(this).closest(".accordion").children();

        $(this).closest(".filter-query-container").remove();

        if (accordions.length === 2) {
            accordions.find(".remove-row-btn").remove();
        }
    });
});
