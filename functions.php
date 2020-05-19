<?php
/**
 * Chouquette thème functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package Chouquette_thème
 */

if (!function_exists('lachouquette_setup')) :
    /**
     * Sets up theme defaults and registers support for various WordPress features.
     *
     * Note that this function is hooked into the after_setup_theme hook, which
     * runs before the init hook. The init hook is too late for some features, such
     * as indicating support for post thumbnails.
     */
    function lachouquette_setup()
    {
        // This theme uses wp_nav_menu() in one location.
        register_nav_menus(array(
			'primary-menu' => esc_html__('Menu principal', 'lachouquette'),
			'footer-menu' => esc_html__('Menu footer', 'lachouquette'),
        ));
    }
endif;
add_action('after_setup_theme', 'lachouquette_setup');
