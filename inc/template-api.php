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
        $categories = chouquette_get_top_categories($fiche->ID);
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
    function build_result(string $taxonomy)
    {
        // field
        $raw_field = get_field_object($taxonomy, 17895); // 17895 is fiche Buet
        $field = array_filter($raw_field, function ($key) {
            return $key == 'label' || $key == 'instructions' || $key == 'name' || $key == 'taxonomy';
        }, ARRAY_FILTER_USE_KEY);

        // taxonomy
        $raw_terms = get_terms($field['taxonomy']);
        $terms = array_map(function (WP_Term $term) {
            $result = [];
            $result['term_id'] = $term->term_id;
            $result['name'] = $term->name;
            $result['slug'] = $term->slug;
            $result['description'] = $term->description;
            return $result;

        }, $raw_terms);

        // put things together
        $field['terms'] = $terms;
        return $field;
    }

    $results = array();
    switch ($data['slug']) {
        case CQ_CATEGORY_BAR_RETOS:
        case CQ_SUB_CATEGORY_BAR_RETOS_VIE_NOCTURNE:
            $results[] = build_result(CQ_TAXONOMY_BAR_REST_CRITERIA);
            break;
        case CQ_SUB_CATEGORY_BAR_RETOS_BAR_PUBS:
            $results[] = build_result(CQ_TAXONOMY_BAR_TYPE);
            $results[] = build_result(CQ_TAXONOMY_BAR_REST_CRITERIA);
            break;
        case CQ_SUB_CATEGORY_BAR_RETOS_BOULANGERIES_PATISSERIES:
            $results[] = build_result(CQ_TAXONOMY_BAR_REST_WHEN);
            $results[] = build_result(CQ_TAXONOMY_BAR_REST_WHO);
            $results[] = build_result(CQ_TAXONOMY_REST_RESTRICTION);
            $results[] = build_result(CQ_TAXONOMY_BAR_REST_CRITERIA);
            break;
        case CQ_SUB_CATEGORY_BAR_RETOS_RESTAURANTS:
        case CQ_SUB_CATEGORY_BAR_RETOS_SUR_LE_POUCE:
            $results[] = build_result(CQ_TAXONOMY_REST_TYPE);
            $results[] = build_result(CQ_TAXONOMY_BAR_REST_WHEN);
            $results[] = build_result(CQ_TAXONOMY_BAR_REST_WHO);
            $results[] = build_result(CQ_TAXONOMY_REST_RESTRICTION);
            $results[] = build_result(CQ_TAXONOMY_BAR_REST_CRITERIA);
            break;

        case CQ_CATEGORY_LOISIRS:
        case CQ_SUB_CATEGORY_LOISIRS_ACTIVITES:
        case CQ_SUB_CATEGORY_LOISIRS_BALADES:
        case CQ_SUB_CATEGORY_LOISIRS_ESCAPADES:
        case CQ_SUB_CATEGORY_LOISIRS_SPA_BIEN_ETRE:
        case CQ_SUB_CATEGORY_LOISIRS_SPORTS:
            $results[] = build_result(CQ_TAXONOMY_HOBBY);
            break;

        case CQ_CATEGORY_CULTURE:
        case CQ_SUB_CATEGORY_CULTURE_AUTRES:
        case CQ_SUB_CATEGORY_CULTURE_CINEMA:
        case CQ_SUB_CATEGORY_CULTURE_MUSEE:
        case CQ_SUB_CATEGORY_CULTURE_MUSIQUE:
        case CQ_SUB_CATEGORY_CULTURE_THEATRE:
            $results[] = build_result(CQ_TAXONOMY_CULTURE);
            break;

        case CQ_CATEGORY_SHOPPING:
            break;
        case CQ_SUB_CATEGORY_SHOPPING_MODE:
            $results[] = build_result(CQ_TAXONOMY_SHOPPING_MODE);
            break;
        case CQ_SUB_CATEGORY_SHOPPING_DECO:
            $results[] = build_result(CQ_TAXONOMY_SHOPPING_DECO);
            break;
        case CQ_SUB_CATEGORY_SHOPPING_FOOD:
            $results[] = build_result(CQ_TAXONOMY_SHOPPING_FOOD);
            break;
        case CQ_SUB_CATEGORY_SHOPPING_AUTRE:
        case CQ_SUB_CATEGORY_SHOPPING_WEB:
            $results[] = build_result(CQ_TAXONOMY_SHOPPING_OTHERS);
            break;

        case CQ_CATEGORY_CHOUCHOUS:
            $results[] = build_result(CQ_TAXONOMY_CHOUCHOU);
            break;
    }
    // add common criteria
    $results[] = build_result(CQ_TAXONOMY_CRITERIA);

    return $results;
}

add_action('rest_api_init', function () {
    register_rest_route('cq/v1', '/category/(?P<slug>[\w-]+)/taxonomy', array(
        'methods' => 'GET',
        'callback' => 'cq_get_taxonomies_for_category',
    ));
});