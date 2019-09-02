grecaptcha.ready(function () {
    grecaptcha.execute(CQ_RECAPTCHA_SITE, {action: 'contact'}).then(function (token) {
        var elements = document.getElementsByName("recaptcha-response");
        for (i = 0; i < elements.length; i++) {
            elements[i].value = token;
        }
    });
});