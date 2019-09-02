$('#ficheReportModal').on('show.bs.modal', function(e) {
    // get data-id attribute of the clicked element
    var ficheTitle = $(e.relatedTarget).data('fiche-title');
    var ficheId = $(e.relatedTarget).data('fiche-id');

    // populate modal
    $(e.currentTarget).find('#ficheReportModalTitle').text(ficheTitle);
    $(e.currentTarget).find('#ficheReportModalId').val(ficheId);
});

// repaptcha for contact
grecaptcha.ready(function () {
    grecaptcha.execute(CQ_RECAPTCHA_SITE, {action: 'ficheReport'}).then(function (token) {
        var elements = document.getElementsByName("recaptcha-response");
        for (i = 0; i < elements.length; i++) {
            elements[i].value = token;
        }
    });
});