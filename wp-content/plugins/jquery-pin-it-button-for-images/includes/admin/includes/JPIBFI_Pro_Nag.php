<?php

require_once 'jpibfi_nag.php';
class JPIBFI_Pro_Nag extends JPIBFI_Nag {

    private $cancel_notice_value;
	private $stages;
	private $plugin_name;
	private $pro_link;
	private $notice_key;
	private $notice_text;

	function __construct( $plugin_prefix, $plugin_name, $pro_link ) {
		parent::__construct( $plugin_prefix );
		$this->pro_link = $pro_link;
		$this->plugin_name = $plugin_name;
		$this->notice_key = $plugin_prefix . '_pro_notice';
		$this->stages = array( 30, 60, 90, 135, 180, 225, 270, 315, 360, 405, 450, 495, 540, 585, 630, 675, 720 );
		$this->cancel_notice_value = 'END';

		$this->notice_text   = sprintf(
			__( "You've been using <b>%s</b> for quite some time now. How about checking out the Pro version? <a class='button button-primary' href='%s' target='_blank'>Yes, take me there &rarr;</a> <a class='button button-secondary' href='%s'>Thanks, but no thanks.</a>", 'jquery-pin-in-button-for-images' ),
			$plugin_name,
            $pro_link,
			'%s'
		);

		$this->setup();
	}

	public function setup() {
		if ( current_user_can( 'install_plugins' ) ) {
			$this->catch_hide_notice();
			add_action( 'admin_notices', array( $this, 'display_admin_notice' ) );
		}
	}

	private function catch_hide_notice() {
		if ( ! isset( $_GET[ $this->notice_key ] ) ) {
			return;
		}
		global $current_user;
		$datetime_install = $this->get_install_date();
		$users_stage = $this->cancel_notice_value;
		for($i = count( $this->stages )-1; $i >= 0 ; $i-- ){
			$datetime_past = new DateTime( sprintf('-%s days', $this->stages[ $i ] ) );
			if ( $datetime_past >= $datetime_install && ($i + 1 < count( $this->stages )) ) {
				$users_stage = $this->stages[ $i + 1 ];
				break;
			}
		}
		update_user_meta( $current_user->ID, $this->notice_key, $users_stage );
		wp_redirect( remove_query_arg( $this->notice_key ) );
		exit;
	}

	/**
	 * Display the admin notice
	 */
	public function display_admin_notice() {
		$current_user = wp_get_current_user();
		$users_stage  = get_user_meta( $current_user->ID, $this->notice_key, true );

		if ( $this->cancel_notice_value === $users_stage ) {
			return;
		}
		$users_stage = '' == $users_stage ? $this->stages[0] : $users_stage;
		$datetime_install = $this->get_install_date();
		$datetime_past    = new DateTime( sprintf('-%s days', $users_stage ) );

		if ( $datetime_past < $datetime_install ) {
			return;
		}
		?>
		<div class="notice notice-info is-dismissible">
			<p><?php printf( $this->notice_text, add_query_arg( $this->notice_key, '1' ) ); ?></p>
		</div>
		<?php
	}

}