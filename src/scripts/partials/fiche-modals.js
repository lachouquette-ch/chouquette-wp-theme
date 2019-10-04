$('#ficheReportModal').on('show.bs.modal', function (e) {
    // get data-id attribute of the clicked element
    var ficheTitle = $(e.relatedTarget).data('fiche-title');
    var ficheId = $(e.relatedTarget).data('fiche-id');

    // populate modal
    $(e.currentTarget).find('#ficheReportModalTitle').text(ficheTitle);
    $(e.currentTarget).find('#ficheReportModalId').val(ficheId);
});

$('#ficheContactModal').on('show.bs.modal', function (e) {
    // get data-id attribute of the clicked element
    var ficheTitle = $(e.relatedTarget).data('fiche-title');
    var ficheId = $(e.relatedTarget).data('fiche-id');

    // populate modal
    $(e.currentTarget).find('#ficheContactModalTitle').text(ficheTitle);
    $(e.currentTarget).find('#ficheContactModalId').val(ficheId);
});

$('#ficheReportForm').submit(function (event) {
    // we stoped it
    event.preventDefault();
    // needs for recaptacha ready
    grecaptcha.ready(function () {
        grecaptcha.execute(CQ_RECAPTCHA_SITE, {action: 'ficheReport'}).then(function (token) {
            // add token to form
            $('#ficheReportForm').prepend('<input type="hidden" name="recaptcha-response" value="' + token + '">');
            // submit form now
            $('#ficheReportForm').unbind('submit').submit();
        });
    });
});

$('#ficheContactForm').submit(function (event) {
    // we stoped it
    event.preventDefault();
    // needs for recaptacha ready
    grecaptcha.ready(function () {
        grecaptcha.execute(CQ_RECAPTCHA_SITE, {action: 'ficheContact'}).then(function (token) {
            // add token to form
            $('#ficheContactForm').prepend('<input type="hidden" name="recaptcha-response" value="' + token + '">');
            // submit form now
            $('#ficheContactForm').unbind('submit').submit();
        });
    });
});