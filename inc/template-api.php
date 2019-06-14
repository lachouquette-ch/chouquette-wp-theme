<?php

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
        $fiche_raw = get_field(CQ_FICHE_LOCATION, $fiche->ID);
        $result = array(
            'id' => $fiche->ID,
            'lat' => floatval($fiche_raw['lat']),
            'lng' => floatval($fiche_raw['lng'])
        );

        $result['categories'] = [];
        $categories = chouquette_categories_get_tops($fiche->ID);
        foreach ($categories as $category) {
            $category_dto = array('cat_id' => $category->term_id, 'cat_name' => $category->name);
            array_push($result['categories'], $category_dto);
        }

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