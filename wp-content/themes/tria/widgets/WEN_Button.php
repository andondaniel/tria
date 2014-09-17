<?php

class WEN_Button_Widget extends WP_Widget {

    /**
     * Register widget with WordPress.
     */
    function __construct() {
        parent::__construct(
            'wen_button_widget',
            __('WEN Button', TEXT_DOMAIN),
            array(
                'description' => __('Widget to display the common buttons in widget', TEXT_DOMAIN)
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
        $type = (isset($instance['type']) ? $instance['type'] : 'blue');
        $page_id = intval(isset($instance['page_id']) ? $instance['page_id'] : null);
        $page_url = (isset($instance['custom_link']) && !empty($instance['custom_link']) ? $instance['custom_link'] : ($page_id > 0 ? get_the_permalink($page_id) : null));

        //  Before Widget
        echo $args['before_widget'];

        //  Print the Button
        echo wen_generate_button($type, $title, $page_url);

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

        //  Get the Title
        $title = (isset($instance['title']) ? $instance['title'] : '');

        //  Type
        $type = (isset($instance['type']) ? $instance['type'] : 'blue');

        //  Page ID
        $page_id = (isset($instance['page_id']) ? $instance['page_id'] : null);

        //  Custom Link
        $custom_link = (isset($instance['custom_link']) ? $instance['custom_link'] : '');

        //  Button Types
        $button_types = array(
            'green' => 'Green Button',
            'blue' => 'Blue Button'
        );

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
            <label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:'); ?></label> 
            <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>" placeholder="Button Label" title="Leave Empty to load Page Title" />
        </p>
        <p>
            <label for="<?php echo $this->get_field_id('type'); ?>"><?php _e('Type:'); ?></label> 
            <select class="widefat" id="<?php echo $this->get_field_id('type'); ?>" name="<?php echo $this->get_field_name('type'); ?>">
                <?php foreach($button_types as $button_type => $button_label) { ?>
                <option value="<?php echo $button_type; ?>" <?php echo ($button_type == $type ? 'selected="selected"' : ''); ?>><?php echo $button_label; ?></option>
                <?php } ?>
            </select>
        </p>
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
        $instance['title'] = (!empty($new_instance['title']) ) ? strip_tags($new_instance['title']) : '';
        $instance['type'] = (!empty($new_instance['type']) ) ? strip_tags($new_instance['type']) : '';
        $instance['page_id'] = (!empty($new_instance['page_id']) ) ? strip_tags($new_instance['page_id']) : '';
        $instance['custom_link'] = (!empty($new_instance['custom_link']) ) ? strip_tags($new_instance['custom_link']) : '';

        //  Check for Empty
        if(empty($instance['title']) && intval($instance['page_id']) > 0) {

            //  Get Post
            $post = get_post($instance['page_id']);

            //  Check
            if($post) {

                //  Set Title
                $instance['title'] = $post->post_title;
            }
        }

        //  Return
        return $instance;
    }

}
