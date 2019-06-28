<?php

get_header();

while (have_posts()) :
    the_post();

    // get categories
    $categories = chouquette_categories_get_tops(get_the_ID());
    $category_ids = array_column($categories, 'term_id');

    // get tags
    $tags = get_the_tags() ? get_the_tags() : [];
    $tag_ids = array_column($tags, 'term_id');

    // get fiche
    $linkFiches = get_field(CQ_FICHE_SELECTOR);
    if (!$linkFiches) {
        $linkFiches = [];
    } elseif (!is_array($linkFiches)) {
        $linkFiches = array($linkFiches);
    }
    ?>

    <?php if (!empty($linkFiches)) : ?>
    <div id="gotoFiche" class="w-100 text-center d-lg-none">
        <a href="#fichesTarget" class="py-1 px-3">
            <small><i class="fas fa-info mr-1"></i> Fiche</small>
        </a>
    </div>
<?php endif; ?>

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
            <?php echo sprintf('<div class="%s px-lg-0">', empty($linkFiches) ? 'col' : 'col-lg-8'); ?>
            <div class="cq-single-post-content-title mt-3 mb-2">
                <h1 class="mr-2"><?php the_title(); ?></h1>
            </div>
            <main class="cq-single-post-content-text">
                <?php the_content(); ?>
            </main>
        </div>

        <?php
        if (!empty($linkFiches)) :
            $fiche_markers = [];
            ?>
            <aside class="col-lg-4 pr-lg-0 pl-lg-3 px-2">
                <div id="app" class="shadow">
                    <a id="fichesTarget"></a>
                    <div id="fichesMap" class="cq-fiches-map border"></div>
                    <div id="fichesAccordion" class="cq-fiches">
                        <?php
                        foreach ($linkFiches as $ficheIndex => $fiche):
                            $fiche_fields = get_fields($fiche->ID);
                            $fiche_taxonomies = chouquette_fiche_get_taxonomies($fiche);
                            $fiche_categories = chouquette_categories_get_tops($fiche->ID);
                            ?>
                            <div class="card">
                                <div class="card-header cq-fiches-header text-center">
                                    <a id="<?php echo 'ficheLink' . $fiche->ID ?>" class="collapsed link-no-decoration w-100" data-toggle="collapse"
                                       href="<?php echo '#ficheContent' . $fiche->ID; ?>"
                                       aria-expanded="false" aria-controls="collapseTwo" v-on:click="locateFiche(<?php echo $fiche->ID; ?>)">
                                        <i class="shown far fa-minus-square float-left"></i>
                                        <i class="hidden far fa-plus-square float-left"></i>
                                        <?php echo $fiche->post_title ?>
                                    </a>
                                </div>
                                <div id="<?php echo 'ficheContent' . $fiche->ID; ?>" class="collapse" aria-labelledby="headingTwo"
                                     data-parent="#fichesAccordion">
                                    <div class="card-body p-2">
                                        <nav>
                                            <div class="nav nav-tabs link-no-decoration" id="nav-tab" role="tablist">
                                                <a class="nav-item nav-link active" id="info-tab" data-toggle="tab" href="<?php echo '#ficheInfo_' . $fiche->ID; ?>" role="tab" aria-controls="Infos"
                                                   aria-selected="true"><i class="fas fa-info mr-2"></i>Fiche</a>
                                                <?php if (!empty($fiche_fields[CQ_FICHE_MAIL])): ?>
                                                    <a class="nav-link" id="contact-tab" data-toggle="tab" href="<?php echo '#ficheContact_' . $fiche->ID; ?>" role="tab" aria-controls="Contact"
                                                       aria-selected="false"><i class="fas fa-user-edit mr-2"></i>Contact</a>
                                                <?php endif; ?>
                                            </div>
                                        </nav>
                                        <div class="tab-content" id="nav-tabContent">
                                            <div class="tab-pane fade show active" id="<?php echo 'ficheInfo_' . $fiche->ID; ?>" role="tabpanel">
                                                <div class="card cq-fiche">
                                                    <?php echo get_the_post_thumbnail($fiche->ID, 'medium', ['class' => 'card-img-top']); ?>
                                                    <div class="card-body">
                                                        <h1 class="card-title h4"><?php echo $fiche->post_title; ?></h1>
                                                        <p class="card-text"><?php echo $fiche->post_content; ?></p>
                                                        <?php
                                                        if (isset($fiche_fields[CQ_FICHE_LOCATION]['address'])) {
                                                            echo '<p class="mb-1">';
                                                            echo sprintf('<a href="%s" title="Ouvrir avec Google maps" target="_blank"><i class="fas fa-map-marker-alt pr-1"></i> %s</a>', esc_url('https://maps.google.com/?q=' . $fiche_fields[CQ_FICHE_LOCATION]['address']), $fiche_fields[CQ_FICHE_LOCATION]['address']);
                                                            echo '</p>';
                                                        }
                                                        if (chouquette_fiche_is_chouquettise($fiche->ID) && !empty($fiche_fields[CQ_FICHE_PHONE])) {
                                                            echo '<p class="mb-1">';
                                                            echo "<a href='tel:{$fiche_fields[CQ_FICHE_PHONE]}' title='Téléphone'><i class='fas fa-phone-square pr-1'></i> {$fiche_fields[CQ_FICHE_PHONE]}</a>";
                                                            echo '</p>';
                                                        }
                                                        if (chouquette_fiche_is_chouquettise($fiche->ID) && !empty($fiche_fields[CQ_FICHE_WEB])) {
                                                            echo '<p class="mb-1">';
                                                            echo sprintf('<a href="%s" title="Site internet" target="_blank"><i class="fas fa-desktop pr-1"></i> Site internet</a>', esc_url($fiche_fields[CQ_FICHE_WEB]));
                                                            echo '</p>';
                                                        }
                                                        if (chouquette_fiche_is_chouquettise($fiche->ID) && !empty($fiche_fields[CQ_FICHE_MAIL])) {
                                                            echo '<p class="mb-1">';
                                                            echo sprintf('<a href="mailto:%s" title="Email"><i class="fas fa-at pr-1"></i> Email</a>', $fiche_fields[CQ_FICHE_MAIL] . '?body=%0A---%0AEnvoy%C3%A9%20depuis%20' . get_home_url());
                                                            echo '</p>';
                                                        }
                                                        ?>
                                                        <?php if (chouquette_fiche_is_chouquettise($fiche->ID)) : ?>
                                                            <p class="mt-3 mb-0">
                                                                <span class="mr-2">Réseaux :</span>
                                                                <?php
                                                                if (!empty($fiche_fields[CQ_FICHE_FACEBOOK])) echo '<a href="' . esc_url($fiche_fields[CQ_FICHE_FACEBOOK]) . '" title="Facebook" target="_blank" class="mr-2"><i class="fab fa-facebook-f"></i></a>';
                                                                if (!empty($fiche_fields[CQ_FICHE_INSTAGRAM])) echo '<a href="' . esc_url($fiche_fields[CQ_FICHE_INSTAGRAM]) . '" title="Instagram" target="_blank" class="mr-2"><i class="fab fa-instagram"></i></a>';
                                                                if (!empty($fiche_fields[CQ_FICHE_TWITTER])) echo '<a href="' . esc_url($fiche_fields[CQ_FICHE_TWITTER]) . '" title="Twitter" target="_blank" class="mr-2"><i class="fab fa-twitter"></i></a>';
                                                                if (!empty($fiche_fields[CQ_FICHE_PINTEREST])) echo '<a href="' . esc_url($fiche_fields[CQ_FICHE_PINTEREST]) . '" title="Twitter" target="_blank" class="mr-2"><i class="fab fa-pinterest-p"></i></a>';
                                                                ?>
                                                            </p>
                                                        <?php endif; ?>
                                                    </div>
                                                    <ul class="list-group list-group-flush">
                                                        <?php if (chouquette_fiche_is_chouquettise($fiche->ID)) : ?>
                                                            <?php if (!empty($fiche_fields[CQ_FICHE_COST])): ?>
                                                                <li class="list-group-item">Prix : <span
                                                                            class="cq-fiche-price cq-fiche-price-selected"><?php echo str_repeat('$', $fiche_fields[CQ_FICHE_COST]); ?></span><span
                                                                            class="cq-fiche-price"><?php echo str_repeat('$', 5 - $fiche_fields[CQ_FICHE_COST]); ?></span></li>
                                                            <?php endif; ?>
                                                            <?php if (chouquette_fiche_has_openings($fiche_fields)): ?>
                                                                <li class="list-group-item">
                                                                    <p class="mb-2">Horaires :</p>
                                                                    <?php chouquette_fiche_openings($fiche_fields) ?>
                                                                </li>
                                                            <?php endif; ?>
                                                        <?php endif; ?>
                                                        <?php if (!empty($fiche_taxonomies)): ?>
                                                            <li class="list-group-item">
                                                                <p class="mb-0">
                                                                <ul class="cq-fiche-info">
                                                                    <?php
                                                                    foreach ($fiche_taxonomies as $taxonomy) {
                                                                        if (!empty($taxonomy['terms'])) {
                                                                            echo '<li><span class="mr-2">' . $taxonomy['label'] . '</span>';
                                                                            echo '<ol>';
                                                                            foreach ($taxonomy['terms'] as $term) {
                                                                                echo '<li>' . $term->name . '</li>';
                                                                            }
                                                                            echo '</ol>';
                                                                            echo '</li>';
                                                                        }
                                                                    }
                                                                    ?>
                                                                </ul>
                                                                </p>
                                                            </li>
                                                        <?php endif; ?>
                                                    </ul>
                                                    <?php if (chouquette_fiche_is_chouquettise($fiche->ID)) : ?>
                                                        <div class="card-footer text-center">CHOUQUETTISÉ</div>
                                                    <?php endif; ?>
                                                </div>
                                            </div>
                                            <?php if (!empty($fiche_fields[CQ_FICHE_MAIL])): ?>
                                                <div class="tab-pane fade" id="<?php echo 'ficheContact_' . $fiche->ID; ?>" role="tabpanel">
                                                    <div class="card cq-fiche-contact">
                                                        <div class="card-body">
                                                            <h2 class="card-title h4">Contact le propriétaire</h2>
                                                            <form action="<?php echo esc_url(admin_url('admin-post.php')); ?>" method="post">
                                                                <div class="form-group">
                                                                    <label for="contactSenderName">Ton prénom / nom</label>
                                                                    <input class="form-control" id="contactSenderName" name="contact-name" required>
                                                                </div>
                                                                <div class="form-group">
                                                                    <label for="contactSenderMail">Ton mail</label>
                                                                    <input type="email" class="form-control" id="contactSenderMail" name="contact-email" required>
                                                                </div>
                                                                <div class="form-group">
                                                                    <label for="contactSenderContent">Ton message</label>
                                                                    <textarea class="form-control" id="contactSenderContent" rows="5" name="contact-content" required></textarea>
                                                                </div>
                                                                <input type="hidden" name="recaptcha-response"> <!-- recaptcha v3 -->
                                                                <input type="hidden" name="action" value="fiche_contact"> <!-- trigger fiche_contact -->
                                                                <input type="hidden" name="fiche-id" value="<?php echo $fiche->ID ?>"> <!-- trigger fiche_contact -->
                                                                <button type="submit" class="btn btn-primary">Envoyer</button>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </aside>

            <!-- Only load map if has fiches -->
            <script src="https://cdn.jsdelivr.net/npm/vue@2.6.0/dist/vue.js"></script>
            <script src="https://cdnjs.cloudflare.com/ajax/libs/axios/0.19.0/axios.min.js"></script>
            <script>
                var map = null; // google map

                function initMap() {
                    map = new google.maps.Map(document.getElementById('fichesMap'), {
                        zoom: 15,
                        disableDefaultUI: true,
                        gestureHandling: 'cooperative',
                        restriction: {
                            latLngBounds: SWITZERLAND_BOUNDS,
                            strictBounds: false,
                        },
                        styles: MAP_STYLES,
                    });

                    google.maps.event.addListener(map, "click", function (event) {
                        app.clearFiches(true);
                        if (app.markers.size > 1) map.fitBounds(app.bounds);
                    });

                    app.addLocationsToMap();
                };

                var app = new Vue({
                    el: '#app',
                    data() {
                        return {
                            locations: new Map(),
                            markers: new Map(),
                            bounds: null,
                            currentMarker: null,
                            currentLocation: null
                        }
                    },
                    computed: {
                        // helper to show/hide fiche
                        showLocation: function (id) {
                            return true;
                            //locations.get(<?php echo $fiche->ID; ?>).visibility
                        }
                    },
                    methods: {
                        addLocationsToMap: function () {
                            axios({
                                method: 'get',
                                url: 'http://chouquette.test/wp-json/cq/v1/post/<?php echo get_the_ID() ?>/location',
                            })
                                .then(function (response) {
                                    app.bounds = new google.maps.LatLngBounds();
                                    response.data.forEach(function (loc) {
                                        var marker = new google.maps.Marker({position: loc, icon: loc.icon, map: map});
                                        app.markers.set(loc.id, marker);
                                        app.locations.set(loc.id, loc);
                                        app.bounds.extend(marker.getPosition());

                                        // action on marker
                                        marker.addListener('click', function () {
                                            app.clearFiches(true);

                                            // set currentLocation and toggle
                                            app.currentLocation = loc;
                                            $(`#ficheContent${app.currentLocation.id}`).collapse('toggle');
                                            if (app.currentMarker != this) {
                                                app.currentMarker = this;
                                                map.setZoom(ZOOM_LEVEL_ACTIVED);
                                                map.setCenter(app.currentMarker.getPosition());
                                                bounce(app.currentMarker);
                                            } else {
                                                app.currentMarker = null;
                                                app.currentLocation = null;
                                            }
                                        });
                                    });

                                    app.clearFiches();
                                });
                        },
                        // stop current animation and close fiches
                        clearFiches: function () {
                            if (this.currentMarker) {
                                this.currentMarker.setAnimation(null);
                            }

                            if (app.markers.size > 1) {
                                map.fitBounds(app.bounds);
                            } else if (app.markers.size) {
                                map.setCenter(app.markers.values().next().value.getPosition());
                            }
                        },
                        // locate on fiche on the map and activate animation
                        locateFiche: function (ficheId) {
                            this.clearFiches();

                            // no need to toggle fiche display. Bootstrap does that
                            targetLocation = this.locations.get(ficheId);
                            if (targetLocation != app.currentLocation) {
                                app.currentLocation = targetLocation;
                                app.currentMarker = app.markers.get(ficheId);
                                map.setZoom(ZOOM_LEVEL_ACTIVED);
                                map.setCenter(app.currentMarker.getPosition());
                                bounce(app.currentMarker);
                            } else {
                                app.currentMarker = null;
                                app.currentLocation = null;
                            }
                        },
                    }
                })
            </script>
        <?php endif; ?>
        </div>

        <div class="row cq-single-post-author">
            <div class="col border shadow-sm text-center m-3 m-lg-0">
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
                        $args = array(
                            'posts_per_page' => 6,
                            'post__not_in' => array(get_the_ID()),
                            'no_found_rows' => true
                        );
                        if (!empty($category_ids)) {
                            $args['category__in'] = $category_ids;
                        }
                        if (!empty($tag_ids)) {
                            $args['tag__in'] = $tag_ids;
                        }
                        $tops_posts = new WP_Query($args);
                        if ($tops_posts->have_posts()) :
                            while ($tops_posts->have_posts()) :
                                $tops_posts->the_post();
                                ?>
                                <div class="swiper-slide bg-dark text-white"> <?php
                                    get_template_part('template-parts/article-card');
                                    ?> </div> <?php
                            endwhile;
                            // Restore original Post Data
                            wp_reset_postdata();
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
                    <?php comments_template(); ?>
                </div>
            </div>
        <?php endif; ?>
    </article>

    <script>
        var recaptchaEnabler = function () {
            grecaptcha.execute('<?php echo CQ_RECAPTCHA_SITE ?>', {action: 'article'}).then(function (token) {
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