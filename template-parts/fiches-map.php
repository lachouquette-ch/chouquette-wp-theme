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
                <a class="fiches-map-fiche-target" id="targetMap"></a>
                <div id="fichesMap" class="fiches-map-map"></div>
            </div>
            <div class="col-md-6 order-md-0 p-0 fiches-map-result-col">
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
                    <div id="collapseCriteria" v-bind:class="{ show: hasCriterias }" class="collapse fiches-map-criteria  mt-2">
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

                echo '<div class="fiches-map-fiche-container py-4">';
                if ($loop->have_posts()):
                    echo '<div class="d-flex justify-content-around flex-wrap">';
                    while ($loop->have_posts()) :
                        $loop->the_post();
                        if ($default_category) {
                            $fiche_category = chouquette_category_get_single_sub_category(get_the_ID(), $default_category);
                        } else {
                            $fiche_category = chouquette_categories_get_tops(get_the_ID())[0];
                        }
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
                        <article id="<?php echo get_the_ID(); ?>" class="card fiches-map-fiche mb-4 <?php if (chouquette_fiche_is_chouquettise(get_the_ID())) echo 'category-fiche-chouquettise'; ?>">
                            <a class="fiches-map-fiche-target" id="<?php echo 'target' . get_the_ID(); ?>"></a>
                            <div class="card-header fiches-map-fiche-header p-2" style="background-image: url('<?php esc_url(the_post_thumbnail_url('medium_large')); ?>');">
                                <div class="fiches-map-fiche-header-icon">
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

<?php

wp_enqueue_script('fiches-map', get_template_directory_uri() . '/template-parts/fiches-map.js', ['vue', 'google-maps', 'underscore'], CQ_THEME_VERSION, true);
