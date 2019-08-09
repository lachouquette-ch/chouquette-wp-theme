<?php
$fiche = get_post();
$fiche_fields = get_fields(get_the_ID());
$fiche_taxonomies = chouquette_fiche_get_taxonomies($fiche);
$is_chouquettise = chouquette_fiche_is_chouquettise($fiche->ID);
?>
<div class="info-window container-fluid">
    <div class="row">
        <div class="col-lg-3 text-center p-0 mb-2 mb-lg-0">
            <img width="100%" class="rounded d-none d-lg-block" src="<?php esc_url(the_post_thumbnail_url('thumbnail')); ?>" alt="<?php get_the_title($fiche->ID); ?>">
        </div>
        <div class="col-lg px-0 px-lg-2">
            <div class="info-window-header mb-2">
                <h5 class="d-inline mr-2"><?php echo get_the_title(); ?></h5>
                <?php if ($is_chouquettise):
                    if (!empty($fiche_fields[CQ_FICHE_FACEBOOK])) echo '<a href="' . esc_url($fiche_fields[CQ_FICHE_FACEBOOK]) . '" title="Facebook" target="_blank" class="link-secondary mr-2"><i class="fab fa-facebook-f"></i></a>';
                    if (!empty($fiche_fields[CQ_FICHE_INSTAGRAM])) echo '<a href="' . esc_url($fiche_fields[CQ_FICHE_INSTAGRAM]) . '" title="Instagram" target="_blank" class="link-secondary mr-2"><i class="fab fa-instagram"></i></a>';
                    if (!empty($fiche_fields[CQ_FICHE_TWITTER])) echo '<a href="' . esc_url($fiche_fields[CQ_FICHE_TWITTER]) . '" title="Twitter" target="_blank" class="link-secondary mr-2"><i class="fab fa-twitter"></i></a>';
                    if (!empty($fiche_fields[CQ_FICHE_PINTEREST])) echo '<a href="' . esc_url($fiche_fields[CQ_FICHE_PINTEREST]) . '" title="Twitter" target="_blank" class="link-secondary mr-2"><i class="fab fa-pinterest-p"></i></a>';
                endif; ?>
            </div>
            <?php if ($is_chouquettise): ?>
                <div class="info-window-extra">
                    <?php if (!empty($fiche_fields[CQ_FICHE_PHONE])): ?>
                        <div>
                            <a href="tel:<?php echo $fiche_fields[CQ_FICHE_PHONE] ?>"
                               title="Téléphone" class="link-secondary link-no-decoration mr-2">
                                <i class="fas fa-phone-square mr-3"></i> <?php echo $fiche_fields[CQ_FICHE_PHONE] ?>
                            </a>
                        </div>
                    <?php endif; ?>
                    <?php if (!empty($fiche_fields[CQ_FICHE_MAIL])): ?>
                        <div>
                            <a href="mailto:<?php echo $fiche_fields[CQ_FICHE_MAIL] . '?body=%0A---%0AEnvoy%C3%A9%20depuis%20' . get_home_url() ?>"
                               title="Email" class="link-secondary link-no-decoration mr-2">
                                <i class="fas fa-at mr-3"></i> <?php echo $fiche_fields[CQ_FICHE_MAIL] ?>
                            </a>
                        </div>
                    <?php endif; ?>
                    <?php if (!empty($fiche_fields[CQ_FICHE_COST])): ?>
                        <div>
                            <label>Prix :</label>
                            <span class="cq-fiche-price cq-fiche-price-selected"><?php echo str_repeat('$', $fiche_fields[CQ_FICHE_COST]); ?></span><span
                                    class="cq-fiche-price"><?php echo str_repeat('$', 5 - $fiche_fields[CQ_FICHE_COST]); ?></span>
                        </div>
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
                        <div>
                            <label>Horaires :</label>
                            <a class="link-secondary link-no-decoration" data-toggle="collapse" href="#horaires" role="button"><?php echo $raw_planning[date('N') - 1]; ?> <i
                                        class="fas fa-caret-down"></i></a>
                            <ul class="collapse mb-0" id="horaires">
                                <li><label>Lundi</label> <?php echo $raw_planning[0]; ?></li>
                                <li><label>Mardi</label> <?php echo $raw_planning[1]; ?></li>
                                <li><label>Mercredi</label> <?php echo $raw_planning[2]; ?></li>
                                <li><label>Jeudi</label> <?php echo $raw_planning[3]; ?></li>
                                <li><label>Vendredi</label> <?php echo $raw_planning[4]; ?></li>
                                <li><label>Samedi</label> <?php echo $raw_planning[5]; ?></li>
                                <li><label>Dimanche</label> <?php echo $raw_planning[6]; ?></li>
                            </ul>
                        </div>
                    <?php endif; ?>
                </div>
            <?php elseif (!empty(get_the_content())) : ?>
                <?php echo get_the_content(); ?>
            <?php endif; ?>
        </div>
    </div>
    <?php if ($is_chouquettise && !empty(get_the_content())): ?>
        <div class="row mt-2"><?php echo get_the_content(); ?></div>
    <?php endif; ?>
    <div class="row mt-3 font-italic">
        <?php
        $terms = chouquette_fiche_flatten_terms($fiche_taxonomies);
        echo implode(", ", $terms);
        ?>
    </div>
    <img width="100%" class="d-block d-lg-none mt-3" src="<?php esc_url(the_post_thumbnail_url('thumbnail')); ?>" alt="<?php get_the_title($fiche->ID); ?>">
    <?php if ($is_chouquettise): ?>
        <div class="row mt-2 float-right">
            <a href="<?php echo esc_url('https://maps.google.com/?q=' . $fiche_fields[CQ_FICHE_LOCATION]['address']); ?>" class="link-secondary" title="Ouvrir avec Google maps" target="_blank"><i
                        class="fas fa-map-marker-alt pr-1"></i> Ouvrir dans google maps</a>
        </div>
    <?php endif; ?>
</div>
