<?php

function cq_location_dto(int $fiche_id)
{
    $location = get_field(CQ_FICHE_LOCATION, $fiche_id);
    if (empty($location)) {
        error_log("Fiche {$fiche_id} has no location");
        return [];
    }
    return array(
        'lat' => floatval($location['lat']),
        'lng' => floatval($location['lng'])
    );
}

function cq_categories_dto(int $fiche_id)
{
    $categories = get_the_category($fiche_id);
    $result = [];
    foreach ($categories as $category) {
        $category_dto = array('cat_id' => $category->term_id, 'cat_name' => $category->name);
        // TODO add location pin (logo)
        $result[] = $category_dto;
    }
    return $result;
}

/**
 * REST API to get all locations for a given post
 *
 * @param $data GET params with post 'id'
 * @return array of object(id, lat, lng)
 */
function cq_get_locations_for_post($data)
{
    $fiches = chouquette_fiche_get_all($data['id']);

    $dtos = [];
    foreach ($fiches as $fiche) {
        $category = chouquette_categories($fiche->ID)[0];

        // populate result object
        $dto = cq_location_dto($fiche->ID);
        $dto['id'] = $fiche->ID;
        $dto['icon'] = chouquette_category_get_marker_icon($category, chouquette_fiche_is_chouquettise($fiche->ID));
        $dto['categories'] = cq_categories_dto($fiche->ID);

        // append to result array
        array_push($dtos, $dto);
    }
    return $dtos;
}

add_action('rest_api_init', function () {
    register_rest_route('cq/v1', '/post/(?P<id>\d+)/location', array(
        'methods' => 'GET',
        'callback' => 'cq_get_locations_for_post',
    ));
});

/**
 * REST API to get all taxonomy for a given category
 *
 * @param $data GET params with category 'slug'
 * @return array of object(label, instructions, name, taxonomy, terms => object(term_id, name, slug, description))
 */
function cq_get_taxonomies_for_category($data)
{
    function build_DTO(array $taxonomy)
    {
        // field
        $field = array_filter($taxonomy, function ($key) {
            return $key == 'label' || $key == 'instructions' || $key == 'name' || $key == 'taxonomy';
        }, ARRAY_FILTER_USE_KEY);

        // taxonomies
        $terms = array_map(function (WP_Term $term) {
            $result = [];
            $result['term_id'] = $term->term_id;
            $result['name'] = $term->name;
            $result['slug'] = $term->slug;
            $result['description'] = $term->description;
            return $result;

        }, $taxonomy['terms']);

        // put things together
        $field['terms'] = $terms;
        return $field;
    }

    $taxonomy_fields = array();
    if (!empty($data['cat'])) {
        $category = get_category_by_slug($data['cat']);

        // get upper categories
        $categories = array($category->term_id => $category);
        while ($category->category_parent != 1232) { // TODO Should be 0
            $category = get_category($category->category_parent);
            $categories[$category->term_id] = $category;
        }

        // get field objects terms
        foreach ($categories as $category) {
            $the_field = chouquette_acf_get_field_object($category->slug)[0];
            if ($the_field['type'] == ACF_FIELD_GROUP_TYPE) {
                foreach ($the_field['sub_fields'] as $sub_field) {
                    if ($sub_field['type'] == ACF_FIELD_TAXONOMY_TYPE) {
                        $taxonomy_fields[$sub_field['taxonomy']] = $sub_field;
                    }
                }
            } elseif ($the_field['type'] == ACF_FIELD_TAXONOMY_TYPE) {
                $taxonomy_fields[$the_field['taxonomy']] = $the_field;
            }
        }
    }

    // add overall criterias
    $other_field = chouquette_acf_get_field_object(CQ_TAXONOMY_CRITERIA)[0];
    $taxonomy_fields[CQ_TAXONOMY_CRITERIA] = $other_field;

    // add terms and built DTO
    $result = [];
    foreach ($taxonomy_fields as $key => $value) {
        $value['terms'] = get_terms($value['taxonomy'], array(
            'hide_empty' => false, // TODO remove ?
        ));
        $dto = build_DTO($value);
        $result[] = $dto;
    }

    return $result;
}

add_action('rest_api_init', function () {
    register_rest_route('cq/v1', '/category/taxonomy', array(
        'methods' => 'GET',
        'callback' => 'cq_get_taxonomies_for_category',
    ));
});

function cq_filter_criterias_params(array $queryParams)
{
    return array_filter($queryParams, function ($key) {
        return substr_compare($key, 'cq_', 0, 3) == false;
    }, ARRAY_FILTER_USE_KEY);
}

function cq_get_locations_for_id(int $id)
{
    return array(
        'post_type' => CQ_FICHE_POST_TYPE,
        'post__in' => [$id], // why doesn't p works... mystery
        'post_status' => 'any', // TODO to remove
    );
}

function cq_get_locations_for_category_prepare_query($category, int $number = null, string $location = '', string $search = '', array $criterias = array())
{
    if (is_null($number) || $number < 1) {
        $number_of_fiches = CQ_CATEGORY_PAGING_NUMBER;
    } elseif ($number > CQ_CATEGORY_MAX_FICHES) {
        $number_of_fiches = CQ_CATEGORY_MAX_FICHES;
    } else {
        $number_of_fiches = $number;
    }

    $args = array(
        'post_type' => CQ_FICHE_POST_TYPE,
        'category_name' => $category->slug,
        'meta_key' => CQ_FICHE_CHOUQUETTISE_TO,
        'meta_type' => 'DATE',
        'orderby' => 'meta_value date',
        'order' => 'DESC DESC',
        'posts_per_page' => $number_of_fiches,
        'post_status' => 'any' // TODO to remove
    );
    // filter location
    $args['tax_query'] = array('relation' => 'AND');
    if (!empty($location)) {
        $args['tax_query'][] = array(
            'taxonomy' => CQ_TAXONOMY_LOCATION,
            'field' => 'slug',
            'terms' => $location,
        );
    }
    // filter search
    if (!empty($search)) {
        $args['s'] = $search;
    }
    // filter criterias
    foreach ($criterias as $key => $value) {
        $args['tax_query'][] = array(
            'taxonomy' => $key,
            'field' => 'slug',
            'terms' => $value,
            'operator' => 'AND'
        );
    }

    return $args;
}

/**
 * REST API to get all locations for a given category
 *
 * @param $data GET params with category 'slug'
 * @return array of object(id, lat, lng)
 */
function cq_get_locations_for_category($data)
{
    $result = array();

    $category = get_category_by_slug($data['slug']);
    $criterias = cq_filter_criterias_params($_GET);
    if (isset($_GET['id'])) {
        $args = cq_get_locations_for_id($_GET['id']);
    } else {
        $args = cq_get_locations_for_category_prepare_query($category, $_GET['num'] ?? null, $_GET['loc'] ?? '', $_GET['search'] ?? '', $criterias);
    }
    $fiches = new WP_Query($args);
    if ($fiches->have_posts()) {
        while ($fiches->have_posts()) {
            $fiches->the_post();
            $fiche = get_post();
            $fiche_category = chouquette_category_get_single_sub_category($fiche->ID, $category);

            $dto = array('id' => $fiche->ID);
            $dto['title'] = get_the_title($fiche->ID);
            $dto['location'] = cq_location_dto($fiche->ID);
            $dto['icon'] = chouquette_category_get_marker_icon($fiche_category, chouquette_fiche_is_chouquettise($fiche->ID));
            $dto['categories'] = cq_categories_dto($fiche->ID);
            $dto['infoWindow'] = chouquette_load_template_part('inc/api/info-window');
            $dto['chouquettise'] = chouquette_fiche_is_chouquettise($fiche->ID);
            $result[] = $dto;
        }
    }
    return $result;
}

add_action('rest_api_init', function () {
    register_rest_route('cq/v1', '/category/(?P<slug>[\w-]+)/fiche', array(
        'methods' => 'GET',
        'callback' => 'cq_get_locations_for_category',
    ));
});

function cq_get_locations_for_location_prepare_query($location, int $number = null, string $category = '', string $search = '', array $criterias = array())
{
    if (is_null($number) || $number < 1) {
        $number_of_fiches = CQ_CATEGORY_PAGING_NUMBER;
    } elseif ($number > CQ_CATEGORY_MAX_FICHES) {
        $number_of_fiches = CQ_CATEGORY_MAX_FICHES;
    } else {
        $number_of_fiches = $number;
    }

    $args = array(
        'post_type' => CQ_FICHE_POST_TYPE,
        'meta_key' => CQ_FICHE_CHOUQUETTISE_TO,
        'meta_type' => 'DATE',
        'orderby' => 'meta_value date',
        'order' => 'DESC DESC',
        'posts_per_page' => $number_of_fiches,
        'post_status' => 'any', // TODO to remove
        'tax_query' => [
            'relation' => 'AND',
            [
                'taxonomy' => CQ_TAXONOMY_LOCATION,
                'field' => 'slug',
                'terms' => $location->slug,
            ]
        ]
    );
    // filter category
    if (!empty($category)) {
        $args['category_name'] = $category;
    }
    // filter search
    if (!empty($search)) {
        $args['s'] = $search;
    }
    // filter criterias
    foreach ($criterias as $key => $value) {
        $args['tax_query'][] = array(
            'taxonomy' => $key,
            'field' => 'slug',
            'terms' => $value,
            'operator' => 'AND'
        );
    }

    return $args;
}

/**
 * REST API to get all locations for a given location
 *
 * @param $data GET params with location 'slug'
 * @return array of object(id, lat, lng)
 */
function cq_get_locations_for_location($data)
{
    $result = array();

    $location = get_term_by('slug', $data['slug'], CQ_TAXONOMY_LOCATION);
    $criterias = cq_filter_criterias_params($_GET);
    $args = cq_get_locations_for_location_prepare_query($location, $_GET['num'] ?? null, $_GET['cat'] ?? '', $_GET['search'] ?? '', $criterias);

    $fiches = new WP_Query($args);
    if ($fiches->have_posts()) {
        while ($fiches->have_posts()) {
            $fiches->the_post();
            $fiche = get_post();
            $fiche_category = chouquette_categories_get_tops($fiche->ID)[0];

            $dto = array('id' => $fiche->ID);
            $dto['title'] = get_the_title($fiche->ID);
            $dto['location'] = cq_location_dto($fiche->ID);
            $dto['icon'] = chouquette_category_get_marker_icon($fiche_category, chouquette_fiche_is_chouquettise($fiche->ID));
            $dto['categories'] = cq_categories_dto($fiche->ID);
            $dto['infoWindow'] = chouquette_load_template_part('inc/api/info-window');
            $dto['chouquettise'] = chouquette_fiche_is_chouquettise($fiche->ID);
            $result[] = $dto;
        }
    }
    return $result;
}

add_action('rest_api_init', function () {
    register_rest_route('cq/v1', '/location/(?P<slug>[\w-]+)/fiche', array(
        'methods' => 'GET',
        'callback' => 'cq_get_locations_for_location',
    ));
});