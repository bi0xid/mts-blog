<?php
/**
 * Created by PhpStorm.
 * User: sergey.gorbach
 * Date: 2015-06-23
 * Time: 20:44
 */

use Goutte\Client;

/**
 * Class imagesTest
 */
class imagesTest extends AbstractMyTinySecretsBlogTest
{
	/**
	 * Data provider for testImages function
	 *
	 * @return array
	 */
	public function imageProvider()
	{
		$posts = self::getVisiblePosts();
		$pages = self::getVisiblePages();

		$units = array_merge($posts, $pages);

		$urls = [
			[home_url()]
		];

		foreach ($units as $unit) {
			$urls[] = [get_permalink($unit)];
		}
		return $urls;
	}

	/**
	 * Testing if all images exists and return not empty content
	 *
	 * This is not standard phpunit test, continue execute on fail
	 *
	 * @param $url
	 * @dataProvider imageProvider
	 * @group hard-loaded
	 */
	public function testImages($url)
	{
		$checkedImages = [];

		$client = new Client();
		/* @var $crawler Symfony\Component\DomCrawler\Crawler */
		$crawler = $client->request('GET', $url);
		$this->assertSame(200, $client->getResponse()->getStatus(), "Failed assert that '{$url}' return 200 code");

		$images = $crawler->filter('img');
		$count = $images->count();

		for ($i = 0; $i < $count; $i++) {
			$image = $images->getNode($i)->getAttribute('src');

			if (isset($checkedImages[$image])) {
				continue;
			}

			$checkedImages[$image] = true;

			/* Check image on origin server, replace cdn */
			$originImage =  preg_replace(['/^http\:\/\/cdn\./', '/^https\:\/\/cdn\./'], ['http://', 'https://'], $image);

			$client->request('GET', $originImage );
			if (200 != $client->getResponse()->getStatus()) {
				echo "Failed assert that image '{$originImage}' returns 200 code for '{$url}'\n";
				continue;
			}

			if (!$client->getResponse()->getContent()) {
				echo "Failed assert that image '{$originImage}' has not empty content for '{$url}'\n";
				continue;
			}

			if ( $image != $originImage ) {
				/* Check image on cdn with HEAD method */
				$client->request('HEAD', $image);
				if (200 != $client->getResponse()->getStatus()) {
					echo "Failed assert that image '{$image}' returns 200 code for '{$url}'\n";
				}
			}
		}
	}
}