<?php
/**
 * The template for displaying archive pages.
 *
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package Tria
 */

//  Image
$image = get_field('part_full_image', get_queried_object());

get_header(); ?>

<div class="row">

    <div class="large-12 columns">
        <?php get_sidebar(); ?>
        <br>

        <div class="large-10 columns header-column">
        	<div id="primary" class="content-area">
        		<main id="main" class="site-main" role="main">

                            <div class="blue-block bodypart-blue-block">
                                <div class="small-<?php echo ($image ? '8' : '12'); ?>">
                                    <h3><?php single_cat_title(); ?></h3>
                                    <p>
                                        <?php echo term_description(); ?>
                                    </p>
                                </div>
                                <?php if($image) { ?>
                                <div class="small-4">
                                    <img src="<?php echo $image['url']; ?>" alt="" />
                                </div>
                                <?php } ?>
                                <div class="clear"></div>
                            </div>

                            <div class="body-part-conditions">
                                <?php while ( have_posts() ) : the_post(); ?>
                                <div class="body-part-condition">
                                    <h3>
                                        <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                                    </h3>
                                    <?php the_excerpt(); ?>
                                </div>
                                <?php endwhile; ?>
                            </div>

                            <?php tria_paging_nav(); ?>

        		</main><!-- #main -->
        	</div><!-- #primary -->
    	</div>
	</div>

</div>


<?php get_sidebar(); ?>
<?php get_footer(); ?>
