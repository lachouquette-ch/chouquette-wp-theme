<?php
get_header();

global $wp_query;
$args = array(
    'meta_key' => CQ_FICHE_CHOUQUETTISE_TO,
    'meta_type' => 'DATE',
    'orderby' => 'meta_value date',
    'order' => 'DESC DESC',
);
query_posts(array_merge($wp_query->query_vars, $args));
?>
    <div class="container mb-3">
        <h1 class="text-center my-4">Résultat(s) pour '<?php echo get_search_query(); ?>'</h1>
        <h3 class="m-3"><?php echo sprintf(_n('%s fiche trouvée', '%s fiches trouvées', $wp_query->found_posts), $wp_query->found_posts); ?></h3>
        <?php
        if (have_posts()) {
            echo '<div class="d-flex justify-content-center flex-wrap">';
            while (have_posts()) {
                the_post();
                get_template_part('template-parts/fiche');
            }
            the_posts_pagination(array(
                'mid_size' => 2,
                'prev_text' => 'Préc.',
                'next_text' => 'Suiv.',
                'screen_reader_text' => ' '
            ));
            echo '</div>';
        }
        ?>
    </div>
<?php

get_footer();