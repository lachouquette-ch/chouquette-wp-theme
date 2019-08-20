/* JS vendor imports */
require("jquery");
require("popper.js");
require("lettering.js");
require("textillate");
require("bootstrap");

/* CSS imports */
require("./styles/main.scss");

/* 3rd parties intialization */
jQuery(function ($) {
    // activate textillate
    $('.tlt').textillate();

    // Remove empty fields from GET forms
    // Author: Bill Erickson
    // URL: http://www.billerickson.net/code/hide-empty-fields-get-form/

    // Change 'form' to class or ID of your specific form
    $("form").submit(function () {
        $(this).find(":input").filter(function () {
            return !this.value;
        }).attr("disabled", "disabled");
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