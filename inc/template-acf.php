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
        } elseif ($item instanceof WP_User) {
            return 'user_' . $item->ID;
        } else {
            trigger_error(sprintf("%s neither have attribute 'object' or 'object_id'", print_r($item, true)), E_USER_ERROR);
        }
    }
endif;

if (!(function_exists('chouquette_acf_get_field_object'))) :
    /**
     * Get ACF field object by field name without using post id.
     * Works also with sub-groups
     *
     * @param string $name the field name (can be category name, ...)
     * @return the field object (using get_field_object method)
     */
    function chouquette_acf_get_field_object(string $name)
    {
        global $wpdb;
        $field_keys = $wpdb->get_col($wpdb->prepare("
            SELECT  p.post_name
            FROM    $wpdb->posts p
            WHERE   p.post_type = 'acf-field'
            AND     p.post_excerpt = %s;
        ", $name));

        return array_map(function ($field_key) {
            return get_field_object($field_key);
        }, $field_keys);
    }
endif;