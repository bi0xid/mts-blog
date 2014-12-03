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
    <div class="main-container">
        <div id="page">
            <div class="content">
                <?php if ( have_posts() ) while ( have_posts() ) : the_post(); ?>
                    <h1 class="title"><?php the_title(); ?></h1>
                    <div class="post-content box mark-links">
                            <?php the_content(); ?>
                    </div>
                <?php endwhile; ?>
            </div>
        </div>
    </div>
</body>
</html>