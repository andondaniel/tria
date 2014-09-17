<?php

/**
 * wen_logo()
 */
if( ! function_exists( 'wen_logo' ) ) :
  function wen_logo(){

    $flag_apply_wen_logo = apply_filters('wen_filter_logo_content', true );
    if ( true != $flag_apply_wen_logo ) {
      return false;
    }

    $logo = wen_get_option( 'logo' );
    ?>
    <div class="site-branding">
      <h1 class="site-title">
        <a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home">
        <?php if ( $logo ): ?>
          <img src="<?php echo esc_url( $logo ); ?>" alt="<?php echo esc_attr( get_bloginfo( 'name' ) ); ?>" />
        <?php else: ?>
          <?php bloginfo( 'name' ); ?>
        <?php endif ?>
        </a>
      </h1>
      <?php $flag_site_description = wen_get_option( 'flag_site_description' , 'off' ); ?>
      <?php if ( 'on' == $flag_site_description ): ?>
        <h2 class="site-description"><?php bloginfo( 'description' ); ?></h2>
      <?php endif ?>
    </div>
    <?php

  } // end function wen_logo
endif;


/**
 * wen_footer_widgets()
 */
if( ! function_exists( 'wen_footer_widgets' ) ) :
  function wen_footer_widgets( $args = array() ){

    $flag_apply_footer_widgets_content = apply_filters('wen_filter_footer_widgets_content', true );
    if ( true != $flag_apply_footer_widgets_content ) {
      return false;
    }


    $flag_footer_widgets = wen_get_option( 'flag_footer_widgets' );
    if ( ! ( 'on' == $flag_footer_widgets ) ) {
      return;
    }
    $number_of_footer_widgets = wen_get_option('number_of_footer_widgets');
    //Defaults
    $args = wp_parse_args( (array) $args, array(
      'container'       => 'div',
      'container_class' => '',
      'container_id'    => '',
      'wrap_class'      => 'footer-widget-area',
      'before'          => '',
      'after'           => '',
      ) );
    $args = apply_filters( 'wen_filter_footer_widgets_args', $args );

    $container_open = '';
    $container_close = '';

    if ( ! empty( $args['container_class'] ) || ! empty( $args['container_id'] ) ) {
      $container_open = sprintf(
        '<%s %s %s>',
        $args['container'],
        ( $args['container_class'] ) ? 'class="' . $args['container_class'] . '"':'',
        ( $args['container_id'] ) ? 'id="' . $args['container_id'] . '"':''
        );
    }
    if ( ! empty( $args['container_class'] ) || ! empty( $args['container_id'] ) ) {
      $container_close = sprintf(
        '</%s>',
        $args['container']
        );
    }

    echo $container_open;

    echo $args['before'];

    for($i = 1; $i <= $number_of_footer_widgets ;$i++){
      $item_class = apply_filters( 'wen_filter_footer_widget_class', '', $i );
      $div_classes = implode(' ', array( $args['wrap_class'], $item_class ) );
      echo '<div class="' . $div_classes .  '">';
      $sidebar_name = ( 1 == $i ) ? "footer-sidebar" : "footer-sidebar-$i" ;
      dynamic_sidebar( $sidebar_name );
      echo '</div><!-- .' . $args['wrap_class'] . ' -->';
    } // end for loop

    echo $args['after'];

    echo $container_close;

  } // end function wen_footer_widgets
endif;



/**
 * wen_sidebar()
 */
if( ! function_exists( 'wen_sidebar' ) ) :
  function wen_sidebar(){

    $default_sidebar = 'sidebar-1';

    $sidebar = apply_filters( 'wen_filter_default_sidebar', $default_sidebar );

    if ( is_page() || is_single() ) {
      // Reset post data
      wp_reset_postdata();
      global $post;
      // Get meta
      $meta = get_post_meta($post->ID,'_sidebar_1',true);
      if ( $meta ) { $sidebar = $meta; }
    }

    dynamic_sidebar( $sidebar );
    return;

  } // end function wen_sidebar
endif;

/*
* wen_social_links()
*/
if ( ! function_exists( 'wen_social_links' ) ) :
    function wen_social_links( $args = array() ){

      $social_links = wen_get_option( 'social_links' );
      if ( empty($social_links ) ) {
        return;
      }
      //Defaults
      $args = wp_parse_args( (array) $args, array(
        'echo'            => true,
        'container'       => 'div',
        'container_class' => '',
        'container_id'    => '',
        'list_class'      => '',
        'list_id'         => '',
        'before'          => '',
        'after'           => '',
        ) );
      $args = apply_filters( 'wen_filter_social_links_args', $args );

      $output = '';
      $output .= $args['before'];

      $container_open = '';
      $container_close = '';

      if ( ! empty( $args['container_class'] ) || ! empty( $args['container_id'] ) ) {
        $container_open = sprintf(
          '<%s %s %s>',
          $args['container'],
          ( $args['container_class'] ) ? 'class="' . $args['container_class'] . '"':'',
          ( $args['container_id'] ) ? 'id="' . $args['container_id'] . '"':''
          );
      }
      if ( ! empty( $args['container_class'] ) || ! empty( $args['container_id'] ) ) {
        $container_close = sprintf(
          '</%s>',
          $args['container']
          );
      }

      $output .= $container_open;

      $list_tag = sprintf(
        '<ul %s %s>',
        ( $args['list_class'] ) ? 'class="' . $args['list_class'] . '"':'',
        ( $args['list_id'] ) ? 'id="' . $args['list_id'] . '"':''
        );
      $output .= $list_tag;


      $social_links_array = array();
      foreach( $social_links as $item ) {
        if ( !  (isset($item['title']) && !empty($item['title']) ) ){
          continue;
        }
        $item_key = sanitize_title( $item['title'] );
        if (!empty($item['social_class'])) {
          $item_key = esc_attr( $item['social_class'] );
        }
        $social_links_array[$item_key]['title'] = esc_attr( $item['title'] ) ;
        $social_links_array[$item_key]['social_link'] = esc_attr( $item['social_link'] ) ;
        $social_links_array[$item_key]['url'] = esc_url( $item['social_link'] ) ;
        $social_links_array[$item_key]['class'] = $item_key ;
        $social_links_array[$item_key]['new_page'] = 1 ;
        $social_links_array[$item_key]['show_title'] = 1 ;

      }
      $social_links_array = apply_filters( 'wen_filter_social_links', $social_links_array );

      foreach( $social_links_array as $item ) {

        $target = ($item['new_page']) ? ' target="_blank" ' : '' ;

        if ( isset($item['title']) && !empty($item['title']) ) {
          $title = 'title="' .esc_attr( $item['title'] ). '"';
        } else {
          $title = '';
        }
        if ( isset($item['title']) && !empty($item['title']) ) {
          $link = ' href="'.$item['url'].'" ';
          $output .= '<li><a rel="nofollow" class="' . $item['class'] . '" '.$title.' '.$link.' '.$target.'>';
          if ( isset( $item['show_title'] ) && 1 == $item['show_title'] ) {
            $output .= $item['title'];
          }
          $output .= '</a></li>';
        }

      }

      $output .= '</ul>';

      $output .= $container_close;

      $output .= $args['after'];

      if ($args['echo']) {
        echo $output;
        return;
      }
      return $output;
    }
endif; // wen_social_links()

/**
 * wen_sidebar_class()
 */
if ( ! function_exists( 'wen_sidebar_class' ) ) :
    function wen_sidebar_class( $class = '' ){

      $classes = array();
      if ( ! empty( $class ) ) {
        if ( !is_array( $class ) )
          $class = preg_split( '#\s+#', $class );
        $classes = array_merge( $classes, $class );
      } else {
        // Ensure that we always coerce class to being an array.
        $class = array();
      }
      $classes = array_map( 'esc_attr', $classes );
      $all_classes = apply_filters( 'wen_sidebar_class', $classes, $class );
      echo ' class="' . join( ' ', $all_classes ) . '"';

    }
endif;

/**
 * wen_content_class()
 */
if ( ! function_exists( 'wen_content_class' ) ) :
    function wen_content_class( $class = '' ){

      $classes = array();
      if ( ! empty( $class ) ) {
        if ( !is_array( $class ) )
          $class = preg_split( '#\s+#', $class );
        $classes = array_merge( $classes, $class );
      } else {
        // Ensure that we always coerce class to being an array.
        $class = array();
      }
      $classes = array_map( 'esc_attr', $classes );
      $all_classes = apply_filters( 'wen_content_class', $classes, $class );
      echo ' class="' . join( ' ', $all_classes ) . '"';

    }
endif;
