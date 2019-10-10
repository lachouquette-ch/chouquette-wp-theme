<?php
/**
 * Template Name: Contact
 */

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

get_footer();