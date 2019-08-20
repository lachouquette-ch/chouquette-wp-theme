<?php
$default_category = get_query_var('default_category');
if ($default_category) {
    $fiche_category = chouquette_category_get_single_sub_category(get_the_ID(), $default_category);
} else {
    $fiche_category = chouquette_categories_get_tops(get_the_ID())[0];
}

$fiche = get_post();
$fiche_fields = get_fields(get_the_ID());
$fiche_taxonomies = chouquette_fiche_get_taxonomies($fiche);
$is_chouquettise = chouquette_fiche_is_chouquettise($fiche->ID);

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

<article class="fiche mb-4 <?php if (chouquette_fiche_is_chouquettise(get_the_ID())) echo 'fiche-chouquettise'; ?>"
         v-cloak
         data-fiche-id="<?php echo get_the_ID(); ?>"
         data-fiche-name="<?php echo get_the_title(); ?>"
         data-fiche-lat="<?php echo $fiche_fields[CQ_FICHE_LOCATION] ? $fiche_fields[CQ_FICHE_LOCATION]['lat'] : ''; ?>"
         data-fiche-lng="<?php echo $fiche_fields[CQ_FICHE_LOCATION] ? $fiche_fields[CQ_FICHE_LOCATION]['lng'] : ''; ?>"
         data-fiche-icon="<?php echo chouquette_category_get_marker_icon($fiche_category, chouquette_fiche_is_chouquettise($fiche->ID)) ?>">
    <a class="fiche-target" id="<?php echo 'target' . get_the_ID(); ?>"></a>
    <div class="fiche-container">
        <div class="fiche-front">
            <div class="card">
                <div class="card-header fiche-header p-2" style="background-image: url('<?php esc_url(the_post_thumbnail_url('medium_large')); ?>');">
                    <div class="fiche-header-icon"><?php echo chouquette_taxonomy_logo($fiche_category, 'black'); ?></div>
                </div>
                <div class="card-body d-flex flex-column position-relative">
                    <h5 class="card-title text-center"><?php the_title(); ?></h5>
                    <p class="card-text"><?php echo strip_tags(get_the_content()); ?></p>
                    <?php if ($is_chouquettise): ?>
                        <div class="card-text d-flex justify-content-around mt-auto">
                            <?php if (!empty($fiche_fields[CQ_FICHE_PHONE])): ?>
                                <a href="tel:<?php echo $fiche_fields[CQ_FICHE_PHONE] ?>" title="Téléphoner" class="fiche-social"><i class="fas fa-phone"></i></a>
                            <?php endif;
                            if (!empty($fiche_fields[CQ_FICHE_MAIL])): ?>
                                <a href="mailto:<?php echo $fiche_fields[CQ_FICHE_MAIL] . '?body=%0A---%0AEnvoy%C3%A9%20depuis%20' . get_home_url() ?>"
                                   title="Email" class="fiche-social"><i class="fas fa-at"></i></a>
                            <?php endif;
                            if (!empty($fiche_fields[CQ_FICHE_FACEBOOK])): ?>
                                <a href="<?php echo esc_url($fiche_fields[CQ_FICHE_FACEBOOK]); ?>" title="Facebook" class="fiche-social"><i class="fab fa-facebook-f"></i></a>
                            <?php endif;
                            if (!empty($fiche_fields[CQ_FICHE_INSTAGRAM])): ?>
                                <a href="<?php echo esc_url($fiche_fields[CQ_FICHE_INSTAGRAM]); ?>" title="Instagram" class="fiche-social"><i class="fab fa-instagram"></i></a>
                            <?php endif;
                            if (!empty($fiche_fields[CQ_FICHE_TWITTER])): ?>
                                <a href="<?php echo esc_url($fiche_fields[CQ_FICHE_TWITTER]); ?>" title="Twitter" class="fiche-social"><i class="fab fa-twitter"></i></a>
                            <?php endif;
                            if (!empty($fiche_fields[CQ_FICHE_PINTEREST])): ?>
                                <a href="<?php echo esc_url($fiche_fields[CQ_FICHE_PINTEREST]); ?>" title="Pinterest" class="fiche-social"><i class="fab fa-pinterest"></i></a>
                            <?php endif; ?>
                        </div>
                    <?php endif; ?>
                    <a class="fiche-report" title="Reporter une précision ou erreur sur la fiche" href="#" data-toggle="modal" data-target="#ficheReportModal" data-fiche-title="<?php the_title(); ?>"
                       data-fiche-id="<?php echo get_the_ID(); ?>">
                        <i class="fas fa-exclamation-circle"></i>
                    </a>
                </div>
                <div class="card-footer">
                    <?php if (is_category() && !is_category(CQ_CATEGORY_SERVICES) || is_tax(CQ_TAXONOMY_LOCATION)) {
                        // only for category pages or locations (not services)
                        ?>
                        <?php if (!empty($fiche_fields[CQ_FICHE_LOCATION])): ?>
                            <a href="#" class="btn btn-outline-secondary"
                               title="Voir la fiche sur la carte"
                               v-on:click.prevent="locateFiche(<?php echo get_the_ID(); ?>)">
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
                        <?php endif;
                    } elseif (is_search()) {
                        $fiche_link = add_query_arg('id', get_the_ID(), get_category_link($fiche_category));
                        ?>
                        <a href="<?php echo $fiche_link; ?>"
                           title="Voir la fiche"
                           class="btn btn-sm btn-outline-secondary">
                            <i class="fas fa-eye"></i>
                        </a>
                    <?php } ?>
                    <a href="#"
                       title="Détails"
                       class="btn btn-secondary float-right"
                       v-on:click.prevent="ficheFlip($event)">
                        <i class="fas fa-redo"></i>
                    </a>
                </div>
            </div>
        </div>
        <div class="fiche-back">
            <div class="card">
                <?php if (!empty($fiche_fields[CQ_FICHE_LOCATION])): ?>
                    <div class="fiche-header" id="<?php echo 'ficheMap' . get_the_ID(); ?>"></div>
                <?php endif; ?>
                <?php if ($is_chouquettise): ?>
                    <ul class="list-group list-group-flush">
                        <?php if (!empty($fiche_fields[CQ_FICHE_PHONE])): ?>
                            <li class="list-group-item">
                                <a href="tel:<?php echo $fiche_fields[CQ_FICHE_PHONE] ?>"
                                   title="Téléphone"
                                   class="link-secondary link-no-decoration"><i class="fas fa-phone"></i> <?php echo $fiche_fields[CQ_FICHE_PHONE] ?>
                                </a>
                            </li>
                        <?php endif; ?>
                        <?php if (!empty($fiche_fields[CQ_FICHE_MAIL])): ?>
                            <li class="list-group-item">
                                <a href="mailto:<?php echo $fiche_fields[CQ_FICHE_MAIL] . '?body=%0A---%0AEnvoy%C3%A9%20depuis%20' . get_home_url() ?>"
                                   title="Email"
                                   class="link-secondary link-no-decoration"><i class="fas fa-at"></i> <?php echo $fiche_fields[CQ_FICHE_MAIL] ?>
                                </a>
                            </li>
                        <?php endif; ?>
                        <?php if (!empty($fiche_fields[CQ_FICHE_COST])): ?>
                            <li class="list-group-item">
                                <label class="mb-0">Prix :</label>
                                <span class="fiche-price fiche-price-selected"><?php echo str_repeat('$', $fiche_fields[CQ_FICHE_COST]); ?></span><span
                                        class="fiche-price"><?php echo str_repeat('$', 5 - $fiche_fields[CQ_FICHE_COST]); ?></span>
                            </li>
                        <?php endif; ?>
                        <?php
                        if (chouquette_fiche_has_openings($fiche_fields)):
                            $raw_planning = array(
                                !in_array($fiche_fields[CQ_FICHE_OPENING_MONDAY], CQ_FICHE_OPERNING_CLOSED) ? $fiche_fields[CQ_FICHE_OPENING_MONDAY] : 'Fermé',
                                !in_array($fiche_fields[CQ_FICHE_OPENING_TUESDAY], CQ_FICHE_OPERNING_CLOSED) ? $fiche_fields[CQ_FICHE_OPENING_TUESDAY] : 'Fermé',
                                !in_array($fiche_fields[CQ_FICHE_OPENING_WEDNESDAY], CQ_FICHE_OPERNING_CLOSED) ? $fiche_fields[CQ_FICHE_OPENING_WEDNESDAY] : 'Fermé',
                                !in_array($fiche_fields[CQ_FICHE_OPENING_THURSDAY], CQ_FICHE_OPERNING_CLOSED) ? $fiche_fields[CQ_FICHE_OPENING_THURSDAY] : 'Fermé',
                                !in_array($fiche_fields[CQ_FICHE_OPENING_FRIDAY], CQ_FICHE_OPERNING_CLOSED) ? $fiche_fields[CQ_FICHE_OPENING_FRIDAY] : 'Fermé',
                                !in_array($fiche_fields[CQ_FICHE_OPENING_SATURDAY], CQ_FICHE_OPERNING_CLOSED) ? $fiche_fields[CQ_FICHE_OPENING_SATURDAY] : 'Fermé',
                                !in_array($fiche_fields[CQ_FICHE_OPENING_SUNDAY], CQ_FICHE_OPERNING_CLOSED) ? $fiche_fields[CQ_FICHE_OPENING_SUNDAY] : 'Fermé',
                            );
                            ?>
                            <li class="list-group-item">
                                <label class="mb-0">Horaires :</label>
                                <div class="dropup d-inline-block fiche-planning">
                                    <a class="link-secondary link-no-decoration dropdown-toggle" href="#horaires" role="button" id="<?php echo 'planning' . get_the_ID(); ?>" data-toggle="dropdown"
                                       aria-haspopup="true" aria-expanded="false"><?php echo $raw_planning[date('N') - 1]; ?></i></a>
                                    <div class="dropdown-menu" aria-labelledby="<?php echo 'planning' . get_the_ID(); ?>">
                                        <ul>
                                            <li><label class="mb-0">Lundi</label> <?php echo $raw_planning[0]; ?></li>
                                            <li><label class="mb-0">Mardi</label> <?php echo $raw_planning[1]; ?></li>
                                            <li><label class="mb-0">Mercredi</label> <?php echo $raw_planning[2]; ?></li>
                                            <li><label class="mb-0">Jeudi</label> <?php echo $raw_planning[3]; ?></li>
                                            <li><label class="mb-0">Vendredi</label> <?php echo $raw_planning[4]; ?></li>
                                            <li><label class="mb-0">Samedi</label> <?php echo $raw_planning[5]; ?></li>
                                            <li><label class="mb-0">Dimanche</label> <?php echo $raw_planning[6]; ?></li>
                                        </ul>
                                    </div>
                                </div>
                            </li>
                        <?php endif; ?>
                    </ul>
                <?php endif; ?>
                <div class="card-body position-relative">
                    <span><?php $terms = chouquette_fiche_flatten_terms($fiche_taxonomies);
                        echo implode(", ", $terms); ?></span>
                    <a href="#" class="fiche-report" title="Reporter une précision ou erreur sur la fiche" data-toggle="modal" data-target="#ficheReportModal" data-fiche-title="<?php the_title(); ?>"
                       data-fiche-id="<?php echo get_the_ID(); ?>">
                        <i class="fas fa-exclamation-circle"></i>
                    </a>
                </div>
                <div class="card-footer">
                    <?php if (is_category() && !is_category(CQ_CATEGORY_SERVICES) || is_tax(CQ_TAXONOMY_LOCATION)) {
                        // only for category pages or locations (not services)
                        ?>
                        <?php if (!empty($fiche_fields[CQ_FICHE_LOCATION])): ?>
                            <a href="#" class="btn btn-outline-secondary"
                               title="Voir la fiche sur la carte"
                               v-on:click.prevent="locateFiche(<?php echo get_the_ID(); ?>)">
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
                        <?php endif;
                    } elseif (is_search()) {
                        $fiche_link = add_query_arg('id', get_the_ID(), get_category_link($fiche_category));
                        ?>
                        <a href="<?php echo $fiche_link; ?>"
                           title="Voir la fiche"
                           class="btn btn-sm btn-outline-secondary">
                            <i class="fas fa-eye"></i>
                        </a>
                    <?php } ?>
                    <a href="#"
                       title="Détails"
                       class="btn btn-secondary float-right"
                       v-on:click.prevent="ficheFlip($event)">
                        <i class="fas fa-undo"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>
</article>