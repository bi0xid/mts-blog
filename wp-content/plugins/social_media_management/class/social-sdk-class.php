<?php

/**
* This Class includes two main functions, one is to check every hour all the post likes and shares
* on Facebook, and the other one is to schedule this check every ten minutes for a new post (in one hour)
* @author Alejandro Orta (alejandro@mytinysecrets.com)
*/
class SocialSdkClass {

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

		add_action( 'init', array( $this, 'check_lastest_post_facebook_shares' ), 10 );

		add_action( 'save_post', array( $this, 'schedule_post_share_check' ) );

		add_action( 'wp_ajax_update_google_plus', array( $this, 'update_google_plus' ) );
		add_action( 'wp_ajax_update_stumble_upon', array( $this, 'update_stumble_upon' ) );
		add_action( 'wp_ajax_update_pinterest_pins', array( $this, 'update_pinterest_pins' ) );
		add_action( 'wp_ajax_update_all_posts_media', array( $this, 'update_all_posts_media' ) );
		add_action( 'wp_ajax_update_facebook_shares', array( $this, 'update_facebook_shares' ) );
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
					set_transient( self::POST_SCHEDULE_TEN_MINUTES.$recent_post['ID'], true, 60 * 10 );
					$this->update_post_social_media_data( $recent_post['ID'] );
				}
			}
		}
	}

	/**
	 * AJAX Call. Update all posts shares/likes
	 */
	public function update_all_posts_media() {
		$this->checkAjaxNonce();

		$posts = get_posts( array(
			'numberposts' => 2000,
			'post_status' => 'publish'
		) );

		foreach ( $posts as $post ) {
			$post->ID === 13869 && $this->update_post_social_media_data( $post->ID );
		};

		$this->returnResponse( 200, 'All data saved', false );
	}

	/**
	 * AJAX Call. Update all posts Google Plus Shares
	 */
	public function update_google_plus() {
		$this->checkAjaxNonce();

		$posts = get_posts( array(
			'numberposts' => 2000,
			'post_status' => 'publish'
		) );

		foreach ( $posts as $post ) {
			$google_plus_shares = $this->getGooglePlusShares( get_permalink( $post->ID ) );
			update_post_meta( $post->ID, 'google_shares', (int) str_replace( array('.'), array(''), $google_plus_shares ) );
		};

		$this->returnResponse( 200, 'Google Plus Shares updated' );
	}

	/**
	 * AJAX Call. Update all posts StumbleUpon shares
	 */
	public function update_stumble_upon() {
		$this->checkAjaxNonce();

		$posts = get_posts( array(
			'numberposts' => 2000,
			'post_status' => 'publish'
		) );

		foreach ( $posts as $post ) {
			$stumbleupon_shares = $this->getStumbleUponCount( get_permalink( $post->ID ) );
			update_post_meta( $post->ID, 'stumble_shares', (int) $stumbleupon_shares );
		};

		$this->returnResponse( 200, 'StumbleUpon data saved' );
	}

	/**
	 * AJAX Call. Update all posts Pinterest Pins
	 */
	public function update_pinterest_pins() {
		$this->checkAjaxNonce();

		$posts = get_posts( array(
			'numberposts' => 2000,
			'post_status' => 'publish'
		) );

		foreach ( $posts as $post ) {
			$pinterest_pins = $this->getPinterestPins( get_permalink( $post->ID ) );
			update_post_meta( $post->ID, 'pinterest_shares', (int) $pinterest_pins );
		};

		$this->returnResponse( 200, 'Pinterest data saved' );
	}

	/**
	 * AJAX Call. Update all posts Facebook Shares and Likes
	 */
	public function update_facebook_shares() {
		$this->checkAjaxNonce();

		$posts = get_posts( array(
			'numberposts' => 2000,
			'post_status' => 'publish'
		) );

		foreach ( $posts as $post ) {
			$this->updateFacebookSharesAndLikes( $post->ID );
		};

		$this->returnResponse( 200, 'Facebook data saved' );
	}

	/**
	 * Given a Post ID update the facebook shares and likes
	 * @param (int) post_id
	 */
	private function update_post_social_media_data( $post_id ) {
		$post_url = get_permalink( $post_id );

		/**
		 * Update Google+ Info
		 */
		$google_plus_shares = $this->getGooglePlusShares( $post_url );
		update_post_meta( $post_id, 'google_shares', (int) str_replace( array('.'), array(''), $google_plus_shares ) );

		/**
		 * Update Pinterest Pins
		 */
		$pinterest_pins = $this->getPinterestPins( $post_url );
		update_post_meta( $post_id, 'pinterest_shares', (int) $pinterest_pins );

		/**
		 * Update StumbleUpon Shares
		 */
		$stumbleupon_shares = $this->getStumbleUponCount( $post_url );
		update_post_meta( $post_id, 'stumble_shares', (int) $stumbleupon_shares );

		/**
		 * Update Facebook Shares and Likes
		 */
		$this->updateFacebookSharesAndLikes( $post_id );
	}

	private function getStumbleUponCount( $url ) {
		$ch = curl_init( 'http://www.stumbleupon.com/services/1.01/badge.getinfo?url='.$url );

		curl_setopt( $ch, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT'] );
		curl_setopt( $ch, CURLOPT_FAILONERROR, 1 );
		curl_setopt( $ch, CURLOPT_FOLLOWLOCATION, 1 );
		curl_setopt( $ch, CURLOPT_RETURNTRANSFER, 1 );
		curl_setopt( $ch, CURLOPT_TIMEOUT, 10 );

		$cont = curl_exec( $ch );
		$json = json_decode( $cont, true );

		return $json['result']['views'] ? $json['result']['views'] : 0;
	}

	private function getPinterestPins( $url ) {
		$json_string = preg_replace( "/[^(]*\((.*)\)/", "$1", file_get_contents( 'http://api.pinterest.com/v1/urls/count.json?url='.$url ) );
		$json = json_decode( $json_string, true );
		return $json['count'] ? $json['count'] : 0;
	}

	private function getGooglePlusShares( $url ) {
		libxml_use_internal_errors( true );

		$html = file_get_contents( 'https://plusone.google.com/_/+1/fastbutton?url='.urlencode( $url ) );

		$doc = new DOMDocument();
		$doc->loadHTML( $html );

		$counter = $doc->getElementById( 'aggregateCount' );
		return $counter->nodeValue ? $counter->nodeValue : 0;
	}

	private function updateFacebookSharesAndLikes( $post_id ) {
		try {
			$response = $this->fb_sdk->get('?fields=share,og_object{likes.limit(0).summary(true),comments.limit(0).summary(true)}&id='.urlencode( get_permalink( $post_id ) ) );
		} catch( \Facebook\Exceptions\FacebookSDKException $e ) {
			$this->returnResponse( 403, $e->getMessage() );
		}

		$response_body = $response->getDecodedBody();

		if( isset( $response_body['share']['share_count'] ) ) {
			update_post_meta( $post_id, 'facebook_shares', (int) $response_body['share']['share_count'] );
		}

		if( isset( $response_body['og_object']['likes']['summary']['total_count'] ) ) {
			update_post_meta( $post_id, 'facebook_likes', (int) $response_body['og_object']['likes']['summary']['total_count'] );
		}
	}

	private function returnResponse( $code, $message, $data = null ) {
		echo json_encode( array(
			'code'    => $code,
			'data'    => $data,
			'message' => $message,
		) );
		die();
	}

	private function checkAjaxNonce() {
		if( !check_ajax_referer( 'seguridad', 'security' ) ) {
			echo json_encode('Security error');
			die();
		}
	}
}
