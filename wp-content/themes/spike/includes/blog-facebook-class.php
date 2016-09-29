<?php

/**
* This Class includes two main functions, one is to check every hour all the post likes and shares
* on Facebook, and the other one is to schedule this check every ten minutes for a new post (in one hour)
* @author Alejandro Orta (alejandro@mytinysecrets.com)
*/
class BlogFacebookClass {
	function __construct() {
		add_action( 'init', array( $this, 'get_all_post_facebook_shares' ) );
		add_action( 'save_post', array( $this, 'schedule_post_share_check' ) );
	}

	public function schedule_post_share_check( $post_id ) {
		if ( get_post_status( $post_id ) === 'publish' ) {
			var_dump(1);die();
		}
	}

	public function get_all_post_facebook_shares() {
		// If there is no transient that means we have to check all post shares
		if( !get_transient( 'post_facebook_shares_checked' ) ) {
			set_transient( 'post_facebook_shares_checked', true, 60 * 60 );

			$posts = get_posts( array(
				'numberposts' => 2000,
				'post_status' => 'publish'
			) );

			foreach ( $posts as $post ) {
				$url = 'http://graph.facebook.com/?fields=share,og_object{likes.limit(0).summary(true),comments.limit(0).summary(true)}&id='.urlencode( get_permalink( $post->ID ) );

				$ch = curl_init();

				curl_setopt( $ch, CURLOPT_URL, $url );
				curl_setopt( $ch, CURLOPT_RETURNTRANSFER, 1 );
				curl_setopt( $ch, CURLOPT_USERAGENT,'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.13) Gecko/20080311 Firefox/2.0.0.13' );

				$output = curl_exec( $ch );
				$facebook_results_json = json_decode( $output );

				curl_close( $ch );

				if( isset( $facebook_results_json->share->share_count ) ) {
					update_post_meta( $post->ID, '_msp_total_shares', $facebook_results_json->share->share_count );
				}

				if( isset( $facebook_results_json->og_object->likes->summary->total_count ) ) {
					update_post_meta( $post->ID, '_msp_fb_likes', $facebook_results_json->og_object->likes->summary->total_count );
				}
			};
		}
	}
}
