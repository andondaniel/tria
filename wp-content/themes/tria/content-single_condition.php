<?php
/**
 * @package Tria
 */

//  Terms 
$terms = get_the_terms(get_post(), TAX_TYPE_BODYPART);

//  First Term
$theTerm = ($terms && sizeof($terms) > 0 ? array_shift($terms) : null);

//  Image
$image = get_field('part_full_image', $theTerm);

?>
<article id="post-<?php the_ID(); ?>" <?php post_class('large-12 columns'); ?> >
    <div class="entry-content">
        <div class="condition-content">
            <div class="small-<?php echo ($image ? '8' : '12'); ?>">
                <?php the_title('<h2 class="entry-title">' . strip_tags(get_the_term_list(get_the_ID(), TAX_TYPE_BODYPART)) . ': ', '</h2>'); ?>
                <?php the_content(); ?>
            </div>
            <?php if($image) { ?>
            <div class="small-4">
                <img src="<?php echo $image['url']; ?>" alt="" />
            </div>
            <div class="clear"></div>
            <?php } ?>
        </div>

        <div class="clear"><br/><br/><br/></div>

        <?php

            //  Get Symptoms
            $symptoms = get_field('symptoms');

            //  Get Treatments
            $treatments = get_field('treatments');

            //  Check
            if($symptoms || $treatments) {
        ?>
        <ul class="tabs events-tabs" data-tab>
            <?php if($symptoms) { ?>
            <li class="tab-title active">
                <a href="#panel-symptoms">Signs & Symptoms</a>
            </li>
            <?php } ?>
            <?php if($treatments) { ?>
            <li class="tab-title <?php echo (!$symptoms ? 'active' : ''); ?>">
                <a href="#panel-treatments">Treatments</a>
            </li>
            <?php } ?>
        </ul>
        <div class="large-12 columns">
            <div class="tabs-content events-content">
                <?php if($symptoms) { ?>
                <div class="content active" id="panel-symptoms">
                    Signs and symptoms of an <?php the_title(); ?> may include:
                    <ul class="condition-symptoms">
                        <?php foreach($symptoms as $symptom) { ?>
                        <li><?php echo $symptom['symptom']; ?></li>
                        <?php } ?>
                    </ul>
                </div>
                <?php } ?>
                <?php if($treatments) { ?>
                <div class="content <?php echo (!$symptoms ? 'active' : ''); ?>" id="panel-treatments">
                    <?php foreach($treatments as $treatment) { ?>
                    <div class="condition-treatment">
                        <strong><?php echo $treatment['title']; ?></strong>
                        <p><?php echo $treatment['contents']; ?></p>
                    </div>
                    <?php } ?>
                </div>
                <?php } ?>
            </div>
        </div>
        <?php } ?>

    </div>


</article><!-- #post-## -->
<div class="clear"></div>
