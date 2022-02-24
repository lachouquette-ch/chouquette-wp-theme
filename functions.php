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
        /*
         * Enable support for Post Thumbnails on posts and pages.
         *
         * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
         */
        add_theme_support('post-thumbnails');

        // This theme uses wp_nav_menu() in one location.
        register_nav_menus(array(
			'primary-menu' => esc_html__('Menu principal', 'lachouquette'),
			'footer-menu' => esc_html__('Menu footer', 'lachouquette'),
        ));

        /**
         * Add support for core custom logo.
         *
         * @link https://codex.wordpress.org/Theme_Logo
         */
        add_theme_support('custom-logo', array(
            'height' => 250,
            'width' => 250,
            'flex-width' => true,
            'flex-height' => true,
        ));
    }
endif;
add_action('after_setup_theme', 'lachouquette_setup');

/**
 * Add new system text field to customization panel
 */
if (!function_exists('lachouquette_extra')) :
    function lachouquette_extra($wp_customize)
    {
        $wp_customize->add_section('la_chouquette_section', array(
            'title' => __('Extra La Chouquette'),
            'description' => __('Champs de configuration du thème pour La Chouquette'),
            'priority' => 30,
        ));

        $wp_customize->add_setting('la_chouquette_system_text', array(
            'default' => '',
        ));

        $wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'system_text', array(
            'type' => 'textarea',
            'section' => 'la_chouquette_section',
            'settings' => 'la_chouquette_system_text',
            'label' => __('Texte système'),
            'description' => __('Texte (HTML) qui sera affiché en haut de chaque page. Ce module est désactivé sur le champ est vide'),
        )));
    }
    add_action('customize_register', 'lachouquette_extra');
endif;
