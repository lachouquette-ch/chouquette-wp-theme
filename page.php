<?php

get_header();

while (have_posts()) :
    the_post();
    ?>

    <div class="container cq-page py-5">
        <h1><?php the_title() ?></h1>
        <div><?php the_content(); ?></div>
    </div>
<?php
endwhile;

wp_enqueue_script('page', get_template_directory_uri() . '/dist/other.js', null, CQ_THEME_VERSION, true);

get_footer();
