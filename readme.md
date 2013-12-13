Zane WordPress Plugin Admin Bar
===

v0.1
July, 2013

ZWIP! Admin Bar is a developer's boilerplate mu-plugin that helps you customize the WordPress admin bar with quick links and visually depict which environment you're in, so you don't edit the wrong site.

by AJ Zane ~ http://AJZane.com or http://github.com/AJZane/z-wp-admin-bar


Usage
===

1) Use the php include() function to add the init.php file to your theme's functions.php file. 

NOTE: By default, the path to the file is a directory named 'functions' in your theme folder (such as: twentytwelve/functions/z-wp-admin-bar)

```php
include('functions/z-wp-admin-bar/init.php');
```

2) Set the WordPress_Environment in wp-config.php

```php
define('WP_ENV', 'dev');
// define('WP_ENV', 'stage');
// define('WP_ENV', 'prod');
```

You can also set a custom environment

3) Modify the CSS file in the styles directory to have the color you want. 

By default:
- dev: green
- stage: blue
- alpha: purple
- prod: red

To add more environments, just create a new CSS file with the same filename as the WP_ENV variable

Hooks
===

z_wp_admin_bar_dir
------------------

This hook lets you change the directory to the z-wp-admin-bar directory

Function example:
```php
function modify_z_wp_admin_bar_dir(){
	//Note that the path ends in a trailing slash
	return "path/to/dir/";
}
```
add_filter("z_wp_admin_bar_dir", "modify_z_wp_admin_bar_dir");

use:

has_filter("z_wp_admin_bar_dir")

apply_filters("z_wp_admin_bar_dir", "")

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

Example
===

The current theme's functions.php has:

```php
get_template_part('functions/z-wp-admin-bar/init');
```
wp-config.php has:
```php
define('WP_ENV', 'alpha');
```

Add a CSS file to your theme's folder with a name that matches WP_ENV

Filepath: functions/z-wp-admin-bar/styles/alpha.css

That stylesheet's code:
```css
#wpadminbar{ 
	background: purple !important;
}
```

Bugs & Features
===
Bugs: 

Please add bugs to the GitHub issue queue

http://AJZane.com or http://github.com/AJZane/z-wp-admin-bar/issues

Feature Requests:

If you have feature requests, please email me at androiddreams@AJZane.com

CHANGELOG
===

0.1
Setup infrastructure. init.php, styles directory (dev.css, prod.css, stage.css)

TO DO:
===

0.2
Check if the target css file exists

Add links to each environment
Add link to github
