<?php

/**
* Form Signup Class for all the courses signups
* Penis Magic Course
* @author Alejandro Orta (alejandro@mytinysecrets.com)
*/
class FormSignups {
	private $conn;

	protected $db = 'adinariv_arls';
	protected $password = '6LC0SN9.P[';
	protected $username = 'adinariv_arls';
	protected $servername = 'loveschool.cgwdbyp5vyan.us-east-1.rds.amazonaws.com';

	function __construct() {
		$this->conn = mysql_connect( $this->servername, $this->username, $this->password );
		mysql_select_db( $this->db, $this->conn );
	}

	public function submitFormSignup( $data ) {
		switch ( $data['form_id'] ) {
			case 'penis_magic_course':
				$this->penisMagicCourseSignup( $data );
				break;
		}
	}

	public function penisMagicCourseSignup( $data ) {

	}
}