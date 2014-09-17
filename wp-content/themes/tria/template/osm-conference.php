<?php
// Template Name: OSM Conference Page
get_header(); ?>
  <div class="row">

      <?php while ( have_posts() ) : the_post(); ?>

        <?php get_template_part( 'content', 'page_osm' ); ?>

      <?php endwhile; // end of the loop. ?>

  </div> <!-- .row -->

<?php get_footer(); ?>
