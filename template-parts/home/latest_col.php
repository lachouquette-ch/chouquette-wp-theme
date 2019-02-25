<div class="<?php echo 'col-lg-' . $col_size ?> py-1 p-xl-3">
    <article class="article-card" style="background-image: url('<?php the_post_thumbnail_url( 'medium_large' ) ?>')">
        <div class="article-card-header p-2">
            <i class="article-card-category fas fa-theater-masks"></i>
            <h4 class="article-card-title"><?php the_title(); ?></h4>
        </div>
    </article>
</div>