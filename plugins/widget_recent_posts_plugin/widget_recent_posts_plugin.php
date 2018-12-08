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
        $post_number = ( ! empty( $instance[ 'post_number' ] ) ) ? $instance[ 'post_number' ] : -1;
        $display_thumbnail = isset( $instance[ 'display_thumbnail' ] ) ? $instance[ 'display_thumbnail' ] : false;
        
        if ( $title ) {
            ?>
            <div style="width: 100%;">
            <?php
            echo $args[ 'before_title' ];
            echo $title;
            echo $args[ 'after_title' ];
            ?>
            </div>
            <?php
        }
        
	/*preparing new query*/
        $post_args = array(
            'posts_per_page'      => $post_number,
            'post_status'         => 'publish',
            'ignore_sticky_posts' => true,
        );
        $new_query = new WP_Query( apply_filters( 'widget_posts_args', $post_args ) );
        
        if ( $new_query->have_posts() ) :
            while ( $new_query->have_posts() ) : $new_query->the_post(); 
        ?>
        <div style=" margin-top: 30px;">
            <a> <?php echo get_the_title(); ?> </a>
            <?php if ( $display_thumbnail ){ ?>
                <div style="max-width: 50%;">    <?php echo get_the_post_thumbnail();?></div>
            <?php } ?>
            
            <p><?php echo get_the_excerpt(); ?></p>
        </div>
        <?php
            endwhile;
            // Reset the global $the_post
            wp_reset_postdata();
        endif;
    }
    		
    
    /* Back-end widget form.*/
    public function form( $instance ) {
        $title = isset( $instance[ 'title' ] ) ? esc_html( $instance[ 'title' ] ) : __( 'New title', 'namespace' );
        $post_number = isset( $instance[ 'post_number' ] ) ?  $instance[ 'post_number' ] : 4;
        $display_thumbnail = isset( $instance[ 'display_thumbnail' ] ) ? (bool) $instance[ 'display_thumbnail' ] : false;
        ?>
        <p>
            <label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php echo _e( 'Title: ', 'namespace' ); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>"
                   name="<?php echo $this->get_field_name( 'title' ); ?>"
                   type="text"
                   value="<?php echo esc_html( $title ); ?>">
	</p>
        
        <p>
            <label for="<?php echo $this->get_field_id( 'post_number' ); ?>"><?php _e( 'Number of posts:', 'namespace' ); ?></label>
            <input id="<?php echo $this->get_field_id( 'post_number' ); ?>"
                   name="<?php echo $this->get_field_name( 'post_number' ); ?>"
                   type="number"
                   min="1"
                   value="<?php echo $post_number; ?>"
                   size="4"/>
        </p>
        
        <p>
            <input class="checkbox" type="checkbox" <?php checked( $display_thumbnail ); ?>
                   id="<?php echo $this->get_field_id( 'display_thumbnail' ); ?>"
                   name="<?php echo $this->get_field_name( 'display_thumbnail' ); ?>"/>
            <label for="<?php echo $this->get_field_id( 'display_thumbnail' ); ?>"><?php _e( 'Show post thumbnail', 'namespace' ); ?></label>
	</p>
    <?php
    }
    
    /* Sanitize widget form values as they are saved.*/
    public function update( $new_instance, $old_instance ) {
        $instance[ 'title' ] = ( ! empty ( $new_instance[ 'title' ] ) ) ? strip_tags( $new_instance[ 'title' ] ) : '';
        $instance[ 'post_number' ] = ( ! empty ( $new_instance[ 'post_number' ] ) ) ? $new_instance[ 'post_number' ]  : '';
        $instance[ 'display_thumbnail' ] = isset( $new_instance[ 'display_thumbnail' ] ) ? (bool) $new_instance[ 'display_thumbnail' ] : false;
        
        return $instance;
        
    }
    
        
        
        
}

// register Widget Recent Posts Plugin for Quantox
function register_widget_recent_posts() {
    register_widget( 'Widget_Recent_Posts_Plugin' );
}
add_action( 'widgets_init', 'register_widget_recent_posts' );