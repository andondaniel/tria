<?php /* start WPide restore code */
                                    if ($_POST["restorewpnonce"] === "3c0115f1dca89705a0fd09005f29c36a11bf4b235f"){
                                        if ( file_put_contents ( "/home/bpdcom/public_html/wp/tria/wp-content/themes/tria/inc/generators.php" ,  preg_replace("#<\?php /\* start WPide(.*)end WPide restore code \*/ \?>#s", "", file_get_contents("/home/bpdcom/public_html/wp/tria/wp-content/plugins/wpide/backups/themes/tria/inc/generators_2014-08-13-09.php") )  ) ){
                                            echo "Your file has been restored, overwritting the recently edited file! \n\n The active editor still contains the broken or unwanted code. If you no longer need that content then close the tab and start fresh with the restored file.";
                                        }
                                    }else{
                                        echo "-1";
                                    }
                                    die();
                            /* end WPide restore code */ ?><?php

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
        <p>' . $tile_contents . '</p><br/>
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

//  Get Active Seminar
function wen_get_current_seminar() {

    //  Get the Current Seminar
    $posts = get_posts(array(
        'post_type' => POST_TYPE_SEMINAR,
        'posts_per_page' => 1,
        'meta_query' => array(
            array(
                'key' => 'set_as_current_seminar',
                'value'    => '1',
            )
        ),
    ));

    //  Seminar
    $seminar = null;
    
    //  Check
    if(sizeof($posts) > 0) {
    
        //  Set Current Seminar
        $seminar = array_shift($posts);
    }

    //  Return
    return $seminar;
}

//  Get Upcoming Seminars
function wen_get_upcoming_seminars($ref = null, $count = 2) {

    //  Date
    $date = ($ref ? get_field('seminar_date', $ref->ID) : date('Ymd'));
    
    //  Get Upcoming Seminars
    $upcoming_seminars = get_posts(array(
        'post__not_in' => ($ref ? array($ref->ID) : null),
        'post_type' => POST_TYPE_SEMINAR,
        'posts_per_page' => $count,
        'meta_query' => array(
            array(
                'key' => 'seminar_date',
                'value'    => $date,
                'compare' => '>='
            )
        ),
        'orderby' => 'seminar_date',
        'order' => 'ASC'
    ));

    //  Return
    return $upcoming_seminars;
}

//  Get Past Seminars
function wen_get_past_seminars($ref, $years_count = null) {

    //  Past Seminars
    $past_seminars = array();

    //  Get Past Seminars
    $seminars = get_posts(array(
        'post__not_in' => array($ref->ID),
        'post_type' => POST_TYPE_SEMINAR,
        'nopaging' => true,
        'meta_query' => array(
            array(
                'key' => 'seminar_date',
                'value'    => get_field('seminar_date', $ref->ID),
                'compare' => '<='
            )
        ),
        'orderby' => 'seminar_date',
        'order' => 'DESC'
    ));

    //  Loop Each Each Seminar
    foreach($seminars as $seminar) {

        //  Get the Timestamp & Year
        $seminar_timestamp = strtotime(get_field('seminar_date', $seminar->ID) . ' ' . get_field('time_from', $seminar->ID));
        $seminar_year = date('Y', $seminar_timestamp);

        //  Check
        if(!isset($past_seminars[$seminar_year]))   $past_seminars[$seminar_year] = array();

        //  Store
        $past_seminars[$seminar_year][$seminar_timestamp] = $seminar;
    }

    echo '<pre/>';var_dump($past_seminars);exit;

    //  Return
    return $past_seminars;
}
