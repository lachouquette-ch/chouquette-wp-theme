<?php

get_header();

get_template_part('template-parts/fiche-modals');

while (have_posts()):
    the_post();

    $fiche = get_post();
    $fiche_category = chouquette_categories($fiche->ID)[0];
    $fiche_category_link = get_category_link($fiche_category->term_id);

    $fichePosts = new WP_Query(array(
        'meta_query' => array(
            array(
                'key' => CQ_FICHE_SELECTOR, // name of custom field
                'value' => '"' . $fiche->ID . '"', // matches exactly "123", not just 123. This prevents a match for "1234"
                'compare' => 'LIKE'
            )
        )
    ));
    ?>
    <div id="app" class="container-fluid cq-single-fiche mx-auto py-4">
        <h1 class="text-center mb-4 cq-font"><?php the_title(); ?></h1>
        <?php get_template_part('template-parts/fiche'); ?>
        <div class="my-4 text-center">
            <a href="<?php echo $fiche_category_link; ?>" role="button" class="btn btn-sm btn-outline-secondary px-4 py-2" title="<?php echo $fiche_category->name; ?>">
                Découvre les autres fiches de la catégorie '<?php echo $fiche_category->name; ?>'</a>
        </div>
        <?php if ($fichePosts->have_posts()): ?>
            <h2 class="text-center my-4 cq-font">Les articles associés</h2>
            <div class="article-card-shuffle-container d-flex flex-wrap align-items-center justify-content-center mb-3">
                <?php
                while ($fichePosts->have_posts()) :
                    $fichePosts->the_post();
                    get_template_part('template-parts/article-card');
                endwhile;
                ?>
            </div>
        <?php endif; ?>
    </div>
<?php
endwhile;

wp_enqueue_script('single-fiche', get_template_directory_uri() . '/src/scripts/partials/single-fiche.js', ['recaptcha', 'swiper-custom', 'vue', 'google-maps', 'hammer'], CQ_THEME_VERSION, true);

get_footer();