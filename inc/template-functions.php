<?php
/**
 * Functions which enhance the theme by hooking into WordPress
 *
 * @package Chouquette_thème
 */

if (!function_exists('chouquette_acf_generate_post_id')) :

    /**
     * Generate the post_id as described in https://www.advancedcustomfields.com/resources/get_field/
     */
    function chouquette_acf_generate_post_id($item)
    {
        if ($item instanceof WP_Term) {
            return $item->taxonomy . '_' . $item->term_id;
        } elseif ($item instanceof WP_Post) {
            return $item->object . '_' . $item->object_id;
        } else {
            trigger_error(sprintf("%s neither have attribute 'object' or 'object_id'", print_r($item, true)), E_USER_ERROR);
        }
    }

endif;

if (!function_exists('chouquette_menu_items')) :

    /**
     * Retrieve chouquette menu items
     */
    function chouquette_menu_items()
    {
        $result = array();

        // get menu items
        if (isset (get_nav_menu_locations()[CHOUQUETTE_PRIMARY_MENU])) {
            $primary_menu_id = get_nav_menu_locations()[CHOUQUETTE_PRIMARY_MENU];
            $menu = wp_get_nav_menu_object($primary_menu_id);
            $menu_items = wp_get_nav_menu_items($menu->term_id);
            foreach ($menu_items as $menu_item) :
                $logo_class = get_field(CHOUQUETTE_MENU_LOGO_SELECTOR, chouquette_acf_generate_post_id($menu_item));
                $menu_item->logo_class = $logo_class;
                $result[] = $menu_item;
            endforeach;
        } else {
            trigger_error(sprintf("Menu principal du thème '%s' non renseigné", CHOUQUETTE_PRIMARY_MENU), E_USER_WARNING);
        }

        return $result;
    }
endif;

if (!function_exists('chouquette_top_category')) :

    /**
     * Retrieve top level category for given post.
     *
     * Fails if multiple top categories.
     */
    function chouquette_top_category($post_id)
    {
        $top_categories = array();

        $categories = get_the_category($post_id);
        foreach ($categories as $category) {
            // if already top category
            if ($category->parent == 1232) { // FIXME should be 0
                $top_categories[$category->term_id] = $category;
                continue;
            }
            // if not ...
            $parents = get_ancestors($category->term_id, 'category');
            foreach (array_reverse($parents) as $term_id) {
                $parent = get_term($term_id, 'category');
                if ($parent->parent == 1232) { // FIXME should be 0
                    $top_categories[$parent->term_id] = $parent;
                }
            }
        }

        // return value
        if (empty ($top_categories))
            return null;
        else
            return array_pop($top_categories);
    }
endif;
