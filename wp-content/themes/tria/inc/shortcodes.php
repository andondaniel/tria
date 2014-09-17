<?php

//  Add Green Button Shortcode
add_shortcode('wen_btn', 'wen_green_btn_shortcode');

//  Callback to Shortcode
function wen_green_btn_shortcode($atts = array(), $label) {

    //  Extract
    extract(shortcode_atts(array(
        'type' => 'green',
        'class' => '',
        'link' => ''
    ), $atts));

    //  Return the Button
    return wen_generate_button($type, $label, $link, $class);
}