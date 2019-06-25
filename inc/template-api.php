<?php

function cq_location_dto(int $fiche_id) {
    $fiche_raw = get_field(CQ_FICHE_LOCATION, $fiche_id);
    return array(
        'lat' => floatval($fiche_raw['lat']),
        'lng' => floatval($fiche_raw['lng'])
    );
}

function cq_categories_dto(int $fiche_id) {
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
function cq_get_localisations_for_post($data)
{
    $fiches = get_field(CQ_FICHE_SELECTOR, $data['id']);

    $results = [];
    foreach ($fiches as $fiche) {
        // populate result object
        $result = cq_location_dto($fiche->ID);
        $result['id'] = $fiche->ID;
        $result['categories'] = cq_categories_dto($fiche->ID);

        // append to result array
        array_push($results, $result);
    }
    return $results;
}

add_action('rest_api_init', function () {
    register_rest_route('cq/v1', '/post/(?P<id>\d+)/localisation', array(
        'methods' => 'GET',
        'callback' => 'cq_get_localisations_for_post',
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

    $category = get_category_by_slug($data['slug']);

    // get upper categories
    $categories = array($category->term_id => $category);
    while ($category->category_parent != 1232) { // TODO Should be 0
        $category = get_category($category->category_parent);
        $categories[$category->term_id] = $category;
    }

    // get field objects terms
    $taxonomy_fields = array();
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
    register_rest_route('cq/v1', '/category/(?P<slug>[\w-]+)/taxonomy', array(
        'methods' => 'GET',
        'callback' => 'cq_get_taxonomies_for_category',
    ));
});

function cq_get_locations_for_category_prepare_query($category) {
    $args = array(
        'post_type' => CQ_FICHE_POST_TYPE,
        'category_name' => isset($_GET['cat']) ? $_GET['cat'] : $category->slug,
        'meta_key' => CQ_FICHE_CHOUQUETTISE_TO,
        'meta_type' => 'DATE',
        'orderby' => 'meta_value',
        'order' => 'DESC',
        'post_status' => 'any' // TODO to remove
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

    return $args;
}

/**
 * REST API to get all locations for a given category
 *
 * @param $data GET params with category 'slug'
 * @return array of object(id, lat, lng)
 */
function cq_get_localisations_for_category($data)
{
    $result = array();

    $category = get_category_by_slug($data['slug']);
    $args = cq_get_locations_for_category_prepare_query($category);

    $fiches = new WP_Query($args);
    if ($fiches->have_posts()) {
        while ($fiches->have_posts()) {
            $fiches->the_post();
            $fiche = get_post();
            $fiche_category = get_categories(array(
                'taxonomy' => 'category',
                'object_ids' =>$fiche->ID,
                'parent' => $category->term_id,
                'hide_empty' => true,
                'number' => 1 // only one
            ));
            // if not subcategory
            if (empty($fiche_category)) {
                $fiche_category = $category;
            } else {
                $fiche_category = $fiche_category[0];
            }

            $dto = array('id' => $fiche->ID);
            $dto['title'] = get_the_title($fiche->ID);
            $dto['location'] = cq_location_dto($fiche->ID);
            $dto['icon'] = chouquette_category_get_marker_icon($fiche_category, false);
            $dto['categories'] = cq_categories_dto($fiche->ID);
            $dto['infoWindow'] = chouquette_load_template_part('inc/api/info-window');
            $result[] = $dto;
        }
    }
    return $result;
}

add_action('rest_api_init', function () {
    register_rest_route('cq/v1', '/category/(?P<slug>[\w-]+)/fiche', array(
        'methods' => 'GET',
        'callback' => 'cq_get_localisations_for_category',
    ));
});
