<?php
/**
 * Created by PhpStorm.
 * User: sergey.gorbach
 * Date: 2015-06-23
 * Time: 14:17
 */

use Goutte\Client;

/**
 * Class searchTest
 */
class searchTest extends AbstractMyTinySecretsBlogTest
{
	/**
	 * Native WP search function
	 *
	 * @param $s
	 *
	 * @return array
	 */
	public function doSearch($s) {

		$query_args =
			[
				's' => $s,
                'post_type'      => array('page', 'post'),
                'post_status'    => 'publish',
                'posts_per_page' => get_option('posts_per_page'),
				'offset' => 0
			];

		$query = new WP_Query( $query_args );

		return $query->get_posts();
	}

	public function searchProvider()
	{
		return [
			['eat'],
			['Yoni Massage is an experience of deep pleasure'],
			['When a woman finds a man who gives good head'],
			[self::getUniqueStr()]
		];
	}

	/**
	 * Testing search function
	 *
	 * @param $phrase
	 * @dataProvider searchProvider
	 */
	public function testSearchPage($phrase)
	{
		$posts = $this->doSearch($phrase);
		$postCount = count($posts);
		$url = home_url("/?s=" . urlencode($phrase));

		$client = new Client();
		/* @var $crawler Symfony\Component\DomCrawler\Crawler */
		$crawler = $client->request('GET', $url);
		$this->assertEquals(200,  $client->getResponse()->getStatus());
		$this->assertEquals($postCount, $crawler->filter('.excerpt')->count(), "Failed assert that search page ({$url}) contains {$postCount} posts for phrase: '{$phrase}'");
		$this->testExistsWidgets($crawler, null, $url);
	}
}