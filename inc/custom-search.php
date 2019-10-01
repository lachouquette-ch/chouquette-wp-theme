<?php
/**
 * Custom search templates
 */
if (!function_exists('chouquette_search_custom')) :
    function chouquette_search_custom($template)
    {
        global $wp_query;
        if ($wp_query->is_search) {
            switch (get_query_var('post_type')) {
                case 'post':
                    return locate_template('search-post.php');
                case CQ_FICHE_POST_TYPE:
                    return locate_template('search-fiche.php');
            }
        }
        return $template;
    }
endif;
add_filter('template_include', 'chouquette_search_custom');

/* Set search to exact match only (no like) */
if (!function_exists('chouquette_search_exact')) :
    function chouquette_search_exact($search, $wp_query)
    {
        global $wpdb;

        if (empty($search))
            return $search;

        $q = $wp_query->query_vars;
        $n = !empty($q['exact']) ? '' : '%';

        $search = $searchand = '';

        foreach ((array)$q['search_terms'] as $term) {
            $term = esc_sql($wpdb->esc_like($term));

            $search .= "{$searchand}($wpdb->posts.post_title REGEXP '[[:<:]]{$term}[[:>:]]') OR ($wpdb->posts.post_content REGEXP '[[:<:]]{$term}[[:>:]]')";

            $searchand = ' AND ';
        }

        if (!empty($search)) {
            $search = " AND ({$search}) ";
            if (!is_user_logged_in())
                $search .= " AND ($wpdb->posts.post_password = '') ";
        }

        return $search;
    }
endif;
add_filter('posts_search', 'chouquette_search_exact', 20, 2);

/* Only return posts for search. No pages */
if (!function_exists('chouquette_search_post_only')) :
    function chouquette_search_post_only($query)
    {
        if ($query->is_search) {
            if (empty($query->get('post_type'))) {
                $query->set('post_type', array('post'));
            }
        }
        return $query;
    }

endif;
add_filter('pre_get_posts', 'chouquette_search_post_only');