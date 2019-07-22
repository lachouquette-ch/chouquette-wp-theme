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

            the_posts_pagination(array(
                'mid_size' => 2,
                'prev_text' => 'Préc.',
                'next_text' => 'Suiv.',
                'screen_reader_text' => ' '
            ));
            endif;
            ?>
        </div>
    </div>
<?php

get_footer();