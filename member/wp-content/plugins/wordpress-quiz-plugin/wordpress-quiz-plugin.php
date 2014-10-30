<?php
/*
Plugin Name: WordPress Quiz Plugin
Plugin URI: http://www.netconcepts.com/wordpress-quiz-plugin/
Description: Plugin to create multiple choice quizzes for your blog.
Author: Andrew Shell, Netconcepts
Version: 0.1.0
Author URI: http://www.netconcepts.com

Copyright (c) 2007 Andrew Shell (http://blog.andrewshell.org)
and Netconcepts (http://www.netconcepts.com)
WordPress Quiz Plugin is released under the GNU General Public
License (GPL) http://www.gnu.org/licenses/gpl.txt

This is a WordPress plugin (http://wordpress.org).
*/

function wqp_bootstrap()
{
    global $wpdb;

    define('WQP_VERSION', "0.1.0");

    define('WQP_ABSPATH', str_replace("\\", "/", ABSPATH));
    define('WQP_FOLDER', dirname(plugin_basename(__FILE__)));

    //read the options
    $wqp_options = get_option('wqp_options');

    // add database pointers
    $wpdb->wqp_quizzes = $wpdb->prefix . 'wqp_quizzes';

    // Load admin panel
    require_once (dirname(__FILE__) . "/wqp-install.php");
    require_once (dirname(__FILE__) . "/wqp-functions.php");
    require_once (dirname(__FILE__) . "/admin/admin.php");

    add_filter('the_content', 'wqp_the_content');
    add_filter('the_title', 'wqp_the_title');
    add_filter('wp_title', 'wqp_the_title');
    add_filter('plugins_loaded', 'wqp_plugins_loaded');
}

wqp_bootstrap();