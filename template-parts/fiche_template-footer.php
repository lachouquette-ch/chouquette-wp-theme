<div class="card-footer">
    <?php if (is_category() && !is_category(CQ_CATEGORY_SERVICES) || is_tax(CQ_TAXONOMY_LOCATION)) :
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
    <?php endif; ?>
    <a href="#"
       title="Plus de détails (retourner la fiche)"
       class="btn btn-secondary float-right"
       v-on:click.prevent="ficheFlip($event.target)">
        <i class="fas fa-plus"></i>
    </a>
</div>