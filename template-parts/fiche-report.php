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
                <form action="<?php echo esc_url(admin_url('admin-post.php')); ?>" method="post">
                    <div class="form-group">
                        <label for="ficheReportText">Une erreure, une remarque, une suggestion sur la fiche ? Merci de nous en faire part <i class="far fa-smile"></i></label>
                        <textarea class="form-control" name="report-text" id="ficheReportText" rows="10" required></textarea>
                    </div>
                    <input type="hidden" name="recaptcha-response"> <!-- recaptcha v3 -->
                    <input type="hidden" name="action" value="fiche_report"> <!-- trigger fiche_contact -->
                    <input id="ficheReportModalId" type="hidden" name="fiche-id" value="">
                    <button type="submit" class="btn btn-primary">Envoyer</button>
                </form>
            </div>
        </div>
    </div>
</div>

<?php

wp_enqueue_script('fiche-report', get_template_directory_uri() . '/template-parts/fiche-report.js', ['recaptcha'], CQ_THEME_VERSION, true);