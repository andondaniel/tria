<?php

/*  Initialize the meta boxes.
/* ------------------------------------ */
add_action( 'admin_init', '_custom_meta_boxes' );

function _custom_meta_boxes() {

  $flag_apply_meta_boxes = apply_filters('wen_filter_meta_boxes', true );
  if ( true != $flag_apply_meta_boxes ) {
    return false;
  }

  /*  Custom meta boxes
  /* ------------------------------------ */
  $page_options = array(
    'id'          => 'page-options',
    'title'       => 'Page Options',
    'desc'        => '<i><strong>All fields are optional</strong></i>',
    'pages'       => array( 'page' ),
    'context'     => 'normal',
    'priority'    => 'high',
    'fields'      => array(

      '_sidebar_1' => array(
        'label' => 'Primary Sidebar',
        'id'    => '_sidebar_1',
        'type'  => 'sidebar-select',
        'desc'  => 'Choose sidebar'
      ),


    )
  );
  $page_options['fields'] = apply_filters('wen_filter_page_metabox_fields', $page_options['fields'] );

  /*  Register meta boxes
  /* ------------------------------------ */
  ot_register_meta_box( $page_options );

}
