<div class="card">
    <div class="card-header fiche-header p-2" style="background-image: url('<?php echo get_the_post_thumbnail_url($fiche, 'medium_large'); ?>');">
        <div class="fiche-header-icon"><?php echo chouquette_taxonomy_logo($fiche_category, 'black'); ?></div>
    </div>
    <div class="card-body d-flex flex-column position-relative">
        <h5 class="card-title text-center"><?php echo $fiche->post_title; ?></h5>
        <p class="fiche-content card-text"><?php echo $fiche->post_content; ?></p>
        <?php if ($is_chouquettise): ?>
            <div class="card-text d-flex justify-content-around mt-auto">
                <?php if (!empty($fiche_fields[CQ_FICHE_PHONE])): ?>
                    <a href="tel:<?php echo $fiche_fields[CQ_FICHE_PHONE] ?>" title="Téléphoner" class="fiche-social" target="_blank"><i class="fas fa-phone"></i></a>
                <?php endif;
                if (!empty($fiche_fields[CQ_FICHE_MAIL])): ?>
                    <a href="#" title="Envoyer un message" class="fiche-social"
                       data-toggle="modal" data-target="#ficheContactModal"
                       data-fiche-title="<?php the_title(); ?>" data-fiche-id="<?php echo $fiche->ID; ?>">
                        <i class="far fa-envelope"></i>
                    </a>
                <?php endif;
                if (!empty($fiche_fields[CQ_FICHE_FACEBOOK])): ?>
                    <a href="<?php echo esc_url($fiche_fields[CQ_FICHE_FACEBOOK]); ?>" title="Facebook" class="fiche-social" target="_blank"><i class="fab fa-facebook-f"></i></a>
                <?php endif;
                if (!empty($fiche_fields[CQ_FICHE_INSTAGRAM])): ?>
                    <a href="<?php echo esc_url($fiche_fields[CQ_FICHE_INSTAGRAM]); ?>" title="Instagram" class="fiche-social" target="_blank"><i class="fab fa-instagram"></i></a>
                <?php endif;
                if (!empty($fiche_fields[CQ_FICHE_TWITTER])): ?>
                    <a href="<?php echo esc_url($fiche_fields[CQ_FICHE_TWITTER]); ?>" title="Twitter" class="fiche-social" target="_blank"><i class="fab fa-twitter"></i></a>
                <?php endif;
                if (!empty($fiche_fields[CQ_FICHE_PINTEREST])): ?>
                    <a href="<?php echo esc_url($fiche_fields[CQ_FICHE_PINTEREST]); ?>" title="Pinterest" class="fiche-social" target="_blank"><i class="fab fa-pinterest"></i></a>
                <?php endif; ?>
            </div>
        <?php endif; ?>
        <a class="fiche-report" title="Reporter une précision ou erreur sur la fiche" href="#" data-toggle="modal" data-target="#ficheReportModal" data-fiche-title="<?php the_title(); ?>"
           data-fiche-id="<?php echo $fiche->ID; ?>">
            <i class="fas fa-exclamation-circle"></i>
        </a>
    </div>
    <?php include 'fiche-footer.php'; ?>
</div>