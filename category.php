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
                <form class="mb-4 px-4">
                    <h3 class="mb-3 h5">Je recherche :</h3>
                    <div class="form-row">
                        <div class="form-group col-md-4">
                            <select class="form-control" title="Sous catégorie" name="cat">
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
                                <option title="Vaud" value="">Où ça ...</option>
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
                            <input class="form-control" type="text" placeholder="Plus précisement ..." name="search" <?php echo $_GET['search'] ? sprintf('value="%s"', $_GET['search']) : '' ?> ">
                        </div>
                    </div>
                    <button class="btn btn-sm btn-secondary mr-1" type="button" data-toggle="collapse" data-target="#collapseCriteria">Plus de critères</button>
                    <button class="btn btn-sm btn-secondary mr-1" type="reset">Réinitialiser</button>
                    <button class="btn btn-sm btn-primary" type="submit">Rechercher</button>
                    <div id="collapseCriteria" class="collapse pl-3 mt-3 category-criteria">
                        <div class="form-inline">
                            <span class="col-form-label">Quand ?</span>
                            <div class="form-check ml-3">
                                <input class="form-check-input" type="checkbox" name="quand" value="option2">
                                <label class="form-check-label">Brunch</label>
                            </div>
                            <div class="form-check ml-3">
                                <input class="form-check-input" type="checkbox" name="quand" value="option2">
                                <label class="form-check-label">Déjeuner (petit)</label>
                            </div>
                            <div class="form-check ml-3">
                                <input class="form-check-input" type="checkbox" name="quand" value="option2">
                                <label class="form-check-label">Goûter</label>
                            </div>
                        </div>
                        <div class="form-inline">
                            <span class="col-form-label">Critères ?</span>
                            <div class="form-check ml-3">
                                <input class="form-check-input" type="checkbox" name="quand" value="option2">
                                <label class="form-check-label">Accès Wi-Fi</label>
                            </div>
                            <div class="form-check ml-3">
                                <input class="form-check-input" type="checkbox" name="quand" value="option2">
                                <label class="form-check-label">Plats à emporter</label>
                            </div>
                            <div class="form-check ml-3">
                                <input class="form-check-input" type="checkbox" name="quand" value="option2">
                                <label class="form-check-label">Possibilité de privatisation</label>
                            </div>
                        </div>
                        <div class="form-inline">
                            <span class="col-form-label">Types ?</span>
                            <div class="form-check ml-3">
                                <input class="form-check-input" type="checkbox" name="quand" value="option2">
                                <label class="form-check-label">Bistrot</label>
                            </div>
                            <div class="form-check ml-3">
                                <input class="form-check-input" type="checkbox" name="quand" value="option2">
                                <label class="form-check-label">Burgers</label>
                            </div>
                            <div class="form-check ml-3">
                                <input class="form-check-input" type="checkbox" name="quand" value="option2">
                                <label class="form-check-label">Fondue</label>
                            </div>
                        </div>
                    </div>
                </form>


                <?php
                $args = array(
                    'post_type' => 'fiche',
                    'category_name' => isset($_GET['cat']) ? $_GET['cat'] : get_queried_object()->slug,
                    's' => $_GET['search']
                );
                if (!empty($_GET['loc'])) {
                    $args['tax_query'] = array(
                        array(
                            'taxonomy' => 'cq_location',
                            'field' => 'slug',
                            'terms' => $_GET['loc'],
                        ),
                    );
                }

                $loop = new WP_Query($args);
                echo '<div class="d-flex justify-content-around flex-wrap category-fiche-container py-4">';
                if ($loop->have_posts()):
                    while ($loop->have_posts()) :
                        $loop->the_post();
                        $categories = chouquette_get_top_categories(get_the_ID());
                        $fiche_info_terms = chouquette_get_fiche_terms(get_post(), $categories);
                        ?>
                        <article class="card category-fiche mb-4">
                            <div class="card-header category-fiche-header p-2" style="background-image: url('<?php esc_url(the_post_thumbnail_url('medium_large')); ?>');">
                                <div class="category-fiche-header-icon">
                                    <img src="http://chouquette.test/wp-content/uploads/2019/04/Loisirs_noir-150x150.png" alt="">
                                </div>
                            </div>
                            <div class="card-body">
                                <h5 class="card-title"><?php the_title(); ?></h5>
                                <p class="card-text"><?php the_content(); ?></p>
                                <p class="card-text small text-secondary">
                                    <?php
                                    $terms = chouquette_flatten_fiche_terms($fiche_info_terms);
                                    echo implode(", ", array_slice($terms, 0, 4));
                                    echo sizeof($terms) > 4 ? '...' : '';
                                    ?>
                                </p>
                                <div class="w-100">
                                    <a href="" class="btn btn-sm btn-outline-secondary">Article</a>
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
<?php
get_footer();
