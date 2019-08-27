<div class="card-footer">
    <?php if (is_category() && !is_category(CQ_CATEGORY_SERVICES) || is_tax(CQ_TAXONOMY_LOCATION)) {
        // only for category pages or locations (not services)
        ?>
        <?php if (!empty($fiche_fields[CQ_FICHE_LOCATION])): ?>
            <a href="#" class="btn btn-outline-secondary"
               title="Voir la fiche sur la carte"
               v-on:click.prevent="locateFiche(<?php echo $fiche->ID; ?>)">
                <i class=" fas fa-map-marker-alt"></i>
            </a>
        <?php endif;
        if (!empty($posts)):
            $lastest_post = $posts[0];
            ?>
            <a href="<?php echo get_the_permalink($lastest_post); ?>"
               title="Dernier article sur le lieu"
               class="btn btn-outline-secondary">
                <i class="far fa-newspaper"></i>
            </a>
        <?php endif; ?>
        <a href="#"
           title="Détails"
           class="btn btn-secondary float-right"
           v-on:click.prevent="ficheFlip($event.target)">
            <i class="fas fa-undo"></i>
        </a>
    <?php } elseif (is_search()) {
        $fiche_link = add_query_arg('id', $fiche->ID, get_category_link($fiche_category));
        ?>
        <a href="<?php echo $fiche_link; ?>"
           title="Voir la fiche"
           class="btn btn-sm btn-outline-secondary">
            <i class="fas fa-eye"></i>
        </a>
    <?php } ?>
</div>