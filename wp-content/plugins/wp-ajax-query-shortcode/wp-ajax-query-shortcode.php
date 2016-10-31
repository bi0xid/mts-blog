<?php
/**
 * Plugin Name: WP Ajax Query Shortcode
 * Plugin URI: http://leafcolor.com/wp-quick-ajax/
 * Description: A plugin to create awesome ajax query post for your WP site
 * Version: 2.2.1
 * Author: Leafcolor
 * Author URI: http://leafcolor.com
 * License: GPL2
 */

// Exit if accessed directly
defined( 'ABSPATH' ) || exit;


if (!defined( 'WAQ_PATH' ) ) {
	define( 'WAQ_PATH', plugin_dir_url( __FILE__ ) );
}

require_once ('core/plugin-options.php');

$waq_id = 0;

/**
 * Setup shortcode
 * Get default settings
 * Call template render
 */
function wp_ajax_shortcode( $atts, $content = "" ) {
	$waq_options = waq_get_all_option();    
	$atts = shortcode_atts( array(
		'author'                 => NULL,
		'author_name'            => '',
		'cat'                    => implode(",",$waq_options['cat']),
		'category_name'          => '',
		'tag'                    => $waq_options['tag'],
		'tag_id'                 => NULL,
		'product_cat'            => '',
		'p'                      => NULL,
		'name'                   => '',
		'page_id'                => '',
		'pagename'               => '',
		'post_parent'            => '',
		'post_type'              => implode(",",$waq_options['post_type']),
		'post_status'            => 'publish',
		'posts_per_page'         => $waq_options['posts_per_page'],
		'posts_per_archive_page' => '',
		'offset'                 => 0,
		'order'                  => $waq_options['order'],
		'orderby'                => $waq_options['orderby'],
		'ignore_sticky_posts'    => true,
		'year'                   => NULL,
		'monthnum'               => NULL,
		'w'                      =>  NULL,
		'day'                    => NULL,
		'meta_key'               => '',
		'meta_value'             => '',
		'meta_compare'           => '',
		'layout'                 => $waq_options['layout'],
		'col_width'              => $waq_options['col_width'],
		'ajax_style'             => $waq_options['ajax_style'],
		'button_label'           => $waq_options['button_label'],
		'button_text_color'      => $waq_options['button_text_color'],
		'button_bg_color'        => $waq_options['button_bg_color'],
		'button_font'            => $waq_options['button_font'],
		'button_size'            => $waq_options['button_size'],
		'button_icon'            => $waq_options['button_icon'],
		'loading_image'          => $waq_options['loading_image'],
		'thumb_size'             => $waq_options['thumb_size'],
		'post_title_color'       => $waq_options['post_title_color'],
		'post_title_font'        => $waq_options['post_title_font'],
		'post_title_size'        => $waq_options['post_title_size'],
		'post_excerpt_color'     => $waq_options['post_excerpt_color'],
		'post_excerpt_font'      => $waq_options['post_excerpt_font'],
		'post_excerpt_size'      => $waq_options['post_excerpt_size'],
		'post_excerpt_limit'     => $waq_options['post_excerpt_limit'],
		'post_meta_color'        => $waq_options['post_meta_color'],
		'post_meta_font'         => $waq_options['post_meta_font'],
		'post_meta_size'         => $waq_options['post_meta_size'],
		'thumb_hover_icon'       => $waq_options['thumb_hover_icon'],
		'thumb_hover_color'      => $waq_options['thumb_hover_color'],
		'thumb_hover_bg'         => $waq_options['thumb_hover_bg'],
		'thumb_hover_popup'      => $waq_options['thumb_hover_popup'],
		'popup_theme'            => $waq_options['popup_theme'],
		'border_hover_color'     => $waq_options['border_hover_color'],
		'border_hover_width'     => $waq_options['border_hover_width'],
		'full_post'              => '0',
		'global_query'           => '0',
		'related_query'          => '0',
		'related_tag_query'      => '0'
	), $atts );
	
	if( $atts['layout'] != 'modern' ) {
		$atts['offset'] = (int)$atts['posts_per_page'];
	}
	
	if( $atts['post_type'] == 'attachment' ) {
		$atts['post_status']='inherit';
	}

	if( $atts['global_query'] == '1' ) {
		global $wp_query;
		$atts_old = $atts;
		$atts = array_merge( $atts, $wp_query->query_vars );
		$atts['posts_per_page'] = $atts_old['posts_per_page'];
		$atts['paged'] = 1;
	}

	if( $atts['related_query'] == '1' ) {
		global $post;
		$related_arg = array(
			'category__in' => wp_get_post_categories( $post->ID ),
			'post__not_in' => array( $post->ID ) 
		);
		$atts = array_merge( $atts, $related_arg );
	}

	if($atts['related_tag_query'] == '1' ) {
		global $post;
		$tags = "";

		$posttags = get_the_tags( $post->ID );
		if ( $posttags ) {
			foreach( $posttags as $tag ) {
				$tags .= ',' . $tag->slug; 
			}
		}

		// Remove first comma
		$tags = substr($tags, 1);

		$related_arg = array(
			'tag' => $tags,
			'post__not_in' => array($post->ID) 
		);
		$atts = array_merge( $atts, $related_arg );
	}

	if( is_multisite() ){
		$atts['multisite'] = get_current_blog_id();
	}

	if($atts['layout'] == 'modern') {
		$atts['post__not_in'] = array(get_the_ID());
	}

	return wp_ajax_template($atts);
}

add_shortcode('wpajax', 'wp_ajax_shortcode');

/**
 * Render template
 * @return HTML
 */
function wp_ajax_template( $atts ) {
	global $waq_id;

	$waq_id++;

	$atts['waq_id'] = $waq_id;

	// Start the HTML Return
	ob_start(); ?>
	<style>
		<?php if($atts['layout']=='modern'||$atts['layout']=='combo'){ ?>
		#waq<?php echo $waq_id; ?> .ajax-item{ /*width:280px */}
		<?php } ?>
		#waq<?php echo $waq_id; ?> .ajax-item-head a{
			color:#<?php echo $atts['post_title_color'] ?>;
			<?php if($atts['post_title_font']){ ?>font-family:"<?php echo $atts['post_title_font'] ?>", sans-serif;<?php } ?>
			font-size:<?php echo $atts['post_title_size'] ?>px;
		}
		#waq<?php echo $waq_id; ?> .ajax-item-meta, #waq<?php echo $waq_id; ?> .ajax-item-meta a {
			color:#<?php echo $atts['post_meta_color'] ?>;
			<?php if($atts['post_meta_font']){ ?>font-family:"<?php echo $atts['post_meta_font'] ?>", sans-serif;<?php } ?>
			font-size:<?php echo $atts['post_meta_size'] ?>px;
		}
		#waq<?php echo $waq_id; ?> .ajax-item-meta a:hover {
			// color:#<?php echo $atts['post_title_color'] ?>;
		}
		#waq<?php echo $waq_id; ?> .ajax-item-content, #waq<?php echo $waq_id; ?> .ajax-item-content p {
			color:#<?php echo $atts['post_excerpt_color'] ?>;
			<?php if($atts['post_excerpt_font']){ ?>font-family:"<?php echo $atts['post_excerpt_font'] ?>", sans-serif;<?php } ?>
			font-size:<?php echo $atts['post_excerpt_size'] ?>px;
		}
		#waq<?php echo $waq_id; ?> .wp-ajax-query-button a, #waq<?php echo $waq_id; ?> .wp-ajax-query-button a:visited{
			background:#<?php echo $atts['button_bg_color'] ?>;
			color:#<?php echo $atts['button_text_color'] ?>;
			<?php if($atts['button_font']){ ?>font-family:"<?php echo $atts['button_font'] ?>", sans-serif;<?php } ?>
			font-size:<?php echo $atts['button_size'] ?>px;
			padding: 1px <?php echo $atts['button_size'] ?>px;
		}
		#waq<?php echo $waq_id; ?> .link-overlay:before {
			//color: #<?php echo $atts['thumb_hover_color'] ?>;
			//background: #<?php echo $atts['thumb_hover_bg'] ?>;
		}
		<?php if($atts['layout']=='classic'||$atts['layout']=='timeline'){ ?>
		#waq<?php echo $waq_id; ?> .ajax-item:hover{
			//box-shadow:inset -<?php echo $atts['border_hover_width'] ?>px 0px 0px #<?php echo $atts['border_hover_color'] ?>;
		}
		<?php }else{ ?>
		#waq<?php echo $waq_id; ?>.modern .ajax-item:hover .ajax-item-content-wrap{
			//box-shadow:inset 0px -<?php echo $atts['border_hover_width'] ?>px 0px #<?php echo $atts['border_hover_color'] ?>, 0 0px 1px rgba(0,0,0,0.075), 0 1px 2px rgba(0,0,0,0.075);
		}
		<?php } ?>
		<?php if($atts['layout']=='combo'){ ?>
		.wp-ajax-query-shortcode.comboed .ajax-item:hover{
			//box-shadow:inset -1px 0px 0px #<?php echo $atts['border_hover_color'] ?>;
		}
		<?php } ?>
		<?php if($atts['layout']=='timeline'){ ?>
		#waq<?php echo $waq_id; ?>.wp-ajax-query-shortcode.timeline .ajax-item{
			//border-left-color: #<?php echo $atts['border_hover_color'] ?>;
		}
		#waq<?php echo $waq_id; ?>.wp-ajax-query-shortcode.timeline .ajax-item:before{
			//background-color: #<?php echo $atts['border_hover_color'] ?>;
		}
		#waq<?php echo $waq_id; ?>.wp-ajax-query-shortcode.timeline .ajax-item:after{
			//color: #<?php echo $atts['border_hover_color'] ?>;
		}
		<?php } ?>
	</style>

	<div id="waq<?php echo $waq_id; ?>" class="wp-ajax-query-shortcode <?php echo $atts['layout']=='combo'?$atts['layout'].' modern':($atts['layout']=='timeline'?$atts['layout'].' classic':$atts['layout']) ?>">
		<div class="wp-ajax-query-wrap">
			<?php if($atts['layout']=='combo'){ ?>
				<center><button class="ajax-layout-toggle">Switch layout  <i class="icon-random"></i></button></center>
			<?php } ?>
			<div class="wp-ajax-query-inner">
				<div class="wp-ajax-query-content">
					<?php echo wp_ajax_query($atts); ?>
				</div>
				<div class="clear"></div>
				<div class="wp-ajax-loading-images">
					<img src="<?php echo WAQ_PATH.'images/gray.gif'; ?>" width="88px" height="8px" />
				</div>
				<div class="wp-ajax-query-button <?php echo $atts['ajax_style']=='scroll'?'hide-button':'' ?>"><a href="#"><?php echo $atts['button_label']; echo $atts['button_icon']?' &nbsp;<i class="'.$atts['button_icon'].'"></i>':'' ?></a></div>
			</div>
		</div>
	</div>

	<div class="clear"></div>

	<script>
		jQuery(function() {
			<?php if($atts['ajax_style']=='scroll') { ?>
				jQuery(window).scroll(function() {
					if(jQuery('#waq<?php echo $atts['waq_id']; ?> .wp-ajax-query-button a').length && waq_isScrolledIntoView(jQuery('#waq<?php echo $waq_id; ?> .wp-ajax-query-button a')) && !window.short_code_ajax_is_loading) {

						ajaxParam = <?php echo json_encode($atts); ?>;
						ajaxParam['home_url'] = "<?php echo home_url( '/' );?>";
						ajaxParam['waq_id'] = "<?php echo $atts['waq_id']; ?>";

						wp_ajax_query_shortcode<?php echo $atts['layout'] == 'combo' ? 'modern' : ($atts['layout'] == 'timeline' ? 'classic' : $atts['layout']) ?>(ajaxParam);
					}
				});
			<?php } else { ?>
			jQuery('#waq<?php echo $atts['waq_id']; ?> .wp-ajax-query-button a').on('click',function() {

				ajaxParam = <?php echo json_encode($atts); ?>;
				ajaxParam['home_url'] = "<?php echo home_url("/");?>";
				ajaxParam['waq_id'] = "<?php echo $atts['waq_id']; ?>";
				wp_ajax_query_shortcode<?php echo $atts['layout'] == 'combo' ? 'modern' : ($atts['layout'] == 'timeline' ? 'classic' : $atts['layout']) ?>(ajaxParam);
				return false;
			});
			<?php } ?>
		});

		jQuery(document).ready(function() {
			wp_ajax_query_resize();
			$columnwidth = jQuery('#waq<?php echo $waq_id; ?> .ajax-item').width();
			$container = jQuery('#waq<?php echo $waq_id; ?>.modern .wp-ajax-query-content');

			$container.imagesLoaded(function() {
				wp_ajax_query_resize();
			});

			$container.masonry({
				itemSelector : '.ajax-item',
				columnWidth  : $columnwidth,
				isFitWidth   : true,
				gutter       : 0
			});
		});

		jQuery(window).load(function(e) {
			$container.imagesLoaded(function() {
				wp_ajax_query_resize();
				$container.masonry('reload');
			});
		});
	</script>
	<?php
	$html = ob_get_clean();

	return $html;
}

/**
 * Do the query with parameters
 */
function wp_ajax_query( $atts = '' ) {
	global $waq_id;

	$is_ajax = 0;

	if( $atts == '' ) {
		$is_ajax = 1;
		$atts = $_GET;

		if( $atts['global_query'] ) {
			unset( $atts['no_found_rows'] );
			unset( $atts['suppress_filters'] );
			unset( $atts['cache_results'] );
			unset( $atts['update_post_term_cache'] );
			unset( $atts['update_post_meta_cache'] );
			unset( $atts['nopaging'] );
		}
	}

	if( $atts['post_excerpt_limit'] > 0 ) {
		add_filter( 'excerpt_length', 'waq_custom_excerpt_length', 999 );
	}

	if( $atts['multisite'] ) {
		switch_to_blog( $atts['multisite'] );
	}

	foreach( $atts as $key => $val ) {
		if ( $atts[$key] == null || $atts[$key] == 'null' || $atts[$key] == '' ) {
			unset( $atts[$key] );
		}
	}

	$html = '';
	$my_query = new WP_Query( $atts );

	if( $my_query->have_posts() ) {
		ob_start();

		if( $atts['layout']=='classic' ) {
			echo '<div>';
		}

		while ( $my_query->have_posts() ) {
			$my_query->the_post();

			if( $atts['post_type']=='attachment' ) {
				$thumb = wp_get_attachment_image_src( get_the_ID(), $atts['thumb_size'] );
				$full = wp_get_attachment_image_src( get_the_ID(), 'large' );
			} else {
				$thumb = wp_get_attachment_image_src( get_post_thumbnail_id(), $atts['thumb_size'] );
				$full = wp_get_attachment_image_src( get_post_thumbnail_id(), 'large' );
			}

			if( $atts['layout'] == 'classic' && $atts['ajax_runnig'] ) { ?>
				<div class="post excerpt" data-id="<?php echo the_id(); ?>">
					<div class="post_excerpt_l">
						<a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>" rel="nofollow" id="featured-thumbnail">
							<?php if ( has_post_thumbnail() ) { ?> 
								<?php echo '<div class="featured-thumbnail">'; the_post_thumbnail('featured',array('title' => '')); echo '</div>'; ?>
							<?php } else { ?>
								<div class="featured-thumbnail">
									<img width="298" height="248" src="<?php echo get_template_directory_uri(); ?>/images/nothumb.png" class="attachment-featured wp-post-image" alt="<?php the_title(); ?>">
								</div>
							<?php } ?>
						</a>
					</div>
					<div class="post_excerpt_r">
						<header>
							<?php
								if ( has_post_thumbnail() ) {
									echo '<div class="featured-thumbnail-mobile featured-thumbnail-mobile_add">';
									the_post_thumbnail( 'featured', array( 'title' => '' ) );
									echo '</div>';
								};
							?>
							<h2 class="title">
								<a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>" rel="bookmark"><?php the_title(); ?></a>
							</h2>
							<div class="post-info">
								<span class="theauthor"><?php _e('By ','mythemeshop'); the_author_posts_link(); ?></span>
								<span class="thecategory"><?php the_category(', '); ?></span>
								<span class="thetime"><?php the_time('M d, Y'); ?></span> 
								<div class="thecomment">
									<a href="<?php comments_link(); ?>" rel="nofollow"><?php comments_number( '0 Comment', '1 Comment', '% Comments' ); ?></a>		
								</div>
							</div>
						</header>
						<div class="post-content image-caption-format-1">
							<?php echo excerpt( 53 ); ?> 
							<a class="pereadore" href="<?php the_permalink(); ?>" title="<?php the_title(); ?>" rel="nofollow">
								<?php _e( '...Read More','mythemeshop' ); ?>
							</a>
						</div>
						<div class="home_meta_comment_social get_social_counter_result" data-id="<?php echo get_the_ID(); ?>" id="get_social_counter_result_<?php echo get_the_ID(); ?>">
							<?php
								$important_social = array(
									'facebook_like' => array(
										'name'  => 'Likes',
										'value' => get_post_meta( get_the_ID(), 'facebook_likes', true )
											? get_post_meta( get_the_ID(), 'facebook_likes', true )
											: 0
									),
									'facebook_shares' => array(
										'name'  => 'Share',
										'value' => get_post_meta( get_the_ID(), 'facebook_shares', true )
											? get_post_meta( get_the_ID(), 'facebook_shares', true )
											: 0,
										'link'  => 'https://www.facebook.com/sharer/sharer.php?u='.get_the_permalink()
									)
								);

								$social_networks = array(
									'google' => array(
										'name'  => 'Google+',
										'value' => get_post_meta( get_the_ID(), 'google_shares', true )
											? get_post_meta( get_the_ID(), 'google_shares', true )
											: 0,
										'link'  => 'https://plus.google.com/share?url='.get_the_permalink()
									),
									'pinterest' => array(
										'name'  => 'Pinterest',
										'value' => get_post_meta( get_the_ID(), 'pinterest_shares', true )
											? get_post_meta( get_the_ID(), 'pinterest_shares', true )
											: 0,
										'href'  => "javascript:void((function(){var%20e=document.createElement('script');e.setAttribute('type','text/javascript');e.setAttribute('charset','UTF-8');e.setAttribute('src','http://assets.pinterest.com/js/pinmarklet.js?r='+Math.random()*99999999);document.body.appendChild(e)})());"
									),
									'stumbleupon' => array(
										'name' => 'StumbleUpon',
										'value' => get_post_meta( get_the_ID(), 'stumble_shares', true )
											? get_post_meta( get_the_ID(), 'stumble_shares', true )
											: 0,
										'link' => 'http://www.stumbleupon.com/badge/?url='.get_the_permalink()
									),
									'digg' => array(
										'name'  => 'Digg',
										'value' => get_post_meta( get_the_ID(), 'digg_post_type', true )
											? get_post_meta( get_the_ID(), 'digg_post_type', true )
											: 0,
										'link'  => 'http://digg.com/submit?phase=2%20&amp;url='.get_the_permalink().'&amp;title='.get_the_title()
									),
									'email' => array(
										'name'  => 'E-mail',
										'value' => get_post_meta( get_the_ID(), 'total_email_shares', true )
											? get_post_meta( get_the_ID(), 'total_email_shares', true )
											: 0
									)
								);

								function shuffle_assoc( $array ) {
									$keys = array_keys( $array );

									shuffle( $keys );

									foreach( $keys as $key ) {
										$new[$key] = $array[$key];
									}

									$array = $new;

									return $array;
								}

								$social_networks = shuffle_assoc( $social_networks );
								$social_networks = array_slice( $social_networks, 0, 1 );

								$result = array_merge( $important_social, $social_networks );
							?>

							<ul class="social_shares">
								<?php
									foreach ( $result as $key => $value ) {
										echo '<li class="share_item '.$key.'">';
											if( $value['link'] ) {
												echo '<a href="#" data-url="'.$value['link'].'" data-media="'.$key.'" class="share-item-button modal">';
											} elseif( $value['href'] ) {
												echo '<a href="'.$value['href'].'" class="share-item-button">';
											} else {
												echo '<a href="#" data-media="'.$key.'" class="share-item-button">';
											}
												echo '<span class="icon"></span>';
												echo '<span>'.$value['name'].'</span>';
											echo '</a>';
											echo '<span class="counter">'.$value['value'].'</span>';
										echo '</li>';
									}
								?>
							</ul>

						</div>
					</div>
				</div>

			<?php } elseif( $atts['ajax_runnig'] ) { ?>
				<div class="ajax-item">
					<div class="ajax-item-pad">                
					<?php if ( has_post_thumbnail() || $atts['post_type']=='attachment') { ?>

						<a href="<?php echo get_permalink() ?>" title="<?php the_title() ?>">
		 
						<div class="ajax-item-thumb">
							<?php if ( has_post_thumbnail() ) { ?> 
								<?php echo '<div class="featured-thumbnail">'; the_post_thumbnail('featured',array('title' => '')); echo '</div>'; ?>
							<?php } else { ?>
								<div class="featured-thumbnail">
									<img width="298" height="248" src="<?php echo get_template_directory_uri(); ?>/images/nothumb.png" class="attachment-featured wp-post-image" alt="<?php the_title(); ?>">
								</div>
							<?php } ?>
							<?php if($atts['thumb_hover_icon']){ ?>
							<div class="link-overlay <?php echo $atts['thumb_hover_icon']?>"></div>
							<?php } ?>
						</div>
						</a>
						<?php } ?>
						<div class="ajax-item-content-wrap <?php echo has_post_thumbnail()?'':'no-thumb' ?>">
						  <?php if($atts['post_title_size']){ ?>
						  <h2 class="ajax-item-head">
							<a href="<?php echo get_permalink() ?>" title="<?php the_title() ?>">
							<?php the_title(); ?>
							</a>
						  </h2>
						  <br />
						  <?php }?>
						  <?php if($atts['post_meta_size']){ ?>
						  <div class="ajax-item-meta">
							<?php
							if( is_plugin_active('woocommerce/woocommerce.php') && $atts['post_type']=='product' ){ //woo product
								$product = new WC_Product( get_the_ID() );
							?>
							<span><?php echo $product->get_price_html(); ?> &nbsp;&nbsp;<a href="<?php echo do_shortcode('[add_to_cart_url id="'.get_the_ID().'"]'); ?>" title="<?php _e('Add to cart','leafcolor') ?>"><i class="icon-shopping-cart"></i>+</a></span>
							<?php }else{ ?>
							<span><i class="icon-time"></i> <?php the_time(get_option('date_format')); ?> &nbsp;&nbsp;<i class="icon-user"></i> <?php the_author_link(); ?></span>
							<?php }?>
						  </div>
						  <br />
						  <?php }?>
						</div>
						<div class="clear"></div>
					</div>
				</div>
			<?php }

			wp_reset_postdata();

			if($atts['layout']=='classic') {
				echo '</div>';
			}

			$html = ob_get_clean();

			if( $is_ajax==1 ) {
				echo $html; 
				die();
			}

			remove_filter( 'excerpt_length', 'waq_custom_excerpt_length' );
			return $html;
		}

		if( $atts['multisite'] ) {
			restore_current_blog();
		}
	}
}

add_action( 'wp_ajax_wp_ajax_query', 'wp_ajax_query');
add_action( 'wp_ajax_nopriv_wp_ajax_query', 'wp_ajax_query');

//load js and css
add_action( 'wp_enqueue_scripts', 'wp_ajax_shortcode_scripts' );
function wp_ajax_shortcode_scripts(){
	wp_enqueue_script('jquery');
	wp_enqueue_script('waq-masonry', plugins_url( 'js/masonry.min.js', __FILE__ ), array('jquery'));
	wp_enqueue_script('prettyPhoto',  plugins_url( 'js/prettyPhoto/jquery.prettyPhoto.js', __FILE__ ), array('jquery'));
	wp_enqueue_script('wpajax', plugins_url( 'js/main.js', __FILE__ ), array('jquery'));
	$waq_options = waq_get_all_option();
	if($waq_options['fontawesome']==0){
		wp_enqueue_style('font-awesome', plugins_url( 'font-awesome/css/font-awesome.min.css', __FILE__ ));
	}
	wp_enqueue_style('prettyPhoto', plugins_url( 'js/prettyPhoto/css/prettyPhoto.css', __FILE__ ));
	wp_enqueue_style('wpajax', plugins_url( 'style.css', __FILE__ ));
}

/*
 * Get all plugin options
 */
function waq_get_all_option(){
	$waq_options = get_option('waq_options_group');
	$waq_options['layout'] = isset($waq_options['layout'])?$waq_options['layout']:'modern';
	$waq_options['col_width'] = isset($waq_options['col_width'])?$waq_options['col_width']:'225';
	$waq_options['ajax_style'] = isset($waq_options['ajax_style'])?$waq_options['ajax_style']:'button';
	//button
	$waq_options['button_label'] = isset($waq_options['button_label'])?$waq_options['button_label']:'View more';
	$waq_options['button_text_color'] = isset($waq_options['button_text_color'])?$waq_options['button_text_color']:'FFFFFF';
	$waq_options['button_bg_color'] = isset($waq_options['button_bg_color'])?$waq_options['button_bg_color']:'35aa47';
	$waq_options['button_font'] = isset($waq_options['button_font'])?$waq_options['button_font']:'0';
	$waq_options['button_size'] = isset($waq_options['button_size'])?$waq_options['button_size']:'14';
	$waq_options['button_icon'] = isset($waq_options['button_icon'])?$waq_options['button_icon']:'icon-search';
	$waq_options['loading_image'] = isset($waq_options['loading_image'])?$waq_options['loading_image']:'1';	
	$waq_options['thumb_size'] = isset($waq_options['thumb_size'])?$waq_options['thumb_size']:'thumbnail';
	$waq_options['post_title_color'] = isset($waq_options['post_title_color'])?$waq_options['post_title_color']:'35aa47';
	$waq_options['post_title_font'] = isset($waq_options['post_title_font'])?$waq_options['post_title_font']:'0';
	$waq_options['post_title_size'] = isset($waq_options['post_title_size'])?$waq_options['post_title_size']:'18';
	$waq_options['post_excerpt_color'] = isset($waq_options['post_excerpt_color'])?$waq_options['post_excerpt_color']:'444444';
	$waq_options['post_excerpt_font'] = isset($waq_options['post_excerpt_font'])?$waq_options['post_excerpt_font']:'0';
	$waq_options['post_excerpt_size'] = isset($waq_options['post_excerpt_size'])?$waq_options['post_excerpt_size']:'14';
	$waq_options['post_excerpt_limit'] = isset($waq_options['post_excerpt_limit'])?$waq_options['post_excerpt_limit']:'0';
	$waq_options['post_meta_color'] = isset($waq_options['post_meta_color'])?$waq_options['post_meta_color']:'999999';
	$waq_options['post_meta_font'] = isset($waq_options['post_meta_font'])?$waq_options['post_meta_font']:'0';
	$waq_options['post_meta_size'] = isset($waq_options['post_meta_size'])?$waq_options['post_meta_size']:'11';
	
	$waq_options['thumb_hover_icon'] = isset($waq_options['thumb_hover_icon'])?$waq_options['thumb_hover_icon']:'icon-search';
	$waq_options['thumb_hover_color'] = isset($waq_options['thumb_hover_color'])?$waq_options['thumb_hover_color']:'35aa47';
	$waq_options['thumb_hover_bg'] = isset($waq_options['thumb_hover_bg'])?$waq_options['thumb_hover_bg']:'ffffff';
	$waq_options['thumb_hover_popup'] = isset($waq_options['thumb_hover_popup'])?$waq_options['thumb_hover_popup']:'1';
	$waq_options['popup_theme'] = isset($waq_options['popup_theme'])?$waq_options['popup_theme']:'0';
	$waq_options['border_hover_color'] = isset($waq_options['border_hover_color'])?$waq_options['border_hover_color']:'35AA47';
	$waq_options['border_hover_width'] = isset($waq_options['border_hover_width'])?$waq_options['border_hover_width']:'1';
	$waq_options['cat'] = isset($waq_options['cat'])?$waq_options['cat']:array();
	$waq_options['tag'] = isset($waq_options['tag'])?$waq_options['tag']:'';
	$waq_options['post_type'] = isset($waq_options['post_type'])?$waq_options['post_type']:array();
	$waq_options['orderby'] = isset($waq_options['orderby'])?$waq_options['orderby']:'date';
	$waq_options['order'] = isset($waq_options['order'])?$waq_options['order']:'DESC';
	$waq_options['posts_per_page'] = isset($waq_options['posts_per_page'])&&$waq_options['posts_per_page']?$waq_options['posts_per_page']:'10';
	$waq_options['waq_rtl'] = isset($waq_options['waq_rtl'])?$waq_options['waq_rtl']:'0';
	$waq_options['fontawesome'] = isset($waq_options['fontawesome'])?$waq_options['fontawesome']:'0';
	return $waq_options;
}
function waq_custom_excerpt_length( $length ) {
	$waq_options = waq_get_all_option();
	return $waq_options['post_excerpt_limit']?$waq_options['post_excerpt_limit']:$length;
}
//Visual Composer
add_action( 'after_setup_theme', 'reg_quick_ajax' );
function reg_quick_ajax() {
	if( function_exists( 'wpb_map' ) ) {
		$sizes = waq_list_thumbnail_sizes();
		$thumbnail_array = array();
		foreach( $sizes as $size => $atts ){
			 $thumbnail_array[$size.' '.implode('x',$atts)]=$size;
		}
		$cats = get_terms( 'category', 'hide_empty=0' );
		$cat_array = array();
		if($cats){
			foreach ($cats as $acat){
				$cat_array[$acat->name]=$acat->term_id;
			}
		}
		
		vc_map( array(
			"name" => __("Quick Ajax", "leafcolor"),
			"base" => "wpajax",
			"content_element" => true,
			"show_settings_on_create" => true,
			"icon" => "quick-ajax-icon",
			"params" => array(
				array(
					"type" => "dropdown",
					"holder" => "div",
					"heading" => __("Layout", "leafcolor"),
					"param_name" => "layout",
					"value" => array(
						__("Classic","leafcolor")=>'classic',
						__("Timeline","leafcolor")=>'timeline',
						__("Modern","leafcolor")=>'modern',
						__("Combo","leafcolor")=>'combo'
					),
					"description" => ""
				),
				array(
					"type" => "textfield",
					"heading" => __("Column width", "leafcolor"),
					"param_name" => "col_width",
					"value" => "",
					"description" => __('Only number for px(Ex: 225) Uses for column width in Modern layout and Thumbnail width in Classic layout', "leafcolor")
				),
				array(
					"type" => "dropdown",
					"holder" => "div",
					"heading" => __("Ajax style", "leafcolor"),
					"param_name" => "ajax_style",
					"value" => array(
						__("Next Button","leafcolor")=>'button',
						__("Infinity Scroll","leafcolor")=>'scroll'
					),
					"description" => ""
				),
				array(
					"type" => "dropdown",
					"holder" => "div",
					"heading" => __("Thumbnail Size", "leafcolor"),
					"param_name" => "thumb_size",
					"value" => $thumbnail_array,
					"description" => ""
				),
				array(
					"type" => "checkbox",
					"heading" => __("Choose category", "leafcolor"),
					"param_name" => "cat",
					"value" => $cat_array,
				  "description" => __("Select Categories", "leafcolor")
				),
				array(
					"type" => "textfield",
					"heading" => __("Tags", "leafcolor"),
					"param_name" => "tag",
					"value" => "",
					"description" => __('Ex: foo,bar,sample-tag (Uses tag slug)', "leafcolor")
				),
				array(
					"type" => "posttypes",
					"heading" => __("Post Type", "leafcolor"),
					"param_name" => "post_type",
					"value" => "",
					"description" => ""
				),
				array(
					"type" => "textfield",
					"heading" => __("Posts per page", "leafcolor"),
					"param_name" => "posts_per_page",
					"value" => "",
					"description" => __("Number of posts per page", "leafcolor"),
				),
			),
			"js_view" => 'VcColumnView'
		) );
	}
}
