<?php

$saveDir = realpath(__DIR__) . '/tests/tool/assets/fileCrawler/';

$imagesMimeTypes = [
	'image/gif',
	'image/jpeg',
	'image/png',
	'application/x-shockwave-flash',
	'image/psd',
	'image/bmp',
	'image/tiff',
	'image/tiff',
	'application/octet-stream',
	'image/jp2',
	'application/octet-stream',
	'application/octet-stream',
	'application/x-shockwave-flash',
	'image/iff',
	'image/vnd.wap.wbmp',
	'image/xbm',
	'image/vnd.microsoft.icon'
];

$contentTypes = [];

$result = [
	'dir' => [],
	'file' => []
];

$path = '/home/mts/domains/mts.usermd.net/public_html';

$fileInfoArray = new \RecursiveIteratorIterator(
	new \RecursiveDirectoryIterator($path)
);

foreach($fileInfoArray as $pathname => $fileInfo) {
	$realPath = str_replace($path, '', $pathname);

	if ( !$fileInfo->isFile() ) {
		/* Replace .. and . at the end of path name */
		/* Replace /.. to / and /. to '' to check 'host.pl' and 'host.pl/' */
		$realPath = preg_replace(['/\/\.\.$/', '/\/\./'], ['/', ''], $realPath);
		$result['dir'][] = $realPath;
		continue;
	}

	if( $fileInfo->isFile() ) {
		$info = mime_content_type( $pathname );
		$name = preg_replace( '/[^\w\d]+/', '', $info );

		if ( ! in_array( $info, $imagesMimeTypes ) ) {
			if ( ! isset( $result['file'][ $name ] ) ) {
				$result['file'][ $name ] = [ ];
			}

			$result['file'][ $name ][] = $realPath;
		}
	}
}

$str = '';

foreach ( $result['dir'] as $dir ) {
	$str .= $dir . "\n";
}

if ( file_exists($saveDir . 'dir.txt') ) {
	unlink($saveDir . 'dir.txt');
}
file_put_contents($saveDir . 'dir.txt', trim($str, "\n"));

foreach ( $result['file'] as $mime => $files ) {
	$str = '';
	foreach($files as $file) {
		$str .= $file . "\n";
	}

	if ( file_exists($saveDir . $mime . '.txt') ) {
		unlink($saveDir . $mime . '.txt');
	}
	file_put_contents($saveDir . $mime . '.txt', trim($str, "\n"));
}