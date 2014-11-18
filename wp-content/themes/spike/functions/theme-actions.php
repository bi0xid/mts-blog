<?php
$options = get_option('spike');	

/*------------[ Meta ]-------------*/
if ( ! function_exists( 'mts_meta' ) ) {
	function mts_meta() { 
	global $options
?>
<?php if ($options['mts_favicon'] != '') { ?>
<link rel="icon" href="<?php echo $options['mts_favicon']; ?>" type="image/x-icon" />
<?php } ?>
<?php if (is_front_page()) { $args = array( 'numberposts' => 1); $myposts = get_posts( $args ); setup_postdata($myposts); ?>
	<link rel="prefetch" href="<?php the_permalink(); ?>">
	<link rel="prerender" href="<?php the_permalink(); ?>">
<?php } elseif (is_singular()) { ?>
	<link rel="prefetch" href="<?php echo home_url(); ?>">
	<link rel="prerender" href="<?php echo home_url(); ?>">
<?php } ?>
<!--iOS/android/handheld specific -->	
<link rel="apple-touch-icon" href="<?php echo home_url(); ?>/apple-touch-icon.png">
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
.title, h1,h2,h3,h4,h5,h6, .slidertitle, .total-comments { font-family: '<?php if ($options['mts_google_title_font'] != '') { ?><?php echo $options['mts_google_title_font']; ?><?php } else { ?><?php echo $options['mts_title_font']; ?><?php } ?>', sans-serif;}
</style>
<?php } ?>
<?php } ?>
<?php if ($options['mts_content_font'] == 'Arial') { ?>
<?php } else { ?>
<?php if ($options['mts_content_font'] != '' || $options['mts_google_content_font'] != '') { ?>
<link href="http://fonts.googleapis.com/css?family=<?php if ($options['mts_google_content_font'] != '') { ?><?php echo $options['mts_google_content_font']; ?><?php } else { ?><?php echo $options['mts_content_font']; ?><?php } ?>:400,400italic,700,700italic" rel="stylesheet" type="text/css">
<style type="text/css">
body {font-family: '<?php if ($options['mts_google_content_font'] != '') { ?><?php echo $options['mts_google_content_font']; ?><?php } else { ?><?php echo $options['mts_content_font']; ?><?php } ?>', sans-serif;}
</style>
<?php } ?>
<?php } ?>
<!--end fonts-->
<style type="text/css">
<?php if($options['mts_bg_color'] != '') { ?>
body {background-color:<?php echo $options['mts_bg_color']; ?>;}
<?php } ?>
<?php if ($options['mts_bg_pattern_upload'] != '') { ?>
body {background-image: url(<?php echo $options['mts_bg_pattern_upload']; ?>);}
<?php } else { ?>
<?php if($options['mts_bg_pattern'] != '') { ?>
body {background-image:url(<?php echo get_template_directory_uri(); ?>/images/<?php echo $options['mts_bg_pattern']; ?>.png);}
<?php } ?>
<?php } ?>
<?php if ($options['mts_color_scheme'] != '') { ?>
#commentform input#submit,#search-image, .mts-subscribe input[type="submit"], .sbutton, .currenttext, .pagination a:hover, .flex-active, .tagcloud a,.reply a, .flex-control-paging li a.flex-active {background-color:<?php echo $options['mts_color_scheme']; ?>; }
.text-logo, .tagcloud a .tab_count,.flex-control-paging li a {background-color:<?php echo $options['mts_color_scheme2']; ?>;}
<?php function hex2rgba($hex, $opacity) {
	$a = $opacity;
   $hex = str_replace("#", "", $hex);
   if(strlen($hex) == 3) {
      $r = hexdec(substr($hex,0,1).substr($hex,0,1));
      $g = hexdec(substr($hex,1,1).substr($hex,1,1));
      $b = hexdec(substr($hex,2,1).substr($hex,2,1));
   } else {
      $r = hexdec(substr($hex,0,2));
      $g = hexdec(substr($hex,2,2));
      $b = hexdec(substr($hex,4,2));
   }
  echo $r,',', $g,',', $b, ',', $a;
} ?>
.slidertext, .slidertitle {background:rgba(<?php hex2rgba($options['mts_color_scheme'],0.70); ?>)}
.pagination a, .pagination2 { border:1px solid <?php echo $options['mts_color_scheme2']; ?>; color:<?php echo $options['mts_color_scheme2']; ?>;}
footer .widget .tweets li a, #tabber .inside li .entry-title a:hover, .single .post-info a, .single_post a, a:hover, .textwidget a, #commentform a, .copyrights a:hover, a,
.sidebar.c-4-12 a:hover, footer .copyrights a, .widget li a:hover, footer .widget a:hover, .advanced-recent-posts a:hover,.related-posts a:hover {color:<?php echo $options['mts_color_scheme']; ?>; }
.currenttext, .pagination a:hover{border:1px solid <?php echo $options['mts_color_scheme'];?>;}
.current-menu-item a, .secondary-navigation a:hover, .current-post-parent a { border-bottom:1px solid <?php echo $options['mts_color_scheme'];?>;}
#navigation ul ul{ border-top:1px solid <?php echo $options['mts_color_scheme'];?>; }
<?php } ?>
<?php if ($options['mts_layout'] == 'sclayout') { ?>
.article { float: right;}
.article{ padding-right:2% !important; padding-left:0;}
.sidebar.c-4-12 { float: left; padding-right: 0; padding-left: 2%; }
<?php } ?>
<?php if($options['mts_author_comment'] == '1') { ?>
.bypostauthor .commentmetadata {border: 1px solid #EEE!important; background: #FAFAFA; }
.bypostauthor .commentmetadata:after { content: "Author"; position: absolute; top: 0; right: 0; background: #CECECE; padding: 1px 10px; color: white; font-size: 12px; }
<?php } ?>
<?php if($options['mts_floating_header'] == '1') { ?>
.main-header {
position: fixed;
top: 0;
}
html {
margin-top: 87px!important;
}
<?php } ?>
<?php echo $options['mts_custom_css']; ?>
</style>
<?php echo $options['mts_header_code']; ?>
<?php }
}

/*------------[ Copyrights ]-------------*/
if ( ! function_exists( 'mts_copyrights_credit' ) ) {
	function mts_copyrights_credit() { 
	global $options
?>
<!--start copyrights-->
<div class="row" id="copyright-note">
<span>&copy; <?php echo date("Y") ?> <a href="<?php echo home_url(); ?>/" title="<?php bloginfo('description'); ?>" rel="nofollow"><?php bloginfo('name'); ?></a>. <?php _e('All Rights Reserved','mythemeshop'); ?>.</span>
<div class="top"><?php echo $options['mts_copyrights']; ?>&nbsp;<a href="#top" class="toplink" rel="nofollow"><?php _e('Back to Top','mythemeshop'); ?> &uarr;</a></div>
</div>
<!--end copyrights-->
<?php }
}

/*------------[ footer ]-------------*/
if ( ! function_exists( 'mts_footer' ) ) {
	function mts_footer() { 
	global $options
?>
<!--Twitter Button Script------> 
<script>
    !function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id; js.async = true; js.src="//platform.twitter.com/widgets.js";  fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");
</script>
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
  js.async = true;
  js.src = "//connect.facebook.net/en_US/all.js#xfbml=1&appId=136911316406581";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>
<?php if($options['mts_featured_slider'] == '1') { ?>
<!--start slider-->
	<?php if( is_home() ) { ?>
	<script type="text/javascript">
		$(window).load(function(){
		  $('.flexslider').flexslider({ animation: "fade", pauseOnHover: true, });  
		});
	</script>
	<?php } ?>
<!--end slider-->
<?php } ?>
<?php if($options['mts_lightbox'] == '1') { ?>
<!--start lightbox-->
<script type="text/javascript">  
jQuery(document).ready(function($) {
$("a[href$='.jpg'], a[href$='.jpeg'], a[href$='.gif'], a[href$='.png']").prettyPhoto({
slideshow: 5000,
autoplay_slideshow: false,
animationSpeed: 'normal',
padding: 40,
opacity: 0.35,
showTitle: true,
social_tools: false
});
})
</script>
<!--end lightbox-->
<?php } ?>
<?php if($options['mts_nav_search_form'] == '1') { ?>
<script type="text/javascript">
jQuery(document).ready(function(e) {(function($){
	var mc = 1;
	var ml = 1;
	$('.secondary-navigation ul').each(function(index, element) { $(this).addClass('menuul'+mc++); });		
	$('.secondary-navigation ul li').each(function(index, element) { $(this).addClass('menuli'+ml++); });		
	$('.secondary-navigation .menuul1').append('<li class="search_li"> <form method="get" id="searchform" class="search-form" action="<?php echo home_url(); ?>" _lpchecked="1"><fieldset><input type="text" name="s" id="s" value="Search the site"><input type="submit" value="Search" class="sbutton2" id="search-image"></fieldset></form> </li>');
	$('#respond .required').html('(required)');
}(jQuery)); });
$(window).load(function(){
$('.main-header #s')
  .on('focus', function(){
      var $this = $(this);
      if($this.val() == 'Search the site'){
          $this.val('');
      }
  })
  .on('blur', function(){
      var $this = $(this);
      if($this.val() == ''){
          $this.val('Search the site');
      }
  });
});
</script>
<?php } ?>
<?php if ($options['mts_analytics_code'] != '') { ?>
<!--start footer code-->
<?php echo $options['mts_analytics_code']; ?>
<!--end footer code-->
<?php } ?>
<?php }
}
?>