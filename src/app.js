/* JS imports */
require("jquery");
require("popper.js");
require("lettering.js");
require("textillate");
require("swiper");
require("swiper/dist/css/swiper.css");
require("bootstrap");
require("bootstrap-select");
require("bootstrap-select/dist/js/i18n/defaults-fr_FR");

import Swiper from 'swiper';

/* CSS imports */
require("./styles/main.scss");

jQuery(function ($) {
    // activate textillate
    $('.tlt').textillate();

    // activate swiper
    var swiper = new Swiper('.swiper-container', {
        grabCursor: true,
        centeredSlides: true,
        loop: true,
        slidesPerView: 1,
        spaceBetween: 10,
        autoplay: {
            delay: 3000,
            disableOnInteraction: false,
        },
        navigation: {
            nextEl: '.swiper-button-next',
            prevEl: '.swiper-button-prev',
        },
        // Responsive breakpoints (based on bootstrap breakpoints)
        breakpointsInverse: true,
        breakpoints: {
            576: {
                slidesPerView: 2,
                spaceBetween: 10,
            },
            768: {
                slidesPerView: 2,
                spaceBetween: 20,
            },
            992: {
                slidesPerView: 3,
                spaceBetween: 30,
            },
            1200: {
                slidesPerView: 4,
                spaceBetween: 30,
            }
        }
    });
});