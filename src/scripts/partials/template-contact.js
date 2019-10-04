// when form is submit
$('#contactForm').submit(function (event) {
    // we stoped it
    event.preventDefault();
    // needs for recaptacha ready
    grecaptcha.ready(function () {
        grecaptcha.execute(CQ_RECAPTCHA_SITE, {action: 'contact'}).then(function (token) {
            // add token to form
            $('#contactForm').prepend('<input type="hidden" name="recaptcha-response" value="' + token + '">');
            // submit form now
            $('#contactForm').unbind('submit').submit();
        });
    });
});