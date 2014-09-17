<?php /* start WPide restore code */
                                    if ($_POST["restorewpnonce"] === "5520c6066367feaba228203d4897407e6c197fa287"){
                                        if ( file_put_contents ( "/home/bpdcom/public_html/tria/wp-content/themes/tria/functions.php" ,  preg_replace("#<\?php /\* start WPide(.*)end WPide restore code \*/ \?>#s", "", file_get_contents("/home/bpdcom/public_html/tria/wp-content/plugins/wpide/backups/themes/tria/functions_2014-08-01-07.php") )  ) ){
                                            echo "Your file has been restored, overwritting the recently edited file! \n\n The active editor still contains the broken or unwanted code. If you no longer need that content then close the tab and start fresh with the restored file.";
                                        }
                                    }else{
                                        echo "-1";
                                    }
                                    die();
                            /* end WPide restore code */ ?><?php

//  Theme Data
$theme_data = wp_get_theme();

//  Define Text Domain
define('TEXT_DOMAIN', $theme_data->get('TextDomain'));

//  Define Post Types
define('POST_TYPE_SEMINAR', 'seminar');


define( 'DISABLE_OPTION_EXPORT_IMPORT', true );

require trailingslashit( get_template_directory() ) . 'wen-framework/init.php';

/**
 * Tria functions and definitions
 *
 * @package Tria
 */

/**
 * Set the content width based on the theme's design and stylesheet.
 */
if ( ! isset( $content_width ) ) {
	$content_width = 640; /* pixels */
}

if ( ! function_exists( 'tria_setup' ) ) :
/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function tria_setup() {

	/*
	 * Make theme available for translation.
	 * Translations can be filed in the /languages/ directory.
	 * If you're building a theme based on Tria, use a find and replace
	 * to change 'tria' to the name of your theme in all the template files
	 */
	load_theme_textdomain( 'tria', get_template_directory() . '/languages' );

	// Add default posts and comments RSS feed links to head.
	add_theme_support( 'automatic-feed-links' );

	/*
	 * Enable support for Post Thumbnails on posts and pages.
	 *
	 * @link http://codex.wordpress.org/Function_Reference/add_theme_support#Post_Thumbnails
	 */
	//add_theme_support( 'post-thumbnails' );

	// This theme uses wp_nav_menu() in one location.
	register_nav_menus( array(
		'primary' => __( 'Primary Menu', 'tria' ),
	) );
	
	/*
	 * Switch default core markup for search form, comment form, and comments
	 * to output valid HTML5.
	 */
	add_theme_support( 'html5', array(
		'search-form', 'comment-form', 'comment-list', 'gallery', 'caption'
	) );

	/*
	 * Enable support for Post Formats.
	 * See http://codex.wordpress.org/Post_Formats
	 */
	add_theme_support( 'post-formats', array(
		'aside', 'image', 'video', 'quote', 'link'
	) );

	// Setup the WordPress core custom background feature.
	add_theme_support( 'custom-background', apply_filters( 'tria_custom_background_args', array(
		'default-color' => 'ffffff',
		'default-image' => '',
	) ) );
}
endif; // tria_setup
add_action( 'after_setup_theme', 'tria_setup' );

/**
 * Register widget area.
 *
 * @link http://codex.wordpress.org/Function_Reference/register_sidebar
 */
function tria_widgets_init() {
	register_sidebar( array(
		'name'          => __( 'Sidebar', 'tria' ),
		'id'            => 'sidebar-1',
		'description'   => '',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h1 class="widget-title">',
		'after_title'   => '</h1>',
	) );
}
add_action( 'widgets_init', 'tria_widgets_init' );

/**
 * Enqueue scripts and styles.
 */
function tria_scripts() {
	wp_enqueue_style( 'tria-style', get_stylesheet_uri() );

	wp_enqueue_script( 'tria-navigation', get_template_directory_uri() . '/js/navigation.js', array(), '20120206', true );

	wp_enqueue_script( 'tria-skip-link-focus-fix', get_template_directory_uri() . '/js/skip-link-focus-fix.js', array(), '20130115', true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'tria_scripts' );

/**
 * Implement the Custom Header feature.
 */
//require get_template_directory() . '/inc/custom-header.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Custom functions that act independently of the theme templates.
 */
require get_template_directory() . '/inc/extras.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Load Jetpack compatibility file.
 */
require get_template_directory() . '/inc/jetpack.php';


//  Add Action to Init
add_action('init', 'tria_register_post_types');

//  Callback to Action
function tria_register_post_types() {

    //  Custom Post Type Labels : Seminar
    $seminar_labels = array(
        'name' => _x('Seminars', 'post type general name', TEXT_DOMAIN),
        'singular_name' => _x('Seminar', 'post type singular name', TEXT_DOMAIN),
        'menu_name' => _x('Seminars', 'admin menu', TEXT_DOMAIN),
        'name_admin_bar' => _x('Seminar', 'add new on admin bar', TEXT_DOMAIN),
        'add_new' => _x('Add New', 'seminar', TEXT_DOMAIN),
        'add_new_item' => __('Add New Seminar', TEXT_DOMAIN),
        'new_item' => __('New Seminar', TEXT_DOMAIN),
        'edit_item' => __('Edit Seminar', TEXT_DOMAIN),
        'view_item' => __('View Seminar', TEXT_DOMAIN),
        'all_items' => __('All Seminars', TEXT_DOMAIN),
        'search_items' => __('Search Seminars', TEXT_DOMAIN),
        'parent_item_colon' => __('Parent Seminars:', TEXT_DOMAIN),
        'not_found' => __('No seminars found.', TEXT_DOMAIN),
        'not_found_in_trash' => __('No seminars found in Trash.', TEXT_DOMAIN)
    );

    //  Custom Post Type Args : Seminar
    $seminar_args = array(
        'labels' => $seminar_labels,
        'public' => true,
        'publicly_queryable' => true,
        'show_ui' => true,
        'show_in_menu' => true,
        'query_var' => true,
        'rewrite' => array('slug' => 'seminar'),
        'capability_type' => 'post',
        'has_archive' => true,
        'hierarchical' => false,
        'menu_position' => null,
        'supports' => array('title', 'editor', 'author', 'thumbnail', 'excerpt', 'comments')
    );

    //  Register Custom Post Type : Seminar
    register_post_type(POST_TYPE_SEMINAR, $seminar_args);

    //  Check Function Exists
    if(function_exists('cpte_register_page')) {

        //  Register the Page
        cpte_register_page('smart-body-seminars', POST_TYPE_SEMINAR);
    }
}