<div class="<?php echo 'col-lg-' . $col_size ?> py-1 p-xl-3">
    <article class="card bg-dark text-white">
        <?php the_post_thumbnail( 'medium', 'class=card-img' ); ?>
        <div class="card-img-overlay">
            <i class="card-category-icon fas fa-theater-masks"></i>
            <h4 class="card-title"><?php the_title(); ?></h4>
        </div>
    </article>
</div>