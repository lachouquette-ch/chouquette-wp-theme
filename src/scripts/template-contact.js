/* Bootstrap imports (once) */
import 'popper.js';
import 'lettering.js';
import 'bootstrap';

import ReCaptcha from './misc/recaptcha';
import $ from "jquery";

// when form is submit
$('#contactForm').submit(function (event) {
    // we stoped it
    event.preventDefault();

    ReCaptcha.load().then(recaptcha => {
        recaptcha.execute('ficheReport').then((token) => {
            // add token to form
            $('#contactForm').prepend('<input type="hidden" name="recaptcha-response" value="' + token + '">');
            // submit form now
            $('#contactForm').unbind('submit').submit();
        });
    });
});