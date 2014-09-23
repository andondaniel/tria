<?php
$page_meta = get_fields();
$banner_style = '';
if (!empty($page_meta['banner_image'])) {
    $banner_style = "background-image: url('" . $page_meta['banner_image']['url'] . "')";
}

//  Get Current Conference
$current_conference = wen_get_current_event('tc_set_as_current_conference', POST_TYPE_TUESDAY_CONFERENCE);

//  Metas
$post_meta = get_fields($current_conference->ID);

?>

<div class="large-12 columns">
    <?php get_sidebar(); ?>
    <br>

    <?php $banner_image = get_field('banner_image'); ?>
    <div class="large-10 columns header-column">
        <div style="<?php echo $banner_style; ?>" class="tues-page-header">
            <h1><?php the_title(); ?></h1>
            <hr>
        </div>
    </div>
    <div class="large-10 columns">
        <div class="large-8 columns paddingforty">
            <?php the_content(); ?>

            <h3 class="tuesh3">Tuesday Conference Schedule</h3>


            <?php

            $identifier = 'tc_date';
            $eargs = array(
                'post_type' => POST_TYPE_TUESDAY_CONFERENCE,
                'nopaging' => true,
                'meta_key' => $identifier,
                'orderby' => 'meta_value',
                'order' => 'DESC'
            );
            // nspre($events,'evets');
            $custom_query = new WP_Query( $eargs );
             ?>
             <?php
             // Pagination fix
             global $wp_query;
             $temp_query = $wp_query;
             $wp_query   = NULL;
             $wp_query   = $custom_query;
             ?>
             <?php if ( $custom_query->have_posts() ) : ?>

               <!-- the loop -->
               <?php while ( $custom_query->have_posts() ) : $custom_query->the_post(); ?>

                <?php
                    $ev_meta = get_fields();
                    // nspre($ev_meta);
                    $ev_month = date('F',strtotime($ev_meta[$identifier]));
                    $ev_year = date('Y',strtotime($ev_meta[$identifier]));
                    $ev_day = date('d',strtotime($ev_meta[$identifier]));
                    // nspre($ev_month,'ev_month');
                    $same_row = false;
                    if ($ev_month == $prev_month && $ev_year == $prev_year) {
                        $same_row = true;
                    }
                 ?>


                 <?php if ( ! $same_row ): ?>
                    <p>
                        <strong><?php echo $ev_month; ?> (<?php echo $ev_year; ?>)</strong>
                    </p>

                 <?php endif ?>



                <p style="margin-bottom:15px;">
                    <?php echo $ev_day; ?> - <?php the_title(); ?>
                    <?php if (!empty($ev_meta['speaker'])): ?>

                        <?php echo '&nbsp;-&nbsp;' ?>

                        <?php $speaker_count = count($ev_meta['speaker']); ?>

                        <?php $cnt =0; ?>
                        <?php foreach ($ev_meta['speaker'] as $key => $speaker): ?>
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
                             <?php echo $link_open.$speaker_info['speaker_full_name'].$link_close; ?>
                             <?php if($cnt < ( $speaker_count-1 ) ) echo ', '; ?>


                             <?php $cnt++; ?>
                        <?php endforeach ?>


                    <?php endif ?>

                </p>

                <?php
                    $prev_month = $ev_month;
                    $prev_year  = $ev_year;
                 ?>

               <?php endwhile; ?>
               <!-- end of the loop -->

             <?php endif; ?>

             <?php
             // Reset postdata
             wp_reset_postdata();
             ?>

             <?php
             // Reset main query object
             $wp_query = NULL;
             $wp_query = $temp_query;
             ?>





            <?php

                //  Get Past Conferences
                //$past_confs = wen_get_past_events($current_conference, 'tc_date', 'tc_time_from', POST_TYPE_TUESDAY_CONFERENCE);

                // nspre($past_confs,'past');

                //  Print the Past Tuesday Conferences Block
                //wen_print_past_events($past_confs, 2, 'tc_date', 'tc_time_from', 'Past');

            ?>
        </div>
        <div class="large-4 columns paddingtwenty right-sidebar">


            <h4>NEW CONFERENCE LOCATION</h4>
            <?php $tc_location = $post_meta['tc_location']; ?>
            <?php if (!empty($tc_location)): ?>
              <?php echo apply_filters('the_content', $tc_location ); ?>
            <?php endif ?>


            <?php $map_url  = $post_meta['map_url']; ?>
            <?php if (!empty($map_url)): ?>
                <?php echo $map_url; ?>
            <?php endif ?>

            <div style="height:10px;">&nbsp;</div>
            <?php
                $register_url = tria_get_registration_url( $post_meta, 'tc_register_url' );
             ?>
            <a class="button bigbtn" href="<?php echo $register_url; ?>">Register online</a>

            <?php
                dynamic_sidebar('sidebar-tuesday-conference');

            ?>

        </div>
    </div>
</div>
