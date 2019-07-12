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

<script>
    // Global variables
    CQ_RECAPTCHA_SITE = "<?php echo CQ_RECAPTCHA_SITE ?>";
    CQ_CATEGORY_PAGING_NUMBER = <?php echo CQ_CATEGORY_PAGING_NUMBER ?>;
</script>

<?php wp_footer(); ?>

</body>
</html>
