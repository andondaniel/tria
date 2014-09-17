<?php
/* ------------------------------------------------------------------------- *
 *  OptionTree framework integration: Use in theme mode
/* ------------------------------------------------------------------------- */

  add_filter( 'ot_show_pages', '__return_false' );
  add_filter( 'ot_show_new_layout', '__return_false' );
  add_filter( 'ot_theme_mode', '__return_true' );
  add_filter( 'ot_options_id', function($input){return 'wen_theme_options';});
  add_filter( 'ot_theme_options_menu_slug', function($input){return 'wen-theme-options';});
  add_filter( 'ot_theme_options_page_title', function($input){return 'WEN Theme Options';});
  load_template( trailingslashit( get_template_directory() ) . 'wen-framework/theme-options/option-tree/ot-loader.php' );

  global $wen_options;

  /*
  * wen_options_setup()
  */
  function wen_options_setup() {

    // Load theme options and meta boxes
    load_template( trailingslashit( get_template_directory() ) . 'wen-framework/theme-options/theme-options.php' );
    load_template( trailingslashit( get_template_directory() ) . 'wen-framework/theme-options/theme-metabox.php' );

    global $wen_options;
    $wen_options = get_option('wen_theme_options');
  }
  add_action( 'after_setup_theme', 'wen_options_setup' );

  /*
  * wen_get_option()
  * return: single theme option
  */
  if ( ! function_exists( 'wen_get_option' ) ) :
      function wen_get_option( $key, $default = '' ){
        global $wen_options;
        if ( isset( $wen_options[ $key ] ) && '' != $wen_options[ $key ] ) {
          return $wen_options[ $key ];
        }
        return $default;
      }
  endif; // wen_get_option

  /*
  * wen_get_options()
  * return: all theme options
  */
  if ( ! function_exists( 'wen_get_options' ) ) :
      function wen_get_options(){
        global $wen_options;
        return $wen_options;
      }
  endif; // wen_get_options

  /*
  * wen_get_meta()
  * return: single meta value
  */
  if ( ! function_exists( 'wen_get_meta' ) ) :
      function wen_get_meta( $post_id, $meta_key ){
        if ( empty( $post_id ) || empty( $meta_key ) ) {
          return;
        }
        return get_post_meta( $post_id, $meta_key, true );
      }
  endif; // wen_get_meta


/**
 * wen_register_custom_sidebars()
 */
if(!function_exists('wen_register_custom_sidebars')) :
  function wen_register_custom_sidebars(){
    $custom_sidebars = wen_get_option('custom_sidebars', array());

    if ( !empty( $custom_sidebars ) ) {
      foreach( $custom_sidebars as $sidebar ) {
        if ( ! isset($sidebar['id']) || ! isset($sidebar['title']) || empty($sidebar['id']) || empty($sidebar['title'])  || 'sidebar-' == $sidebar['id']) {
          continue;
        }
        register_sidebar( array(
          'name'          => ''.__( trim($sidebar['title']) ).'',
          'id'            => ''.strtolower($sidebar['id']).'',
          'description'   => ''.esc_attr($sidebar['caption']).'',
          'before_widget' => '<aside id="%1$s" class="widget %2$s">',
          'after_widget'  => '</aside>',
          'before_title'  => '<h2 class="widget-title">',
          'after_title'   => '</h2>',
        ) );
      }
    } //end if
  }
endif;
add_action( 'widgets_init', 'wen_register_custom_sidebars', 50 );

/**
 * wen_custom_validate_theme_options()
 */
if(!function_exists('wen_custom_validate_theme_options')) :
  function wen_custom_validate_theme_options($input, $type, $field_id) {
      if ( 'excerpt_length' == $field_id ) {
          if( ! ctype_digit( $input ) ) {
              $input = '' ;
          }
      }
      return $input;
  }
endif;
add_filter('ot_validate_setting', 'wen_custom_validate_theme_options', 10, 3);
