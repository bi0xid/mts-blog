<?php
/*-----------------------------------------------------------------------------------*/
/*	Do not remove these lines, sky will fall on your head.
/*-----------------------------------------------------------------------------------*/
require_once( dirname( __FILE__ ) . '/theme-options.php' );
include("functions/tinymce/tinymce.php");
if ( ! isset( $content_width ) ) $content_width = 960;

// Email Share Class
include( 'includes/email-share-class.php' );
$email_share_class = new EmailShareClass();

// Include our Blog Helpers
include( 'includes/blog-helpers.php' );
$blog_helpers = new BlogHelpers();

// FormSignups Class and Actions
include( 'includes/form-signups.php' );
//$form_signups = new FormSignups();

if( $_POST && $_POST['form_id'] ) {
	$form_signups->submitFormSignup( $_POST );
}

/*-----------------------------------------------------------------------------------*/
/*	Load Translation Text Domain
/*-----------------------------------------------------------------------------------*/
load_theme_textdomain( 'mythemeshop', get_template_directory().'/lang' );
if ( function_exists('add_theme_support') ) add_theme_support('automatic-feed-links');

/*-----------------------------------------------------------------------------------*/
/*	Post Thumbnail Support
/*-----------------------------------------------------------------------------------*/
if ( function_exists( 'add_theme_support' ) ) {
	add_theme_support( 'post-thumbnails' );
	set_post_thumbnail_size( 298, 248, true );
	add_image_size( 'featured', 298, 248, true ); //featured
	add_image_size( 'related', 140, 100, true ); //related
	add_image_size( 'widgetthumb', 65, 50, true ); //widget
	add_image_size( 'slider', 850, 350, true ); //slider
}

/*-----------------------------------------------------------------------------------*/
/*	Javascsript
/*-----------------------------------------------------------------------------------*/
function mts_add_scripts() {
	$options = get_option('spike');

	global $data;

	wp_enqueue_script( 'modernizr', get_template_directory_uri() . '/js/modernizr.min.js' );
	wp_enqueue_script( 'customscript', get_template_directory_uri() . '/js/customscript.js', array( 'jquery' ) );
	wp_enqueue_script( 'main-js', get_template_directory_uri() . '/js/main.js', array( 'jquery' ), '1.0.7', true );

	if($options['mts_featured_slider'] == '1') {
		if(is_front_page()) {
			wp_enqueue_script('flexslider', get_template_directory_uri() . '/js/jquery.flexslider-min.js');
		}
	}

	if($options['mts_lightbox'] == '1') {
		wp_enqueue_script('prettyPhoto', get_template_directory_uri() . '/js/jquery.prettyPhoto.js');
	}
}
add_action('wp_enqueue_scripts','mts_add_scripts');

/*-----------------------------------------------------------------------------------*/
/* Enqueue CSS
/*-----------------------------------------------------------------------------------*/
function mts_enqueue_css() {
	$options = get_option('spike');
	global $data;

	if($options['mts_featured_slider'] == '1') {
		if(is_front_page()) {
			wp_enqueue_style('flexslider', get_template_directory_uri() . '/css/flexslider.css', 'style');
		}
	}

	if($options['mts_lightbox'] == '1') {
		wp_enqueue_style('prettyPhoto', get_template_directory_uri() . '/css/prettyPhoto.css', 'style');
	}

	wp_enqueue_style('custom-style', get_template_directory_uri() . '/css/style.css', 'style', '1.0.8');
}
add_action('wp_enqueue_scripts', 'mts_enqueue_css');

/*-----------------------------------------------------------------------------------*/
/*	Enable Widgetized sidebar
/*-----------------------------------------------------------------------------------*/
if ( function_exists('register_sidebar') )
register_sidebar(array('name'=>'Sidebar',
	'before_widget' => '<li id="%2$s" class="widget widget-sidebar">',
	'after_widget' => '</li>',
	'before_title' => '<h3>',
	'after_title' => '</h3>',
));

/*-----------------------------------------------------------------------------------*/
/*	Load Widgets & Shortcodes
/*-----------------------------------------------------------------------------------*/
// Add the 125x125 Ad Block Custom Widget
include("functions/widget-ad125.php");

// Add the 300x250 Ad Block Custom Widget
include("functions/widget-ad300.php");

// Add the Tabbed Custom Widget
include("functions/widget-tabs.php");

// Add the Latest Tweets Custom Widget
include("functions/widget-tweets.php");

// Add the Theme Shortcodes
include("functions/theme-shortcodes.php");

// Add Recent Posts Widget
include("functions/widget-recentposts.php");

// Add Popular Posts Widget
include("functions/widget-popular.php");

// Add Facebook Like box Widget
include("functions/widget-fblikebox.php");

// Add Subscribe Widget
include("functions/widget-subscribe.php");

// Add Social Profile Widget
include("functions/widget-social.php");

// Add Category Posts Widget
include("functions/widget-catposts.php");

// Add Welcome message
include("functions/welcome-message.php");

// Theme Functions
include("functions/theme-actions.php");

show_admin_bar(false);

/*-----------------------------------------------------------------------------------*/
/*	Filters customize wp_title
/*-----------------------------------------------------------------------------------*/
if ( ! function_exists('mythemeshop_page_title' ) ) {
	function mythemeshop_page_title( $title ) {
		$the_page_title = $title;
		if( ! $the_page_title ){
			$the_page_title = get_bloginfo("name");
		}else{
			$the_page_title = $the_page_title;
		}
		return $the_page_title;
	}
	add_filter('wp_title', 'mythemeshop_page_title');
}

/*-----------------------------------------------------------------------------------*/
/*	Filters that allow shortcodes in Text Widgets
/*-----------------------------------------------------------------------------------*/
add_filter('widget_text', 'shortcode_unautop');
add_filter('widget_text', 'do_shortcode');
add_filter('the_content_rss', 'do_shortcode');

/*-----------------------------------------------------------------------------------*/
/*	Register Footer widgets
/*-----------------------------------------------------------------------------------*/
if (function_exists('register_sidebar')) {
	$sidebars = array(1, 2, 3);
	foreach($sidebars as $number) {
	register_sidebar(array(
		'name' => 'Footer ' . $number,
		'id' => 'footer-' . $number,
		'before_widget' => '<div class="widget">',
		'after_widget' => '</div>',
		'before_title' => '<h3>',
		'after_title' => '</h3>'
	));
	}
}
function widgetized_footer() {
?>
	<div class="f-widget f-widget-1">
		<?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('Footer 1') ) : ?>
		<?php endif; ?>
	</div>
	<div class="f-widget f-widget-2">
		<?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('Footer 2') ) : ?>
		<?php endif; ?>
	</div>
	<div class="f-widget last">
		<?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('Footer 3') ) : ?>
		<?php endif; ?>
	</div>
<?php
}

/*-----------------------------------------------------------------------------------*/
/*	Custom Comments template
/*-----------------------------------------------------------------------------------*/
function mytheme_comment($comment, $args, $depth) {
	$GLOBALS['comment'] = $comment; ?>
	<li <?php comment_class(); ?> id="li-comment-<?php comment_ID() ?>">
		<div id="comment-<?php comment_ID(); ?>" style="position:relative;">
			<div class="comment-author vcard">
				<?php echo get_avatar( $comment->comment_author_email, 68 ); ?>
				<?php $options = get_option('spike'); if($options['mts_comment_date'] == '1') { ?> <time><?php comment_date('M d Y'); ?></time> <?php } ?>
			</div>
			<?php if ($comment->comment_approved == '0') : ?>
				<em><?php _e('Your comment is awaiting moderation.', 'mythemeshop') ?></em>
				<br />
			<?php endif; ?>
			<div class="commentmetadata">
			<?php printf(__('<span class="fn">%s</span>', 'mythemeshop'), get_comment_author_link()) ?>
			<div class="comment-meta">
				<?php edit_comment_link(__('(Edit)', 'mythemeshop'),'  ','') ?>
			</div>
			<?php comment_text() ?>
                <div class="reply">
                    <?php comment_reply_link(array_merge( $args, array('depth' => $depth, 'max_depth' => $args['max_depth']))) ?>
                </div>
			</div>
		</div>
	</li>
<?php }

/*-----------------------------------------------------------------------------------*/
/*	Custom Menu Support
/*-----------------------------------------------------------------------------------*/
add_theme_support( 'menus' );
if ( function_exists( 'register_nav_menus' ) ) {
	register_nav_menus(
		array(
		  'primary-menu' => 'Primary Menu'
		)
	);
}

/*-----------------------------------------------------------------------------------*/
/*	excerpt
/*-----------------------------------------------------------------------------------*/
function excerpt($limit) {
  $excerpt = explode(' ', get_the_excerpt(), $limit);
  if (count($excerpt)>=$limit) {
    array_pop($excerpt);
    $excerpt = implode(" ",$excerpt);
  } else {
    $excerpt = implode(" ",$excerpt);
  }
  $excerpt = preg_replace('`[[^]]*]`','',$excerpt);
  return $excerpt;
}

/*-----------------------------------------------------------------------------------*/
/* nofollow to next/previous links
/*-----------------------------------------------------------------------------------*/
//function pagination_add_nofollow($content) {
//    return 'rel="nofollow"';
//}
//add_filter('next_posts_link_attributes', 'pagination_add_nofollow' );
//add_filter('previous_posts_link_attributes', 'pagination_add_nofollow' );

/*-----------------------------------------------------------------------------------*/
/* Nofollow to category links
/*-----------------------------------------------------------------------------------*/
add_filter( 'the_category', 'add_nofollow_cat' );
function add_nofollow_cat( $text ) {
$text = str_replace('rel="category tag"', 'rel="nofollow"', $text); return $text;
}

/*-----------------------------------------------------------------------------------*/
/* nofollow post author link
/*-----------------------------------------------------------------------------------*/
add_filter('the_author_posts_link', 'mts_nofollow_the_author_posts_link');
function mts_nofollow_the_author_posts_link ($link) {
return str_replace('<a href=', '<a rel="nofollow" href=',$link);
}

/*-----------------------------------------------------------------------------------*/
/* removes detailed login error information for security
/*-----------------------------------------------------------------------------------*/
add_filter('login_errors',create_function('$a', "return null;"));

/*-----------------------------------------------------------------------------------*/
/* removes the WordPress version from your header for security
/*-----------------------------------------------------------------------------------*/
function wb_remove_version() {
	return '<!--Theme by MyThemeShop.com-->';
}
add_filter('the_generator', 'wb_remove_version');

/*-----------------------------------------------------------------------------------*/
/* Removes Trackbacks from the comment count
/*-----------------------------------------------------------------------------------*/
add_filter('get_comments_number', 'comment_count', 0);
function comment_count( $count ) {
	if ( ! is_admin() ) {
		global $id;
		$comments_by_type = &separate_comments(get_comments('status=approve&post_id=' . $id));
		return count($comments_by_type['comment']);
	} else {
		return $count;
	}
}

/*-----------------------------------------------------------------------------------*/
/* category id in body and post class
/*-----------------------------------------------------------------------------------*/
function category_id_class($classes) {
	global $post;
	foreach((get_the_category($post->ID)) as $category)
		$classes [] = 'cat-' . $category->cat_ID . '-id';
		return $classes;
}
add_filter('post_class', 'category_id_class');
add_filter('body_class', 'category_id_class');

/*-----------------------------------------------------------------------------------*/
/* adds a class to the post if there is a thumbnail
/*-----------------------------------------------------------------------------------*/
function has_thumb_class($classes) {
	global $post;
	if( has_post_thumbnail($post->ID) ) { $classes[] = 'has_thumb'; }
		return $classes;
}
add_filter('post_class', 'has_thumb_class');

/*-----------------------------------------------------------------------------------*/
/* Breadcrumb
/*-----------------------------------------------------------------------------------*/
function the_breadcrumb() {
	echo '<a href="';
	echo home_url();
	echo '" rel="nofollow">Home';
	echo "</a>";
	if (is_category() || is_single()) {
		echo "&nbsp;&nbsp;&#187;&nbsp;&nbsp;";
		the_category(' &bull; ');
			if (is_single()) {
				echo " &nbsp;&nbsp;&#187;&nbsp;&nbsp; ";
				the_title();
			}
	} elseif (is_page()) {
		echo "&nbsp;&nbsp;&#187;&nbsp;&nbsp;";
		echo the_title();
	} elseif (is_search()) {
		echo "&nbsp;&nbsp;&#187;&nbsp;&nbsp;Search Results for... ";
		echo '"<em>';
		echo the_search_query();
		echo '</em>"';
	}
}

/*-----------------------------------------------------------------------------------*/
/* Pagination
/*-----------------------------------------------------------------------------------*/
function pagination($pages = '', $range = 3) {
	$showitems = ($range * 3)+1;
	global $paged; if(empty($paged)) $paged = 1;
	if($pages == '') {
		global $wp_query; $pages = $wp_query->max_num_pages;
		if(!$pages){ $pages = 1; }
	}
	if(1 != $pages) {
		echo "<div class='pagination'><ul>";
		if($paged > 2 && $paged > $range+1 && $showitems < $pages)
			echo "<li><a href='".get_pagenum_link(1)."'>&laquo; First</a></li>";
		if($paged > 1 && $showitems < $pages)
			echo "<li><a href='".get_pagenum_link($paged - 1)."' class='inactive'>&lsaquo; Previous</a></li>";
		for ($i=1; $i <= $pages; $i++){
			if (1 != $pages &&( !($i >= $paged+$range+1 || $i <= $paged-$range-1) || $pages <= $showitems )) {
				echo ($paged == $i)? "<li class='current'><span class='currenttext'>".$i."</span></li>":"<li><a href='".get_pagenum_link($i)."' class='inactive'>".$i."</a></li>";
			}
		}
		if ($paged < $pages && $showitems < $pages)
			echo "<li><a href='".get_pagenum_link($paged + 1)."' class='inactive'>Next &rsaquo;</a></li>";
		if ($paged < $pages-1 &&  $paged+$range-1 < $pages && $showitems < $pages)
			echo "<a class='inactive' href='".get_pagenum_link($pages)."'>Last &raquo;</a>";
			echo "</ul></div>";
	}
}

/*-----------------------------------------------------------------------------------*/
/* Redirect feed to feedburner
/*-----------------------------------------------------------------------------------*/
$options = get_option('spike');
if ( $options['mts_feedburner'] != '') {
function mts_rss_feed_redirect() {
    $options = get_option('spike');
    global $feed;
    $new_feed = $options['mts_feedburner'];
    if (!is_feed()) {
            return;
    }
    if (preg_match('/feedburner/i', $_SERVER['HTTP_USER_AGENT'])){
            return;
    }
    if ($feed != 'comments-rss2') {
            if (function_exists('status_header')) status_header( 302 );
            header("Location:" . $new_feed);
            header("HTTP/1.1 302 Temporary Redirect");
            exit();
    }
}
add_action('template_redirect', 'mts_rss_feed_redirect');
}

$options = get_option('spike');
if ( $options['mts_admin_style'] == '1') {
function admin_css() {
	wp_enqueue_style( 'admin_css', get_template_directory_uri() . '/css/admin.css' );
}
add_action('admin_print_styles', 'admin_css' );

function remove_footer_admin () {
    echo "Thank you for creating with <a href=\"http://wordpress.org/\">WordPress</a>. Dashboard Customization by <a href=\"http://mythemeshop.com/\">MyThemeShop</a>.";
}
add_filter('admin_footer_text', 'remove_footer_admin');
}

/*-----------------------------------------------------------------------------------*/
/* Tag Widget
/*-----------------------------------------------------------------------------------*/
function mts_tag_cloud() {
	$tags = get_tags( array('orderby' => 'count', 'order' => 'DESC') );
	foreach ( (array) $tags as $tag ) {
	echo '<a title=" " href="'.get_tag_link ($tag->term_id).'"><span class="tab_count">'.$tag->count.'</span><span class="tab_name">'.$tag->name.'</span></a>';
	}
}
add_filter('wp_tag_cloud', 'mts_tag_cloud');

add_filter('the_content', 'add_author_box_inside_post_content', 10);

function add_author_box_inside_post_content($sContent = ''){
    if(!is_singular() || is_page()) return $sContent;
    $options = get_option('spike');
    if(!(int)$options['mts_author_box']) return $sContent;

    if(preg_match('/^.*(<img[^>]+>)/', $sContent)){
        $sAuthorImage = '';
        if(function_exists('get_avatar')) {
            $sAuthorImage = get_avatar( get_the_author_meta('email'), '90', '90' );
        }
        global $authordata;

        $sContentAbout = get_the_author_meta('description');
        $sAuthrohPostUrl = get_author_posts_url( $authordata->ID, $authordata->user_nicename);

        $sAuthrorName = $authordata->display_name;
        $sVisileUrl = ($authordata->user_url != '') ? "<a class='inside_author_block_url' href='{$authordata->user_url}' target='_blank' rel='nofollow'>Visit Author's Website</a>" : '';

        $sAuthorBlockContent = "<div class='internal_author_block_content' style='position: relative; z-index: 1;'>
                    <div class='upper_block'>
                        <div class='author_avatar_wrapper'>
                            {$sAuthorImage}
                        </div>
                        <div class='author_name_wrapper'>
                            The Author<br/>
                            <span class='vcard author post-author'>
                                <span class='fn'>
                                    <h5 style='margin: 0;'>
                                        <a href='{$sAuthrohPostUrl}' target='_blank' title='Posts by {$sAuthrorName}'>{$sAuthrorName}</a>
                                    </h5>
                                </span>
                            </span>
                            {$sVisileUrl}
                        </div>
                    </div>
                    <div class='lowwer_block'>
                        <p>About Me</p>
                        {$sContentAbout}
                    </div>
                </div>";
        $sContent = preg_replace('/^(.*)(<img[^>]+>)(.*)/', "$1$2{$sAuthorBlockContent}$3", $sContent);
    }
    return $sContent;
}

function get_the_user_ip() {
	if ( ! empty( $_SERVER['HTTP_CLIENT_IP'] ) ) {
		//check ip from share internet
		$ip = $_SERVER['HTTP_CLIENT_IP'];
	} elseif ( ! empty( $_SERVER['HTTP_X_FORWARDED_FOR'] ) ) {
		//to check ip is pass from proxy
		$ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
	} else {
		$ip = $_SERVER['REMOTE_ADDR'];
	}

	return apply_filters( 'wpb_get_ip', $ip );
}


function remove_pages_from_search() {
    global $wp_post_types;
    $wp_post_types['page']->exclude_from_search = true;
}
add_action('init', 'remove_pages_from_search');

