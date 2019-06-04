<?php
/**
 * The template for displaying archive pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Chouquette_thème
 */

get_header();
?>
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-6 order-md-1 p-0">
                <div id="fichesMap" class="category-map"></div>
            </div>
            <div class="col-md-6 order-md-0 p-0">
                <h1 class="text-center my-4 cq-font"><?php echo single_cat_title(); ?></h1>
                <form class="mb-4 px-4">
                    <h3 class="mb-3 h5">Je recherche :</h3>
                    <div class="form-row">
                        <div class="cq-selectpicker form-group col-md-4">
                            <select class="form-control selectpicker show-tick" title="Sous catégorie" data-selected-text-format="count > 2" multiple="" data-actions-box="true" tabindex="-98">
                                <option title="Bars / Pubs" value="">Bars / Pubs</option>
                                <option title="Boulangeries / Pâtisseries" value="">Boulangeries / Pâtisseries</option>
                                <option title="Restaurants" value="fribourg">Restaurants</option>
                            </select>
                        </div>
                        <div class="cq-selectpicker form-group col-md-4">
                            <select class="form-control selectpicker show-tick" title="Où veux-tu aller ?" data-selected-text-format="count > 2" multiple="" data-actions-box="true" tabindex="-98">
                                <option title="Vaud" value="vaud">Vaud</option>
                                <option title="Fribourg" value="fribourg">Fribourg</option>
                            </select>
                        </div>
                        <div class="form-group col-md-4">
                            <input class="form-control" type="text" placeholder="Un mot clef ?" aria-label="" aria-describedby="basic-addon1">
                        </div>
                    </div>
                    <button class="btn btn-sm btn-secondary mr-2" type="button" data-toggle="collapse" data-target="#collapseCriteria">Plus de critères</button>
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
                $latest_posts = new WP_Query('posts_per_page=6');
                if ($latest_posts->have_posts()):
                    echo '<div class="d-flex justify-content-around flex-wrap category-fiche-container py-4">';
                    while ($latest_posts->have_posts()) :
                        $latest_posts->the_post();
                        ?>
                        <article class="card category-fiche mb-4">
                            <div class="card-header category-fiche-header p-2" style="background-image: url('http://chouquette.test/wp-content/uploads/2019/03/MG_9874-768x512.jpg');">
                                <div class="category-fiche-header-icon">
                                    <img src="http://chouquette.test/wp-content/uploads/2019/04/Loisirs_noir-150x150.png" alt="">
                                </div>
                            </div>
                            <div class="card-body">
                                <h5 class="card-title">LaSpaSuite</h5>
                                <p class="card-text">
                                    Some quick example text to build on the card title and make up the bulk of the card's content
                                </p>
                                <p class="card-text small text-secondary">Brunch, cocktail, Wifi, ...</p>
                                <div class="w-100">
                                    <a href="" class="btn btn-sm btn-outline-secondary">Article</a>
                                    <a href="" class="btn btn-sm btn-outline-secondary">Voir</a>
                                </div>
                            </div>
                        </article>
                    <?php
                    endwhile;
                    echo '</div>';
                    wp_reset_postdata();
                endif;
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
