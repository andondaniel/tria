<?php
return $custom_settings = array(
    'contextual_help' => array(
      'content'       => array(
        array(
          'id'        => 'general_help',
          'title'     => 'General',
          'content'   => '<p>This is a simple theme framework developed by <strong>Web Experts Nepal Pvt. Ltd.</strong></p>'
        )
      ),
      'sidebar'       => '<p>Web Experts Nepal Pvt. Ltd.</p>',
    ),
    'sections'        => array(
      'general' => array(
        'id'          => 'general',
        'title'       => __( 'General', 'text-domain' )
      ),
      'social' => array(
        'id'          => 'social',
        'title'       => __( 'Social', 'text-domain' )
      ),
      'sidebar' => array(
        'id'          => 'sidebar',
        'title'       => __( 'Sidebar', 'text-domain' )
      ),
      'footer' => array(
        'id'          => 'footer',
        'title'       => __( 'Footer', 'text-domain' )
      ),
      'blog' => array(
        'id'          => 'blog',
        'title'       => __( 'Blog', 'text-domain' )
      ),
      'advance' => array(
        'id'          => 'advance',
        'title'       => __( 'Advance', 'text-domain' )
      ),
    ),
    'settings'        => array(
      // general STARTS
      'favicon' => array(
        'id'    => 'favicon',
        'label'   => __('Favicon', 'text-domain' ),
        'desc'    => __('Upload a 16x16px Png/Gif image for favicon', 'text-domain' ),
        'type'    => 'upload',
        'section' => 'general'
      ),
      'logo' => array(
        'id'    => 'logo',
        'label'   => __('Logo', 'text-domain' ),
        'desc'    => __('Upload your logo', 'text-domain' ),
        'type'    => 'upload',
        'section' => 'general'
      ),
      'flag_site_description' => array(
        'id'      => 'flag_site_description',
        'label'   => __('Site Description', 'text-domain' ),
        'desc'   => __('Show / Hide Site Description', 'text-domain' ),
        'type'    => 'on-off',
        'std'     => 'off',
        'section' => 'general'
      ),
      'flag_comment_in_page' => array(
        'id'      => 'flag_comment_in_page',
        'label'   => __('Comments in Page', 'text-domain' ),
        'desc'   => __('Enable / Disable Comments in Page', 'text-domain' ),
        'type'    => 'on-off',
        'std'     => 'on',
        'section' => 'general'
      ),
      // general ENDS

      // social STARTS
      'social_links' => array(
        'id'      => 'social_links',
        'label'   => __('Social Links', 'text-domain' ),
        'desc'    => __('Create and organize your social links', 'text-domain' ),
        'type'    => 'list-item',
        'section' => 'social',
        'settings'  => array(
          array(
            'id'    => 'social_link',
            'label' => 'Link',
            'desc'  => 'Enter the full url for your icon button',
            'std'   => 'http://',
            'type'  => 'text',
          ),
          array(
            'id'    => 'social_class',
            'label' => 'Class',
            'desc'  => 'Enter class for social link (Optional). Eg: facebook',
            'std'   => '',
            'type'  => 'text',
          ),
        )
      ),
      // social STARTS

      // sidebar STARTS
      'custom_sidebars' => array(
        'id'    => 'custom_sidebars',
        'label'   => __('Create Sidebars', 'text-domain' ),
        'desc'    => __('<i>Warning: Make sure each area has a unique ID.</i>', 'text-domain' ),
        'type'    => 'list-item',
        'section' => 'sidebar',
        'settings'  => array(
          array(
            'id'    => 'id',
            'label'   => __('Sidebar ID', 'text-domain' ),
            'desc'    => __('This ID must be unique, for example "sidebar-contact"', 'text-domain' ),
            'std'   => 'sidebar-',
            'type'    => 'text',
          ),
          array(
            'id'    => 'caption',
            'label'   => __('Caption', 'text-domain' ),
            'std'   => '',
            'type'    => 'text',
            'choices' => array()
          ),
        )
      ),


      // sidebar ENDS


      // footer STARTS
      'flag_footer_widgets' => array(
        'id'    => 'flag_footer_widgets',
        'label'   => __('Footer Widgets', 'text-domain' ),
        'desc'    => __('Widgets in footer', 'text-domain' ),
        'std'   => 'off',
        'type'    => 'on-off',
        'section' => 'footer'
      ),
      'number_of_footer_widgets' => array(
        'id'    => 'number_of_footer_widgets',
        'label'   => __('Number of Footer Widgets', 'text-domain' ),
        'desc'    => __('Select number of footer widgets', 'text-domain' ),
        'std'   => '0',
        'type'    => 'select',
        'section' => 'footer',
        'condition' => 'flag_footer_widgets:is(on)',
        'choices' => array(
          array(
            'value'   => '1',
            'label'   => __('1', 'text-domain' ),
          ),
          array(
            'value'   => '2',
            'label'   => __('2', 'text-domain' ),
          ),
          array(
            'value'   => '3',
            'label'   => __('3', 'text-domain' ),
          ),
          array(
            'value'   => '4',
            'label'   => __('4', 'text-domain' ),
          ),
          array(
            'value'   => '5',
            'label'   => __('5', 'text-domain' ),
          ),
          array(
            'value'   => '6',
            'label'   => __('6', 'text-domain' ),
          ),
        )
      ),
      'copyright_text' => array(
        'id'    => 'copyright_text',
        'label'   => __('Copyright Text', 'text-domain' ),
        'desc'    => __('Enter Copyright Text', 'text-domain' ),
        'std'    => '&copy; 2014',
        'type'    => 'text',
        'section' => 'footer'
      ),
      // footer ENDS
      // blog STARTS
      'excerpt_length' => array(
        'id'      => 'excerpt_length',
        'label'   => __('Excerpt Length', 'text-domain' ),
        'desc'    => __('Maximum number of words in excerpt', 'text-domain' ),
        'std'     => '40',
        'type'    => 'text',
        'section' => 'blog',
      ),
      'read_more_text' => array(
        'id'      => 'read_more_text',
        'label'   => __('Read More Text', 'text-domain' ),
        'desc'    => __('Enter text to display in Read more link', 'text-domain' ),
        'std'     => 'Read more...',
        'type'    => 'text',
        'section' => 'blog',
      ),
      // blog ENDS
      // advance STARTS
      'custom_css' => array(
        'id'      => 'custom_css',
        'label'   => __('Custom CSS', 'text-domain' ),
        'type'    => 'textarea_simple',
        'section' => 'advance',
      ),
      'custom_javascript_header' => array(
        'id'      => 'custom_javascript_header',
        'label'   => __('Custom Javascript in Header', 'text-domain' ),
        'type'    => 'textarea_simple',
        'section' => 'advance',
      ),
      'custom_javascript_footer' => array(
        'id'      => 'custom_javascript_footer',
        'label'   => __('Custom Javascript in Footer', 'text-domain' ),
        'type'    => 'textarea_simple',
        'section' => 'advance',
      ),
      // advance ENDS

    )
  );
