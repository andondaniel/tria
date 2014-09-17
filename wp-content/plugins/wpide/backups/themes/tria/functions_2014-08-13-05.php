<?php /* start WPide restore code */
                                    if ($_POST["restorewpnonce"] === "3c0115f1dca89705a0fd09005f29c36a11bf4b235f"){
                                        if ( file_put_contents ( "/home/bpdcom/public_html/wp/tria/wp-content/themes/tria/functions.php" ,  preg_replace("#<\?php /\* start WPide(.*)end WPide restore code \*/ \?>#s", "", file_get_contents("/home/bpdcom/public_html/wp/tria/wp-content/plugins/wpide/backups/themes/tria/functions_2014-08-13-05.php") )  ) ){
                                            echo "Your file has been restored, overwritting the recently edited file! \n\n The active editor still contains the broken or unwanted code. If you no longer need that content then close the tab and start fresh with the restored file.";
                                        }
                                    }else{
                                        echo "-1";
                                    }
                                    die();
                            /* end WPide restore code */ ?><?php

//  Set Unicode utf-8
ini_set('default_charset', 'utf-8');

//  Theme Data
$theme_data = wp_get_theme();

//  Define Text Domain
define('TEXT_DOMAIN', $theme_data->get('TextDomain'));

define( 'DISABLE_ADMIN_BAR', false );

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
	add_theme_support( 'post-thumbnails' );

	// This theme uses wp_nav_menu() in one location.
	register_nav_menus( array(
		'primary' => __( 'Primary Menu', 'tria' ),
		'footer' => __( 'Footer Menu', 'tria' ),
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
	// add_theme_support( 'post-formats', array(
	// 	'aside', 'image', 'video', 'quote', 'link'
	// ) );

	// Setup the WordPress core custom background feature.
	// add_theme_support( 'custom-background', apply_filters( 'tria_custom_background_args', array(
	// 	'default-color' => 'ffffff',
	// 	'default-image' => '',
	// ) ) );
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
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );
	register_sidebar( array(
		'name'          => __( 'Right Sidebar', 'tria' ),
		'id'            => 'sidebar-right',
		'description'   => '',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );
	register_sidebar( array(
		'name'          => __( 'Footer Sitemap Left', 'tria' ),
		'id'            => 'sidebar-sitemap-left',
		'description'   => '',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );
	register_sidebar( array(
		'name'          => __( 'Footer Sitemap Right', 'tria' ),
		'id'            => 'sidebar-sitemap-right',
		'description'   => '',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );
}
add_action( 'widgets_init', 'tria_widgets_init' );

/**
 * Enqueue scripts and styles.
 */
function tria_scripts() {
	wp_enqueue_style( 'tria-googlefont-opensans', 'http://fonts.googleapis.com/css?family=Open+Sans' );
	wp_enqueue_style( 'tria-foundation', get_template_directory_uri() . '/css/foundation.css' );
	wp_enqueue_style( 'tria-slick', get_template_directory_uri() . '/thirdparty/slick/slick.css' );
	wp_enqueue_style( 'tria-style', get_stylesheet_uri() );
	wp_enqueue_style( 'tria-custom', get_template_directory_uri() . '/css/custom.css' );
	wp_enqueue_style( 'tria-custom-wen', get_template_directory_uri() . '/css/custom-wen.css' );

        wp_enqueue_script( 'tria-modernizr', get_template_directory_uri() . '/js/modernizr.js', array(), false);
        wp_enqueue_script( 'jquery', get_template_directory_uri() . '/js/jquery.js');
        wp_enqueue_script( 'jquery-cookie', get_template_directory_uri() . '/js/jquery.cookie.js');
        wp_enqueue_script( 'tria-fastclick-script', get_template_directory_uri() . '/js/fastclick.js', array(), '20120206', true );
        wp_enqueue_script( 'tria-foundation-script', get_template_directory_uri() . '/thirdparty/foundation/foundation.min.js', array(), '20120206', true );
	wp_enqueue_script( 'tria-slick-script', get_template_directory_uri() . '/thirdparty/slick/slick.min.js', array(), '20120206', true );
	wp_enqueue_script( 'tria-custom-script', get_template_directory_uri() . '/js/custom.js', array(), '20120206', true );
	// wp_enqueue_script( 'tria-navigation', get_template_directory_uri() . '/js/navigation.js', array(), '20120206', true );

	// wp_enqueue_script( 'tria-skip-link-focus-fix', get_template_directory_uri() . '/js/skip-link-focus-fix.js', array(), '20130115', true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'tria_scripts' );

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Custom functions that act independently of the theme templates.
 */
require get_template_directory() . '/inc/extras.php';

//  Load the Overrides
require_once get_template_directory() . '/inc/adv-override.php';
require_once get_template_directory() . '/inc/wf-override.php';

//  Load the Generators and Shortcodes
require_once get_template_directory() . '/inc/generators.php';
require_once get_template_directory() . '/inc/shortcodes.php';

//  Get all Widgets and Load
foreach(glob(get_template_directory() . '/widgets/*.php') as $widget_file) {

    //  Load the File
    include_once $widget_file;
}

//  Listen Widgets Init
add_action('widgets_init', 'wen_widgets_init');

//  Callback to Action
function wen_widgets_init() {

    //  Register the Widgets
    register_widget('WEN_Button_Widget');
    register_widget('WEN_Block_Widget');
}


function wen_get_speaker_info($speaker){

  $output = array_merge($speaker, array());
  $output['speaker_gravatar'] = '';
  $output['speaker_meta'] = '';

  if (!empty($speaker['speaker_id'])) {
    $output['speaker_full_name'] = $speaker['speaker_id']->post_title;
  }
  else{
    $output['speaker_full_name'] = $speaker['speaker_name'];
  }

  if ( 1 == $speaker['use_default_picture'] ) {
    if (!empty($speaker['speaker_id'])) {
      $image = wp_get_attachment_image_src( get_post_thumbnail_id( $speaker['speaker_id']->ID ), 'full' );
      if (!empty($image)) {
        $output['speaker_gravatar'] = $image[0];
      }
      $output['speaker_meta'] = get_fields($speaker['speaker_id']->ID);
    }
  }
  else{
    if (!empty($speaker['speaker_picture'])) {
      $output['speaker_gravatar'] = $speaker['speaker_picture']['url'];
    }
  }
  return $output;
}
