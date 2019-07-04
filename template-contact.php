<?php
/**
 * Template Name: Contact
 */

get_header();

while (have_posts()) :
    the_post();
    ?>

    <div class="container cq-contact my-5">
        <h1 class="mb-5 cq-font text-center"><?php the_title() ?></h1>
        <div class="mb-5 text-center"><?php the_content(); ?></div>
        <div class="container">
            <form action="<?php echo esc_url(admin_url('admin-post.php')); ?>" method="post">
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="inputName">Nom *</label>
                        <input type="text" class="form-control" id="inputName" placeholder="Nom" name="contact-name" required>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="inputMail">Email *</label>
                        <input type="email" class="form-control" id="inputMail" placeholder="Email" name="contact-email" required>
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="inputSubject">Sujet *</label>
                        <input type="text" class="form-control" id="inputSubject" placeholder="Sujet" name="contact-subject" required>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="inputCanton">Canton *</label>
                        <select id="inputCanton" class="form-control" name="contact-localisation" required>
                            <option value="" selected>Tous</option>
                                <?php
                                $terms = get_terms(array(
                                    'taxonomy' => CQ_TAXONOMY_LOCATION,
                                    'hide_empty' => false,
                                    'parent' => 0,
                                    'orderby' => 'name'
                                ));
                                foreach ($terms as $term) {
                                    $ambassador = get_field(CQ_LOCALISATION_AMBASSADOR, chouquette_acf_generate_post_id($term));
                                    echo "<option title='{$term->name}' value='{$term->slug}'>{$term->name} ({$ambassador->display_name})</option>";
                                }
                                ?>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label for="inputMessage">Message *</label>
                    <textarea class="form-control" id="inputMessage" rows="10" name="contact-content" required></textarea>
                </div>
                <input type="hidden" name="recaptcha-response"> <!-- recaptcha v3 -->
                <input type="hidden" name="action" value="contact"> <!-- trigger fiche_contact -->
                <span class="float-right"><em>* champs obligatoires</em></span>
                <button type="submit" class="btn btn-primary">Envoyer</button>
            </form>
        </div>
    </div>

    <script>
        var recaptchaEnabler = function () {
            grecaptcha.execute('<?php echo CQ_RECAPTCHA_SITE ?>', {action: 'contact'}).then(function (token) {
                var elements = document.getElementsByName("recaptcha-response");
                for (i = 0; i < elements.length; i++) {
                    elements[i].value = token;
                }
            });
        };
    </script>
<?php
endwhile;

get_footer();