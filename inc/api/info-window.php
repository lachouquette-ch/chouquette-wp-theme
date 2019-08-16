<?php
$fiche_fields = get_fields(get_the_ID());
$is_chouquettise = chouquette_fiche_is_chouquettise(get_the_ID());
?>
<div class="info-window">
    <h5 class="mb-3"><?php echo get_the_title(); ?></h5>
    <img class="d-block mb-3" src="<?php esc_url(the_post_thumbnail_url('thumbnail')); ?>" alt="<?php get_the_title(); ?>">
    <?php if ($is_chouquettise): ?>
        <a href="<?php echo esc_url('https://maps.google.com/?q=' . $fiche_fields[CQ_FICHE_LOCATION]['address']); ?>"
           class="link-secondary"
           title="Ouvrir avec Google maps"
           target="_blank">
            <i class="fas fa-map-marker-alt pr-1"></i> Ouvrir dans google maps
        </a>
    <?php endif; ?>
</div>
