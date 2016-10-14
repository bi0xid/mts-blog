<?php

/**
* Email Share backend
* @author Alejandro alejandro@mytinysecrets.com
*/
class EmailShareClass {
	function __construct() {
		add_action( 'wp_ajax_share_via_email', array( $this, 'share_via_email' ) );
		add_action( 'wp_ajax_nopriv_share_via_email', array( $this, 'share_via_email' ) );
	}

	public function share_via_email() {
		if(!check_ajax_referer('seguridad', 'security')) {
			echo json_encode('Security error');
			exit;
		}

		$post_id = (int) $_POST['post_id'];

		$user_message = $_POST['message'];
		$email_to     = $_POST['email_to'];
		$email_from   = $_POST['email_from'];

		if( !$post_id || !$email_to || !$email_from ) {
			$this->returnResponseJson( 403, 'Some params are missing.' );
		}

		$post_excerpt = get_the_excerpt( $post_id );

		$headers[] = 'From: <'.$email_from.'>';
		$headers[] = 'Content-Type: text/html; charset=UTF-8';

		$subject = 'Take a look at this amazing article from MyTinySecrets!';

		$message = '';

		// Add user message
		if( $user_message ) {
			$message .= $user_message.'</br>';
		}

		// Add Post Excerpt
		if( $post_excerpt ) {
			$message .= get_the_excerpt( $post_id );
		}

		// Add Post Link
		$message .= '</br><a href="'.get_permalink( $post_id ).'" target="_blank" title="mts_blog">'.get_the_title( $post_id ).'</a>';
		var_dump($message);die();
		$email = wp_mail( $email_to, $subject, $message, $headers );

		if( $email ) {
			$this->returnResponseJson( 200, 'Message sent successfully!' );
		} else {
			$this->returnResponseJson( 403, 'There was an error while sending the email. Please try again later.' );
		}
	}

	private function returnResponseJson( $code, $message ) {
		echo json_encode( array( 
			'code'    => $code,
			'message' => $message
		) );
		die();
	}
}
