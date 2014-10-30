<?php

/*
 * Plugin Name: Easy Social Share Buttons for WordPress
* Description: Easy Social Share Buttons automatically adds share bar to your post or pages with support of Facebook, Twitter, Google+, LinkedIn, Pinterest, Digg, StumbleUpon, VKontakte, E-mail. 
* Plugin URI: http://apps.creoworx.com
* Version: 1.0.9
* Author: CreoApps
* Author URI: http://apps.creoworx.com
*/

if (! defined ( 'WPINC' ))
	die ();

define ( 'ESSB_VERSION', '1.0.9' );
define ( 'ESSB_PLUGIN_ROOT', dirname ( __FILE__ ) . '/' );
define ( 'ESSB_PLUGIN_URL', plugins_url () . '/' . basename ( dirname ( __FILE__ ) ) );

define ( 'ESSB_TEXT_DOMAIN', 'essb' );

include (ESSB_PLUGIN_ROOT . 'lib/essb.php');
include (ESSB_PLUGIN_ROOT . 'lib/admin/essb-metabox.php');
register_activation_hook ( __FILE__, array ('EasySocialShareButtons', 'activate' ) );
register_deactivation_hook ( __FILE__, array ('EasySocialShareButtons', 'deactivate' ) );


add_action( 'init', 'essb_load_translations' );
function essb_load_translations() {
	load_plugin_textdomain( ESSB_TEXT_DOMAIN, false, ESSB_PLUGIN_ROOT.'/languages' );
}


global $essb;
$essb = new EasySocialShareButtons();

?>