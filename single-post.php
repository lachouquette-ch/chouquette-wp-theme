<?php
get_header();

while (have_posts()) :
    the_post();

    // get fiche
    $fiche = get_field('link_fiche')[0];
    $fiche_fields = get_fields($fiche->ID);
    ?>

    <article class="container cq-single-post">
        <div class="row cq-single-post-header mt-0 mt-lg-4">
            <div class="col p-0">
                <?php the_post_thumbnail('large', ['class' => 'cq-single-post-header-img']); ?>
                <?php echo get_avatar(get_the_author_meta('ID'), 150, null, get_the_author(), ['class' => 'cq-single-post-header-author-img rounded-circle']); ?>
                <div class="cq-single-post-header-meta">
                    <span>par <?php the_author() ?></span>
                    <span>le
                        <?php
                        $print_date = get_the_modified_date() ? get_the_modified_date() : get_the_date();
                        echo $print_date;
                        ?>
                    </span>
                    <span>dans <?php the_category(' / '); ?></span>
                </div>
            </div>
        </div>

        <div class="row cq-single-post-content">
            <div class="col-lg-8 px-lg-0">
                <div class="cq-single-post-content-title mt-3 mb-2">
                    <h1 class="mr-2"><?php the_title(); ?></h1>
                </div>
                <main class="cq-single-post-content-text">
                    <?php the_content(); ?>
                </main>
            </div>

            <aside class="col-lg-4 pr-lg-0 pl-lg-3">
                <a id="ficheTarget"></a>
                <div id="fiche" class="pt-4">
                    <ul class="nav nav-tabs cq-fiche-tabs" id="ficheTab" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" id="info-tab" data-toggle="tab" href="#ficheInfo" role="tab" aria-controls="Infos" aria-selected="true"><i class="fas fa-info mr-2"></i>
                                Fiche</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="contact-tab" data-toggle="tab" href="#ficheContact" role="tab" aria-controls="Contact" aria-selected="false"><i class="fas fa-user-edit mr-2"></i>
                                Contact</a>
                        </li>
                    </ul>

                    <div class="tab-content" id="ficheTabContent">
                        <div class="tab-pane fade show active" id="ficheInfo" role="tabpanel" aria-labelledby="info-tab">
                            <div class="card cq-fiche">
                                <?php echo get_the_post_thumbnail($fiche->ID, 'medium', ['class' => 'card-img-top']); ?>
                                <div class="card-body">
                                    <h1 class="card-title h4"><?php echo $fiche->post_title; ?></h1>
                                    <p class="card-text"><?php echo $fiche->post_content; ?></p>
                                    <p class="mb-1">
                                        <?php print_r($fiche_fields); ?>
                                        <?php echo '<a href="' . esc_url(sprintf("https://maps.google.com/?q=%s", $fiche_fields['location']['address'])) . '" title="Ouvrir avec Google maps" target="_blank"><i class="fas fa-map-marker-alt pr-1"></i> ' . $fiche_fields['location']['address'] . '</a>'; ?>
                                    </p>
                                    <p class="mb-1"><a href="<?php echo esc_url(sprintf("tel:%s", $fiche_fields['telephone'])); ?>" title="Téléphone"><i
                                                    class="fas fa-phone-square pr-1"></i> <?php echo $fiche_fields['telephone']; ?></a></p>
                                    <p class="mb-1"><a href="<?php echo esc_url($fiche_fields['website']) ?>" title="Site internet" target="_blank"><i class="fas fa-desktop pr-1"></i> Site
                                            internet</a></p>
                                    <p class="mb-1"><a href="<?php echo esc_url(sprintf("mailto::%s", $fiche_fields['mail'])); ?>" title="Email"><i class="fas fa-at pr-1"></i> Email</a></p>
                                    <p class="mt-3 mb-0">
                                        <span class="mr-2">Réseaux :</span>
                                        <?php
                                        if (!empty($fiche_fields['sn_facebook'])) echo '<a href="' . esc_url($fiche_fields['sn_facebook']) . '" title="Facebook" target="_blank" class="mr-2"><i class="fab fa-facebook-f"></i></a>';
                                        if (!empty($fiche_fields['sn_instagram'])) echo '<a href="' . esc_url($fiche_fields['sn_instagram']) . '" title="Instagram" target="_blank" class="mr-2"><i class="fab fa-instagram"></i></a>';
                                        if (!empty($fiche_fields['sn_twitter'])) echo '<a href="' . esc_url($fiche_fields['sn_twitter']) . '" title="Twitter" target="_blank" class="mr-2"><i class="fab fa-twitter"></i></a>';
                                        if (!empty($fiche_fields['sn_pinterest'])) echo '<a href="' . esc_url($fiche_fields['sn_pinterest']) . '" title="Twitter" target="_blank" class="mr-2"><i class="fab fa-pinterest-p"></i></a>';
                                        ?>
                                    </p>
                                </div>
                                <ul class="list-group list-group-flush">
                                    <li class="list-group-item">Prix : <span class="cq-fiche-price cq-fiche-price-selected"><?php echo str_repeat('$', $fiche_fields['cost']); ?></span><span
                                                class="cq-fiche-price"><?php echo str_repeat('$', 5 - $fiche_fields['cost']); ?></span></li>
                                    <li class="list-group-item">
                                        <p class="mb-2">Horaires :</p>
                                        <ul>
                                            <li>Lundi-Vendredi : 19-23h</li>
                                            <li>Samedi : 9-23h</li>
                                            <li>Dimanche : 11-20h</li>
                                        </ul>
                                    </li>
                                    <li class="list-group-item">
                                        <p class="mb-2">Infos :</p>
                                        <p class="mb-0">
                                            <i class="fas fa-child mr-2"></i><i class="fas fa-wheelchair mr-2"></i><i class="fas fa-wifi mr-2"></i>
                                        </p>
                                    </li>
                                </ul>
                                <?php if (chouquette_is_chouquettise($fiche_fields)) : ?>
                                    <div class="card-footer text-center">
                                        CHOUQUETTISÉ
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="ficheContact" role="tabpanel" aria-labelledby="contact-tab">
                            <div class="card cq-fiche-contact">
                                <div class="card-body">
                                    <h2 class="card-title h4">Contact le propriétaire</h2>
                                    <form>
                                        <div class="form-group">
                                            <label for="contactSenderName">Ton prénom / nom</label>
                                            <input class="form-control" id="contactSenderName">
                                        </div>
                                        <div class="form-group">
                                            <label for="contactSenderMail">Ton mail</label>
                                            <input type="email" class="form-control" id="contactSenderMail">
                                        </div>
                                        <div class="form-group">
                                            <label for="contactSenderContent">Ton message</label>
                                            <textarea class="form-control" id="contactSenderContent" rows="5"></textarea>
                                        </div>
                                        <button type="submit" class="btn btn-primary">Envoyer</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </aside>
        </div>

        <div class="row cq-single-post-author">
            <div class="col border text-center m-3 m-lg-0">
                <?php echo get_avatar(get_the_author_meta('ID'), 150, null, get_the_author(), ['class' => 'cq-single-post-header-author-img rounded-circle']); ?>
                <h5 class="mt-3 mb-4"><?php the_author() ?></h5>
                <p><?php the_author_meta('description'); ?></p>
            </div>
        </div>

        <div class="row cq-single-post-similar mt-3 mt-lg-5">
            <div class="col">
                <h3 class="mb-3 text-center">Articles similaires</h3>
                <div class="swiper-container">
                    <div class="swiper-wrapper">
                        <?php
                        $tops_posts = new WP_Query('posts_per_page=10');
                        if ($tops_posts->have_posts()) :
                            while ($tops_posts->have_posts()) :
                                $tops_posts->the_post();
                                ?>
                                <div class="swiper-slide bg-dark text-white"> <?php
                                    get_template_part('template-parts/article-card');
                                    ?> </div> <?php
                            endwhile;
                        endif;
                        ?>
                    </div>
                    <!-- Add Arrows -->
                    <div class="swiper-button-next swiper-button-black"></div>
                    <div class="swiper-button-prev swiper-button-black"></div>
                </div>
            </div>
        </div>

        <?php if (comments_open() || get_comments_number()) : ?>
            <div class="row cq-single-post-comments mt-3 mt-lg-5">
                <div class="col">
                    <h3 class="mb-3 text-center">Commentaires</h3>
                    <?php comments_template(); ?>
                </div>
            </div>
        <?php endif; ?>
    </article>

<?php
endwhile;
get_footer();