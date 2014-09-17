<?php /* start WPide restore code */
                                    if ($_POST["restorewpnonce"] === "3c0115f1dca89705a0fd09005f29c36a11bf4b235f"){
                                        if ( file_put_contents ( "/home/bpdcom/public_html/wp/tria/wp-content/themes/tria/content-page_smartbody.php" ,  preg_replace("#<\?php /\* start WPide(.*)end WPide restore code \*/ \?>#s", "", file_get_contents("/home/bpdcom/public_html/wp/tria/wp-content/plugins/wpide/backups/themes/tria/content-page_smartbody_2014-08-13-08.php") )  ) ){
                                            echo "Your file has been restored, overwritting the recently edited file! \n\n The active editor still contains the broken or unwanted code. If you no longer need that content then close the tab and start fresh with the restored file.";
                                        }
                                    }else{
                                        echo "-1";
                                    }
                                    die();
                            /* end WPide restore code */ ?><?php

//  Get Fields
$page_meta = get_fields();

//  Global
global $current_seminar, $current_seminar_metas;

//  Get Current Seminar
$current_seminar = get_current_seminar();

//  Check
if($current_seminar) {

    //  Set the Metas
    $current_seminar_metas = get_fields($current_seminar->ID);
}

?>

 <?php if ($current_seminar): ?>

   <div class="large-10 columns">
     <div class="large-8 columns paddingforty">
       <?php the_content(); ?>
     </div>
     <div class="large-4 columns paddingforty">
     <?php
     $register_url = 'javascript:void(0)';
     if (!empty($current_seminar_metas['register_url'])) {
       $register_url = esc_url($current_seminar_metas['register_url']);
     }
      ?>

       <a class="button bigbtn" href="<?php echo $register_url; ?>" target="_blank">Register Now</a>
       <p class="text-center"> Or call <?php echo wen_get_option('contact_phone_number'); ?></p>
     </div>
   </div>

   <div class="large-10 columns">
     <div class="large-8 columns paddingforty">
       <?php
       $image = wp_get_attachment_image_src( get_post_thumbnail_id( $current_seminar->ID ), 'full' );
       $style_text = '';
       if (!empty($image)) {
         $style_text = "background-image: url('".$image[0]."')";
       }
        ?>
       <div style="<?php echo $style_text; ?>" class="smart-body-header">
         <h2><?php echo $current_seminar->post_title; ?></h2>
       </div>
       <h3><?php echo date('l, F jS, Y,', strtotime($current_seminar_metas['seminar_date'])); ?>&nbsp;<?php echo $current_seminar_metas['time_from'] ?>-<?php echo $current_seminar_metas['time_to'] ?>
       </h3>

       <?php echo apply_filters( 'the_content', $current_seminar_metas['seminar_description'] ); ?>

       <?php if (!empty($current_seminar_metas['speaker']) && is_array($current_seminar_metas['speaker']) ): ?>

        <?php foreach ($current_seminar_metas['speaker'] as $key => $speaker): ?>

          <?php
            $speaker_info = wen_get_speaker_info($speaker);
           ?>

         <div class="large-4 columns speaker">
           <img src="<?php echo esc_url( $speaker_info['speaker_gravatar'] ); ?>">
         </div>
         <div class="large-8 columns speaker">
          <h4>
            <?php echo $speaker_info['speaker_full_name']; ?>
            <?php if ( !empty($speaker_info['speaker_meta']) && isset($speaker_info['speaker_meta']['dr_specialty']) ): ?>
              <?php echo ', '.$speaker_info['speaker_meta']['dr_specialty']; ?>

            <?php endif ?>

          </h4>
          <p><?php echo strip_tags($speaker_info['speaker_description']); ?></p>

         </div>
         <div class="clearfix"></div>

        <?php endforeach ?>

       <?php endif ?>

     </div>

     <div class="large-4 columns paddingforty right-sidebar">

       <?php get_sidebar('seminar'); ?>

     </div> <!-- .right-sidebar -->
   </div>



   <?php else: ?>

    <p>Not found</p>

 <?php endif ?>

