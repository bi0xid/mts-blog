<?php
/**
 * Created by PhpStorm.
 * User: sergey.gorbach
 * Date: 2015-06-25
 * Time: 12:01
 */

use Goutte\Client;

/**
 * Class pageTest
 */
class fullStatusAndRedirections extends AbstractMyTinySecretsBlogTest
{
	public static $failedCounter = 0;

	public static $failedForbidden = [];
	/**
	 * @beforeClass
	 */
	public static function setUpLocationsData() {
		$reportsPath = realpath( __DIR__ ) . '/tool/reports/';

		$fileInfoArray = new \RecursiveIteratorIterator(
			new \RecursiveDirectoryIterator( $reportsPath )
		);

		/* Remove old reports */
		foreach ( $fileInfoArray as $pathname => $fileInfo ) {
			if ( ! preg_match( '/txt$/', $pathname ) ) {
				continue;
			}
			@unlink($pathname);
		}
	}

	public function dataProvider()
	{
		$data = [];

		$reportsPath = realpath( __DIR__ ) . '/tool/reports/';
		$filePath = realpath(__DIR__) . '/tool/assets/urlCrawler/';
		$this->assertFileExists($filePath);
		$this->assertFileExists($reportsPath);

		$fileInfoArray = new \RecursiveIteratorIterator(
			new \RecursiveDirectoryIterator($filePath)
		);

		foreach($fileInfoArray as $pathname => $fileInfo) {
			if(!preg_match('/txt$/', $pathname)) {
				continue;
			}

			preg_match('/(?<name>[^\/]+)\.txt/', $pathname, $m);
			$fileName = date("Y-m-d_H:i:s") . '_' .$m['name'] . '.txt';
			$reportFile = $reportsPath . '/' . $fileName;

			$content = file_get_contents($pathname);
			$loop = explode("\n", $content);

			foreach($loop as $line){
				$container = explode('|:|', $line);
				$url = home_url($container[0]);
				$data[] = [
					$url,
					$container[1],
					$container[2],
					$reportFile,
					false,
					$m['name']
				];
			}
		}

		/*last element*/
		$data[] = [
			null,
			null,
			null,
			null,
			true,
			$m['name']
		];

		return $data;
	}

	/**
	 * Testing full statuses and redirections
	 *
	 * @param $url
	 * @param $expectedCode
	 * @param $expectedLocation
	 * @param $reportPath
	 * @param $isLast
	 * @param $name Name of file
	 * @dataProvider dataProvider
	 * @return null
	 * @group full-redirection
	 */
	public function testFullStatusAndRedirection($url, $expectedCode, $expectedLocation, $reportPath, $isLast, $name)
	{
		if($isLast){ /* show final report */
			echo "\n total failed test: " . self::$failedCounter . "\n";
			echo "Please check reports files\n";
			die(); /* finish process to not to show last native report from phpunit */
		}

		if ($expectedCode == 403 ) { /* Skipping check children forbidden if parent forbidden failed */
			foreach (self::$failedForbidden as $for) {
				if(false !== strpos($url, $for))	{
					return null;
				}
			}
		}

		$realSite = 'mytinysecrets.com';
		$devSite = str_replace(['https://', 'http://'], '', home_url());
		$expectedLocation = str_replace($realSite, $devSite, $expectedLocation);

		$filePath = realpath(__DIR__) . '/tool/assets/urlCrawler';
		$client = new Client();
		$client->followRedirects(false);

		$client->request('HEAD', $url);

		$status = $client->getResponse()->getStatus();
		$finalLocation = $client->getResponse()->getHeader('location', true);
		$finalLocation = $finalLocation ? $finalLocation : '';

		$msg = '';

		/* checking directory nginx has 403 for all directories, but apache 200. For us it important to access file in directory, not listing directory */
		if ($name = 'dir' && $status == 403 && $expectedCode == 200) {
			return null;
		}

		if ($status != $expectedCode) {
			$msg = "Failed assert that status {$status} = $expectedCode(expected $expectedCode) from {$url}. ";
		}

		if ($finalLocation != $expectedLocation) {
			$msg .= "Failed assert that location {$finalLocation} = $expectedLocation from {$url}. ";
		}

		if($msg != '') {
			if ($expectedCode == 403) { //if forbidden failed then we do not need to check other children urls
				self::$failedForbidden[] = $url;
			}
			self::$failedCounter++;

			file_put_contents($reportPath, $msg . "\n", FILE_APPEND);
			//$this->assertTrue(false); /* not enough memory */
		}
	}
}
