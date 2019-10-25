<?php
/**
 * Functions which enhance the theme by hooking into WordPress
 *
 * @package Chouquette_thème
 */

if (!function_exists('chouquette_pagination_next_url')) :
    /**
     * Get next url for given url
     */
    function chouquette_pagination_next_url()
    {
        global $wp;
        $current_url = home_url($wp->request . '/');

        $params = array();
        parse_str($_SERVER['QUERY_STRING'], $params);

        $num = isset($params['num']) ? $params['num'] : 0;
        // reach max num
        if ($num >= CQ_CATEGORY_MAX_FICHES) {
            return null;
        } else {
            $num += CQ_CATEGORY_PAGING_NUMBER;
            $params['num'] = $num;
        }

        $next_url = add_query_arg($params, $current_url);
        return $next_url;
    }
endif;