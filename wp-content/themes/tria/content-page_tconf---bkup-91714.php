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
            <p class="biggerbold tues-cat current">Current</p>

            <a href="<?php echo get_permalink($current_conference->ID); ?>"><?php echo $current_conference->post_title; ?></a>

            <?php
            $calendar_code = $post_meta['tc_calendar_code'];
            ?>
            <?php if (!empty($calendar_code)): ?>

                <div style="margin:15px 0;"><?php echo $calendar_code; ?></div>

            <?php endif ?>


            <?php

                //  Get Past Conferences
                $past_confs = wen_get_past_events($current_conference, 'tc_date', 'tc_time_from', POST_TYPE_TUESDAY_CONFERENCE);

                //  Print the Past Tuesday Conferences Block
                wen_print_past_events($past_confs, 2, 'tc_date', 'tc_time_from', 'Past');

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
