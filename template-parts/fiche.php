<?php
$fiche = !empty(get_query_var('refFiche')) ? get_query_var('refFiche') : get_post();

$default_category = get_query_var('default_category');
if ($default_category) {
    $fiche_category = chouquette_category_get_single_sub_category($fiche->ID, $default_category);
} else {
    $fiche_category = chouquette_categories($fiche->ID)[0];
}

$fiche_fields = get_fields($fiche->ID);
$fiche_taxonomies = chouquette_fiche_get_taxonomies($fiche);
$is_chouquettise = chouquette_fiche_is_chouquettise($fiche->ID);

$fichePosts = get_posts(array(
    'meta_query' => array(
        array(
            'key' => CQ_FICHE_SELECTOR, // name of custom field
            'value' => '"' . $fiche->ID . '"', // matches exactly "123", not just 123. This prevents a match for "1234"
            'compare' => 'LIKE'
        )
    )
));
?>

<article class="fiche fiche-flip <?php if (chouquette_fiche_is_chouquettise($fiche->ID)) echo 'fiche-chouquettise'; ?>"
         v-cloak
         data-fiche-id="<?php echo $fiche->ID; ?>"
         data-fiche-name="<?php echo esc_url($fiche->post_title); ?>"
         data-fiche-lat="<?php echo $fiche_fields[CQ_FICHE_LOCATION] ? $fiche_fields[CQ_FICHE_LOCATION]['lat'] : ''; ?>"
         data-fiche-lng="<?php echo $fiche_fields[CQ_FICHE_LOCATION] ? $fiche_fields[CQ_FICHE_LOCATION]['lng'] : ''; ?>"
         data-fiche-icon="<?php echo esc_url(chouquette_category_get_marker_icon($fiche_category, chouquette_fiche_is_chouquettise($fiche->ID))); ?>">
    <a id="<?php echo 'target' . $fiche->ID; ?>"></a>
    <div class="fiche-container">
        <div class="fiche-front">
            <?php include 'fiche-front.php'; ?>
        </div>
        <div class="fiche-back">
            <?php include 'fiche-back.php'; ?>
        </div>
    </div>
</article>