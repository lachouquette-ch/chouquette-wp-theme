// Polyfill (import once !)
import "@babel/polyfill";

/* Bootstrap imports */
require("popper.js");
require("lettering.js");
require("bootstrap");

/* CSS imports */
require("../styles/main.scss");

/* Run global app script */
import ShowOnce from './misc/show-once';
import $ from 'jquery';

const confidentialityOnce = new ShowOnce("confidentialityWarningAccepted");
const newsletterOnce = new ShowOnce("newsletterModalShown");

let confidentialityElt;
export function closeConfidentiality() {
    confidentialityElt.hide(800);
    confidentialityOnce.setAsShown();
}

$(function () {
    // trigger modals
    confidentialityElt = $("#confidentialityWarning");

    // force focus for modal
    const newsLetterElt = $("#newsletterModal");
    $("#newsletterModal").on("shown.bs.modal", function () {
        $(this).find("input:first-of-type").focus();
    })

    confidentialityOnce.asyncShow(() => confidentialityElt.show(1200));
    if (confidentialityOnce.hasBeenShown()) {
        newsletterOnce.asyncShow(() => {
            newsLetterElt.modal("show");
            newsletterOnce.setAsShown();
        }, 1500);
    }

    removeEmptyFieldsFromForms();
})

function removeEmptyFieldsFromForms() {
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
        $("form").find(":input").prop("disabled", false);
    }

    $(window).bind("onunload", cleanForm);
    // for BFCache navigator (Firefox/Safari)
    $(window).bind("pagehide", cleanForm);
}