<?php
/**
 * Initialize the options before anything else.
 */
add_action( 'admin_init', 'wen_ot_custom_theme_options', 1 );

/**
 * Build the custom settings & update OptionTree.
 */
function wen_ot_custom_theme_options() {
  /**
   * Get a copy of the saved settings array.
   */
  $saved_settings = get_option( 'option_tree_settings', array() );

  /**
   * Custom settings array that will eventually be
   * passes to the OptionTree Settings API Class.
   */
  $theme_fields = trailingslashit( get_template_directory() ) . 'wf/option-fields.php';
  $theme_fields_child = trailingslashit( get_stylesheet_directory() ) . 'wf/option-fields.php';
  if ( file_exists( $theme_fields_child ) ) {
    $custom_settings =  include_once($theme_fields_child) ;
  }
  else if( file_exists( $theme_fields ) ) {
    $custom_settings =  include_once($theme_fields) ;
  }
  else{
    $custom_settings =  include_once trailingslashit( get_template_directory() ) . 'wen-framework/theme-options/option-fields.php' ;
  }
  $custom_settings['sections'] = apply_filters('wen_filter_theme_option_sections', $custom_settings['sections'] );
  $custom_settings['settings'] = apply_filters('wen_filter_theme_option_fields', $custom_settings['settings'] );

  /* settings are not the same update the DB */
  if ( $saved_settings !== $custom_settings ) {
    update_option( 'option_tree_settings', $custom_settings );
  }

}
