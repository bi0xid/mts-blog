<?php $options = get_option('minimalist'); ?>
<?php get_header(); ?>
<div id="page">
	<div class="content">
		<article class="article">
			<div id="content_box">
				<?php if (is_home() && !is_paged()) { ?>
					<?php if($options['mts_featured_slider'] == '1') { ?>
						<div class="flex-container">
							<div class="flexslider">
								<ul class="slides">
									<?php $my_query = new WP_Query('cat='.$options['mts_featured_cat'].'&posts_per_page=4'); while ($my_query->have_posts()) : $my_query->the_post(); ?>
									<li>
										<a href="<?php the_permalink() ?>">
											<?php the_post_thumbnail('slider',array('title' => '')); ?>
											<p class="flex-caption">
												<span class="slidertitle"><?php the_title(); ?></span>
												<span class="slidertext"><?php echo excerpt(20); ?></span>
											</p>
										</a>
									</li>
									<?php endwhile; ?>
								</ul>
							</div>
						</div>
					<?php } ?>
				<?php } ?>
				<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
					<div class="post excerpt">
						<header>
							<div class="featured-thumbnail">
								<a href="<?php the_permalink() ?>" title="<?php the_title(); ?>" rel="nofollow" id="featured-thumbnail">
								<?php if ( has_post_thumbnail() ) { ?> 
								<?php the_post_thumbnail('featured',array('title' => '')); ?>
								<?php } ?>
								</a>
							</div>
								<h2 class="title">
									<a href="<?php the_permalink() ?>" title="<?php the_title(); ?>" rel="bookmark"><?php the_title(); ?></a>
								</h2>
							<?php if($options['mts_headline_meta'] == '1') { ?>
								<div class="post-info">
									<span class="theauthor"><?php _e('Posted by ', 'mythemeshop'); the_author_posts_link(); ?></span>
									<time><?php _e('On ', 'mythemeshop'); the_time('F j, Y'); ?></time>
									<span class="thecategory"><?php _e('In ', 'mythemeshop'); the_category(', ') ?></span>
								</div>
							<?php } ?>
						</header><!--.header-->
						<div class="post-content image-caption-format-1">
							<?php echo excerpt(48);?>
							<div class="more">
							<a href="<?php the_permalink() ?>" rel="nofollow"><?php _e('Read More','mythemeshop'); ?></a>
							</div>
						</div>
					</div><!--.post excerpt-->
					<?php if ($count == 0) : ?>
					<div class="intercept">
					  <div class="Intercept-1">
						<div class="IPLeft">
							<span><?php _e('Advertisement','mythemeshop'); ?></span>
							<?php if ($options['mts_home_adcode'] != '') { ?>
									<div class="homead">
										<?php echo(stripslashes ($options['mts_home_adcode']));?>
									</div>
							<?php } ?>
						</div>
						<div class="IPRight">
						  <h5><?php _e('Hot Now!','mythemeshop'); ?></h5>
							<ul>
							  <?php $my_query = new WP_Query('posts_per_page=3&orderby=rand'); while ($my_query->have_posts()) : $my_query->the_post(); ?>
								<li>
									<a href="<?php echo get_permalink($post->ID); ?>">
										<?php if ( has_post_thumbnail() ) { ?> 
											<?php the_post_thumbnail('popular',array('title' => '')); ?>
										<?php } else { ?>
											<img width="60" height="60" src="<?php echo get_template_directory_uri(); ?>/images/smallthumb.png" class="attachment-featured wp-post-image" alt="<?php the_title(); ?>">
										<?php } ?>
										<span class="IP-title"><?php the_title(); ?></span>
									</a><br />
									<div class="clear"></div>
								</li>
							   <?php endwhile; ?>
							</ul>
						</div>
						<div class="clear"></div>
					  </div>
					</div>
					<?php endif; $count++; ?>
				<?php endwhile; else: ?>
					<div class="post excerpt">
						<div class="no-results">
							<p><strong><?php _e('There has been an error.', 'mythemeshop'); ?></strong></p>
							<p><?php _e('We apologize for any inconvenience, please hit back on your browser or use the search form below.', 'mythemeshop'); ?></p>
							<?php get_search_form(); ?>
						</div><!--noResults-->
					</div>
				<?php endif; ?>
				<?php if ($options['mts_pagenavigation'] == '1') { ?>
					<?php pagination($additional_loop->max_num_pages);?>
				<?php } else { ?>
					<div class="pnavigation2">
						<div class="nav-previous left"><?php next_posts_link( __( 'Older posts', 'mythemeshop' ) ); ?></div>
						<div class="nav-next right"><?php previous_posts_link( __( 'Newer posts', 'mythemeshop' ) ); ?></div>
					</div>
				<?php } ?>
			</div>
		</article>
		<?php get_sidebar(); ?>
<?php get_footer(); ?>