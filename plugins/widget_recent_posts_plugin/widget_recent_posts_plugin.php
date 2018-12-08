<?php

/*
Plugin Name: Widget Recent Posts Plugin for Quantox
Description: Custom recent posts for widget area plugin
Author: Zarko Stojadinovic
Version: 1.0.0
Author URI: http://www.arcs.org.rs
*/


class Widget_Recent_Posts_Plugin extends WP_Widget {
    
    
    function __construct() {
		parent::__construct(

			// base ID of the widget
			'widget_recent_posts_plugin',

			// name of the widget
			__( 'Widget Recent Posts Plugin for Quantox', 'namespace' ),

			// widget options
			array ( 'description' => __( 'Widget that displays recent posts', 'namespace' ) ) );
        
    }
    
    /*Front-end of widget.*/
    public function widget( $args, $instance ) {
        $title = ( ! empty( $instance[ 'title' ] ) ) ? $instance[ 'title' ] : '';
        
        if ( $title ) {
            echo $args[ 'before_title' ];
            echo $title;
            echo $args[ 'after_title' ];
        }
    }
    		
    
    /* Back-end widget form.*/
    public function form( $instance ) {
        $title = isset( $instance[ 'title' ] ) ? esc_html( $instance[ 'title' ] ) : __( 'New title', 'namespace' );
        ?>
        <p>
            <label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php echo _e( 'Title: ', 'namespace' ); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>"
                   name="<?php echo $this->get_field_name( 'title' ); ?>"
                   type="text"
                   value="<?php echo esc_html( $title ); ?>">
	</p>
    <?php    
    }
    
    /* Sanitize widget form values as they are saved.*/
    public function update( $new_instance, $old_instance ) {
        $instance[ 'title' ] = ( ! empty ( $new_instance[ 'title' ] ) ) ? strip_tags( $new_instance[ 'title' ] ) : '';
        
        return $instance;
        
    }
    
        
        
        
}

// register Widget Recent Posts Plugin for Quantox
function register_widget_recent_posts() {
    register_widget( 'Widget_Recent_Posts_Plugin' );
}
add_action( 'widgets_init', 'register_widget_recent_posts' );