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

/* ZWP Debug logic
 * currently a work in progress
 * TODO: ZWP Debug logic
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

/* Set the admin bar color depending on the environment
 */
function zwp_set_admin_bar_color() {
	//See if the target CSS file actually exists.
	//If it does not, we will display an error
	//We find the file by getting the full URL to the path, and using is_file() to see if it is there

	$zwp_adminbar_style_file = plugins_url( 'styles/'.WP_ENV.'.css', __FILE__ ); //the file to enqueue
	$path_to_z_wp_admin_bar_dir_file = plugin_dir_path( __FILE__ ) . 'styles/'.WP_ENV.'.css' ; //the path to the file to test with is_file

	//Now enqueue the stylesheet if it exists:
	if( is_file( $path_to_z_wp_admin_bar_dir_file ) ) {
		// add_action( 'wp_enqueue_scripts', 'wp_set_admin_bar_color' );
		// wp_enqueue_style('admin_bar', $zwp_adminbar_style_file, array(), false, 'all'); 
		wp_enqueue_style('admin_bar', $zwp_adminbar_style_file , array(), false, 'screen'); 
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
		//For hardcore debug testing only! This displays the direct path through your server to your css file. This could show hackers the path to your server and should only be used when you can't figure out why this isn't working
		// echo "\n<strong>ERROR</strong> in Z WP Admin Bar: Path to style file (" . $path_to_z_wp_admin_bar_dir_file . ") cannot be found.\n";
		//^^^ end_warning

	}//if
}

/* Remove stock WordPress menu features:
 * For a list of WordPress user capabilities: http://codex.wordpress.org/Roles_and_Capabilities#Capabilities
 */
function zwp_remove_wordpress_admin_bar_links() {
		global $wp_admin_bar;

		//Only allow users who can update plugins see the notice
		if( ! current_user_can('update_plugins')){
				$wp_admin_bar->remove_menu('updates');
		}
		//Only allow users who can moderate comments see the notice
		if( ! current_user_can('moderate_comments') ){
				$wp_admin_bar->remove_menu('comments');
		}
		//$wp_admin_bar->remove_menu('new-content'); //create a new post/user/etc
		//$wp_admin_bar->remove_menu('my-account'); //My account info on the right side of the menu bar
}


/* Add links to the menu bar
 */
function zwp_add_admin_bar_link() {
		global $wp_admin_bar;

		//Options for editors and up
		if( current_user_can( 'edit_pages' ) ){
			$wp_admin_bar->add_menu( array(
				'id'      => 'environments_link'
				, 'title' => __( 'Environments')
			) );
				$wp_admin_bar->add_menu( array(
					'parent'  => 'environments_link'
					, 'id'    => 'environments-production-link'
					, 'title' => __( 'Production')
					, 'href'  => __( 'http://site.com' )
				));
				$wp_admin_bar->add_menu( array(
					'parent'  => 'environments_link'
					, 'id'    => 'environments-stage-link'
					, 'title' => __( 'Stage')
					, 'href'  => __( 'http://stage.site.com' )
				));
		}//if edit_pages

		//Options for contributors and up
		if( current_user_can( 'edit_posts' ) ){
			$wp_admin_bar->add_menu( array(
				'id'      => 'theme_info_link'
				, 'title' => __( 'Theme info')
			) );
				$wp_admin_bar->add_menu( array(
					'parent'  => 'theme_info_link'
					, 'id'    => 'theme-documentation-link'
					, 'title' => __( 'Documentation')
					, 'href'  => __( 'http://site.com' )
				));
				$wp_admin_bar->add_menu( array(
					'parent'  => 'theme_info_link'
					, 'id'    => 'theme-demo-link'
					, 'title' => __( 'Demo')
					, 'href'  => __( 'http://site.com' )
				));
				$wp_admin_bar->add_menu( array(
					'parent'  => 'theme_info_link'
					, 'id'    => 'theme-support-link'
					, 'title' => __( 'Support')
					, 'href'  => __( 'http://site.com' )
				));
		}//if edit_posts
}

/* Modify the WordPress Admin Bar
 */
add_action( 'wp_before_admin_bar_render', 'zwp_admin_bar' );

function zwp_admin_bar( ) {

	//Only run this code if the admin bar is showing
	if( is_admin_bar_showing() ){

		global $wp_admin_bar;

		//If the WordPress Environment has not been defined, assume local
		if ( 'WP_ENV' == WP_ENV ){
			define('WP_ENV', 'local');
		}

		//Run each function to modify the admin bar
		zwp_set_admin_bar_color();
		zwp_remove_wordpress_admin_bar_links();
		zwp_add_admin_bar_link();
	}//if is_admin_bar_showing

}//wp_set_admin_bar_color

/* Hide this plugin from the plugin list once it is activated
 */
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