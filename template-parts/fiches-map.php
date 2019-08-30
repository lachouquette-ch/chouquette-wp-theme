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

get_template_part('template-parts/fiche-report');
?>
    <div id="app" class="container-fluid">
        <div class="row">
            <div class="col-md-6 p-0 category-result-col">
                <h1 class="text-center my-4 cq-font"><?php echo single_cat_title(); ?></h1>
                <form class="mb-4 px-4 <?php echo empty($_GET['id']) ? '' : 'd-none' ?>">
                    <input id="search-cat" type="hidden" value="<?php echo $default_category->slug ?? '' ?>">
                    <input id="search-loc" type="hidden" value="<?php echo $default_location->slug ?? '' ?>">

                    <h3 class="mb-3 h5">Je recherche :</h3>
                    <div class="form-row">
                        <div class="form-group col-md-4">
                            <select class="form-control" title="Sous catégorie" name="cat"
                                    v-on:change="updateCriterias($event)">
                                <option title="" value="">Je veux ...</option>
                                <?php
                                foreach ($search_categories as $search_category) {
                                    $attr_selected = isset($_GET['cat']) && $_GET['cat'] == $search_category->slug ? 'selected' : '';
                                    echo "<option title='{$search_category->name}' value='{$search_category->slug}' {$attr_selected}>{$search_category->name}</option>";
                                }
                                ?>
                            </select>
                        </div>
                        <div class="form-group col-md-4">
                            <select class="form-control" title="Où veux-tu aller ?" name="loc">
                                <option title="" value="">Où ça ...</option>
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
                    <button class="btn btn-sm btn-secondary mr-1 cq-toggle" type="button" data-toggle="collapse" data-target="#collapseCriteria" v-cloak>
                        <i class="fa"></i>
                        <span class="d-md-none">{{ criteriaLabel(criteriaCount) }}</span>
                        <span class="d-none d-md-inline">{{ criteriaLabel(checkedCount) }}</span>
                    </button>
                    <button class="btn btn-sm btn-primary" type="submit">Rechercher</button>
                    <div id="collapseCriteria" class="collapse category-criteria mt-2 pl-2">
                        <div v-for="criteria in criterias" class="form-group">
                            <label :for="criteria.name">{{ criteria.label }}</label>
                            <select :id="criteria.name" class="form-control d-md-none" :name="criteria.name + '[]'" multiple="multiple" v-model="criteria.selectedTerms" size="3">
                                <option v-for="term in criteria.terms" :value="term.slug">{{ term.name }}</option>
                            </select>
                            <div class="category-criteria-checkbox d-none d-md-block">
                                <div v-for="term in criteria.terms" class="form-check px-3">
                                    <label class="form-check-label"><input class="form-check-input" type="checkbox" :name="criteria.name + '[]'" :value="term.slug" v-model="term.checked"> {{ term.name }}</label>
                                </div>
                            </div>
                        </div>
                        <a href="#" class="d-block link-secondary small mt-3" v-on:click.prevent="resetCriterias">Tout déselectionner</a>
                    </div>
                </form>

                <?php
                $criterias = cq_filter_criterias_params($_GET);
                if (!empty($_GET['id'])) {
                    $args = cq_get_locations_for_id($_GET['id']);
                } elseif ($default_category) {
                    $args = cq_get_locations_for_category_prepare_query($default_category, $_GET['num'] ?? null, $_GET['loc'] ?? '', $_GET['search'] ?? '', $criterias);
                } else {
                    $args = cq_get_locations_for_location_prepare_query($default_location, $_GET['num'] ?? null, $_GET['cat'] ?? '', $_GET['search'] ?? '', $criterias);
                }
                $loop = new WP_Query($args);
                $number_of_fiches = $loop->post_count;

                echo '<div class="category-fiche-container py-4">';
                if ($loop->have_posts()):
                    echo '<div class="d-flex justify-content-around flex-wrap">';
                    while ($loop->have_posts()) {
                        $loop->the_post();
                        get_template_part('template-parts/fiche');
                    }
                    echo '</div>';

                    echo '<div class="text-center mt-3">';
                    $current_url = "//" . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
                    $next_url = add_query_arg('num', $number_of_fiches + CQ_CATEGORY_PAGING_NUMBER, $current_url);

                    if (isset($_GET['num']) && $_GET['num'] > $number_of_fiches || $number_of_fiches >= $loop->found_posts) {
                        $pagination_disabled = true;
                        $pagination_text = "Plus d'article pour cette recherche";
                    } elseif ($number_of_fiches >= CQ_CATEGORY_MAX_FICHES) {
                        $pagination_disabled = true;
                        $pagination_text = "Peux-tu affiner ta recherche ?";
                    } else {
                        $pagination_disabled = false;
                        $pagination_text = "Plus de fiches";
                    }

                    echo sprintf('<a class="btn btn-sm btn-outline-secondary w-50 %s %s" href="%s" role="button">%s</a>',
                        $pagination_disabled ? 'disabled' : '',
                        empty($_GET['id']) ? '' : 'd-none',
                        $next_url,
                        $pagination_text);
                    echo '</div>';
                else:
                    echo "<span class='d-block text-center'>Oh mince, nous n'avons rien trouvé pour toi <i class='far fa-frown'></i>. Continue avec d'autres critères et c'est sûr, tu vas trouver ton bonheur</span>";
                endif;
                echo '</div>';
                ?>
            </div>
            <div class="col-md-6">
                <div id="fichesMapLegend" class="d-none">
                    <?php
                    $url = get_page_by_title('Charte éditoriale') ? get_permalink(get_page_by_title('Charte éditoriale')) : null;
                    if (!empty($url)) :
                        ?>
                        <div class="m-1 p-2 border rounded h4" style="background-color: rgba(255,255,255,0.8); font-size: 0.9rem;">
                            <img height="40px" src="<?php echo get_template_directory_uri() . '/images/marker_yellow.png' ?>"> Lieux
                            <a href="<?php echo $url; ?>" class="link-secondary">chouquettisés</a>
                        </div>
                    <?php endif; ?>
                </div>
                <div id="fichesMapReset" class="d-none">
                    <button v-on:click="resetMap" draggable="false" title="Reset view map" aria-label="Reset view map" type="button" class="btn btn-white border-0 p-0 shadow rounded-0"
                            style="margin: 10px; height: 40px; width: 40px;">
                        <i class="fas fa-bullseye"></i>
                    </button>
                </div>

                <div class="category-map">
                    <button class="btn btn-sm btn-primary cq-toggle horizontal d-md-none" type="button" v-on:click="toggleMap">
                        <i class="fa"></i><span class="ml-2">La carte</span>
                    </button>
                    <div id="fichesMap"></div>
                </div>
            </div>
        </div>
    </div>

<?php

wp_enqueue_script('fiches-map', get_template_directory_uri() . '/template-parts/fiches-map.js', ['vue', 'google-maps', 'underscore', 'hammer'], CQ_THEME_VERSION, true);
