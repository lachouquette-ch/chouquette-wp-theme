<?php
get_header();
global $wp_query;
?>
    <div class="container mb-3">
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
                echo '<button class="btn btn-outline-secondary w-100" style="height: 5rem;">Les autres articles</button>';
            }
            ?>
        </div>
        <?php
        $args = array(
            'post_type' => CQ_FICHE_POST_TYPE,
            'meta_key' => CQ_FICHE_CHOUQUETTISE_TO,
            'meta_type' => 'DATE',
            'orderby' => 'meta_value',
            'order' => 'DESC',
            'post_status' => 'any' // TODO to remove
        );
        $args = array_merge($wp_query->query_vars, $args);
        $loop = new WP_Query($args);
        $loop->parse_query_vars();
        ?>
        <h3 class="m-3"><?php echo sprintf(_n('%s fiche trouvée', '%s fiches trouvées', $loop->found_posts), $loop->found_posts); ?></h3>
        <?php
        if ($loop->have_posts()) {
            echo '<div class="d-flex justify-content-center flex-wrap">';
            while ($loop->have_posts()) {
                $loop->the_post();
                get_template_part('template-parts/fiche');
            }
        }

        if ($loop->found_posts > $loop->post_count): ?>
            <article id="<?php echo get_the_ID(); ?>" class="card fiche mb-4">
                <button class="btn btn-outline-secondary w-100" style="height: 100%">Les autres fiches</button>
            </article>
        <?php endif; ?>
    </div>
    </div>
<?php

get_footer();