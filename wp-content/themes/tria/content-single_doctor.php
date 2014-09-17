<?php
/**
 * @package Tria
 */
?>
<article id="post-<?php the_ID(); ?>" <?php post_class('large-12 columns'); ?> >
	<header class="entry-header">
		<?php the_title( '<h2 class="entry-title">', '</h2>' ); ?>

		<br>
	</header><!-- .entry-header -->

	<div class="entry-content">
		<?php
			if ( has_post_thumbnail() ) {
				the_post_thumbnail();
			}
		?>
		<?php the_content(); ?>

                <?php

                    //  Get Form ID
                    $cf7_id = intval(wen_get_option('cf7_doctor_feedback'));

                    //  Check
                    if($cf7_id && $cf7_id > 0) {

                        //  Print the Form
                        echo do_shortcode('[contact-form-7 id="' . $cf7_id . '"]');
                    }
                ?>

	</div><!-- .entry-content -->


</article><!-- #post-## -->
<div class="clear"></div>
