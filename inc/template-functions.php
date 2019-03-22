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
        if (isset (get_nav_menu_locations()[CQ_PRIMARY_MENU])) {
            $primary_menu_id = get_nav_menu_locations()[CQ_PRIMARY_MENU];
            $menu = wp_get_nav_menu_object($primary_menu_id);
            $menu_items = wp_get_nav_menu_items($menu->term_id);
            foreach ($menu_items as $menu_item) :
                $logo_class = get_field(CQ_MENU_LOGO_SELECTOR, chouquette_acf_generate_post_id($menu_item));
                $menu_item->logo_class = $logo_class;
                $result[] = $menu_item;
            endforeach;
        } else {
            trigger_error(sprintf("Menu principal du thème '%s' non renseigné", CQ_PRIMARY_MENU), E_USER_WARNING);
        }
        return $result;
    }
endif;

if (!function_exists('chouquette_is_chouquettise')) :
    /**
     * Return if fiche is chouquettise
     */
    function chouquette_is_chouquettise(array $fiche_fields) {
        $chouquettise_to = DateTime::createFromFormat('d/m/Y', $fiche_fields['chouquettise_to']);
        return $chouquettise_to >= new DateTime();
    }
endif;