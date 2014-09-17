<?php
/**
 * NSFP Featured Posts widget class
 */
class NSFP_Featured_Post_Widget extends WP_Widget {

  function __construct() {

    $widget_ops = array('classname' => 'nsfp_featured_post_widget', 'description' => __( 'NS Featured Posts Widget', 'ns-featured-posts' ) );
    parent::__construct('nsfp-featured-post-widget', __( 'NS Featured Posts', 'ns-featured-posts' ), $widget_ops);

  }

  function widget($args, $instance) {

    ob_start();
    extract($args);

    $title = ( ! empty( $instance['title'] ) ) ? $instance['title'] : __( 'Featured Posts' );

    /** This filter is documented in wp-includes/default-widgets.php */
    $title = apply_filters( 'widget_title', $title, $instance, $this->id_base );

    $number = ( ! empty( $instance['number'] ) ) ? absint( $instance['number'] ) : 5;
    if ( ! $number )
      $number = 5;
    $show_date = isset( $instance['show_date'] ) ? $instance['show_date'] : false;
    $post_type = isset( $instance['post_type'] ) ? esc_attr( $instance['post_type'] ) : 'post';

    $nsfp_query = new WP_Query( apply_filters( 'nsfp_featured_posts_widget_args', array(
      'posts_per_page'      => $number,
      'no_found_rows'       => true,
      'post_status'         => 'publish',
      'ignore_sticky_posts' => true,
      'meta_key'            => '_is_ns_featured_post',
      'meta_value'          => 'yes',
      'post_type'           => $post_type,
    ) ) );
?>


    <?php echo $before_widget; ?>
    <?php if ( $title ) echo $before_title . $title . $after_title; ?>

    <?php if ($nsfp_query->have_posts()) :  ?>

    <ul>
    <?php while ( $nsfp_query->have_posts() ) : $nsfp_query->the_post(); ?>
      <li>
        <a href="<?php the_permalink(); ?>"><?php get_the_title() ? the_title() : the_ID(); ?></a>&nbsp;
      <?php if ( $show_date ) : ?>
        <span class="post-date"><?php echo get_the_date(); ?></span>
      <?php endif; ?>
      </li>
    <?php endwhile; ?>
    </ul>
  <?php else: ?>
    <p><?php _e( 'No featured found', 'ns-featured-posts' ) ?></p>
  <?php endif; ?>

  <?php

    echo $after_widget;

    // Reset the global $the_post as this query will have stomped on it
    wp_reset_postdata();
    ob_end_flush();
  }

  function update( $new_instance, $old_instance ) {
    $instance = $old_instance;
    $instance['title']     = strip_tags($new_instance['title']);
    $instance['number']    = (int) $new_instance['number'];
    $instance['show_date'] = isset( $new_instance['show_date'] ) ? (bool) $new_instance['show_date'] : false;
    $instance['post_type'] = strip_tags($new_instance['post_type']);
    return $instance;
  }

  function form( $instance ) {
    $title     = isset( $instance['title'] ) ? esc_attr( $instance['title'] ) : '';
    $number    = isset( $instance['number'] ) ? absint( $instance['number'] ) : 5;
    $show_date = isset( $instance['show_date'] ) ? (bool) $instance['show_date'] : false;
    $post_type = isset( $instance['post_type'] ) ? esc_attr( $instance['post_type'] ) : 'post';
?>
    <p><label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:', 'ns-featured-posts' ); ?></label>
    <input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo $title; ?>" /></p>

    <p><label for="<?php echo $this->get_field_id( 'number' ); ?>"><?php _e( 'Number of posts to show:', 'ns-featured-posts' ); ?></label>
    <input id="<?php echo $this->get_field_id( 'number' ); ?>" name="<?php echo $this->get_field_name( 'number' ); ?>" type="text" value="<?php echo $number; ?>" size="3" /></p>

    <p><label for="<?php echo $this->get_field_id('post_type'); ?>"><?php _e('Post Type:', 'ns-featured-posts' ) ?></label>
    <select id="<?php echo $this->get_field_id('post_type'); ?>" name="<?php echo $this->get_field_name('post_type'); ?>">
      <option value="post" <?php selected($post_type, 'post' ) ?>><?php _e( 'Post', 'ns-featured-posts' ) ?></option>
      <option value="page" <?php selected($post_type, 'page' ) ?>><?php _e( 'Page', 'ns-featured-posts' ) ?></option>
      <?php
      $args = array(
        'public' => true,
        '_builtin' => false
      );
      $post_types_custom = get_post_types( $args, 'objects' );
      ?>
      <?php if ( ! empty( $post_types_custom ) ): ?>
        <?php foreach ( $post_types_custom as $key => $ptype ): ?>
          <?php $name = $ptype->labels->{'name'}; ?>
          <option value="<?php echo $key; ?>" <?php selected($post_type, $key ) ?>><?php echo $name; ?></option>

        <?php endforeach ?>

      <?php endif ?>
    </select></p>

    <p><input class="checkbox" type="checkbox" <?php checked( $show_date ); ?> id="<?php echo $this->get_field_id( 'show_date' ); ?>" name="<?php echo $this->get_field_name( 'show_date' ); ?>" />
    <label for="<?php echo $this->get_field_id( 'show_date' ); ?>"><?php _e( 'Display post date?', 'ns-featured-posts' ); ?></label></p>
<?php
  }
}
