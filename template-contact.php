<?php
/**
 * Template Name: Contact
 */

get_header();

while (have_posts()) :
    the_post();
    ?>

    <div class="container cq-contact my-5">
        <h1 class="mb-3 cq-font text-center"><?php the_title() ?></h1>
        <div class="mb-5 text-center"><?php the_content(); ?></div>
        <div class="container">
            <form action="<?php echo esc_url(admin_url('admin-post.php')); ?>" method="post">
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="inputName">Nom (et société) *</label>
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
                                    echo sprintf("<option title='%s' value='%s'>%s %s</option>", $term->name, $term->slug, $term->name, $ambassador ? "({$ambassador->display_name})" : '');
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
<?php
endwhile;

wp_enqueue_script('template_contact', get_template_directory_uri() . '/template-contact.js', null, null, true);

get_footer();