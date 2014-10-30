<?php


if (!isset($wp_did_header)){
	$wp_did_header = true;
	require_once( dirname(__FILE__) . '/../../../../wp-load.php' );
}

@set_time_limit(9000);

$iPostId = (int)$_GET['postid'];
$fblikecount_shares_count = (int)$_GET['fblikecount_shares_count'];
$fbsharecount_shares_count = (int)$_GET['fbsharecount_shares_count'];

if($iPostId && $fblikecount_shares_count && $fbsharecount_shares_count){
    if(!((int)get_post_meta($iPostId, 'fblikecount_shares_count', true) > $fblikecount_shares_count)){
        if(!add_post_meta($iPostId, 'fblikecount_shares_count', $fblikecount_shares_count, true))                            
            update_post_meta($iPostId, 'fblikecount_shares_count', $fblikecount_shares_count);
    }

    if(!((int)get_post_meta($iPostId, 'fbsharecount_shares_count', true) > $fbsharecount_shares_count)){
        if(!add_post_meta($iPostId, 'fbsharecount_shares_count', $fbsharecount_shares_count, true))
            update_post_meta($iPostId, 'fbsharecount_shares_count', $fbsharecount_shares_count);
    }
}
echo $iPostId, $fblikecount_shares_count, $fbsharecount_shares_count;