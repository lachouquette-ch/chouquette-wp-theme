<div class="index-content-latest-container <?php echo 'col-lg-' . $col_size ?>">
    <article class="article-card d-flex align-items-end" style="background-image: url('<?php the_post_thumbnail_url( 'medium_large' ) ?>')">
        <div class="article-card-header p-2 flex-fill">
            <i class="article-card-category fas fa-theater-masks"></i>
            <h3 class="article-card-title"><?php the_title(); ?></h3>
        </div>
    </article>
</div>