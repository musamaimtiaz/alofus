"use strict";

$(function () {
    var $inboxContainer = $(".chat-view-container");

    var formData;

    var messageRefreshTimer;

    let lastMessageActivityDuration = new Date().getTime();

    var temporaryText = "";

    /**
     * Starts and reschedules message refresh timer
     */
    const updateMessageRefreshTimer = () => {
        window.clearTimeout(messageRefreshTimer);
        messageRefreshTimer = setTimeout(function () {
            refreshChatMessage();
        }, 15000);
    };

    /**
     * Check the last message activity of the user
     * @return boolean
     */
    const isMessageActivityExpired = () => {
        return (new Date().getTime() - lastMessageActivityDuration) / 1000 > 10; // 10 seconds
    };

    /**
     * Updates user last message activity
     * @return void
     */
    $(document).on("click keyup", "#message-to-send", function (e) {
        updateMessageLastActivity();
    });

    /**
     * Updates the last activity time to current time
     */
    const updateMessageLastActivity = () => {
        lastMessageActivityDuration = new Date().getTime();
    };

    /**
     * Starts message refresher only if user is logged in
     */
    if (typeof userLoggedIn === "undefined" || userLoggedIn == true) {
        setTimeout(() => {
            updateMessageRefreshTimer();
        }, 15000);
    }

    /**
     * Toggles user sidebar
     */
    $(document).on("click", ".chat-inbox-sidebar-toggle", function () {
        $(".chat-view-sidebar").toggleClass("chat-header-sidebar-mobile");
    });

    /**
     * Search user from users list
     */
    $(document).on("keyup", ".chat-sidebar-topbar-input", function () {
        var value = $(this).val();
        $inboxContainer.find(".chat-sidebar-user-name").filter(function () {
            $(this)
                .closest(".chat-sidebar-user")
                .toggle($(this).text().toLowerCase().indexOf(value) > -1);
        });
    });

    /**
     * Toggles chat container
     */
    $(document).on("click", ".chat-toggle-button", function () {
        $(this).toggleClass("chat-hidden");
        $(".chat-view-container").toggleClass("chat-hidden");
    });

    /**
     * CLoses chat container
     */
    $(document).on("click", ".chat-view-close-button", function () {
        $(".chat-toggle-button").trigger("click");
    });

    /**
     * Triggers user selection
     */
    $(document).on("click", ".chat-sidebar-user", function () {
        handleUserSelection($(this));
    });

    /**
     * Handles user selection event
     * @param {*} user
     */
    const handleUserSelection = (user) => {
        let url = $(user).data("url");

        temporaryText = $("#message-to-send").val();

        userStateUpdate(user);

        refreshInitiated();

        makeAjaxCall(
            url,
            {},
            { success: handleConversationRequest, complete: refreshCompleted }
        );
    };

    /**
     * Starts message sending event
     */
    const messageSendInitiated = () => {
        $(".chat-view-container").addClass("message-state-loading");
        $("#message_form").find("input,textarea").prop("disabled", true);
    };

    /**
     * Stops message sending event
     */
    const messageSendCompleted = () => {
        $(".chat-view-container").removeClass("message-state-loading");
        $("#message_form").find("input").prop("disabled", false);
    };

    /**
     * Message refresh event initiated
     */
    const refreshInitiated = () => {
        $(".chat-view-container").addClass("chat-inbox-refreshing");
    };

    /**
     * Message refresh event completed
     */
    const refreshCompleted = () => {
        $(".chat-view-container").removeClass("chat-inbox-refreshing");
    };

    /**
     * Scrolls inbox list to the bottom
     * @param {?number} duration
     */
    const scrollInboxItems = (duration = 100) => {
        setTimeout(() => {
            let div = $(".chat-inbox-body");
            div.scrollTop(div.prop("scrollHeight"));
        }, duration);
    };

    /**
     * Handle new message send successful event
     * @param {*} params
     * @param {*} response
     */
    const handleConversationRequest = (params, response) => {
        temporaryText = $("#message-to-send").val();

        updateInboxView(response.records.html);

        $(document).on("#chat-history-list", "scroll", function () {
            if ($(this).scrollTop() === 0) {
                lazyLoadInitiate($(this));
            }
        });

        $("#message-to-send").val(temporaryText);
        $("#message-to-send").trigger("focus");

        temporaryText = "";

        scrollInboxItems();
    };

    /**
     * Updates inbox items
     * @param {*} html
     */
    const updateInboxView = (html) => {
        $(".chat-view-body").find(".chat-view-inbox").remove();
        $(".chat-view-body").append(html);
    };

    /**
     * Updates users state after selecting one user
     * @param {*} user
     */
    const userStateUpdate = (user) => {
        $(".chat-sidebar-user").removeClass("chat-user-active");
        $(user).removeClass("chat-inbox-unread");
        $(user).addClass("chat-user-active");
    };

    /**
     * Handles sending product as message action
     */
    $(document).on("click", "#chat-initiate-vendor", function () {
        if (!$(".chat-toggle-button").hasClass("chat-hidden")) {
            $(".chat-toggle-button").trigger("click");
        }

        makeAjaxCall(
            $(this).data("vendor"),
            {},
            {
                success: handleShopChatInitialize,
            }
        );
    });

    const handleShopChatInitialize = (params, response) => {
        updateMessageRefreshTimer();

        $("body").trigger("chat-count-refreshed", [response.records.unread]);

        $inboxContainer.find(".chat-view-sidebar .chat-sidebar-users").remove();

        $inboxContainer
            .find(".chat-view-sidebar")
            .append(response.records.users);

        updateInboxView(response.records.box);

        $(document).on("#chat-history-list", "scroll", function () {
            if ($(this).scrollTop() === 0) {
                lazyLoadInitiate($(this));
            }
        });

        scrollInboxItems();
    };

    /**
     * Handles sending product as message action
     */
    $(document).on("click", ".send-item-message", function () {
        if (!$(".chat-toggle-button").hasClass("chat-hidden")) {
            $(".chat-toggle-button").trigger("click");
        }

        makeAjaxCall(
            $(this).data("vendor"),
            {},
            {
                success: productChatHandler,
            }
        );
    });

    /**
     * Handles sending product as a message successful event
     * @param {*} params
     * @param {*} response
     */
    const productChatHandler = (params, response) => {
        // Updating users list
        $(".chat-sidebar-users").remove();
        $(".chat-view-sidebar").append(response.records.users);

        // Updating inbox
        $(".chat-view-inbox").remove();
        $(".chat-view-body").append(response.records.html);

        $inboxContainer
            .find(".chat-user-active .chat-sidebar-user-text")
            .html(jsLang("You") + ": " + jsLang("Product sent."));

        scrollInboxItems(100);
    };

    /**
     * Listens to 'enter' press while typing message to submit the form
     */
    $(document).on("keyup", "#message-to-send", function (e) {
        if (e.keyCode === 13 && !e.shiftKey) {
            $("#message-form").trigger("submit");
        }
    });


    /**
     * Submit the message form when the send button is clicked
     */
    $(document).on("click", ".chat-inbox-send-button", function (e) {
        $("#message-form").trigger("submit");
    });


    /**
     * Handles submitting message form
     */
    $(document).on("submit", "#message-form", function (e) {
        e.preventDefault();

        // generates form data for sending http request
        formData = new FormData($(this)[0]);

        // Get message from text box and the attachments
        let name = filterXSS($("#message-to-send").val().trim());
        let attachment = $("#attachment-msg").val().trim();

        // returns void if message and attachment both are empty
        if (!(name || attachment)) {
            return;
        }

        // Append csrf token and chat id with the request data
        formData.append("_token", token);
        formData.append("thread_id", $(".chat-identifier").val());

        // reset the message form
        $("#message-to-send").val("");
        $(this).trigger("reset");

        // Starting message sending state
        messageSendInitiated();

        // Make ajax call to send the message
        makeAjaxCall(
            $(this).attr("action"),
            {},
            {
                success: sendMessageHandler,
                failed: sendMessageFailedHandler,
                type: "post",
                formData: formData,
                callbackParam: { message: name ?? attachment },
            }
        );
    });

    /**
     * Handles attachment
     */
    $(document).on("change", "#attachment-msg", function () {
        // Set the attachment name as message
        $("#message-to-send").val($(this)[0].files[0].name);
        // Triggers the message form to submit
        $("#message-form").trigger("submit");
    });

    /**
     * Handles successful message sending event
     * @param {*} params
     * @param {*} response
     */
    const sendMessageHandler = (params, response) => {
        messageSendCompleted();

        $inboxContainer
            .find(".chat-inbox-message-list")
            .append(response.records.html);

        $inboxContainer
            .find(".chat-user-active .chat-sidebar-user-text")
            .html(jsLang("You") + ": " + params.message);

        scrollInboxItems();
    };

    /**
     * Handles message sending failed event
     * @param {*} xhr
     * @param {*} status
     * @param {*} error
     */
    const sendMessageFailedHandler = (xhr, status, error) => {
        messageSendCompleted();

        let errResponse = JSON.parse(xhr.responseText);

        let messages = [];

        let errList = "";

        if (errResponse?.errors == undefined) {
            errList = `<li>${jsLang("Attachment failed")}</li>`;
        } else {
            // Renders all the error messages from server
            for (let key in errResponse?.errors) {
                if (Array.isArray(errResponse.errors[key])) {
                    messages.push(...errResponse.errors[key]);
                }
            }
            messages.forEach((element) => {
                errList += `<li>${element}</li>`;
            });
        }

        $(".chat-error-message ul").html(errList);

        $(".chat-error-message").addClass("chat-error-show");

        setTimeout(() => {
            $(".chat-error-message").removeClass("chat-error-show");
            $(".chat-error-message ul").html("");
        }, 4000);
    };

    /**
     * Triggers message reload event
     */
    $(document).on("click", ".chat-inbox-sidebar-reload", function () {
        refreshChatMessage(true);
    });

    /**
     * Handles message refresh event
     * @param {*} force
     * @returns
     */
    const refreshChatMessage = (force = false) => {
        const $activeUser = $(".chat-sidebar-user.chat-user-active");

        /**
         * If the browser tab is not active then reschedule the refresher
         * and return void
         */
        if (!force && (document.hidden || !isMessageActivityExpired())) {
            updateMessageRefreshTimer();
            return;
        }

        let data = {
            cid: $activeUser.attr("id"),
        };

        refreshInitiated();

        makeAjaxCall($inboxContainer.data("refreshurl") + `?cid=${data.cid}`, data, {
            success: handleInboxRefresher,
            failed: handleRefreshFailed,
            complete: refreshCompleted,
        });
    };

    /**
     * Re-render updated messages and triggers message update events
     * @param {*} params
     * @param {*} response
     */
    const handleInboxRefresher = (params, response) => {
        $("body").trigger("chat-count-refreshed", [response.records.unread]);

        $inboxContainer.find(".chat-view-sidebar .chat-sidebar-users").remove();

        $inboxContainer
            .find(".chat-view-sidebar")
            .append(response.records.users);

        let id = $(".chat-sidebar-user.chat-user-active").attr("id");

        if (id) {
            if ($inboxContainer.hasClass("chat-hidden")) {
                $inboxContainer.find(`#${id}`).addClass("chat-user-active");
            } else {
                $inboxContainer.find(`#${id}`).trigger("click");
            }
        }

        updateMessageRefreshTimer();
    };

    /**
     * Handles unread message count update event
     */
    $(document).on("chat-count-refreshed", "body", function (e, data) {
        let count = $(".chat-sidebar-user.chat-inbox-unread").length;

        count = Math.max(count, data);

        if (count > 0) {
            $(".chat-unread-count").html(count).addClass("d-flex").removeClass("d-none");
        } else {
            $(".chat-unread-count").html("0").addClass("d-none").removeClass("d-flex");
        }
    });

    /**
     * Handles userlist  refresh event
     */
    $(document).on("chat-users-refreshed", "body", function (e, data) {
        $inboxContainer.find(".chat-view-sidebar .chat-sidebar-users").remove();
        $inboxContainer.find(".chat-view-sidebar").append(data);
    });

    /**
     * Handle refresh failed event
     * @param {*} params
     * @param {*} response
     */
    const handleRefreshFailed = (params, response) => {
        if (response?.message == "Unauthenticated") {
            window.clearTimeout(messageRefreshTimer);
        }

        updateMessageRefreshTimer();
    };

    // $(document).on("users-updated", ".")

    /**
     * @param {string} _url Request url
     * @param {object} _data Data needed to pass along
     * @param {*} _options={method,datatype,success,failed,callbackParam}
     * @ _options: {
     * @    type: get ["get", "post"]
     * @    dataType: "json" [String]
     * @    success: undefined [Callback]
     * @    failed: Closure [Callback]
     * @    callbackParam: false [Any]
     * @    formData: false
     * @ }
     */
    function makeAjaxCall(_url, _data = {}, _options = {}) {
        // Default options and post data
        let { defaults, data } = {
            defaults: {
                type: "get",
                dataType: "json",
                processData: false,
                contentType: false,
                success: undefined,
                failed: defaultFailedHandler,
                complete: undefined,
                callbackParam: false,
                formData: false,
            },
            data: { _token: token },
        };

        // Overrides default options with the arguments option
        defaults = Object.assign({}, defaults, _options);

        if (defaults.formData) {
            data = defaults.formData;
        } else {
            data = Object.assign({}, data, _data);
        }

        // Send ajax http request
        $.ajax({
            url: _url,
            type: defaults.type,
            processData: defaults.processData,
            contentType: defaults.contentType,
            data: data,
            success: function (data) {
                if (defaults.success) {
                    defaults.success(defaults.callbackParam, data.response);
                } else {
                }
            },
            error: function (xhr, status, error) {
                if (defaults.failed) {
                    defaults.failed(xhr, status, error);
                } else {
                    defaultFailedHandler(xhr, status, error);
                }
            },
            complete: function (xhr, status) {
                if (defaults.complete) {
                    defaults.complete(xhr, status);
                }
            },
        });
    }

    /**
     * Default failed request handler
     */
    const defaultFailedHandler = (xhr, status, error) => {
        temporaryText = "";
        throw error;
    };
});
