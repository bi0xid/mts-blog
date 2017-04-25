<?php
/*
Plugin Name: Dudelols Easy Facebook Share Thumbnails
Plugin URI: http://dudelol.com
Description: The post's first image is used as the thumbnail when the page is being shared on facebook. 
Version: 1.3
Author: Benjamin Adams
Author URI: http://dudelol.com
License: A "Slug" license name e.g. GPL2
*/
/*  Copyright 2011 Hebeisen Consulting

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License, version 2, as 
    published by the Free Software Foundation.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

/*
Wordpress admin settings and core installation
*/


add_action('wp_head', 'fbthumbnails_head');
add_option('fbthumbnails_head_section', '');
add_option('fbthumbnails_link_rel', '');
define('PLUGINPATH', ABSPATH . 'wp-content/plugins/easy-facebook-share-thumbnails');
define('PLUGINLINK', get_bloginfo('siteurl') . '/wp-content/plugins/easy-facebook-share-thumbnails/');

//Check if featured immage is supported on current theme
//If not, set it on      
if(!function_exists('the_post_thumbnail()')){
	add_theme_support( 'post-thumbnails' ); 
}



//plugin <head></head> overriding
function fbthumbnails_head()
{ 
	global $wpdb;	
	global $post;
	    $post_id = $post;	    
		    if (is_object($post_id) || is_page($post_id))
			{
		    	$post_id = $post_id->ID;
		      	$site_title = get_the_title($post->ID);
		      	
		      	$post_var = get_post($post_id, ARRAY_A);
		        $raw_content = $post_var['post_content'];
				$fb_thumbnail_src[0] = get_first_img_thumbnails($raw_content);
				
				$category = get_the_category($post_id); 

            $content =  preg_replace('/\s+?(\S+)?$/', '', substr(trim($raw_content), 0, 401));
                
			$content = trim(strip_tags($content));
	
			 echo "\n";
			 echo "\n";
			 echo "<!--  Dudelols Facebook Thumbnails --><!-- Post type with Featured image -->";
			 echo "\n";
			 echo '<meta property="og:title" content="'.  get_the_title($post_id) . '"/>' . "\n";
			 echo '<meta property="og:type" content="article"/>' . "\n";
			 echo '<meta property="og:url" content="' . get_permalink($post_id->ID) . '"/>' . "\n";
			 if(isset($fb_thumbnail_src[0]))
			 {
			 echo '<meta property="og:image" content="' . $fb_thumbnail_src[0] . '"/>' . "\n";
			 }
			 echo '<meta property="og:site_name" content="' . get_bloginfo('name') . '"/>' . "\n";
			 echo '<meta property="og:description" content="'.htmlentities($content).'"/>' . "\n";
			 if(isset($fb_thumbnail_src[0]))
			 {
			 echo '<link rel="image_src" href="' . $fb_thumbnail_src[0] . '"/>' . "\n";
			 }
			 echo "<!-- Dudelols Facebook Share Thumbnails -->";
			 echo "\n";
			 echo "\n";
			 
		 	}
		
}






function get_first_img_thumbnails($postContents) {
  $first_img = '';
  $new_img_tag = "";
  ob_start();
  ob_end_clean();

  
 
//$content= get_the_whole_content();
$content=$postContents;
$content= str_replace("<!--more  -->", "", $content);
$content= str_replace("><img", "> <img", $content);
$output = preg_match_all('/<img.+src=[\'"]([^\'"]+)[\'"].*>/i', $content, $matches);

  $first_img = $matches [1] [0];

  if(empty($first_img)){ //if we do not find an image try to find one via string split
 $split= preg_split("/<img src=/", $content);
//echo $split[1];
$first_img= preg_split("/ alt=/", $split[1]);
$first_img= $first_img[0];

return $first_img;
  }
 
  return $first_img;

}



?>
