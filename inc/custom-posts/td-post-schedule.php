<?php

	function post_type_schedule() {
		$labels = array(
	    	'name' => _x('Schedule', 'post type general name', 'themesdojo'),
	    	'singular_name' => _x('Schedule', 'post type singular name', 'themesdojo'),
	    	'add_new' => _x('Add New Day', 'book', 'themesdojo'),
	    	'add_new_item' => __('Add New Day', 'themesdojo'),
	    	'edit_item' => __('Edit Day', 'themesdojo'),
	    	'new_item' => __('New Day', 'themesdojo'),
	    	'view_item' => __('View Day', 'themesdojo'),
	    	'search_items' => __('Search Days', 'themesdojo'),
	    	'not_found' =>  __('No Days found', 'themesdojo'),
	    	'not_found_in_trash' => __('No Days found in Trash', 'themesdojo'), 
	    	'parent_item_colon' => ''
		);		
		$args = array(
	    	'labels' => $labels,
	    	'public' => true,
	    	'publicly_queryable' => true,
	    	'show_ui' => true, 
	    	'query_var' => true,
	    	'rewrite' => true,
	    	'capability_type' => 'post',
	    	'hierarchical' => false,
	    	'menu_position' => null,
	    	'supports' => array('title'),
	    	'menu_icon' => 'dashicons-menu'
		); 		

		register_post_type( 'day', $args );						  
	} 
									  
	add_action('init', 'post_type_schedule');


?>