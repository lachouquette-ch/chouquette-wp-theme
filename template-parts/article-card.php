<article class="article-card d-flex align-items-end" style="background-image: url('<?php esc_url( the_post_thumbnail_url( 'medium_large' ) ); ?>')">
    <div class="article-card-header p-2 flex-fill">
        <?php
            $category = chouquette_top_category( get_the_ID() );
            if ( isset ( $category )) {
                $logo_class = get_field(CHOUQUETTE_MENU_LOGO_SELECTOR, chouquette_acf_generate_post_id($category));
                echo sprintf("<i class='article-card-category %s'></i>", $logo_class);
            }
        ?>
        <h3 class="article-card-title"><?php the_title(); ?></h3>
    </div>
</article>