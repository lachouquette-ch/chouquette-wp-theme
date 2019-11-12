require("bootstrap");

import $ from 'jquery';

import ReCaptcha from '../misc/recaptcha';

$('#ficheReportModal').on('show.bs.modal', element => {
    // get data-id attribute of the clicked element
    var ficheTitle = $(element.relatedTarget).data('fiche-title');
    var ficheId = $(element.relatedTarget).data('fiche-id');

    // populate modal
    $(element.currentTarget).find('#ficheReportModalTitle').text(ficheTitle);
    $(element.currentTarget).find('#ficheReportModalId').val(ficheId);
});

$('#ficheContactModal').on('show.bs.modal', element => {
    // get data-id attribute of the clicked element
    var ficheTitle = $(element.relatedTarget).data('fiche-title');
    var ficheId = $(element.relatedTarget).data('fiche-id');

    // populate modal
    $(element.currentTarget).find('#ficheContactModalTitle').text(ficheTitle);
    $(element.currentTarget).find('#ficheContactModalId').val(ficheId);
});

$('#ficheReportForm').submit(event => {
    // we stoped it
    event.preventDefault();
    // needs for recaptacha ready
    ReCaptcha.load().then(recaptcha => {
        recaptcha.execute('ficheReport').then((token) => {
            // add token to form
            $('#ficheReportForm').prepend('<input type="hidden" name="recaptcha-response" value="' + token + '">');
            // submit form now
            $('#ficheReportForm').unbind('submit').submit();
        });
    });
});

$('#ficheContactForm').submit(event => {
    // we stoped it
    event.preventDefault();
    // needs for recaptacha ready
    ReCaptcha.load().then(recaptcha => {
        recaptcha.execute('ficheContact').then((token) => {
            // add token to form
            $('#ficheContactForm').prepend('<input type="hidden" name="recaptcha-response" value="' + token + '">');
            // submit form now
            $('#ficheContactForm').unbind('submit').submit();
        });
    });
});