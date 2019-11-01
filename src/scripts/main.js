import {confidentialityModal, newsletterModal} from './misc/modal-once';
import $ from 'jquery';

$(function () {
    removeEmptyFieldsFromForms();

    // trigger modals
    confidentialityModal.show();
    if (confidentialityModal.isAccepted()) {
        newsletterModal.show();
    }
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

    jQuery(window).bind("onunload", cleanForm);
    // for BFCache navigator (Firefox/Safari)
    jQuery(window).bind("pagehide", cleanForm);
}