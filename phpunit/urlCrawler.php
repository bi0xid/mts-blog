<?php
/**
 * Created by PhpStorm.
 * User: sergey.gorbach
 * Date: 2015-06-25
 * Time: 22:37
 */

include 'bootstrap.php';

use Goutte\Client;

$domain = 'http://mytinysecrets.com';
$dir = realpath(__DIR__) . '/tests/tool/assets/fileCrawler/';

$saveDir = realpath(__DIR__) . '/tests/tool/assets/urlCrawler/';

/* remove all files before */
$fileInfoArray = new \RecursiveIteratorIterator(
	new \RecursiveDirectoryIterator($saveDir)
);

foreach($fileInfoArray as $pathname => $fileInfo) {
	if ( !preg_match('/txt$/', $pathname)) {
		continue;
	}
	@unlink($pathname);
}


$fileInfoArray = new \RecursiveIteratorIterator(
	new \RecursiveDirectoryIterator($dir)
);

$client = new Client();
$client->followRedirects(false);

foreach($fileInfoArray as $pathname => $fileInfo) {
	if ( !preg_match('/txt$/', $pathname)) {
		continue;
	}

	preg_match('/(?<name>[^\/]+)\.txt/', $pathname, $m);
	$fileName = $m['name'] . '.txt';

	$content = file_get_contents($pathname);
	$loop = explode("\n", $content);
	$result = '';


	foreach ($loop as $file) {
		$url = $domain . $file;

try {
		/* @var $crawler Symfony\Component\DomCrawler\Crawler */
		$crawler = $client->request('HEAD', $url);
} catch (Exception $e) {
    echo 'Caught exception: '.  $e->getMessage() . " url: {$url}\n";
continue;
}


		$status = $client->getResponse()->getStatus();
		$finalLocation = $client->getResponse()->getHeader('location', true);
		$finalLocation = $finalLocation ? $finalLocation : '';

		$result .= implode('|:|', [$file, $status, $finalLocation]) . "\n";
	}

	if ( file_exists($saveDir . $fileName) ) {
		unlink($saveDir . $fileName);
	}
	file_put_contents($saveDir . $fileName, trim($result, "\n"));
}
