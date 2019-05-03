<?php
/**
 * Template Name: Contact
 */

get_header();

while (have_posts()) :
    the_post();
    ?>

    <div class="container cq-contact mb-5">
        <h1 class="mb-5 cq-font text-center"><?php the_title() ?></h1>
        <div class="mb-5 text-center"><?php the_content(); ?></div>
        <div class="container">
            <form>
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="inputName">Nom</label>
                        <input type="text" class="form-control" id="inputName" placeholder="Nom" required>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="inputMail">Email</label>
                        <input type="email" class="form-control" id="inputMail" placeholder="Email" required>
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="inputSubject">Sujet</label>
                        <input type="text" class="form-control" id="inputSubject" placeholder="Sujet" required>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="inputCanton">Canton</label>
                        <select id="inputCanton" class="form-control" required>
                            <option value="">Canton...</option>
                                <?php
                                $terms = get_terms(array(
                                    'taxonomy' => CQ_TAXONOMY_LOCALISATION,
                                    'hide_empty' => false,
                                    'parent' => 0,
                                    'orderby' => 'name'
                                ));
                                foreach ($terms as $term) {
                                    echo sprintf("<option title='%s' value='%s'>%s</option>", $term->name, $term->slug, $term->name);
                                }
                                ?>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label for="inputMessage">Message</label>
                    <textarea class="form-control" id="inputMessage" rows="10" required></textarea>
                </div>
                <button type="submit" class="btn btn-primary">Envoyer</button>
            </form>
        </div>
    </div>
<?php
endwhile;

get_footer();