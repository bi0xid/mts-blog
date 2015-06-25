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
	public static $forbidden = [];
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
		$filePath = realpath(__DIR__) . '/tool/assets/urlCrawler';
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
					$reportFile
				];
			}
		}

		return $data;
	}

	/**
	 * Testing full statuses and redirections
	 *
	 * @param $url
	 * @param $expectedCode
	 * @param $expectedLocation
	 * @param $reportPath
	 * @dataProvider dataProvider
	 */
	public function testFullStatusAndRedirection($url, $expectedCode, $expectedLocation, $reportPath)
	{
		$filePath = realpath(__DIR__) . '/tool/assets/urlCrawler';
		$client = new Client();
		$client->followRedirects(false);

		$client->request('HEAD', $url);

		$status = $client->getResponse()->getStatus();
		$finalLocation = $client->getResponse()->getHeader('location', true);
		$finalLocation = $finalLocation ? $finalLocation : '';

		$msg = '';

		if ($status != $expectedCode) {
			$msg = "Failed assert that status {$status} = $expectedCode(expected $expectedCode) from {$url}. ";
		}

		if ($finalLocation != $expectedLocation) {
			$msg .= "Failed assert that location {$finalLocation} = $expectedLocation from {$url}. ";
		}

		if($msg != '') {
			echo $finalLocation;
			file_put_contents($reportPath, $msg, FILE_APPEND);
			$this->assertTrue(false, $msg);
		}
	}
}