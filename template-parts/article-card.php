<a class="article-card" href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>">
    <article class="d-flex align-items-end" style="background-image: url('<?php esc_url(the_post_thumbnail_url('medium_large')); ?>')">
        <div class="article-card-header p-2 flex-fill">
            <?php
            // get fiche
            $linkFiche = get_field('link_fiche');
            if ($linkFiche) {
                $taxonomy_id = $linkFiche[0]->ID;
            } else {
                $taxonomy_id = get_the_ID(); // fallback to article if no fiche (ex : tops)
            }

            $categories = chouquette_get_top_categories($taxonomy_id);
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
