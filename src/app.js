/* JS vendor imports */
require("popper.js");
require("lettering.js");
require("bootstrap");

/* CSS imports */
require("./styles/main.scss");

/* Overall script */
jQuery(function ($) {
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

    // Trigger newsletter modal on first visit
    setTimeout(function () {
        const newsletterCookieName = "newsletterModalShown";
        const newsletterModal = $("#newsletterModal");
        if (Cookies.get(confidentialityCookieName) && !Cookies.get(newsletterCookieName)) {
            newsletterModal.modal('show');
            Cookies.set(newsletterCookieName, 1, {expires: 365});
        }
    }, 15000);

    $('#newsletterModal').on('shown.bs.modal', function () {
        $('#newsletterModal input:first-of-type').focus();
    })

    // Trigger confidentiality warning
    setTimeout(showConfidentiality, 1000);
});