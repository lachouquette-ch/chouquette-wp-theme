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
    <div id="app" class="container-fluid">
        <div class="row">
            <div class="col-md-6 order-md-1 p-0">
                <a class="category-fiche-target" id="targetMap"></a>
                <span id="colTrigger" class="d-none d-md-inline"></span>
                <div id="fichesMap" class="category-map"></div>
            </div>
            <div class="col-md-6 order-md-0 p-0 category-result-col">
                <h1 class="text-center my-4 cq-font"><?php echo single_cat_title(); ?></h1>
                <form class="mb-4 px-4">
                    <h3 class="mb-3 h5">Je recherche :</h3>
                    <div class="form-row">
                        <div class="form-group col-md-4">
                            <select id="search-cat" class="form-control" title="Sous catégorie" name="cat"
                                    onchange="app.refreshCriterias(this.options[this.selectedIndex].value)">
                                <option title="Bars / Pubs" value="<?php echo get_queried_object()->slug ?>">Je veux ...</option>
                                <?php
                                foreach ($sub_categories as $sub_category) {
                                    $attr_selected = isset($_GET['cat']) && $_GET['cat'] == $sub_category->slug ? 'selected' : '';
                                    echo sprintf("<option title='%s' value='%s' %s>%s</option>", $sub_category->name, $sub_category->slug, $attr_selected, $sub_category->name);
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
                                    $attr_selected = isset($_GET['loc']) && $_GET['loc'] == $location->slug ? 'selected' : '';
                                    echo sprintf("<option title='%s' value='%s' %s>%s</option>", $location->name, $location->slug, $attr_selected, $location_display);
                                }
                                ?>
                            </select>
                        </div>
                        <div class="form-group col-md-4">
                            <input class="form-control" type="text" placeholder="Plus précisement ..." name="search" <?php echo empty($_GET['search']) ? '' : sprintf('value="%s"', $_GET['search']) ?>>
                        </div>
                    </div>
                    <button class="btn btn-sm btn-secondary mr-1" type="button" data-toggle="collapse" data-target="#collapseCriteria">Plus de critères</button>
                    <button class="btn btn-sm btn-primary" type="submit">Rechercher</button>
                    <div id="collapseCriteria" class="collapse pl-3 mt-3 category-criteria">
                        <div class="form-inline" v-for="criteria in criterias">
                            <span class="col-form-label">{{ criteria.label }}</span>
                            <div class="form-check ml-3" v-for="term in criteria.terms">
                                <input class="form-check-input" type="checkbox" :id="term.slug" :name="criteria.name + '[]'" :value="term.slug" :checked="term.checked">
                                <label class="form-check-label" :for="term.slug">{{ term.name }}</label>
                            </div>
                        </div>
                        <a href="#" class="d-block link-secondary small mt-3" v-on:click="resetCriterias">Tout déselectionner</a>
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
                        <a class="category-fiche-target" id="<?php echo 'target' . get_the_ID(); ?>"></a>
                        <article id="<?php echo get_the_ID(); ?>" class="card category-fiche mb-4">
                            <div class="card-header category-fiche-header p-2" style="background-image: url('<?php esc_url(the_post_thumbnail_url('medium_large')); ?>');">
                                <div class="category-fiche-header-icon">
                                    <?php echo chouquette_taxonomy_logo($category[0], 'black'); ?>
                                </div>
                            </div>
                            <div class="card-body">
                                <h5 class="card-title"><?php the_title(); ?></h5>
                                <p class="card-text"><?php the_content(); ?></p>
                                <?php
                                $terms = chouquette_fiche_flatten_terms($taxonomies);
                                if (!empty($terms)):
                                    ?>
                                    <p class="card-text small text-secondary">
                                        <?php
                                        echo implode(", ", array_slice($terms, 0, 4));
                                        echo sizeof($terms) > 4 ? '...' : '';
                                        ?>
                                    </p>
                                <?php endif; ?>
                                <div class="w-100">
                                    <?php
                                    if (!empty($posts)) {
                                        $lastest_post = $posts[0];
                                        echo sprintf('<button href="%s" title="%s" class="btn btn-sm btn-outline-secondary">Article</button>', get_the_permalink($lastest_post), esc_html($lastest_post->post_title));
                                    }
                                    ?>
                                    <button href="" class="btn btn-sm btn-outline-secondary" v-on:click="locateFiche(<?php echo get_the_ID(); ?>)">Voir</button>
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
        var map = null; // google map

        function initMap() {
            map = new google.maps.Map(document.getElementById('fichesMap'), {
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

            google.maps.event.addListener(map, "click", function (event) {
                if (app.currentInfoWindow) app.currentInfoWindow.close();
                if (app.currentMarker) app.currentMarker.setAnimation(null);
                if (app.markers.size > 1) map.fitBounds(app.bounds);
            });

            app.addFichesToMap();
        };
    </script>

    <script src="https://cdn.jsdelivr.net/npm/vue@2.6.0/dist/vue.js"></script>
    <script src="https://unpkg.com/axios/dist/axios.min.js"></script>
    <script>
        var app = new Vue({
            el: '#app',
            data() {
                return {
                    criterias: null,
                    category: null,
                    currentMarker: null,
                    markers: new Map(),
                    currentInfoWindow: null,
                    infoWindows: new Map(),
                    bounds: null,
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
                },
                resetCriterias: function () {
                    this.criterias.forEach(function (taxonomy) {
                        taxonomy.terms.forEach(function (term) {
                            term.checked = false;
                        })
                    })
                },
                clearMap: function () {
                    // stop current animation
                    if (app.currentMarker) app.currentMarker.setAnimation(null);
                    // close current infoWindow
                    if (app.currentInfoWindow) app.currentInfoWindow.close();
                },
                _colEnabled: function () {
                    return window.getComputedStyle(document.getElementById('colTrigger')).display != "none";
                },
                addFichesToMap: function () {
                    axios({
                        method: 'get',
                        url: `http://chouquette.test/wp-json/cq/v1/category/${this.category}/fiche` + location.search,
                    })
                        .then(function (response) {
                            app.bounds = new google.maps.LatLngBounds();
                            response.data.forEach(function (fiche) {
                                // create info window
                                var infoWindow = new google.maps.InfoWindow({content: fiche.infoWindow});
                                app.infoWindows.set(fiche.id, infoWindow);

                                // create marker
                                var marker = new google.maps.Marker({position: fiche.location, map: map});
                                app.bounds.extend(marker.getPosition());
                                app.markers.set(fiche.id, marker);

                                // action on marker
                                marker.addListener('click', function () {
                                    // only for column display
                                    if (app._colEnabled()) {
                                        // goto fiche
                                        var elmnt = document.getElementById('target' + fiche.id);
                                        elmnt.scrollIntoView(true, {behavior: "smooth"});
                                    }

                                    // work on map
                                    app.clearMap();
                                    app.currentInfoWindow = infoWindow;
                                    app.currentInfoWindow.open(map, marker);
                                });
                            });

                            if (app.markers.size > 1) {
                                map.fitBounds(app.bounds);
                            } else {
                                map.setCenter(app.markers.values().next().value.getPosition());
                            }
                        });
                },
                locateFiche: function (ficheId) {
                    this.clearMap();

                    app.currentMarker = app.markers.get(ficheId);
                    // center map
                    map.setCenter(app.currentMarker.getPosition());
                    // start animation
                    app.currentMarker.setAnimation(google.maps.Animation.BOUNCE);
                    window.setTimeout(function () {
                        app.currentMarker.setAnimation(null);
                    }, 2000);

                    // close current infoWindow
                    app.currentInfoWindow = app.infoWindows.get(ficheId);
                    app.currentInfoWindow.open(map, app.currentMarker);

                    // for mobile
                    if (!this._colEnabled()) {
                        window.scrollTo(0, 0);
                    }
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
