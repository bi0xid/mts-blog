<?php
$options = get_option('minimalist');	

/*------------[ Meta ]-------------*/
if ( ! function_exists( 'mts_meta' ) ) {
	function mts_meta() { 
	global $options
?>
<?php if ($options['mts_favicon'] != '') { ?>
<link rel="icon" href="<?php echo $options['mts_favicon']; ?>" type="image/x-icon" />
<?php } ?>
<!--iOS/android/handheld specific -->	
<link rel="apple-touch-icon" href="apple-touch-icon.png">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="apple-mobile-web-app-capable" content="yes">
<meta name="apple-mobile-web-app-status-bar-style" content="black">
<?php }
}

/*------------[ Head ]-------------*/
if ( ! function_exists( 'mts_head' ) ) {
	function mts_head() { 
	global $options
?>
<!--start fonts-->
<?php if ($options['mts_title_font'] == 'Arial') { ?>
<?php } else { ?>
	<?php if ($options['mts_title_font'] != '' || $options['mts_google_title_font'] != '') { ?>
		<link href="http://fonts.googleapis.com/css?family=<?php if ($options['mts_google_title_font'] != '') { ?><?php echo $options['mts_google_title_font']; ?><?php } else { ?><?php echo $options['mts_title_font']; ?><?php } ?>:400,700" rel="stylesheet" type="text/css">
		<style type="text/css">
			.title, h1,h2,h3,h4,h5,h6, #header-logo h1, #header-logo h2, .secondary-navigation a, .widget h3, .total-comments, .slidertitle { font-family: '<?php if ($options['mts_google_title_font'] != '') { ?><?php echo $options['mts_google_title_font']; ?><?php } else { ?><?php echo $options['mts_title_font']; ?><?php } ?>', sans-serif;}
		</style>
	<?php } ?>
<?php } ?>
<?php if ($options['mts_content_font'] == 'Arial') { ?>
<?php } else { ?>
	<?php if ($options['mts_content_font'] != '' || $options['mts_google_content_font'] != '') { ?>
		<link href="http://fonts.googleapis.com/css?family=<?php if ($options['mts_google_content_font'] != '') { ?><?php echo $options['mts_google_content_font']; ?><?php } else { ?><?php echo $options['mts_content_font']; ?><?php } ?>:400,400italic,700,700italic" rel="stylesheet" type="text/css">
		<style type="text/css">
			body { font-family: '<?php if ($options['mts_google_content_font'] != '') { ?><?php echo $options['mts_google_content_font']; ?><?php } else { ?><?php echo $options['mts_content_font']; ?><?php } ?>', sans-serif; }
		</style>
	<?php } ?>
<?php } ?>
<!--end fonts-->
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script>
<script src="<?php echo get_template_directory_uri(); ?>/js/modernizr.min.js"></script>
<script src="<?php echo get_template_directory_uri(); ?>/js/customscript.js" type="text/javascript"></script>
<!--start slider-->
<?php if($options['mts_featured_slider'] == '1') { ?>
	<?php if( is_home() ) { ?>
		<link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/css/flexslider.css" type="text/css">
		<script src="<?php echo get_template_directory_uri(); ?>/js/jquery.flexslider-min.js"></script>
		<script type="text/javascript">
		$(window).load(function() {
			$('.flexslider').flexslider({
				  animation: "fade",
			  pauseOnHover: true,
				  controlsContainer: ".flex-container"
			});
		});
		</script>
	<?php } ?>
<?php } ?>
<!--end slider-->
<style type="text/css">
	body {
	<?php if ($options['mts_bg_pattern_upload'] != '') { ?>
		background-image: url(<?php echo $options['mts_bg_pattern_upload']; ?>);
	<?php } else { ?>
	<?php if($options['mts_bg_pattern'] != '') { ?>
		background: <?php if($options['mts_bg_color'] != '') { ?><?php echo $options['mts_bg_color']; ?><?php } ?> url(<?php echo get_template_directory_uri(); ?>/images/<?php echo $options['mts_bg_pattern']; ?>.png) repeat;
	<?php } ?>
	<?php } ?>
	<?php if ($options['mts_body_font_color'] != '') { ?>
		color: <?php echo $options['mts_body_font_color']; ?>;
	<?php } ?>
	}
	<?php if($options['mts_content_bg_color'] != '') { ?>
		.main-container, .main-navigation, #tabber .inside, #tabber ul.tabs li a.selected, #tabber ul.tabs li a, #navigation ul ul li, #tabber ul.tabs li.tab-recent-posts a.selected {
		background-color:<?php echo $options['mts_content_bg_color']; ?>;
		}
	<?php } ?>
	<?php if($options['mts_color_scheme'] != '') { ?>
		.currenttext, .pagination a:hover, #navigation ul li li:hover > a, .more a, .mts-subscribe input[type="submit"]:hover, .tagcloud a:hover { background-color: <?php echo $options['mts_color_scheme']; ?>; }
		a, .title a:hover, .widget a:hover, .post-info a:hover, div.IPRight li a:hover, .copyrights a:hover, .single div.IPRight li a, a:hover { color:<?php echo $options['mts_color_scheme']; ?>; }
	<?php } ?>
	<?php if($options['mts_floating_social'] == '1') { ?>
		.shareit { top: 260px; left: auto; z-index: 0; margin: 0 0 0 -125px; width: 90px; position: fixed; overflow: hidden; padding: 3px; background: #F1F1F1; border: 1px solid #CCC; -webkit-border--radius: 6px; -moz-border-radius: 6px; border-radius: 6px; }
		.share-item { margin: 2px; }
	<?php } ?>
	<?php if($options['mts_layout'] == 'sclayout') { ?>
		.article { float: right; border-right: 0; border-left: 1px solid #D5D5D5; padding-right: 0; padding-left: 20px; }
		div.IPRight { margin-right:0; margin-left:30px; }
		#content_box { padding-right: 10px; padding-left: 10px; }
		.sidebar.c-4-12 { float: left; }
		<?php if($options['mts_floating_social'] == '1') { ?>
		.shareit { margin: 0 0 0 675px; }
		<?php } ?>
	<?php } ?>
	<?php if($options['mts_author_comment'] == '1') { ?>
		.bypostauthor { border: 1px solid #EEE!important; padding: 15px 5px 0 15px!important; background: #FAFAFA; }
		.bypostauthor .reply { border-bottom: 0; }
	<?php } ?>
	<?php echo $options['mts_custom_css']; ?>
</style>
<?php echo $options['mts_header_code']; ?>
<?php }
}
/*------------[ footer ]-------------*/
if ( ! function_exists( 'mts_footer' ) ) {
	function mts_footer() { 
	global $options
?>
<!--Twitter Button Script------>
<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src="//platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>
<script type="text/javascript">
  (function() {
    var po = document.createElement('script'); po.type = 'text/javascript'; po.async = true;
    po.src = 'https://apis.google.com/js/plusone.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(po, s);
  })();
</script>
<!--Facebook Like Button Script------>
<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/en_US/all.js#xfbml=1&appId=136911316406581";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>
<!--start lightbox-->
<?php if($options['mts_lightbox'] == '1') { ?>
<link rel="stylesheet" href="<?php bloginfo('template_directory'); ?>/css/prettyPhoto.css" type="text/css" media="screen" charset="utf-8" />
<script src="<?php bloginfo('template_directory'); ?>/js/jquery.prettyPhoto.js"></script>
<script type="text/javascript">  
	jQuery(document).ready(function($) {
	$("a[href$='.jpg'], a[href$='.jpeg'], a[href$='.gif'], a[href$='.png']").prettyPhoto({ slideshow: 5000, autoplay_slideshow: false,  animationSpeed: 'normal', padding: 40, opacity: 0.35, showTitle: true, social_tools: false }); })
</script>
<?php } ?>
<!--end lightbox-->
<!--start footer code-->
<?php if ($options['mts_analytics_code'] != '') { ?>
	<?php echo $options['mts_analytics_code']; ?>
<?php } ?>
<!--end footer code-->
<?php }
}
/*------------[ Copyrights ]-------------*/
if ( ! function_exists( 'mts_copyrights_credit' ) ) {
	function mts_copyrights_credit() { 
	global $options
?>
<!--start copyrights-->
<div class="copyrights">
	<div class="container">
		<div class="row" id="copyright-note">
			<?php if ($options['mts_copyrights'] != '') { ?>
					<?php echo $options['mts_copyrights']; ?>
			<?php } else { ?>
				<span>Copyright 2012 <a href="http://mythemeshop.com">MyThemeShop</a>.</span>
			<?php } ?>
		</div>
		<div class="top"><a href="#top"><?php _e('Back to Top','mythemeshop'); ?> &uarr;</a></div>
	</div>
</div>
<?php }
}
?>