Zane WordPress Plugin Admin Bar
===

v0.3

December, 2013

ZWIP! Admin Bar is a developer's boilerplate plugin that helps you customize the WordPress admin bar with quick links and visually depict which environment you're in, so you don't edit the wrong site.

This is mainly meant for developers who want to modify the admin bar for a client site with fixed links the client should not change. If you want to modify the links through the WordPress GUI I suggest [Custom Admin Bar](http://wordpress.org/plugins/custom-admin-bar/).

by AJ Zane ~ http://AJZane.com or http://github.com/AJZane/zwp-admin-bar


Installation
===
- Drop the zwp-admin-bar directory into your plugins folder
- Activate the plugin through the plugin administration panel
- Once activated, the plugin will not be dispayed on the list of plugins

Usage
===

Modify zwp-admin-bar.php to change what shows up in the admin bar. To change the style of the admin bar for each environment, modify the CSS files in 'styles/'. 

The environment is determined by the WP_ENV constant, which is typically defined in wp-config. If it is not defined, this plugin will set it to 'local'. To add more styles, simply make a new CSS file with the name of the WP_ENV constant.
Right now the options are:

- local (default if the WP_ENV constant has not been defined)
- dev
- stage
- prod

zwp_set_admin_bar_color() determines which CSS file to use based on the WP_ENV constant

zwp_remove_wordpress_admin_bar_links() prevents users from seeing certain options (such as update plugins or moderate comments) if they don't have the role capability to do so

zwp_add_admin_bar_link() adds new tabs to the admin bar for the environment and theme info

You can easily add more functionality to the zwp_admin_bar() function.

Hidden plugin
===

The final section of the plugin hides it from the plugins list. This is to make sure only you setup the plugin, and it will not be deactivated or removed by anyone else.

z_debug
-------

This hooks lets you display debug messages in the production environment. It returns a string (on / off)
	By default, debug messages will be displayed
Function example:
```php
function z_debug(){
	return "on";
	//return "off";
}
add_filter("z_debug", "z_debug");
```
use:

has_filter("z_debug")

apply_filters("z_debug", "")

Bugs & Features
===
Bugs: 

Please add bugs to the GitHub issue queue

http://AJZane.com or http://github.com/AJZane/z-wp-admin-bar/issues

Feature Requests:

If you have feature requests, please email me at androiddreams@AJZane.com

CHANGELOG
===

0.3
- Made this now act as a plugin
- Adds hard-coded tabs for environments and theme info

0.2
- Check if the target css file exists

0.1
- Setup infrastructure. init.php, styles directory (dev.css, prod.css, stage.css)

TO DO:
===

Figure out a better system for Z_Debug. Will also probably have to add an '! if_function_exists' to not interfere with the final version of Z_Debug which is meant to be a completely independent module