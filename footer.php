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

<!-- needs jquery -->
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCL4mYyxlnp34tnC57WyrU_63BJhuRoeKI&callback=bootstrapMap" async defer></script>
<script type='text/javascript'>
    const MAP_STYLES = [
        {
            "featureType": "poi.business",
            "stylers": [
                {"visibility": "off"}
            ]
        },
    ];

    const SWITZERLAND_BOUNDS = {
        north: 48.5744540832,
        south: 45.3980935767,
        west: 4.3880763722,
        east: 11.93019063
    };
    const LAUSANNE_LOCALISATION = {
        lat: 46.519962,
        lng: 6.633597
    };

    const Z_INDEX_SELECTED = 1000;
    const Z_INDEX_CHOUQUETTISE = 500;
    const Z_INDEX_DEFAULT = 100;

    const ZOOM_LEVEL_ACTIVED = 17;

    function bounce(marker) {
        if (marker.getAnimation()) {
            marker.setAnimation(null);
        } else {
            marker.setAnimation(google.maps.Animation.BOUNCE);
            window.setTimeout(function () {
                marker.setAnimation(null);
            }, 2000);
        }
    };

    function bootstrapMap() {
        // not all paged needs it so tries to find the recaptchaEnabler in current page
        if (typeof initMap === "function") {
            initMap();
        }
    }
</script>

</body>
</html>
