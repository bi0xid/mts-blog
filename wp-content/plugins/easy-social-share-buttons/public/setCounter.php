<?php

if (!isset($wp_did_header)){
	$wp_did_header = true;
	require_once( dirname(__FILE__) . '/../../../../wp-load.php' );
}

$sAction = (string)((isset($_GET['action']) && $_GET['action']) ? $_GET['action'] : '');
$sType = (string)((isset($_GET['type']) && $_GET['type']) ? $_GET['type'] : '');
$iPostId = (int)((isset($_GET['iPostId']) && $_GET['iPostId']) ? $_GET['iPostId'] : 0);

if(!in_array($sAction, array('getCount', 'setCount'))) die();
if(!in_array($sType, array('mail', 'digg'))) die();

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
die();