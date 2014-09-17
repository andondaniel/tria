<div class="large-10 columns" style="margin-top:20px;">

<?php
$job_departments = get_terms( 'cdepartment', array(
  'orderby'    => 'name',
  'hide_empty' => 1
 ) );

 ?>

 <?php foreach ($job_departments as $key => $department ): ?>

  <h3><?php echo $department->name ; ?></h3>

  <?php
  $custom_query_args = array(
    'post_type' => 'career',
    'tax_query' => array(
        array(
          'taxonomy' => 'cdepartment',
          'field'    => 'slug',
          'terms'    => $department->slug,
        ),
      ),

    );
  // Get current page and append to custom query parameters array
  $custom_query_args['paged'] = get_query_var( 'paged' ) ? get_query_var( 'paged' ) : 1;

  $custom_query = new WP_Query( $custom_query_args ); ?>

  <?php if ( $custom_query->have_posts() ) : ?>

    <!-- the loop -->
    <?php while ( $custom_query->have_posts() ) : $custom_query->the_post(); ?>
      <p><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></p>

      <?php $post_meta = get_fields(); ?>

    <?php endwhile; ?>
    <!-- end of the loop -->

  <?php endif; ?>

  <?php
  // Reset postdata
  wp_reset_postdata();
  ?>


  <?php endforeach; // endforeach of job_departments ?>
</div>
