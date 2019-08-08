<?php
$default_category = get_query_var('default_category');

if ($default_category) {
    $fiche_category = chouquette_category_get_single_sub_category(get_the_ID(), $default_category);
} else {
    $fiche_category = chouquette_categories_get_tops(get_the_ID())[0];
}
$taxonomies = chouquette_fiche_get_taxonomies(get_post());
$posts = get_posts(array(
    'meta_query' => array(
        array(
            'key' => CQ_FICHE_SELECTOR, // name of custom field
            'value' => '"' . get_the_ID() . '"', // matches exactly "123", not just 123. This prevents a match for "1234"
            'compare' => 'LIKE'
        )
    )
));
?>
<article id="<?php echo get_the_ID(); ?>" class="card fiche mb-4 <?php if (chouquette_fiche_is_chouquettise(get_the_ID())) echo 'fiche-chouquettise'; ?>">
    <a class="fiche-target" id="<?php echo 'target' . get_the_ID(); ?>"></a>
    <div class="card-header fiche-header p-2" style="background-image: url('<?php esc_url(the_post_thumbnail_url('medium_large')); ?>');">
        <div class="fiche-header-icon">
            <?php echo chouquette_taxonomy_logo($fiche_category, 'black'); ?>
        </div>
    </div>
    <div class="card-body">
        <h5 class="card-title"><?php the_title(); ?></h5>
        <p class="card-text"><?php echo strip_tags(get_the_excerpt()); ?></p>
        <?php
        $terms = chouquette_fiche_flatten_terms($taxonomies);
        if (!empty($terms)):
            ?>
            <p class="card-text small text-secondary">
                <?php
                echo implode(", ", array_slice($terms, 0, 4));
                echo sizeof($terms) > 4 ? '...' : '';
                ?>
            </p>
        <?php
        endif;
        // only for category pages or locations (not services)
        if (is_category() && !is_category(CQ_CATEGORY_SERVICES) || is_tax(CQ_TAXONOMY_LOCATION)):
            ?>
            <div class="w-100">
                <?php
                if (!empty($posts)) {
                    $lastest_post = $posts[0];
                    echo sprintf('<a href="%s" title="%s" class="btn btn-sm btn-outline-secondary">Article</a>', get_the_permalink($lastest_post), esc_html($lastest_post->post_title));
                }
                ?>
                <button class="btn btn-sm btn-outline-secondary" v-on:click="locateFiche(<?php echo get_the_ID(); ?>)">Voir</button>
            </div>
        <?php elseif (is_search()):
            $fiche_link = add_query_arg('id', get_the_ID(), get_category_link($fiche_category));
            echo "<a class='btn btn-sm btn-outline-secondary' href='${fiche_link}'>Voir</a>";
        endif; ?>
    </div>
    <a class="fiche-report" title="Reporter une précision ou erreur sur la fiche" href="#" data-toggle="modal" data-target="#ficheReportModal" data-fiche-title="<?php the_title(); ?>" data-fiche-id="<?php echo get_the_ID(); ?>">
        <i class="fas fa-exclamation-circle"></i>
    </a>
</article>