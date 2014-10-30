<?php get_header(); ?>
<div id="page">
	<div class="content">
		<article class="article">
			<div id="content_box" >
				<div id="content" class="hfeed">
					<header>
						<div class="title">
							<h1><?php _e('Error 404 Not Found', 'mythemeshop'); ?></h1>
						</div>
					</header>
					<div class="post-content">
						<p><?php _e('Oops! We couldn\'t find this Page.', 'mythemeshop'); ?></p>
						<p><?php _e('Please check your URL or use the search form below.', 'mythemeshop'); ?></p>
						<?php get_search_form();?>
					</div><!--.post-content--><!--#error404 .post-->
				</div><!--#content-->
			</div><!--#content_box-->
            <div style="width: 100%; clear: both;"></div>
            <h4>You Might Enjoy Reading</h4>
            <div>
                <?php echo do_shortcode('[wpajax layout ="modern" col_width ="253" ajax_style ="scroll" button_label ="View more" button_text_color ="FFFFFF" button_bg_color ="35AA47" button_font ="0" button_size ="14" button_icon ="icon-double-angle-right" loading_image ="3" thumb_size ="thumbnail" post_title_color ="35AA47" post_title_font ="Arial" post_title_size ="18" post_excerpt_color ="444444" post_excerpt_font ="Arial" post_excerpt_size ="14" post_meta_color ="999999" post_meta_font ="Arial" post_meta_size ="11" thumb_hover_icon ="icon-search" thumb_hover_color ="35AA47" thumb_hover_bg ="FFFFFF" thumb_hover_popup ="1" popup_theme ="0" border_hover_color ="35AA47" border_hover_width ="1" tag ="" orderby ="date" order ="DESC" posts_per_page ="12" cat ="30,76,75,103,4,80,1" post_type ="" /]'); ?>
            </div>
		</article>
		<?php get_sidebar(); ?>
<?php get_footer(); ?>