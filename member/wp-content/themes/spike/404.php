<?php get_header(); ?>
<div id="page">
	<div class="content">
		<article class="article">
			<div id="content_box" >
				<div id="content" class="hfeed">
                     <?php
                            $isPostFound = false;
                            $sRequestUri = $_SERVER['REQUEST_URI'];                            
                            if(preg_match("/(?P<url>[^\/]+)\/$/", $sRequestUri, $aMathes)){
                                $sUrl = $aMathes['url'];                                
                                global $wpdb;
                                $post = (int)$wpdb->get_var($wpdb->prepare( "SELECT ID FROM $wpdb->posts WHERE post_name = %s AND (post_status='publish' or post_status='private')", $sUrl));
                                if($post) $isPostFound = true;
                            }
                        ?>
					<header>
						<div class="title">
                            <?php if(!$isPostFound): ?>
                                <h1><?php _e('Error 404 Not Found', 'mythemeshop'); ?></h1>
                            <?php else: ?>
                                <h1><?php _e('Protected content', 'mythemeshop'); ?></h1>
                            <?php endif; ?>
						</div>
					</header>
					<div class="post-content">                       
                        <?php if(!$isPostFound): ?>
                            <p><?php _e('Oops! We couldn\'t find this Page.', 'mythemeshop'); ?></p>
                            <p><?php _e('Please check your URL or use the search form below.', 'mythemeshop'); ?></p>
                        <?php else: ?>
                            <p><?php _e('This is protected content.', 'mythemeshop'); ?></p>
                            <p><?php _e('Please sign up to see it.', 'mythemeshop'); ?></p>
                        <?php endif; ?>
						<?php get_search_form();?>
					</div><!--.post-content--><!--#error404 .post-->
				</div><!--#content-->
			</div><!--#content_box-->
		</article>
		<?php get_sidebar(); ?>
<?php get_footer(); ?>