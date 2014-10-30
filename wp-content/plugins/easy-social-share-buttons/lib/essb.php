<?php

class EasySocialShareButtons {
	
	protected $version = "1.0.9";
	protected $plugin_name = "Easy Social Share Buttons for WordPress";
	protected $plugin_slug = "easy-social-share-buttons";
	
	public static $plugin_settings_name = "easy-social-share-buttons";
	
	public static $instance = null;
	
	public function __construct() {
		// register admin page
		add_action ( 'admin_menu', array ($this, 'init_menu' ) );
		
		if (is_admin ()) {
			add_action ( 'admin_enqueue_scripts', array ($this, 'register_admin_assets' ), 1 );
		} else {
			add_action ( 'wp_enqueue_scripts', array ($this, 'register_front_assets' ), 1 );
		}
		
		add_action ( 'the_content', array ($this, 'print_share_links' ), 10, 1 );
		add_action ( 'the_excerpt', array ($this, 'print_share_links' ), 10, 1 );
		add_shortcode ( 'essb', array ($this, 'handle_essb_shortcode' ) );
		add_shortcode ( 'easy-share', array ($this, 'handle_essb_shortcode' ) );
		add_shortcode ( 'easy-social-share-buttons', array ($this, 'handle_essb_shortcode' ) );
		
		add_action('add_meta_boxes', array ($this, 'handle_essb_metabox' ) );
		
		add_action('save_post',  array ($this, 'handle_essb_save_metabox'));
		
		// @since 1.0.1 - Facebook Like Button
		$option = get_option ( self::$plugin_settings_name );
		
		$included_fb_api = isset($option['facebook_like_button_api']) ? $option['facebook_like_button_api'] : '';
		
		if ($included_fb_api != 'true') {
			add_action ( 'wp_footer', array ($this, 'init_fb_script' ) );
		}
		
		// @since 1.0.4
		$include_vk_api = isset($option['vklike']) ? $option['vklike'] : '';
		
		if ($include_vk_api == 'true') {
			add_action('wp_footer', array($this, 'init_vk_script'));
		}		
		
		// @since 1.0.7 fix for mobile devices don't to pop network names
		$hidden_network_names = (isset($option['hide_social_name']) && $option['hide_social_name']==1) ? true : false;
		if ($hidden_network_names && $this->isMobile()){
			add_action('wp_head', array($this, 'fix_css_mobile_hidden_network_names'));
		}
		//add_action('woocommerce_share', array($this, 'handle_woocommerce_share'));
	}
	
	public static function get_instance() {
		
		// If the single instance hasn't been set, set it now.
		if (null == self::$instance)
			self::$instance = new self ();
		
		return self::$instance;
	
	}
	
	/**
	 * Activate plugin
	 */
	public static function activate() {
		$option = get_option ( self::$plugin_settings_name );
		if (! $option || empty ( $option ))
			update_option ( self::$plugin_settings_name, self::default_options () );
	}
	
	public static function deactivate() {
		delete_option ( self::$plugin_settings_name );
	}
	
	public static function default_options() {
		return array ('style' => 1, 'networks' => array ("facebook" => array (1, "Facebook" ), "twitter" => array (1, "Twitter" ), "google" => array (0, "Google+" ), "pinterest" => array (0, "Pinterest" ), "linkedin" => array (0, "LinkedIn" ), "digg" => array (0, "Digg" ), "stumbleupon" => array (0, "StumbleUpon" ), "vk" => array (0, "VKontakte" ), "mail" => array (1, "E-mail" ) ), 'show_counter' => 0, 'hide_social_name' => 0, 'target_link' => 1, 'twitter_user' => '', 'display_in_types' => array ('post' ), 'display_where' => 'bottom', 'mail_subject' => __ ( 'Visit this site %%siteurl%%', ESSB_TEXT_DOMAIN ), 'mail_body' => __ ( 'Hi, this may be intersting you: "%%title%%"! This is the link: %%permalink%%', ESSB_TEXT_DOMAIN ), 'colors' => array ("bg_color" => '', "txt_color" => '', 'facebook_like_button' => 'false' ) );
	}
	
	public function init_menu() {
        $user = wp_get_current_user();
        if(!in_array('administrator', $user->roles)) return false;
		add_menu_page ( "Easy Social Share Buttons", "Easy Social Share Buttons", 'edit_pages', "essb_settings", array (__CLASS__, 'essb_settings_load' ), ESSB_PLUGIN_URL . '/assets/images/essb_16.png', 113 );
	
	}
	
	public function essb_settings_load() {
		include (ESSB_PLUGIN_ROOT . 'lib/admin/essb-settings.php');
	}
	
	public function register_admin_assets() {
		wp_register_style ( 'essb-admin', ESSB_PLUGIN_URL . '/assets/css/essb-admin.css', array (), $this->version );
		wp_enqueue_style ( 'essb-admin' );

		wp_enqueue_script( 'jquery-ui-sortable' );
	}
	
	public function register_front_assets() {
		global $post;		
		
		$options = get_option ( EasySocialShareButtons::$plugin_settings_name );
		if (is_array ( $options )) {
			if (is_numeric ( $options ['style'] )) {
				
				$post_theme =  get_post_meta($post->ID,'essb_theme',true);
				if ($post_theme != "" && is_numeric($post_theme)) {
					$options['style'] = intval($post_theme);
				}
				
				$folder = "default";
				
				if ($options ['style'] == 1) { $folder = "default"; }
				if ($options ['style'] == 2) { $folder = "metro"; }
				if ($options ['style'] == 3) { $folder = "modern"; }
				if ($options ['style'] == 4) {
					$folder = "round";
				}
				
				wp_enqueue_style ( 'easy-social-share-buttons', ESSB_PLUGIN_URL . '/assets/css/' . $folder . '/' . 'easy-social-share-buttons.css', false, $this->version, 'all' );
			}
			
			$post_counters =  get_post_meta($post->ID,'essb_counter',true);
			
			if ($post_counters != '') {
				$options ['show_counter'] = intval($post_counters);
			}
			
			if (is_numeric ( $options ['show_counter'] ) && $options ['show_counter'] == 1) {
				wp_enqueue_script ( 'essb-counter-script', ESSB_PLUGIN_URL . '/assets/js/easy-social-share-buttons.js', array ( 'jquery' ), $this->version, true );
			}
			
			$display_where = isset($options['display_where']) ? $options['display_where'] : '';
			$post_display_where = get_post_meta($post->ID,'essb_position',true);
			if ($post_display_where != "") { $display_where = $post_display_where; }			
			
			if ($display_where == "float") {
				wp_enqueue_script ( 'essb-float-script', ESSB_PLUGIN_URL . '/assets/js/essb-float.js', array ('jquery' ), $this->version, true );
			}
			
			$plusbutton = isset($options['googleplus']) ? $options['googleplus'] : 'false';
			
			if ($plusbutton == 'true') {
				wp_enqueue_script ( 'essb-google-plusone', 'https://apis.google.com/js/plusone.js', array ('jquery' ), $this->version, true );
			}
		}
		
	}
	
	public function get_current_url($mode = 'base') {
		
		$url = 'http' . (is_ssl () ? 's' : '') . '://' . $_SERVER ['HTTP_HOST'] . $_SERVER ['REQUEST_URI'];
		
		switch ($mode) {
			case 'raw' :
				return $url;
				break;
			case 'base' :
				return reset ( explode ( '?', $url ) );
				break;
			case 'uri' :
				$exp = explode ( '?', $url );
				return trim ( str_replace ( home_url (), '', reset ( $exp ) ), '/' );
				break;
			default :
				return false;
		}
	}
	
	public function generate_share_snippet($networks = array(), $counters = 0, $is_current_page_url = 0, $is_shortcode = 0, $custom_share_text = '', $custom_share_address = '') {
	
		global $post;
		$essb_off = get_post_meta($post->ID,'essb_off',true);
		
		if ($essb_off == "true") { $show_me = false; } else {$show_me = true;}
		//		$show_me =  (get_post_meta($post->ID,'essb_off',true)== 1) ? false : true;			
		$show_me = 	$is_shortcode ? true : $show_me;
		//print $show_me;
		$post_display_where = get_post_meta($post->ID,'essb_position',true);
		$post_hide_network_names = get_post_meta($post->ID,'essb_names',true);
		
		$post_hide_fb = get_post_meta($post->ID,'essb_hidefb',true);
		$post_hide_plusone = get_post_meta($post->ID,'essb_hideplusone',true);
		$post_hide_vk = get_post_meta($post->ID,'essb_hidevk',true);
		
		// show buttons only if post meta don't ask to hide it, and if it's not a shortcode.
		if ( $show_me ) {
	
			// texts, URL and image to share
			$text = esc_attr(urlencode($post->post_title));
			$url = $post ? get_permalink() : $this->get_current_url( 'raw' );
			//$url = urlencode(get_permalink());
			if ( $is_current_page_url ) {
				$url = $this->get_current_url( 'raw' );
			}
			$url = apply_filters('essb_the_shared_permalink', $url);
			$image = has_post_thumbnail( $post->ID ) ? wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'single-post-thumbnail' ) : '';
	
			$pinterest_image = ($image != '') ? $image[0] : '';
			$pinterest_desc = $post->post_excerpt;
			
			// some markup filters
			$hide_intro_phrase 			= apply_filters('eesb_network_name', false);
			$share_the_post_sentence 	= apply_filters('eesb_intro_phrase_text', __('Share the post',ESSB_TEXT_DOMAIN) );
			$before_the_sps_content 	= apply_filters('eesb_before_the_snippet', '');
			$after_the_sps_content 		= apply_filters('eesb_after_the_snippet', '');
			$before_the_list 			= apply_filters('eesb_before_the_list', '');
			$after_the_list 			= apply_filters('eesb_after_the_list', '');
			$before_first_i 			= apply_filters('eesb_before_first_item', '');
			$after_last_i 				= apply_filters('eesb_after_last_item', '');
			$container_classes 			= apply_filters('eesb_container_classes', '');
			$rel_nofollow 				= apply_filters('eesb_links_nofollow', 'rel="nofollow"');
	
			// markup filters
			$div 	= apply_filters('eesb_container_tag', 'div');
			$p 		= apply_filters('eesb_phrase_tag', 'p');
			$ul 	= apply_filters('eesb_list_container_tag', 'ul');
			$li 	= apply_filters('eesb_list_of_item_tag', 'li');
	
	
			// get the plugin options
			$options = get_option(  EasySocialShareButtons::$plugin_settings_name );
	
			// classes and attributes options
			$target_link = (isset($options['target_link']) && $options['target_link']==1) ? ' target="_blank"' : '';
			$hidden_name_class = (isset($options['hide_social_name']) && $options['hide_social_name']==1) ? ' essb_hide_name' : '';
			$container_classes .= (intval($counters)==1) ? ' essb_counters' : '';
	
			// custom share message
			$active_custom_message =isset($options['customshare']) ? $options['customshare'] : 'false';
			$is_from_customshare = false;
			
			$custom_share_imageurl = isset($options['customshare_imageurl']) ? $options['customshare_imageurl'] : '';
			$custom_share_description = isset($options['customshare_description']) ? $options['customshare_description'] : '';
				
			
			$pinterest_sniff_disable = isset($options['pinterest_sniff_disable']) ? $options['pinterest_sniff_disable'] : 'false';
			
			if ($custom_share_text == '' && $active_custom_message == 'true') {
				$custom_share_text = isset($options['customshare_text']) ? $options['customshare_text'] : '';
				
			}
			if ($custom_share_text != '') {
				$text = $custom_share_text;
				$is_from_customshare = true;
			}
				
			if ($custom_share_address == '' && $active_custom_message == 'true') {
				$custom_share_address = isset($options['customshare_url']) ? $options['customshare_url'] : '';
				
			}
			if ($custom_share_address != '') {
				$url = $custom_share_address;
			}
			
			if ($custom_share_description != '' && $active_custom_message == 'true') {
				$pinterest_desc = $custom_share_description;
			}
				
			if ($custom_share_imageurl != '' && $active_custom_message == 'true') {
				$pinterest_image = $custom_share_imageurl;
			}
			
			// other options
			$display_where = isset($options['display_where']) ? $options['display_where'] : '';
			
			if ($post_display_where != '') { $display_where = $post_display_where; }
			if ($post_hide_network_names == '1') {
				$hidden_name_class = ' essb_hide_name';
			}
			
			$force_pinterest_snif = 1;
			if ($pinterest_sniff_disable == 'true') { $force_pinterest_snif = 0; }

			// beginning markup
			$block_content = $before_the_sps_content;
			$block_content .= "\n".'<'.$div.' class="essb_links '.$container_classes.' essb_displayed_'.$display_where.'" id="essb_displayed_'.$display_where.'">';						$block_content .= "<h2>Did you like the post? Make sure to share it with your friends.</h2>";
			$block_content .= $hide_intro_phrase ? '' : "\n".'<'.$p.' class="screen-reader-text essb_maybe_hidden_text">'.$share_the_post_sentence.' "'.get_the_title().'"</'.$p.'>'."\n";
			$block_content .= $before_the_list;
			$block_content .= "\n\t".'<'.$ul.' class="essb_links_list'.$hidden_name_class.'">';
			$block_content .= $before_first_i;
	
			// networks to display
			// 2 differents results by :
			// -- using hook (options from admin panel)
			// -- using shortcode/template-function (the array $networks in parameter of this function)
			$essb_networks = array();
	
			if ( count($networks) > 0 ) {
				$essb_networks = array();
				foreach($options['networks'] as $k => $v) {
					if(in_array($k, $networks)) {
						$essb_networks[$k]=$v;
						$essb_networks[$k][0]=1; //set its visible value to 1 (visible)
					}
				}
	
			}
			else {
				$essb_networks = $options['networks'];
			}
	
	
			$active_fb = false;		
			$active_pinsniff = false;						
			
			// each links (come from options or manual array)
			foreach($essb_networks as $k => $v) {                
				if( $v[0] == 1 ) {
					$api_link = $api_text = '';
					$url = apply_filters('essb_the_shared_permalink_for_'.$k, $url);
                    $iCountOfShares = 0;
                    
					$twitter_user = '';
	
					switch ($k) {
						case "twitter" :
							$api_link = 'https://twitter.com/intent/tweet?source=webclient&amp;original_referer='.$url.'&amp;text='.$text.'&amp;url='.$url.$twitter_user;
							$api_text = apply_filters('essb_share_text_for_'.$k, __('Share this article on Twitter',ESSB_TEXT_DOMAIN));
                            $iCountOfShares = (int)get_post_meta(get_the_ID(), 'twitter_shares_count', true);
							break;
	
						case "facebook" :
							$api_link = 'https://www.facebook.com/sharer/sharer.php?u='.$url;
							
							if ($is_from_customshare) {
								$api_link = 'https://www.facebook.com/sharer/sharer.php?s=100&p[url]='.$url.'&p[title]='.$text;
								
								if ($custom_share_description != '') {
									$api_link .= '&p[summary]='.$custom_share_description; 
								}
								// @ fix in 1.0.8
								if ($custom_share_imageurl != '') {
									$api_link .= '&p[images][0]='.$custom_share_imageurl;
								}	

								$api_link = preg_replace(array('#%%title%%#', '#%%siteurl%%#', '#%%permalink%%#'), array(get_the_title(), get_site_url(), get_permalink()), $api_link);
								
							}
							
							$api_text = apply_filters('essb_share_text_for_'.$k, __('Share this article on Facebook',ESSB_TEXT_DOMAIN));
                            $iCountOfShares = (int)get_post_meta(get_the_ID(), 'fbsharecount_shares_count', true);
							break;
	
						case "google" :
							$api_link = 'https://plus.google.com/share?url='.$url;
							$api_text = apply_filters('essb_share_text_for_'.$k, __('Share this article on Google+',ESSB_TEXT_DOMAIN));
                            $iCountOfShares = (int)get_post_meta(get_the_ID(), 'google_shares_count', true);
							break;
	
						case "pinterest" :
							if ( $pinterest_image != '' && $force_pinterest_snif==0 ) {
								$api_link = 'http://pinterest.com/pin/create/bookmarklet/?media='.$pinterest_image.'&amp;url='.$url.'&amp;title='.$text.'&amp;description='.$pinterest_desc;
								$api_link = preg_replace(array('#%%title%%#', '#%%siteurl%%#', '#%%permalink%%#'), array(get_the_title(), get_site_url(), get_permalink()), $api_link);								
							}
							else {
								$api_link = "javascript:void((function(){var%20e=document.createElement('script');e.setAttribute('type','text/javascript');e.setAttribute('charset','UTF-8');e.setAttribute('src','http://assets.pinterest.com/js/pinmarklet.js?r='+Math.random()*99999999);document.body.appendChild(e)})());";
								$target_link = "";
								$active_pinsniff = true;
							}
							$api_text = apply_filters('essb_share_text_for_'.$k, __('Share an image of this article on Pinterest',ESSB_TEXT_DOMAIN));
                            $iCountOfShares = (int)get_post_meta(get_the_ID(), 'pinterest_shares_count', true);
							break;
	
	
						case 'linkedin':
							$api_link = "http://www.linkedin.com/shareArticle?mini=true&amp;ro=true&amp;trk=EasySocialShareButtons&amp;title=".$text."&amp;url=".$url;
							$api_text = apply_filters('essb_share_text_for_'.$k, __('Share this article on LinkedIn',ESSB_TEXT_DOMAIN));
							break;
	
						case 'digg':
							$api_link = "http://digg.com/submit?phase=2%20&amp;url=".$url."&amp;title=".$text;
							$api_text = apply_filters('essb_share_text_for_'.$k, __('Share this article on Digg',ESSB_TEXT_DOMAIN));
                            $iCountOfShares = (int)get_post_meta(get_the_ID(), 'digg_post_type', true);
							break;
	
						case 'stumbleupon':
							$api_link = "http://www.stumbleupon.com/badge/?url=".$url;
							$api_text = apply_filters('essb_share_text_for_'.$k, __('Share this article on StumbleUpon',ESSB_TEXT_DOMAIN));
                            $iCountOfShares = (int)get_post_meta(get_the_ID(), 'stumble_shares_count', true);
							break;
	
						
	
						case 'vk':
							$api_link = "http://vkontakte.ru/share.php?url=".$url;
							$api_text = apply_filters('essb_share_text_for_'.$k, __('Share this article on VKontakte',ESSB_TEXT_DOMAIN));
							break;
	
						case 'mail' :
							if (strpos($options['mail_body'], '%%') || strpos($options['mail_subject'], '%%') ) {
								$api_link = esc_attr('mailto:?subject='.$options['mail_subject'].'&amp;body='.$options['mail_body']);
								$api_link = preg_replace(array('#%%title%%#', '#%%siteurl%%#', '#%%permalink%%#'), array(get_the_title(), get_site_url(), get_permalink()), $api_link);
							}
							else {
								$api_link = 'mailto:?subject='.$options['mail_subject'].'&amp;body='.$options['mail_body']." : ".$url;
							}
							$api_text = apply_filters('essb_share_text_for_'.$k, __('Share this article with a friend (email)',ESSB_TEXT_DOMAIN));
                            $iCountOfShares = (int)get_post_meta(get_the_ID(), 'mail_post_type', true);
							break;
					}

					$network_name = isset($v[1]) ? $v[1] : $k;
					
					if ($k != 'mail' && $k != 'pinterest') {
						if ($k == "facebook") { $network_name = "Share It"; } // change Facebook network name to whatever text
						if ($k == "twitter") { $network_name = "Tweet It"; } // change Facebook network name to whatever text
                            
                        if($k == "twitter")
                            $block_content .= '<'.$li.' class="essb_item essb_link_'.$k.'"><a href="'.$api_link.'" '.$rel_nofollow.' title="'.$api_text.'"'.$target_link.'><span class="essb_icon"></span><span class="essb_network_name">'.$network_name.'</span></a><span class="essb_counter">'.$iCountOfShares.'</span></'.$li.'>';
                        else
                            $block_content .= '<'.$li.' class="essb_item essb_link_'.$k.'"><a href="'.$api_link.'" '.$rel_nofollow.' title="'.$api_text.'"'.$target_link.' onclick="essb_window(\''.$api_link.'\'); return false;"><span class="essb_icon"></span><span class="essb_network_name">'.$network_name.'</span></a><span class="essb_counter">'.$iCountOfShares.'</span></'.$li.'>';						
					}
					else {
						if ($k == 'pinterest') {
						if (!$active_pinsniff) {
							$block_content .= '<'.$li.' class="essb_item essb_link_'.$k.'"><a href="'.$api_link.'" '.$rel_nofollow.' title="'.$api_text.'"'.$target_link.' onclick="essb_window(\''.$api_link.'\'); return false;"><span class="essb_icon"></span><span class="essb_network_name">'.$network_name.'</span></a><span class="essb_counter">'.$iCountOfShares.'</span><span class="essb_counter">'.$iCountOfShares.'</span></'.$li.'>';
						}
						else {
							$block_content .= '<'.$li.' class="essb_item essb_link_'.$k.'"><a href="'.$api_link.'" '.$rel_nofollow.' title="'.$api_text.'"'.$target_link.'><span class="essb_icon"></span><span class="essb_network_name">'.$network_name.'</span></a><span class="essb_counter">'.$iCountOfShares.'</span></'.$li.'>';
						}
						}
						else {
							$block_content .= '<'.$li.' class="essb_item essb_link_'.$k.'"><a href="'.$api_link.'" '.$rel_nofollow.' title="'.$api_text.'"><span class="essb_icon"></span><span class="essb_network_name">'.$network_name.'</span></a><span class="essb_counter">'.$iCountOfShares.'</span></'.$li.'>';								
						}
					}
	
				}
			}
			
			
			$post_counters =  get_post_meta($post->ID,'essb_counter',true);
				
			if ($post_counters != '') {
				$options ['show_counter'] = $post_counters;
			}
			$general_counters = (isset($options['show_counter']) && $options['show_counter']==1) ? 1 : 0;
			$hidden_info = '<input type="hidden" class="essb_info_plugin_url" value="'.ESSB_PLUGIN_URL.'" /><input type="hidden" class="essb_info_permalink" value="'.$url.'" />';
			
			$block_content .= $after_last_i;
			$block_content .= (($general_counters==1 && intval($counters)==1) || ($general_counters==0 && intval($counters)==1)) ? '<li class="essb_item essb_totalcount_item"><span class="essb_totalcount" title="'.__('Total: ', ESSB_TEXT_DOMAIN).'"><span class="essb_t_nb"></span></span></li>' : '';
			$block_content .= '</'.$ul.'>'."\n\t";
			$block_content .= $after_the_list;
			$block_content .= ( ($general_counters==1 && intval($counters)==1) || ($general_counters==0 && intval($counters)==1))  ? $hidden_info : '';
			
			$include_plusone_button = isset($options['googleplus']) ? $options['googleplus'] : 'false'; 
			$include_fb_likebutton = isset($options['facebook_like_button']) ? $options['facebook_like_button'] : '';
			$include_vklike = isset($options['vklike']) ? $options['vklike'] : '';

			if ($post_hide_fb == 'yes') { $include_fb_likebutton = 'false';}
			if ($post_hide_plusone == 'yes') { $include_plusone_button = 'false';}
			if ($post_hide_vk == 'yes') {
				$include_vklike = 'false';
			}
				
			if ($include_fb_likebutton == 'true' || $include_plusone_button == 'true' || $include_vklike == 'true') {
				$block_content .= '<div style="display: block; width: 100%; padding-top: 3px !important;">';				
			}
			
			if ($include_plusone_button == 'true') {
				//$block_content .= '<'.$div.' class="" style="position: relative; float: left;">'.$this->print_plusone_button($url).'</'.$div.'>';		
				$block_content .= $this->print_plusone_button($url);		
			}			
			
			if ($include_vklike == 'true') {
				$block_content .= $this->print_vklike_button($url);
			}
			
			if ($include_fb_likebutton == 'true') {
				//$block_content .= '<'.$div.' class="" style="postion: relative; float: left; padding-top:3px !important;">'.$this->print_fb_likebutton($url).'</'.$div.'>';
				$block_content .= $this->print_fb_likebutton($url);
			}
			if ($include_fb_likebutton == 'true' || $include_plusone_button == 'true') {
				$block_content .= '</div>';
			}
				
			$block_content .= '</'.$div.'>'."\n\n";
			$block_content .= $after_the_sps_content;
	
			$block_content .= '<script type="text/javascript">';
			$block_content .= 'function essb_window(oUrl) { window.open( oUrl, "essb_share_window", "height=300,width=550,resizable=1" );  }';
			//$block_content .= 'jQuery(document).ready(function() {
            //jQuery(\'.essb_link_facebook\').tooltipster({interactive: true});
			//jQuery(\'.essb_link_facebook\').tooltipster(\'update\', jQuery(\'#essb_fb_commands\').html());
			//
			//});';
			
			$block_content .= '</script>';
			
			//$block_content .= '<div id="essb_fb_commands" style="display: block;">'.$this->print_fb_sharebutton($url).$this->print_fb_likebutton($url). '</div>';
	
			// final markup
	
			return $block_content;
	
		} // end of if post meta hide sharing buttons
	
	} 
	
	public function print_vklike_button($address) {
		$output = '<div class="essb-vk" style="display: inline-block;vertical-align: top;overflow: hidden;height: 20px;width: 100px !important;"><div id="vk_like" style="float: left; poistion: relative;"></div></div>';
		
		return $output;
	}
	
	function print_plusone_button($address) {
		$output = '<div class="g-plusone" data-size="medium" data-href="'.$address.'"></div>';
		
		return $output;
	}
	
	function print_fb_likebutton($address) {
		$output = '<div class="fb-like" data-href="'.$address.'" data-layout="button_count" data-action="like" data-show-faces="false" data-share="false" data-width="292"></div>';
		
		return $output;
	}
	
	function print_fb_sharebutton($address) {
		$output = '<div class="fb-share-button" data-href="'.$address.'" data-type="button"></div>';
		
		return $output;
	}
	
	function print_share_links($content) {
		global $post;
			
		$options = get_option(  EasySocialShareButtons::$plugin_settings_name );
	
		if( isset($options['display_in_types']) ) {
	
			// write buttons only if administrator checked this type
			$is_all_lists = in_array('all_lists', $options['display_in_types']);
			$singular_options = $options['display_in_types'];
			
			$is_set_list = count($singular_options) > 0 ?  true: false;	
			
			unset($singular_options['all_lists']);
			
			$is_lists_authorized = (is_archive() || is_front_page() || is_search() || is_tag() || is_post_type_archive() || is_home()) && $is_all_lists ? true : false;
			$is_singular = is_singular($singular_options);

			if ($is_singular && !$is_set_list) { $is_singular = false; }
			
			if ( $is_singular || $is_lists_authorized ) {
	
				$post_counters =  get_post_meta($post->ID,'essb_counter',true);
					
				if ($post_counters != '') {
					$options ['show_counter'] = $post_counters;
				}
				
				$need_counters = $options['show_counter'] ? 1 : 0;	
							
	
				$links = $this->generate_share_snippet(array(), $need_counters);
	
				$display_where = isset($options['display_where']) ? $options['display_where'] : '';
				$post_position =  get_post_meta($post->ID,'essb_position',true);
				if ($post_position != '' ) { $display_where = $post_position; }
				
				if( 'top' == $display_where || 'both' == $display_where || 'float' == $display_where )
					$content = $links.$content;
				if( 'bottom' == $display_where || 'both' == $display_where )
					$content = $content.$links;
	
				return $content;
			}
			else
				return $content;
		}
		else
			return $content;
	
	} // end function
	
	function handle_essb_shortcode($atts) {
			
		$atts = shortcode_atts(array(
				//'buttons' 	=> 'facebook,twitter,mail,google,stumbleupon,linkedin,pinterest,digg,vk',
			    'buttons' => '',
				'counters'	=> 0,
				'current'	=> 1,
				'text' => '',
				'url' => ''
		), $atts);
			
		//print "shortcode handle";
		// buttons become array ("digg,mail", "digg ,mail", "digg, mail", "digg , mail", are right syntaxes)
		if ( $atts['buttons'] == '') {
			$networks = array();
		}
		else {
			$networks = preg_split('#[\s+,\s+]#', $atts['buttons']);
		}
		$counters = intval($atts['counters']);
		$current_page = intval($atts['current']);
		
		$text = isset($atts['text']) ? $atts['text'] : '';
		$url = isset($atts['url']) ? $atts['url'] : '';
	
		if( $current_page == 1 ) {
			wp_enqueue_script ( 'essb-counter-script', ESSB_PLUGIN_URL . '/assets/js/easy-social-share-buttons.js', array ('jquery' ), $this->version, true );
		}
			
		//ob_start();
		$output = $this->generate_share_snippet($networks, $counters, $current_page, 1, $text, $url); //do an echo
		//$output = ob_get_contents();
		//ob_end_clean();
			
		
		
		return $output;
	}
	
	public function handle_essb_metabox() {
		$options = get_option(  EasySocialShareButtons::$plugin_settings_name );
		$pts	 = get_post_types( array('public'=> true, 'show_ui' => true, '_builtin' => true) );
		$cpts	 = get_post_types( array('public'=> true, 'show_ui' => true, '_builtin' => false) );
		
		foreach ( $pts as $pt ) {
			if (in_array($pt, $options['display_in_types'])) {
				add_meta_box('essb_metabox', __('Easy Social Share Buttons', ESSB_TEXT_DOMAIN), 'essb_register_settings_metabox', $pt, 'side', 'high');
			}
		}
		foreach ( $cpts as $cpt ) {
			if (in_array($cpt, $options['display_in_types'])) {
				add_meta_box('essb_metabox', __('Easy Social Share Buttons', ESSB_TEXT_DOMAIN), 'essb_register_settings_metabox', $cpt, 'side', 'high');
			}
		}
	
	}
	
	public function handle_essb_save_metabox() {
		global $post, $post_id;
		
		if (! $post) {
			return $post_id;
		}
		
		if (! $post_id)
			$post_id = $post->ID;
			
			// if (! wp_verify_nonce ( @$_POST ['essb_nonce'],
		// 'essb_metabox_handler' ))
			// return $post_id;
			// if (defined ( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE)
			// return $post_id;
			
		// "essb_off"
		if (isset ( $_POST ['essb_off'] )) {
			if ($_POST ['essb_off'] != '')
				update_post_meta ( $post_id, 'essb_off', $_POST ['essb_off'] );
			else
				delete_post_meta ( $post_id, 'essb_off' );
		}
		
		if (isset ( $_POST ['essb_position'] )) {
			if ($_POST ['essb_position'] != '')
				update_post_meta ( $post_id, 'essb_position', $_POST ['essb_position'] );
			else
				delete_post_meta ( $post_id, 'essb_position' );
		}
		
		if (isset ( $_POST ['essb_theme'] )) {
			if ($_POST ['essb_theme'] != '')
				update_post_meta ( $post_id, 'essb_theme', $_POST ['essb_theme'] );
			else
				delete_post_meta ( $post_id, 'essb_theme' );
		}
		
		if (isset ( $_POST ['essb_names'] )) {
			if ($_POST ['essb_names'] != '')
				update_post_meta ( $post_id, 'essb_names', $_POST ['essb_names'] );
			else
				delete_post_meta ( $post_id, 'essb_names' );
		}		
		if (isset ( $_POST ['essb_counter'] )) {
			if ($_POST ['essb_counter'] != '')
				update_post_meta ( $post_id, 'essb_counter', $_POST ['essb_counter'] );
			else
				delete_post_meta ( $post_id, 'essb_counter' );
		}

		if (isset ( $_POST ['essb_hidefb'] )) {
			if ($_POST ['essb_hidefb'] != '')
				update_post_meta ( $post_id, 'essb_hidefb', $_POST ['essb_hidefb'] );
			else
				delete_post_meta ( $post_id, 'essb_hidefb' );
		}

		if (isset ( $_POST ['essb_hideplusone'] )) {
			if ($_POST ['essb_hideplusone'] != '')
				update_post_meta ( $post_id, 'essb_hideplusone', $_POST ['essb_hideplusone'] );
			else
				delete_post_meta ( $post_id, 'essb_hideplusone' );
		}		

		if (isset ( $_POST ['essb_hidevk'] )) {
			if ($_POST ['essb_hidevk'] != '')
				update_post_meta ( $post_id, 'essb_hidevk', $_POST ['essb_hidevk'] );
			else
				delete_post_meta ( $post_id, 'essb_hidevk' );
		}
	}
	
	public function init_fb_script() {
	
		$fb_appid = "";
	
	
		echo <<<EOFb
<div id="fb-root"></div>
<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/en_US/all.js#xfbml=1$fb_appid"
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>
	
EOFb;
	}
	
	public function init_vk_script() {
		$option = get_option ( self::$plugin_settings_name );
		
		$vkapp_id = isset($option['vklikeappid']) ? $option['vklikeappid'] : '';
		
		echo <<<EOFb
<script type="text/javascript" src="//vk.com/js/api/openapi.js?105"></script>
<script type="text/javascript">
window.onload = function () { 
  VK.init({apiId: $vkapp_id, onlyWidgets: true});
  VK.Widgets.Like("vk_like", {type: "button", height: 20});
}
</script>
EOFb;
	}
	
	public function handle_woocommerce_share() {
		$options = get_option(  EasySocialShareButtons::$plugin_settings_name );
		
		
		
				$need_counters = $options['show_counter'] ? 1 : 0;
					
		
				$links = $this->generate_share_snippet(array(), $need_counters);
		
		echo $links .'<div style="clear: both;\"></div>';		
	}
	
	// @since 1.0.7 - disable network name popup on mobile devices
	public function isMobile() {
		$user_agent = strtolower ( $_SERVER['HTTP_USER_AGENT'] );
		
		if ( preg_match ( "/phone|iphone|itouch|ipod|symbian|android|htc_|htc-|palmos|blackberry|opera mini|iemobile|windows ce|nokia|fennec|hiptop|kindle|mot |mot-|webos\/|samsung|sonyericsson|^sie-|nintendo/", $user_agent ) ) {
			// these are the most common
			return true;
		} else if ( preg_match ( "/mobile|pda;|avantgo|eudoraweb|minimo|netfront|brew|teleca|lg;|lge |wap;| wap /", $user_agent ) ) {
			// these are less common, and might not be worth checking
			return true;
		}
		
		return false;
	}
	
	public function fix_css_mobile_hidden_network_names() {	
		echo '<style type="text/css">';
		
		echo '.essb_hide_name a:hover .essb_network_name, .essb_hide_name a:focus .essb_network_name { display: none !important; } ';
		echo '.essb_hide_name a:hover .essb_icon, .essb_hide_name a:focus .essb_icon { margin-right: 0px !important; }';
		
		echo '</style>';
	
	}
}

?>