<?php
/**
 * Created by PhpStorm.
 * User: sergey.gorbach
 * Date: 2015-06-23
 * Time: 12:01
 */

use Goutte\Client;

/**
 * Class pageTest
 */
class pageTest extends AbstractMyTinySecretsBlogTest
{
//	/**
//	 * Data provider for navigation test
//	 *
//	 * @return array
//	 */
//	public function navigationProvider()
//	{
//		$postCount = count(self::getVisiblePosts());
//		$postPerPage = get_option('posts_per_page');
//		$fullPages = intval($postCount / $postPerPage);
//
//		$provider = [
//			[home_url(), $postPerPage] /* home page in our case will be the same as page/1, but additional test should not cause any problems */
//		];
//
//		for ($i = 1; $i <= $fullPages; $i++) {
//			$provider[] = [home_url("/page/{$i}"), $postPerPage ];
//		}
//
//		if (($postCount % $postPerPage) != 0) { /* add case when last page is not full */
//			$provider[] = [home_url("/page/{$i}"), intval($postCount % $postPerPage) ];
//		}
//
//		return $provider;
//	}
//
//	/**
//	 * Testing page navigation
//	 *
//	 * @param $url
//	 * @param $postCount
//	 * @dataProvider navigationProvider
//	 */
//	public function testNavigation($url, $postCount)
//	{
//		$client = new Client();
//
//		/* @var $crawler Symfony\Component\DomCrawler\Crawler */
//		$crawler = $client->request('GET', $url);
//		$this->assertEquals(200, $client->getResponse()->getStatus(), "Failed assert that response code from '{$url}' is 200"); /* All pages should returns 200 as response */
//		$this->assertEquals($postCount, $crawler->filter('.excerpt')->count(), "Failed assert that count of  posts on '{$url}' is {$postCount}");
//		$this->testExistsWidgets($crawler, $url);
//	}

	/**
	 * Data provider for testPage function
	 *
	 * @return array
	 */
	public function pagesProvider()
	{
		return array_map(function($v) {
			return [$v];
		}, self::getVisiblePages());
	}

	/**
	 * Testing pages
	 *
	 * @param $page
	 * @dataProvider pagesProvider
	 */
	public function testPage($page)
	{
		if (in_array($page->post_name, ['contact-me'])) {
			$this->markTestSkipped("Test skipped for page = '{$page->post_name}' because we using not standard wp contact page");
		}

		$this->testSingleWPUnit($page);
	}
}