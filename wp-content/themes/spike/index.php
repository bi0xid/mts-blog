<?php $options = get_option('spike'); ?>
<?php get_header(); ?>
<div id="page">
	<div class="content">
		<article class="article">
			<div id="content_box">
				<?php if (is_home() && !is_paged()) { ?>
					<?php if($options['mts_featured_slider'] == '1') { ?>
						<div class="slider-container">
							<div class="flex-container">
								<div class="flexslider">
									<ul class="slides">
										<?php $my_query = new WP_Query('cat='.$options['mts_featured_slider_cat'].'&posts_per_page=4'); while ($my_query->have_posts()) : $my_query->the_post(); $image_id = get_post_thumbnail_id(); $image_url = wp_get_attachment_image_src($image_id,'slider'); $image_url = $image_url[0]; ?>
										<li data-thumb="<?php echo $image_url; ?>">
											<a href="<?php the_permalink() ?>">
												<?php the_post_thumbnail('slider',array('title' => '')); ?>
												<div class="flex-caption">
													<span class="sliderAuthor"><span><?php _e('By','mythemeshop'); ?>:</span> <?php the_author(); ?></span>
													<span class="slidertitle"><?php the_title(); ?></span>
													<span class="slidertext"><p><?php echo excerpt(20); ?></p></span>
													<span class="sliderReadMore"><?php _e('Continue Reading ','mythemeshop'); ?>&rarr;</span>
												</div>
											</a>
										</li>
										<?php endwhile; ?>
									</ul>
								</div>
							</div>
						</div>
					<?php } ?> 
				<?php } ?>
				
				
				<?php
				if ( is_home() ) { ?>
					<!-- index query with advert after the second post -->
					<?php global $post; // required
					$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
					$args = array(
						'paged'			=> $paged,
						'posts_per_page' => 12
					); // setup if needed
					$custom_posts = get_posts($args);
					foreach($custom_posts as $key => $post) : setup_postdata($post); ?>
				
					
						<div class="post excerpt <?php echo (++$j % 2 == 0) ? 'last' : ''; ?>">						
							<div class="post_excerpt_l">
					
								<a href="<?php the_permalink() ?>" title="<?php the_title(); ?>" rel="nofollow" id="featured-thumbnail">
									<?php if ( has_post_thumbnail() ) { ?> 
										<?php echo '<div class="featured-thumbnail">'; the_post_thumbnail('featured',array('title' => '')); echo '</div>'; ?>
									<?php } else { ?>
										<div class="featured-thumbnail">
											<img width="298" height="248" src="<?php echo get_template_directory_uri(); ?>/images/nothumb.png" class="attachment-featured wp-post-image" alt="<?php the_title(); ?>">
										</div>
									<?php } ?>
								</a>
							</div>
							<div class="post_excerpt_r">
								<header>
									<?php if ( has_post_thumbnail() ) { ?> 
										<?php echo '<div class="featured-thumbnail-mobile">'; the_post_thumbnail('featured',array('title' => '')); echo '</div>'; ?>
									<?php }; ?>
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
                                    <?php } ?> <!--Shareit-->
								</div>
							</div>
						</div><!--.post excerpt-->
						
						<!-- the advert -->
						<?php if( $key == 1 ) { ?>
							<div id="WFItem7323302" class="wf-formTpl hidden-mailform">
								<h2>Want To Become Sexually Healthy & Happy?</h2>
								<p>Get 1 FREE Actionable Secret Every Sunday.</p>
								<form accept-charset="utf-8" action="<?php echo get_home_url(); ?>/sign-up/register.php" method="post">
                                                                    <input type="hidden" name="form_type" value="mobile">
									<div class="box">
										<!--<div id="WFIheader" class="wf-header el" style="height: 75px; display:  none !important; ">
											<div class="actTinyMceElBodyContent">
												<p>
													<span style="font-size: 24px; ">Headline</span>
												</p>
											</div>
											<em class="clearfix clearer"></em>
										</div>-->
										<div id="WFIcenter" class="wf-body">
											<ul class="wf-sortable" id="wf-sort-id">
												<!--<li class="wf-name" rel="temporary" style="display:  none !important; ">
													<div class="wf-contbox">
														<div class="wf-labelpos">
															<label class="wf-label">Name:</label>
														</div>
														<div class="wf-inputpos">
															<input class="wf-input" type="text" name="name" data-placeholder="yes"
															value="Enter Your Name Here"></input>
														</div>
														<em class="clearfix clearer"></em>
													</div>
												</li>-->
												<li class="wf-email" rel="undefined" style="display:  block !important; ">
													<div class="wf-contbox">
														<!--<div class="wf-labelpos">
															<label class="wf-label">Email:</label>
														</div>-->
														<div class="wf-inputpos">
															<input class="wf-input wf-req wf-valid__email" id="pb-mail-input" type="text" name="email"
															data-placeholder="yes" placeholder="Enter Your E-Mail Here" required="required"></input>
														</div>
														<em class="clearfix clearer"></em>
													</div>
												</li>                                                                                                
                                                                                                <?php /*
												<li class="wf-submit" rel="undefined" style="display:  block !important; ">
													<div class="wf-contbox">
														<div class="wf-inputpos">
															<input type="submit" id="pb-mf-submit" class="wf-button" name="submit" value="Join!"
															></input>
														</div>
														<em class="clearfix clearer"></em>
													</div>
												</li>
												<li class="wf-counter" rel="undefined" style="display:  none !important; ">
													<div class="wf-contbox">
														<div>
															<span style="padding: 4px 6px 8px 24px; background-image: url(https://app.getresponse.com/images/core/webforms/countertemplates.png); background-position: 0% 0px; background-repeat: no-repeat no-repeat; "
															class="wf-counterbox">
																<span class="wf-counterboxbg" style="padding: 4px 12px 8px 5px; background-image: url(https://app.getresponse.com/images/core/webforms/countertemplates.png); background-position: 100% -36px; background-repeat: no-repeat no-repeat; ">
																	<span class="wf-counterbox0" style="padding: 5px 0px; "></span>
																	<span style="padding: 5px; " name="https://app.getresponse.com/display_subscribers_count.js?campaign_name=info_926081&var=0"
																	class="wf-counterbox1 wf-counterq">1311</span>
																	<span style="padding: 5px 0px; " class="wf-counterbox2">subscribers</span>
																</span>
															</span>
														</div>
													</div>
												</li>
												<li class="wf-captcha" rel="temporary" style="display:  none !important; ">
													<div class="wf-contbox wf-captcha-1" id="wf-captcha-1" wf-captchaword="Enter the words above:"
													wf-captchasound="Enter the numbers you hear:" wf-captchaerror="Incorrect please try again"
													style="display:  block !important; "></div>
													<em class="clearfix clearer"></em>
												</li>
												<li class="wf-privacy" rel="temporary" style="display:  none !important; ">
													<div class="wf-contbox">
														<div>
															<a class="wf-privacy wf-privacyico" href="http://www.getresponse.com/permission-seal?lang=en"
															target="_blank" style="height: 0px !important; display: inline !important; ">We respect your privacy<em class="clearfix clearer"></em></a>
														</div>
														<em class="clearfix clearer"></em>
													</div>
												</li>
												<li class="wf-poweredby" rel="temporary" style="display:  none !important; ">
													<div class="wf-contbox">
														<div>
															<span class="wf-poweredby wf-poweredbyico" style="display:  none !important; ">
																<a class="wf-poweredbylink wf-poweredby" href="http://www.getresponse.com/"
																style="display:  inline !important; " target="_blank">Email Marketing</a>by GetResponse</span>
														</div>
													</div>
												</li>
                                                                                                 */ ?>
											</ul>
										</div>
										<div id="WFIfooter" class="wf-footer el" style="height: 20px; display:  none !important; ">
											<div class="actTinyMceElBodyContent"></div>
											<em class="clearfix clearer"></em>
										</div>
									</div>
								</form>
							</div>
						<?php } ?>
						
					<?php endforeach; ?>
				<?php } else { ?>
					<!-- original query( for search results) -->
					<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
						<div class="post excerpt <?php echo (++$j % 2 == 0) ? 'last' : ''; ?>">						
							<div class="post_excerpt_l">
					
								<a href="<?php the_permalink() ?>" title="<?php the_title(); ?>" rel="nofollow" id="featured-thumbnail">
									<?php if ( has_post_thumbnail() ) { ?> 
										<?php echo '<div class="featured-thumbnail">'; the_post_thumbnail('featured',array('title' => '')); echo '</div>'; ?>
									<?php } else { ?>
										<div class="featured-thumbnail">
											<img width="298" height="248" src="<?php echo get_template_directory_uri(); ?>/images/nothumb.png" class="attachment-featured wp-post-image" alt="<?php the_title(); ?>">
										</div>
									<?php } ?>
								</a>
							</div>
							<div class="post_excerpt_r">
								<header>
									<?php if ( has_post_thumbnail() ) { ?> 
										<?php echo '<div class="featured-thumbnail-mobile">'; the_post_thumbnail('featured',array('title' => '')); echo '</div>'; ?>
									<?php }; ?>
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
                                            
                                            $iFBLikes = (int)get_post_meta($iPostId, '_msp_fb_likes', true);
                                            $iFBShares = (int)get_post_meta($iPostId, '_msp_shares_total', true);
                                            $iTweeterShares = (int)get_post_meta(get_the_ID(), '_msp_tweets', true);
                                            $iGoogleShares = (int)get_post_meta(get_the_ID(), '_msp_google_plus_ones', true); 
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
                                            
                                            //if(!in_array('iGoogleShares', array_keys($aSharesArray))){
                                            //    $iLastElemnt = end($aSharesArray);
                                            //    if(!$iLastElemnt){
                                            //        $aSharesArray = array_slice($aSharesArray, 0, 3);
                                            //        $aSharesArray['iGoogleShares'] = $iGoogleShares;
                                            //    }
                                            //}
                                            
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
                                                
                                            <?php /* if(in_array('iStumbleShares', $aSharesArray)): ?>   
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
                                            <?php endif; */ ?>
                                            
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
                                                    <a href="mailto:?subject=Visit this site <?php echo $sSiteUrl; ?>&body=Hi, this may be interesting for you: '<?php echo $sPostTitle; ?>'! This is the link: <?php echo $sPermaLink; ?>"
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
                                <?php if($options['mts_social_buttons_home'] == '1') { ?>
                                    <div class="home_meta_comment_social get_social_counter_result" data-id="<?php echo get_the_ID(); ?>" id="get_social_counter_result_<?php echo get_the_ID(); ?>"></div>
                                <?php } ?>
							</div>
						</div><!--.post excerpt-->
					<?php endwhile; endif; ?>
				<?php } ?>
                
                <?php if(!is_home() || $_SERVER["REQUEST_URI"] != '/') { ?>
                    <?php  if ($options['mts_pagenavigation'] == '1' ) { ?>
                        <?php pagination($additional_loop->max_num_pages);?>
                    <?php } else { ?>
                        <div class="pnavigation2">
                            <div class="nav-previous"><?php next_posts_link( __( '&larr; '.'Older posts', 'mythemeshop' ) ); ?></div>
                            <div class="nav-next"><?php previous_posts_link( __( 'Newer posts'.' &rarr;', 'mythemeshop' ) ); ?></div>
                        </div>
                    <?php } ?>
                <?php } ?>
			</div>
		</article>


		<?php get_sidebar(); ?>


        <?php if(is_home() && $_SERVER["REQUEST_URI"] == '/') { ?>
            <?php /* <div style="width: 100%; clear: both;"></div> */ ?>
            <div id="infinite_scroll_single_post">
                <?php  echo do_shortcode('[wpajax]');  ?>
            </div>
            <div class="article">
                <?php if ($options['mts_pagenavigation'] == '1') { ?>
                    <?php pagination($additional_loop->max_num_pages);?>
                <?php } else { ?>
                    <div class="pnavigation2">
                        <div class="nav-previous"><?php next_posts_link( __( '&larr; '.'Older posts', 'mythemeshop' ) ); ?></div>
                        <div class="nav-next"><?php previous_posts_link( __( 'Newer posts'.' &rarr;', 'mythemeshop' ) ); ?></div>
                    </div>
                <?php } ?>
            </div>
        <?php } ?>
        
<?php get_footer(); ?>
