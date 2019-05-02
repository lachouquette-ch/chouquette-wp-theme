<a class="article-card" href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>">
    <article class="d-flex align-items-end" style="background-image: url('<?php esc_url(the_post_thumbnail_url('medium_large')); ?>')">
        <div class="article-card-header p-2 flex-fill">
            <?php
            $categories = chouquette_get_top_categories(get_the_ID());
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
