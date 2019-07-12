<?php
/**
 * The template for displaying archive pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Chouquette_thème
 */

get_header();

$search_categories = array_map(function ($item) {
    return get_category($item->object_id);
}, chouquette_menu_items());
$default_category = '';

$search_locations = get_categories(array(
    'taxonomy' => CQ_TAXONOMY_LOCATION,
    'child_of' => get_queried_object()->term_id,
    'hide_empty' => false
));
$default_location = isset($_GET['loc']) ? get_term_by('slug', $_GET['loc'], CQ_TAXONOMY_LOCATION) : get_queried_object();

set_query_var('search_categories', $search_categories);
set_query_var('default_category', $default_category);
set_query_var('search_locations', $search_locations);
set_query_var('default_location', $default_location);
get_template_part('template-parts/fiches-map');

get_footer();
