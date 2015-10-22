<?php

if (!isset($wp_did_header)){
	$wp_did_header = true;
	require_once( dirname(__FILE__) . '/../../../../wp-load.php' );
}

@set_time_limit(9000);

//if(php_sapi_name() != 'cli'){
//    header('HTTP/1.0 404 Not Found');
//    die();
//}


function getGplusShares($url)
{
    $buttonUrl = sprintf('https://plusone.google.com/u/0/_/+1/fastbutton?url=%s', urlencode($url));

    $htmlData  = file_get_contents($buttonUrl);    
    $iCounter = 0;
    if(preg_match('/<div[^>]*aggregateCount[^>]*>(?P<Counter>[\d]+)<\/div>/', $htmlData, $match))
            
    $iCounter = (int)$match['Counter'];

    if($iCounter)            
        return $iCounter;

    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, "https://clients6.google.com/rpc");
    curl_setopt($curl, CURLOPT_POST, 1);
    curl_setopt($curl, CURLOPT_POSTFIELDS, '[{"method":"pos.plusones.get","id":"p","params":{"nolog":true,"id":"' . $url . '","source":"widget","userId":"@viewer","groupId":"@self"},"jsonrpc":"2.0","key":"p","apiVersion":"v1"}]');
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-type: application/json'));
    $curl_results = curl_exec ($curl);
    curl_close ($curl);            
    $json = json_decode($curl_results, true);

    return intval( $json[0]['result']['metadata']['globalCounts']['count'] );
}

function getStumbleShares($url){
    $content = file_get_contents("http://www.stumbleupon.com/services/1.01/badge.getinfo?url=$url");
    $result = json_decode($content);
    if ( isset($result->result->views )) {
            return $result->result->views;
    }
    
    return 0;
}

$aPosts = get_posts(array('numberposts' => -1,
                          'post_status' => 'publish'));

$aLinksArray = array();

foreach($aPosts as $aPost){
    
    $sCheckingUrl = get_the_permalink($aPost->ID);
    
    $aLinksArray[$sCheckingUrl] = array('id' => $aPost->ID, 'url' => $sCheckingUrl);

    //$sTwitterUrl	= "http://cdn.api.twitter.com/1/urls/count.json?url={$sCheckingUrl}&callback=?";
    $sDeliciousUrl      = "http://feeds.delicious.com/v2/json/urlinfo/data?url={$sCheckingUrl}&callback=?";
    $sPinterestUrl      = "http://api.pinterest.com/v1/urls/count.json?&url={$sCheckingUrl}";            
    
    //$sTwitterContent = file_get_contents($sTwitterUrl);
    //$sTwitterContent = ($sTwitterContent) ? $sTwitterContent : '';
    //$oTwitterContent = json_decode($sTwitterContent);
    //$iTwitterCount = (int)(isset($oTwitterContent->count) ? $oTwitterContent->count : 0);
    
    $sDeliciousContent = file_get_contents($sDeliciousUrl);
    $sDeliciousContent = ($sDeliciousContent) ? $sDeliciousContent : '';
    $oDeliciousContent = json_decode($sDeliciousContent);
    $iDeliciousCount = (int)(isset($oDeliciousContent->count) ? $oDeliciousContent->count : 0);
        
    $sPinterestContent = file_get_contents($sPinterestUrl);
    $sPinterestContent = ($sPinterestContent) ? $sPinterestContent : '';
    preg_match('/[^\d]*(?P<count>\d+)/', $sPinterestContent, $aMatches);    
    $iPinterestCount = (int)(isset($aMatches['count']) ? $aMatches['count'] : 0);
    
    $iGoogleCount = (int)getGplusShares($sCheckingUrl);
    
    $iStumbleCount = (int)getStumbleShares($sCheckingUrl);
    
    //if(!((int)get_post_meta($iPostId, 'twitter_shares_count', true) > $iTwitterCount)){
    //    if(!add_post_meta($aPost->ID, 'twitter_shares_count', $iTwitterCount, true))
    //        update_post_meta($aPost->ID, 'twitter_shares_count', $iTwitterCount);
    //}
    
    if(!((int)get_post_meta($iPostId, 'delicious_shares_count', true) > $iDeliciousCount)){
        if(!add_post_meta($aPost->ID, 'delicious_shares_count', $iDeliciousCount, true))
            update_post_meta($aPost->ID, 'delicious_shares_count', $iDeliciousCount);
    }
        
    if(!((int)get_post_meta($iPostId, 'pinterest_shares_count', true) > $iPinterestCount)){
        if(!add_post_meta($aPost->ID, 'pinterest_shares_count', $iPinterestCount, true))
            update_post_meta($aPost->ID, 'pinterest_shares_count', $iPinterestCount);
    }
    
    if(!((int)get_post_meta($iPostId, 'google_shares_count', true) > $iGoogleCount)){
        if(!add_post_meta($aPost->ID, 'google_shares_count', $iGoogleCount, true))
            update_post_meta($aPost->ID, 'google_shares_count', $iGoogleCount);
    }
    
    if(!((int)get_post_meta($iPostId, 'stumble_shares_count', true) > $iStumbleCount)){
        if(!add_post_meta($aPost->ID, 'stumble_shares_count', $iStumbleCount, true))
            update_post_meta($aPost->ID, 'stumble_shares_count', $iStumbleCount);
    }    
}

$aNewLinksArray = array();
$aStringsParts = array();

foreach($aLinksArray as $link => $array){
    
    $aTmpStringsParts = $aStringsParts;
    
    $aStringsParts[] = '"' . $link . '"';
    
    /* check max url size (8126) */
    if(strlen(implode(',', $aStringsParts)) > 6500){
        $aNewLinksArray[] = $aTmpStringsParts;
        $aStringsParts = array();
        $aStringsParts[] = '"' . $link . '"';
    }
}

$aNewLinksArray[] = $aStringsParts;

foreach($aNewLinksArray as $links){
    if($links && !empty($links)){  
        $sCheckingUrl = implode(',', $links);
        $sCheckingUrl = urlencode($sCheckingUrl);
        $sFacebookUrl = "https://graph.facebook.com/fql?q=SELECT%20url,%20like_count,%20total_count,%20share_count,%20click_count,%20comment_count%20FROM%20link_stat%20WHERE%20url%20IN%20({$sCheckingUrl})";
        $sFacebookContent = file_get_contents($sFacebookUrl);
        $oFacebookContent = json_decode($sFacebookContent);

        if(isset($oFacebookContent->error)){
            /*  add proxy */
            continue;
        }
        
        if(isset($oFacebookContent->data)){
            foreach($oFacebookContent->data as $value){
                
                $sFacebookUrl = (isset($value->url) ? $value->url : '');
                
                $iPostId = isset($aLinksArray[$sFacebookUrl]) ? (int)$aLinksArray[$sFacebookUrl]['id'] : 0;
                
                $iFacebookLikeCount = (int)(isset($value->total_count) ? $value->total_count : 0);
                $iFacebookShareCount = (int)(isset($value->share_count) ? $value->share_count : 0);
                
                if($iPostId && $sFacebookUrl){                    
                    if(!((int)get_post_meta($iPostId, 'fblikecount_shares_count', true) > $iFacebookLikeCount)){
                        if(!add_post_meta($iPostId, 'fblikecount_shares_count', $iFacebookLikeCount, true))                            
                            update_post_meta($iPostId, 'fblikecount_shares_count', $iFacebookLikeCount);
                    }
                    
                    if(!((int)get_post_meta($iPostId, 'fbsharecount_shares_count', true) > $iFacebookShareCount)){
                        if(!add_post_meta($iPostId, 'fbsharecount_shares_count', $iFacebookShareCount, true))
                            update_post_meta($iPostId, 'fbsharecount_shares_count', $iFacebookShareCount);
                    }
                }
            }
        }
    }
}

echo "Social counters was updated";
header('HTTP/1.0 404 Not Found');
die();