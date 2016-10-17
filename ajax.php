<?php
/*
ini_set('display_errors', false);
error_reporting (-1);

include('./wp-load.php');

$action = isset($_GET['action']) ? $_GET['action'] : '';

switch($action){
    case 'wp_ajax_query':
            require_once ("./wp-content/plugins/wp-ajax-query-shortcode/wp-ajax-query-shortcode.php");
            wp_ajax_query();
        die();
    break;
}

header('HTTP/1.0 404 Not Found');
die();
*/