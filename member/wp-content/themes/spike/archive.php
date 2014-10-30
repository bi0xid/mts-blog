<?php $options = get_option('spike'); ?>
<?php get_header(); ?>
<div id="page">
	<div class="content">
		<article class="article">
			<div id="content_box">
				<h1 class="postsby">
					<?php if (is_category()) { ?>
						<span><?php single_cat_title(); ?><?php _e(" Archive", "mythemeshop"); ?></span>
					<?php } elseif (is_tag()) { ?> 
						<span><?php single_tag_title(); ?><?php _e(" Archive", "mythemeshop"); ?></span>
					<?php } elseif (is_search()) { ?> 
						<span><?php _e("Search Results for:", "mythemeshop"); ?></span> <?php the_search_query(); ?>
					<?php } elseif (is_author()) { ?>
						<span><?php _e("Author Archive", "mythemeshop"); ?></span> 
					<?php } elseif (is_day()) { ?>
						<span><?php _e("Daily Archive:", "mythemeshop"); ?></span> <?php the_time('l, F j, Y'); ?>
					<?php } elseif (is_month()) { ?>
						<span><?php _e("Monthly Archive:", "mythemeshop"); ?>:</span> <?php the_time('F Y'); ?>
					<?php } elseif (is_year()) { ?>
						<span><?php _e("Yearly Archive:", "mythemeshop"); ?>:</span> <?php the_time('Y'); ?>
					<?php } ?>
				</h1>
				<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
					<div class="cpostex post excerpt <?php echo (++$j % 2 == 0) ? 'last' : ''; ?>">						
                        <div class="post_excerpt_l">
                        	<a href="<?php the_permalink() ?>" title="<?php the_title(); ?>" rel="nofollow" id="featured-thumbnail">
								<?php if ( has_post_thumbnail() ) { ?> 
									<?php echo '<div class="featured-thumbnail">'; the_post_thumbnail('featured',array('title' => '')); echo '</div>'; ?>
								<?php } else { ?>
									<div class="featured-thumbnail">
										<img width="300" height="250" src="<?php echo get_template_directory_uri(); ?>/images/nothumb.png" class="attachment-featured wp-post-image" alt="<?php the_title(); ?>">
									</div>
								<?php } ?>
							</a>
                        </div>
                        <div class="post_excerpt_r">
							<header>						
								<h2 class="title">
									<a href="<?php the_permalink() ?>" title="<?php the_title(); ?>" rel="bookmark"><?php the_title(); ?></a>
								</h2>
								<?php if($options['mts_headline_meta'] == '1') { ?>
									<div class="post-info">
										<span class="theauthor"><?php _e('By ','mythemeshop'); the_author_posts_link(); ?></span>
										<span class="thecategory"><?php the_category(', ') ?></span>
										<span class="thetime"><?php the_time('M d, Y'); ?></span> 
                                        <div class="thecomment">
                                            <a href="<?php comments_link(); ?>" rel="nofollow"><?php comments_number('0 Comment','1 Comment','% Comments'); ?></a>					
                                        </div>
									</div>
								<?php } ?>
							</header><!--.header-->
							<div class="post-content image-caption-format-1">
								<?php echo excerpt(53);?> 
								<a class="pereadore" href="<?php the_permalink() ?>" title="<?php the_title(); ?>" rel="nofollow"><?php _e('...Read More','mythemeshop'); ?></a>
							</div>
							<div class="home_meta_comment_social">								
								<?php if($options['mts_social_buttons_home'] == '1') { ?>
                                    <?php
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
                                                       onclick="custom_social_window('http://digg.com/submit?phase=2%20&amp;url=<?php echo $sPermaLink; ?>&amp;title=<?php echo $sPostTitle; ?>'); return false;">
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
                                                       title="Share this article with a friend (email)">
                                                        <span class='essb_icon'></span>
                                                        <span class="essb_network_name">E-mail</span>
                                                    </a>
                                                    <span class="mailCounter essb_counter1"><?php echo number_format($iMailShares, 0, ',', '.'); ?></span>
                                                </li>
                                            <?php endif; ?>
                                        </ul>
								<?php } ?><!--Shareit-->
							</div>	
						</div>
					</div><!--.post excerpt-->
				<?php endwhile; endif; ?>
				<?php if ($options['mts_pagenavigation'] == '1') { ?>
					<?php pagination($additional_loop->max_num_pages);?>
				<?php } else { ?>
					<div class="pnavigation2">
						<div class="nav-previous"><?php next_posts_link( __( '&larr; '.'Older posts', 'mythemeshop' ) ); ?></div>
						<div class="nav-next"><?php previous_posts_link( __( 'Newer posts'.' &rarr;', 'mythemeshop' ) ); ?></div>
					</div>
				<?php } ?>
			</div>
		</article>
		<?php get_sidebar(); ?>
<?php get_footer(); ?>