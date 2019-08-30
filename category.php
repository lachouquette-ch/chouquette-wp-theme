<?php
/**
 * The template for displaying archive pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Chouquette_thème
 */

get_header();

$search_categories = get_categories(array(
    'child_of' => get_queried_object()->term_id,
    'hide_empty' => true
));
$default_category = isset($_GET['cat']) ? get_category_by_slug($_GET['cat']) : get_queried_object();

$locations = get_terms(array(
    'taxonomy' => CQ_TAXONOMY_LOCATION,
    'orderby' => 'term_group',
    'hide_empty' => false
));
$default_location = '';

set_query_var('search_categories', $search_categories);
set_query_var('default_category', $default_category);
set_query_var('search_locations', $locations);
set_query_var('default_location', $default_location);
get_template_part('template-parts/fiches-map');

get_footer();