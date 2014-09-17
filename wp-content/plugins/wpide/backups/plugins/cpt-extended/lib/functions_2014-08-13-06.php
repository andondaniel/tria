<?php /* start WPide restore code */
                                    if ($_POST["restorewpnonce"] === "3c0115f1dca89705a0fd09005f29c36a11bf4b235f"){
                                        if ( file_put_contents ( "/home/bpdcom/public_html/wp/tria/wp-content/plugins/cpt-extended/lib/functions.php" ,  preg_replace("#<\?php /\* start WPide(.*)end WPide restore code \*/ \?>#s", "", file_get_contents("/home/bpdcom/public_html/wp/tria/wp-content/plugins/wpide/backups/plugins/cpt-extended/lib/functions_2014-08-13-06.php") )  ) ){
                                            echo "Your file has been restored, overwritting the recently edited file! \n\n The active editor still contains the broken or unwanted code. If you no longer need that content then close the tab and start fresh with the restored file.";
                                        }
                                    }else{
                                        echo "-1";
                                    }
                                    die();
                            /* end WPide restore code */ ?><?php

//  Global Holder
global $cpte_mapper, $cpte_registered,
        $cpte_mapper2, $cpte_registered2,
        $cpte_comment_types, $cpte_post_cache,
        $cpte_post_messages;
if(!$cpte_mapper) $cpte_mapper = array();
if(!$cpte_registered) $cpte_registered = array();
if(!$cpte_mapper2) $cpte_mapper2 = array();
if(!$cpte_registered2) $cpte_registered2 = array();
if(!$cpte_comment_types) $cpte_comment_types = array();
if(!$cpte_post_cache) $cpte_post_cache = array();
if(!$cpte_post_messages) $cpte_post_messages = array();


//  Register the Page
function cpte_register_page($title, $slug, $post_type, $icon = null, $opts = array()) {

    //  Get Global
    global $cpte_registered;

    //  Page
    $page = cpte_get_post($slug);

    //  Get the Post Type Object
    $pObject = get_post_type_object($post_type);

    //  Check
    if($page && $pObject) {

        //  Store
        $cpte_registered[$page->ID] = array_merge(array(
            'title' => $title,
            'slug' => $slug,
            'post_type' => $post_type,
            'icon' => $icon,
            'archives_list' => false,
            'add_form' => true,
            'base_fields' => null,
            'capability' => 'edit_pages',
            'page' => $page,
            'pobject' => $pObject,
            'acf_box_id' => null
        ), $opts);
    }
}

//  Register the Page to Custom Post Type
function cpte_register_page_to_post_type($slug, $post_type, $show_slug_field = true, $opts = array()) {

    //  Get Global
    global $cpte_registered2;

    //  Get the Page
    $page = cpte_get_post($slug, 'page');

    //  Get the Post Type Object
    $pObject = get_post_type_object($post_type);

    //  Check
    if($page && $pObject) {

        //  Store
        $cpte_registered2[$post_type] = array_merge(array(
            'slug' => $slug,
            'post_type' => $post_type,
            'show_slug_field' => $show_slug_field,
            'hook_acf_fields' => array(),
            'page' => $page,
            'pobject' => $pObject
        ), $opts);
    }
}

//  Store the ACF Fields Only from Postdata
function cpte_store_acf_fields_post($postID, $formdata) {

    //  Check
    if(isset($formdata['acf_fields'])) {

        //  Loop Each Acf Fields
        foreach($formdata['acf_fields'] as $field_name => $field_key) {

            //  Save
            update_field($field_name, $formdata[$field_name], $postID);
        }
    }
}

//  Generate Args for ACF Hook
function cpte_generate_acf_hook_args($box_id, $post_id) {

    //  Get Post
    $acfPost = get_post($box_id);

    //  Args
    $args = array(
        "field_group" => array(
            "id" => $box_id,
            "title" => get_the_title($acfPost),
            "menu_order" => 0,
            "options" => array(
                "position" => get_post_meta($box_id, 'position', true),
                "layout" => get_post_meta($box_id, 'layout', true),
                "hide_on_screen" => get_post_meta($box_id, 'hide_on_screen', true)
            )
        ),
        "show" => 0,
        "post_id" => $post_id
    );

    //  Return
    return $args;
}

//  Create the Success Output
function cpte_success_output($success) {

    //  Return
    return '<div id="cpte-success" class="updated"><p>' . implode('</p><p>', (array)$success) . '</p></div>';
}

//  Create the Error Output
function cpte_errors_output($errors) {

    //  Return
    return '<div id="cpte-errors" class="error"><p>' . implode('</p><p>', (array)$errors) . '</p></div>';
}

//  Get Archives
function cpte_get_archives($post_type = null, $args = array()) {

    //  Prepare Args
    $theArgs = array_merge(array(
        'echo' => false,
        'post_type' => $post_type,
        'type' => 'yearly',
        'format' => 'custom',
        'before' => '',
        'after' => '[SEP]',
        'array_list' => true
    ), $args);

    //  Get Archives
    $output = wp_get_archives($theArgs);

    //  Check
    if($theArgs['array_list']) {

        //  Explode & Filter
        $output = array_filter(explode($theArgs['after'], $output), 'cpt_filter_array');
    }

    //  Return
    return $output;
}

//  Filter the Empty Array
function cpt_filter_array($val) {
    return (trim($val) != '');
}

//  Get the Post
function cpte_get_post($slug, $type = 'page') {

    //  Get Posts
    $posts = get_posts(array(
        'name' => $slug,
        'post_type' => $type,
        'post_status' => 'publish',
        'numberposts' => 1
    ));

    //  Post
    $post = null;

    //  Check
    if(sizeof($posts) > 0) {

        //  Get Post
        $post = array_pop($posts);
    }

    //  Return
    return $post;
}

//  Get the Post ID from Slug
function cpte_get_post_id($slug, $type = 'page') {

    //  Get Post
    $post = cpte_get_post($slug, $type);

    //  Check
    if($post)   return $post->ID;
    return null;
}

//  Get the ACF for Desired Location
function resolve_acf_box_posts($location, $rule_to_match) {

    //  Rule to Match
    if(!is_array($rule_to_match)) {

        //  Create the Rule to Match
        $rule_to_match = array(
            'param' => 'post_type',
            'operator' => '==',
            'value' => $rule_to_match
        );
    }

    //  Global
    global $wpdb;

    //  Get the Post IDs
    $found_rows = $wpdb->get_results("SELECT id from {$wpdb->prefix}posts WHERE post_type = 'acf'");

    //  The IDs
    $theIDs = array();

    //  Loop Each
    foreach($found_rows as $theRow) {

        //  Add the ID
        $theIDs[] = $theRow->id;
    }

    //  Found ACF
    $foundACFs = array();

    //  Check
    if($theIDs) {

        // vars
        $defaults = array(
            'post_id' => 0,
            'post_type' => 0,
            'page_template' => 0,
            'page_parent' => 0,
            'page_type' => 0,
            'post_category' => array(),
            'post_format' => 0,
            'taxonomy' => array(),
            'ef_taxonomy' => 0,
            'ef_user' => 0,
            'ef_media' => 0,
            'lang' => 0,
            'ajax' => false
        );

        //  Read the Metas
        $found_rows2 = $wpdb->get_results("SELECT post_id FROM {$wpdb->prefix}postmeta WHERE post_id IN (" . implode(', ', $theIDs) . ") AND meta_key = 'position' AND meta_value = '{$location}'");

        //  Loop Each
        foreach($found_rows2 as $theRow2) {

            //  Get the Rule
            $rules = get_post_meta($theRow2->post_id, 'rule');

            //  Options
            $options = array_merge($defaults, array(
                'post_id' => $theRow2->post_id,
                'post_type' => 'page'
            ));

            //  Matched
            $matched = true;

            //  Loop Each Rules
            foreach($rules as $rule) {

                //  Matches
                //$match = apply_filters( 'acf/location/rule_match/' . $rule['param'] , false, $rule, $options );

                //  Check
                //if(!$match) {

                    //  Set
                    //$matched = false;
                    //break;
                //}

                //  Unset the Order & Group
                unset($rule['order_no']);
                unset($rule['group_no']);

                //  Match the Rule
                if($rule_to_match === $rule) {

                    //  Add the ACF
                    $foundACFs[] = $theRow2->post_id;
                    break;
                }
            }
        }
    }

    //  Return
    return $foundACFs;
}

//  Register Custom Post Type Helper
function cpte_register_post_type($type, $labelSingular, $labelPlural, $supports = null, $slug = null, $oArgs = array(), $oLabels = array()) {

    //  Global
    global $cpte_post_messages;

    //  Fix Slug
    $slug || $slug = $type;

    //  Default Support
    $default_support = array('title', 'editor', 'author', 'thumbnail', 'excerpt', 'comments', 'custom-fields');

    //  Fix Supports
    if(is_null($supports))  $supports = $default_support;
    else if(is_string($supports))   $supports = array_merge($default_support, explode(',', $supports));

    //  Custom Post Type Labels
    $labels = apply_filters('cpte_post_labels-' . $type, array_merge(array(
        'name' => _x(ucwords($labelPlural), 'post type general name', CURRENT_THEME_TEXT_DOMAIN),
        'singular_name' => _x(ucwords($labelSingular), 'post type singular name', CURRENT_THEME_CURRENT_THEME_TEXT_DOMAIN),
        'menu_name' => _x(ucwords($labelPlural), 'admin menu', CURRENT_THEME_TEXT_DOMAIN),
        'name_admin_bar' => _x(ucwords($labelSingular), 'add new on admin bar', CURRENT_THEME_TEXT_DOMAIN),
        'add_new' => _x('Add New', $slug, CURRENT_THEME_TEXT_DOMAIN),
        'add_new_item' => __('Add New ' . ucwords($labelSingular), CURRENT_THEME_TEXT_DOMAIN),
        'new_item' => __('New ' . ucwords($labelSingular), CURRENT_THEME_TEXT_DOMAIN),
        'edit_item' => __('Edit ' . ucwords($labelSingular), CURRENT_THEME_TEXT_DOMAIN),
        'view_item' => __('View ' . ucwords($labelSingular), CURRENT_THEME_TEXT_DOMAIN),
        'all_items' => __('All ' . ucwords($labelPlural), CURRENT_THEME_TEXT_DOMAIN),
        'search_items' => __('Search ' . ucwords($labelPlural), CURRENT_THEME_TEXT_DOMAIN),
        'parent_item_colon' => __('Parent ' . ucwords($labelPlural) . ':', CURRENT_THEME_TEXT_DOMAIN),
        'not_found' => __('No ' . strtolower($labelPlural) . ' found.', CURRENT_THEME_TEXT_DOMAIN),
        'not_found_in_trash' => __('No ' . strtolower($labelPlural) . ' found in Trash.', CURRENT_THEME_TEXT_DOMAIN)
    ), $oLabels));

    //  Custom Post Type Args
    $args = apply_filters('cpte_post_args-' . $type, array_merge(array(
        'labels' => $labels,
        'public' => true,
        'publicly_queryable' => true,
        'show_ui' => true,
        'show_in_menu' => true,
        'query_var' => true,
        'rewrite' => array('slug' => $slug),
        'capability_type' => 'post',
        'has_archive' => true,
        'hierarchical' => false,
        'menu_position' => null,
        'supports' => $supports
    ), $oArgs));

    //  Register Custom Post Type
    register_post_type($type, $args);

    //  Add to References
    $cpte_post_messages[] = $type;
}

//  Register Custom Taxonomy Helper
function cpte_register_taxonomy($type, $post_types, $labelSingular, $labelPlural, $slug = null, $hierarchical = true, $oArgs = array(), $oLabels = array()) {

    //  Fix Slug
    $slug || $slug = $type;

    //  Custom Taxonomy Labels
    $labels = apply_filters('cpte_taxonomy_labels-' . $type, array_merge(array(
        'name' => _x(ucwords($labelPlural), 'taxonomy general name', CURRENT_THEME_TEXT_DOMAIN),
        'singular_name' => _x(ucwords($labelSingular), 'taxonomy singular name', CURRENT_THEME_TEXT_DOMAIN),
        'search_items' => __('Search ' . ucwords($labelPlural), CURRENT_THEME_TEXT_DOMAIN),
        'all_items' => __('All ' . ucwords($labelPlural), CURRENT_THEME_TEXT_DOMAIN),
        'parent_item' => __('Parent ' . ucwords($labelSingular), CURRENT_THEME_TEXT_DOMAIN),
        'parent_item_colon' => __('Parent ' . ucwords($labelSingular) . ':', CURRENT_THEME_TEXT_DOMAIN),
        'edit_item' => __('Edit ' . ucwords($labelSingular), CURRENT_THEME_TEXT_DOMAIN),
        'update_item' => __('Update ' . ucwords($labelSingular), CURRENT_THEME_TEXT_DOMAIN),
        'add_new_item' => __('Add New ' . ucwords($labelSingular), CURRENT_THEME_TEXT_DOMAIN),
        'new_item_name' => __('New ' . ucwords($labelSingular) . ' Name', CURRENT_THEME_TEXT_DOMAIN),
        'separate_items_with_commas' => __('Separate ' . strtolower($labelPlural) . ' with commas', CURRENT_THEME_TEXT_DOMAIN),
        'add_or_remove_items' => __('Add or remove ' . strtolower($labelPlural), CURRENT_THEME_TEXT_DOMAIN),
        'choose_from_most_used' => __('Choose from the most used ' . strtolower($labelPlural), CURRENT_THEME_TEXT_DOMAIN),
        'not_found' => __('No ' . strtolower($labelPlural) . ' found.', CURRENT_THEME_TEXT_DOMAIN),
        'menu_name' => __(ucwords($labelPlural), CURRENT_THEME_TEXT_DOMAIN),
    ), $oLabels));

    //  Custom Taxonomy Args
    $args = apply_filters('cpte_taxonomy_args-' . $type, array_merge(array(
        'hierarchical' => $hierarchical,
        'labels' => $labels,
        'show_ui' => true,
        'show_admin_column' => true,
        'update_count_callback' => '_update_post_term_count',
        'query_var' => true,
        'rewrite' => array('slug' => $slug)
    ), $oArgs));

    //  Register Custom Taxonomy
    register_taxonomy($type, (array)$post_types, $args);
}

//  Register Custom Comment Type
function cpte_register_comment_type($type, $labelSingular, $labelPlural, $extra_fields = array(), $post_type = null, $args = array()) {

    //  Get Global
    global $cpte_comment_types;

    //  Store
    $cpte_comment_types[$type] = array_merge(array(
        'label_singular' => $labelSingular,
        'label_plural' => $labelPlural,
        'post_type' => $post_type,
        'extra_fields' => $extra_fields
    ), $args);
}

//  Get Post Value
function cpte_post_value($key, $id = null, $use_cache = true, $single = true) {

    //  Check for String
    if(is_string($id) && intval($id) == 0 && !empty($id)) {

        //  Get the ID
        $id = cpte_get_post_id($id);
    }

    //  Fix the ID
    $id || $id = get_the_ID();

    //  Cache
    global $cpte_post_cache;

    //  Value
    $value = null;

    //  Search in Cache
    if($use_cache) {

        //  Check Post Loaded
        if(isset($cpte_post_cache[$id])) {

            //  Get the Post
            $cache_post = $cpte_post_cache[$id];

            //  Check Key Exists
            if(isset($cache_post->{$key})) {

                //  Get Value
                $value = $cache_post->{$key};
            }
        }

        //  Check Value
        if(is_null($value)) {

            //  Check for Attributes Loaded
            if(isset($cpte_post_cache[$id . '_metas'])) {

                //  Get Metas
                $cache_metas = $cpte_post_cache[$id . '_metas'];

                //  Check Key Exists
                if(isset($cache_metas[$key])) {

                    //  Get Value
                    $value = $cache_metas[$key];
                }
            }
        }
    }

    //  Check Value
    if(is_null($value)) {

        //  Get the Post
        $the_post = get_post($id);

        //  Check
        if($the_post) {

            //  Metas
            $the_metas = (isset($cpte_post_cache[$id . '_metas']) ? $cpte_post_cache[$id . '_metas'] : array());

            //  Check for Key
            if(isset($the_post->{$key})) {

                //  Get Value
                $value = $the_post->{$key};
            } else {

                //  Get the Meta
                $meta_value = get_post_meta($id, $key, $single);

                //  Check
                if($meta_value) {

                    //  Get Value
                    $value = $meta_value;

                    //  Store in Cache
                    $the_metas[$key] = $value;
                }
            }

            //  Store the Post Cache
            $cpte_post_cache[$id] = $the_post;

            //  Store the Post Meta Cache
            $cpte_post_cache[$id . '_metas'] = $the_metas;
        }
    }

    //  Return
    return $value;
}