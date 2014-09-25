<?php

//  Callback to Option Sections
function tria_wen_sections($input) {

    //  Remove Advance Section
    unset($input['advance']);

    //  Add the Find a Provider Section
    $input['section_find_a_provider'] = array(
        'id' => 'section_find_a_provider',
        'title' => __('Find a Provider', TEXT_DOMAIN),
    );
    //  Add the Content Pages Section
    $input['content_pages'] = array(
        'id' => 'content_pages',
        'title' => __('Content Pages', TEXT_DOMAIN),
    );

    //  Add the Forms Section
    $input['forms_selection'] = array(
        'id' => 'forms_selection',
        'title' => __('Forms Selection', TEXT_DOMAIN),
    );

    //  Add the Homepage Section
    /*$input['homepage'] = array(
        'id' => 'homepage',
        'title' => __('Homepage', TEXT_DOMAIN),
    );*/

    //  Add the Contact Section
    $input['contact'] = array(
        'id' => 'contact',
        'title' => __('Contact', TEXT_DOMAIN)
    );

    //  Return
    return $input;
}

//  Add Filter to Option Sections
add_filter('wen_filter_theme_option_sections', 'tria_wen_sections');

//  Callback to Option Fields
function tria_wen_fields($input) {

    //  Unset Unrequired Fields
    unset($input['flag_site_description']);
    unset($input['flag_comment_in_page']);

    //  Add the Footer Logo Support
    $input['provider_per_page'] = array(
        'id' => 'provider_per_page',
        'label' => __('Provider per page', TEXT_DOMAIN),
        'desc' => __('Select Provider per page', TEXT_DOMAIN),
        'type' => 'numeric_slider',
        'std' => 10,
        'min_max_step' => '2,20,2',
        'section' => 'section_find_a_provider',
    );
    //  Add the Footer Logo Support
    $input['footer_logo'] = array(
        'id' => 'footer_logo',
        'label' => __('Footer Logo', TEXT_DOMAIN),
        'desc' => __('Upload Footer Logo', TEXT_DOMAIN),
        'type' => 'upload',
        'section' => 'footer',
    );

    //  Add the Seminar Page Selection
    $input['cp_seminar'] = array(
        'id' => 'cp_seminar',
        'label' => __('Smart Body Seminar', TEXT_DOMAIN),
        'desc' => __('Select the Smart Body Seminars Page', TEXT_DOMAIN),
        'type' => 'custom-post-type-select',
        'post_type' => 'page',
        'section' => 'content_pages'
    );

    //  Add the Tuesday Conference Page Selection
    $input['cp_tuesday_conference'] = array(
        'id' => 'cp_tuesday_conference',
        'label' => __('Tuesday Conference', TEXT_DOMAIN),
        'desc' => __('Select the Tuesday Conference Page', TEXT_DOMAIN),
        'type' => 'custom-post-type-select',
        'post_type' => 'page',
        'section' => 'content_pages'
    );

    //  Add the OSM Conference Page Selection
    $input['cp_osm_conference'] = array(
        'id' => 'cp_osm_conference',
        'label' => __('OSM Conference', TEXT_DOMAIN),
        'desc' => __('Select the OSM Conference Page', TEXT_DOMAIN),
        'type' => 'custom-post-type-select',
        'post_type' => 'page',
        'section' => 'content_pages'
    );
    //  Add the OSM Conference Registration Page Selection
    $input['cp_osm_registration'] = array(
        'id' => 'cp_osm_registration',
        'label' => __('OSM Conference Registration', TEXT_DOMAIN),
        'desc' => __('Select the OSM Conference Registration Page', TEXT_DOMAIN),
        'type' => 'custom-post-type-select',
        'post_type' => 'page',
        'section' => 'content_pages'
    );

    //  Add the Contact Page Selection
    $input['cp_contact'] = array(
        'id' => 'cp_contact',
        'label' => __('Contact Us', TEXT_DOMAIN),
        'desc' => __('Select the Contact Us Page', TEXT_DOMAIN),
        'type' => 'custom-post-type-select',
        'post_type' => 'page',
        'section' => 'content_pages'
    );

    //  Add the Find a Doctor Page Selection
    $input['cp_find_a_doctor'] = array(
        'id' => 'cp_find_a_doctor',
        'label' => __('Find a Doctor', TEXT_DOMAIN),
        'desc' => __('Select the Find a Doctor Page', TEXT_DOMAIN),
        'type' => 'custom-post-type-select',
        'post_type' => 'page',
        'section' => 'content_pages'
    );

    //  Add the Find a Doctor Page Selection
    $input['cp_all_providers'] = array(
        'id' => 'cp_all_providers',
        'label' => __('All Providers', TEXT_DOMAIN),
        'desc' => __('Select the All Providers Page', TEXT_DOMAIN),
        'type' => 'custom-post-type-select',
        'post_type' => 'page',
        'section' => 'content_pages'
    );

    //  Add the Directions Page Selection
    $input['cp_directions'] = array(
        'id' => 'cp_directions',
        'label' => __('Directions', TEXT_DOMAIN),
        'desc' => __('Select the Directions Page', TEXT_DOMAIN),
        'type' => 'custom-post-type-select',
        'post_type' => 'page',
        'section' => 'content_pages'
    );

    //  Add the Acute Injury Clinic Page Selection
    $input['cp_acute_injury_clinic'] = array(
        'id' => 'cp_acute_injury_clinic',
        'label' => __('Acute Injury Clinic', TEXT_DOMAIN),
        'desc' => __('Select the Acute Injury Clinic Page', TEXT_DOMAIN),
        'type' => 'custom-post-type-select',
        'post_type' => 'page',
        'section' => 'content_pages'
    );

    //  Add the Services Page Selection
    $input['cp_services'] = array(
        'id' => 'cp_services',
        'label' => __('Services', TEXT_DOMAIN),
        'desc' => __('Select the Services Page', TEXT_DOMAIN),
        'type' => 'custom-post-type-select',
        'post_type' => 'page',
        'section' => 'content_pages'
    );

    //  Add the Conditions and Treatments Page Selection
    $input['cp_conditions_n_treatments'] = array(
        'id' => 'cp_conditions_n_treatments',
        'label' => __('Conditions n\' Treatments', TEXT_DOMAIN),
        'desc' => __('Select the Conditions and Treatments Page', TEXT_DOMAIN),
        'type' => 'custom-post-type-select',
        'post_type' => 'page',
        'section' => 'content_pages'
    );

    //  Add the Events and Injury Page Selection
    $input['cp_events_n_injury'] = array(
        'id' => 'cp_events_n_injury',
        'label' => __('Events n\' Injury', TEXT_DOMAIN),
        'desc' => __('Select the Events and Injury Prevention Page', TEXT_DOMAIN),
        'type' => 'custom-post-type-select',
        'post_type' => 'page',
        'section' => 'content_pages'
    );

    //  Add the Schedule an Appointment Page Selection
    $input['cp_schedule_appointment'] = array(
        'id' => 'cp_schedule_appointment',
        'label' => __('Schedule an Appointment', TEXT_DOMAIN),
        'desc' => __('Select the Schedule an Appointment Page', TEXT_DOMAIN),
        'type' => 'custom-post-type-select',
        'post_type' => 'page',
        'section' => 'content_pages'
    );

    //  Add the Feedback Page Selection
    $input['cp_feedback'] = array(
        'id' => 'cp_feedback',
        'label' => __('Feedback', TEXT_DOMAIN),
        'desc' => __('Select the Feedback Page', TEXT_DOMAIN),
        'type' => 'custom-post-type-select',
        'post_type' => 'page',
        'section' => 'content_pages'
    );

    //  Add the Feedback Response Page Selection
    $input['cp_feedback_response'] = array(
        'id' => 'cp_feedback_response',
        'label' => __('Feedback Response', TEXT_DOMAIN),
        'desc' => __('Select the Feedback Response Page', TEXT_DOMAIN),
        'type' => 'custom-post-type-select',
        'post_type' => 'page',
        'section' => 'content_pages'
    );

    //  Add the Careers Page Selection
    $input['cp_careers'] = array(
        'id' => 'cp_careers',
        'label' => __('Careers', TEXT_DOMAIN),
        'desc' => __('Select the Careers Page', TEXT_DOMAIN),
        'type' => 'custom-post-type-select',
        'post_type' => 'page',
        'section' => 'content_pages'
    );

    //  Add the Holiday Hours Page Selection
    $input['cp_holiday_hours'] = array(
        'id' => 'cp_holiday_hours',
        'label' => __('Holiday Hours', TEXT_DOMAIN),
        'desc' => __('Select the Holiday Hours Page', TEXT_DOMAIN),
        'type' => 'custom-post-type-select',
        'post_type' => 'page',
        'section' => 'content_pages'
    );
    //  Add the Registration Form Page Selection
    $input['cp_registration_form'] = array(
        'id' => 'cp_registration_form',
        'label' => __('Registration Form Page', TEXT_DOMAIN),
        'desc' => __('Select the Registration Form Page', TEXT_DOMAIN),
        'type' => 'custom-post-type-select',
        'post_type' => 'page',
        'section' => 'content_pages'
    );

    //  Add the CF7 Form Selection for Feedback
    $input['cf7_feedback'] = array(
        'id' => 'cf7_feedback',
        'label' => __('Feedback Form', TEXT_DOMAIN),
        'desc' => __('Select the Form to use for Feedback', TEXT_DOMAIN),
        'type' => 'custom-post-type-select',
        'post_type' => 'wpcf7_contact_form',
        'section' => 'forms_selection'
    );

    //  Add the CF7 Form Selection for Doctor Feedback
    $input['cf7_doctor_feedback'] = array(
        'id' => 'cf7_doctor_feedback',
        'label' => __('Doctor Feedback Form', TEXT_DOMAIN),
        'desc' => __('Select the Form to use for Doctor Feedback', TEXT_DOMAIN),
        'type' => 'custom-post-type-select',
        'post_type' => 'wpcf7_contact_form',
        'section' => 'forms_selection'
    );

    //  Add the Email Address Field
    $input['contact_email'] = array(
        'id' => 'contact_email',
        'label' => __('Email Address', TEXT_DOMAIN),
        'desc' => __('Contact Email Address', TEXT_DOMAIN),
        'type' => 'text',
        'section' => 'contact'
    );

    //  Add the Phone Number Field
    $input['contact_phone_number'] = array(
        'id' => 'contact_phone_number',
        'label' => __('Phone Number', TEXT_DOMAIN),
        'desc' => __('Contact Phone Number', TEXT_DOMAIN),
        'type' => 'text',
        'section' => 'contact'
    );

    //  Add the Fax Number Field
    $input['contact_fax_number'] = array(
        'id' => 'contact_fax_number',
        'label' => __('Fax Number', TEXT_DOMAIN),
        'desc' => __('Contact Fax Number', TEXT_DOMAIN),
        'type' => 'text',
        'section' => 'contact'
    );

    //  Add the Location Details
    $input['contact_location_details'] = array(
        'id' => 'contact_location_details',
        'label' => __('Location Details', TEXT_DOMAIN),
        'desc' => __('Contact Location Details', TEXT_DOMAIN),
        'type' => 'textarea-simple',
        'section' => 'contact',
        'rows' => 3
    );

    //  Add the Location Map
    $input['contact_location_map'] = array(
        'id' => 'contact_location_map',
        'label' => __('Location Map', TEXT_DOMAIN),
        'desc' => __('Contact Location Map', TEXT_DOMAIN),
        'type' => 'upload',
        'section' => 'contact'
    );

    //  Add the Google Map Code Field
    $input['contact_google_map_code'] = array(
        'id' => 'contact_google_map_code',
        'label' => __('Google Map Embed', TEXT_DOMAIN),
        'desc' => __('Google Map Code to Embed(with iFrame)', TEXT_DOMAIN),
        'type' => 'textarea-simple',
        'section' => 'contact',
        'rows' => 8
    );

    //  Return
    return $input;
}

//  Add Filter to Option Fields
add_filter('wen_filter_theme_option_fields', 'tria_wen_fields');

//  Callback to Metabox Filter
function custom_remove_meta_boxes($input) {
    return false;
}

//  Add Filter to Metaboxes
add_filter('wen_filter_meta_boxes', 'custom_remove_meta_boxes');

//  Callback to Supported MIME Types
function custom_mtypes( $m ){

    //  Add SVG Upload Support
    $m['svg'] = 'image/svg+xml';
    $m['svgz'] = 'image/svg+xml';

    //  Return
    return $m;
}

//  Add Filter to Supported Upload File Mime
add_filter( 'upload_mimes', 'custom_mtypes' );

add_filter( 'wen_filter_excerpt_readmore', 'tria_wen_filter_excerpt_readmore' );

function tria_wen_filter_excerpt_readmore(){
    return false;
}

