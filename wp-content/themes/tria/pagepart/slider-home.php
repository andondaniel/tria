<?php
  $home_sliders = array();
  $args = array(
      'post_type' => 'wen-slider',
      'order_by'  => 'menu_order',
      'order'     => 'ASC',
      );
  $the_query = new WP_Query( $args );
 ?>
<?php if ( $the_query->have_posts() ) : ?>

  <?php $cnt=0; ?>

  <?php while ( $the_query->have_posts() ) : $the_query->the_post(); ?>

    <?php
    global $post;
    if ( has_post_thumbnail() ) {
      $image_url = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'full');

      if ( !empty( $image_url ) ) {

        $home_sliders[$cnt]['image_url']   = $image_url[0];
        $home_sliders[$cnt]['width']       = $image_url[1];
        $home_sliders[$cnt]['height']      = $image_url[2];
        $home_sliders[$cnt]['title']       = $post->post_title;

        if (function_exists('get_field')) {
          $home_sliders[$cnt]['description']        = get_field( 'slider_text' );
          $home_sliders[$cnt]['slider_url']         = get_field( 'slider_url' );
          $home_sliders[$cnt]['slider_button_text'] = get_field( 'slider_button_text' );
          $home_sliders[$cnt]['open_in_new_page']   = get_field( 'open_in_new_page' );
        }

        $cnt++;

      }
    }

     ?>

  <?php endwhile; ?>

<?php endif; ?>

<?php wp_reset_postdata(); ?>

<?php if (!empty($home_sliders)): ?>


<div class="slider-wrapper">
  <div class="slider responsive">

    <?php foreach ($home_sliders as $key => $slide): ?>

      <div class="slide" style="background-image: url('<?php echo esc_url( $slide['image_url'] ); ?>')" >
        <div class="row">
          <div class="large-12 columns">
            <h1><?php echo $slide['title']; ?></h1>
            <div class="show-for-medium-up">
              <hr>
              <p class="show-for-medium-up"><?php echo $slide['description']; ?></p>
              <?php
              $link_open = '';
              $link_close = '';
              if ( isset( $slide['slider_url'] ) && ! empty( $slide['slider_url'] ) ) {
                $link_open = '<a href="' . esc_url( $slide['slider_url'] ) . '" class="button main-cta" >';
                $link_close = '</a>';
              }
              if (!empty($link_open)) {
                echo sprintf('%s%s%s',
                  $link_open,
                  esc_attr($slide['slider_button_text']),
                  $link_close
                  );
              }
               ?>
            </div>
          </div>
        </div>
      </div>

    <?php endforeach ?>

  </div>
</div>
<?php endif; ?>
