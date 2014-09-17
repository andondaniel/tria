<?php
/**
 * @package Tria
 */
?>
<article id="post-<?php the_ID(); ?>" <?php post_class('large-12 columns post-listing'); ?> >
	<header class="entry-header">
		<?php the_title( '<h2 class="entry-title">', '</h2>' ); ?>

		<div class="entry-meta">
			Posted on: <?php the_date(); ?> by <?php the_author(); ?>
		</div><!-- .entry-meta -->
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
			wp_link_pages( array(
				'before' => '<div class="page-links">' . __( 'Pages:', 'tria' ),
				'after'  => '</div>',
			) );
		?>
	</div><!-- .entry-content -->

	<footer class="entry-footer">
		<?php
			/* translators: used between list items, there is a space after the comma */
			$category_list = get_the_category_list( __( ', ', 'tria' ) );

			/* translators: used between list items, there is a space after the comma */
			$tag_list = get_the_tag_list( '', __( ', ', 'tria' ) );

			echo 'Categories: '.$category_list;

		?>


		<?php edit_post_link( __( 'Edit', 'tria' ), '<span class="edit-link">', '</span>' ); ?>
	</footer><!-- .entry-footer -->
</article><!-- #post-## -->
<div class="clear"></div>
