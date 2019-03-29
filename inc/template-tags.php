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

if (!function_exists('chouquette_header_alert')) :
    /**
     * Prints an alert. Should be on top of page (after menu)
     *
     * @param string $alert_type the alert type. Should be either  'success', 'danger', 'warning' or 'info'
     * @param string $alert_message the alert message content
     */
    function chouquette_header_alert(string $alert_type, string $alert_message)
    {
        echo sprintf('<div class="alert alert-%s alert-dismissible fade show mb-0 pt-4" role="alert">%s', $alert_type, $alert_message);
        echo '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>';
        echo '</div>';
    }
endif;

