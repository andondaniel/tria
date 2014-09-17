<?php
define('WEN_FRAMEWORK_BASEPATH', 'wen-framework');
define('WEN_FRAMEWORK_VERSION', '1.0.1');

if ( ! defined( 'DISABLE_ADMIN_BAR' ) ) {
  define('DISABLE_ADMIN_BAR', true );
}

if ( ! defined( 'DISABLE_CUSTOM_LOGIN' ) ) {
  define('DISABLE_CUSTOM_LOGIN', false );
}

if ( ! defined( 'DISABLE_OPTION_EXPORT_IMPORT' ) ) {
  define('DISABLE_OPTION_EXPORT_IMPORT', false );
}

/**
 * Include theme option settings
 */
require trailingslashit( get_template_directory() ) . 'wen-framework/theme-options/option-setup.php';
/**
 * Include framework functions
 */
require trailingslashit( get_template_directory() ) . 'wen-framework/wen-functions.php';
/**
 * Include theme API functions
 */
require trailingslashit( get_template_directory() ) . 'wen-framework/wen-api.php';

if ( ! DISABLE_OPTION_EXPORT_IMPORT ) {
  /**
   * Include theme option export / import
   */
  require trailingslashit( get_template_directory() ) . 'wen-framework/theme-import-export.php';
}
if ( ! DISABLE_CUSTOM_LOGIN ) {
  /**
   * Include custom login design
   */
  require trailingslashit( get_template_directory() ) . 'wen-framework/custom-login/custom-login.php';
}
