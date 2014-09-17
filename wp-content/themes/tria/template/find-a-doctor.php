<?php
// Template Name: Find A Doctor Page
get_header(); ?>
  <div class="row">
    <div class="large-12 columns">

      <?php get_sidebar(); ?>

      <?php while ( have_posts() ) : the_post(); ?>

        <?php get_template_part( 'content', 'page_find_a_doctor' ); ?>

      <?php endwhile; // end of the loop. ?>

    </div> <!-- .row -->
  </div> <!-- .row -->

<?php get_footer(); ?>
