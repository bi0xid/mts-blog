<?php
	$sPermaLink = get_the_permalink();
	$sPostTitle = get_the_title();
	$sSiteUrl   = get_site_url();
	$iPostId    = get_the_ID();

	$iFBLikes         = (int)get_post_meta($iPostId, '_msp_fb_likes', true);
	$iTweeterShares   = (int)get_post_meta(get_the_ID(), '_msp_tweets', true);
	$iFBShares        = (int)get_post_meta($iPostId, '_msp_total_shares', true);
	$iDiggShares      = (int)get_post_meta(get_the_ID(), 'digg_post_type', true);
	$iMailShares      = (int)get_post_meta(get_the_ID(), 'total_email_shares', true);
	$iStumbleShares   = (int)get_post_meta(get_the_ID(), 'stumble_shares_count', true);
	$iGoogleShares    = (int)get_post_meta(get_the_ID(), '_msp_google_plus_ones', true); 
	$iPinterestShares = (int)get_post_meta(get_the_ID(), 'pinterest_shares_count', true);

	$aSharesArray = array(
		'iFBLikes'         => $iFBLikes,
		'iFBShares'        => $iFBShares,
		'iMailShares'      => $iMailShares,
		'iDiggShares'      => $iDiggShares,
		'iGoogleShares'    => $iGoogleShares,
		'iTweeterShares'   => $iTweeterShares,
		'iStumbleShares'   => $iStumbleShares,
		'iPinterestShares' => $iPinterestShares
	);

	arsort( $aSharesArray );

	$aSharesArray = array_slice( $aSharesArray, 0, 4 );
	$aSharesArray = array_keys( $aSharesArray );

	if( !defined( 'ESSB_PLUGIN_URL' ) ){
		define( 'ESSB_PLUGIN_URL', "{$sSiteUrl}/wp-content/plugins/easy-social-share-buttons" );
	}
?>

<input type='hidden' value='<?php echo ESSB_PLUGIN_URL; ?>' id='additonal_easy_share_button_url' style="display: none; visibility: hidden;">

<ul class="essb_links1">
	<?php if( in_array( 'iFBLikes', $aSharesArray ) ) { ?>
		<li class="essb_item1 essb_link_facebook fb_custom_likeit">
			<a onclick="return false;" 
				rel="nofollow"
				title="Likes this article on Facebook">
				<span class='essb_icon'></span>
				<span></span>
				Likes
			</a>
			<span class="fbLikeIt essb_counter1"><?php echo number_format( $iFBLikes, 0, ',', '.' ); ?></span>
		</li>
	<?php }; ?>
	
	<?php if( in_array( 'iFBShares', $aSharesArray ) ) { ?>
		<li class="essb_item1 essb_link_facebook fb_custom_share">
			<a onclick="custom_social_window('https://www.facebook.com/sharer/sharer.php?u=<?php echo $sPermaLink; ?>'); return false;"
				href="https://www.facebook.com/sharer/sharer.php?u=<?php echo $sPermaLink; ?>" 
				rel="nofollow"
				title="Share this article on Facebook">
				<span class='essb_icon'></span>
				Share
			</a>
			<span class="fbCounter essb_counter1"><?php echo number_format( $iFBShares, 0, ',', '.' ); ?></span>
		</li>
	<?php }; ?>
		
	<?php if( in_array( 'iGoogleShares', $aSharesArray ) ) { ?>
		<li class="essb_item1 essb_link_google google_custom_share">
			<a href='#'
				onclick="custom_social_window('https://plus.google.com/share?url=<?php echo $sPermaLink; ?>'); return false;"
				href="https://plus.google.com/share?url=<?php echo $sPermaLink; ?>" 
				rel="nofollow"
				title="Share this article on Google+">
				<span class='essb_icon'></span>
				<span class="essb_network_name">Google+</span>
			</a>
			<span class="googleCounter essb_counter1"><?php echo number_format( $iGoogleShares, 0, ',', '.' ); ?></span>
		</li>       
	<?php }; ?>
	
	<?php if( in_array( 'iPinterestShares', $aSharesArray ) ) { ?>
		<li class="essb_item1 essb_link_pinterest pinterest_custom_share">
			<a href="javascript:void((function(){var%20e=document.createElement('script');e.setAttribute('type','text/javascript');e.setAttribute('charset','UTF-8');e.setAttribute('src','http://assets.pinterest.com/js/pinmarklet.js?r='+Math.random()*99999999);document.body.appendChild(e)})());" rel="nofollow" title="Share an image of this article on Pinterest">
				<span class='essb_icon'></span>
				<span class="essb_network_name">Pinterest</span>
			</a>
			<span class="pinterestCounter essb_counter1"><?php echo number_format( $iPinterestShares, 0, ',', '.' ); ?></span>
		</li>
	<?php }; ?>
		
	<?php if( in_array( 'iStumbleShares', $aSharesArray ) ) { ?>   
		<li class="essb_item1 essb_link_stumbleupon stumbleupon_custom_share">
			<a href="http://www.stumbleupon.com/badge/?url=<?php echo $sPermaLink; ?>" 
			   rel="nofollow" 
			   title="Share this article on StumbleUpon"
			   onclick="custom_social_window('http://www.stumbleupon.com/badge/?url=<?php echo $sPermaLink; ?>'); return false;">
				<span class='essb_icon'></span>
				<span class="essb_network_name">StumbleUpon</span>
			</a>
			<span class="stumbleCounter essb_counter1"><?php echo number_format( $iStumbleShares, 0, ',', '.' ); ?></span>
		</li>
	<?php }; ?>
	
	<?php if( in_array( 'iDiggShares', $aSharesArray ) ) { ?>
		<li class="essb_item1 essb_link_digg digg_custom_share">
			<input type='hidden' value='<?php echo get_the_ID(); ?>' id='home_page_post_id' style="display: none; visibility: hidden;">
			<a href='http://digg.com/submit?phase=2%20&amp;url=<?php echo $sPermaLink; ?>&amp;title=<?php echo $sPostTitle; ?>' 
			   rel="nofollow" 
			   title="Share this article on Digg"
			   onclick="custom_social_window('http://digg.com/submit?phase=2%20&amp;url=<?php echo $sPermaLink; ?>&amp;title=<?php echo $sPostTitle; ?>'); return false;">
				<span class='essb_icon'></span>
				<span class="essb_network_name">Digg</span>
			</a>
			<span class="diggCounter essb_counter1"><?php echo number_format( $iDiggShares, 0, ',', '.' ); ?></span>
		</li>
	<?php }; ?>
		
	<?php if( in_array( 'iMailShares', $aSharesArray ) ) { ?>    
		<li class="essb_item1 essb_link_mail mail_custom_share">
			<input type='hidden' value='<?php echo get_the_ID(); ?>' id='home_page_post_id' style="display: none; visibility: hidden;">
			<a href="mailto:?subject=Visit this site <?php echo $sSiteUrl; ?>&body=Hi, this may be intersting you: '<?php echo $sPostTitle; ?>'! This is the link: <?php echo $sPermaLink; ?>"
			   rel="nofollow" 
			   title="Share this article with a friend (email)">
				<span class='essb_icon'></span>
				<span class="essb_network_name">E-mail</span>
			</a>
			<span class="mailCounter essb_counter1"><?php echo number_format( $iMailShares, 0, ',', '.' ); ?></span>
		</li>
	<?php }; ?>
</ul>
