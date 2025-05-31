<?php

namespace App\Widgets;

use WP_Widget;

class ContactForm extends WP_Widget
{
    public function __construct()
    {
        parent::__construct(
            'contact-form',
            'Contact Form'
        );;
    }

    public $args = [
        'before_title' => '<h3 class="widgettitle">',
        'after_title' => '</h3>',
        'before_widget' => '<div class="widget-wrap">',
        'after_widget' => '</div></div>'
    ];

    public function widget($args, $instance)
    {
        $id = uniqid();
        $title = null;
        echo $args['before_widget'];

        if (!empty($instance['title'])) {
            $title = $args['before_title'] . apply_filters('widget_title', $instance['title']) . $args['after_title'];
        }

        echo "<div class='textwidget'><div class='contact-form contact-form-$id' data-id='$id'><div is='contact-form'>{$title}<br>{$instance['content']}</div></div></div>";

        echo $args['after_widget'];
    }


    public function form($instance)
    {
        $title = !empty($instance['title']) ? $instance['title'] : '';
        $content = !empty($instance['content']) ? $instance['content'] : '';
        $redirectUrl = !empty($instance['redirect_url']) ? $instance['redirect_url'] : '';
        ?>
        <p>
            <label for="<?php echo esc_attr($this->get_field_id('title')); ?>">Title:</label>
            <input class="widefat" id="<?php echo esc_attr($this->get_field_id('title')); ?>"
                   name="<?php echo esc_attr($this->get_field_name('title')); ?>" type="text"
                   value="<?php echo esc_attr($title); ?>">
        </p>
        <p>
            <label for="<?php echo esc_attr($this->get_field_id('redirect_url')); ?>">Redirect URL:</label>
            <input class="widefat" id="<?php echo esc_attr($this->get_field_id('redirect_url')); ?>"
                   name="<?php echo esc_attr($this->get_field_name('redirect_url')); ?>" type="text"
                   value="<?php echo esc_attr($redirectUrl); ?>">
        </p>
        <p>
            <label for="<?php echo esc_attr($this->get_field_id('Content')); ?>">Content:</label>
            <textarea class="widefat" id="<?php echo esc_attr($this->get_field_id('content')); ?>"
                      name="<?php echo esc_attr($this->get_field_name('content')); ?>">
                <?php echo esc_textarea($content); ?>
            </textarea>
        </p>
        <?php
    }

    public function update($new_instance, $old_instance)
    {
        $instance = [];
        $instance['title'] = (!empty($new_instance['title'])) ? strip_tags($new_instance['title']) : '';
        $instance['content'] = (!empty($new_instance['content'])) ? wp_kses_post($new_instance['content']) : '';
        $instance['redirect_url'] = (!empty($new_instance['redirect_url'])) ? strip_tags($new_instance['redirect_url']) : '';

        return $instance;
    }
}