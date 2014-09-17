<?php /* start WPide restore code */
                                    if ($_POST["restorewpnonce"] === "5520c6066367feaba228203d4897407e48e5a2549a"){
                                        if ( file_put_contents ( "/home/bpdcom/public_html/wp/tria/wp-content/themes/tria/inc/wf-override.php" ,  preg_replace("#<\?php /\* start WPide(.*)end WPide restore code \*/ \?>#s", "", file_get_contents("/home/bpdcom/public_html/wp/tria/wp-content/plugins/wpide/backups/themes/tria/inc/wf-override_2014-08-05-10.php") )  ) ){
                                            echo "Your file has been restored, overwritting the recently edited file! \n\n The active editor still contains the broken or unwanted code. If you no longer need that content then close the tab and start fresh with the restored file.";
                                        }
                                    }else{
                                        echo "-1";
                                    }
                                    die();
                            /* end WPide restore code */ ?><?php

function tria_wen_sections( $input ){
  $input['seminar']= array(
    'id'    => 'seminar',
    'title' => __('Seminar', 'text-domain' ),
    );
  return $input;
}
add_filter('wen_filter_theme_option_sections','tria_wen_sections');

function tria_wen_fields( $input ){
  $input['seminar_title'] = array(
      'id'      => 'seminar_title',
      'label'   => __('Seminar Title', 'text-domain' ),
      'desc'    => __('Enter Seminar Title', 'text-domain' ),
      'type'    => 'text',
      'section' => 'seminar'
    );
  $input['seminar_banner'] = array(
      'id'      => 'seminar_banner',
      'label'   => __('Seminar Banner', 'text-domain' ),
      'desc'    => __('Upload Seminar Banner', 'text-domain' ),
      'type'    => 'upload',
      'section' => 'seminar'
    );
  $input['seminar_description'] = array(
      'id'      => 'seminar_description',
      'label'   => __('Seminar Description', 'text-domain' ),
      'desc'    => __('Enter Seminar Description', 'text-domain' ),
      'type'    => 'textarea',
      'section' => 'seminar'
    );

  return $input;
  }
// add_filter('wen_filter_theme_option_fields','tria_wen_fields');

function custom_remove_meta_boxes( $input ){
      return false;
    }
    add_filter( 'wen_filter_meta_boxes', 'custom_remove_meta_boxes' );