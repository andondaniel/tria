<?php

class WEN_Block_Blue_Widget extends WP_Widget {

    /**
     * Register widget with WordPress.
     */
    function __construct() {
        parent::__construct(
            'wen_block_blue_widget',
            __('WEN Block Blue', TEXT_DOMAIN),
            array(
                'description' => __('Widget to display the Blue block in widget', TEXT_DOMAIN)
            )
        );
    }

    /**
     * Front-end display of widget.
     *
     * @see WP_Widget::widget()
     *
     * @param array $args     Widget arguments.
     * @param array $instance Saved values from database.
     */
    public function widget($args, $instance) {

        //  Get the Button Arguments
        $title = apply_filters('widget_title', $instance['title']);
        $contents = (isset($instance['contents']) ? $instance['contents'] : '');
        $link_text = (isset($instance['link_text']) ? $instance['link_text'] : 'Click Here');
        $page_id = intval(isset($instance['page_id']) ? $instance['page_id'] : null);
        $page_url = (isset($instance['custom_link']) && !empty($instance['custom_link']) ? $instance['custom_link'] : ($page_id > 0 ? get_the_permalink($page_id) : null));

        //  Before Widget
        echo $args['before_widget'];
?>
<div class="conference-mailer">
     <h4><?php echo $title; ?></h4>
        <?php echo str_ireplace("\n", '<br/>', $contents); ?>
     <a class="button" href="<?php echo $page_url; ?>"><?php echo $link_text; ?></a>
</div>
<?php
        //  After Widget
        echo $args['after_widget'];
    }

    /**
     * Back-end widget form.
     *
     * @see WP_Widget::form()
     *
     * @param array $instance Previously saved values from database.
     */
    public function form($instance) {

        //  Page ID
        $page_id = (isset($instance['page_id']) ? $instance['page_id'] : null);

        //  Get the Title
        $title = (isset($instance['title']) ? $instance['title'] : '');

        //  Get the Contents
        $contents = (isset($instance['contents']) ? $instance['contents'] : '');

        //  Link Text
        $linkText = (isset($instance['link_text']) ? $instance['link_text'] : '');

        //  Custom Link
        $custom_link = (isset($instance['custom_link']) ? $instance['custom_link'] : '');

        //  Pages List
        $pages_list = array();

        //  Get the Pages
        $pages = get_posts(array(
            'status' => 'publish',
            'post_type' => 'page',
            'nopaging' => true,
            'order_by' => 'title'
        ));

        //  Loop Each
        foreach($pages as $page) {

            //  Add
            $pages_list[$page->ID] = $page->post_title;
        }

        ?>
        <p>
            <label for="<?php echo $this->get_field_id('page_id'); ?>"><?php _e('Page to Link:'); ?></label>
            <select class="widefat" id="<?php echo $this->get_field_id('page_id'); ?>" name="<?php echo $this->get_field_name('page_id'); ?>">
                <option value="">- None -</option>
                <?php foreach($pages_list as $theID => $theTitle) { ?>
                <option value="<?php echo $theID; ?>" <?php echo ($theID == $page_id ? 'selected="selected"' : ''); ?>><?php echo $theTitle; ?></option>
                <?php } ?>
            </select>
        </p>
        <p>
            <label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:'); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>" title="Leave Empty to load Page Title" />
        </p>
        <p>
            <label for="<?php echo $this->get_field_id('contents'); ?>"><?php _e('Contents:'); ?></label>
            <textarea class="widefat" id="<?php echo $this->get_field_id('contents'); ?>" name="<?php echo $this->get_field_name('contents'); ?>" title="Leave Empty to load Page Tile Settings" rows="5"><?php echo esc_attr($contents); ?></textarea>
        </p>
        <p>
            <label for="<?php echo $this->get_field_id('link_text'); ?>"><?php _e('Link Text:'); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id('link_text'); ?>" name="<?php echo $this->get_field_name('link_text'); ?>" type="text" value="<?php echo esc_attr($linkText); ?>" title="Leave Empty to load Page Tile Settings" />
        </p>
        <p>
            <label for="<?php echo $this->get_field_id('custom_link'); ?>"><?php _e('Custom Link:'); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id('custom_link'); ?>" name="<?php echo $this->get_field_name('custom_link'); ?>" type="text" value="<?php echo esc_attr($custom_link); ?>" placeholder="Custom Link" />
        </p>
        <?php
    }

    /**
     * Sanitize widget form values as they are saved.
     *
     * @see WP_Widget::update()
     *
     * @param array $new_instance Values just sent to be saved.
     * @param array $old_instance Previously saved values from database.
     *
     * @return array Updated safe values to be saved.
     */
    public function update($new_instance, $old_instance) {

        //  Instance
        $instance = array();

        //  Populate
        $instance['page_id'] = (!empty($new_instance['page_id']) ) ? strip_tags($new_instance['page_id']) : '';
        $instance['title'] = (!empty($new_instance['title']) ) ? strip_tags($new_instance['title']) : '';
        $instance['contents'] = (!empty($new_instance['contents']) ) ? strip_tags($new_instance['contents']) : '';
        $instance['link_text'] = (!empty($new_instance['link_text']) ) ? strip_tags($new_instance['link_text']) : '';
        $instance['custom_link'] = (!empty($new_instance['custom_link']) ) ? strip_tags($new_instance['custom_link']) : '';

        //  Check for Empty
        if((empty($instance['title']) || empty($instance['contents']) || empty($instance['link_text']))
                && intval($instance['page_id']) > 0) {

            //  Get Post
            $post = get_post($instance['page_id']);

            //  Check
            if($post) {

                //  Set Title
                if(empty($instance['title']))   $instance['title'] = $post->post_title;
                if(empty($instance['contents']))   $instance['contents'] = (get_field('use_tagline_for_contents', $post->ID) == true ? get_field('tag_line', $post->ID) : get_field('tile_contents', $post->ID));
                if(empty($instance['link_text']))   $instance['link_text'] = (get_field('link_text', $post->ID) != '' ? get_field('link_text', $post->ID) : 'Click Here');
            }
        }

        //  Return
        return $instance;
    }

}
