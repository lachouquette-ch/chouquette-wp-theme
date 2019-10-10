<?php

get_header();

get_template_part('template-parts/fiche-modals');

while (have_posts()):
    the_post();

    $fiche = get_post();
    $fiche_category = chouquette_categories($fiche->ID)[0];
    $fiche_category_link = get_category_link($fiche_category->term_id);
    ?>
    <div id="app" class="container-fluid cq-single-fiche mx-auto py-4">
        <?php
        get_template_part('template-parts/fiche');
        echo '<div class="mt-3 w-100 text-center">';
        echo "<a href='$fiche_category_link' class='link-secondary' title='$fiche_category->name'>Découvre les autres fiches '$fiche_category->name'</a>";
        echo '</div>';
        ?>
    </div>
<?php
endwhile;

wp_enqueue_script('single-fiche', get_template_directory_uri() . '/src/scripts/partials/single-fiche.js', ['recaptcha', 'swiper-custom', 'vue', 'google-maps', 'hammer'], CQ_THEME_VERSION, true);

get_footer();