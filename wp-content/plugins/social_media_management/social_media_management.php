<?php

/*
Plugin Name: MyTinySecrets Social Media Management
Description: Take control of the shares and likes
Author: Alejandro Orta
Version: 0.9.9
Author URI: alejandro@mytinysecrets.com
*/

if ( !defined( 'FACEBOOK_SDK_PLUGIN_DIR' ) ) {
	$plugin_dir = plugin_dir_path( __FILE__ );
	define( 'FACEBOOK_SDK_PLUGIN_DIR', $plugin_dir );
}

require_once FACEBOOK_SDK_PLUGIN_DIR.'/vendor/autoload.php';
require FACEBOOK_SDK_PLUGIN_DIR.'/class/social-sdk-class.php';

class MtsFacebookSdf {
	function __construct() {
		$social_sdk_class = new SocialSdkClass();

		add_action( 'admin_menu', array( $this, 'facebook_posts_shares' ) );
		add_action( 'admin_enqueue_scripts', array( $this, 'load_custom_wp_admin_assets' ));
	}

	public function facebook_posts_shares() {
		add_dashboard_page( 'Posts Social Media Settings', 'Posts Social Media Settings', 'activate_plugins', 'facebook_posts_shares', array( $this, 'posts_shares_page' ) );
	}

	public function posts_shares_page() {
		include( FACEBOOK_SDK_PLUGIN_DIR.'/templates/shares-dashboard.php' );
	}

	public function load_custom_wp_admin_assets() {
		wp_register_style( 'admin-style', get_template_directory_uri() . '/css/admin-style.css', false, '0.5.0' );
		wp_register_script( 'admin-scripts', get_template_directory_uri() . '/js/admin-script.js', false, '0.5.0', true );

		wp_enqueue_style( 'admin-style' );
		wp_enqueue_script( 'admin-scripts' );
	}
}

$mts_facebook_sdk = new MtsFacebookSdf();
