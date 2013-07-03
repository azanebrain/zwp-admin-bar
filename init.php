<?php
//Change the color of the admin bar depending on what environment the user is in

function wp_set_admin_bar_color($path_to_z_wp_admin_bar_dir = "functions/") {

	//Figure out the path to the z-wp-admin-bar directory
	if( has_filter("z_wp_admin_bar_dir") ) {
		//If the developer has set the path
		$path_to_z_wp_admin_bar_dir = apply_filters("z_wp_admin_bar_dir", "");
	} else {
		if( ! is_child_theme() ){
		    $path_to_z_wp_admin_bar_dir = get_bloginfo('template_directory') . "/functions/";
		} else {
		    $path_to_z_wp_admin_bar_dir = dirname( get_bloginfo('stylesheet_url') ) . "/functions/";
		}

	}
	
	$zwp_adminbar_style_file = $path_to_z_wp_admin_bar_dir . 'z-wp-admin-bar/styles/'.WP_ENV.'.css';

	//Now enqueue the stylesheet
	wp_enqueue_style('admin_bar', $zwp_adminbar_style_file, array(), false, 'all');

}//wp_set_admin_bar_color

// add_action( 'wp_before_admin_bar_render', 'wp_set_admin_bar_color' );
wp_set_admin_bar_color();