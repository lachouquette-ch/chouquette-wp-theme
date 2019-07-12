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
define('CQ_THEME_VERSION', $chouquette_theme->get('Version'));
define('CQ_PRIMARY_MENU', 'primary-menu');
define('CQ_FOOTER_MENU', 'footer-menu');

define('CQ_FICHE_POST_TYPE', 'fiche');
define('CQ_FICHE_SELECTOR', 'link_fiche');

define('CQ_COOKIE_PREFIX', 'chouquette_');

define('CQ_CATEGORY_BAR_RETOS', 'bar-et-restaurant');
define('CQ_CATEGORY_LOISIRS', 'loisirs');
define('CQ_CATEGORY_CULTURE', 'culture-future');
define('CQ_CATEGORY_SHOPPING', 'shopping');
define('CQ_CATEGORY_CHOUCHOUS', 'services');

define('CQ_CATEGORY_LOGO_YELLOW', 'logo_yellow');
define('CQ_CATEGORY_LOGO_WHITE', 'logo_white');
define('CQ_CATEGORY_LOGO_BLACK', 'logo_black');
define('CQ_CATEGORY_LOGO_MARKER_YELLOW', 'marker_yellow');
define('CQ_CATEGORY_LOGO_MARKER_WHITE', 'marker_white');

define('CQ_CATEGORY_PAGING_NUMBER', 10);
define('CQ_CATEGORY_MAX_FICHES', 30);

define('ACF_FIELD_GROUP_TYPE', 'group');
define('ACF_FIELD_TAXONOMY_TYPE', 'taxonomy');

define('YOAST_PRIMARY_CATEGORY_META', '_yoast_wpseo_primary_category');

define('CQ_TAXONOMY_LOCATION', 'cq_location');
define('CQ_TAXONOMY_CRITERIA', 'cq_criteria');

define('CQ_SN_FACEBOOK', 'https://www.facebook.com/lachouquettelausanne');
define('CQ_SN_INSTAGRAM', 'https://www.instagram.com/lachouquettelausanne');

// TODO should be in wp-config.php
define('CQ_RECAPTCHA_SITE', '6LeGzZoUAAAAAMfFh3ybAsEBM_ocOUWbPnDRbg0U');
define('CQ_RECAPTCHA_SECRET', '6LeGzZoUAAAAAF35rYtWWthF9Wb_WDB1QPJ3hYG4');

define('CQ_FICHE_LOCATION', 'location');
define('CQ_FICHE_PHONE', 'telephone');
define('CQ_FICHE_WEB', 'website');
define('CQ_FICHE_MAIL', 'mail');
define('CQ_FICHE_COST', 'cost');
define('CQ_FICHE_FACEBOOK', 'sn_facebook');
define('CQ_FICHE_INSTAGRAM', 'sn_instagram');
define('CQ_FICHE_TWITTER', 'sn_twitter');
define('CQ_FICHE_PINTEREST', 'sn_pinterest');
define('CQ_FICHE_OPENING_MONDAY', 'opening_monday');
define('CQ_FICHE_OPENING_TUESDAY', 'opening_tuesday');
define('CQ_FICHE_OPENING_WEDNESDAY', 'opening_wednesday');
define('CQ_FICHE_OPENING_THURSDAY', 'opening_thursday');
define('CQ_FICHE_OPENING_FRIDAY', 'opening_friday');
define('CQ_FICHE_OPENING_SATURDAY', 'opening_saturday');
define('CQ_FICHE_OPENING_SUNDAY', 'opening_sunday');
define('CQ_FICHE_OPENING_CLOSED', 'closed');
define('CQ_FICHE_CHOUQUETTISE_FROM', 'chouquettise_from');
define('CQ_FICHE_CHOUQUETTISE_TO', 'chouquettise_to');

define('CQ_USER_ROLE', 'role');
define('CQ_LOCALISATION_AMBASSADOR', 'ambassadeur');

if (!function_exists('chouquette_setup')) :
    /**
     * Sets up theme defaults and registers support for various WordPress features.
     *
     * Note that this function is hooked into the after_setup_theme hook, which
     * runs before the init hook. The init hook is too late for some features, such
     * as indicating support for post thumbnails.
     */
    function chouquette_setup()
    {
        /*
         * Make theme available for translation.
         * Translations can be filed in the /languages/ directory.
         * If you're building a theme based on Chouquette thème, use a find and replace
         * to change 'chouquette' to the name of your theme in all the template files.
         */
        load_theme_textdomain('chouquette', get_template_directory() . '/languages');

        // Add default posts and comments RSS feed links to head.
        add_theme_support('automatic-feed-links');

        /*
         * Let WordPress manage the document title.
         * By adding theme support, we declare that this theme does not use a
         * hard-coded <title> tag in the document head, and expect WordPress to
         * provide it for us.
         */
        add_theme_support('title-tag');

        /*
         * Enable support for Post Thumbnails on posts and pages.
         *
         * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
         */
        add_theme_support('post-thumbnails');

        // This theme uses wp_nav_menu() in one location.
        register_nav_menus(array(
            CQ_PRIMARY_MENU => esc_html__('Menu principal', 'chouquette'),
            CQ_FOOTER_MENU => esc_html__('Menu footer', 'chouquette'),
        ));

        /*
         * Switch default core markup for search form, comment form, and comments
         * to output valid HTML5.
         */
        add_theme_support('html5', array(
            'search-form',
            'comment-form',
            'comment-list',
            'gallery',
            'caption',
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
add_action('after_setup_theme', 'chouquette_setup');

/**
 * Enqueue scripts and styles.
 */
if (!function_exists('chouquette_scripts')) :
    function chouquette_scripts()
    {
        $const = get_defined_constants();

        wp_enqueue_style('style', get_template_directory_uri() . '/dist/style.css', null, CQ_THEME_VERSION, 'all');

        wp_enqueue_style('font-awesome', 'https://use.fontawesome.com/releases/v5.7.2/css/all.css', null, null, 'all');

        wp_enqueue_script('mailchimp', '//s3.amazonaws.com/downloads.mailchimp.com/js/mc-validate.js', null, null, true);

        wp_enqueue_script('vendor', get_template_directory_uri() . '/dist/vendor.js', null, CQ_THEME_VERSION, true);

        wp_enqueue_script('recaptcha', "https://www.google.com/recaptcha/api.js?render={$const['CQ_RECAPTCHA_SITE']}", null, null, true);

        wp_enqueue_script('script', get_template_directory_uri() . '/dist/app.js', null, CQ_THEME_VERSION, true);

        // https://codex.wordpress.org/Function_Reference/comment_reply_link
        if (is_singular() && comments_open() && get_option('thread_comments')) {
            wp_enqueue_script('comment-reply');
        }
    }
endif;
add_action('wp_enqueue_scripts', 'chouquette_scripts');

/**
 * PHPMailer configuration
 */
if (!function_exists('chouquette_smtp')) :
    if (!defined('MAIL_ACTIVATE')) {
        define('MAIL_ACTIVATE', false);
    }
    if (!defined('MAIL_FALLBACK')) {
        define('MAIL_FALLBACK', get_option('admin_email'));
    }
    if (!defined('MAIL_BCC_FALLBACK')) {
        define('MAIL_BCC_FALLBACK', false);
    }

    function chouquette_smtp($phpmailer)
    {
        $phpmailer->isSMTP();
        $phpmailer->Host = SMTP_HOST;
        $phpmailer->SMTPAuth = SMTP_AUTH;
        $phpmailer->Port = SMTP_PORT;
        $phpmailer->SMTPSecure = SMTP_SECURE;
        $phpmailer->Username = SMTP_USERNAME;
        $phpmailer->Password = SMTP_PASSWORD;
        $phpmailer->From = SMTP_FROM;
        $phpmailer->FromName = SMTP_FROMNAME;
    }
endif;
add_action('phpmailer_init', 'chouquette_smtp');

/**
 * Implement the Custom Header feature.
 */
require get_template_directory() . '/inc/custom-header.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Various functions to enhance the theme.
 */
require get_template_directory() . '/inc/template-functions.php';
require get_template_directory() . '/inc/template-acf.php';
require get_template_directory() . '/inc/template-fiches.php';
require get_template_directory() . '/inc/template-categories.php';

/**
 * Posts methods to handle forms.
 */
require get_template_directory() . '/inc/template-posts.php';

/**
 * API template endpoints
 */
require get_template_directory() . '/inc/template-api.php';

/**
 * Load Jetpack compatibility file.
 */
if (defined('JETPACK__VERSION')) {
    require get_template_directory() . '/inc/jetpack.php';
}

