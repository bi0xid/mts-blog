<?php

function redirect( $http_referer = '' ) {
	if( $http_referer ) {
		header( "Location: {$http_referer}" );
	} else {
		header( 'Location: http://mytinysecrets.com/' );
	}
	exit();
}

$http_referer = isset( $_SERVER['HTTP_REFERER'] ) ? $_SERVER['HTTP_REFERER'] : '';
$http_referer = filter_var( $http_referer, FILTER_VALIDATE_URL ) ? $http_referer : '';

if ( isset($_POST['email'] ) ) {
	$email = $_POST['email'];

	if( !filter_var( $email, FILTER_VALIDATE_EMAIL ) ) {
		redirect( $http_referer );
	}

	$api_key = 'Vl6rr4wdvvE5zlJWkPtKZg';
	$name    = ( isset($_POST['name'] ) && $_POST['name']) ? $_POST['name'] : '';


	$thankyou = 'http://mytinysecrets.com/thank-you/';

	if ( $name == '' ) {
		$name = 'Beautiful';
	}

	// Get all vars
	$vars = array(
		'api_key'  => $api_key,
		'name'     => ucfirst( $name ),
		'email'    => $email,
		'tags'     => $tags,
		'form_id'  => '47065',
		'thankyou' => $thankyou,
	);

	// Send the form to ConvertKit
	$curl = curl_init('https://api.convertkit.com/v3/forms/47065/subscribe');

	curl_setopt( $curl, CURLOPT_RETURNTRANSFER, 1 );
	curl_setopt( $curl, CURLOPT_HTTPHEADER, array( "Content-type: application/json" ) );
	curl_setopt( $curl, CURLOPT_POST, true );
	curl_setopt( $curl, CURLOPT_POSTFIELDS, json_encode( $vars ) );

	curl_close( $curl );

	// Go to thank-you page to finish the process
	header( "Location: $thankyou" );
}
