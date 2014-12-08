<?php
	header('content-type: application/json');

	// parse() function
	
	function curl_exec_follow(/*resource*/ $encUrl, /*int*/ &$maxredirect = null) { 
        
    $ch = curl_init();
    $mr = $maxredirect === null ? 5 : intval($maxredirect); 
    if (ini_get('open_basedir') == '' && ini_get('safe_mode' == 'Off')) { 
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, $mr > 0); 
        curl_setopt($ch, CURLOPT_MAXREDIRS, $mr); 
    } else { 
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, false); 
        if ($mr > 0) { 
            $newurl = curl_getinfo($ch, CURLINFO_EFFECTIVE_URL); 

            $rch = curl_copy_handle($ch); 
            curl_setopt($rch, CURLOPT_HEADER, true); 
            curl_setopt($rch, CURLOPT_NOBODY, true); 
            curl_setopt($rch, CURLOPT_FORBID_REUSE, false); 
            curl_setopt($rch, CURLOPT_RETURNTRANSFER, true); 
            do { 
                curl_setopt($rch, CURLOPT_URL, $newurl); 
                $header = curl_exec($rch); 
                if (curl_errno($rch)) { 
                    $code = 0; 
                } else { 
                    $code = curl_getinfo($rch, CURLINFO_HTTP_CODE); 
                    if ($code == 301 || $code == 302) { 
                        preg_match('/Location:(.*?)\n/', $header, $matches); 
                        $newurl = trim(array_pop($matches)); 
                    } else { 
                        $code = 0; 
                    } 
                } 
            } while ($code && --$mr); 
            curl_close($rch); 
            if (!$mr) { 
                if ($maxredirect === null) { 
                    trigger_error('Too many redirects. When following redirects, libcurl hit the maximum amount.',E_USER_WARNING); 
                } else { 
                    $maxredirect = 0; 
                } 
                return false; 
            } 
            curl_setopt($ch, CURLOPT_URL, $newurl); 
        } 
    } 
    return curl_exec($ch); 
} 



	function getGplusShares($url)
	{

            $buttonUrl = sprintf('https://plusone.google.com/u/0/_/+1/fastbutton?url=%s', urlencode($url));

            $htmlData  = file_get_contents($buttonUrl);
            //$htmlData  = parse($buttonUrl);        
            $iCounter = 0;
            if(preg_match('/<div[^>]*aggregateCount[^>]*>(?P<Counter>[\d]+)<\/div>/', $htmlData, $match))
            $iCounter = (int)$match['Counter'];
            return $iCounter;

            $buttonUrl = sprintf('https://plusone.google.com/u/0/_/+1/fastbutton?url=%s', urlencode($url));
            //$htmlData  = file_get_contents($buttonUrl);
            $htmlData  = parse($buttonUrl);
	
            if($iCounter)
              return $iCounter;
	
            $curl = curl_init();
            curl_setopt($curl, CURLOPT_URL, "https://clients6.google.com/rpc");
            curl_setopt($curl, CURLOPT_POST, 1);
            curl_setopt($curl, CURLOPT_POSTFIELDS, '[{"method":"pos.plusones.get","id":"p","params":{"nolog":true,"id":"' . $url . '","source":"widget","userId":"@viewer","groupId":"@self"},"jsonrpc":"2.0","key":"p","apiVersion":"v1"}]');
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-type: application/json'));
            $curl_results = curl_exec ($curl);
            curl_close ($curl);            
            $json = json_decode($curl_results, true);
            
            return intval( $json[0]['result']['metadata']['globalCounts']['count'] );
	}
	
	function get_counter_number__vk( $url ) {
		$CHECK_URL_PREFIX = 'http://vk.com/share.php?act=count&url=';
	
		$check_url = $CHECK_URL_PREFIX . $url;
	
		$data   = parse( $check_url );
		$shares = array();
	
		preg_match( '/^VK\.Share\.count\(\d, (\d+)\);$/i', $data, $shares );
	
		return $shares[ 1 ];
	}
	
	function parse( $encUrl ) {
		return curl_exec_follow($encUrl);
		$options = array(
			CURLOPT_RETURNTRANSFER	=> true, 	// return web page
			CURLOPT_HEADER 			=> false, 	// don't return headers
			CURLOPT_FOLLOWLOCATION	=> true, 	// follow redirects
			CURLOPT_ENCODING	 	=> "", 		// handle all encodings
			CURLOPT_USERAGENT	 	=> 'essb', 	// who am i
			CURLOPT_AUTOREFERER 	=> true, 	// set referer on redirect
			CURLOPT_CONNECTTIMEOUT 	=> 5, 		// timeout on connect
			CURLOPT_TIMEOUT 		=> 10, 		// timeout on response
			CURLOPT_MAXREDIRS 		=> 3, 		// stop after 3 redirects
			CURLOPT_SSL_VERIFYHOST 	=> 0,
			CURLOPT_SSL_VERIFYPEER 	=> false,
		);
		$ch = curl_init();

		$options[CURLOPT_URL] = $encUrl;  
		curl_setopt_array($ch, $options);

		$content	= curl_exec( $ch );
		$err 		= curl_errno( $ch );
		$errmsg 	= curl_error( $ch );

		curl_close( $ch );

		if ($errmsg != '' || $err != '') {
			print_r($errmsg);
		}
		return $content;
	}


	// get counters

	$json = array('url'=>'','count'=>0);
	$url = $_GET['url'];
	$json['url'] = $url;
	$network = $_GET['nw'];
	

	
	if ( filter_var($url, FILTER_VALIDATE_URL) ) {

		if ( $network == 'google2' ) {
			
			// http://www.helmutgranda.com/2011/11/01/get-a-url-google-count-via-php/
			$content = parse("https://plusone.google.com/u/0/_/+1/fastbutton?url=".$url."&count=true");
			$dom = new DOMDocument;
			$dom->preserveWhiteSpace = false;
			@$dom->loadHTML($content);
			$domxpath = new DOMXPath($dom);
			$newDom = new DOMDocument;
			$newDom->formatOutput = true;

			$filtered = $domxpath->query("//div[@id='aggregateCount']");

			if ( isset( $filtered->item(0)->nodeValue ) ) {
				$cars = array("u00c2", "u00a", 'Ã‚Â ', 'Ã‚Â', 'Ã', ',', 'Â', 'Â ');
				$count = str_replace($cars, '', $filtered->item(0)->nodeValue );
				$json['count'] = preg_replace( '#([0-9])#', '$1', $count );
			}

		}

		elseif ( $network == 'stumble' ) {
			
			$content = file_get_contents("http://www.stumbleupon.com/services/1.01/badge.getinfo?url=$url");
			$result = json_decode($content);
			if ( isset($result->result->views )) {
				$json['count'] = $result->result->views;
			}

		}
		
		elseif ($network == "google") {
			$json['count'] = getGplusShares($url);
		
		}
		
		elseif ($network == 'vk') {
			$json['count'] = get_counter_number__vk($url);
		
		}
	}
	echo str_replace('\\/','/',json_encode($json));
?>