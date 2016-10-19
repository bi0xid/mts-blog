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

		if( !$post_id || !$email_to || !$email_from || !$user_message ) {
			$this->returnResponseJson( 403, 'Some params are missing.' );
		}

		$post_excerpt = get_the_excerpt( $post_id );

		$headers[] = 'From: <'.$email_from.'>';
		$headers[] = 'Content-Type: text/html; charset=UTF-8';

		$subject = 'Take a look at this amazing article from MyTinySecrets!';

		$message  = '<p>Hi! your friend <strong>'.$email_from. '</strong> has recommended this article entitled <strong>'.get_the_title( $post_id ).'</strong>.</p>';
		$message .= '<p>Here is his/her remark: <strong>'.$user_message.'</strong></p>';

		// Add Post Excerpt
		if( $post_excerpt ) {
			$message .= '<p>Little summary: '.get_the_excerpt( $post_id ).'</p>';
		}

		$post_author = get_userdata( get_post_field( 'post_author', $post_id ) );
		$post_author_name = $post_author->data->user_nicename
			? $post_author->data->user_nicename
			: $post_author->data->display_name;

		$message .= '<p></p>';
		$message .= '<p>Article by <strong>'.$post_author_name.'</strong></p>';
		$message .= '<p>Link to the article: <a href="'.get_permalink( $post_id ).'" target="_blank" title="mts_blog">'.get_the_title( $post_id ).'</a></p>';

		$email = wp_mail( $email_to, $subject, $message, $headers );

		if( $email ) {
			$total_email_shares = get_post_meta( $post_id, 'total_email_shares', true );
			update_post_meta( $post_id, 'total_email_shares', ++$total_email_shares );
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
