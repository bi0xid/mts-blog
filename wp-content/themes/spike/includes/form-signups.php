<?php

/**
* Form Signup Class for all the courses signups
* Penis Magic Course
* @author Alejandro Orta (alejandro@mytinysecrets.com)
*/
class FormSignups {
	protected $pages_ids = array(
		'penis_magic_course' => 12831
	);

	protected $thank_you_pages = array(
		'penis_magic_course' => 12833
	);

	protected $convertkit_url = array(
		'penis_magic_course' => 'https://api.convertkit.com/v3/forms/47312/subscribe'
	);

	protected $convertkit_vars = array(
		'api_key'  => 'Vl6rr4wdvvE5zlJWkPtKZg'
	);

	private $conn;

/*
	protected $db = 'adinariv_arls';
	protected $password = '6LC0SN9.P[';
	protected $username = 'adinariv_arls';
	protected $servername = 'loveschool.cgwdbyp5vyan.us-east-1.rds.amazonaws.com';
*/

	protected $db = 'mytinyse_loveschool_multi';
	protected $password = '';
	protected $username = 'root';
	protected $servername = 'localhost';

	function __construct() {
		$this->conn = mysql_connect( $this->servername, $this->username, $this->password );
		mysql_select_db( $this->db, $this->conn );
	}

	/**
	 * Each form will be redirected to a specific function
	 * @param post_data
	 */
	public function submitFormSignup( $data ) {
		switch ( $data['form_id'] ) {
			case 'penis_magic_course':
				$this->penisMagicCourseSignup( $data );
				break;
		}
	}

	/**
	 * Handle Penis Magic Course form signups
	 * @param post_data
	 * @return url redirect
	 */
	public function penisMagicCourseSignup( $data ) {

		if( $this->checkIfEmailExists( $data['email'], $data['form_id'] ) ) {
			wp_redirect( get_permalink( $this->pages_ids[$data['form_id']] ).'?existing_email=true' );
			exit;
		}

		$this->saveIntoDataBase( $data['email'], $data['form_id'] );
		$this->saveEmailIntoConvertKit( $data['email'], $data['form_id'], $data['name'] );

		wp_redirect( get_permalink( $this->thank_you_pages[$data['form_id']] ) );
		exit;
	}

	/**
	 * Check if the Email exists inside our database
	 * @param user_email
	 * @param form_id
	 * @return boolean
	 */
	private function checkIfEmailExists( $email, $form_id ) {
		$query = 'SELECT ID FROM wparl_leads WHERE user_email = "'.$email.'" AND form_id = "'.$form_id.'"';

		$existing_email = mysql_query( $query, $this->conn );

		return mysql_fetch_array( $existing_email ) > 0;
	}

	private function saveIntoDataBase( $email, $form_id ) {
		$query = 'INSERT INTO `wparl_leads` (`form_id`, `user_email`) VALUES ("'.$form_id.'", "'.$email.'")';
		$insert = mysql_query( $query, $this->conn );
	}

	private function saveEmailIntoConvertKit( $email, $form_id, $name ) {
		$this->convertkit_vars['email'] = $email;	
		$this->convertkit_vars['form_id'] = $form_id;
		$this->convertkit_vars['name'] = ucfirst( $name );

		$curl = curl_init( $this->convertkit_url[$form_id] );
		curl_setopt( $curl, CURLOPT_HEADER, 0 );
		curl_setopt( $curl, CURLOPT_VERBOSE, 1 );
		curl_setopt( $curl, CURLOPT_RETURNTRANSFER, 1 );
		curl_setopt( $curl, CURLOPT_HTTPHEADER, array( 'Content-type: application/json' ) );
		curl_setopt( $curl, CURLOPT_POST, 1 );
		curl_setopt( $curl, CURLOPT_POSTFIELDS, json_encode( $this->convertkit_vars ) );

		$json_response = curl_exec( $curl );
		curl_close( $curl );

		return $json_response;
	}
}
