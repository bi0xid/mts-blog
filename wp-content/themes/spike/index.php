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

		<span class="loading" style="background-image:url(<?php echo get_stylesheet_directory_uri().'/images/loading.gif'; ?>)"></span>
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
						setup_postdata( $post );
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

								</div>
							</div>
					<?php }; };
				} ?>
				
				<?php if( !is_home() || $_SERVER["REQUEST_URI"] != '/' ) {
					if ( $options['mts_pagenavigation'] == '1' ) {
						pagination($additional_loop->max_num_pages);
					} else { ?>
						<div class="pnavigation2">
							<div class="nav-previous"><?php next_posts_link( __( '&larr; '.'Older posts', 'mythemeshop' ) ); ?></div>
							<div class="nav-next"><?php previous_posts_link( __( 'Newer posts'.' &rarr;', 'mythemeshop' ) ); ?></div>
						</div>
				<?php } } ?>
			</div>
		</article>

		<?php
			get_sidebar();

			if( is_home() && $_SERVER["REQUEST_URI"] == '/' ) {
		?>
			<div id="infinite_scroll_single_post">
				<?php echo do_shortcode( '[wpajax]' ); ?>
			</div>

			<div class="article">
				<?php if ($options['mts_pagenavigation'] == '1') {
					pagination($additional_loop->max_num_pages);
				} else { ?>
					<div class="pnavigation2">
						<div class="nav-previous"><?php next_posts_link( __( '&larr; '.'Older posts', 'mythemeshop' ) ); ?></div>
						<div class="nav-next"><?php previous_posts_link( __( 'Newer posts'.' &rarr;', 'mythemeshop' ) ); ?></div>
					</div>
				<?php } ?>
			</div>
		<?php } ?>

<?php get_footer(); ?>
