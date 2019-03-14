<a class="article-card" href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>">
    <article class="d-flex align-items-end" style="background-image: url('<?php esc_url(the_post_thumbnail_url('medium_large')); ?>')">
        <div class="article-card-header p-2 flex-fill">
            <?php
            $categories = get_categories(array(
                'object_ids' => get_the_ID(),
                'parent' => 1232 // TODO should be 0
            ));
            if (!empty ($categories)) {
                $logo_class = get_field(CHOUQUETTE_MENU_LOGO_SELECTOR, chouquette_acf_generate_post_id($categories[0])); // first one only
                echo sprintf("<i class='article-card-category %s'></i>", $logo_class);
            }
            ?>
            <h3 class="article-card-title"><?php the_title(); ?></h3>
        </div>
    </article>
</a>
