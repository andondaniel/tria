<?php
/**
* @package Tria
*/
?>
<div <?php post_class('large-10 columns post-listing'); ?> id="post-<?php the_ID(); ?>" style="" >
	<div class="large-3 columns date-and-meta">
		<div class="date">
			<span class="day"><?php the_time('m'); ?></span>
			<span class="month"><?php the_time('F'); ?></span>
			<span class="year"><?php the_time('Y'); ?></span>
		</div>
		<hr>
		<div class="post-meta">
			<span class="author"><span class="blog-icons">&#128100;</span><span class="meta-tag"><?php the_author(); ?></span></span>
			<span class="comments"><span class="blog-icons">&#59168;</span><span class="meta-tag">
			<?php if ( ! post_password_required() && ( comments_open() || '0' != get_comments_number() ) ) : ?>
			<?php comments_popup_link( __( 'Add comment', 'tria' ), __( '1 Comment', 'tria' ), __( '% Comments', 'tria' ) ); ?>
			<?php endif; ?>
			</span></span>
			<span class="tags">
			<?php
				/* translators: used between list items, there is a space after the comma */
				$categories_list = get_the_category_list( __( ', ', 'tria' ) );
				if ( $categories_list && tria_categorized_blog() ) :
			?>
			<span class="blog-icons">&#59148;</span>
			<span class="meta-tag">
			<?php echo $categories_list; ?>
			</span>
			<?php endif; // End if categories ?>
			</span>
		</div>
	</div>
	<div class="large-9 columns image-and-description">
		<?php
		// Must be inside a loop.
		if ( has_post_thumbnail() ) {
			the_post_thumbnail('full');
		}
		else {
			echo '<img src="http://placehold.it/785x237" />';
		}
		?>
		<div class="share-module">&nbsp;</div>
		<h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
		<div class="grid-only date-meta">
				<span><?php the_time('F'); ?></span>&nbsp;<span><?php the_time('m'); ?></span>,&nbsp;<span><?php the_time('Y'); ?></span>&nbsp;|&nbsp;<?php the_author(); ?>
		</div><!-- .grid-only -->
		<div class="grid-only cat-meta">
			<span class="blog-icons">&#59148;</span>
				<span class="meta-tag">
				<?php echo $categories_list; ?>
				</span>
		</div><!-- .grid-only -->
		<div class="p-excerpt"><?php the_excerpt(); ?></div><!-- .p-excerpt -->
		<a class="button" href="<?php the_permalink(); ?>">Read More</a>
	</div>
</div>
<div class="clear11"></div>
