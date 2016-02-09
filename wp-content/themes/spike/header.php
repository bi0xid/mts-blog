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
<style>.single_post a {
  color: #de0079;
}</style>
</head>
<?php flush(); ?>
<body id ="blog" <?php body_class('main'); ?>>
    <div id="fb-root"></div>
	<header class="main-header">
		<div class="container">
			<div id="header">
				<?php if ($options['mts_logo'] != '') { ?>
					<?php if( is_front_page() || is_home() || is_404() ) { ?>
							<h1 id="logo" class="image-logo">
								<a href="<?php echo home_url(); ?>"><img src="<?php echo $options['mts_logo']; ?>" width="290px" height="90px" alt="<?php bloginfo( 'name' ); ?>"></a>
							</h1><!-- END #logo -->
					<?php } else { ?>
						  <h2 id="logo" class="image-logo">
								<a href="<?php echo home_url(); ?>"><img src="<?php echo $options['mts_logo']; ?>" width="290px" height="90px" alt="<?php bloginfo( 'name' ); ?>"></a>
							</h2><!-- END #logo -->
					<?php } ?>
				<?php } else { ?>
					<?php if( is_front_page() || is_home() || is_404() ) { ?>
							<h1 id="logo" class="text-logo">
								<a href="<?php echo home_url(); ?>"><?php bloginfo( 'name' ); ?></a>
							</h1><!-- END #logo -->
					<?php } else { ?>
						  <h2 id="logo" class="text-logo">
								<a href="<?php echo home_url(); ?>"><?php bloginfo( 'name' ); ?></a>
							</h2><!-- END #logo -->
					<?php } ?>
				<?php } ?>
				<div class="secondary-navigation">
					<div id="mobile-navigation">
						<span class="toggler"></span>
						<h2>MyTinySecrets</h2>
						<ul class="menu-wrapper">
							<?php wp_list_categories('title_li='); ?>
						</ul>
						<span class="search-toggler"></span>
					</div>
					<nav id="navigation" >
						<?php if ( has_nav_menu( 'primary-menu' ) ) { ?>
							<?php wp_nav_menu( array( 'theme_location' => 'primary-menu', 'menu_class' => 'menu', 'container' => '' ) ); ?>
						<?php } else { ?>
							<ul class="menu">
								<?php wp_list_categories('title_li='); ?>
							</ul>
						<?php } ?>
					</nav>
				</div>
			</div><!--#header-->
		</div><!--.container-->
		<div id="header-mail-form">
			<div id="header-form-content">
				<div id="top-form-textbox">
					<h1>
						WANT TO BECOME Sexually  <br>
						<span class="bold-part">Healthy & Happy?</span>
						<p>Join The Secret Sunday List & Get 1 FREE Actionable Secret Every Sunday.</p>
					</h1>
				</div>
				<div id="header-form-wrapper">
                                    <div id="WFItem7323202" class="wf-formTpl">
                                        <form accept-charset="utf-8" action="<?php echo get_home_url(); ?>/sign-up/register.php" method="post">
                                            <input type="hidden" name="form_type" value="header">
                                            <div class="box">
                                                <div id="WFIcenter" class="wf-body">
                                                    <ul class="wf-sortable" id="pb-top-form">
                                                        <li class="pb-name" rel="undefined" style="display:  block !important;">
                                                            <div class="wf-contbox">
                                                                <div class="wf-inputpos">
                                                                        <input type="text" placeholder="Enter Your First Name Here" data-placeholder="yes" class="wf-input" name="name"></input>
                                                                </div>
                                                                <em class="clearfix clearer"></em>
                                                            </div>
                                                        </li>
                                                        <li class="pb-email" rel="undefined" style="display:  block !important;">
                                                            <div class="wf-contbox">
                                                                <div class="wf-inputpos">
                                                                        <input type="email" required="required" placeholder="Enter Your E-mail Here" data-placeholder="yes" class="wf-input wf-req wf-valid__email" name="email"></input>
                                                                </div>
                                                                <em class="clearfix clearer"></em>
                                                            </div>
                                                        </li>
                                                        <li class="wf-submit" rel="undefined" style="display:  block !important;">
                                                            <div class="wf-contbox">
                                                                <div class="wf-inputpos">
                                                                        <input type="submit" style="width: 74px ! important; display:  inline !important;" value="Sign Up!" class="wf-button" id="top-form-submit" name="submit"></input>
                                                                </div>
                                                                <em class="clearfix clearer"></em>
                                                            </div>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
				</div>
			</div>
		</div>
	</header>
	<div class="main-container">
