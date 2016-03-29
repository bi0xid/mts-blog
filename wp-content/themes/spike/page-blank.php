<?php
/**
 * Template Name: Page Blank
 */
?>
<title><?php the_title(); ?></title>
<script type='text/javascript' src='//ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js?ver=1.7.1'></script>
<script type='text/javascript' src='http://newsletter.mytinysecrets.com/api/js/subscribe.js' async></script>
<link rel="stylesheet" href="http://mtsloveschool.com/wp-content/themes/zeyn/css/reset-css.css">
<link rel="stylesheet" href="http://mtsloveschool.com/wp-content/themes/zeyn/css/core.css">
<link rel="stylesheet" href="http://mtsloveschool.com/wp-content/themes/zeyn/css/webform.css">
<link rel="stylesheet" href="http://mtsloveschool.com/wp-content/themes/zeyn/css/template.css">
<style type="text/css">
#load, header {
   display: none;
}</style>
<script>
jQuery(document).ready(function(){
	jQuery('#button').click(function(){
	       jQuery('#load').show();
	       jQuery('#button').hide();
	});
});</script>

<?php //get_header(); ?>
<div id="page">
	<div class="content">
		<article class="ss-full-width">
			<div id="content_box" >
				<div id="content" class="hfeed">
					<?php if ( have_posts() ) while ( have_posts() ) : the_post(); ?>
						<div id="post-<?php the_ID(); ?>" <?php post_class('g post'); ?>>
							<header>
								<h1 class="title"><?php the_title(); ?></h1>
							</header>
							<div class="post-content box mark-links">
								<?php the_content(); ?>
								<?php wp_link_pages('before=<div class="pagination">&after=</div>'); ?>
							</div><!--.post-content box mark-links -->
						</div><!--.g post-->
						<?php comments_template( '', true ); ?>
					<?php endwhile; ?>
				</div>
			</div>
		</article>
<?php //get_footer(); ?>

