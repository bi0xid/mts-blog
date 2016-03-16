<?php
/**
 * Created by PhpStorm.
 * User: sergey.gorbach
 * Date: 2015-06-23
 * Time: 15:54
 */

use Goutte\Client;

/**
 * Class xmlFeederTest
 */
class xmlFeederTest extends AbstractMyTinySecretsBlogTest
{
	/**
	 * Simple test if xml feed has any information
	 */
	public function testXml()
	{
		$postPerPage = 5; /* this value from xml.php file */

		$args = [
			'post_type'      => array('post', 'youtube-video'),
			'post_status'    => 'publish',
			'posts_per_page' => -1,
			'offset'         => 0
		];

		$posts = get_posts($args);
		$postsCount = count($posts);
		$mod = $postsCount % $postPerPage;
		$pages = intval($postsCount / $postPerPage) + (($mod == 0) ? 0 : 1);

		$url = home_url('/xml.php');

		$client = new Client();
		$crawler = $client->request('GET', $url);
		$this->assertEquals(200 , $client->getResponse()->getStatus(), "Failed assert that response code from '{$url}' is 200");
		$this->assertEquals('application/xml; charset=UTF-8', $client->getResponse()->getHeader('Content-Type'), "Failed assert that content type from '{$url}' is xml");
		$this->assertSame($postPerPage, $crawler->filter('post')->count());

		$url = home_url('/xml.php?page=' . $pages);
		$client = new Client();
		$crawler = $client->request('GET', $url);
		$this->assertEquals(200 , $client->getResponse()->getStatus(), "Failed assert that response code from '{$url}' is 200");
		$this->assertEquals('application/xml; charset=UTF-8', $client->getResponse()->getHeader('Content-Type'), "Failed assert that content type from '{$url}' is xml");
		$this->assertSame($mod, $crawler->filter('post')->count());
	}
}