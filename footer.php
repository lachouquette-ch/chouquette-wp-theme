<footer class="footer container-fluid text-center">
    <div class="footer-top row pt-4">
        <div class="col">
            <?php
            $custom_logo_id = get_theme_mod('custom_logo');
            $logo = wp_get_attachment_image_src($custom_logo_id, 'medium');
            if (has_custom_logo()) {
                echo sprintf('<img class="mx-auto" src="%s">', esc_url($logo[0]));
            }
            ?>
            <p class="my-3">
                <?php
                $menu_args = array(
                    'theme_location' => CQ_FOOTER_MENU,
                    'menu_class' => 'footer-top-menu px-2'
                );
                wp_nav_menu($menu_args);
                ?>
            </p>
        </div>
    </div>
    </div>
    <div class="footer-bottom row py-3">
        <div class="col">
            <span>Copyright 2014-2019 - Tous droits réservés à La Chouquette. Toutes les images et le contenu sont la propriété du site.</span>
        </div>
    </div>
</footer>

<script type='text/javascript' src='//s3.amazonaws.com/downloads.mailchimp.com/js/mc-validate.js'></script>
<script type='text/javascript'>(function ($) {
        window.fnames = new Array();
        window.ftypes = new Array();
        fnames[0] = 'EMAIL';
        ftypes[0] = 'email';
        fnames[1] = 'FNAME';
        ftypes[1] = 'text';
        fnames[2] = 'LNAME';
        ftypes[2] = 'text';

        $.extend($.validator.messages, {
            required: "Ce champ est requis.",
            remote: "Veuillez remplir ce champ pour continuer.",
            email: "Veuillez entrer une adresse email valide.",
            url: "Veuillez entrer une URL valide.",
            date: "Veuillez entrer une date valide.",
            dateISO: "Veuillez entrer une date valide (ISO).",
            number: "Veuillez entrer un nombre valide.",
            digits: "Veuillez entrer (seulement) une valeur numérique.",
            creditcard: "Veuillez entrer un numéro de carte de crédit valide.",
            equalTo: "Veuillez entrer une nouvelle fois la même valeur.",
            accept: "Veuillez entrer une valeur avec une extension valide.",
            maxlength: $.validator.format("Veuillez ne pas entrer plus de {0} caractères."),
            minlength: $.validator.format("Veuillez entrer au moins {0} caractères."),
            rangelength: $.validator.format("Veuillez entrer entre {0} et {1} caractères."),
            range: $.validator.format("Veuillez entrer une valeur entre {0} et {1}."),
            max: $.validator.format("Veuillez entrer une valeur inférieure ou égale à {0}."),
            min: $.validator.format("Veuillez entrer une valeur supérieure ou égale à {0}.")
        });
    }(jQuery));
    var $mcj = jQuery.noConflict(true);
</script>

<?php wp_footer(); ?>

<!-- needs jquery -->
<script type='text/javascript' src='https://www.google.com/recaptcha/api.js?render=<?php echo CQ_RECAPTCHA_SITE ?>'></script>
<script type='text/javascript'>
    grecaptcha.ready(function () {
        // not all paged needs it so tries to find the recaptchaEnabler in current page
        if (typeof recaptchaEnabler === "function") {
            recaptchaEnabler();
        }
    });
</script>

</body>
</html>
