<a class="article-card" href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>">
    <?php
    $fiches = chouquette_fiche_get_all();
    $fiches_chouquettise = array_map(function ($fiche) {
        return chouquette_fiche_is_chouquettise($fiche->ID);
    }, $fiches);
    $is_chouquettise = in_array(true, $fiches_chouquettise);
    ?>
    <article class="d-flex align-items-end <?php echo $is_chouquettise ? 'article-card-chouquettise' : ''; ?>" style="background-image: url('<?php esc_url(the_post_thumbnail_url('medium_large')); ?>')">
        <div class="article-card-header p-2 flex-fill">
            <?php
            $categories = chouquette_categories_get_tops(get_the_ID());
            if (!empty ($categories)) {
                echo '<div class="article-card-category p-2">';
                echo chouquette_taxonomy_logo($categories[0], 'black');
                echo '</div>';
            }
            ?>
            <h3 class="article-card-title"><?php the_title(); ?></h3>
        </div>
    </article>
</a>
