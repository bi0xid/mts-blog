<?php

/**
* This Class includes two main functions, one is to check every hour all the post likes and shares
* on Facebook, and the other one is to schedule this check every ten minutes for a new post (in one hour)
* @author Alejandro Orta (alejandro@mytinysecrets.com)
*/
class FacebookSdkClass {

	private $app_id = '109970876058039';
	private $app_secret = 'c9b9f0496665882dab21486c0aa695f1';
	private $access_token = '109970876058039|p4fimCw5sXSGcIP6ZJdt4HGia78';

	CONST POST_SCHEDULE_HOUR = 'post_facebook_schedule_hour_';
	CONST POST_SCHEDULE_TEN_MINUTES = 'post_facebook_schedule_minute_';

	private $fb_sdk;

	function __construct() {
		$this->fb_sdk = new \Facebook\Facebook([
			'default_graph_version' => 'v2.8',
			'app_id'                => $this->app_id,
			'app_secret'            => $this->app_secret,
			'default_access_token'  => $this->access_token
		]);

		add_action( 'save_post', array( $this, 'schedule_post_share_check' ) );
		add_action( 'init', array( $this, 'check_lastest_post_facebook_shares' ), 10 );
		add_action( 'wp_ajax_update_all_facebook_posts', array( $this, 'update_all_facebook_posts' ) );
	}

	/**
	 * On post save prepare the schedule
	 */
	public function schedule_post_share_check( $post_id ) {
		if ( get_post_status( $post_id ) === 'publish' && !wp_is_post_revision( $post_id ) ) {
			set_transient( self::POST_SCHEDULE_HOUR.$post_id, true, 60 * 60  );
		}
	}

	/**
	 * Check Lastest post Shares/Likes every ten minutes in a hour
	 */
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
					$this->update_post_social_media_data( $recent_post['ID'] );
					set_transient( self::POST_SCHEDULE_TEN_MINUTES.$recent_post['ID'], true, 60 * 10 );
				}
			}
		}
	}

	/**
	 * AJAX Call. Update all posts shares/likes
	 */
	public function update_all_facebook_posts() {
		if( !check_ajax_referer( 'seguridad', 'security' ) ) {
			echo json_encode('Security error');
			die();
		}

		$now = date('d-m-Y H:i:s');
		update_option( 'facebook_posts_stats_lats_update', $now );

		$posts = get_posts( array(
			'numberposts' => 2000,
			'post_status' => 'publish'
		) );

		foreach ( $posts as $post ) {
			$this->update_post_social_media_data( $post->ID );
		};

		$this->returnResponse( 200, 'All data saved', $now );
	}

	/**
	 * Given a Post ID update the facebook shares and likes
	 * @param (int) post_id
	 */
	private function update_post_social_media_data( $post_id ) {
		$post_url = get_permalink( $post_id );

		// Just for testing porpouses
		$post_url = str_replace(array('.dev'), array('.com'), $post_url);

		/**
		 * Update Google+ Info
		 */
		$google_plus_shares = $this->getGooglePlusShares( $post_url );
		if( $google_plus_shares ) {
			update_post_meta( $post_id, 'google_shares', $google_plus_shares );
		}

		/**
		 * Update Facebook Shares and Likes
		 */
		try {
			$response = $this->fb_sdk->get('?fields=share,og_object{likes.limit(0).summary(true),comments.limit(0).summary(true)}&id='.$post_url);
		} catch( \Facebook\Exceptions\FacebookSDKException $e ) {
			$this->returnResponse( 403, $e->getMessage() );
		}

		$response_body = $response->getDecodedBody();

		if( isset( $response_body['share']['share_count'] ) ) {
			update_post_meta( $post_id, 'facebook_shares', $response_body['share']['share_count'] );
		}

		if( isset( $response_body['og_object']['likes']['summary']['total_count'] ) ) {
			update_post_meta( $post_id, 'facebook_likes', $response_body['og_object']['likes']['summary']['total_count'] );
		}
	}

	private function getGooglePlusShares( $url ) {
		$html =  file_get_contents( 'https://plusone.google.com/_/+1/fastbutton?url='.urlencode( $url ) );

		$doc = new DOMDocument();
		$doc->loadHTML( $html );

		$counter = $doc->getElementById( 'aggregateCount' );
		return $counter->nodeValue;
	}

	private function returnResponse( $code, $message, $data = null ) {
		echo json_encode( array(
			'code'    => $code,
			'data'    => $data,
			'message' => $message,
		) );
		die();
	}
}
