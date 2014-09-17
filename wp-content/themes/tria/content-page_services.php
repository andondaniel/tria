<?php
$meta = get_fields();
// nspre($meta);
$banner_style = '';
if (!empty($meta['banner_image'])) {
  $banner_style = "background-image: url('".$meta['banner_image']['url'] ."')";
}
 ?>
<div class="large-10 columns header-column">
  <div style="<?php echo $banner_style; ?>" class="inner-page-header">
    <h1><?php the_title(); ?></h1>
    <hr>
  </div>
  <?php $acute_injury_clinic_page = wen_get_option('cp_acute_injury_clinic'); ?>


  <?php if (!empty($acute_injury_clinic_page)): ?>

    <?php
      $clinic_post = get_post($acute_injury_clinic_page);
      $clinic_excerpt = wp_trim_words( $clinic_post->post_content, 40 );
      $clinic_thumbnail = get_the_post_thumbnail($acute_injury_clinic_page, 'full');

     ?>

    <div class="large-7 columns services-secondhead">
      <?php echo $clinic_thumbnail; ?>
      <a class="services-button button"><?php echo esc_html($clinic_post->post_title); ?></a>
    </div>
    <div class="large-5 columns paddingforty">
      <p><?php echo $clinic_excerpt; ?></p>
      <a class="alt-button-2" href="<?php echo get_permalink($acute_injury_clinic_page); ?>">View Clinic</a>
    </div>

  <?php endif ?>

</div>

<div class="large-10 columns">
  <h3 class="inner-page-welcome"><?php the_title(); ?></h3>
  <?php the_content(); ?>

  <?php
    $custom_query_args = array(
      'post_type' => 'service',
      'posts_per_page' => 6,
      'tax_query' => array(
          array(
            'taxonomy' => 'service_type',
            'field'    => 'slug',
            'terms'    => 'tria-service',
          ),
        ),
      );

    $custom_query = new WP_Query( $custom_query_args );
   ?>
   <?php if ( $custom_query->have_posts() ) : ?>

     <!-- the loop -->
     <?php $col_count = 1; ?>
     <?php while ( $custom_query->have_posts() ) : $custom_query->the_post(); ?>

       <div class="large-4 columns">
         <?php
         if ( '' != get_the_post_thumbnail()  ) {
          $attr_arg = array(
            'class' => 'service-images',
            );
          the_post_thumbnail('full', $attr_arg);
         }
         else{
          echo '<img src="http://placehold.it/279x96&text=No+Image" class="service-images" />';
         }
          ?>
           <a href="<?php the_permalink(); ?>" class="service-button"><?php the_title(); ?>&nbsp;<span class="service-icon">&#59238;</span></a>
       </div>

       <?php if ($col_count % 3 == 0 ): ?>

        <div class="clearfix"></div>

       <?php endif ?>

       <?php $col_count++; ?>

     <?php endwhile; ?>
     <!-- end of the loop -->

   <?php endif; ?>

   <?php
   // Reset postdata
   wp_reset_postdata();
   ?>

   <div class="clearfix"></div>
   <h3 class="inner-page-welcome">Unique Programs</h3>
   <div class="clearfix"></div>

   <?php
     $custom_query_args = array(
       'post_type' => 'service',
       'posts_per_page' => 6,
       'tax_query' => array(
           array(
             'taxonomy' => 'service_type',
             'field'    => 'slug',
             'terms'    => 'tria-unique-program',
           ),
         ),
       );

     $custom_query = new WP_Query( $custom_query_args );
    ?>
    <?php if ( $custom_query->have_posts() ) : ?>

      <!-- the loop -->
      <?php $col_count = 1; ?>
      <?php while ( $custom_query->have_posts() ) : $custom_query->the_post(); ?>

        <div class="large-4 columns">
          <a href="<?php the_permalink(); ?>" class="service-button unique-programs"><?php the_title(); ?>&nbsp;<span class="service-icon">&#59238;</span></a>
        </div>

        <?php if ($col_count % 3 == 0 ): ?>

         <div class="clearfix"></div>

        <?php endif ?>

        <?php $col_count++; ?>

      <?php endwhile; ?>
      <!-- end of the loop -->

    <?php endif; ?>

    <?php
    // Reset postdata
    wp_reset_postdata();
    ?>

  <div class="clearfix"></div>

  <div class="spacer"></div>
</div>
