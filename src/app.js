/* JS vendor imports */
require("jquery");
require("popper.js");
require("lettering.js");
require("textillate");
require("swiper");
require("swiper/dist/css/swiper.css");
require("bootstrap");

import Swiper from 'swiper';

/* CSS imports */
require("./styles/main.scss");

/* 3rd parties intialization */
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

    // Remove empty fields from GET forms
    // Author: Bill Erickson
    // URL: http://www.billerickson.net/code/hide-empty-fields-get-form/

    // Change 'form' to class or ID of your specific form
    $("form").submit(function() {
        $(this).find(":input").filter(function(){ return !this.value; }).attr("disabled", "disabled");
        return true; // ensure form still submits
    });

    // Un-disable form fields when page loads, in case they click back after submission
    function cleanForm() {
        console.log("cleanForm");
        $("form").find(":input").prop("disabled", false);
    }
    $(window).bind("onunload", cleanForm);
    // for BFCache navigator (Firefox/Safari)
    $(window).bind("pagehide", cleanForm);
});