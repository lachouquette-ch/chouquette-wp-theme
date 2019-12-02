<?php
/**
 * Template Name: Contact
 */

get_header();

while (have_posts()) :
    the_post();
    ?>

    <div class="container cq-page py-5">
        <h1><?php the_title() ?></h1>
        <div class="mb-5"><?php the_content(); ?></div>
        <div class="container">
            <form id="contactForm" action="<?php echo esc_url(admin_url('admin-post.php')); ?>" method="post">
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
                        <label for="inputTo">Destinataire *</label>
                        <select id="inputTo" class="form-control" name="contact-to" required>
                            <option value="" selected>Choisir un destinataire</option>
                            <option value="hello">Général (infos, suggestions, partenariats, chouquettisation, ...)</option>
                            <option value="communication">Réseaux sociaux (Insta, Facebook)</option>
                            <option value="webmaster">Webmaster (tout ce qui concerne le site)</option>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label for="inputMessage">Message *</label>
                    <textarea class="form-control" id="inputMessage" rows="10" name="contact-content" required></textarea>
                </div>
                <input type="hidden" name="action" value="contact"> <!-- trigger fiche_contact -->
                <span class="float-right"><em>* champs obligatoires</em></span>
                <button type="submit" class="btn btn-primary">Envoyer</button>
            </form>
        </div>
    </div>
<?php
endwhile;

wp_enqueue_script('template-contact', get_template_directory_uri() . '/dist/templateContact.js', null, CQ_THEME_VERSION, true);

get_footer();