<?php
/**
 * Functions which enhance the theme by hooking into WordPress
 *
 * @package Chouquette_thème
 */

if (!function_exists('chouquette_fiche_is_chouquettise')) :
    /**
     * Return if fiche is chouquettise
     *
     * @param $fiche_id the id of the fiche
     *
     * @return true of false if the fiche is chouquettise
     */
    function chouquette_fiche_is_chouquettise(int $fiche_id)
    {
        $field = get_field(CQ_FICHE_CHOUQUETTISE_TO, $fiche_id);
        if (!$field) {
            return false;
        }

        $chouquettise_to = DateTime::createFromFormat('d/m/Y', $field);
        return $chouquettise_to >= new DateTime();
    }
endif;

if (!function_exists('chouquette_fiche_has_openings')):
    /**
     * Does the fiche has any openings
     *
     * @param array of fiche fields
     *
     * @return boolean true or false
     */
    function chouquette_fiche_has_openings($fiche_fields)
    {
        return !empty(trim($fiche_fields[CQ_FICHE_OPENING_MONDAY])) ||
            !empty(trim($fiche_fields[CQ_FICHE_OPENING_TUESDAY])) ||
            !empty(trim($fiche_fields[CQ_FICHE_OPENING_WEDNESDAY])) ||
            !empty(trim($fiche_fields[CQ_FICHE_OPENING_THURSDAY])) ||
            !empty(trim($fiche_fields[CQ_FICHE_OPENING_FRIDAY])) ||
            !empty(trim($fiche_fields[CQ_FICHE_OPENING_SATURDAY])) ||
            !empty(trim($fiche_fields[CQ_FICHE_OPENING_SUNDAY]));
    }
endif;

if (!function_exists('chouquette_fiche_flatten_terms')) :
    /**
     * Flatten fiche terms into single array
     *
     * @param $taxonomies fiche taxonomies including terms from chouquette_get_fiche_taxonomies function
     *
     * @return array of term names
     *
     * @throws Exception if no taxonomy is given
     */
    function chouquette_fiche_flatten_terms(array $taxonomies)
    {
        if (empty($taxonomies)) {
            throw new Exception("No taxonomy given");
        }
        $terms = array_column($taxonomies, 'terms');
        $terms = call_user_func_array('array_merge', $terms); // flatten array of arrays
        $names = array_column($terms, 'name');
        return array_unique($names);
    }
endif;


if (!function_exists('chouquette_fiche_get_taxonomies')) :
    function get_all_taxonomy_fields($field, array $acc = [])
    {
        if ($field['type'] == ACF_FIELD_GROUP_TYPE) {
            foreach ($field['sub_fields'] as $sub_field) {
                $fields = get_all_taxonomy_fields($sub_field, $acc);
                $acc = array_merge($acc, $fields);
            }
        } elseif ($field['type'] == ACF_FIELD_TAXONOMY_TYPE) {
            $acc[$field['name']] = $field;
        }
        return $acc;
    }

    /**
     * Get all fiche taxonomy terms depending of its categories
     *
     * @param WP_post $fiche the given fiche
     *
     * @return array of arrays (taxonomy name with WP_Terms) or empty array
     */
    function chouquette_fiche_get_taxonomies(WP_Post $fiche)
    {
        // get all field objects for fiche categories
        $categories = chouquette_categories_get_all($fiche->ID);
        $fields = array();
        foreach ($categories as $category) {
            $act_fields = chouquette_acf_get_field_object($category->slug);
            // no acf field for category ? (can be...)
            if (empty($act_fields)) continue;
            $the_field = $act_fields[0];
            $taxonomy_fields = get_all_taxonomy_fields($the_field);
            $fields = array_merge($fields, $taxonomy_fields);
        }
        // get field objects terms
        foreach ($fields as $key => $field) {
            $terms = get_the_terms($fiche, $field['taxonomy']);
            if ($terms) {
                $fields[$key]['terms'] = $terms;
            } else {
                $fields[$key]['terms'] = [];
            }
        }
        return $fields;
    }
endif;

if (!function_exists('chouquette_fiche_get_all')) :
    /**
     * Get all fiches for given post
     *
     * @param int|WP_Post|null $post Post ID or post object of null to get globa $post
     *
     * @return array of posts (fiches) sorted (chouquettise last). Empty array if none.
     */
    function chouquette_fiche_get_all($post = null)
    {
        $fiches = get_field(CQ_FICHE_SELECTOR, $post);

        if (!$fiches) {
            return [];
        } elseif (!is_array($fiches)) {
            return array($fiches);
        } else {
            // sort fiches (chouquettises last)
            $fiches_chouquettises = array_filter($fiches, function ($fiche) {
                return chouquette_fiche_is_chouquettise($fiche->ID);
            });
            $fiches_not_chouquettises = array_filter($fiches, function ($fiche) {
                return !chouquette_fiche_is_chouquettise($fiche->ID);
            });
            return array_merge($fiches_not_chouquettises, $fiches_chouquettises);
        }
    }
endif;