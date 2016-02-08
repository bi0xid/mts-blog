<?php

/*
	Plugin Name: SG React/Share
	Description: This plugin alows to react/share posts.
	Author: Sergey Gorbach
	Version: 0.0.01
*/

class SG_React_Share
{
	private static $oInstance = null;

	public static function getInstance()
	{
		if(self::$oInstance === null)
		{
			self::$oInstance = new SG_React_Share();
		}

		return self::$oInstance;
	}

	public function install()
	{
		return true;
	}

	public function uninstall()
	{
		return true;
	}

	public function init()
	{
		$oSGReactShare = self::getInstance();

		$oSGReactShare->_addActions();

		$oSGReactShare->_setJsAndCss();

		$oSGReactShare->_setFilters();
	}

	private function _addActions()
	{
		add_action('wp_ajax_setVoute', array($this, 'setVoute'));
		add_action('wp_ajax_nopriv_setVoute', array($this, 'setVoute'));
	}

	public function isVoted($iPostId = 0)
	{
		if(!$iPostId)
		{
			return false;
		}

		if($aCookies = $this->_getCookieValue('sgreactshare'))
		{
			return in_array($iPostId, $aCookies);
		}

		return false;
	}

	private function _getCookieValue($sValue = '')
	{
		$sCookieValue = false;

		if(isset($_COOKIE[$sValue]) and $_COOKIE[$sValue])
		{
			$sCookieValue = mcrypt_decrypt(MCRYPT_RIJNDAEL_128, md5(AUTH_KEY), urldecode(isset($_COOKIE[$sValue]) ? $_COOKIE[$sValue] : false), MCRYPT_MODE_ECB);
			$sCookieValue = unserialize($sCookieValue);
		}

		return $sCookieValue;
	}

	private function _setCookie($iPostId = 0)
	{
		if(!$iPostId)
		{
			return false;
		}

		$aCookie = $this->_getCookieValue('sgreactshare');
		$aCookie[] = $iPostId;
		$sCookie = mcrypt_encrypt(MCRYPT_RIJNDAEL_128, md5(AUTH_KEY), serialize(array_unique($aCookie)), MCRYPT_MODE_ECB);
		setcookie('sgreactshare', urlencode($sCookie), time() + 60*60*24*365, COOKIEPATH, COOKIE_DOMAIN);
	}

	public function setVoute()
	{
		$iPostId = intval($_POST['postId']);
		$sVote = $_POST['vote'];

		if(!$iPostId or !in_array($sVote, array('positive', 'negative')))
		{
			echo json_encode(array('status' => 'error', 'message' => 'Wrond data')); die();
		}

		if($this->isVoted($iPostId))
		{
			echo json_encode(array('status' => 'alreadyVoted', 'message' => 'You have already voted on this post')); die();
		}

		$sOptionName = '_post_votes_positive';

		if($sVote == 'negative')
		{
			$sOptionName = '_post_votes_negative';
		}

		$iCountOfVotes = (int)get_post_meta($iPostId, $sOptionName, true);

		if($iCountOfVotes != '')
		{
			update_post_meta($iPostId, $sOptionName, $iCountOfVotes + 1);
		}
		else
		{
			add_post_meta($iPostId, $sOptionName, 1, true);
		}

		$this->_setCookie($iPostId);

		$iPositiveVoutes = get_post_meta($iPostId, '_post_votes_positive', true);
		$iNegativeVoutes = get_post_meta($iPostId, '_post_votes_negative', true);

		$iPositiveVoutes = !($iPositiveVoutes) ? 0 : $iPositiveVoutes;
		$iNegativeVoutes = !($iNegativeVoutes) ? 0 : $iNegativeVoutes;

		echo json_encode(array('status' => 'ok', '_post_votes_positive' => $iPositiveVoutes, '_post_votes_negative' => $iNegativeVoutes)); die();
	}

	private function _setJsAndCss()
	{
		wp_enqueue_script('sg_reactshare_js',   plugin_dir_url(__FILE__).'js/main.js', array(), "0.0.1", true );
		wp_localize_script('sg_reactshare_js', 'SGReactShareAjaxPath', array( 'ajaxurl' => admin_url( 'admin-ajax.php' )));

		wp_enqueue_style('sg_reactshare_css', plugins_url( 'css/main.css', __FILE__ ));
	}

	private function _setFilters()
	{
		add_filter('the_content', array($this, 'setVouteContent'));
	}

	public static function setVouteContent($sContent = '')
	{
		if(is_single())
		{
			$iPositiveVoutes = get_post_meta(get_the_ID(), '_post_votes_positive', true);
			$iNegativeVoutes = get_post_meta(get_the_ID(), '_post_votes_negative', true);

			$iPositiveVoutes = !($iPositiveVoutes) ? 0 : $iPositiveVoutes;
			$iNegativeVoutes = !($iNegativeVoutes) ? 0 : $iNegativeVoutes;

			$sContent .= "
							<div class='react-overlay'>
							</div>
								<a href='https://mytinysecrets.com/shopping/' target='_blank' id='new-shop-link'>
									<span>Visit My Shop</span>
								</a>
								<div id='reactshare-button' class=''>
									<div class='share-functions'>
										<a class='share-func-button' id='share-funct-fb' rel='nofollow' target='_blank' title='facebook' href='http://www.facebook.com/share.php?u=" . urlencode(get_permalink()) . "&title=" . urlencode(get_the_title()) . "'></a><a class='share-func-button' id='share-funct-twt' href='http://twitter.com/home?status=" . urlencode(get_permalink()) ."+" . urlencode(get_the_title()) . "' title='twitter' rel='nofollow' target='_blank'></a>
										<div class='share-func-button' id='share-funct-mail'>" . email_link('', '', false) . "</div>
										<div class='share-func-button' id='share-funct-sms'>Sms</div>
									</div>
									<div class='opinion-functions'>
										<span id='span_positive_votes'>{$iPositiveVoutes}</span>
										<a href='#' class='clicble_voute' id='posvote' data-id='" . get_the_ID() . "' data-vote='positive' ></a>
										<a href='#' class='clicble_voute' id='negvote' data-id='" . get_the_ID() . "' data-vote='negative'></a>
										<span id='span_negative_votes'>{$iNegativeVoutes}</span>
									</div>
									<div class='rs-share'>
										share
									</div>
									<div class='rs-react'>
										react
									</div>
								</div>

								";



		}

		return $sContent;
	}

	public function admin_init()
	{

	}
}

register_activation_hook( __FILE__, array('SG_React_Share', 'install'));

register_uninstall_hook(__FILE__, array('SG_React_Share', 'uninstall'));

add_action('init', array('SG_React_Share', 'init'));

add_action('admin_init', array('SG_React_Share', 'admin_init'));
