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
	//See if the target CSS file actually exists.
	//If it does not, we will display an error
	//We find the file by getting the full URL to the path, and using is_file() to see if it is there

	$zwp_adminbar_style_file = plugins_url( 'styles/'.WP_ENV.'.css', __FILE__ ); //the file to enqueue
	$path_to_z_wp_admin_bar_dir_file = plugin_dir_path( __FILE__ ) . 'styles/'.WP_ENV.'.css' ; //the path to the file to test with is_file

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


//Hide this plugin from the plugin list once it is activated
add_filter( 'all_plugins', 'hide_zwp_admin_bar_from_plugin_list' );

function hide_zwp_admin_bar_from_plugin_list( $plugins ) {
    unset( $plugins[ 'zwp-admin-bar/zwp-admin-bar.php' ] );
    return $plugins;
}

/*  Copyright 2013 AJ Zane  (email : androiddreams@AJZane.com)

	This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation; either version 2 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License along
    with this program; if not, write to the Free Software Foundation, Inc.,
    51 Franklin Street, Fifth Floor, Boston, MA 02110-1301 USA.
*/