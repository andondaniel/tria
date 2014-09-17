<?php
// Template Name: Registration Form Page
get_header(); ?>
  <div class="row">
    <div class="large-12 columns">

      <?php get_sidebar(); ?>


      <?php while ( have_posts() ) : the_post(); ?>

        <?php get_template_part( 'pagepart/page', 'banner' ); ?>

        <?php get_template_part( 'content', 'page_registration' ); ?>

      <?php endwhile; // end of the loop. ?>



    </div>
  </div> <!-- .row -->



<?php get_footer(); ?>
