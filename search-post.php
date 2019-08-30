<?php
get_header();
global $wp_query;
?>
    <div class="container py-4">
        <h1 class="text-center mb-4">Résultat(s) pour '<?php echo get_search_query(); ?>'</h1>
        <h3 class="m-3"><?php echo sprintf(_n('%s article trouvé', '%s articles trouvés', $wp_query->found_posts), $wp_query->found_posts); ?></h3>
        <?php
        if (have_posts()) {
            echo '<div class="search-articles d-flex justify-content-around flex-wrap">';
            while (have_posts()) {
                the_post();
                get_template_part('template-parts/article-card');
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

get_footer();