<?php
/**
 * Chouquette thème functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package Chouquette_thème
 */

/* Chouquette constants */
$chouquette_theme = wp_get_theme();
define ( 'CHOUQUETTE_THEME_VERSION', $chouquette_theme->get( 'Version' ) );
define ( 'CHOUQUETTE_PRIMARY_MENU', 'primary-menu' );
define ( 'CHOUQUETTE_MENU_LOGO_SELECTOR', 'logo' );

define ( 'CHOUQUETTE_TAXONOMY_LOCALISATION', 'cq_localisation' );

define ( 'CHOUQUETTE_SN_FACEBOOK', 'https://www.facebook.com/lachouquettelausanne' );
define ( 'CHOUQUETTE_SN_INSTAGRAM', 'https://www.instagram.com/lachouquettelausanne' );

if ( ! function_exists( 'chouquette_setup' ) ) :
	/**
	 * Sets up theme defaults and registers support for various WordPress features.
	 *
	 * Note that this function is hooked into the after_setup_theme hook, which
	 * runs before the init hook. The init hook is too late for some features, such
	 * as indicating support for post thumbnails.
	 */
	function chouquette_setup() {
		/*
		 * Make theme available for translation.
		 * Translations can be filed in the /languages/ directory.
		 * If you're building a theme based on Chouquette thème, use a find and replace
		 * to change 'chouquette' to the name of your theme in all the template files.
		 */
		load_theme_textdomain( 'chouquette', get_template_directory() . '/languages' );

		// Add default posts and comments RSS feed links to head.
		add_theme_support( 'automatic-feed-links' );

		/*
		 * Let WordPress manage the document title.
		 * By adding theme support, we declare that this theme does not use a
		 * hard-coded <title> tag in the document head, and expect WordPress to
		 * provide it for us.
		 */
		add_theme_support( 'title-tag' );

		/*
		 * Enable support for Post Thumbnails on posts and pages.
		 *
		 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
		 */
		add_theme_support( 'post-thumbnails' );

		// This theme uses wp_nav_menu() in one location.
        register_nav_menus( array(
			'primary-menu' => esc_html__( 'Menu principal', 'chouquette' ),
		) );

		/*
		 * Switch default core markup for search form, comment form, and comments
		 * to output valid HTML5.
		 */
		add_theme_support( 'html5', array(
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
		) );

		/**
		 * Add support for core custom logo.
		 *
		 * @link https://codex.wordpress.org/Theme_Logo
		 */
		add_theme_support( 'custom-logo', array(
			'height'      => 250,
			'width'       => 250,
			'flex-width'  => true,
			'flex-height' => true,
		) );
	}
endif;
add_action( 'after_setup_theme', 'chouquette_setup' );

/**
 * Enqueue scripts and styles.
 */
function chouquette_scripts() {
    wp_enqueue_style( 'slider', get_template_directory_uri() . '/dist/style.css', null, CHOUQUETTE_THEME_VERSION, 'all');

    wp_enqueue_script( 'vendor', get_template_directory_uri() . '/dist/vendor.js', null, CHOUQUETTE_THEME_VERSION, true);

    wp_enqueue_script( 'script', get_template_directory_uri() . '/dist/app.js', null, CHOUQUETTE_THEME_VERSION, true);

	// https://codex.wordpress.org/Function_Reference/comment_reply_link
	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'chouquette_scripts' );

/**
 * Implement the Custom Header feature.
 */
require get_template_directory() . '/inc/custom-header.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Functions which enhance the theme by hooking into WordPress.
 */
require get_template_directory() . '/inc/template-functions.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Load Jetpack compatibility file.
 */
if ( defined( 'JETPACK__VERSION' ) ) {
	require get_template_directory() . '/inc/jetpack.php';
}

