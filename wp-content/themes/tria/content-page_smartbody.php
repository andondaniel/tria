<?php

//  Get Fields
$page_meta = get_fields();

//  Global
global $current_seminar, $current_seminar_metas;

//  Get Current Seminar
$current_seminar = wen_get_current_event();

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
       $register_url = tria_get_registration_url($current_seminar_metas);
      ?>

       <a class="button bigbtn" href="<?php echo $register_url; ?>" target="_blank">Register Now</a>
       <p class="text-center"> Or call <?php echo wen_get_option('contact_phone_number'); ?></p>
     </div>
   </div>

   <div class="large-10 columns">
     <div class="large-8 columns paddingforty">
       <?php
       // nspre($current_seminar_metas,'current_seminar_metas');
       $image_url = '';
       $style_text = '';
       if (!empty($current_seminar_metas['tria_event_banner'])) {
         $image_url = $current_seminar_metas['tria_event_banner']['url'];
       }
       if (!empty($image_url)) {
         $style_text = "background-image: url('".$image_url."')";
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
            // nspre($speaker_info,'s');
            $link_open = '';
            $link_close = '';
            if (!empty($speaker_info['speaker_profile_url'])) {
              $link_open = '<a href="' . esc_url( $speaker_info['speaker_profile_url'] ) . '">';
              $link_close = '</a>';
            }
           ?>

         <div class="large-4 columns speaker">
            <?php echo $link_open; ?>
               <img src="<?php echo esc_url( $speaker_info['speaker_gravatar'] ); ?>">
            <?php echo $link_close; ?>
         </div>
         <div class="large-8 columns speaker">
          <h4>
            <?php echo $link_open.$speaker_info['speaker_full_name'].$link_close; ?>
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

