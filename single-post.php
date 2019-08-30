<?php

get_header();

get_template_part('template-parts/fiche-report');

while (have_posts()) :
    the_post();

    // get categories
    $categories = chouquette_categories_get_tops(get_the_ID());
    $category_ids = array_column($categories, 'term_id');

    // get tags
    $tags = get_the_tags() ? get_the_tags() : [];
    $tag_ids = array_column($tags, 'term_id');

    // get fiche
    $linkFiches = chouquette_fiche_get_all();
    $linkFichesWithLocations = array_filter($linkFiches, function ($fiche) {
        return !empty(get_field(CQ_FICHE_LOCATION, $fiche));
    });
    ?>
    <article id="post<?php echo get_the_ID(); ?>" class="cq-single-post">
        <div class="cq-single-post-header container p-0">
            <?php the_post_thumbnail('large', ['class' => 'cq-single-post-header-img']); ?>
            <?php echo get_avatar(get_the_author_meta('ID'), 150, null, get_the_author(), ['class' => 'cq-single-post-header-author-img rounded-circle']); ?>
            <div class="cq-single-post-header-meta">
                <span>par <?php the_author() ?></span>
                <span>le
                        <?php
                        $print_date = get_the_modified_date() ? get_the_modified_date() : get_the_date();
                        echo $print_date;
                        ?>
                    </span>
                <span>dans <?php
                    foreach ($categories as $index => $category) {
                        echo sprintf('<a href="%s" title="%s">%s</a>', get_category_link($category), $category->description, $category->name);
                        if (sizeof($categories) - 1 > $index) {
                            echo ' / ';
                        }
                    }
                    ?></span>
            </div>
        </div>

        <div class="cq-single-post-content container">
            <div class="cq-single-post-content-title mt-4">
                <h1 class="mr-2 mb-4"><?php the_title(); ?></h1>
            </div>
            <main class="cq-single-post-content-text">
                <?php the_content(); ?>
            </main>
        </div>

        <?php if (!empty($linkFiches)) : ?>
        <?php endif; ?>

        <div class="cq-single-post-author container mt-4">
            <div class="border shadow-sm text-center position-relative">
                <?php echo get_avatar(get_the_author_meta('ID'), 150, null, get_the_author(), ['class' => 'cq-single-post-header-author-img rounded-circle']); ?>
                <h5 class="mt-3 mb-4"><?php the_author() ?></h5>
                <p><?php the_author_meta('description'); ?></p>
            </div>
        </div>

        <div class="cq-single-post-similar container mt-5">
            <h3 class="mb-3 text-center">Articles similaires</h3>
            <div class="swiper-container">
                <div class="swiper-wrapper">
                    <?php
                    $args = array(
                        'posts_per_page' => 6,
                        'post__not_in' => array(get_the_ID()),
                        'no_found_rows' => true
                    );
                    if (!empty($tag_ids)) {
                        $args['tag__in'] = $tag_ids;
                    }
                    $tops_posts = new WP_Query($args);
                    if ($tops_posts->have_posts()) :
                        while ($tops_posts->have_posts()) :
                            $tops_posts->the_post();
                            echo '<div class="swiper-slide">';
                            get_template_part('template-parts/article-card');
                            echo '</div>';
                        endwhile;
                        // Restore original Post Data
                        wp_reset_postdata();
                    endif;
                    ?>
                </div>
                <!-- Add Arrows -->
                <div class="swiper-button-next swiper-button-black"></div>
                <div class="swiper-button-prev swiper-button-black"></div>
            </div>
        </div>

        <?php if (comments_open() || get_comments_number()) : ?>
            <div class="cq-single-post-comments container mt-5">
                <?php comments_template(); ?>
            </div>
        <?php endif; ?>

        <div id="app"> <!-- shouldn't encompass comments_template since askimet has script embedded (doesn't suit vuejs) -->
            <?php if (!empty($linkFiches)) : ?>
                <div class="cq-single-post-fiches" v-cloak>
                    <button class="cq-single-post-fiches-btn btn btn-lg btn-primary cq-toggle reverse d-none d-md-inline-block" type="button" v-on:click="toggleFiches">
                        <i class="fa"></i><span class="ml-2">Les fiches</span>
                    </button>
                    <button class="cq-single-post-fiches-btn-sm btn btn-sm btn-primary cq-toggle horizontal d-md-none" type="button" v-on:click="toggleFiches">
                        <i class="fa"></i><span class="ml-2">Les fiches</span>
                    </button>
                    <div class="cq-single-post-fiches-wrapper" v-cloak>
                        <div id="fichesAccordion">
                            <?php foreach ($linkFiches as $fiche): ?>
                                <button class="w-100 btn btn-dark d-block cq-toggle" type="button" data-toggle="collapse" data-target="#fiche<?php echo $fiche->ID; ?>"
                                        aria-expanded="true" aria-controls="collapseOne">
                                    <i class="fa mr-2"></i><?php echo $fiche->post_title; ?>
                                </button>
                                <div id="fiche<?php echo $fiche->ID; ?>" class="p-2 collapse show" aria-labelledby="headingOne"
                                     data-parent="#fichesAccordion">
                                    <?php
                                    set_query_var('fiche', $fiche);
                                    get_template_part('template-parts/fiche');
                                    ?>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </article>
<?php
endwhile;

wp_enqueue_script('single-post', get_template_directory_uri() . '/single-post.js', ['recaptcha', 'swiper-custom', 'vue', 'google-maps', 'hammer'], CQ_THEME_VERSION, true);

get_footer();