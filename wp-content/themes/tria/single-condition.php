<?php
/**
 * The template for displaying all single posts.
 *
 * @package Tria
 */

get_header(); ?>

<div class="row">

    <div class="large-12 columns">
        <?php get_sidebar(); ?>
        <br>

        <div class="large-10 columns header-column">
        	<div id="primary" class="content-area">
        		<main id="main" class="site-main" role="main">

        		<?php while ( have_posts() ) : the_post(); ?>

        			<?php get_template_part( 'content', 'single_condition' ); ?>

        		<?php endwhile; ?>

        		</main><!-- #main -->
        	</div><!-- #primary -->
    	</div>
	</div>

</div>

<?php get_footer(); ?>
