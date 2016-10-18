<?php
	$options = get_option('spike');
	get_header();
?>

<div id="email-share-template">
	<p class="close-modal">X</p>

	<form>
		<h3>To whom do you want to send this article via email?</h3>
		<input type="email" required="true" class="from_email" placeholder="From email:">
		<input type="email" required="true" class="to_email" placeholder="To email:">
		<input type="text" class="message" placeholder="Message:">
		<button type="submit">Send</button>
	</form>
</div>

<p id="message_alert"></p>

<div id="page">
	<div class="content">
		<article class="article">
			<div id="content_box">
				<?php
					if (is_home() && !is_paged()) {
						if($options['mts_featured_slider'] == '1') { ?>
							<div class="slider-container">
								<div class="flex-container">
									<div class="flexslider">
										<ul class="slides">
											<?php
												$my_query = new WP_Query('cat='.$options['mts_featured_slider_cat'].'&posts_per_page=4');

												while ( $my_query->have_posts() ) {
													$my_query->the_post();
													$image_id = get_post_thumbnail_id();
													$image_url = wp_get_attachment_image_src( $image_id, 'slider' );
													$image_url = $image_url[0];
												?>
													<li data-thumb="<?php echo $image_url; ?>">
														<a href="<?php the_permalink() ?>">
															<?php the_post_thumbnail( 'slider', array( 'title' => '' ) ); ?>
															<div class="flex-caption">
																<span class="sliderAuthor"><span><?php _e('By','mythemeshop'); ?>:</span> <?php the_author(); ?></span>
																<span class="slidertitle"><?php the_title(); ?></span>
																<span class="slidertext"><p><?php echo excerpt(20); ?></p></span>
																<span class="sliderReadMore"><?php _e('Continue Reading ','mythemeshop'); ?>&rarr;</span>
															</div>
														</a>
													</li>
											<?php }; ?>
										</ul>
									</div>
								</div>
							</div>
				<?php
					}
				}

				if ( is_home() ) {
					global $post;

					$paged = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;

					$custom_posts = get_posts(array(
						'paged' => $paged,
						'posts_per_page' => 12
					));

					foreach( $custom_posts as $key => $post ) {
						setup_postdata($post);
				?>
						<div data-id="<?php echo the_id(); ?>" class="post excerpt <?php echo (++$j % 2 == 0) ? 'last' : ''; ?>">						
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
									<?php if ( has_post_thumbnail() ) {
										 echo '<div class="featured-thumbnail-mobile">'; the_post_thumbnail('featured',array('title' => '')); echo '</div>';
									}; ?>
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
								</header>

								<div class="post-content image-caption-format-1">
									<?php echo excerpt( 53 ); ?> 
									<a class="pereadore" href="<?php the_permalink() ?>" title="<?php the_title(); ?>" rel="nofollow"><?php _e('...Read More','mythemeshop'); ?></a>
								</div>

								<div class="home_meta_comment_social">
									<?php
										if($options['mts_social_buttons_home'] == '1') {
											include get_stylesheet_directory().'/templates/post-share-options.php';
										}
									?>
								</div>
							</div>
						</div>
						
						<?php if( $key == 1 ) { ?>
							<div id="WFItem7323302" class="wf-formTpl hidden-mailform">
								<h2>Want To Become Sexually Healthy & Happy?</h2>
								<p>Get 1 FREE Actionable Secret Every Sunday.</p>
								<form accept-charset="utf-8" action="<?php echo get_stylesheet_directory_uri().'/sign-up/newsletter.php' ?>" method="post">
									<input type="hidden" name="form_type" value="mobile">
									<div class="box">
										<div id="WFIcenter" class="wf-body">
											<ul class="wf-sortable" id="wf-sort-id">
												<li class="wf-email" rel="undefined" style="display:  block !important; ">
													<div class="wf-contbox">
														<div class="wf-inputpos">
															<input class="wf-input wf-req wf-valid__email" id="pb-mail-input" type="text" name="email"
															data-placeholder="yes" placeholder="Enter Your E-Mail Here" required="required"></input>
														</div>
														<em class="clearfix clearer"></em>
													</div>
												</li>
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
						
					<?php };
				} else {
					if ( have_posts() ) {
						while ( have_posts() ) {
							the_post();
						?>
							<div class="post excerpt <?php echo ( ++$j % 2 == 0 ) ? 'last' : ''; ?>">
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
									</header>

									<div class="post-content image-caption-format-1">
										<?php echo excerpt( 53 ); ?> 
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
												$iMailShares = (int)get_post_meta(get_the_ID(), 'total_email_shares', true);
												
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
										<?php } ?>
									</div>	
									<?php if($options['mts_social_buttons_home'] == '1') { ?>
										<div class="home_meta_comment_social get_social_counter_result" data-id="<?php echo get_the_ID(); ?>" id="get_social_counter_result_<?php echo get_the_ID(); ?>"></div>
									<?php } ?>
								</div>
							</div>
					<?php }; }; ?>
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
