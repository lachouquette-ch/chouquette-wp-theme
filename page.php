<?php
/**
 * Template Name: Contact
 */

get_header();

while (have_posts()) :
    the_post();
    ?>

    <div class="container cq-contact my-5">
        <h1 class="mb-3 cq-font text-center"><?php the_title() ?></h1>
        <div class="mb-5 text-center"><?php the_content(); ?></div>
    </div>
<?php
endwhile;

get_footer();