<?php
/**
 * Created by PhpStorm.
 * User: sergey.gorbach
 * Date: 2015-06-23
 * Time: 13:53
 */

use Goutte\Client;

/**
 * Class AbstractMyTinySecretsBlogTest
 */
class AbstractMyTinySecretsBlogTest extends \PHPUnit_Framework_TestCase
{
	/**
	 * Generate unique string
	 *
	 * @return string
	 */
	protected static function getUniqueStr()
	{
		return str_repeat(sha1(123456789), 5);
	}

	/**
	 * Get visible posts
	 *
	 * @return array
	 */
	public static function getVisiblePosts()
	{
		$args = array(
			'posts_per_page' => -1,
			'post_status' => ['publish']
		);

		return get_posts($args);
	}

	/**
	 * Get visible posts
	 *
	 * @return array
	 */
	public static function getVisiblePages()
	{
		$args = array(
			'offset' => 0,
			'post_type' => 'page',
			'post_status' => ['publish'],
			'posts_per_page' => -1
		);

		return get_pages($args);
	}

	/**
	 * Test exists widget
	 *
	 * You can use unit to get info about some exceptions and exclude from tests
	 *
	 * @group helpers
	 *
	 * @param $crawler
	 * @param $unit post|page
	 * @param $url
	 * @return null
	 */
	public function testExistsWidgets($crawler, $unit, $url)
	{
		/* All pagination pages contains menu */
		$this->assertEquals(1, $crawler->filter('#navigation')->count(), "Failed assert that '{$url}' contains '#navigation' (menu)");

		if (in_array($unit->post_name, ['thank-you'])) {
			$this->markTestSkipped("Test 'testExistsWidgets' skipped for page = '{$unit->post_name}'");
		}

		/* Search form */
		$this->assertEquals(1, $crawler->filter('.search-form')->count(), "Failed assert that '{$url}' contains '.search-form' (search form)");
		/* 'Follow MyTinySecrets' widget */
		$this->assertEquals(1, $crawler->filter('html:contains("Follow MyTinySecrets")')->count(), "Failed assert that '{$url}' contains 'Follow MyTinySecrets' widget");
		/* 'Recommended Products' widget */
		$this->assertEquals(1, $crawler->filter('html:contains("Recommended Products")')->count(), "Failed assert that '{$url}' contains 'Recommended Products' widget");
		/* 'MyTinySecrets Videos' widget */
		$this->assertEquals(1, $crawler->filter('html:contains("MyTinySecrets Videos")')->count(), "Failed assert that '{$url}' contains 'MyTinySecrets Videos' widget");
		/* 'Most Shared Posts' widget */
		$this->assertEquals(1, $crawler->filter('html:contains("Most Shared Posts")')->count(), "Failed assert that '{$url}' contains 'Most Shared Posts' widget");
		/* 'My Favorite Posts' widget */
		$this->assertEquals(1, $crawler->filter('html:contains("My Favorite Posts")')->count(), "Failed assert that '{$url}' contains 'My Favorite Posts' widget");
		/* 'Meet the Person Behind MTS' widget */
		$this->assertEquals(1, $crawler->filter('html:contains("Meet the Person Behind MTS")')->count(), "Failed assert that '{$url}' contains 'Meet the Person Behind MTS' widget");
		/* 'Recent Posts' widget */
		$this->assertEquals(1, $crawler->filter('html:contains("Recent Posts")')->count(), "Failed assert that '{$url}' contains 'Recent Posts' widget");
		/* 'widget_text-custom' scrolling advertising */
		$this->assertEquals(1, $crawler->filter('#widget_text-custom')->count(), "Failed assert that '{$url}' contains '#widget_text-custom' (scrolling advertising)");
	}

	/**
	 * @group helpers
	 * @param $unit wp post|page
	 *
	 * TODO: add check of fb 'og' content
	 */
	public function testSingleWPUnit($unit)
	{
		$client = new Client();

		$title = get_post_meta( $unit->ID, "_aioseop_title", true );
		if (empty($title)) {
			$title = $unit->post_title;
		}

		$url = get_permalink($unit);

		/* @var $crawler Symfony\Component\DomCrawler\Crawler */
		$crawler = $client->request('GET', $url);

		$this->assertEquals(200 , $client->getResponse()->getStatus(), "Failed assert that response code from '{$url}' is 200");

		if ($title != '') {
			$this->assertContains(
				preg_replace('/[^\da-z]/i', '', $title),
				preg_replace('/[^\da-z]/i', '', $crawler->filterXPath('//title')->text()),
				"Failed assert that '{$url}' contains title from database"
			);
		}

		$this->testExistsWidgets($crawler, $unit, $url);

		$attachments = get_posts( array(
			'post_type' => 'attachment',
			'posts_per_page' => -1,
			'post_parent' => $unit->ID,
		) );

		if ( $attachments ) { /* all images */
			foreach ( $attachments as $attachment ) {
				$attachmentUrl = wp_get_attachment_image_src($attachment->ID, 'thumbnail')['url'];
				$client->request('HEAD', $attachmentUrl);
				$this->assertEquals(200 , $client->getResponse()->getStatus(), "Failed assert that response from '{$attachmentUrl}' is 200");
			}
		}
	}
}