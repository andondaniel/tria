<?php /* start WPide restore code */
                                    if ($_POST["restorewpnonce"] === "3c0115f1dca89705a0fd09005f29c36ad6cfb1ddf1"){
                                        if ( file_put_contents ( "/home/bpdcom/public_html/wp/tria/wp-content/themes/tria/inc/adv-override.php" ,  preg_replace("#<\?php /\* start WPide(.*)end WPide restore code \*/ \?>#s", "", file_get_contents("/home/bpdcom/public_html/wp/tria/wp-content/plugins/wpide/backups/themes/tria/inc/adv-override_2014-08-15-06.php") )  ) ){
                                            echo "Your file has been restored, overwritting the recently edited file! \n\n The active editor still contains the broken or unwanted code. If you no longer need that content then close the tab and start fresh with the restored file.";
                                        }
                                    }else{
                                        echo "-1";
                                    }
                                    die();
                            /* end WPide restore code */ ?><?php

//  Define Custom Post Types
define('POST_TYPE_SEMINAR', 'seminar');
define('POST_TYPE_TUESDAY_CONFERENCE', 'tues-conf');
define('POST_TYPE_OSM_CONFERENCE', 'osm-conf');
define('POST_TYPE_DOCTOR', 'doctor');
define('POST_TYPE_TREATMENT', 'treatment');
define('POST_TYPE_CAREER', 'career');
define('POST_TYPE_SERVICE', 'service');
define('POST_TYPE_FEEDBACK', 'feedback');
define('POST_TYPE_SLIDER', 'wen-slider');

//  Define Custom Taxonomies
define('TAX_TYPE_DOC_INTEREST', 'doc_interest');
define('TAX_TYPE_DOC_PROVIDER_TYPE', 'doc_ptype');
define('TAX_TYPE_TREATMENT_BODYPART', 'tbody-part');
define('TAX_TYPE_TREATMENT_ACTIVITY', 'activity');
define('TAX_TYPE_DOC_LOCATION', 'doc_location');
define('TAX_TYPE_CAREER_DEPARTMENT', 'cdepartment');
define('TAX_TYPE_SERVICE', 'service_type');
define('TAX_TYPE_SLIDER_GROUP', 'wslider-group');

//  Define Custom Comment Types
define('COMMENT_TYPE_FORM_FEEDBACK', 'ffeedback');
define('COMMENT_TYPE_DOC_FEEDBACK', 'dfeedback');


//  Add Action to Init
add_action('init', 'tria_register_post_types', 10);

//  Callback to Action
function tria_register_post_types() {

    //  Register Custom Post Type : Seminar
    cpte_register_post_type(POST_TYPE_SEMINAR, 'Seminar', 'Seminars', array('custom-fields', 'thumbnail'), POST_TYPE_SEMINAR);

    //  Register Custom Post Type : Tuesday Conference
    cpte_register_post_type(POST_TYPE_TUESDAY_CONFERENCE, 'Tuesday Conference', 'Tuesday Conferences', array('custom-fields', 'thumbnail'), 'tconference');

    //  Register Custom Post Type : Tuesday Conference
    cpte_register_post_type(POST_TYPE_OSM_CONFERENCE, 'OSM Conference', 'OSM Conferences', array('custom-fields', 'thumbnail'), 'oconference');

    //  Register Custom Post Type : Doctor
    cpte_register_post_type(POST_TYPE_DOCTOR, 'Doctor', 'Doctors', null, POST_TYPE_DOCTOR);

    //  Register Custom Post Type : Treatment
    cpte_register_post_type(POST_TYPE_TREATMENT, 'Treatment', 'Treatments', null, POST_TYPE_TREATMENT);

    //  Register Custom Post Type : Career
    cpte_register_post_type(POST_TYPE_CAREER, 'Career', 'Careers', array('custom-fields'), POST_TYPE_CAREER);

    //  Register Custom Post Type : Service
    cpte_register_post_type(POST_TYPE_SERVICE, 'Service', 'Services', 'page-attributes', POST_TYPE_SERVICE);

    //  Register Custom Post Type : Feedback
    cpte_register_post_type(POST_TYPE_FEEDBACK, 'Feedback', 'Feedbacks', array('title', 'page-attributes'), POST_TYPE_FEEDBACK);

    //  Register Custom Post Type : Slider
    cpte_register_post_type(POST_TYPE_SLIDER, 'Slider', 'Sliders', array('title', 'thumbnail', 'page-attributes'), POST_TYPE_SLIDER, array(
        'public' => false
    ));


    //  Register Custom Taxonomy : Doctor Interest
    cpte_register_taxonomy(TAX_TYPE_DOC_INTEREST, POST_TYPE_DOCTOR, 'Interest', 'Interests', 'dinterest');

    //  Register Custom Taxonomy : Doctor Provider Type
    cpte_register_taxonomy(TAX_TYPE_DOC_PROVIDER_TYPE, POST_TYPE_DOCTOR, 'Provider Type', 'Provider Types', 'dptype');

    //  Register Custom Taxonomy : Doctor Location
    cpte_register_taxonomy(TAX_TYPE_DOC_LOCATION, POST_TYPE_DOCTOR, 'Location', 'Locations', 'dlocation');

    //  Register Custom Taxonomy : Treatment Bodypart
    cpte_register_taxonomy(TAX_TYPE_TREATMENT_BODYPART, POST_TYPE_TREATMENT, 'Body Part', 'Body Parts', TAX_TYPE_TREATMENT_BODYPART);

    //  Register Custom Taxonomy : Treatment Activity
    cpte_register_taxonomy(TAX_TYPE_TREATMENT_ACTIVITY, POST_TYPE_TREATMENT, 'Activity', 'Activities', TAX_TYPE_TREATMENT_ACTIVITY);

    //  Register Custom Taxonomy : Career Department
    cpte_register_taxonomy(TAX_TYPE_CAREER_DEPARTMENT, POST_TYPE_CAREER, 'Department', 'Departments', 'cdepartment');

    //  Register Custom Taxonomy : Service
    cpte_register_taxonomy(TAX_TYPE_SERVICE, POST_TYPE_SERVICE, 'Service Type', 'Service Types', TAX_TYPE_SERVICE);

    //  Register Custom Taxonomy : Service
    cpte_register_taxonomy(TAX_TYPE_SLIDER_GROUP, POST_TYPE_SLIDER, 'Slider Group', 'Slider Groups', TAX_TYPE_SLIDER_GROUP);


    //  Register Custom Comment Type : Form Feedback
    cpte_register_comment_type(COMMENT_TYPE_FORM_FEEDBACK, 'Feedback', 'Feedbacks');

    //  Register Custom Comment Type : Doctor Profile Feedback
    cpte_register_comment_type(COMMENT_TYPE_DOC_FEEDBACK, 'Doctor Feedback', 'Doctor Feedbacks', POST_TYPE_DOCTOR);


    //  CPTE Implementation
    //wen_cpte_extended_implementation();

    //  Hook Page to Post Type
    wen_cpte_extended_implementation_page();
}

//  Render the Complex Editing Layout Embeding the Page
function wen_cpte_extended_implementation_page() {

    //  Check Function Exists
    if(function_exists('cpte_register_page_to_post_type')) {

        //  Register the Page to Post Type : Seminar
        cpte_register_page_to_post_type(cpte_post_value('post_name', wen_get_option('cp_seminar')), POST_TYPE_SEMINAR, false, array(

            //  ACF Fields to Hook
            'hook_acf_fields' => array(
                'acf-field-seminar_title' => array(
                    'change' => 'title',
                    'duplicate' => 'post_title'
                ),
                'acf-field-seminar_description' => array(
                    'duplicate' => 'hidden_post_content'
                )
            )
        ));

        //  Register the Page to Post Type : Tuesday Conference
        cpte_register_page_to_post_type(cpte_post_value('post_name', wen_get_option('cp_tuesday_conference')), POST_TYPE_TUESDAY_CONFERENCE, false, array(

            //  ACF Fields to Hook
            'hook_acf_fields' => array(
                'acf-field-tc_event_title' => array(
                    'change' => 'title',
                    'duplicate' => 'post_title'
                )
            )
        ));

        //  Register the Page to Post Type : OSM Conference
        cpte_register_page_to_post_type(cpte_post_value('post_name', wen_get_option('cp_osm_conference')), POST_TYPE_OSM_CONFERENCE, false, array(

            //  ACF Fields to Hook
            'hook_acf_fields' => array(
                'acf-field-oc_event_title' => array(
                    'change' => 'title',
                    'duplicate' => 'post_title'
                )
            )
        ));

        //  Register the Page to Post Type : Doctor
        /*cpte_register_page_to_post_type(cpte_post_value('post_name', wen_get_option('cp_find_a_doctor')), POST_TYPE_DOCTOR, false, array(

            //  ACF Fields to Hook
            'hook_acf_fields' => array(
                'acf-field-dr_name' => array(
                    'change' => 'title',
                    'duplicate' => 'post_title'
                ),
                'acf-field-dr_description' => array(
                    'duplicate' => 'hidden_post_content'
                )
            )
        ));*/

        //  Register the Page to Post Type : Career
        cpte_register_page_to_post_type(cpte_post_value('post_name', wen_get_option('cp_careers')), POST_TYPE_CAREER, false, array(

            //  ACF Fields to Hook
            'hook_acf_fields' => array(
                'acf-field-job_title' => array(
                    'change' => 'title',
                    'duplicate' => 'post_title'
                ),
                'acf-field-job_description' => array(
                    'duplicate' => 'hidden_post_content'
                )
            )
        ));
    }
}

//  Get Doctor Filter Attributes
function wen_doctor_filter_attributes() {

    //  Return Attributes
    return apply_filters('wen_doctor_attributes', array(
        'name' => array(
            'label' => 'Name',
            'type' => 'internal',
            'match_type' => 'like'
        ),
        'interest' => array(
            'label' => 'Interest',
            'type' => 'taxonomy',
            'match_type' => 'equal'
        ),
        'provider_type' => array(
            'label' => 'Provider Type',
            'type' => 'taxonomy',
            'match_type' => 'equal'
        ),
        'location' => array(
            'label' => 'Location',
            'type' => 'taxonomy',
            'match_type' => 'equal'
        )
    ));
}

//  Add After Editor Filter
add_filter('edit_form_after_editor', 'wen_edit_form_after_editor');

//  Callback to Action
function wen_edit_form_after_editor($post) {

    //  Check for Find a Doctor Page
    if($post->post_type == 'page' && $post->post_name == 'find-a-doctor') {
?>
<div id="find-a-doctor-selection" class="postbox">
    <div class="handlediv" title="Click to toggle"<br /></div>
    <h3 class='hndle'><span>Edit Selection Tool</span></h3>
    <div class="inside">
        <ul class="wen-custom-list wen-custom-list-inline">
            <?php

            //  Get Selected
            $selection_tools = (array)get_post_meta($post->ID, '_selection_tools', true);

            //  Attributes Available
            $doctor_attributes = wen_doctor_filter_attributes();

            //  Loop Each Attributes
            foreach($doctor_attributes as $attr_key => $attr_data) {
            ?>
            <li>
                <label>
                    <input type="checkbox" name="selection_tools[]" value="<?php echo $attr_key; ?>" <?php echo (in_array($attr_key, $selection_tools) ? 'checked="checked"' : ''); ?> />
                    <?php echo $attr_data['label']; ?>
                </label>
            </li>
            <?php } ?>
        </ul>
        <div class="clearfix"></div>
    </div>
</div>
<?php
    }

    //  Check for Conditions and Treatments Page
    if($post->post_type == 'page' && $post->post_name == 'conditions-and-treatments') {
?>
<div id="treatments-selection" class="postbox">
    <div class="handlediv" title="Click to toggle"<br /></div>
    <h3 class='hndle'><span>Edit Wizard Tool</span></h3>
    <div class="inside">
        <h2>What makes it hurt?</h2>
        <ul class="wen-custom-list wen-custom-list-inline-rows">
            <?php

            //  Get Selected
            $wizard_tools = get_post_meta($post->ID, '_wizard_tools', true);

            //  Check
            if($wizard_tools && is_array($wizard_tools)) {

                //  Loop Each
                foreach($wizard_tools['title'] as $wI => $wTitle) { ?>
            <li class="ct-item">
                <label>
                    <span class="item-icon">
                        <?php if($wizard_tools['url'][$wI] != '') { ?>
                        <img src="<?php echo $wizard_tools['url'][$wI]; ?>" alt="" />
                        <?php } else { ?>
                        &nbsp;
                        <?php } ?>
                    </span>
                    <span class="item-name"><?php echo $wTitle; ?></span>
                    <a href="#" class="ct-item-delete" title="Delete">X</a>
                </label>
                <input type="hidden" name="wizard_tools[title][]" class="hidden-ct-title" value="<?php echo $wTitle; ?>" />
                <input type="hidden" name="wizard_tools[url][]" class="hidden-ct-url" value="<?php echo $wizard_tools['url'][$wI]; ?>" />
            </li>
                <?php }
            }
            ?>
        </ul>
        <a href="#" class="add-new-ct button-secondary">Add New</a>
    </div>
</div>

<div class="wen-custom-dialog">
    <label>
        Title
        <input type="text" class="ct-title" />
    </label>
    <label>
        URL
        <input type="text" class="ct-url" />
    </label>
    Upload Icon
    <a href="#" class="ct-pick-from-media button-secondary">Pick from Media</a>
    <div class="clearfix"><br/></div>
    <a href="#" class="submit-ct-data button-primary">Save</a>
    <a href="#" class="cancel-ct-data button-secondary">Cancel</a>
</div>
<?php
    }
}

//  Listen Post Save
add_action('save_post', 'wen_save_page_customs', 10, 2);

//  Callback to Action
function wen_save_page_customs($ID, $post) {

    //  Check for Page
    if($post->post_type == 'page') {

        //  Check for Find a Doctor Page
        if($post->ID == wen_get_option('cp_find_a_doctor')) {

            //  Get Meta
            $attributes = (isset($_POST['selection_tools']) ? $_POST['selection_tools'] : array());

            //  Save
            update_post_meta($ID, '_selection_tools', $attributes);
        }

        //  Check for Conditions & Treatments Page
        if($post->ID == wen_get_option('cp_conditions_n_treatments')) {

            //  Get Meta
            $attributes = (isset($_POST['wizard_tools']) ? $_POST['wizard_tools'] : array());

            //  Save
            update_post_meta($ID, '_wizard_tools', $attributes);
        }
    }
    //  Check for Seminar
    else if(in_array($post->post_type, array(POST_TYPE_SEMINAR, POST_TYPE_TUESDAY_CONFERENCE, POST_TYPE_OSM_CONFERENCE))) {

        //  Global
        global $wpdb;

        //  Check if Current Seminar
        if($post->post_type == POST_TYPE_SEMINAR && get_field('set_as_current_seminar', $post->ID)) {

            //  Fix all Other Seminars
            $wpdb->query("UPDATE {$wpdb->prefix}postmeta SET meta_value = '0' WHERE meta_key = 'set_as_current_seminar' AND post_id != {$post->ID}");
        }

        //  Check if Current Tuesday Conference
        if($post->post_type == POST_TYPE_TUESDAY_CONFERENCE && get_field('tc_set_as_current_conference', $post->ID)) {

            //  Fix all Other Seminars
            $wpdb->query("UPDATE {$wpdb->prefix}postmeta SET meta_value = '0' WHERE meta_key = 'tc_set_as_current_conference' AND post_id != {$post->ID}");
        }

        //  Check if Current Tuesday Conference
        if($post->post_type == POST_TYPE_OSM_CONFERENCE && get_field('oc_set_as_current_conference', $post->ID)) {

            //  Fix all Other Seminars
            $wpdb->query("UPDATE {$wpdb->prefix}postmeta SET meta_value = '0' WHERE meta_key = 'oc_set_as_current_conference' AND post_id != {$post->ID}");
        }
    }
}

//  Render the Complex Editing Layout
function wen_cpte_extended_implementation() {

    //  Check Function Exists
    if(function_exists('cpte_register_page')) {

        //  Register the Page
        cpte_register_page('Seminar Page', cpte_post_value('post_name', wen_get_option('cp_seminar')), POST_TYPE_SEMINAR, null, array(

            //  Assign Primary ACF
            'acf_box_id' => 15,

            //  Base Fields
            'base_fields' => array(

                //  Title Field
                'seminar_name' => array(
                    'title' => 'Title',
                    'required' => true,
                    'name' => 'seminar_name',
                    'acf_type' => 'input-wrap',
                    'acf_args' => array(
                        'type' => 'text'
                    )
                ),

                //  Description Field
                'seminar_description' => array(
                    'title' => 'Description',
                    'required' => true,
                    'name' => 'seminar_description',
                    'acf_type' => 'wysiwyg',
                    'acf_args' => array(
                        'type' => 'wysiwyg'
                    )
                )
            )
        ));
    }
}

//  Add Filter to Subpost Submit
//add_filter('cpte_subpost_submit-' . POST_TYPE_SEMINAR, 'wen_seminar_subpost_submit', 10, 3);

//  Callback to Filter
function wen_seminar_subpost_submit($response, $formdata) {

    //  Prepare the Post Data
    $post_data = array(
        'post_title'    => $formdata['seminar_name'],
        'post_content'  => $formdata['seminar_description'],
        'post_status'   => 'publish',
        'post_author'   => get_the_author_meta('ID'),
        'post_type'     => POST_TYPE_SEMINAR
    );

    //  Insert Post to Wordpress
    $postID = wp_insert_post($post_data);

    //  Store ACF Fields
    cpte_store_acf_fields_post($postID, $formdata);

    //  Add the ID to Response
    $response['post_id'] = $postID;

    //  Set Message
    $response['message'] = cpte_success_output("Seminar '{$formdata['seminar_name']}' has been successfully created");

    //  Return
    return $response;
}

//  Listen Post Save
//add_action('save_post', 'wen_save_post', 10, 2);

//  Callback to Action
function wen_save_post($ID, $post) {

    //  Data Map
    $post_types = array(
        POST_TYPE_SEMINAR => 'seminar_title',
        POST_TYPE_TUESDAY_CONFERENCE => 'tc_event_title',
        POST_TYPE_OSM_CONFERENCE => 'oc_event_title'
    );

    //  Check
    if(array_key_exists($post->post_type, $post_types)) {

        //  ACF Index
        $acfIndex = $post_types[$post->post_type];

        //  Get the Title
        $refTitle = get_field($acfIndex);

        //  Remove Action
        remove_action('save_post', 'wen_save_post');

        //  Data to Update
        $post_data = array(
            'ID' => $ID,
            'post_title' => $refTitle
        );

        //  Check
        if(intval($post->post_name) === $post->post_name
                || strtolower($post->post_name) == 'auto draft'
                || strtolower($post->post_name) == 'auto-draft') {

            //  Set
            $post_data['post_name'] = wp_unique_post_slug(sanitize_title($refTitle), $ID, $post->post_status, $post->post_type, $post->post_parent);
        }

        //  Save the Title
        wp_update_post($post_data);
    }
}

//  Add Action to Admin Enqueue Styles
add_action('admin_footer', 'wen_admin_enqueue_styles');

//  Callback to Action
function wen_admin_enqueue_styles() {

    //  Enqueue Admin Styles
    wp_enqueue_style('jquery-select2', get_template_directory_uri() . '/css/select2.css');
    wp_enqueue_style('wen-admin-css', get_template_directory_uri() . '/css/admin.css');

    //  Enqueue Admin Scripts
    wp_enqueue_script('jquery-select2', get_template_directory_uri() . '/js/select2.min.js');
    wp_enqueue_script('wen-admin-js', get_template_directory_uri() . '/js/admin.js', array('jquery'));
}

//  Add Filter to Nav Menu Args
add_filter('wp_nav_menu_args', 'wen_wp_nav_menu_args');

//  Callback to Filter
function wen_wp_nav_menu_args($args) {

    //  Get Global
    global $sidebar_nav_fix;

    //  Check for Fix Callback
    //if(strpos($args['menu_class'], 'skip-dyn-class') === false) {
    if(!is_null($sidebar_nav_fix) && $sidebar_nav_fix == true) {

        //  Update the Menu Class
        $args['menu_class'] .= ' sidebar-nav';
    }

    //  Return Args
    return $args;
}

//  Register Additional Attributes for TinyMCE
add_filter('tiny_mce_before_init', 'wen_filter_tiny_mce_before_init'); 

//  Callback to Filter
function wen_filter_tiny_mce_before_init( $options ) { 
 
    //  Check
    if ( ! isset( $options['extended_valid_elements'] ) ) 
        $options['extended_valid_elements'] = ''; 

    //  Extend
    $options['extended_valid_elements'] .= ',span[contenteditable|class|id|style]'; 

    //  Return
    return $options; 
}

//  Add Filter to WP COntent
add_filter('the_content', 'wen_the_content', 500);

//  Callback to Filter
function wen_the_content($content, $length = null, $force = false) {

    //  Check for Singular Page
    if($force || (!is_singular() && !is_page())) {

        //  Length
        $length || $length = wen_get_option('excerpt_length');

        //  Explode the Words
        $explodes = array_chunk(explode(' ', $content), $length);

        //  Set Content
        $content = implode(' ', array_shift($explodes));
    }

    //  Return
    return $content;
}

//  Add Filter to Body Class
add_filter('body_class', 'wen_body_class');

//  Callback to Filter
function wen_body_class($classes) {

    //  Check for not Home
    if(!is_home() && !is_front_page()) {

        //  Add Class
        $classes[] = 'not-home';
    }

    //  Return
    return $classes;
}

//  Add Ajax Action for Subscription
add_action('wp_ajax_wen-newsletter-subscribe', 'wen_process_newsletter_subscribe');
add_action('wp_ajax_nopriv_wen-newsletter-subscribe', 'wen_process_newsletter_subscribe');

//  Callback to Action
function wen_process_newsletter_subscribe() {

    //  Response
    $response = array('success' => false);

    //  Verify Nonce
    if(wp_verify_nonce(filter_input(INPUT_POST, '_wen_newsletter'), 'wen-newsletter-subscribe')) {

        //  Save the Email
        Newsletter::instance()->save_user(array(
            'email' => filter_input(INPUT_POST, 'email'),
            'status' => 'C',
            'token' => Newsletter::instance()->get_token()
        ));

        //  Set Success
        $response['success'] = true;
    }

    //  Write Response
    header('Content-Type: application/json');
    echo json_encode($response);
    exit;
}

//  Add Action to Append Filters
add_action('restrict_manage_posts', 'wen_restrict_feedbacks');

//  Callback to Action
function wen_restrict_feedbacks() {

    //  Resolve Type
    $type = 'post';
    if (isset($_GET['post_type'])) {
        $type = $_GET['post_type'];
    }

    //only add filter to post type you want
    if (POST_TYPE_FEEDBACK == $type){

        //  Values
        $values = array(
            'Feedback' => 'normal',
            'Doctor Feedback' => 'doctor',
        );
?>
        <select name="admin_feedback_ws_filter" title="Filter Feedback Type">
            <option value=""><?php _e('All Status', TEXT_DOMAIN); ?></option>
            <?php
                $current_v = (isset($_GET['admin_feedback_ws_filter']) ? $_GET['admin_feedback_ws_filter'] : '');
                foreach ($values as $label => $value) {
                    printf
                        (
                            '<option value="%s"%s>%s</option>',
                            $value,
                            $value == $current_v? ' selected="selected"':'',
                            $label
                        );
                    }
            ?>
        </select>
<?php
    }
}

//  Add Action to Apply the Feedbacks Filters
add_filter('parse_query', 'wen_restrict_feedbacks_apply');

//  Callback to Action
function wen_restrict_feedbacks_apply($query) {

    //  Get Page Now
    global $pagenow;
    $type = 'post';
    if (isset($_GET['post_type'])) {
        $type = $_GET['post_type'];
    }

    //  Validate
    if ( POST_TYPE_FEEDBACK == $type && is_admin() && $pagenow=='edit.php' && isset($_GET['admin_feedback_ws_filter']) && $_GET['admin_feedback_ws_filter'] != '') {
        //$query->query_vars['post_type'] = POST_TYPE_FEEDBACK;
        $query->query_vars['meta_key'] = 'feedback_type';
        $query->query_vars['meta_value'] = $_GET['admin_feedback_ws_filter'];
    }
}

//  Add Action to Contact Form 7 Before Mail Send
add_action('wpcf7_before_send_mail', 'wen_wpcf7_before_send_mail');

//  Callback to Action
function wen_wpcf7_before_send_mail($cf7) {

    //  Get the contact form object
    //$wpcf7 = WPCF7_ContactForm::get_current();

    //  Submission
    //$cfSubmission = WPCF7_Submission::get_instance();

    //  Set No Mail Send
    //$cfSubmission->skip_mail = true;

    //  For Debug
    echo '<pre/>';var_dump($cf7);exit;

    //  Check for Feedback Form
    if($cf7->id == wen_get_option('cf7_feedback')) {

        //  Get Properties
        $properties = $cf7->get_properties();

        //  Add Thank You Page Redirect
        $properties['additional_settings'] .= ($properties['additional_settings'] != '' ? PHP_EOL : '') . "on_sent_ok: \"location = '" . get_permalink(cpte_post_value('ID', 'feedback-response')) . "';\"";

        //  Set Properties
        $cf7->set_properties($properties);

        //  Post Data
        $postdata = array(
            'post_title' => 'Feedback ' . date('Ymd.Hi'),
            'post_type' => POST_TYPE_FEEDBACK,
            'post_status' => 'publish'
        );

        //  Create the Post
        $postID = wp_insert_post($postdata);

        //  Save ACF Fields
        update_field('feedback_type', 'normal', $postID);
        update_field('experience_at_tria', filter_input(INPUT_POST, 'experience_at_tria'), $postID);
        update_field('recommend_a_family', filter_input(INPUT_POST, 'recommend_a_family'), $postID);
        update_field('did_you_find', filter_input(INPUT_POST, 'did_you_find'), $postID);
        update_field('story_permission', (isset($_POST['story_permission'])), $postID);
        update_field('response_required', (isset($_POST['response_required'])), $postID);
        update_field('phone_email', filter_input(INPUT_POST, 'phone_email'), $postID);
        update_field('story', filter_input(INPUT_POST, 'your-message'), $postID);
    }

    //  Check for Doctor Feedback Form
    if($cf7->id == wen_get_option('cf7_doctor_feedback')) {

        //  Doctor ID
        $doctor_id = filter_input(INPUT_POST, 'ID');

        //  Post Data
        $postdata = array(
            'post_title' => 'Doctor Feedback ' . date('Ymd.Hi'),
            'post_type' => POST_TYPE_FEEDBACK,
            'post_status' => 'publish'
        );

        //  Create the Post
        $postID = wp_insert_post($postdata);

        //  Save ACF Fields
        update_field('feedback_type', 'doctor', $postID);
        update_field('doctor', $doctor_id, $postID);
        update_field('story', filter_input(INPUT_POST, 'your-message'), $postID);
    }
}

//  Add Filter to Remove Private Prefix
add_filter('private_title_format', 'wen_remove_private_prefix_from_title');

//  Callback to Filter
function wen_remove_private_prefix_from_title($title) {
    return '%s';
}
