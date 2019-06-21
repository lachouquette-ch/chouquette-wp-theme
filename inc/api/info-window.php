<?php
$fiche = get_post();
$fiche_fields = get_fields(get_the_ID());
$fiche_taxonomies = chouquette_fiche_get_taxonomies($fiche);
?>
<div class="category-info-window container-fluid">
    <div class="row">
        <div class="col-lg-3 text-center p-0 mb-2 mb-lg-0">
            <img width="100%" class="rounded d-none d-lg-block" src="<?php echo $fiche_fields['main-image']; ?>" alt="<?php get_the_title($fiche->ID); ?>">
        </div>
        <div class="col-lg px-0 px-lg-2">
            <h5 class="mt-0"><?php echo get_the_title(); ?></h5>
            <div>
                <label>Internet :</label>
                <span>
                    <?php
                    if (!empty($fiche_fields[CQ_FICHE_FACEBOOK])) echo '<a href="' . esc_url($fiche_fields[CQ_FICHE_FACEBOOK]) . '" title="Facebook" target="_blank" class="link-secondary mr-2"><i class="fab fa-facebook-f"></i></a>';
                    if (!empty($fiche_fields[CQ_FICHE_INSTAGRAM])) echo '<a href="' . esc_url($fiche_fields[CQ_FICHE_INSTAGRAM]) . '" title="Instagram" target="_blank" class="link-secondary mr-2"><i class="fab fa-instagram"></i></a>';
                    if (!empty($fiche_fields[CQ_FICHE_TWITTER])) echo '<a href="' . esc_url($fiche_fields[CQ_FICHE_TWITTER]) . '" title="Twitter" target="_blank" class="link-secondary mr-2"><i class="fab fa-twitter"></i></a>';
                    if (!empty($fiche_fields[CQ_FICHE_PINTEREST])) echo '<a href="' . esc_url($fiche_fields[CQ_FICHE_PINTEREST]) . '" title="Twitter" target="_blank" class="link-secondary mr-2"><i class="fab fa-pinterest-p"></i></a>';
                    ?>
                </span>
            </div>
            <div>
                <label>Contact :</label>
                <span>
                    <?php
                    if (!empty($fiche_fields[CQ_FICHE_MAIL])) echo sprintf('<a href="mailto:%s" title="Email" class="link-secondary link-no-decoration mr-2"><i class="fas fa-at"></i> Email</a>', $fiche_fields[CQ_FICHE_MAIL] . '?body=%0A---%0AEnvoy%C3%A9%20depuis%20' . get_home_url());
                    if (!empty($fiche_fields[CQ_FICHE_PHONE])) echo sprintf('<a href="tel:%s" title="Téléphone" class="link-secondary link-no-decoration mr-2"><i class="fas fa-phone-square"></i> %s</a>', $fiche_fields[CQ_FICHE_PHONE], $fiche_fields[CQ_FICHE_PHONE]);
                    ?>
                </span>
            </div>
            <div>
                <?php if (!empty($fiche_fields[CQ_FICHE_COST])): ?>
                    <label>Prix :</label>
                    <span class="cq-fiche-price cq-fiche-price-selected"><?php echo str_repeat('$', $fiche_fields[CQ_FICHE_COST]); ?></span><span
                            class="cq-fiche-price"><?php echo str_repeat('$', 5 - $fiche_fields[CQ_FICHE_COST]); ?></span>
                <?php endif; ?>
            </div>
            <?php
            if (chouquette_fiche_has_openings($fiche_fields)):
                $raw_planning = array(
                    $fiche_fields[CQ_FICHE_OPENING_MONDAY],
                    $fiche_fields[CQ_FICHE_OPENING_TUESDAY],
                    $fiche_fields[CQ_FICHE_OPENING_WEDNESDAY],
                    $fiche_fields[CQ_FICHE_OPENING_THURSDAY],
                    $fiche_fields[CQ_FICHE_OPENING_FRIDAY],
                    $fiche_fields[CQ_FICHE_OPENING_SATURDAY],
                    $fiche_fields[CQ_FICHE_OPENING_SUNDAY],
                );
                ?>
                <div>
                    <label>Horaires :</label>
                    <a class="link-secondary link-no-decoration" data-toggle="collapse" href="#horaires" role="button"><?php echo $raw_planning[date('N') - 1]; ?> <i class="fas fa-caret-down"></i></a>
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
    </div>
    <?php if (!empty(get_the_content())): ?>
        <div class="row mt-2"><?php echo get_the_content(); ?></div>
    <?php endif; ?>
    <div class="row mt-3 font-italic">
        <?php
        $terms = chouquette_fiche_flatten_terms($fiche_taxonomies);
        echo implode(", ", $terms);
        ?>
    </div>
    <img width="100%" class="d-block d-lg-none mt-2" src="<?php echo $fiche_fields['main-image']; ?>" alt="<?php get_the_title($fiche->ID); ?>">
</div>
