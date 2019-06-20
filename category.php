<?php
/**
 * The template for displaying archive pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Chouquette_thème
 */

get_header();

$sub_categories = get_categories(array(
    'child_of' => get_queried_object()->term_id,
    'hide_empty' => 1
));

$locations = get_terms(array(
    'taxonomy' => CQ_TAXONOMY_LOCALISATION,
    'hide_empty' => false,
    'orderby' => 'term_group'
));

?>
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-6 order-md-1 p-0">
                <div id="fichesMap" class="category-map"></div>
            </div>
            <div class="col-md-6 order-md-0 p-0 category-result-col">
                <h1 class="text-center my-4 cq-font"><?php echo single_cat_title(); ?></h1>
                <form id="app-form" class="mb-4 px-4">
                    <h3 class="mb-3 h5">Je recherche :</h3>
                    <div class="form-row">
                        <div class="form-group col-md-4">
                            <select id="search-cat" class="form-control" title="Sous catégorie" name="cat"
                                    onchange="app.refreshCriterias(this.options[this.selectedIndex].value)">
                                <option title="Bars / Pubs" value="<?php echo get_queried_object()->slug ?>">Je veux ...</option>
                                <?php
                                foreach ($sub_categories as $sub_category) {
                                    echo sprintf("<option title='%s' value='%s' %s>%s</option>", $sub_category->name, $sub_category->slug, $_GET['cat'] == $sub_category->slug ? 'selected' : '', $sub_category->name);
                                }
                                ?>
                            </select>
                        </div>
                        <div class="form-group col-md-4">
                            <select class="form-control" title="Où veux-tu aller ?" name="loc">
                                <option title="" value="">Où ça ...</option>
                                <?php
                                foreach ($locations as $location) {
                                    $location_display = $location->parent != 0 ? ' • ' : '';
                                    $location_display .= $location->name;
                                    echo sprintf("<option title='%s' value='%s' %s>%s</option>", $location->name, $location->slug, $_GET['loc'] == $location->slug ? 'selected' : '', $location_display);
                                }
                                ?>
                            </select>
                        </div>
                        <div class="form-group col-md-4">
                            <input class="form-control" type="text" placeholder="Plus précisement ..." name="search" <?php echo empty($_GET['search']) ? '' : sprintf('value="%s"', $_GET['search']) ?>>
                        </div>
                    </div>
                    <button class="btn btn-sm btn-secondary mr-1" type="button" data-toggle="collapse" data-target="#collapseCriteria">Plus de critères</button>
                    <button class="btn btn-sm btn-secondary mr-1" type="reset">Réinitialiser</button>
                    <button class="btn btn-sm btn-primary" type="submit">Rechercher</button>
                    <div id="collapseCriteria" class="collapse pl-3 mt-3 category-criteria">
                        <div class="form-inline" v-for="criteria in criterias">
                            <span class="col-form-label">{{ criteria.label }}</span>
                            <div class="form-check ml-3" v-for="term in criteria.terms">
                                <input class="form-check-input" type="checkbox" :name="criteria.name + '[]'" :value="term.slug" :checked="term.checked">
                                <label class="form-check-label">{{ term.name }}</label>
                            </div>
                        </div>
                    </div>
                </form>

                <?php
                // filter category
                $args = array(
                    'post_type' => 'fiche',
                    'category_name' => isset($_GET['cat']) ? $_GET['cat'] : get_queried_object()->slug,
                );
                // filter search
                if (!empty($_GET['search'])) {
                    $args['s'] = $_GET['search'];
                }
                // filter location
                $args['tax_query'] = array('relation' => 'AND');
                if (!empty($_GET['loc'])) {
                    $args['tax_query'][] = array(
                        'taxonomy' => 'cq_location',
                        'field' => 'slug',
                        'terms' => $_GET['loc'],
                    );
                }
                // filter criterias
                $filtered_params = array_filter($_GET, function ($key) {
                    return substr_compare($key, 'cq_', 0, 3) == false;
                }, ARRAY_FILTER_USE_KEY);
                foreach ($filtered_params as $key => $value) {
                    $args['tax_query'][] = array(
                        'taxonomy' => $key,
                        'field' => 'slug',
                        'terms' => $value,
                        'operator' => 'AND'
                    );
                }
                $loop = new WP_Query($args);

                echo '<div class="d-flex justify-content-around flex-wrap category-fiche-container py-4">';
                if ($loop->have_posts()):
                    while ($loop->have_posts()) :
                        $loop->the_post();
                        $category = get_the_category(get_the_ID());
                        $categories = chouquette_categories_get_tops(get_the_ID());
                        $taxonomies = chouquette_fiche_get_taxonomies(get_post());
                        $posts = get_posts(array(
                            'meta_query' => array(
                                array(
                                    'key' => CQ_FICHE_SELECTOR, // name of custom field
                                    'value' => '"' . get_the_ID() . '"', // matches exactly "123", not just 123. This prevents a match for "1234"
                                    'compare' => 'LIKE'
                                )
                            )
                        ));
                        ?>
                        <article class="card category-fiche mb-4">
                            <div class="card-header category-fiche-header p-2" style="background-image: url('<?php esc_url(the_post_thumbnail_url('medium_large')); ?>');">
                                <div class="category-fiche-header-icon">
                                    <?php //echo chouquette_taxonomy_logo($category[0], 'black'); ?>
                                </div>
                            </div>
                            <div class="card-body">
                                <h5 class="card-title"><?php the_title(); ?></h5>
                                <p class="card-text"><?php the_content(); ?></p>
                                <p class="card-text small text-secondary">
                                    <?php
                                    $terms = chouquette_fiche_flatten_terms($taxonomies);
                                    echo implode(", ", array_slice($terms, 0, 4));
                                    echo sizeof($terms) > 4 ? '...' : '';
                                    ?>
                                </p>
                                <div class="w-100">
                                    <?php
                                    if (!empty($posts)) {
                                        $lastest_post = $posts[0];
                                        echo sprintf('<a href="%s" title="%s" class="btn btn-sm btn-outline-secondary">Article</a>', get_the_permalink($lastest_post), $lastest_post->post_title);
                                    }
                                    ?>
                                    <a href="" class="btn btn-sm btn-outline-secondary">Voir</a>
                                </div>
                            </div>
                        </article>
                    <?php
                    endwhile;
                else:
                    echo "<span>Pas de résultat pour cette recherche</span>";
                endif;
                echo '</div>';
                ?>
            </div>
        </div>
    </div>

    <script>
        var markers = new Map();

        function initMap() {
            let map = new google.maps.Map(document.getElementById('fichesMap'), {
                zoom: 15,
                disableDefaultUI: true,
                fullscreenControl: true,
                gestureHandling: 'greedy',
                restriction: {
                    latLngBounds: SWITZERLAND_BOUNDS,
                    strictBounds: false,
                },
                styles: MAP_STYLES,
                center: LAUSANNE_LOCALISATION
            });

            var contentString = `
            <div class="category-info-window container-fluid">
                <div class="row">
                    <div class="col-lg-3 text-center p-0 mb-2 mb-lg-0">
                        <img width="75px" class="rounded" src="http://chouquette.test/wp-content/uploads/2018/11/Buet-web-07a-150x150.jpg" alt="Generic placeholder image">
                    </div>
                    <div class="col-lg px-0 px-lg-2">
                        <h5 class="mt-0">Maison Buet – Café Boutique</h5>
                        <div>
                            <label>Internet :</label>
                            <span>
                                <a class="link-secondary mr-2" href="https://www.facebook.com/maisonbuet/" title="Facebook" target="_blank" class="mr-2"><i class="fab fa-facebook-f"></i></a>
                                <a class="link-secondary mr-2" href="https://www.instagram.com/maisonbuet/" title="Instagram" target="_blank" class="mr-2"><i class="fab fa-instagram"></i></a>
                                <a class="link-secondary link-no-decoration mr-2" href="http://www.maisonbuet.ch" title="Site internet" target="_blank"><i class="fas fa-desktop"></i> Site</a>
                            </span>
                        </div>
                        <div>
                            <label>Contact :</label>
                            <span>
                                <a class="link-secondary link-no-decoration mr-1" href="mailto:info@maisonbuet.ch?body=%0A---%0AEnvoy%C3%A9%20depuis%20http://chouquette.test" title="Email"><i class="fas fa-at"></i> Mail</a>
                                <a class="link-secondary link-no-decoration mr-1" href="tel:021 312 62 90" title="Téléphone"><i class="fas fa-phone"></i> +41 21 312 62 90</a>
                            </span>
                        </div>
                        <div>
                            <label>Prix :</label>
                            <span class="cq-fiche-price cq-fiche-price-selected">$$</span><span class="cq-fiche-price">$$$</span>
                        </div>
                        <div>
                            <label>Horaires :</label>
                            <a class="link-secondary link-no-decoration" data-toggle="collapse" href="#horaires" role="button">Ouvert (12:00-15:00) <i class="fas fa-caret-down"></i></a>
                            <ul class="collapse mb-0" id="horaires">
                                <li><label>Lundi</label> 12:00-15:00</li>
                                <li><label>Mardi</label> 12:00-15:00</li>
                                <li><label>Mercredi</label> 12:00-15:00</li>
                                <li><label>Jeudi</label> 12:00-15:00</li>
                                <li><label>Vendredi</label> 12:00-15:00</li>
                                <li><label>Samedi</label> 12:00-15:00</li>
                                <li><label>Dimanche</label> 12:00-15:00</li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="row mt-2">Réserve ton ménage en quelques clics seulement !</div>
                <div class="row mt-3 font-italic">Accès Wi-Fi, Plats à emporter, Service de livraison, Terrasse...</div>
            </div>`;

            var infowindow = new google.maps.InfoWindow({
                content: contentString
            });

            var marker = new google.maps.Marker({position: LAUSANNE_LOCALISATION, map: map});
            marker.addListener('click', function () {
                var self = this;
                self.setAnimation(google.maps.Animation.BOUNCE);
                infowindow.open(map, marker);
                window.setTimeout(function () {
                    self.setAnimation(null);
                }, 2000);
            });
            //var bounds = new google.maps.LatLngBounds();
            //$.getJSON('http://chouquette.test/wp-json/cq/v1/post/<?php //echo get_the_ID() ?>///localisation', function (fiches) {
            //    fiches.forEach(function (fiche) {
            //        var marker = new google.maps.Marker({position: fiche, map: map});
            //        marker.addListener('click', function () {
            //            bounce(markers.get(fiche.id));
            //            document.getElementById('ficheLink' + fiche.id).click();
            //        });
            //        markers.set(fiche.id, marker);
            //        bounds.extend(marker.getPosition());
            //    });
            //    if (markers.size > 1) {
            //        map.fitBounds(bounds);
            //    } else {
            //        map.setCenter(markers.values().next().value.getPosition());
            //    }
            //});
        };
    </script>

    <script src="https://cdn.jsdelivr.net/npm/vue@2.6.0/dist/vue.js"></script>
    <script src="https://unpkg.com/axios/dist/axios.min.js"></script>
    <script>
        var app = new Vue({
            el: '#app-form',
            data() {
                return {
                    criterias: null,
                    category: null,
                    $_params: null
                }
            },
            methods: {
                refreshCriterias: function (category) {
                    axios
                        .get(`http://chouquette.test/wp-json/cq/v1/category/${category}/taxonomy`)
                        .then(function (response) {
                            response.data.forEach(function (taxonomy) {
                                taxonomy.terms.forEach(function (term) {
                                    term.checked = app.$_params.getAll(taxonomy.name).includes(term.slug);
                                });
                            });
                            app.criterias = response.data;
                        });
                }
            },
            created() {
                // create instance of URLSearch
                var queryParams = location.search.replace(/%5B%5D/g, ''); // remove []
                this.$_params = new URLSearchParams(queryParams);
            },
            mounted() {
                var selectCategory = document.getElementById("search-cat");
                this.category = selectCategory.options[selectCategory.selectedIndex].value;
                this.refreshCriterias(this.category);
            }
        })
    </script>
<?php
get_footer();
