<?php

//  Enqueue Scripts
add_action('admin_enqueue_scripts', 'cpte_admin_enqueue_scripts');

//  Callback to Action
function cpte_admin_enqueue_scripts() {

    //  Enqueue jQuery UI CSS
    //wp_enqueue_style('jquery-ui-full', PLUGIN_CPTE_ASSETS_CSS_URI . 'jquery-ui.min.css');

    //  Enqueue Custom Style
    wp_enqueue_style('cpte-custom', PLUGIN_CPTE_ASSETS_CSS_URI . 'cpt-extended.css');

    //  Enqueue Custom Script
    wp_enqueue_script('cpte-custom', PLUGIN_CPTE_ASSETS_JS_URI . 'cpt-extended.js', array('jquery', 'jquery-ui-accordion'));
    wp_localize_script('cpte-custom', 'CPTE_OBJECT', array(
        'admin_url' => admin_url(),
        'ajax_url' => admin_url('admin-ajax.php'),
    ));
}

//  Add Action to Admin Menu
add_action('admin_menu', 'cpte_register_page_menus', 500);

//  Callback to Action
function cpte_register_page_menus() {

    //  Get Global
    global $cpte_mapper, $cpte_registered;

    //  Store URLs
    $edit_urls = array();

    //  Loop Each
    foreach($cpte_registered as $settings) {

        //  Get the Page
        $page = $settings['page'];

        //  Check
        if($page) {

            //  Keys
            $thisSlug = 'cpte-page_' . $settings['slug'];
            $thisEditUrl = 'post.php?post=' . $page->ID . '&action=edit#tpage=' . $thisSlug;

            //  Store
            $edit_urls[$thisSlug] = $thisEditUrl;

            //  Store Mapper
            $cpte_mapper[$page->ID] = $settings['slug'];

            //  Create the Admin Menu
            add_menu_page($settings['title'], $settings['title'], $settings['capability'], $thisSlug, $thisEditUrl, $settings['icon'], 25);
        }
    }

    //  Get Global Menu Holder
    global $menu, $_parent_pages, $admin_page_hooks;

    //  Loop Each
    foreach($edit_urls as $slug => $url) {

        //  Check
        if(isset($_parent_pages[$slug])) {

            //  Set for Parent Pages
            $_parent_pages[$slug] = $url;

            //  Set for Admin Page Hooks
            $admin_page_hooks[$slug] = $url;

            //  Loop Menu
            foreach($menu as $mIndex => $mData) {

                //  Check
                if($mData[2] == $slug) {

                    //  Set
                    $menu[$mIndex][2] = $url;

                    //  Break
                    break;
                }
            }
        }
    }
}

//  Add Filter
add_filter('gettext', 'cpte_filter_gettext', 5000, 3);

//  Get Text Filter
function cpte_filter_gettext($translated_text, $untranslated_text) {

    //  Get PageNow
    global $pagenow, $cpte_registered;

    //  Check
    if($pagenow == 'post.php' && isset($_GET['post'])) {

        //  Page ID
        $pageID = intval($_GET['post']);

        //  Check for 'Edit Page' Text
        if($untranslated_text == 'Edit Page' && $pageID > 0 && isset($cpte_registered[$pageID])) {

            //  Get Settings
            $settings = $cpte_registered[$pageID];

            //  Set
            $translated_text = $settings['title'];
        }
    }

    //  Return
    return $translated_text;
}

//  Add Hook to Post Top
add_action('edit_form_after_editor', 'cpte_edit_form_after_editor');

//  Callback to Action
function cpte_edit_form_after_editor($post) {

    //  Validate Post Type
    if(in_array($post->post_type, array('page'))) {

        //  Get Global
        global $cpte_registered;

        //  Get the Settings
        $settings = (isset($cpte_registered[$post->ID]) ? $cpte_registered[$post->ID] : null);

        //  Check
        if($settings) {

            //  Post Type Object
            $posttype_object = $settings['pobject'];

            //  Check for Display Add Form
            if($settings['add_form'] && $settings['base_fields'] && sizeof($settings['base_fields']) > 0) {
?>
<a name="inline-form"></a>
<div id="inline-add-post" class="postbox acf_postbox">
    <div class="handlediv" title="Click to toggle"> <br /></div>
    <h3 class="hndle"><span><?php echo $posttype_object->labels->add_new_item; ?></span></h3>
    <div class="inside">
        <div class="cpte-messages-panel"></div>
        <?php foreach($settings['base_fields'] as $field_name => $base_field) {

            //  Fix Data Array
            $base_field = array_merge(array(
                'type' => 'input',
                'class' => '',
                'attrs' => '',
                'has_interface' => true
            ), $base_field);

            //  Check for Interface
            if(!$base_field['has_interface'])    continue;
        ?>
        <?php if($base_field['type'] == 'input') { ?>
        <div class="field <?php echo (@$base_field['required'] ? 'required-field' : ''); ?>">
            <p class="label">
                <label>
                    <?php echo $base_field['title']; ?> 
                    <?php if(@$base_field['required']) { ?>
                    <span class="required">*</span>
                    <?php } ?>
                </label>
            </p>
            <div class="acf-<?php echo $base_field['acf_type']; ?> <?php echo @$base_field['class']; ?>" <?php echo @$base_field['attrs']; ?>>
                <?php if(isset($base_field['acf_args'])) { ?>
                    <?php create_field(array_merge(array('name' => $field_name), $base_field['acf_args'])); ?>
                <?php } else { ?>
                    <?php echo ($base_field['contents'] instanceof \Closure ? call_user_func_array($base_field['contents'], array($base_field)) : $base_field['contents']); ?>
                <?php } ?>
            </div>
            <div class="clear"></div>
        </div>
        <div class="clear"></div>
        <?php } else if($base_field['type'] == 'hr') { ?>
        <hr/>
        <?php } ?>
        <?php } ?>

        <?php

            //  Check
            if(!is_null($settings['acf_box_id'])) {

                //  Create the Temporary Post
                $tmp_post = get_default_post_to_edit($settings['post_type']);

                //  Generate the Args to Create the Metabox
                $args = cpte_generate_acf_hook_args($settings['acf_box_id'], $tmp_post->ID);

                //  Get the Fields
                $fields = apply_filters('acf/field_group/get_fields', array(), $args['field_group']['id']);

                //  Print the Box
                do_action('acf/create_fields', $fields, $args['post_id']);
            }
        ?>

        <div class="field field-submit">
            <p class="label">&nbsp;</p>
            <div>
                <button type="submit" name="submit-post-ajax" class="button-primary ajax-add-subpost"><?php echo $posttype_object->labels->add_new_item; ?></button>
                <button class="button-secondary clear-inline-subpost">Clear</button>
            </div>
        </div>
    </div>

    <div class="cpte-hidden-fields">
        <input type="hidden" name="page_id" value="<?php echo $post->ID; ?>" />
        <input type="hidden" name="page_slug" value="<?php echo $settings['slug']; ?>" />
        <input type="hidden" name="page_post_type" value="<?php echo $settings['post_type']; ?>" />
    </div>
</div>
<?php
            }

            //  Check for Display Archives List
            if($settings['archives_list']) {
?>
<a name="inline-archives"></a>
<div id="inline-archives-holder">
<?php
            //  Get Yearly Archives
            $archives = cpte_get_archives($settings['post_type']);

            //  Check
            if(sizeof($archives) > 0) {

                //  Loop Each
                foreach($archives as $archive) {

                    //  Get Monthly Archives
                    $mArchives = cpte_get_archives($settings['post_type'], array('type' => 'monthly'));
?>
    <h3><?php echo strip_tags($archive) . ' ' . $posttype_object->labels->name; ?></h3>
    <div>
        <p>Loading <?php echo $posttype_object->labels->name; ?>...</p>
    </div>
<?php
                }
            }
?>
</div>
<div class="clearfix"><br/></div>
<?php
            }
        }
    }
}

//  Add AJAX Filter
add_filter('wp_ajax_cpte-subpost-submit', 'cpte_subpost_ajax_submit');

//  Callback to Filter
function cpte_subpost_ajax_submit() {

    //  Get the Details
    $pageID = @$_POST['page_id'];
    $page_slug = @$_POST['page_slug'];
    $page_post_type = @$_POST['page_post_type'];

    //  Get Form Data
    $formdata = @$_POST['form_data'];

    //  Response
    $response = array(
        'success' => ($page_slug && $pageID && $page_post_type && sizeof($formdata) > 0 ? true : false)
    );

    //  Set Message
    $response['message'] = ($response['success'] ? cpte_success_output('Data successfully submitted to database') : cpte_errors_output('Error with data sent'));

    //  Check
    if($response['success']) {

        //  Get the Global
        global $cpte_registered;

        //  Check
        if(isset($cpte_registered[$pageID])) {

            //  Get Settings
            $settings = $cpte_registered[$pageID];

            //  Check
            if($response['success']) {

                //  Run the Validation
                $response = apply_filters('cpte_subpost_submit_validate', $response, $formdata, $settings, $page_post_type, $page_slug);
            }

            //  Check
            if($response['success']) {

                //  Run the Create Filter
                $response = apply_filters('cpte_subpost_submit-' . $page_post_type, $response, $formdata, $settings, $page_slug);
            }
        }
    }

    //  Create Response
    header('Content-Type: application/json');
    echo json_encode($response);
    exit;
}

//  Add the Validation Filter
add_filter('cpte_subpost_submit_validate', 'cpte_do_subpost_submit_validate', 10, 3);

//  Callback to Filter
function cpte_do_subpost_submit_validate($response, $formdata, $settings) {

    //  Errors
    $errors = array();

    //  Loop Each Form Data
    foreach($formdata as $fKey => $fVal) {

        //  Get the Field Setting
        $bFieldSet = array_merge(array(
            'required' => false,
            'required_error' => 'this field is required',
            'match' => null,
            'match_error' => null
        ), $settings['base_fields'][$fKey]);

        //  Check Required
        if($bFieldSet && isset($bFieldSet['required'])) {

            //  Check for Empty
            if(empty($fVal) && isset($bFieldSet['required']) && $bFieldSet['required']) {

                //  Add Error
                $errors[] = '<strong>' . $bFieldSet['title'] . ':</strong> ' . $bFieldSet['required_error'];
            }

            //  Check for Match Error
            if(!empty($fVal) && isset($bFieldSet['match']) && !is_null($bFieldSet['match'])) {

                //  Try to Match
                if(!preg_match($bFieldSet['match'], $fVal)) {

                    //  Add Error
                    $errors[] = '<strong>' . $bFieldSet['title'] . ':</strong> ' . (!is_null($bFieldSet['match_error']) ? $bFieldSet['match_error'] : 'didnot match regex <em><strong>' . $bFieldSet['match'] . '</strong></em>');
                }
            }
        }
    }

    //  Check for Errors
    if(sizeof($errors) > 0) {

        //  Set Error
        $response['success'] = false;
        $response['message'] = cpte_errors_output($errors);
        $response['message_array'] = $errors;
    }

    //  Return
    return $response;
}

//  Add Action to Admin Footer
add_action('admin_footer', 'cpte_admin_footer');

//  Callback to Action
function cpte_admin_footer() {

    //  Get Global
    global $pagenow, $cpte_mapper;

    //  Check
    if($pagenow != 'post.php')  return;

    //  Get Page ID
    $pageID = intval($_GET['post']);

    //  Check for Page Data Exists
    if(!isset($cpte_mapper[$pageID]))   return;

    //  Prepare the Slug
    $theSlug = 'cpte-page_' . $cpte_mapper[$pageID];
?>
<script>
window.top.location.hash = '#tpage=<?php echo $theSlug; ?>';
</script>
<?php
}

//  Add Filter to Get Archive
add_filter('getarchives_where', 'cpte_getarchives_where_filter', 10, 2);

//  Callback to Filter
function cpte_getarchives_where_filter($where, $r) {

    //  Post Types
    $post_types = array(isset($r['post_type']) && !is_null($r['post_type']) ? $r['post_type'] : $r['post_type']);
    $post_types = "'" . implode("' , '", $post_types) . "'";

    //  Return Query Replacement
    return str_replace("post_type = 'post'", "post_type IN ( $post_types )", $where);
}

//  Add Hook to Post After Title
add_action('edit_form_after_title', 'cpte_edit_form_after_title');

//  Callback to Action
function cpte_edit_form_after_title($post) {

    //  Get Global
    global $cpte_registered2;

    //  Check for Post Type
    if(isset($cpte_registered2[$post->post_type])) {

        //  Get the Settings
        $settings = $cpte_registered2[$post->post_type];

        //  Get Main Page
        $theMainPage = $settings['page'];
?>
<div id="titlediv">
    <div id="titlewrap">
        <label class="screen-reader-text">Enter title here</label>
        <input type="text" name="parent_post_title" size="30" class="dup-title" value="<?php echo $theMainPage->post_title; ?>" autocomplete="off" />
    </div>
</div>
<?php

        //  Get the ACFs
        $acfsIDs = array_unique(array_merge(
            resolve_acf_box_posts('acf_after_title', 'page')
        ));

        //  Check
        if($acfsIDs) {

            //  Loop Each
            foreach($acfsIDs as $acfID) {

                //  Generate the Args to Create the Metabox
                $args = cpte_generate_acf_hook_args($acfID, $theMainPage->ID);

                //  Get the Fields
                $fields = apply_filters('acf/field_group/get_fields', array(), $args['field_group']['id']);

                //  Print the Box
                do_action('acf/create_fields', $fields, $args['post_id']);

                //  Add Break
                echo '<div class="clearfix"><br/></div>';
            }
        }
?>
<div id="postdivrich" class="postarea edit-form-section">
    <?php wp_editor( $theMainPage->post_content, 'parent_post_content', array(
            'dfw' => true,
            'drag_drop_upload' => true,
            'tabfocus_elements' => 'insert-media-button,save-post',
            'editor_height' => 220,
            'tinymce' => array(
                'resize' => true,
                'add_unload_trigger' => false
            ),
    ) ); ?>
</div>
<?php
    }
}

//  Add Hook to Post After Editor
add_action('edit_form_after_editor', 'cpte_edit_form_after_editor_page');

//  Callback to Action
function cpte_edit_form_after_editor_page($post) {

    //  Get Global
    global $cpte_registered2;

    //  Check for Post Type
    if(isset($cpte_registered2[$post->post_type])) {

        //  Get the Settings
        $settings = $cpte_registered2[$post->post_type];

        //  Check Requested
        if($settings['show_slug_field']) {
?>
<div id="edit-slug-box" class="hide-if-no-js">
    <?php echo get_sample_permalink_html($post->ID); ?>
</div>
<div class="clearfix"><br/></div>
<?php

            //  Add Nonce Field
            wp_nonce_field('samplepermalink', 'samplepermalinknonce', false);
        }

        //  Check Requested
        if(sizeof($settings['hook_acf_fields']) < 1)   return;

        //  Get the Hook Fields
        $hook_fields = $settings['hook_acf_fields'];
?>
<script>HOOK_PAGE_FIELDS = <?php echo json_encode($hook_fields); ?></script>
<?php
    }
}

//  Listen Post Save
add_action('save_post', 'cpte_save_post', 10, 2);

//  Callback to Action
function cpte_save_post($ID, $post) {

    //  Get Global
    global $cpte_registered2;

    //  Check for Post Type
    if(isset($cpte_registered2[$post->post_type])) {

        //  Remove Action
        remove_action('save_post', 'cpte_save_post');

        //  Get the Settings
        $settings = $cpte_registered2[$post->post_type];

        //  Parent Page
        $theMainPage = $settings['page'];

        //  Data to Update
        $post_data = array(
            'ID' => $theMainPage->ID,
            'post_title' => filter_input(INPUT_POST, 'parent_post_title'),
            'post_content' => filter_input(INPUT_POST, 'parent_post_content')
        );

        //  Update the Post
        wp_update_post($post_data);

        //  Check for Hidden Post Description
        if(filter_input(INPUT_POST, 'hidden_post_content')) {

            //  Main Post Data to Update
            $mpost_data = array(
                'ID' => $ID,
                'post_content' => filter_input(INPUT_POST, 'hidden_post_content')
            );

            //  Update the Post
            wp_update_post($mpost_data);
        }
    }
}

//  Add Filter to Admin Comment Types Dropdown
add_filter('admin_comment_types_dropdown', 'cpte_admin_comment_types_dropdown');

//  Callback to Filter
function cpte_admin_comment_types_dropdown($types) {

    //  Get Global
    global $cpte_comment_types;

    //  Loop Each
    foreach($cpte_comment_types as $comment_type => $cSettings) {

        //  Store
        $types[$comment_type] = $cSettings['label_plural'];
    }

    //  Return
    return $types;
}

//  Add Filter to Comment Status Links
//add_filter('manage_edit-comments_columns', 'cpte_manage_comments_columns');

//  Callback to Filter
function cpte_manage_comments_columns() {

    //  Get Global
    global $cpte_comment_types;

    echo '<pre/>';var_dump(func_get_args());exit;

    //  Loop Each
    foreach($cpte_comment_types as $comment_type => $cSettings) {

        //  Store
        $links['ctype-' . $comment_type] = admin_url('edit-comments.php?comment_type');
    }

    //  Return
    return $links;
}

//  Add Filter to Customize the Post Messages
add_filter('post_updated_messages', 'cpte_post_updated_messages');

//  Callback to Filter
function cpte_post_updated_messages( $messages ) {

    //  Get Global
    global $cpte_post_messages;

    //  Get the Post
    $post = get_post();

    //  Get Post Type
    $post_type = get_post_type($post);

    //  Get Post Type Object
    $post_type_object = get_post_type_object($post_type);

    //  Check
    if(in_array($post_type, $cpte_post_messages)) {

        //  Singular Name
        $singular_name = $post_type_object->labels->singular_name;

        //  Setup Messages
        $messages[$post_type] = array(
            0 => '', // Unused. Messages start at index 1.
            1 => __($singular_name . ' updated.', CURRENT_THEME_TEXT_DOMAIN),
            2 => __('Custom field updated.', CURRENT_THEME_TEXT_DOMAIN),
            3 => __('Custom field deleted.', CURRENT_THEME_TEXT_DOMAIN),
            4 => __($singular_name . ' updated.', CURRENT_THEME_TEXT_DOMAIN),
            /* translators: %s: date and time of the revision */
            5 => isset($_GET['revision']) ? sprintf(__($singular_name . ' restored to revision from %s', CURRENT_THEME_TEXT_DOMAIN), wp_post_revision_title((int) $_GET['revision'], false)) : false,
            6 => __($singular_name . ' published.', CURRENT_THEME_TEXT_DOMAIN),
            7 => __($singular_name . ' saved.', CURRENT_THEME_TEXT_DOMAIN),
            8 => __($singular_name . ' submitted.', CURRENT_THEME_TEXT_DOMAIN),
            9 => sprintf(
                    __($singular_name . ' scheduled for: <strong>%1$s</strong>.', CURRENT_THEME_TEXT_DOMAIN),
                    // translators: Publish box date format, see http://php.net/date
                    date_i18n(__('M j, Y @ G:i', CURRENT_THEME_TEXT_DOMAIN), strtotime($post->post_date))
            ),
            10 => __($singular_name . ' draft updated.', CURRENT_THEME_TEXT_DOMAIN)
        );

        //  Check if Public
        if ($post_type_object->publicly_queryable) {

            //  Get Permalink
            $permalink = get_permalink($post->ID);

            //  Create View Link
            $view_link = sprintf(' <a href="%s">%s</a>', esc_url($permalink), __('View ' . strtolower($singular_name), CURRENT_THEME_TEXT_DOMAIN));
            $messages[$post_type][1] .= $view_link;
            $messages[$post_type][6] .= $view_link;
            $messages[$post_type][9] .= $view_link;

            //  Create Preview Link
            $preview_permalink = add_query_arg('preview', 'true', $permalink);
            $preview_link = sprintf(' <a target="_blank" href="%s">%s</a>', esc_url($preview_permalink), __('Preview ' . strtolower($singular_name), CURRENT_THEME_TEXT_DOMAIN));
            $messages[$post_type][8] .= $preview_link;
            $messages[$post_type][10] .= $preview_link;
        }

        //  Run the Filter
        $messages[$post_type] = apply_filters('cpte_post_updated_messages-' . $post_type, $messages[$post_type]);
    }

    //  Return Messages
    return $messages;
}