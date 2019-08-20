<a class="article-card" href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>">
    <?php
    $fiches = chouquette_fiche_get_all();
    $fiches_chouquettises = array_filter($fiches, function ($fiche) {
        return chouquette_fiche_is_chouquettise($fiche->ID);
    });
    ?>
    <article class="<?php echo !empty($fiches_chouquettises) ? 'article-card-chouquettise' : ''; ?>">
        <div class="article-card-picture" style="background-image: url('<?php esc_url(the_post_thumbnail_url('medium_large')); ?>')">
                <?php
                $categories = chouquette_categories_get_tops(get_the_ID());
                if (!empty ($categories)) {
                    echo '<div class="article-card-category">';
                    echo chouquette_taxonomy_logo($categories[0], 'black');
                    echo '</div>';
                }
                ?>
        </div>
        <div class="article-card-caption d-flex text-center justify-content-center align-items-center"><?php the_title(); ?></div>
    </article>
</a>
