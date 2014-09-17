<div class="large-10 columns">
    <div class="large-8 columns">
        <div class="blue-block">
            <h3><?php echo get_field('tag_line'); ?></h3>
            <p>
                <?php the_content(); ?>
            </p>
        </div>
        <p>
            <b>Please take a moment to answer the questions below and share your story. We look forward to hearing from you.</b>
        </p>
        <?php

            //  Get Form ID
            $cf7_id = intval(wen_get_option('cf7_feedback'));

            //  Check
            if($cf7_id && $cf7_id > 0) {

                //  Print the Form
                echo do_shortcode('[contact-form-7 id="' . $cf7_id . '"]');
            }
        ?>
    </div>

    <div class="large-4 columns right-sidebar">
        <?php dynamic_sidebar('sidebar-feedback'); ?>
    </div>
</div>
