<?php

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

if ( isset($_POST['email'] ) ) {
	$email = $_POST['email'];

	if( !filter_var( $email, FILTER_VALIDATE_EMAIL ) ) {
		redirect( $http_referer );
	}

	$api_key  = 'Vl6rr4wdvvE5zlJWkPtKZg';
	$thankyou = 'http://mytinysecrets.com/thank-you/';
	$name     = ( isset($_POST['name'] ) && $_POST['name']) ? $_POST['name'] : '';

	if ( $name == '' ) {
		$name = 'Beautiful';
	}

	// Get all vars
	$vars = array(
		'api_key'  => $api_key,
		'name'     => ucfirst( $name ),
		'email'    => $email,
		'fields'   => array(
			'ip'           => get_ip(),
			'http_referer' => $http_referer
		)
	);

	// Send the form to ConvertKit
	$curl = curl_init('https://api.convertkit.com/v3/forms/47065/subscribe');

	curl_setopt( $curl, CURLOPT_RETURNTRANSFER, 1 );
	curl_setopt( $curl, CURLOPT_HTTPHEADER, array( "Content-type: application/json" ) );
	curl_setopt( $curl, CURLOPT_POST, true );
	curl_setopt( $curl, CURLOPT_POSTFIELDS, json_encode( $vars ) );
	$json_response = curl_exec($curl);

	curl_close( $curl );

	// Go to thank-you page to finish the process
	header( "Location: $thankyou" );
}