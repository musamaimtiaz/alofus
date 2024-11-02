"use strict";

let titles = document.querySelectorAll('.accordion__button');
for (let i = 0; i < titles.length; i++) {
    titles[i].addEventListener('click', e => {
        for (let x of titles) {
            if (x !== e.target) {
                x.classList.remove('accordion__button--active');
                x.nextElementSibling.style.maxHeight = 0;
                x.nextElementSibling.style.padding = 0;
            }
        }
        e.target.classList.toggle('accordion__button--active');
        let description = e.target.nextElementSibling;

        if (e.target.classList.contains('accordion__button--active')) {
            description.style.maxHeight = description.scrollHeight + 'px';
        } else {
            description.style.maxHeight = 0;
            description.style.padding = 0;
        }
    });
}
