<?php
/**
 * Custom template tags for this theme
 *
 * Eventually, some of the functionality here could be replaced by core features.
 *
 * @package Chouquette_thème
 */

if (!function_exists('chouquette_navbar_nav')) :
    /*
     * Prints the navbar composed of ul/li items (nav-item)
     */
    function chouquette_navbar_nav()
    {
        // get menu items
        $menu_items = chouquette_menu_items();
        if (!empty ($menu_items)) {
            echo '<ul class="navbar-nav mr-auto">';
            foreach ($menu_items as $menu_item) :
                echo '<li class="nav-item">';
                echo sprintf("<a class='nav-link' href='%s' title='%s'><i class='mr-2 %s'></i> %s</a>", esc_url($menu_item->url), $menu_item->description, $menu_item->logo_class, $menu_item->title);
                echo '</li>';
            endforeach;
            echo '</ul>';
        } else {
            trigger_error(sprintf("Menu principal du thème '%s' non renseigné", CQ_PRIMARY_MENU), E_USER_WARNING);
        }
    }
endif;

