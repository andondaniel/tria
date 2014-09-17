<?php
/*
Plugin Name: Advanced Custom Fields: Provider Field
Plugin URI: #
Description: Provider ACF Field
Version: 1.0.0
Author: WEN
Author URI: #
License: GPL
Copyright: WEN
*/

// only include add-on once
if( !function_exists('acf_register_provider_field') ):


// add action to include field
add_action('acf/register_fields', 'acf_register_provider_field');

function acf_register_provider_field()
{
	include_once('provider.php');
}

endif; // class_exists check

?>
