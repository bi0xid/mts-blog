<?php

	$thankyou = 'http://mytinysecrets.com/thank-you';

if ( !isset($_POST['email'] ) ) {
		header( "Location: $thankyou" );
		die();
}

require_once('ontraport/Ontraport.php');


function redirect( $http_referer = '' ) {
	if( $http_referer ) {
		header( "Location: {$http_referer}" );
	} else {
		header( 'Location: http://mytinysecrets.com/' );
	}
	exit();
}

function get_ip() {
    if ( ! empty( $_SERVER['HTTP_CLIENT_IP'] ) ) {
            $ip = $_SERVER['HTTP_CLIENT_IP'];
    } elseif ( ! empty( $_SERVER['HTTP_X_FORWARDED_FOR'] ) ) {
            $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
    } else {
            $ip = $_SERVER['REMOTE_ADDR'];
    }

    return $ip;
}

$http_referer = isset( $_SERVER['HTTP_REFERER'] ) ? $_SERVER['HTTP_REFERER'] : '';
$http_referer = filter_var( $http_referer, FILTER_VALIDATE_URL ) ? $http_referer : '';

	$name  = $_POST['name'];
	$email = $_POST['email'];

	if( !filter_var( $email, FILTER_VALIDATE_EMAIL ) ) {
		redirect( $http_referer );
	}

	if ( $name == '' ) {
		$name = 'Beautiful';
	}


	// Get all vars
    use OntraportAPI\Ontraport;

    // Authentication occurs when the API Key and App ID are sent as request headers
    // These headers are set when you create a new instance of the Ontraport client
    $client = new Ontraport("2_139657_iRKxiogo6","WI3Rua3cR4GiROW");

    $requestParams = array(
        "objectID"  => 0, // Contact object
        "firstname" => ucfirst( $name ),
        "email"     => $email,
        "ip_addy"   => $ip,
        "website"   => $http_referer,
        "updateSequence" => "13"
    );
    $response = $client->contact()->saveOrUpdate($requestParams);

	// Go to thank-you page to finish the process
	header( "Location: $thankyou" );
