$("#navigation a.click").on("click", function (e) {
    var closest_ul = $(this).closest("ul");
    var active_links = closest_ul.find(".active");
    var closest_li = $(this).closest("li");
    var status = closest_li.hasClass("active");
    var count = 0;
    $(this).toggleClass("down");
    closest_ul.find("ul").slideUp(function () {
        if (++count == closest_ul.find("ul").length)
            active_links.removeClass("active");
    });
    if (!status) {
        closest_li.children("ul").slideDown();
        closest_li.addClass("active");
    }
});
