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
));
$default_category = isset($_GET['cat']) ? get_category_by_slug($_GET['cat']) : get_queried_object();
$default_location = isset($_GET['loc']) ? get_term_by('slug', $_GET['loc'], CQ_TAXONOMY_LOCATION) : null;

set_query_var('search_categories', $search_categories);
set_query_var('default_category', $default_category);
set_query_var('default_location', $default_location);

get_template_part('template-parts/fiches-map');

get_footer();