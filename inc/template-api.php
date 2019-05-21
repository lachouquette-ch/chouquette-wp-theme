<?php

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