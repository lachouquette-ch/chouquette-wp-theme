<!-- Report Modal -->
<div class="modal fade cq-modal" id="ficheReportModal" tabindex="-1" role="dialog" aria-labelledby="ficheReportModalTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="ficheReportModalTitle"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="ficheReportForm" action="<?php echo esc_url(admin_url('admin-post.php')); ?>" method="post">
                    <label>Une erreur, une remarque, une suggestion sur la fiche ? Merci de nous en faire part <i class="far fa-smile"></i></label>
                    <div class="form-group">
                        <label for="ficheReportName">Ton prénom / nom *</label>
                        <input class="form-control" id="ficheReportName" name="report-name" required>
                    </div>
                    <div class="form-group">
                        <label for="ficheReportMail">Ton mail *</label>
                        <input type="email" class="form-control" id="ficheReportMail" name="report-email" required>
                    </div>
                    <div class="form-group">
                        <label for="ficheReportText">Ton commentaire *</label>
                        <textarea class="form-control" name="report-text" id="ficheReportText" rows="8" required></textarea>
                    </div>
                    <input type="hidden" name="action" value="fiche_report"> <!-- trigger fiche_report -->
                    <input id="ficheReportModalId" type="hidden" name="fiche-id" value="">
                    <button type="submit" class="btn btn-primary">Envoyer</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Contact Modal -->
<div class="modal fade cq-modal" id="ficheContactModal" tabindex="-1" role="dialog" aria-labelledby="ficheContactModalTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="ficheContactModalTitle"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="ficheContactForm" action="<?php echo esc_url(admin_url('admin-post.php')); ?>" method="post">
                    <div class="form-group">
                        <label for="ficheContactName">Ton prénom / nom *</label>
                        <input class="form-control" id="ficheContactName" name="contact-name" required>
                    </div>
                    <div class="form-group">
                        <label for="ficheContactMail">Ton mail *</label>
                        <input type="email" class="form-control" id="ficheContactMail" name="contact-email" required>
                    </div>
                    <div class="form-group">
                        <label for="ficheContactContent">Une question, une demande, une réservation... écris-lui un petit mot directement ici <i class="far fa-smile"></i></label>
                        <textarea class="form-control" id="ficheContactContent" rows="5" name="contact-content" required></textarea>
                    </div>
                    <input type="hidden" name="action" value="fiche_contact"> <!-- trigger fiche_contact -->
                    <input id="ficheContactModalId" type="hidden" name="fiche-id" value="">
                    <button type="submit" class="btn btn-primary">Envoyer</button>
                </form>
            </div>
        </div>
    </div>
</div>

<?php

wp_enqueue_script('fiche-report', get_template_directory_uri() . '/src/scripts/partials/fiche-modals.js', ['recaptcha'], CQ_THEME_VERSION, true);