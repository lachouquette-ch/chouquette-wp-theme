<?php
/**
 * Functions which enhance the theme by hooking into WordPress
 *
 * @package Chouquette_thème
 */

if ( ! function_exists( 'chouquette_menu_items' ) ) :

    class ChouquetteMenuItem {
        public $id;
        public $type;
        public $title;
        public $description;
        public $url;
        public $logo_class;

        function get_post_id() {
            return $this->type . '_' . $this->id;
        }
    }

    /**
     * Retrieve menu items
     */
    function chouquette_menu_items() {
        $result = array();

        // get menu items
        if ( isset ( get_nav_menu_locations()[CHOUQUETTE_PRIMARY_MENU] ) ) {
            $primary_menu_id = get_nav_menu_locations()[CHOUQUETTE_PRIMARY_MENU];
            $menu = wp_get_nav_menu_object( $primary_menu_id );
            $menu_items = wp_get_nav_menu_items( $menu->term_id );
            foreach ( $menu_items as $menu_item ) :
                // init result object
                $result_item = new ChouquetteMenuItem();
                $result_item->id = $menu_item->object_id;
                $result_item->type = $menu_item->object;
                $result_item->title = $menu_item->title;
                $result_item->description = $menu_item->description;
                $result_item->url = $menu_item->url;

                // get logo
                $result_item->logo_class = get_field( CHOUQUETTE_MENU_LOGO_SELECTOR, $result_item->get_post_id() );

                $result[] = $result_item;
            endforeach;
        } else {
            trigger_error( sprintf("Menu principal du thème '%s' non renseigné", CHOUQUETTE_PRIMARY_MENU), E_USER_WARNING );
        }

        return $result;
    }
endif;
