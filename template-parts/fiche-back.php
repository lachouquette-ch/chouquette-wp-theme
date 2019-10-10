<div class="card">
    <?php if (!empty($fiche_fields[CQ_FICHE_LOCATION])): ?>
        <div class="fiche-header fiche-map"></div>
    <?php endif; ?>
    <?php if ($is_chouquettise): ?>
        <ul class="list-group list-group-flush">
            <?php if (!empty($fiche_fields[CQ_FICHE_PHONE])): ?>
                <li class="list-group-item">
                    <a href="tel:<?php echo $fiche_fields[CQ_FICHE_PHONE] ?>"
                       title="Téléphone" target="_blank"
                       class="link-secondary link-no-decoration"><i class="fas fa-phone"></i> <?php echo $fiche_fields[CQ_FICHE_PHONE] ?>
                    </a>
                </li>
            <?php endif; ?>
            <?php if (!empty($fiche_fields[CQ_FICHE_WEB])): ?>
                <li class="list-group-item">
                    <a href="<?php echo $fiche_fields[CQ_FICHE_WEB] ?>"
                       title="Site Internet" target="_blank"
                       class="link-secondary link-no-decoration"><i class="fas fa-globe"></i> <?php echo $fiche_fields[CQ_FICHE_WEB] ?>
                    </a>
                </li>
            <?php endif; ?>
            <?php if (!empty($fiche_fields[CQ_FICHE_MAIL])): ?>
                <li class="list-group-item">
                    <a href="mailto:<?php echo $fiche_fields[CQ_FICHE_MAIL] . '?body=%0A---%0AEnvoy%C3%A9%20depuis%20' . get_home_url() ?>"
                       title="Email" target="_blank"
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
                        <a class="link-secondary link-no-decoration dropdown-toggle" href="#horaires" role="button" id="<?php echo 'planning' . $fiche->ID; ?>" data-toggle="dropdown"
                           aria-haspopup="true" aria-expanded="false"><?php echo $raw_planning[date('N') - 1]; ?></i></a>
                        <div class="dropdown-menu" aria-labelledby="<?php echo 'planning' . $fiche->ID; ?>">
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
           data-fiche-id="<?php echo $fiche->ID; ?>">
            <i class="fas fa-exclamation-circle"></i>
        </a>
    </div>
    <?php include 'fiche-footer.php'; ?>
</div>