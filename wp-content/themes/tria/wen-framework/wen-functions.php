<?php
/*
 * ****************************
 * Please DO NOT edit this file
 * ****************************
 */

/*
 * If you want to enable Admin Bar then define 'DISABLE_ADMIN_BAR' in your functions.php file
 * Eg: define('DISABLE_ADMIN_BAR', false );
 */
if ( DISABLE_ADMIN_BAR ) {

  // Hide Admin Bar in front-end
  add_filter('show_admin_bar', '__return_false');

}

// Enable shortcode in Widgets
add_filter('widget_text', 'do_shortcode');


/**
 * wen_add_favicon()
 */
if( ! function_exists( 'wen_add_favicon' ) ) :
  function wen_add_favicon(){
    $favicon = wen_get_option( 'favicon' );
    if ( ! empty( $favicon ) ) {
      echo '<link rel="shortcut icon" href="'.esc_url( $favicon ).'" />';
    }

  } // end function wen_add_favicon
endif;
add_action( 'wp_head', 'wen_add_favicon' );

/**
 * wen_ie_hack_script()
 */
if( ! function_exists( 'wen_ie_hack_script' ) ) :
  function wen_ie_hack_script(){
    $flag_apply_ie_hack_script = apply_filters('wen_filter_ie_hack_script', true );
    if ( true != $flag_apply_ie_hack_script ) {
      return;
    }
    ?>
    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
     <!--[if lt IE 9]>
       <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
       <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
     <![endif]-->
    <?php

  } // end function wen_ie_hack_script
endif;
add_action( 'wp_head', 'wen_ie_hack_script' );


/*
* wen_excerpt_readmore()
*/
if ( ! function_exists( 'wen_excerpt_readmore' ) ) :
    function wen_excerpt_readmore($more) {
        global $post;

        $flag_apply_excerpt_readmore = apply_filters('wen_filter_excerpt_readmore', true );
        if ( true != $flag_apply_excerpt_readmore ) {
          return $more;
        }

        $read_more_text = wen_get_option( 'read_more_text' );
        if ( empty( $read_more_text ) ) {
          return $more;
        }
        $output = '... <a href="'. esc_url( get_permalink( $post->ID ) ) . '" class="readmore">' . esc_attr( $read_more_text )  . '</a>';
        $output = apply_filters( 'wen_filter_read_more_content' , $output );
        return $output;
    }
endif; // wen_excerpt_readmore
add_filter( 'excerpt_more', 'wen_excerpt_readmore' );

/*
* wen_custom_excerpt_length()
*/
if ( ! function_exists( 'wen_custom_excerpt_length' ) ) :
    function wen_custom_excerpt_length( $length ){
        $excerpt_length = wen_get_option( 'excerpt_length' );
        if ( empty( $excerpt_length) ) {
          $excerpt_length = $length;
        }
        return apply_filters( 'wen_filter_excerpt_length', esc_attr( $excerpt_length ) );
    }
endif; // wen_custom_excerpt_length
add_filter( 'excerpt_length', 'wen_custom_excerpt_length', 999 );

/**
 * wen_filter_social_links_custom()
 */
if( ! function_exists( 'wen_filter_social_links_custom' ) ) :
  function wen_filter_social_links_custom($input){

    if ( isset($input['email'] ) ) {
      $input['email']['url'] = 'mailto:'.$input['email']['social_link'];
    }
    if ( isset($input['skype'] ) ) {
      $input['skype']['url'] = 'skype:'.$input['skype']['social_link'].'?call';
    }

    return $input;

  } // end function wen_filter_social_links_custom
endif;
add_filter( 'wen_filter_social_links', 'wen_filter_social_links_custom' );

/**
 * wen_footer_widgets_init()
 */
if( ! function_exists( 'wen_footer_widgets_init' ) ) :
  function wen_footer_widgets_init(){

    $flag_apply_footer_widgets = apply_filters('wen_filter_footer_widgets', true );
    if ( true != $flag_apply_footer_widgets ) {
      return false;
    }

    $flag_footer_widgets = wen_get_option('flag_footer_widgets','off');

    if ('on' == $flag_footer_widgets) {
      $number_of_footer_widgets = wen_get_option('number_of_footer_widgets');
      register_sidebars( $number_of_footer_widgets, array(
        'name'          => 'Footer Column %d',
        'id'            => "footer-sidebar",
        'before_widget' => '<aside id="%1$s" class="widget %2$s">',
        'after_widget'  => '</aside>',
        'before_title'  => '<h2 class="widget-title">',
        'after_title'   => '</h2>',
      ));
    }
  } // end function wen_footer_widgets_init
endif;

add_action( 'widgets_init', 'wen_footer_widgets_init', 100 );


/**
 * wen_add_custom_css()
 */
if( ! function_exists( 'wen_add_custom_css' ) ) :
  function wen_add_custom_css(){
    $custom_css = wen_get_option( 'custom_css' );
    $output = '';
    if ( ! empty( $custom_css ) ) {
      $output = "\n" . '<style type="text/css">' . "\n";
      $output .= esc_textarea( $custom_css ) ;
      $output .= "\n" . '</style>' . "\n" ;
    }
    echo $output;
  } // end function wen_add_custom_css
endif;
add_action( 'wp_head', 'wen_add_custom_css' );

/**
 * wen_add_custom_javascript_header()
 */
if( ! function_exists( 'wen_add_custom_javascript_header' ) ) :
  function wen_add_custom_javascript_header(){
    $custom_javascript_header = wen_get_option( 'custom_javascript_header' );
    $output = '';
    if ( ! empty( $custom_javascript_header ) ) {
      $output = "\n" . '<script type="text/javascript">' . "\n";
      $output .= '//<![CDATA[';
      $output .= $custom_javascript_header ;
      $output .= '//]]>';
      $output .= "\n" . '</script>' . "\n";
    }
    echo $output;
  } // end function wen_add_custom_javascript_header
endif;
add_action( 'wp_head', 'wen_add_custom_javascript_header' );

/**
 * wen_add_custom_javascript_footer()
 */
if( ! function_exists( 'wen_add_custom_javascript_footer' ) ) :
  function wen_add_custom_javascript_footer(){
    $custom_javascript_footer = wen_get_option( 'custom_javascript_footer' );
    $output = '';
    if ( ! empty( $custom_javascript_footer ) ) {
      $output = "\n" . '<script type="text/javascript">' . "\n";
      $output .= '//<![CDATA[';
      $output .= $custom_javascript_footer ;
      $output .= '//]]>';
      $output .= "\n" . '</script>' . "\n";
    }
    echo $output;
  } // end function wen_add_custom_javascript_footer
endif;
add_action( 'wp_footer', 'wen_add_custom_javascript_footer' );


/**
 * wen_custom_extra_body_class()
 */
if( ! function_exists( 'wen_custom_extra_body_class' ) ) :
  function wen_custom_extra_body_class( $classes ){
    global $is_lynx, $is_gecko, $is_IE, $is_opera, $is_NS4, $is_safari, $is_chrome;

    /* Browser detection. */
    $browsers = array( 'gecko' => $is_gecko, 'opera' => $is_opera, 'lynx' => $is_lynx, 'ns4' => $is_NS4, 'safari' => $is_safari, 'chrome' => $is_chrome, 'msie' => $is_IE );
    foreach ( $browsers as $key => $value ) {
      if ( $value ) {
        $classes[] = $key;
        break;
      }
    }

  /* Check if the current theme is a parent or child theme. */
  $classes[] = ( is_child_theme() ? 'child-theme' : 'parent-theme' );

  /* Is the current user logged in. */
  $classes[] = ( is_user_logged_in() ) ? 'logged-in' : 'logged-out';


    /* Return the array of classes. */
    return $classes;

  } // end function wen_custom_extra_body_class
endif;

add_filter( 'body_class', 'wen_custom_extra_body_class' );





/**
 * wen_framework_custom_init()
 */
if( ! function_exists( 'wen_framework_custom_init' ) ) :
  function wen_framework_custom_init() {

    add_post_type_support( 'page', 'excerpt' );

    remove_action( 'wp_head', 'rsd_link' );
    // windows live writer
    remove_action( 'wp_head', 'wlwmanifest_link' );
    // index link
    remove_action( 'wp_head', 'index_rel_link' );
    // previous link
    remove_action( 'wp_head', 'parent_post_rel_link', 10, 0 );
    // start link
    remove_action( 'wp_head', 'start_post_rel_link', 10, 0 );
    // links for adjacent posts
    remove_action( 'wp_head', 'adjacent_posts_rel_link_wp_head', 10, 0 );

  }
endif;
add_action('init', 'wen_framework_custom_init');


/**
 * wen_remove_version()
 */
if( ! function_exists( 'wen_remove_version' ) ) :
  function wen_remove_version() {
    // removes the WordPress version from your header for security
    return '<!--built on the WEN Framework '.WEN_FRAMEWORK_VERSION.' -->';
  }
endif;
add_filter('the_generator', 'wen_remove_version');

/**
 * Adds support for WooCommerce Plugin
 */
if ( in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {

  add_theme_support( 'woocommerce' );

}


/**
 * wen_admin_bar_customization()
 */
if( ! function_exists( 'wen_admin_bar_customization' ) ) :
  function wen_admin_bar_customization( $wp_admin_bar ) {
    $theme_option_slug = apply_filters('ot_theme_options_menu_slug','ot-theme-options');
    $args = array(
      'id'    => 'wf_theme_option',
      'title' => 'Theme Options',
      'href'  => add_query_arg( array( 'page'=> $theme_option_slug ), admin_url('themes.php') ) ,
      'meta'  => array( 'class' => 'wf-theme-options' )
    );
    $wp_admin_bar->add_node( $args );

  }
endif;
add_action( 'admin_bar_menu', 'wen_admin_bar_customization', 999 );