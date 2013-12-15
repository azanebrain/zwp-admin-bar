<?php
/**
 * Plugin Name: ZWP Admin Bar
 * Plugin URI: https://github.com/AJZane/zwp-admin-bar
 * Description: Change the color of the admin bar depending on what environment the user is in
 * Version: 0.3
 * Author: AJ Zane
 * Author URI: http://AJZane.com
 * License: GPL2
 */

function z_debug_logic( $args = array() ){
	//arguments:
	//plugin: The plugin that ran into the error
	//message: The error message supplied by the plugin
//run the checks
//return the error string
//if there is no string, say it aint!

	return "\n<strong>ERROR</strong> in " . $args("plugin") . ": \n";

}

function wp_set_admin_bar_color($path_to_z_wp_admin_bar_dir = "functions/") {

	//Figure out the path to the z-wp-admin-bar directory
	if( ! is_child_theme() ){
	    $path_to_z_wp_admin_bar_dir = get_bloginfo('template_directory') . "/";
	} else {
	    $path_to_z_wp_admin_bar_dir = dirname( get_bloginfo('stylesheet_url') ) . "/";
	}//if child_theme

	if( has_filter("z_wp_admin_bar_dir") ) {
		//If the developer has set the path
		$path_to_z_wp_admin_bar_dir = $path_to_z_wp_admin_bar_dir . apply_filters("z_wp_admin_bar_dir", "");
	} else {
		$zwp_admin_bar_default_dir_path = "functions/"; //The default path to the z-wp-admin-bar directory
		$path_to_z_wp_admin_bar_dir = $path_to_z_wp_admin_bar_dir . $zwp_admin_bar_default_dir_path;
	}//if has_filter

	//Now we will see if the target CSS file actually exists.
	//If it does not, we will display an error
	//We find the file by getting the full URL to the path, and using is_file() to see if it is there
	$path_to_z_wp_admin_bar_dir_file = $path_to_z_wp_admin_bar_dir; //First, start with the full URL to the target CSS file
	$path_to_z_wp_admin_bar_dir_file = str_replace( "http://" , "" , $path_to_z_wp_admin_bar_dir_file ); //remove 'http://' 
	$path_to_z_wp_admin_bar_dir_file = str_replace( $_SERVER['HTTP_HOST'] , '' , $path_to_z_wp_admin_bar_dir_file ); //Remove the host name from the URL
	$path_to_z_wp_admin_bar_dir_file = $_SERVER['DOCUMENT_ROOT'] . $path_to_z_wp_admin_bar_dir_file;
	//Add the file path to the website's root
	$path_to_z_wp_admin_bar_dir_file = $path_to_z_wp_admin_bar_dir_file . 'z-wp-admin-bar/styles/'.WP_ENV.'.css'; //add the path to the CSS file (we know it will be z-wp-admin-bar/styles/<the wordpress environment>.css)

	$zwp_adminbar_style_file = $path_to_z_wp_admin_bar_dir . 'z-wp-admin-bar/styles/'.WP_ENV.'.css'; //Create a WordPress-friendly path to the css file for when we enqueue it

	//Now enqueue the stylesheet if it exists:
	if( is_file( $path_to_z_wp_admin_bar_dir_file ) ) {
		// add_action( 'wp_enqueue_scripts', 'wp_set_admin_bar_color' );
		// wp_enqueue_style('admin_bar', $zwp_adminbar_style_file, array(), false, 'all'); 
		wp_enqueue_style('admin_bar', $zwp_adminbar_style_file , array(), false, 'all'); 
	} else if ( 
		! has_filter("z_debug") && 'prod' != WP_ENV
		|| has_filter("z_debug") && "off" != apply_filters("z_debug", "")
		){

		//If the debug has not been set, and the environment is not production: Display the debug message, unless on production (default)
		//If the debug has been set, and is not set to off
		echo "\n<strong>ERROR</strong> in Z WP Admin Bar: Path to style file (" . $zwp_adminbar_style_file . ") cannot be found.\n";
		// echo z_debug_logic( array(
			// "plugin" => "Z WP Admin Bar"
			// , "message" => "Path to style file (" . $zwp_adminbar_style_file . ") cannot be found."
			// ) );
		//The CSS file cannot be found so we will display an error message

		//vvv WARNING:
		//For hardcore debug testing only! This displays the direct path through your server to your css file. This could show hackers the path to your server and should not be used
		// echo "\n<strong>ERROR</strong> in Z WP Admin Bar: Path to style file (" . $path_to_z_wp_admin_bar_dir_file . ") cannot be found.\n";
		//^^^ end_warning

	}//if

}//wp_set_admin_bar_color



// add_action( 'wp_before_admin_bar_render', 'wp_set_admin_bar_color' );
wp_set_admin_bar_color();