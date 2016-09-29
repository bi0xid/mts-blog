<?php

/**
* This Class includes two main functions, one is to check every hour all the post likes and shares
* on Facebook, and the other one is to schedule this check every ten minutes for a new post (in one hour)
* @author Alejandro Orta (alejandro@mytinysecrets.com)
*/
class BlogFacebookClass {

	CONST POST_SCHEDULE_HOUR = 'post_facebook_schedule_hour_';
	CONST POST_SCHEDULE_TEN_MINUTES = 'post_facebook_schedule_minute_';

	CONST POSTS_HOUR_SCHEDULE = 'post_facebook_shares_checked';

	function __construct() {
		add_action( 'init', array( $this, 'get_all_post_facebook_shares' ) );
		add_action( 'init', array( $this, 'check_lastest_post_facebook_shares' ) );

		add_action( 'save_post', array( $this, 'schedule_post_share_check' ) );
	}

	public function schedule_post_share_check( $post_id ) {
		if ( get_post_status( $post_id ) === 'publish' && !wp_is_post_revision( $post_id ) ) {
			// The limit for every ten minutes check is one hour
			set_transient( self::POST_SCHEDULE_HOUR.$post_id, true, 60 * 60  );
		}
	}

	public function check_lastest_post_facebook_shares() {
		$recent_posts = wp_get_recent_posts( array(
			'numberposts' => 5,
			'orderby'     => 'post_date',
			'order'       => 'DESC',
			'post_type'   => 'post',
			'post_status' => 'publish'
		) );

		foreach ( $recent_posts as $recent_post ) {
			if( get_transient( self::POST_SCHEDULE_HOUR.$recent_post['ID'] ) ) {
				if( !get_transient( self::POST_SCHEDULE_TEN_MINUTES.$recent_post['ID'] ) ) {
					$this->update_post_facebook_stats( $recent_post['ID'] );
					set_transient( self::POST_SCHEDULE_TEN_MINUTES.$recent_post['ID'], true, 60 * 10 );
				}
			}
		}
	}

	public function get_all_post_facebook_shares() {
		// If there is no transient that means we have to check all post shares
		if( !get_transient( POSTS_HOUR_SCHEDULE ) ) {
			set_transient( POSTS_HOUR_SCHEDULE, true, 60 * 60 );

			$posts = get_posts( array(
				'numberposts' => 2000,
				'post_status' => 'publish'
			) );

			foreach ( $posts as $post ) {
				$this->update_post_facebook_stats( $post->ID );
			};
		}
	}

	private function update_post_facebook_stats( $post_id ) {
		$url = 'http://graph.facebook.com/?fields=share,og_object{likes.limit(0).summary(true),comments.limit(0).summary(true)}&id='.urlencode( get_permalink( $post_id ) );

		$ch = curl_init();

		curl_setopt( $ch, CURLOPT_URL, $url );
		curl_setopt( $ch, CURLOPT_RETURNTRANSFER, 1 );
		curl_setopt( $ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.13) Gecko/20080311 Firefox/2.0.0.13' );

		$output = curl_exec( $ch );
		$facebook_results_json = json_decode( $output );

		curl_close( $ch );

		if( isset( $facebook_results_json->share->share_count ) ) {
			update_post_meta( $post_id, '_msp_total_shares', $facebook_results_json->share->share_count );
		}

		if( isset( $facebook_results_json->og_object->likes->summary->total_count ) ) {
			update_post_meta( $post_id, '_msp_fb_likes', $facebook_results_json->og_object->likes->summary->total_count );
		}
	}
}
