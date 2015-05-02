<?php
/*
 * here we handle request from page by GET method nad from iPhone app by POST method.
 * TODO: changes method to POST on the page.
 */
ini_set('display_errors', false);
error_reporting (-1);

if (!isset($wp_did_header)){
	$wp_did_header = true;
	require_once( dirname(__FILE__) . '/../../../../wp-load.php' );
}

$sAction = (string)((isset($_GET['action']) && $_GET['action']) ? $_GET['action'] : 'setCount');
$sType = (string)((isset($_GET['type']) && $_GET['type']) ? $_GET['type'] : '');
$PostId = (isset($_GET['iPostId']) && $_GET['iPostId']) ? $_GET['iPostId'] : false;

if(!in_array($sAction, array('getCount', 'setCount'))) die('Error');
if(!in_array($sType, array('mail', 'digg'))) die('Error');
if(!$PostId) die('Error');

/* we got url */
if((string)(int)$PostId !== (string)$PostId){
    $args=array(
        'name' => $iPostId,
        'post_type' => 'post',
        'post_status' => 'publish',
        'posts_per_page' => 1,
        'caller_get_posts'=> 1
      );
    $aPost = get_posts( $args );
    
    if(isset($aPost[0])){
        $tmpPost = $aPost[0];
        $PostId = $tmpPost->ID;
    }
}

$post = get_post($PostId);

if(!$post || !property_exists($post, 'ID') || !$post->ID){
    die('Error');
}

$iPostId = (int)$post->ID;
$postStatus = get_post_status($iPostId);

//Check if post exist.
if ( FALSE === $postStatus || $postStatus != 'publish') {
   die('Error');
} 

$sPostMetaName = $sType.'_post_type';

$iPostCount = (int)get_post_meta($iPostId, $sPostMetaName, true);

if(!update_post_meta($iPostId, $sPostMetaName, $iPostCount + 1)) {
    add_post_meta($iPostId, $sPostMetaName, $iPostCount + 1);
    die('Ok');
}else{
    die('Ok');
}      

header('HTTP/1.0 404 Not Found');
die('Error');