<?php
get_header();
global $wp_query;

get_template_part('template-parts/fiche-modals');
?>
    <div id="app" class="container py-4">
        <h1 class="text-center mb-4">Résultat(s) pour '<?php echo get_search_query(); ?>'</h1>
        <h3 class="m-3"><?php echo sprintf(_n('%s article trouvé', '%s articles trouvés', $wp_query->found_posts), $wp_query->found_posts); ?></h3>
        <?php
        if (have_posts()) {
            echo '<div class="search-articles d-flex justify-content-around flex-wrap">';
            while (have_posts()) {
                the_post();
                get_template_part('template-parts/article-card');
            }
            if ($wp_query->found_posts > $wp_query->post_count) {
                $more_posts_url = add_query_arg(array(
                    'post_type' => 'post',
                    'paged' => 2
                ));
                echo "<a href='$more_posts_url' class='btn btn-outline-secondary w-100' role='button' style='line-height: 5rem;'>Les autres articles</a>";
            }
            echo '</div>';
        }

        $args = array(
            'post_type' => CQ_FICHE_POST_TYPE,
            'meta_key' => CQ_FICHE_CHOUQUETTISE_TO,
            'meta_type' => 'DATE',
            'orderby' => 'meta_value date',
            'order' => 'DESC DESC',
        );
        $args = array_merge($wp_query->query_vars, $args);
        $loop = new WP_Query($args);
        $loop->parse_query_vars();
        ?>
        <h3 class="m-3"><?php echo sprintf(_n('%s fiche trouvée', '%s fiches trouvées', $loop->found_posts), $loop->found_posts); ?></h3>
        <?php
        if ($loop->have_posts()) {
            echo '<div class="search-fiches d-flex justify-content-around flex-wrap">';
            while ($loop->have_posts()) {
                $loop->the_post();
                get_template_part('template-parts/fiche_template');
            }
            if ($loop->found_posts > $loop->post_count) {
                $more_posts_url = add_query_arg(array(
                    'post_type' => 'fiche',
                    'paged' => 2
                ));
                echo "<a href='$more_posts_url' class='btn btn-outline-secondary w-100' role='button' style='line-height: 5rem;'>Les autres fiches</a>";
            }
            echo '</div>';
        }
        ?>
    </div>
<?php

wp_enqueue_script('search', get_template_directory_uri() . '/src/scripts/partials/search.js', ['vue', 'google-maps', 'hammer'], CQ_THEME_VERSION, true);

get_footer();