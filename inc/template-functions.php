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
        if (!isset($fiche_fields[CQ_FICHE_CHOUQUETTISE_TO])) {
            return false;
        }

        $chouquettise_to = DateTime::createFromFormat('d/m/Y', $fiche_fields[CQ_FICHE_CHOUQUETTISE_TO]);
        return $chouquettise_to >= new DateTime();
    }
endif;

if (!function_exists('chouquette_get_taxonomy_terms')) :
    /**
     * Get taxonomy terms using https://developer.wordpress.org/reference/functions/get_the_terms/.
     *
     * @param WP_Post $post The given post
     * @param string $taxonomy the given taxonomy
     *
     * @return array of WP_Term of empty array if nothing. Return terms also get the logo field on attribute 'logo'
     */
    function chouquette_get_taxonomy_terms(WP_Post $post, string $taxonomy)
    {
        $terms = get_the_terms($post, $taxonomy);
        if ($terms instanceof WP_Error) {
            error_log($terms->get_error_message() . ' for ' . $taxonomy);
            return;
        }
        if (!$terms) $terms = [];
        // add logo field to term object
        foreach ($terms as $term) {
            $term->logo = get_field(CQ_MENU_LOGO_SELECTOR, $term);
        }
        return $terms;
    }
endif;

if (!function_exists('chouquette_get_fiche_terms')) :
    /**
     * Get all fiche taxonomy terms depending of its categories
     *
     * @param WP_post $fiche the given fiche
     * @param array $categories array of category terms TODO retrieve categories should be included in this function (currently post have categories, not fiche)
     *
     * @return array of WP_Term or empty array
     */
    function chouquette_get_fiche_terms(WP_Post $fiche, array $categories)
    {
        $fiche_info_terms = [];
        // defaults
        $fiche_info_terms = array_merge($fiche_info_terms, chouquette_get_taxonomy_terms($fiche, CQ_TAXONOMY_CRITERIA));
        foreach ($categories as $category) {
            switch ($category->slug) {
                case CQ_CATEGORY_BAR_RETOS:
                    $fiche_info_terms = array_merge($fiche_info_terms, chouquette_get_taxonomy_terms($fiche, CQ_TAXONOMY_BAR_REST_WHEN));
                    $fiche_info_terms = array_merge($fiche_info_terms, chouquette_get_taxonomy_terms($fiche, CQ_TAXONOMY_BAR_REST_WHO));
                    $fiche_info_terms = array_merge($fiche_info_terms, chouquette_get_taxonomy_terms($fiche, CQ_TAXONOMY_BAR_REST_CRITERIA));
                    $fiche_info_terms = array_merge($fiche_info_terms, chouquette_get_taxonomy_terms($fiche, CQ_TAXONOMY_REST_TYPE));
                    $fiche_info_terms = array_merge($fiche_info_terms, chouquette_get_taxonomy_terms($fiche, CQ_TAXONOMY_REST_RESTRICTION));
                    $fiche_info_terms = array_merge($fiche_info_terms, chouquette_get_taxonomy_terms($fiche, CQ_TAXONOMY_BAR_TYPE));
                    break;
                case CQ_CATEGORY_LOISIRS:
                    $fiche_info_terms = array_merge($fiche_info_terms, chouquette_get_taxonomy_terms($fiche, CQ_TAXONOMY_HOBBY));
                    break;
                case CQ_CATEGORY_CULTURE:
                    $fiche_info_terms = array_merge($fiche_info_terms, chouquette_get_taxonomy_terms($fiche, CQ_TAXONOMY_CULTURE));
                    break;
                case CQ_CATEGORY_SHOPPING:
                    $fiche_info_terms = array_merge($fiche_info_terms, chouquette_get_taxonomy_terms($fiche, CQ_TAXONOMY_SHOPPING_MODE));
                    $fiche_info_terms = array_merge($fiche_info_terms, chouquette_get_taxonomy_terms($fiche, CQ_TAXONOMY_SHOPPING_DECO));
                    $fiche_info_terms = array_merge($fiche_info_terms, chouquette_get_taxonomy_terms($fiche, CQ_TAXONOMY_SHOPPING_FOOD));
                    $fiche_info_terms = array_merge($fiche_info_terms, chouquette_get_taxonomy_terms($fiche, CQ_TAXONOMY_SHOPPING_OTHERS));
                    break;
                case CQ_CATEGORY_CHOUCHOUS:
                    $fiche_info_terms = array_merge($fiche_info_terms, chouquette_get_taxonomy_terms($fiche, CQ_TAXONOMY_CHOUCHOU));
                    break;
            }
        }
        return $fiche_info_terms;
    }
endif;