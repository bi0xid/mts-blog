<?php 
    //Replace all links to the shop when user read affiliate authors post
    //First we check if author in affiliate program if yes then parse content
    $post_author_id = get_post_field('post_author', get_the_ID());
    $affiliate_id_mts = (int)get_user_meta($post_author_id, 'affiliate_id_mts', true);
    if($affiliate_id_mts && is_single()){
        ob_start();
        get_header();
        $sSideBarHtml = ob_get_clean();            
        $oDomObject = new DomDocument;
        @$oDomObject->loadHTML($sSideBarHtml);
        $aSearcheUrl = array();
        foreach ($oDomObject->getElementsByTagName('a') as $oNode)
        {
            $sUrl = $oNode->getAttribute("href");
            if (strpos($sUrl, 'mytinysecrets.com/shop') !== false) {
                $aSearcheUrl[$sUrl] = "http://mytinysecrets.com/sharethelove/idevaffiliate.php?id={$affiliate_id_mts}&url={$sUrl}";
            }
        }
        if(!empty($aSearcheUrl)) $sSideBarHtml = str_replace(array_keys($aSearcheUrl), array_values($aSearcheUrl), $sSideBarHtml);

        echo $sSideBarHtml;
    }
    else{
        get_header();
    }
?>
<?php $options = get_option('spike'); ?>
<div id="page" class="single">	
	<div class="content">	
		<article class="article">
			<div id="content_box" >
				<div id="WFItem7323302" class="wf-formTpl hidden-mailform">
					<h2>Want To Become Sexually Healthy & Happy?</h2>
					<p>Get 1 FREE Actionable Secret Every Sunday.</p>
					<form accept-charset="utf-8" action="<?php echo get_home_url(); ?>/sign-up/register.php" method="post">
                                            <input type="hidden" name="form_type" value="post">
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
												<input class="wf-input" type="text" name="name" data-placeholder="yes" value="Enter Your Name Here"></input>
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
												<input class="wf-input wf-req wf-valid__email" id="pb-mail-input" type="text" name="email" data-placeholder="yes" placeholder="Enter Your E-Mail Here" required="required"></input>
											</div>
											<em class="clearfix clearer"></em>
										</div>
									</li>                                                                
                                                                <?php /*
								<li class="wf-submit" rel="undefined" style="display:  block !important; ">
									<div class="wf-contbox">
										<div class="wf-inputpos">
											<input type="submit" id="pb-mf-submit" class="wf-button" name="submit" value="Join!"></input>
										</div>
										<em class="clearfix clearer"></em>
									</div>
								</li>
								<li class="wf-counter" rel="undefined" style="display:  none !important; ">
									<div class="wf-contbox">
										<div>
											<span style="padding: 4px 6px 8px 24px; background-image: url(https://app.getresponse.com/images/core/webforms/countertemplates.png); background-position: 0% 0px; background-repeat: no-repeat no-repeat; " class="wf-counterbox">
											<span class="wf-counterboxbg" style="padding: 4px 12px 8px 5px; background-image: url(https://app.getresponse.com/images/core/webforms/countertemplates.png); background-position: 100% -36px; background-repeat: no-repeat no-repeat; ">
											<span class="wf-counterbox0" style="padding: 5px 0px; "></span>
											<span style="padding: 5px; " name="https://app.getresponse.com/display_subscribers_count.js?campaign_name=info_926081&var=0" class="wf-counterbox1 wf-counterq">1311</span>
											<span style="padding: 5px 0px; " class="wf-counterbox2">subscribers</span></span>
											</span>
										</div>
									</div>
								</li>
								<li class="wf-captcha" rel="temporary" style="display:  none !important; ">
									<div class="wf-contbox wf-captcha-1" id="wf-captcha-1" wf-captchaword="Enter the words above:" wf-captchasound="Enter the numbers you hear:" wf-captchaerror="Incorrect please try again" style="display:  block !important; "></div>
									<em class="clearfix clearer"></em>
								</li>
								<li class="wf-privacy" rel="temporary" style="display:  none !important; ">
									<div class="wf-contbox">
										<div>
											<a class="wf-privacy wf-privacyico" href="http://www.getresponse.com/permission-seal?lang=en" target="_blank" style="height: 0px !important; display: inline !important; ">We respect your privacy<em class="clearfix clearer"></em></a>
										</div>
										<em class="clearfix clearer"></em>
									</div>
								</li>
								<li class="wf-poweredby" rel="temporary" style="display:  none !important; ">
								<div class="wf-contbox">
								<div>
								<span class="wf-poweredby wf-poweredbyico" style="display:  none !important; ">
								<a class="wf-poweredbylink wf-poweredby" href="http://www.getresponse.com/" style="display:  inline !important; " target="_blank">Email Marketing</a>by GetResponse</span></div></div></li>
                                                                */ ?>
							</ul>
						</div>
						<div id="WFIfooter" class="wf-footer el" style="height: 20px; display:  none !important; ">
							<div class="actTinyMceElBodyContent"></div>
							<em class="clearfix clearer"></em>
						</div>
					</div>
					<input type="hidden" name="webform_id" value="7323302" />
				</form>
			</div>
				<?php if ( have_posts() ) while ( have_posts() ) : the_post(); ?>
					<div id="post-<?php the_ID(); ?>" <?php post_class('g post'); ?>>
						<?php if ($options['mts_breadcrumb'] == '1') { ?>
							<div class="breadcrumb"><?php the_breadcrumb(); ?></div>
						<?php } ?>
						<header>
							<h1 class="title single-title entry-title"><?php the_title(); ?></h1>
							<?php if($options['mts_headline_meta'] == '1') { ?>
								<div class="post-info"><span class="theauthor"><?php _e('Posted by ','mythemeshop'); the_author_posts_link(); ?></span>
								<span class="thetime date updated"><?php _e('on ','mythemeshop'); the_time('F j, Y'); ?></span>
								<span class="thecategory"><?php _e(' in ','mythemeshop'); the_category(', ') ?></span>
								<span class="thecomment"><a href="<?php comments_link(); ?>" rel="nofollow"><?php echo comments_number();?></a></span></span></div>
							<?php } ?>
						</header><!--.headline_area-->
						<div class="post-single-content box mark-links">
							<div class="single_post">
								<?php if ($options['mts_posttop_adcode'] != '') { ?>
									<?php $toptime = $options['mts_posttop_adcode_time']; if (strcmp( date("Y-m-d", strtotime( "-$toptime day")), get_the_time("Y-m-d") ) >= 0) { ?>
										<div class="topad">
											<?php echo $options['mts_posttop_adcode']; ?>
										</div>
									<?php } ?> 
								<?php } ?>
								
								<?php the_content(); ?>
								<?php wp_link_pages('before=<div class="pagination2">&after=</div>'); ?>
								<?php if ($options['mts_postend_adcode'] != '') { ?>
									<?php $endtime = $options['mts_postend_adcode_time']; if (strcmp( date("Y-m-d", strtotime( "-$endtime day")), get_the_time("Y-m-d") ) >= 0) { ?>
										<div class="bottomad">
											<?php echo $options['mts_postend_adcode'];?>
										</div>
									<?php } ?>
								<?php } ?> 
								<?php if($options['mts_tags'] == '1') { ?>
									<div class="tags"><?php the_tags('<span class="tagtext">Tags:</span>',', ') ?></div>
								<?php } ?>
							</div>
                         
                            <?php if(function_exists('getAddvertithingForPost')): ?>
                                <?php $aRes = getAddvertithingForPost(get_the_ID());?>
                                <?php if($aRes): ?>
                                    <div class="custom_advertising_block">
                                        <a href="<?php echo $aRes['url']; ?>" title="<?php echo $aRes['title']; ?>" target="_blank">
                                            <img src="<?php echo $aRes['scr']; ?>" alt="<?php echo $aRes['title']; ?>" title="<?php echo $aRes['title']; ?>" height="<?php echo $aRes['height']; ?>" width="<?php echo $aRes['width']; ?>">
                                        </a>
                                    </div>
                                <?php endif; ?>
                            <?php endif; ?>
                            
                            
							<div class="pb-mc-wrapper">
								<div id="pb-mailchimp">
									<h3>Want To Become Sexually Healthy & Happy?</h3>
									<p>Join The Secret Sunday List & Get 1 FREE Actionable Secret Every Sunday.</p>
									<div id="WFItem7323402" class="wf-formTpl">
										<form accept-charset="utf-8" action="<?php echo get_home_url(); ?>/sign-up/register.php" method="post">
											<div class="pb-inputline">
												<input type="text" value="" class="wf-input wf-req wf-valid__required"
												name="name" placeholder="Enter Your First Name Here" required="true"></input>
												<input type="email" value="" class="wf-input wf-req wf-valid__email"
												name="email" required="true" required="required" placeholder="Enter Your E-mail Here"></input>
												<input type="submit" id="pb-mc-submit"
												value="Join!" class="wf-button" name="submit"></input>
												<input type="hidden" name="form_type" value="post">
											</div>
											
										</form>
									</div>
								</div>
							</div>

							<div class="loveschool-teaser-video-background">
								<span class="close-video">X</span>
								<div id="teaser-video"></div>
							</div>

						<?php if ( function_exists( "get_yuzo_related_posts" ) ) { get_yuzo_related_posts(); } ?>
							<?php //if ( function_exists( "wp_related_posts" ) ) { wp_related_posts(); } ?>
							
							<div class="single_post_right">
							<?php if($options['mts_related_posts'] == '1') { ?>	
							<?php $categories = get_the_category($post->ID); if ($categories) { $category_ids = array(); foreach($categories as $individual_category) $category_ids[] = $individual_category->term_id; $args=array( 'category__in' => $category_ids, 'post__not_in' => array($post->ID), 'showposts'=>6, 'caller_get_posts'=>1, 'orderbye' => 'rand' );
							$my_query = new wp_query( $args ); if( $my_query->have_posts() ) {
								echo '<div class="related-posts"><div class="postauthor-top"><h3>'.__('Related Posts','mythemeshop').'</h3></div><ul>';
								while( $my_query->have_posts() ) { ++$counter; if($counter == 4) { $postclass = 'last2'; $counter = 0; } else { $postclass = ''; } $my_query->the_post();?>
								<li class="<?php echo $postclass; ?>">
									<a rel="nofollow" class="relatedthumb" href="<?php the_permalink()?>" rel="bookmark" title="<?php the_title(); ?>">
										<span class="rthumb">
											<?php if(has_post_thumbnail()): ?>
												<?php the_post_thumbnail('related', 'title='); ?>
											<?php else: ?>
												<img src="<?php echo get_template_directory_uri(); ?>/images/relthumb.png" alt="<?php the_title(); ?>"  width='140' height='100' class="wp-post-image" />
											<?php endif; ?>
										</span>									
									</a>
									<a class="relatedthumb" href="<?php the_permalink()?>" rel="bookmark" title="<?php the_title(); ?>">
								   <?php the_title(); ?>
								   </a>
								</li>
								<?php } echo '</ul></div>'; }} wp_reset_query(); ?>
							<!-- .related-posts -->
							<?php }?>
                            
							<?php if($options['mts_social_buttons'] == '1') { ?>
								<div class="shareit abc">
									<?php if($options['mts_twitter'] == '1') { ?>
											<!-- Twitter -->
											<span class="share-item twitterbtn">
											<a href="https://twitter.com/share" class="twitter-share-button" data-via="<?php echo $options['mts_twitter_username']; ?>">Tweet</a>
											</span>
									<?php } ?>
									<?php if($options['mts_gplus'] == '1') { ?>
											<!-- GPlus -->
											<span class="share-item gplusbtn">
											<g:plusone size="medium"></g:plusone>
											</span>
									<?php } ?>
									<?php if($options['mts_facebook'] == '1') { ?>
											<!-- Facebook -->
											<span class="share-item facebookbtn">
											<div id="fb-root"></div>
											<div class="fb-like" data-send="false" data-layout="button_count" data-width="150" data-show-faces="false"></div>
											</span>
									<?php } ?>
									<?php if($options['mts_linkedin'] == '1') { ?>
											<!--Linkedin -->
											<span class="share-item linkedinbtn">
											<script type="text/javascript" src="http://platform.linkedin.com/in.js"></script><script type="in/share" data-url="<?php the_permalink(); ?>" data-counter="right"></script>
											</span>
									<?php } ?>
									<?php if($options['mts_stumble'] == '1') { ?>
											<!-- Stumble -->
											<span class="share-item stumblebtn">
											<su:badge layout="1"></su:badge>
											<script type="text/javascript"> 
											(function() { 
											var li = document.createElement('script'); li.type = 'text/javascript'; li.async = true; 
											li.src = window.location.protocol + '//platform.stumbleupon.com/1/widgets.js'; 
											var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(li, s); 
											})(); 
											</script>
											</span>
									<?php } ?>
									<?php if($options['mts_pinterest'] == '1') { ?>
											<!-- Pinterest -->
											<span class="share-item pinbtn">
											<a href="http://pinterest.com/pin/create/button/?url=<?php the_permalink(); ?>&media=<?php $thumb = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'large' ); echo $thumb['0']; ?>&description=<?php the_title(); ?>" class="pin-it-button" count-layout="horizontal">Pin It</a>
											<script type="text/javascript" src="//assets.pinterest.com/js/pinit.js"></script>
											</span>
									<?php } ?>
								</div>
							<?php } ?><!--Shareit-->
                            
                            <?php /*Authro bloc old version*/ ?>
                            <?php if( /*$options['mts_author_box'] == '1'*/ false ) { ?>                                
                                <div class="postauthor">
                                    <h4> <?php _e('About The Author', 'mythemeshop'); ?> </h4>
                                    <div class="postauthor_img_wrapper">
                                        <?php if(function_exists('get_avatar')) { echo get_avatar( get_the_author_meta('email'), '100', '100' );  } ?>
                                    </div>
                                    <span class="vcard author post-author">	
                                    <span class="fn"><h5> <?php _e('by ','mythemeshop'); the_author_posts_link(); ?> </h5></span>
                                    </span>                                 
                                    <p>
                                        <?php the_author_meta('description'); ?>
                                    </p>
                                </div>
                            <?php }?>                            
						</div>
                            <h3>Share Your Thoughts</h3>
							<?php comments_template( '', true ); ?>
						</div>
						<!--.g post-->
					</div><!--.post-content box mark-links-->
				<?php endwhile; /* end loop */ ?>
			</div>
		</article>
		<?php 
            //Replace all links to the shop when user read affiliate authors post
            //First we check if author in affiliate program if yes then parse content
            $post_author_id = get_post_field('post_author', get_the_ID());
            $affiliate_id_mts = (int)get_user_meta(get_the_author_ID(), 'affiliate_id_mts', true);
            if($affiliate_id_mts && is_single()){
                ob_start();
                get_sidebar();
                $sSideBarHtml = ob_get_clean();            
                $oDomObject = new DomDocument;
                @$oDomObject->loadHTML($sSideBarHtml);
                $aSearcheUrl = array();
                foreach ($oDomObject->getElementsByTagName('a') as $oNode)
                {
                    $sUrl = $oNode->getAttribute("href");
                    if (strpos($sUrl, 'mytinysecrets.com/shop') !== false) {
                        $aSearcheUrl[$sUrl] = "http://mytinysecrets.com/sharethelove/idevaffiliate.php?id={$affiliate_id_mts}&url={$sUrl}";
                    }
                }
                if(!empty($aSearcheUrl)) $sSideBarHtml = str_replace(array_keys($aSearcheUrl), array_values($aSearcheUrl), $sSideBarHtml);
                        
                echo $sSideBarHtml;
            }
            else{
                get_sidebar();
            }
        ?>
        <div id="infinite_scroll_single_post">
            <?php  echo do_shortcode('[wpajax layout ="modern" col_width ="253" ajax_style ="scroll" button_label ="View more" button_text_color ="FFFFFF" button_bg_color ="35AA47" button_font ="0" button_size ="14" button_icon ="icon-double-angle-right" loading_image ="3" thumb_size ="thumbnail" post_title_color ="35AA47" post_title_font ="Arial" post_title_size ="18" post_excerpt_color ="444444" post_excerpt_font ="Arial" post_excerpt_size ="14" post_meta_color ="999999" post_meta_font ="Arial" post_meta_size ="11" thumb_hover_icon ="icon-search" thumb_hover_color ="35AA47" thumb_hover_bg ="FFFFFF" thumb_hover_popup ="1" popup_theme ="0" border_hover_color ="35AA47" border_hover_width ="1" tag ="" orderby ="date" order ="DESC" posts_per_page ="12" cat ="30,76,75,103,4,80,1" post_type ="" /]');  ?>
        </div>
<?php get_footer(); ?>