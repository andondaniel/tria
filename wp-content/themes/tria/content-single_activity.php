<?php
/**
 * @package Tria
 */
?>
<article id="post-<?php the_ID(); ?>" <?php post_class('large-12 columns'); ?> >

    <div class="entry-content">
        <div class="activity-content">
            <div class="small-12">
                <?php //the_title('<h2 class="entry-title">', '</h2>'); ?>
                <?php the_content(); ?>
            </div>
        </div>

    </div>


</article><!-- #post-## -->
<div class="clear"></div>
