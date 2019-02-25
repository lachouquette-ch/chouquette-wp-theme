<?php
/**
 * Chouquette thème functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package Chouquette_thème
 */

$chouquette_theme = wp_get_theme();
$chouquette_theme_version = $chouquette_theme->get( 'Version' );

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

		// TODO remove since title will be fix
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

		// TODO remove since nav will be fix
		// This theme uses wp_nav_menu() in one location.
        register_nav_menus( array(
			'menu-1' => esc_html__( 'Primary', 'chouquette' ),
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

		// TODO remove since background will be fix
		// Set up the WordPress core custom background feature.
		add_theme_support( 'custom-background', apply_filters( 'chouquette_custom_background_args', array(
			'default-color' => 'ffffff',
			'default-image' => '',
		) ) );

		// TODO what is this ?
		// Add theme support for selective refresh for widgets.
		add_theme_support( 'customize-selective-refresh-widgets' );

		// TODO remove since logo should be fix
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
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function chouquette_content_width() {
	// This variable is intended to be overruled from themes.
	// Open WPCS issue: {@link https://github.com/WordPress-Coding-Standards/WordPress-Coding-Standards/issues/1043}.
	// phpcs:ignore WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedVariableFound
	$GLOBALS['content_width'] = apply_filters( 'chouquette_content_width', 640 );
}
add_action( 'after_setup_theme', 'chouquette_content_width', 0 );

/**
 * Enqueue scripts and styles.
 */
function chouquette_scripts() {
    global $chouquette_theme_version;

    wp_enqueue_style( 'slider', get_template_directory_uri() . '/dist/style.css', null, $chouquette_theme_version, 'all');

    wp_enqueue_script( 'vendor', get_template_directory_uri() . '/dist/vendor.js', null, $chouquette_theme_version, true);

    wp_enqueue_script( 'script', get_template_directory_uri() . '/dist/app.js', null, $chouquette_theme_version, true);

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

