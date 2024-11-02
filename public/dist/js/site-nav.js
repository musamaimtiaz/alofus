"use strict";

    let burger = document.querySelector('.burger');
    let close = document.querySelector('.close');
    let sidenav = document.querySelector('#sidenav');
    let overlay = document.querySelector('#overlay');

    let classOpen = [sidenav, overlay];
    burger.addEventListener('click', function(e){
        classOpen.forEach(e => e.classList.add('active'));
    });

    let classCloseClick = [overlay, close];
    classCloseClick.forEach(function(el) {
        el.addEventListener('click', function(els) {
            classOpen.forEach(els => els.classList.remove('active'));
        });
    });

    $(document).ready(function() {
		$("#accordian a.clicks").click(function() {
				var link = $(this);
				var closest_ul = link.closest("ul");
				var parallel_active_links = closest_ul.find(".active")
				var closest_li = link.closest("li");
				var link_status = closest_li.hasClass("active");
				var count = 0;
                $(this).toggleClass("down");
				closest_ul.find("ul").slideUp(function() {
						if (++count == closest_ul.find("ul").length)
								parallel_active_links.removeClass("active");
				});

				if (!link_status) {
						closest_li.children("ul").slideDown();
						closest_li.addClass("active");
				}
		})
    })


