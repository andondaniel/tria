<?php
/*
Plugin Name: Custom Post Types Extended
Plugin URI: #
Description: Advanced Custom Post Types Extension (SaaS)
Version: 0.1.0
Author: WEN
Author URI: #
License: GPL
Copyright: WEN
*/

//  Define Constants
define('PLUGIN_CPTE_DIR', plugin_dir_path(__FILE__));
define('PLUGIN_CPTE_URI', plugin_dir_url(__FILE__));
define('PLUGIN_CPTE_LIB_DIR', PLUGIN_CPTE_DIR . 'lib/');
define('PLUGIN_CPTE_VIEWS_DIR', PLUGIN_CPTE_DIR . 'views/');
define('PLUGIN_CPTE_ASSETS_URI', PLUGIN_CPTE_URI . 'assets/');
define('PLUGIN_CPTE_ASSETS_JS_URI', PLUGIN_CPTE_ASSETS_URI . 'js/');
define('PLUGIN_CPTE_ASSETS_CSS_URI', PLUGIN_CPTE_ASSETS_URI . 'css/');


//  Theme Data
$theme_data = wp_get_theme();

//  Define Text Domain
define('CURRENT_THEME_TEXT_DOMAIN', $theme_data->get('TextDomain'));


//  Load the Functions File
require_once PLUGIN_CPTE_LIB_DIR . 'functions.php';
require_once PLUGIN_CPTE_LIB_DIR . 'get_hooked.php';

//  Add Action to Admin Menu
add_action('admin_menu', 'cpte_register_menus');

//  Callback to Action
function cpte_register_menus() {

    //  Add Settings Page
    //add_options_page('CPT Extended', 'CPT Extended', 'manage_options', 'cpt-extended-settings', 'display_cpte_settings_page');
}

//  Display Settings Page Callback
function display_cpte_settings_page() {

    //  Load View
    require_once PLUGIN_CPTE_VIEWS_DIR . 'settings.php';
}

