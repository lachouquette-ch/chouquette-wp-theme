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

if (!function_exists('chouquette_category_get_marker_icon')) :
    /**
     * Prints the taxonomy logo (if any)
     *
     * @param object $taxonomy the taxonomy. Should have a 'logo' attribute (array) with the id of the image
     * @param string $color the color. Only 'white', 'black' or 'yellow'
     * @param string $size the WP size. Default is thumbnail
     * @param array $classes the classes to add to the img tag
     */
    function chouquette_category_get_marker_icon(object $category, bool $is_chouquettise)
    {
        if ($is_chouquettise) {
            $icon = get_field(CQ_CATEGORY_LOGO_MARKER_YELLOW, chouquette_acf_generate_post_id($category));
        } else {
            $icon = get_field(CQ_CATEGORY_LOGO_MARKER_WHITE, chouquette_acf_generate_post_id($category));
        }
        $image_src = wp_get_attachment_image_src($icon['id'], 'full')[0];
        return $image_src;
    }
endif;

if (!function_exists('chouquette_category_get_single_sub_category')) :
    /**
     * Get first subcategory for given post and parent category. Fallback to parent category if none.
     *
     * @param int $post_id the post id
     * @param object $parent_category the parent category
     * @return object the first sub category or parent category if none
     */
    function chouquette_category_get_single_sub_category(int $post_id, object $parent_category)
    {
        $result = get_categories(array(
            'taxonomy' => 'category',
            'object_ids' => $post_id,
            'parent' => $parent_category->term_id,
            'hide_empty' => true,
            'number' => 1 // only one
        ));
        // if not subcategory
        if (empty($result)) {
            return $parent_category;
        }
        return $result[0];
    }
endif;