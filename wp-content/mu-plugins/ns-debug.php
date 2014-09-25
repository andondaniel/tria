<?php
/*
Plugin Name: NS Debug
Plugin URI: http://www.nilambar.net
Description: Debug Tool for WordPress
Author: Nilambar Sharma
Version: 1.0.0
Author URI: http://www.nilambar.net
*/

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

define('NS_DEBUG_NAME','NS Debug');
define('NS_DEBUG_SLUG','ns-debug');


/**
 * nspre
 *
 * Displays formatted output
 *
 * @author Nilambar Sharma <nilambar@outlook.com>
 * @copyright Copyright (c) 2013, Nilambar Sharma
 * @version 1.0
 *
 * @param mixed $str What do you want to display
 * @param string $title Title
 * @param bool $die Enable/disable die
 * @param bool $style   Enable/disable styling
 * @param bool $html Encoded html content
 * @return null
 *
 * @todo Make more advanced and awesome
 */
if (!function_exists('nspre')) :
  function nspre( $str, $title='', $die=false, $style = true, $html=false )
      {
          $o = '<pre';
      if($style)$o.=' style="
      border:1px solid red; background-color:#eee;margin:3px;height:auto; margin-left:3%;
      overflow:hidden; width:94%;padding:5px; color:#000; text-align:left;
      white-space: pre-wrap;
      white-space: -moz-pre-wrap !important;
      word-wrap: break-word;
      white-space: -o-pre-wrap;
      white-space: -pre-wrap;"';
      $o.='>';
    if($title!='')
    {
      $o.= '<p';
      if($style) $o.= '  style="border-bottom:1px solid red; color:#f00;font-weight:bold;padding:2px; margin:0px; text-align:left;"';
      $o.= '>'.$title.'</p>';
    }
    if(!$html)
    {
      $o.= print_r($str,true);
    }
    else
    {
      $o.= print_r(htmlentities($str),true);
    }

    $o.='</pre>';
    echo  $o;
    if($die) die;
    return ;
  }
endif;
////////////////////////////////////////////////////

////////////////////////////////////////////////////

/**
 * nssql
 *
 * Print last SQL query in WordPress
 *
 * @author Nilambar Sharma <nilambar@outlook.com>
 * @copyright Copyright (c) 2013, Nilambar Sharma
 * @version 1.0
 *
 * @param string $title Title
 * @param bool $die Enable/disable die
 * @return null
 *
 */
if (!function_exists('nssql')) :
  function nssql( $title='', $die = false ){

    nspre($GLOBALS['wp_query']->request, $title, $die );

  }
endif;
////////////////////////////////////////////////////

////////////////////////////////////////////////////
if(!function_exists('nslog')){
  function nslog( $message ) {
    if( WP_DEBUG === true ){
      if( is_array( $message ) || is_object( $message ) ){
        error_log( print_r( $message, true ) );
      } else {
        error_log( $message );
      }
    }
  }
}
////////////////////////////////////////////////////

////////////////////////////////////////////////////
if(!function_exists('nspre_die')){
  function nspre_die( $str, $title='' ) {
    nspre( $str, $title, true );
  }
}
////////////////////////////////////////////////////

////////////////////////////////////////////////////
if(!function_exists('nspre_clean')){
  function nspre_clean( $str, $title='' ) {
    nspre( $str, $title, $die, false, $html );
  }
}
////////////////////////////////////////////////////
