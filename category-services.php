<?php
/**
 * The template for displaying archive pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Chouquette_thème
 */

get_header();

$category = get_queried_object();
$sub_categories = get_categories(array(
    'child_of' => $category->term_id,
    'hide_empty' => true
));

$locations = get_terms(array(
    'taxonomy' => CQ_TAXONOMY_LOCATION,
    'hide_empty' => false,
    'orderby' => 'term_group'
));

get_template_part('template-parts/fiche-report');
?>
    <div id="app">
        <h1 class="text-center my-4 cq-font"><?php echo single_cat_title(); ?></h1>
        <form class="mb-4 px-4">
            <h3 class="mb-3 h5">Je recherche :</h3>
            <div class="form-row">
                <div class="form-group col-md-4">
                    <select class="form-control" title="Où veux-tu aller ?" name="loc">
                        <option title="" value="">Où ça ...</option>
                        <?php
                        foreach ($locations as $location) {
                            $location_display = $location->parent != 0 ? ' • ' : '';
                            $location_display .= $location->name;
                            $attr_selected = isset($_GET['loc']) && $_GET['loc'] == $location->slug ? 'selected' : '';
                            echo "<option title='{$location->name}' value='{$location->slug}' {$attr_selected}>{$location_display}</option>";
                        }
                        ?>
                    </select>
                </div>
                <div class="form-group col-md-4">
                    <input class="form-control" type="text" placeholder="Plus précisement ..." name="search" <?php echo empty($_GET['search']) ? '' : "value='{$_GET['search']}'"; ?>>
                </div>
                <div class="form-group col-md-4">
                    <button class="btn btn-primary" type="submit">Rechercher</button>
                </div>
            </div>
            <button class="btn btn-sm btn-secondary mr-1" type="button" data-toggle="collapse" data-target="#collapseCriteria">Plus de critères</button>
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
        if (!empty($_GET['id'])) {
            $args = cq_get_locations_for_id($_GET['id']);
        } else {
            $args = cq_get_locations_for_category_prepare_query($category, $_GET['num'] ?? null, $_GET['loc'] ?? '', $_GET['search'] ?? '', $criterias);
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
            echo "<span class='d-block text-center'>Oh mince, nous n'avons rien trouvé pour toi <i class='far fa-frown'></i>. Continue avec d'autres critères et c'est sûr, tu vas trouver ton bonheur</span>";
        endif;
        echo '</div>';
        ?>
    </div>
<?php

wp_enqueue_script('category-les-services', get_template_directory_uri() . '/category-services.js', ['vue', 'underscore'], CQ_THEME_VERSION, true);

get_footer();