<?php
ob_start();
if (!isset($wp_did_header)){
	$wp_did_header = true;
	require_once( dirname(__FILE__) . '/../../../../wp-load.php' );
}
$sCacheFilePath = dirname(__FILE__) . DIRECTORY_SEPARATOR . 'cache' . DIRECTORY_SEPARATOR;
$aAction = (isset($_GET['action']) && $_GET['action']) ? $_GET['action'] : '';

if($aAction == 'getForHomePage'){
    $aPostsIds = (array)$_GET['posts'];
    $aPostsIds = array_map('intval', $aPostsIds);
    
    $sFilePath = $sCacheFilePath . "getForHomePage_".  implode('-', $aPostsIds).".txt";
    if(file_exists($sFilePath) &&
            filemtime($sFilePath) > (time() - 180)){
        die(file_get_contents($sFilePath));
    }
    
    $args = array('post__in' => $aPostsIds, 'posts_per_page'   => count($aPostsIds));
    $posts = get_posts($args);
    $aResult = array();
    
    foreach ($posts as $post ){
        setup_postdata($post);
        ob_end_clean();
        ob_start();
        $sPermaLink = get_the_permalink();
        $sPostTitle = get_the_title();
        $sSiteUrl = get_site_url();
        $iPostId = get_the_ID();

        $iFBLikes = (int)get_post_meta($iPostId, 'fblikecount_shares_count', true);
        $iFBShares = (int)get_post_meta($iPostId, 'fbsharecount_shares_count', true);
        $iTweeterShares = (int)get_post_meta(get_the_ID(), 'twitter_shares_count', true);
        $iGoogleShares = (int)get_post_meta(get_the_ID(), 'google_shares_count', true); 
        $iPinterestShares = (int)get_post_meta(get_the_ID(), 'pinterest_shares_count', true);
        $iStumbleShares = (int)get_post_meta(get_the_ID(), 'stumble_shares_count', true);
        $iDiggShares = (int)get_post_meta(get_the_ID(), 'digg_post_type', true);
        $iMailShares = (int)get_post_meta(get_the_ID(), 'mail_post_type', true);

        $aSharesArray = array('iFBLikes' => $iFBLikes,
                    'iFBShares' => $iFBShares,
                    'iTweeterShares' => $iTweeterShares,
                    'iGoogleShares' => $iGoogleShares,
                    'iPinterestShares' => $iPinterestShares,
                    'iStumbleShares' => $iStumbleShares,
                    'iDiggShares' => $iDiggShares,
                    'iMailShares' => $iMailShares);                                            
        arsort($aSharesArray);
        $aSharesArray = array_slice($aSharesArray, 0, 4);

        if(!in_array('iGoogleShares', array_keys($aSharesArray))){
            $iLastElemnt = end($aSharesArray);
            if(!$iLastElemnt){
                $aSharesArray = array_slice($aSharesArray, 0, 3);
                $aSharesArray['iGoogleShares'] = $iGoogleShares;
            }
        }

        $aSharesArray = array_keys($aSharesArray);                                        



        if(!defined('ESSB_PLUGIN_URL')){
            define('ESSB_PLUGIN_URL', "{$sSiteUrl}/wp-content/plugins/easy-social-share-buttons");
        }
    ?>
    <input type='hidden' value='<?php echo ESSB_PLUGIN_URL; ?>' id='additonal_easy_share_button_url' style="display: none; visibility: hidden;">
    <ul class="essb_links1">
        <?php if(in_array('iFBLikes', $aSharesArray)): ?>
            <li class="essb_item1 essb_link_facebook fb_custom_likeit">
                <a onclick="return false;" 
                    rel="nofollow"
                    title="Likes this article on Facebook">
                    <span class='essb_icon'></span>
                    <span></span>
                    Likes
                </a>
                <span class="fbLikeIt essb_counter1"><?php echo number_format($iFBLikes, 0, ',', '.'); ?></span>
            </li>
        <?php endif; ?>

        <?php if(in_array('iFBShares', $aSharesArray)): ?>
            <li class="essb_item1 essb_link_facebook fb_custom_share">
                <a onclick="custom_social_window('https://www.facebook.com/sharer/sharer.php?u=<?php echo $sPermaLink; ?>'); return false;"
                    href="https://www.facebook.com/sharer/sharer.php?u=<?php echo $sPermaLink; ?>" 
                    rel="nofollow"
                    title="Share this article on Facebook">
                    <span class='essb_icon'></span>
                    Share
                </a>
                <span class="fbCounter essb_counter1"><?php echo number_format($iFBShares, 0, ',', '.'); ?></span>
            </li>
        <?php endif; ?>

        <?php if(in_array('iTweeterShares', $aSharesArray)): ?>
            <li class="essb_item1 essb_link_twitter twitter_custom_share">
                <a onclick="custom_social_window('https://twitter.com/intent/tweet?source=webclient&amp;original_referer=<?php echo $sPermaLink; ?>&amp;text=<?php echo $sPostTitle; ?>&amp;url=<?php echo $sPermaLink; ?>'); return false;"
                    href="#" 
                    rel="nofollow" 
                    title="Share this article on Twitter" 
                    >
                    <span class='essb_icon'></span>
                    Tweet                                                    
                </a>
                <span class="twitterCounter essb_counter1"><?php echo number_format($iTweeterShares, 0, ',', '.') ?></span>
            </li>
        <?php endif; ?>

        <?php if(in_array('iGoogleShares', $aSharesArray)): ?>
            <li class="essb_item1 essb_link_google google_custom_share">
                <a href='#'
                    onclick="custom_social_window('https://plus.google.com/share?url=<?php echo $sPermaLink; ?>'); return false;"
                    href="https://plus.google.com/share?url=<?php echo $sPermaLink; ?>" 
                    rel="nofollow"
                    title="Share this article on Google+">
                    <span class='essb_icon'></span>
                    <span class="essb_network_name">Google+</span>
                </a>
                <span class="googleCounter essb_counter1"><?php echo number_format($iGoogleShares, 0, ',', '.'); ?></span>
            </li>       
        <?php endif; ?>

        <?php if(in_array('iPinterestShares', $aSharesArray)): ?>
            <li class="essb_item1 essb_link_pinterest pinterest_custom_share">
                <a href="javascript:void((function(){var%20e=document.createElement('script');e.setAttribute('type','text/javascript');e.setAttribute('charset','UTF-8');e.setAttribute('src','http://assets.pinterest.com/js/pinmarklet.js?r='+Math.random()*99999999);document.body.appendChild(e)})());" rel="nofollow" title="Share an image of this article on Pinterest">
                    <span class='essb_icon'></span>
                    <span class="essb_network_name">Pinterest</span>
                </a>
                <span class="pinterestCounter essb_counter1"><?php echo number_format($iPinterestShares, 0, ',', '.'); ?></span>
            </li>
        <?php endif; ?>

        <?php if(in_array('iStumbleShares', $aSharesArray)): ?>   
            <li class="essb_item1 essb_link_stumbleupon stumbleupon_custom_share">
                <a href="http://www.stumbleupon.com/badge/?url=<?php echo $sPermaLink; ?>" 
                   rel="nofollow" 
                   title="Share this article on StumbleUpon"
                   onclick="custom_social_window('http://www.stumbleupon.com/badge/?url=<?php echo $sPermaLink; ?>'); return false;">
                    <span class='essb_icon'></span>
                    <span class="essb_network_name">StumbleUpon</span>
                </a>
                <span class="stumbleCounter essb_counter1"><?php echo number_format($iStumbleShares, 0, ',', '.'); ?></span>
            </li>
        <?php endif; ?>

        <?php if(in_array('iDiggShares', $aSharesArray)): ?>
            <li class="essb_item1 essb_link_digg digg_custom_share">
                <input type='hidden' value='<?php echo get_the_ID(); ?>' id='home_page_post_id' style="display: none; visibility: hidden;">
                <a href='http://digg.com/submit?phase=2%20&amp;url=<?php echo $sPermaLink; ?>&amp;title=<?php echo $sPostTitle; ?>' 
                   rel="nofollow" 
                   title="Share this article on Digg"
                   onclick="setCounter(<?php echo get_the_ID(); ?>, 'digg'); custom_social_window('http://digg.com/submit?phase=2%20&amp;url=<?php echo $sPermaLink; ?>&amp;title=<?php echo $sPostTitle; ?>'); return false;">
                    <span class='essb_icon'></span>
                    <span class="essb_network_name">Digg</span>
                </a>
                <span class="diggCounter essb_counter1"><?php echo number_format($iDiggShares, 0, ',', '.'); ?></span>
            </li>
        <?php endif; ?>

        <?php if(in_array('iMailShares', $aSharesArray)): ?>    
            <li class="essb_item1 essb_link_mail mail_custom_share">
                <input type='hidden' value='<?php echo get_the_ID(); ?>' id='home_page_post_id' style="display: none; visibility: hidden;">
                <a href="mailto:?subject=Visit this site <?php echo $sSiteUrl; ?>&body=Hi, this may be intersting you: '<?php echo $sPostTitle; ?>'! This is the link: <?php echo $sPermaLink; ?>"
                   rel="nofollow" 
                   title="Share this article with a friend (email)"
                   onclick="setCounter(<?php echo get_the_ID(); ?>, 'mail');"
                   >
                    <span class='essb_icon'></span>
                    <span class="essb_network_name">E-mail</span>
                </a>
                <span class="mailCounter essb_counter1"><?php echo number_format($iMailShares, 0, ',', '.'); ?></span>
            </li>
        <?php endif; ?>
    </ul>
    <?php        
        $aResult[get_the_ID()] = ob_get_contents();
        ob_end_clean();
    }
    $sResult = json_encode($aResult);
    @file_put_contents($sFilePath, $sResult);
    ob_end_clean();
    die($sResult);
}
/*elseif($aAction == 'getForSinglePost'){
    $iPostId = (int)(isset($_GET['postId']) && $_GET['postId']) ? $_GET['postId'] : 0;
    
    $sFilePath = $sCacheFilePath . "getForSinglePost_{$iPostId}.txt";
    if(file_exists($sFilePath) &&
            filemtime($sFilePath) > (time() - 180)){
        die(file_get_contents($sFilePath));
    }
    
    $twitter_shares_count = (int)get_post_meta($iPostId, 'twitter_shares_count', true);
    $fbsharecount_shares_count = (int)get_post_meta($iPostId, 'fbsharecount_shares_count', true);
    $google_shares_count = (int)get_post_meta($iPostId, 'google_shares_count', true);
    $pinterest_shares_count = (int)get_post_meta($iPostId, 'pinterest_shares_count', true);
    $digg_post_type = (int)get_post_meta($iPostId, 'digg_post_type', true);
    $stumble_shares_count = (int)get_post_meta($iPostId, 'stumble_shares_count', true);
    $mail_post_type = (int)get_post_meta($iPostId, 'mail_post_type', true);
    
    $aResult = array('twitter_shares_count' => $twitter_shares_count,
                    'fbsharecount_shares_count' => $fbsharecount_shares_count,
                    'google_shares_count' => $google_shares_count,
                    'pinterest_shares_count' => $pinterest_shares_count,
                    'digg_post_type' => $digg_post_type,
                    'stumble_shares_count' => $stumble_shares_count,
                    'mail_post_type' => $mail_post_type);
    $sResult = json_encode($aResult);
    @file_put_contents($sFilePath, $sResult);
    die($sResult);
}*/
die();
