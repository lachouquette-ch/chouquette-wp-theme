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
));
$default_location = isset($_GET['loc']) ? get_term_by('slug', $_GET['loc'], CQ_TAXONOMY_LOCATION) : null;

get_template_part('template-parts/fiche-modals');
?>
    <div id="app" class="py-4">
        <h1 class="text-center mb-4 cq-font"><?php echo single_cat_title(); ?></h1>
        <form class="mb-4 px-4">
            <h3 class="mb-3 h5">Je recherche :</h3>
            <div class="form-row">
                <div class="form-group col-md-6">
                    <select class="form-control" title="Où veux-tu aller ?" name="loc">
                        <option title="" value="">Où ça ...</option>
                        <?php chouquette_location_options($default_location); ?>
                    </select>
                </div>
                <div class="form-group col-md-6">
                    <input class="form-control" type="text" placeholder="Plus précisément ..." name="search" <?php echo empty($_GET['search']) ? '' : "value='{$_GET['search']}'" ?>>
                </div>
            </div>
            <button class="btn btn-sm btn-secondary mr-1 cq-toggle" type="button" data-toggle="collapse" data-target="#collapseCriteria" v-cloak>
                <i class="fa"></i>
                <span class="d-md-none">{{ criteriaLabel(criteriaCount) }}</span>
                <span class="d-none d-md-inline">{{ criteriaLabel(checkedCount) }}</span>
            </button>
            <button class="btn btn-sm btn-primary" type="submit">Rechercher</button>
            <div id="collapseCriteria" class="collapse category-criteria mt-2 pl-3">
                <div v-for="criteria in criterias" class="form-group">
                    <label :for="criteria.name">{{ criteria.label }}</label>
                    <select :id="criteria.name" class="form-control d-md-none" :name="criteria.name + '[]'" multiple="multiple" v-model="criteria.selectedTerms" size="3">
                        <option v-for="term in criteria.terms" :value="term.slug" v-on:change="toggleCheckCritera(term)">{{ term.name }}</option>
                    </select>
                    <div class="category-criteria-checkbox d-none d-md-block">
                        <div v-for="term in criteria.terms" class="form-check">
                            <label class="form-check-label">
                                <input class="form-check-input" type="checkbox" :name="criteria.name + '[]'" :value="term.slug" v-model="term.checked" v-on:change="toggleCheckCritera(term)"> {{ term.name }}
                            </label>
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
            $current_url = "//" . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
            $next_url = add_query_arg('num', $number_of_fiches + CQ_CATEGORY_PAGING_NUMBER, $current_url);

            if (isset($_GET['num']) && $_GET['num'] > $number_of_fiches || $number_of_fiches >= $loop->found_posts) {
                $pagination_disabled = true;
                $pagination_text = "Arf, désolé nous n'avons pas plus à te proposer pour le moment";
            } elseif ($number_of_fiches >= CQ_CATEGORY_MAX_FICHES) {
                $pagination_disabled = true;
                $pagination_text = "Peux-tu affiner ta recherche ?";
            } else {
                $pagination_disabled = false;
                $pagination_text = "Tu en veux plus ? Cliques ici";
            }

            echo sprintf('<a class="btn btn-sm btn-outline-secondary w-75 %s %s" href="%s" role="button">%s</a>',
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
<?php

wp_enqueue_script('category-les-services', get_template_directory_uri() . '/src/scripts/partials/category-services.js', ['vue', 'underscore', 'hammer'], CQ_THEME_VERSION, true);

get_footer();
