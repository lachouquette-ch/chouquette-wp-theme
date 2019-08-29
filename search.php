<?php
get_header();
global $wp_query;

get_template_part('template-parts/fiche-report');
?>
    <div id="app" class="container mb-3">
        <h1 class="text-center my-4">Résultat(s) pour '<?php echo get_search_query(); ?>'</h1>
        <h3 class="m-3"><?php echo sprintf(_n('%s article trouvé', '%s articles trouvés', $wp_query->found_posts), $wp_query->found_posts); ?></h3>
        <?php if (have_posts()): ?>
        <div class="d-flex flex-wrap">
            <?php
            while (have_posts()):
                the_post();
                ?>
                <div class="border rounded p-2 mb-2">
                    <div class="media">
                        <?php if ($wp_query->current_post % 2 == 0) {
                            the_post_thumbnail('thumbnail', ['class' => ' mr-3 rounded']);
                        } ?>
                        <div class="media-body ml-2">
                            <h5 class="mt-2"><?php the_title(); ?></h5>
                            <div class="d-none d-md-block">
                                <?php the_excerpt(); ?>
                                <a class="link-secondary" href="<?php the_permalink(); ?>">La suite</a>
                            </div>
                        </div>
                        <?php if ($wp_query->current_post % 2 == 1) {
                            the_post_thumbnail('thumbnail', ['class' => ' ml-3 rounded']);
                        } ?>
                    </div>
                    <div class="d-md-none mt-3 mx-2">
                        <?php the_excerpt(); ?>
                        <a class="link-secondary" href="<?php the_permalink(); ?>">La suite</a>
                    </div>
                </div>
            <?php
            endwhile;
            endif;

            if ($wp_query->found_posts > $wp_query->post_count) {
                $more_posts_url = add_query_arg(array(
                    'post_type' => 'post',
                    'paged' => 2
                ));
                echo "<a href='$more_posts_url' class='btn btn-outline-secondary w-100' role='button' style='line-height: 5rem;'>Les autres articles</a>";
            }
            ?>
        </div>
        <?php
        $args = array(
            'post_type' => CQ_FICHE_POST_TYPE,
            'meta_key' => CQ_FICHE_CHOUQUETTISE_TO,
            'meta_type' => 'DATE',
            'orderby' => 'meta_value date',
            'order' => 'DESC DESC',
            'post_status' => 'any' // TODO to remove
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
                get_template_part('template-parts/fiche');
            }
            if ($loop->found_posts > $loop->post_count) {
                $more_posts_url = add_query_arg(array(
                    'post_type' => 'fiche',
                    'paged' => 2
                ));

                echo sprintf('<article id="%s" class="card fiche mb-4">', get_the_ID());
                echo "<a href='$more_posts_url' class='btn btn-outline-secondary d-flex align-items-center' role='button' style='height: 100%;'><span class='w-100 text-center'>Les autres fiches</span></a>";
                echo '</article >';
            }
            echo '</div>';
        }
        ?>
    </div>
<?php

wp_enqueue_script('single-post', get_template_directory_uri() . '/search.js', ['vue', 'google-maps', 'hammer'], CQ_THEME_VERSION, true);

get_footer();