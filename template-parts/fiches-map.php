<?php
/**
 * The template for displaying archive pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Chouquette_thème
 */

$search_categories = get_query_var('search_categories');
$default_category = get_query_var('default_category');
$search_locations = get_query_var('search_locations');
$default_location = get_query_var('default_location');

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
                            <option title="" value="<?php echo $default_category->slug ?? '' ?>">Je veux ...</option>
                            <?php
                            foreach ($search_categories as $search_category) {
                                $attr_selected = isset($_GET['cat']) && $_GET['cat'] == $search_category->slug ? 'selected' : '';
                                echo "<option title='{$search_category->name}' value='{$search_category->slug}' {$attr_selected}>{$search_category->name}</option>";
                            }
                            ?>
                        </select>
                    </div>
                    <div class="form-group col-md-4">
                        <select id="search-loc" class="form-control" title="Où veux-tu aller ?" name="loc">
                            <option title="" value="<?php echo $default_location->slug ?? '' ?>">Où ça ...</option>
                            <?php
                            foreach ($search_locations as $search_location) {
                                $term_style = $search_location->parent == 0 ? 'font-weight: bold' : '';
                                $search_location_display = $search_location->parent != 0 ? '&nbsp;&nbsp;' : '';
                                $search_location_display .= $search_location->name;
                                $attr_selected = isset($_GET['loc']) && $_GET['loc'] == $search_location->slug ? 'selected' : '';
                                echo "<option title='{$search_location->name}' value='{$search_location->slug}' style='${term_style}' {$attr_selected}>{$search_location_display}</option>";
                            }
                            ?>
                        </select>
                    </div>
                    <div class="form-group col-md-4">
                        <input class="form-control" type="text" placeholder="Plus précisement ..." name="search" <?php echo empty($_GET['search']) ? '' : "value='{$_GET['search']}'" ?>>
                    </div>
                </div>
                <button class="btn btn-sm btn-secondary mr-1" type="button" data-toggle="collapse" data-target="#collapseCriteria">Plus de critères</button>
                <button class="btn btn-sm btn-primary" type="submit">Rechercher</button>
                <div id="collapseCriteria" v-bind:class="{ show: hasCriterias }" class="collapse category-criteria  mt-2">
                    <div class="container-fluid">
                        <div v-for="criteriaRow in criteriaRows" class="row">
                            <div v-for="criteria in criteriaRow" class="col-md-6 pt-2 px-2">
                                <span class="col-form-label" class="white-space: nowrap;">{{ criteria.label }}</span>
                                <div class="form-check ml-3" v-for="term in criteria.terms">
                                    <input class="form-check-input" type="checkbox" :id="term.slug" :name="criteria.name + '[]'" :value="term.slug" v-model="term.checked">
                                    <label class="form-check-label" :for="term.slug">{{ term.name }}</label>
                                </div>
                            </div>
                        </div>
                        <a href="#" class="d-block link-secondary small mt-3" v-on:click.prevent="resetCriterias">Tout déselectionner</a>
                    </div>
                </div>
            </form>

            <?php
            $criterias = cq_filter_criterias_params($_GET);
            if ($default_category) {
                $args = cq_get_locations_for_category_prepare_query($default_category, $_GET['num'] ?? null, $_GET['loc'] ?? '', $_GET['search'] ?? '', $criterias);
            } else {
                $args = cq_get_locations_for_location_prepare_query($default_location, $_GET['num'] ?? null, $_GET['cat'] ?? '', $_GET['search'] ?? '', $criterias);
            }
            $loop = new WP_Query($args);
            $number_of_fiches = $loop->post_count;

            echo '<div class="category-fiche-container py-4">';
            if ($loop->have_posts()):
                echo '<div class="d-flex justify-content-around flex-wrap">';
                while ($loop->have_posts()) :
                    $loop->the_post();
                    $fiche_category = chouquette_categories_get_tops(get_the_ID())[0];
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
                    <article id="<?php echo get_the_ID(); ?>" class="card category-fiche mb-4 <?php if (chouquette_fiche_is_chouquettise(get_the_ID())) echo 'category-fiche-chouquettise'; ?>">
                        <a class="category-fiche-target" id="<?php echo 'target' . get_the_ID(); ?>"></a>
                        <div class="card-header category-fiche-header p-2" style="background-image: url('<?php esc_url(the_post_thumbnail_url('medium_large')); ?>');">
                            <div class="category-fiche-header-icon">
                                <?php echo chouquette_taxonomy_logo($fiche_category, 'black'); ?>
                            </div>
                        </div>
                        <div class="card-body">
                            <h5 class="card-title"><?php echo get_the_title(); ?></h5>
                            <p class="card-text"><?php echo get_the_content(); ?></p>
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
                                    echo sprintf('<a href="%s" title="%s" class="btn btn-sm btn-outline-secondary">Article</a>', get_the_permalink($lastest_post), esc_html($lastest_post->post_title));
                                }
                                ?>
                                <button class="btn btn-sm btn-outline-secondary" v-on:click="locateFiche(<?php echo get_the_ID(); ?>)">Voir</button>
                            </div>
                        </div>
                    </article>
                <?php
                endwhile;
                echo '</div>';
                echo '<div class="text-center mt-3">';
                global $wp;
                $current_url = "//" . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
                $next_url = add_query_arg('num', $number_of_fiches + CQ_CATEGORY_PAGING_NUMBER, $current_url);

                if (isset($_GET['num']) && $_GET['num'] > $number_of_fiches) {
                    $pagination_disabled = true;
                    $pagination_text = "Plus d'article pour cette recherche";
                } elseif ($number_of_fiches >= CQ_CATEGORY_MAX_FICHES) {
                    $pagination_disabled = true;
                    $pagination_text = "Peux-tu affiner ta recherche ?";
                } else {
                    $pagination_disabled = false;
                    $pagination_text = "Plus de fiches";
                }

                echo sprintf('<a class="btn btn-sm btn-outline-secondary w-50 %s" href="%s" role="button">%s</a>', $pagination_disabled ? 'disabled' : '', $next_url, $pagination_text);
                echo '</div>';
            else:
                echo "<span class='d-block text-center'>Pas de résultat pour cette recherche</span>";
            endif;
            echo '</div>';
            ?>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/vue@2.6.0/dist/vue.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/axios/0.19.0/axios.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/lodash@4.17.11/lodash.min.js"></script>
<script>
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
            app.clearMap();
            if (app.markers.size > 1) map.fitBounds(app.bounds);
        });

        app.addFichesToMap();
    };

    var app = new Vue({
        el: '#app',
        data() {
            return {
                criterias: null,
                hasCriterias: false,
                category: null,
                location: null,
                ficheApiURL: '',
                currentMarker: null,
                markers: new Map(),
                currentInfoWindow: null,
                infoWindows: new Map(),
                bounds: null,
                $_params: null
            }
        },
        computed: {
            // helper to create proper grid columns
            criteriaRows: function () {
                if (!this.criterias) {
                    return [];
                }

                var result = [];
                for (var i = 0; i < this.criterias.length; i = i + 2) {
                    result.push(this.criterias.slice(i, i + 2));
                }
                return result;
            },
        },
        methods: {
            // get criterias from remote based on given category
            refreshCriterias: function (category) {
                axios
                    .get(`http://chouquette.test/wp-json/cq/v1/category/taxonomy?cat=${category}`)
                    .then(function (response) {
                        response.data.forEach(function (taxonomy) {
                            taxonomy.terms.forEach(function (term) {
                                if (app.$_params.getAll(taxonomy.name).includes(term.slug)) {
                                    term.checked = true;
                                    app.hasCriterias = true;
                                }
                            });
                        });
                        app.criterias = response.data;
                    });
            },
            // uncheck add criterias
            resetCriterias: function () {
                this.criterias.forEach(function (taxonomy) {
                    taxonomy.terms.forEach(function (term) {
                        term.checked = false;
                    })
                })
            },
            // stop current animation and close current info window
            clearMap: function () {
                if (app.currentMarker) {
                    // stop animation
                    app.currentMarker.setAnimation(null);
                    // reset zindex
                    app.currentMarker.setZIndex(app.currentMarker.defaultZIndex);
                }

                if (app.currentInfoWindow) app.currentInfoWindow.close();
                // reset index
            },
            // hack to know if on mobile or not
            _colEnabled: function () {
                return window.getComputedStyle(document.getElementById('colTrigger')).display != "none";
            },
            // get fiches from URL and add it to map
            addFichesToMap: function () {
                axios({
                    method: 'get',
                    url: this.ficheApiURL + location.search,
                })
                    .then(function (response) {
                        app.bounds = new google.maps.LatLngBounds();
                        response.data.forEach(function (fiche) {
                            // create info window
                            var infoWindow = new google.maps.InfoWindow({content: fiche.infoWindow});
                            app.infoWindows.set(fiche.id, infoWindow);

                            // create marker
                            if (_.isEmpty(fiche.location)) {
                                console.log(`${fiche.title} has no location`);
                                return;
                            }

                            var marker = new google.maps.Marker({position: fiche.location, icon: fiche.icon, map: map});
                            marker.defaultZIndex = fiche.chouquettise ? Z_INDEX_CHOUQUETTISE : Z_INDEX_DEFAULT;
                            marker.setZIndex(marker.defaultZIndex); // to start
                            app.markers.set(fiche.id, marker);
                            app.bounds.extend(marker.getPosition());

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
                                app.currentMarker = this;
                                app.currentMarker.setZIndex(Z_INDEX_SELECTED);
                                app.currentInfoWindow = infoWindow;
                                app.currentInfoWindow.open(map, app.currentMarker);
                            });
                        });

                        if (app.markers.size > 1) {
                            map.fitBounds(app.bounds);
                        } else if (app.markers.size) {
                            map.setCenter(app.markers.values().next().value.getPosition());
                        }
                    });
            },
            // locate on fiche on the map, display info window and activate animation
            locateFiche: function (ficheId) {
                this.clearMap();

                app.currentMarker = app.markers.get(ficheId);
                // zoom and center map
                map.setZoom(ZOOM_LEVEL_ACTIVED);
                map.setCenter(app.currentMarker.getPosition());
                // set zIndex
                app.currentMarker.setZIndex(Z_INDEX_SELECTED);
                // start animation
                bounce(app.currentMarker);

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
            // get selections
            var selectedLocation = document.getElementById("search-loc");
            this.location = selectedLocation.options[selectedLocation.selectedIndex].value;
            var selectCategory = document.getElementById("search-cat");
            this.category = selectCategory.options[selectCategory.selectedIndex].value;
            this.refreshCriterias(this.category);

            if (this.category) {
                this.ficheApiURL = `http://chouquette.test/wp-json/cq/v1/category/${this.category}/fiche`;
            } else {
                this.ficheApiURL = `http://chouquette.test/wp-json/cq/v1/location/${this.location}/fiche`;
            }

            // scroll to current fiche
            var num = this.$_params.get('num');
            if (num) {
                var numGotoFiche = num - <?php echo CQ_CATEGORY_PAGING_NUMBER; ?>; // compute first fiche to go to
                var fiche = document.getElementsByClassName("category-fiche")[numGotoFiche];
                setTimeout(function () {
                    fiche.childNodes[0].scrollIntoView(true, {behavior: "smooth"});
                }, 1500);
            }
        }
    });
</script>