<?php
get_header();

global $wp_query;
$args = array(
    'post_type' => CQ_FICHE_POST_TYPE,
    'meta_key' => CQ_FICHE_CHOUQUETTISE_TO,
    'meta_type' => 'DATE',
    'orderby' => 'meta_value date',
    'order' => 'DESC DESC',
);
query_posts(array_merge($wp_query->query_vars, $args));
?>
    <div id="app" class="container py-4">
        <h1 class="text-center mb-4">Résultat(s) pour '<?php echo get_search_query(); ?>'</h1>
        <h3 class="m-3"><?php echo sprintf(_n('%s fiche trouvée', '%s fiches trouvées', $wp_query->found_posts), $wp_query->found_posts); ?></h3>
        <?php
        if (have_posts()) {
            echo '<div class="search-fiches d-flex justify-content-around flex-wrap">';
            while (have_posts()) {
                the_post();
                get_template_part('template-parts/fiche');
            }
            echo '</div>';
            the_posts_pagination(array(
                'mid_size' => 2,
                'prev_text' => 'Préc.',
                'next_text' => 'Suiv.',
                'screen_reader_text' => ' '
            ));
        }
        ?>
    </div>
<?php

wp_enqueue_script('search', get_template_directory_uri() . '/search.js', ['vue', 'google-maps', 'hammer'], CQ_THEME_VERSION, true);

get_footer();