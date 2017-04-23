<?php

/**
* Form Signup Class for all the courses signups
* Penis Magic Course
* @author Alejandro Orta (alejandro@mytinysecrets.com)
*/
class FormSignups {
	protected $pages_ids = array(
		'penis_magic_course'       => 12831,
		'pussy_empowerment_course' => 12835,
		'energy_orgasm_course'     => 13336
	);

	protected $convertkit_url = array(
		'penis_magic_course'       => 'https://api.convertkit.com/v3/forms/47312/subscribe',
		'pussy_empowerment_course' => 'https://api.convertkit.com/v3/forms/47349/subscribe',
		'energy_orgasm_course'     => 'https://api.convertkit.com/v3/forms/47351/subscribe'
	);

	protected $convertkit_vars = array(
		'api_key'  => 'Vl6rr4wdvvE5zlJWkPtKZg'
	);

	private $conn;

	private $db;
	private $password;
	private $username;
	private $servername;

	function __construct() {
	    $this->db = getenv('ARLS_DB_NAME');
	    $this->password = getenv('ARLS_DB_PASS');
	    $this->username = getenv('ARLS_DB_USER');
	    $this->servername = getenv('ARLS_DB_HOST');
		$this->conn = mysqli_connect( $this->servername, $this->username, $this->password, $this->db );
	}

	/**
	 * Each form will be redirected to a specific function
	 * @param post_data
	 */
	public function submitFormSignup( $data ) {
		if( $data['email'] && $data['form_id'] && $data['name'] ) {
			if( $this->checkIfEmailExists( $data['email'], $data['form_id'] ) ) {
				wp_redirect( get_permalink( $this->pages_ids[$data['form_id']] ).'?existing_email=true' );
				exit;
			}

			$this->saveIntoDataBase( $data['email'], $data['form_id'] );
			$this->saveEmailIntoConvertKit( $data['email'], $data['form_id'], $data['name'] );

			wp_redirect( get_permalink( 14039 ).'?course='.$data['form_id'] );
			exit;
		}
	}

	/**
	 * Check if the Email exists inside our database
	 * @param user_email
	 * @param form_id
	 * @return boolean
	 */
	private function checkIfEmailExists( $email, $form_id ) {
		$query = 'SELECT ID FROM wparl_leads WHERE user_email = "'.$email.'" AND form_id = "'.$form_id.'"';

		$existing_email = mysqli_query( $this->conn, $query );

		return $existing_email->fetch_array() > 0;
	}

	/**
	 * Save new row into database
	 * @param user_email
	 * @param form_id
	 */
	private function saveIntoDataBase( $email, $form_id ) {
		$query = 'INSERT INTO `wparl_leads` (`form_id`, `user_email`) VALUES ("'.$form_id.'", "'.$email.'")';
		$insert = mysqli_query( $this->conn, $query );
	}

	/**
	 * Save the new Email into Converkit
	 * @param user_email
	 * @param form_id
	 * @param name
	 * @return response json
	 */
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
