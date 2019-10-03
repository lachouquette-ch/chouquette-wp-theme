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

set_query_var('search_categories', $search_categories);
set_query_var('default_category', $default_category);
get_template_part('template-parts/fiches-map');

get_footer();