<?php /* start WPide restore code */
                                    if ($_POST["restorewpnonce"] === "5520c6066367feaba228203d4897407e6c197fa287"){
                                        if ( file_put_contents ( "/home/bpdcom/public_html/tria/wp-content/themes/tria/inc/wf-override.php" ,  preg_replace("#<\?php /\* start WPide(.*)end WPide restore code \*/ \?>#s", "", file_get_contents("/home/bpdcom/public_html/tria/wp-content/plugins/wpide/backups/themes/tria/inc/wf-override_2014-08-01-08.php") )  ) ){
                                            echo "Your file has been restored, overwritting the recently edited file! \n\n The active editor still contains the broken or unwanted code. If you no longer need that content then close the tab and start fresh with the restored file.";
                                        }
                                    }else{
                                        echo "-1";
                                    }
                                    die();
                            /* end WPide restore code */ ?><?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

function tria_wen_sections( $input ){
      $input['seminar']= array(
        'id'    => 'seminar',
        'title' => __('Seminar', 'text-domain' ),
        );
      return $input;
    }
add_filter('wen_filter_theme_option_sections','tria_wen_sections');