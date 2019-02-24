/* JS imports */
require("jquery");
require("popper.js");
require("lettering.js");
require("textillate");
require("bootstrap-select");
require("bootstrap");

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
        slidesPerView: 4,
        spaceBetween: 40,
        grabCursor: true,
        centeredSlides: true,
        loop: true,
        navigation: {
            nextEl: '.swiper-button-next',
            prevEl: '.swiper-button-prev',
        },
        breakpoints: {
            1024: {
                slidesPerView: 4,
                spaceBetween: 40,
            },
            768: {
                slidesPerView: 3,
                spaceBetween: 30,
            },
            640: {
                slidesPerView: 2,
                spaceBetween: 20,
            },
            320: {
                slidesPerView: 1,
                spaceBetween: 10,
            }
        }
    });
});