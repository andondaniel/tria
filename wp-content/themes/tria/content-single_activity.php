<?php
/**
 * @package Tria
 */
?>
<article id="post-<?php the_ID(); ?>" <?php post_class('large-12 columns'); ?> >

    <div class="entry-content">
        <div class="activity-content">
            <div class="small-<?php echo (has_post_thumbnail() ? '8' : '12'); ?>">
                <?php the_title('<h2 class="entry-title">Activity: ', '</h2>'); ?>
                <?php the_content(); ?>
            </div>
            <?php if(has_post_thumbnail()) { ?>
            <div class="small-4">
                <?php the_post_thumbnail('full'); ?>
            </div>
            <div class="clear"></div>
            <?php } ?>
        </div>

        <?php

        //  Preventions
        $preventions = get_field('injury_prevention');

        //  Check
        if($preventions && sizeof($preventions) > 0) {
        ?>
            <h4>Preventing Injury for <?php the_title(); ?></h4>
            Here are some tips for how to avoid injury while <?php echo strtolower(get_the_title()); ?>:

            <ul class="preventions">
                <?php foreach($preventions as $prevention) { ?>
                <li>
                    <span class="prevention-title"><?php echo $prevention['title']; ?>.</span>
                    <?php echo $prevention['contents']; ?>
                </li>
                <?php } ?>
            </ul>
        <?php } ?>
    </div>


</article><!-- #post-## -->
<div class="clear"></div>
