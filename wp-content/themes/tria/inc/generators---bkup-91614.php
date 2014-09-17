<?php

//  Generate the Tiles Row
function wen_tile_row_generator($post_id = null, $column_size = null, $class = null, $use_wrapper = true) {

    //  Fix Post ID
    $post_id || $post_id = get_the_ID();

    //  Fix the Column Size
    $column_size || $column_size = 3;

    //  Get the Tiles to Display
    $display_tiles = get_field('display_tiles', $post_id);

    //  Output
    $output = '';

    //  Check
    if($display_tiles && sizeof($display_tiles) > 0) {

        //  Check for Wrapper Required
        if($use_wrapper) {

            //  Start Wrapper
            $output .= '
            <div class="row">
                <div class="large-12 columns">
                    <div class="row">';
        }

        //  Loop Each
        foreach($display_tiles as $display_tile_id) {

            //  Add the Tile
            $output .= '<div class="large-' . $column_size . ' ' . (string)$class . ' columns post-title-custom">' . wen_tile_generator($display_tile_id) . '</div>';
        }

        //  Check for Wrapper Required
        if($use_wrapper) {

            //  End Wrapper
            $output .= '
                    </div>
                </div>
            </div>';
        }
    }

    //  Return Output
    return $output;
}

//  Generate Tile for Post
function wen_tile_generator($post_id = null) {

    //  Fix Post ID
    $post_id || $post_id = get_the_ID();

    //  Check
    if(!get_field('use_tile_settings', $post_id))   return '';

    //  Contents
    $tile_contents = (get_field('use_tagline_for_contents', $post_id) == true ? get_field('tag_line', $post_id) : get_field('tile_contents', $post_id));

    //  Additional Link Details
    $additional_post = (get_field('use_additional_link', $post_id) == true ? get_field('additional_link', $post_id) : null);
    $additional_post_text=  ($additional_post ? (get_field('additional_link_text', $post_id) != '' ? get_field('additional_link_text', $post_id) : $additional_post->post_title) : null);

    //  Button Class
    $buttonClass = ($additional_post ? ' first-of-two' : '');
    if(get_field('set_button_active', $post_id))    $buttonClass .= ' green-button';

    //  Link Text
    $link_text = (get_field('link_text', $post_id) != '' ? get_field('link_text', $post_id) : get_the_title($post_id));

    //  Create the Output
    $output = '
    <a class="panel-link" href="' . get_permalink($post_id) . '">
        ' . wp_get_attachment_image(get_field('tile_background', $post_id), 'full') . '
    </a>
    <div class="overlay">
        <h6>' . get_field('tile_title', $post_id) . '</h6>
        <p>' . $tile_contents . '</p>
        <a href="' . get_permalink($post_id) . '" class="featured-button button' . $buttonClass . '">
            ' . $link_text . ' <span class="icons">&#59238;</span>
        </a>
        ' . ($additional_post ? '<a href="' . get_permalink($additional_post->ID) . '" class="featured-button button">' . $additional_post_text . ' <span class="icons">&#59238;</span></a>' : '') . '
    </div>';

    //  Return Output
    return $output;
}

//  Generate Green Button
function wen_generate_button($type, $label, $link = null, $class = null) {

    //  Type Maps
    $maps = array(
        'green' => 'button',
        'blue' => 'alt-button-2'
    );

    //  Button Class
    $buttonClass = (isset($maps[$type]) ? $maps[$type] : '');

    //  Output
    $output = '<a ' . ($link ? 'href="' . $link . '"' : '') . ' class="' . $buttonClass . ' fullwidthbutton ' . (string)$class . '">' . $label . '</a>';

    //  Return
    return $output;
}

//  Get Current Event
function wen_get_current_event($identifier = 'set_as_current_seminar', $post_type = POST_TYPE_SEMINAR) {

    //  Global
    global $wen_current_events;
    if(!$wen_current_events)    $wen_current_events = array();

    //  Check
    if(isset($wen_current_events[$post_type]))
        return $wen_current_events[$post_type];

    //  Get the Current Event
    $posts = get_posts(array(
        'post_type' => $post_type,
        'posts_per_page' => 1,
        'meta_query' => array(
            array(
                'key' => $identifier,
                'value'    => '1',
            )
        ),
    ));

    //  Event
    $event = null;

    //  Check
    if(sizeof($posts) > 0) {

        //  Set Current Event
        $event = array_shift($posts);

        //  Store
        $wen_current_events[$post_type] = $event;
    }

    //  Return
    return $event;
}

//  Get Upcoming Events
function wen_get_upcoming_events($ref = null, $identifier = 'seminar_date', $post_type = POST_TYPE_SEMINAR, $count = 2) {

    //  Date
    $date = ($ref ? get_field($identifier, $ref->ID) : date('Ymd'));

    //  Get Upcoming Events
    $upcoming_events = get_posts(array(
        'post__not_in' => ($ref ? array($ref->ID) : null),
        'post_type' => $post_type,
        'posts_per_page' => $count,
        'meta_key' => $identifier,
        'meta_query' => array(
            array(
                'key' => $identifier,
                'value'    => $date,
                'compare' => '>='
            )
        ),
        'orderby' => 'meta_value',
        'order' => 'ASC'
    ));

    //  Return
    return $upcoming_events;
}

//  Get Past Events
function wen_get_past_events($ref, $identifier = 'seminar_date', $identifier2 = 'time_from', $post_type = POST_TYPE_SEMINAR, $years_count = null) {

    //  Past Events
    $past_events = array();

    //  Get Past Events
    $events = get_posts(array(
        'post__not_in' => array($ref->ID),
        'post_type' => $post_type,
        'nopaging' => true,
        'meta_key' => $identifier,
        'meta_query' => array(
            array(
                'key' => $identifier,
                'value'    => get_field($identifier, $ref->ID),
                'compare' => '<='
            )
        ),
        'orderby' => 'meta_value',
        'order' => 'DESC'
    ));

    //  Loop Each Each Event
    foreach($events as $event) {

        //  Get the Timestamp & Year
        $event_timestamp = strtotime(get_field($identifier, $event->ID) . ' ' . get_field($identifier2, $event->ID));
        $event_year = date('Y', $event_timestamp);

        //  Check
        if(intval($years_count) > 0 &&
                !isset($past_events[$event_year]) && sizeof($past_events) >= $years_count)
            break;

        //  Check
        if(!isset($past_events[$event_year]))   $past_events[$event_year] = array();

        //  Store
        $past_events[$event_year][$event_timestamp] = $event;
    }

    //  Loop Each
    foreach($past_events as $year => $pEvents) {

        //  Sort the Events
        krsort($pEvents);

        //  Store
        $past_events[$year] = $pEvents;
    }

    //  Sort
    krsort($past_events);

    //  Return
    return $past_events;
}

//  Get the Excerpt Date Format
function wen_event_date_excerpt_format() {

    //  Return with Filters Applied
    return apply_filters('wen_event_date_excerpt_format', 'l, F jS, Y, h:i A');
}

//  Print the Current Event Output
function wen_print_current_event($current_event, $label = 'Upcoming Seminar', $identifier = 'seminar_date', $identifier2 = 'time_from', $label2 = 'Up Next') {

    //  Check
    if($current_event) {

        //  Date Display Format
        $date_format = wen_event_date_excerpt_format();
?>
<div class="current-seminar-block">
    <a class="panel-link" href="<?php echo get_permalink($current_event->ID); ?>">
        <img src="<?php echo get_template_directory_uri();?>/img/smartbody-sidebar.jpg"/>
    </a>
    <div class="overlay">
        <h6><?php echo $label2; ?></h6>
        <p>
            <b><?php echo apply_filters('the_title', $current_event->post_title); ?></b><br/>
            <?php echo date($date_format, strtotime(get_field($identifier, $current_event->ID) . ' ' . get_field($identifier2, $current_event->ID))); ?>
        </p>
        <a class="featured-button button" href="<?php echo get_permalink($current_event->ID); ?>">
            <?php echo $label; ?>
        </a>
    </div>
</div>
<?php }
}

//  Print the Upcoming Events Output
function wen_print_upcoming_events($upcoming_events, $identifier = 'seminar_date', $identifier2 = 'time_from') {

    //  Check for Upcoming Events
    if(sizeof($upcoming_events) > 0) {

        //  Date Display Format
        $date_format = wen_event_date_excerpt_format();
?>
<div class="upcoming-events">
    <?php foreach($upcoming_events as $upcoming_event) { ?>
    <div class="upcoming-event">
        <p>
            <b><?php echo apply_filters('the_title', $upcoming_event->post_title); ?></b>
            <?php echo date($date_format, strtotime(get_field($identifier, $upcoming_event->ID) . ' ' . get_field($identifier2, $upcoming_event->ID))); ?>
        </p>
    </div>
    <?php } ?>
</div>
<?php }
}

//  Print the Past Events Output
function wen_print_past_events($past_events, $style = 1, $identifier = 'seminar_date', $identifier2 = 'time_from', $label = 'Past Seminars') {

    //  Check
    if(sizeof($past_events) > 0) {

        //  Date Display Format
        $date_format = wen_event_date_excerpt_format();
?>
<?php if($style == 1) { ?>
<a class="button fullwidthbutton pastseminars"><?php echo $label; ?></a>
<?php } else if($style == 2) { ?>
<p class="biggerbold tues-cat past"><?php echo $label; ?></p>
<?php } ?>
<dl class="accordion" data-accordion>
    <?php $i = 1; ?>
    <?php foreach($past_events as $past_year => $pEvents) { ?>
    <dd class="accordion-navigation">
        <a class="<?php echo ($i > 1 ? 'light-' : ''); ?>grey-button" href="#panel<?php echo $i; ?>"><?php echo $past_year; ?></a>
        <div id="panel<?php echo $i; ?>" class="content <?php echo ($i == 1 ? 'active' : ''); ?>">
            <?php foreach($pEvents as $pEvent) { ?>
            <p>
                <b><?php echo apply_filters('the_title', $pEvent->post_title); ?></b>
                <?php echo date($date_format, strtotime(get_field($identifier, $pEvent->ID) . ' ' . get_field($identifier2, $pEvent->ID))); ?>
            </p>
            <?php } ?>
        </div>
    </dd>
    <?php $i++; } ?>
</dl>
<?php }
}

//  Print the Newsletter Form
function wen_newsletter_form() {
?>
<div class="mailing-subscribe">
    <h4>Mailing List</h4>
    <p>If you are interested in receiving notices regarding upcoming seminars, sign up for our mailing list:</p>
    <form action="" method="post" class="mailing-subscribe-form">
        <?php wp_nonce_field('wen-newsletter-subscribe', '_wen_newsletter'); ?>
        <input type="email" name="email" class="required email" id="mce-EMAIL" placeholder="Email" required />
        <br />
        <input type="submit" value="Subscribe" name="subscribe" id="mc-embedded-subscribe" class="button">
    </form>
</div>
<?php
}
