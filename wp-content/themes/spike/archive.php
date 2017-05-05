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