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
}

// register Widget Recent Posts Plugin for Quantox
function register_widget_recent_posts() {
    register_widget( 'Widget_Recent_Posts_Plugin' );
}
add_action( 'widgets_init', 'register_widget_recent_posts' );