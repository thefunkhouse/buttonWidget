<?php

/*
Plugin Name: Button Widget
Plugin URI: http://www.thefunkhouse.co.uk
Description: Allows you to add a button in your sidebar as a call to action.
Author: Lee Doel
Version: 1
Author URI: http://www.thefunkhouse.co.uk
*/


class button_widget extends WP_Widget {
    function button_widget() {
        $widget_ops = array( 'classname' => 'widget_button', 'description' => __( "Button Widget" ) );
        $this->WP_Widget('button_widget', __('Button Widget'), $widget_ops);
    }

    function widget( $args, $instance ) {
        extract($args);
        $text = apply_filters( 'widget_text', $instance['text'], $instance );
        $link = apply_filters( 'widget_text', $instance['link'], $instance );
        echo $before_widget;
        ?>
            <div class="textwidget">
                 <span><a href="<?php echo $link; ?>"><?php echo $text; ?></a></span>
            </div> 
        <?php
        echo $after_widget;
    }

    function update( $new_instance, $old_instance ) {
        $instance = $old_instance;
        if ( current_user_can('unfiltered_html') ){
            $instance['text'] =  $new_instance['text'];
            $instance['link'] =  $new_instance['link'];
        } else {
            $instance['text'] = stripslashes( wp_filter_post_kses( addslashes($new_instance['text']) ) ); // wp_filter_post_kses() expects slashed
            $instance['link'] = stripslashes( wp_filter_post_kses( addslashes($new_instance['link']) ) ); // wp_filter_post_kses() expects slashed
        }
        return $instance;
    }

    function form( $instance ) {
        $instance = wp_parse_args( (array) $instance, array( 'text' => '' ) );
        $text = format_to_edit($instance['text']);
        
        $instance = wp_parse_args( (array) $instance, array( 'link' => '' ) );
        $link = format_to_edit($instance['link']);
?>

        <label>Button Text<input class="widefat" rows="16" cols="20" id="<?php echo $this->get_field_id('text'); ?>" name="<?php echo $this->get_field_name('text'); ?>" value="<?php echo $text; ?>" /></label><br /><br />
        
        <label>Button Link<input class="widefat" rows="16" cols="20" id="<?php echo $this->get_field_id('link'); ?>" name="<?php echo $this->get_field_name('link'); ?>" value="<?php echo $link; ?>" /></label>
<?php
    }
}


function tfh_widgets_init() {
    register_widget( 'button_widget' );
}
add_action( 'widgets_init', 'tfh_widgets_init' );

?>