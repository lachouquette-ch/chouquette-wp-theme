<?php
/**
 * Functions which enhance the theme by hooking into WordPress
 *
 * @package Chouquette_thème
 */

if (!(function_exists('chouquette_categories'))) :
    /**
     * Gets all categories for given post or related fiches.
     * First try with fiches then fallback to post (if given as parameter).
     *
     * @param int $id the post/fiche id
     *
     * @return array a unique array of categories
     */
    function chouquette_categories(int $id)
    {
        // get fiche
        $linkFiches = get_field(CQ_FICHE_SELECTOR, $id);
        if ($linkFiches) {
            $taxonomy_ids = array_column($linkFiches, 'ID');
        } else {
            $taxonomy_ids = array($id); // fallback to article if no fiche (ex : tops)
        }

        $categories = get_categories(array(
            'object_ids' => $taxonomy_ids,
            'exclude_tree' => "8,9,285,1,14,257" // TODO remove after deployment
        ));

        return $categories;
    }
endif;

if (!(function_exists('chouquette_categories_get_tops'))) :
    /**
     * Gets top categories for given post (or fiche)
     *
     * @param int $id the post/fiche id
     *
     * @return array a unique array of top categories
     */
    function chouquette_categories_get_tops(int $id)
    {
        $categories = chouquette_categories($id);

        $result = array();
        foreach ($categories as $category) {
            while ($category->category_parent != 1232) { // TODO Should be 0
                $category = get_category($category->category_parent);
            }
            array_push($result, $category);
        }
        return array_unique($result, SORT_REGULAR);
    }
endif;

if (!(function_exists('chouquette_categories_get_all'))) :
    /**
     * Gets all categories (including top) for given post (or fiche)
     *
     * @param int $id the post/fiche id
     *
     * @return array a unique array of top categories
     */
    function chouquette_categories_get_all(int $id)
    {
        $categories = chouquette_categories($id);

        $result = array();
        foreach ($categories as $category) {
            $current = array($category->slug => $category);
            while ($category->category_parent != 1232) { // TODO Should be 0
                $category = get_category($category->category_parent);
                $current[$category->slug] = $category;
            }
            $current = array_reverse($current);
            $result = array_merge($result, $current);
        }
        return $result;
    }
endif;