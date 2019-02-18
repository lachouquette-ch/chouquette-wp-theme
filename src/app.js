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
});