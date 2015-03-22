<?php
/*
 * here we handle request from page by GET method nad from iPhone app by POST method.
 * TODO: changes method to POST on the page.
 */

if (!isset($wp_did_header)){
	$wp_did_header = true;
	require_once( dirname(__FILE__) . '/../../../../wp-load.php' );
}

$sAction = (string)((isset($_GET['action']) && $_GET['action']) ? $_GET['action'] : '');
$sType = (string)((isset($_GET['type']) && $_GET['type']) ? $_GET['type'] : '');
$iPostId = (int)((isset($_GET['iPostId']) && $_GET['iPostId']) ? $_GET['iPostId'] : 0);

if(!$sAction){
    $sAction = (string)((isset($_POST['action']) && $_POST['action']) ? $_POST['action'] : '');
}

if($sAction == 'setCount' && !$sType && !$iPostId){
    $sType = (string)((isset($_POST['type']) && $_POST['type']) ? $_POST['type'] : '');
    $iPostId = ((isset($_POST['iPostId']) && $_POST['iPostId']) ? $_POST['iPostId'] : '');
    //meas that we got url
    if((string)(int)$iPostId !== (string)$iPostId){
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
            $iPostId = $tmpPost->ID;
        }
    }
    
}

$iPostId = (int)$iPostId;

if(!in_array($sAction, array('getCount', 'setCount'))) die('Error');
if(!in_array($sType, array('mail', 'digg'))) die('Error');

//Check if post exist.
if ( FALSE === get_post_status( $iPostId ) ) {
   die('Error');
} 

$sPostMetaName = $sType.'_post_type';
$iPostCount = (int)get_post_meta($iPostId, $sPostMetaName, true);

switch ($sAction){
    case 'setCount':
        if(!update_post_meta($iPostId, $sPostMetaName, $iPostCount + 1)) add_post_meta($iPostId, $sPostMetaName, $iPostCount + 1);
        die('Ok');
    break;
    case 'getCount':
        $aResult = array('count' => $iPostCount, 'post_id' => $iPostId);
        header('content-type: application/json');
        die(json_encode($aResult));
    break;
}
header('HTTP/1.0 404 Not Found');
die('Error');