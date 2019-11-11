<footer class="footer container-fluid text-center">
    <div class="footer-top row pt-4">
        <div class="col">
            <?php
            $custom_logo_id = get_theme_mod('custom_logo');
            $logo = wp_get_attachment_image_src($custom_logo_id, 'medium');
            if (has_custom_logo()) {
                echo sprintf('<img class="mx-auto" src="%s" alt="Logo Chouquette">', esc_url($logo[0]));
            }
            ?>
            <div class="my-3">
                <?php
                $menu_args = array(
                    'theme_location' => CQ_FOOTER_MENU,
                    'menu_class' => 'footer-top-menu px-2'
                );
                wp_nav_menu($menu_args);
                ?>
            </div>
        </div>
    </div>
    <div class="footer-bottom row py-3">
        <div class="col">
            <span>Copyright 2014-2019 - Tous droits réservés à La Chouquette. Toutes les images et le contenu sont la propriété du site.</span>
        </div>
    </div>
</footer>

<div id="confidentialityWarning" class="footer-confidentiality w-100" style="display: none;">
    <div class="p-2 d-flex flex-wrap align-items-center justify-content-center">
        <span class="text-center d-block d-md-inline-block mr-md-3">Ici, on aime les Cookies <i class="fas fa-cookie-bite"></i>, mais pas plus qu'il n'en faut !</span>
        <a href="<?php echo get_permalink(get_page_by_title('Politique de confidentialité')); ?>" class="btn btn btn-outline-primary mr-2 my-2">En savoir plus</a>
        <button class="btn btn btn-primary my-2" onclick="app.closeConfidentiality();">J'accepte</button>
    </div>
</div>

<script>
    // Global variables
    CQ_RECAPTCHA_SITE = "<?php echo CQ_RECAPTCHA_SITE ?>";
    CQ_CATEGORY_PAGING_NUMBER = <?php echo CQ_CATEGORY_PAGING_NUMBER ?>;
    CQ_IMG_PATH = "<?php echo get_template_directory_uri() . '/images' ?>"
</script>

<?php wp_footer(); ?>

</body>
</html>
