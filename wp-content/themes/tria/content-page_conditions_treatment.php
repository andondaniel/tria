<?php

//  Get Bodyparts
$bodyparts = get_terms(TAX_TYPE_BODYPART, array(
    'hide_empty' => 0,
    'number' => 0
));

//  Get Activities
$args_activity = array(
    'post_type' => POST_TYPE_ACTIVITY,
    'post_status' => 'publish',
    'nopaging' => true,
    'orderby' => 'menu_order',
    'order' => 'ASC'
    );
$wizard_tools = get_post_meta(get_the_ID(), '_wizard_tools', true);
// nspre($wizard_tools,'wt');
$activity_ids = array();
if (!empty($wizard_tools)) {
    if ( isset($wizard_tools['title']) && !empty($wizard_tools['title']) ) {
        $activity_ids = $wizard_tools['title'];
    }
}
if (!empty($activity_ids)) {
    $args_activity['post__in'] = $activity_ids;
}
// nspre($activity_ids,'ids');
$activities = get_posts($args_activity);

?>
<div class="large-10 columns">
    <div class="large-12 columns paddingforty">
        <?php the_content(); ?>
    </div>
</div>
<div class="large-10 columns">
    <div class="treatments-subtitle">
        <h3 id="numero2">Where does it hurt?</h3>
    </div>
    <div class="large-6 columns">
        <div class="body-pain-points">
            <?php foreach($bodyparts as $bodypart) { ?>
            <a href="<?php echo get_term_link($bodypart); ?>" class="<?php echo get_field('body_part_class', $bodypart); ?> body-part"></a>
            <?php } ?>
            <!--<a href="http://tria-prototype.snapagency.com/conditions-treatments.html" class="neck-and-back"></a>
            <a href="http://tria-prototype.snapagency.com/conditions-treatments.html" class="shoulder"></a>
            <a href="http://tria-prototype.snapagency.com/conditions-treatments.html" class="elbow"></a>
            <a href="http://tria-prototype.snapagency.com/conditions-treatments.html" class="hand-and-wrist"></a>
            <a href="http://tria-prototype.snapagency.com/conditions-treatments.html" class="hip"></a>
            <a href="http://tria-prototype.snapagency.com/conditions-treatments.html" class="knee"></a>
            <a href="http://tria-prototype.snapagency.com/conditions-treatments.html" class="foot-and-ankle"></a>-->
        </div>
    </div>
    <div class="treatments-subtitle">
        <h3 id="numero3">What Makes it Hurt?</h3>
    </div>
    <div class="large-6 columns">
        <div id="numero3"></div>
        <ul class="activity-pain">
        <?php if (!empty($wizard_tools)): ?>
            <?php foreach ($wizard_tools['title'] as $key => $tool): ?>
                <?php
                    $wid = $tool;
                    $wimage = $wizard_tools['url'][$key];
                    // nspre($wimage);
                    $wpost = get_post($wid);
                 ?>
                <li><a href="<?php echo get_permalink($wid); ?>">
                    <?php if (!empty($wimage)): ?>
                        <img src="<?php echo esc_url($wimage); ?>" alt="asd" style="width:30px; height:30px;"/>&nbsp;
                    <?php endif ?>
                    <span><?php echo apply_filters('the_title', $wpost->post_title); ?></span>
                </a></li>
            <?php endforeach ?>
        <?php endif ?>

        </ul>
    </div>
</div>
