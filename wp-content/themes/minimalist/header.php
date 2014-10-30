<?php $options = get_option('minimalist'); ?>
<!DOCTYPE html>
<html class="no-js" <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo('charset'); ?>">
	<title><?php wp_title(''); ?></title>
	<?php mts_meta(); ?>
	<link rel="stylesheet" type="text/css" media="all" href="<?php bloginfo( 'stylesheet_url' ); ?>" />
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />
	<?php wp_enqueue_script("jquery"); ?>
	<?php if ( is_singular() ) wp_enqueue_script( 'comment-reply' ); ?>
	<!--[if lt IE 9]>
	<script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
	<![endif]-->
	<?php wp_head(); ?>
	<?php mts_head(); ?>
</head>
<?php flush(); ?>
<body id ="blog" <?php body_class('main'); ?>>
	<header class="main-header">
		<div class="container">
			<div id="header">
				<?php if ($options['mts_logo'] != '') { ?>
					<?php if( is_front_page() || is_home() || is_404() ) { ?>
							<h1 id="logo">
								<a href="<?php echo home_url(); ?>"><img src="<?php echo $options['mts_logo']; ?>" alt="<?php bloginfo( 'name' ); ?>"></a>
							</h1><!-- END #logo -->
					<?php } else { ?>
						  <h2 id="logo">
								<a href="<?php echo home_url(); ?>"><img src="<?php echo $options['mts_logo']; ?>" alt="<?php bloginfo( 'name' ); ?>"></a>
							</h2><!-- END #logo -->
					<?php } ?>
				<?php } else { ?>
					<?php if( is_front_page() || is_home() || is_404() ) { ?>
							<h1 id="logo">
								<a href="<?php echo home_url(); ?>"><?php bloginfo( 'name' ); ?></a>
							</h1><!-- END #logo -->
					<?php } else { ?>
						  <h2 id="logo">
								<a href="<?php echo home_url(); ?>"><?php bloginfo( 'name' ); ?></a>
							</h2><!-- END #logo -->
					<?php } ?>
				<?php } ?>
				<?php if ( ! dynamic_sidebar( 'Header' ) ) : ?><?php endif ?>
			</div><!--#header-->
			<div class="main-navigation">
				<nav id="navigation">
					<?php if ( has_nav_menu( 'primary-menu' ) ) { ?>
						<?php wp_nav_menu( array( 'theme_location' => 'primary-menu', 'menu_class' => 'menu', 'container' => '' ) ); ?>
					<?php } else { ?>
						<ul class="menu">
							<li class="home-tab"><a href="<?php echo home_url(); ?>">Home</a></li>
							<?php wp_list_pages('title_li='); ?>
						</ul>
					<?php } ?><!--#nav-primary-->
				</nav>
			</div>
		</div><!--.container-->
	</header>
<div class="main-container">