<?php
/*
Plugin Name: Chouquette Fiche
 */
function chouquette_fiche_post_type()
{
    $labels = array(
        'name' => _x('Fiches', 'Post Type General Name', 'chouquette'),
        'singular_name' => _x('Fiche', 'Post Type Singular Name', 'chouquette'),
        'menu_name' => __('Fiches', 'chouquette'),
        'name_admin_bar' => __('Fiche', 'chouquette'),
        'parent_item_colon' => __('Fiche parente', 'chouquette'),
        'all_items' => __('Toutes les fiches', 'chouquette'),
        'add_new_item' => __('Ajouter une nouvelle fiche', 'chouquette'),
    );
    $args = array(
        'label' => __('Fiche', 'chouquette'),
        'description' => __('Fiche Chouquette', 'chouquette'),
        'labels' => $labels,
        'supports' => array('title', 'thumbnail', 'comments', 'revisions', 'custom-fields'),
        'taxonomies' => array('category', 'post_tag'),
        'hierarchical' => false,
        'public' => true,
        'show_ui' => true,
        'show_in_menu' => true,
        'menu_position' => 5,
        'menu_icon' => 'dashicons-location',
        'show_in_admin_bar' => true,
        'show_in_nav_menus' => true,
        'can_export' => true,
        'has_archive' => true,
        'exclude_from_search' => false,
        'publicly_queryable' => true,
        'capability_type' => 'page',
    );
    register_post_type('fiche', $args);

}

add_action('init', 'chouquette_fiche_post_type', 0);
?>