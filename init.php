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
	
	$path_to_z_wp_admin_bar_dir = "/cms/wp-content/themes/watson2012/functions/";
	// $zwp_adminbar_style = $GLOBALS['template_directory'] . "/" . $path_to_z_wp_admin_bar_dir . 'z-wp-admin-bar/styles/'.WP_ENV.'.css';
	$zwp_adminbar_style_file = $path_to_z_wp_admin_bar_dir . 'z-wp-admin-bar/styles/'.WP_ENV.'.css';

	echo "stylesheet dir: ". get_bloginfo('stylesheet_url')."!<br>\n";
	echo "dirnam of that: " .dirname( get_bloginfo('stylesheet_url') )."!<br>\n";
	echo "adminbar string: <b>".$zwp_adminbar_style."</b>!<br>\n";
	echo "is file : ".   is_file( $zwp_adminbar_style_file ) . " ! <BR>\n";
	echo "file_exists : ".   file_exists( $zwp_adminbar_style ) . " ! <BR>\n";
	// echo "fopen : ".   fopen( $zwp_adminbar_style , 'r' ) . " ! <BR>\n";

	//Now enqueue the stylesheet if it exists:
	if( is_file( $zwp_adminbar_style_file ) ) {
		// add_action( 'wp_enqueue_scripts', 'wp_set_admin_bar_color' );
		wp_enqueue_style('admin_bar', $zwp_adminbar_style_file, array(), false, 'all'); 
	} else if ( 
		! has_filter("z_debug") && 'prod' != WP_ENV
		|| has_filter("z_debug") && "off" != apply_filters("z_debug", "")
		){
		// has_filter("z_debug") && "on" == apply_filters("z_debug", "")
		// || WP_ENV != 'prod' && "off" != apply_filters("z_debug", "")

//If the debug has not been set, and the environment is not production: Display the debug message, unless on production (default)
//If the debug has been set, and is not set to off

		//The CSS file cannot be found
		//display an error message
		echo "\n<strong>ERROR</strong> in Z WP Admin Bar: Path to style file (" . $zwp_adminbar_style_file . ") cannot be found.\n";
	}//if


}//wp_set_admin_bar_color


/* TEST AREA
 * Testing the hooks
 */

function modify_z_wp_admin_bar_dir(){
	//Note that the path ends in a trailing slash
	return "functions/";
}
//add_filter("z_wp_admin_bar_dir", "modify_z_wp_admin_bar_dir");

function z_debug(){
	// return "on";
	//return "off";
	// return "ha!";
}

add_filter("z_debug", "z_debug");


// add_action( 'wp_before_admin_bar_render', 'wp_set_admin_bar_color' );
wp_set_admin_bar_color();