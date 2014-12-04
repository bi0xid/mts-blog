<?php
/**
 * Template Name: Landingpage
 */
?>
<!DOCTYPE html>
<?php $options = get_option('spike'); ?>
<html class="no-js" <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo('charset'); ?>">
	<title><?php wp_title(''); ?></title>
	<?php mts_meta(); ?>
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />
	<?php wp_enqueue_script("jquery"); ?>
	<?php if ( is_singular() ) wp_enqueue_script( 'comment-reply' ); ?>
	<!--[if lt IE 9]>
	<script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
	<![endif]-->
	<?php wp_head(); ?>
	<link rel="stylesheet" type="text/css" media="all" href="<?php bloginfo( 'stylesheet_url' ); ?>" />
	<?php mts_head(); ?>
	<meta name="p:domain_verify" content="2299c127dcf14a09af8856aae852cd5e"/>
</head>
<?php flush(); ?>
<body id ="blog" <?php body_class('main'); ?>>
    <div id="fb-root"></div>	
    <div class="main-container">
        <div id="page">
            <div class="content">
		<article class="ss-full-width">
                    <div id="content_box" >
                        <div id="content" class="hfeed">
                            <?php if ( have_posts() ) while ( have_posts() ) : the_post(); ?>
                                <div id="post-<?php the_ID(); ?>" <?php post_class('g post'); ?>>
                                        <div class="post-content box mark-links">
                                                <?php the_content(); ?>                                                
                                        </div><!--.post-content box mark-links -->
                                </div><!--.g post-->
                            <?php endwhile; ?>
                        </div>
                    </div>
		</article>
                <?php $options = get_option('spike'); ?>
            </div>
	</div><!--#page-->
    </div><!--.main-container-->
    <?php mts_footer(); ?>
    <?php wp_footer(); ?>
</body>
</html>
