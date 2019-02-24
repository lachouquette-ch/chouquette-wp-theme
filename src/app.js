/* JS imports */
require("jquery");
require("popper.js");
require("lettering.js");
require("textillate");
require("swiper");
require("swiper/dist/css/swiper.css");
require("bootstrap-select");
require("bootstrap");

import Swiper from 'swiper';

/* CSS imports */
require("./styles/main.scss");

jQuery(function ($) {
    // activate textillate
    $('.tlt').textillate();

    // bootstrap-select specify bootstrap version
    $.fn.selectpicker.Constructor.BootstrapVersion = '4';
    $('.selectpicker').selectpicker({
        iconBase: 'fa',
        tickIcon: 'fa-check'
    });

    // activate swiper
    var swiper = new Swiper('.swiper-container', {
        slidesPerView: 3,
        spaceBetween: 40,
        grabCursor: true,
        centeredSlides: true,
        loop: true,
        navigation: {
            nextEl: '.swiper-button-next',
            prevEl: '.swiper-button-prev',
        },
        breakpoints: {
            992: {
                slidesPerView: 2,
                spaceBetween: 30,
                grabCursor: true,
                centeredSlides: true,
            }
        }
    });
});