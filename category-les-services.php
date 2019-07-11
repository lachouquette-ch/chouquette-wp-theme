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
                            echo "<option title='{$location->name}' value='{$location->slug}' {$attr_selected}>{$location_display}></option>";
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
        $criterias = array_filter($_GET, function ($key) {
            return substr_compare($key, 'cq_', 0, 3) == false;
        }, ARRAY_FILTER_USE_KEY);
        $args = cq_get_locations_for_category_prepare_query($category, $_GET['num'] ?? null, $_GET['loc'] ?? '', $_GET['search'] ?? '', $criterias);
        $loop = new WP_Query($args);
        $number_of_fiches = $loop->post_count;

        echo '<div class="category-fiche-container py-4">';
        if ($loop->have_posts()):
            echo '<div class="d-flex justify-content-around flex-wrap">';
            while ($loop->have_posts()) :
                $loop->the_post();
                $fiche_category = chouquette_category_get_single_sub_category(get_the_ID(), $category);
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

    <script src="https://cdn.jsdelivr.net/npm/vue@2.6.0/dist/vue.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/axios/0.19.0/axios.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/lodash@4.17.11/lodash.min.js"></script>
    <script>
        var app = new Vue({
            el: '#app',
            data() {
                return {
                    criterias: null,
                    hasCriterias: false,
                    category: null,
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
                        .get(`http://chouquette.test/wp-json/cq/v1/category/${category}/taxonomy`)
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
            },
            created() {
                // create instance of URLSearch
                var queryParams = location.search.replace(/%5B%5D/g, ''); // remove []
                this.$_params = new URLSearchParams(queryParams);
            },
            mounted() {
                this.refreshCriterias('les-services');
            }
        });
    </script>
<?php
get_footer();
