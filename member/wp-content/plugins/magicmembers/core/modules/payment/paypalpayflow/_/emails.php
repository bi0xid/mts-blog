// issue#: 504 (2012 Jan 24)
				// emails not for guest
				if($user_id){
					
					// subject
					$subject = $system_obj->get_template('payment_success_email_template_subject', array('blogname'=>$blogname), true);
					// body
					$message = $system_obj->get_template('payment_success_email_template_body', 
											array('blogname'=>$blogname, 'name'=>$user->display_name,
											      'post_title'=>$post_title,'purchase_cost'=>$purchase_cost,  
												  'email'=>$user->user_email, 
												  'admin_email'=>$system_obj->setting['admin_email']), true);
				}											  


// issue#: 504 (2012 Jan 24)
				// emails not for guest
				if($user_id){
					
					// subject
					$subject = $system_obj->get_template('payment_failed_email_template_subject', array('blogname'=>$blogname), true);
					 
					// body			
					$message = $system_obj->get_template('payment_failed_email_template_body', 
											array('blogname'=>$blogname, 'name'=>$user->display_name,
											      'post_title'=>$post_title,'purchase_cost'=>$purchase_cost,  
												  'email'=>$user->user_email, 'payment_type'=>'post purchase payment','reason'=>$status_str,
												  'admin_email'=>$system_obj->setting['admin_email']), true);
				}


// issue#: 504 (2012 Jan 24)
				// emails not for guest
				if($user_id){
				
				
				// subject
				$subject = $system_obj->get_template('payment_pending_email_template_subject', array('blogname'=>$blogname), true);
				// body	
				$message = $system_obj->get_template('payment_pending_email_template_body', 
										array('blogname'=>$blogname, 'name'=>$user->display_name,
										      'post_title'=>$post_title,'purchase_cost'=>$purchase_cost,  
											  'email'=>$user->user_email, 'reason'=>$status_str,
											  'admin_email'=>$system_obj->setting['admin_email']), true);
				}	


// issue#: 504 (2012 Jan 24)
				// emails not for guest
				if($user_id){
					
					// subject
					$subject = $system_obj->get_template('payment_unknown_email_template_subject', array('blogname'=>$blogname), true);				
					// body	
					$message = $system_obj->get_template('payment_unknown_email_template_body', 
											array('blogname'=>$blogname, 'name'=>$user->display_name,
												  'post_title'=>$post_title,'purchase_cost'=>$purchase_cost,  
					                              'email'=>$user->user_email, 'reason'=>$status_str,
												  'admin_email'=>$system_obj->setting['admin_email']), true);
				}


// notify user	
		if(!$dpne) {
			// issue#: 504 (2012 Jan 24)
			if($user_id && $this->send_payment_email($_POST['M_CUSTOM'])) {	
				//issue #862
				$subject = mgm_replace_email_tags($subject,$user_id);
				$message = mgm_replace_email_tags($message,$user_id);
				
				mgm_mail($user->user_email, $subject, $message); //send an email to the buyer		
				//update as email sent 
				$this->update_paymentemail_sent($_POST['M_CUSTOM']);	
			}
		}		
		
		$status = __('Failed join', 'mgm'); //overridden on a successful payment
		if ($tran_success) {
			//issue #1421
			if($user_id){				
				do_action('mgm_update_coupon_usage', array('user_id' => $user_id));				
			}			
			
			// issue#: 504 (2012 Jan 24)
			// mark as purchased
			if(isset($guest_token)){
				// issue #1421
				if(isset($coupon_id) && isset($coupon_code)) {
					do_action('mgm_update_coupon_usage', array('guest_token' => $guest_token,'coupon_id' => $coupon_id));
					$this->_set_purchased(NULL, $post_id, $guest_token, $_POST['M_CUSTOM'],$coupon_code);
				}else {
					$this->_set_purchased(NULL, $post_id, $guest_token, $_POST['M_CUSTOM']);				
				}				
			}else{
				$this->_set_purchased($user_id, $post_id, NULL, $_POST['M_CUSTOM']);
			}
			// status
			$status = __('The post was purchased successfully', 'mgm');
		}	


		// notify admin, only if gateway emails on
		if (!$dge) {
			// issue#: 504 (2012 Jan 24)			
			// not for guest
			if($user_id){
				$subject = "[" . $blogname . "] Admin Notification: " . $user->user_email . " purchased post " . $post_id;
				$message = "User display name: {$user->display_name}<br />User email: {$user->user_email}<br />User ID: {$user->ID}<br />Status: " . 
				            $status . "<br />Action: Purchase post:" . $subject . "<br /><br />" . $message;
			}else{
				$subject = "[" . $blogname . "] Admin Notification: Guest[IP: ".mgm_get_client_ip_address()."] purchased post " . $post_id;
				$message = "Guest Purchase";
			}
		
			mgm_mail($system_obj->setting['admin_email'], $subject, $message);
		}									




		// on status
		switch ($member->status) {
			case MGM_STATUS_ACTIVE:
				//Sending notification email to user - issue #1468
				if($notify_user && $is_registration =='Y'){
					$user_pass = mgm_decrypt_password($member->user_password, $user_id);
					do_action('mgm_register_user_notification', $user_id, $user_pass);
				}
				// init
				$subscription = '';
				// add trial 
				if ($subs_pack['trial_on']) {
					// trial
					$subscription = sprintf('%1$s %2$s for the first %3$s %4$s,<br> then ',$member->trial_cost, $member->currency, ($member->trial_duration * $member->trial_num_cycles), $s_packs->get_pack_duration($subs_pack,true)); 
				}
				// subject
				$subject = $system_obj->get_template('payment_success_email_template_subject', array('blogname'=>$blogname), true);
				// on type
				if ($member->payment_type == 'subscription') {
					$payment_type = 'recurring subscription';
					$subscription .= sprintf('%1$s %2$s for each %3$s %4$s, %5$s',$member->amount,$member->currency, 
					                                                              $member->duration,$s_packs->get_pack_duration($subs_pack),
																				  ((int)$member->active_num_cycles > 0 ? sprintf('for %d installments',(int)$member->active_num_cycles):'until cancelled'));
				} else {
					$payment_type = 'one-time payment';
					$subscription .= sprintf('%1$s %2$s for %3$s %4$s',$member->amount, $member->currency, $member->duration,$s_packs->get_pack_duration($subs_pack));					
				}
				// body
				$message = $system_obj->get_template('payment_success_subscription_email_template_body', 
													array('blogname'=>$blogname, 'name'=>$user->display_name, 
														  'email'=>$user->user_email, 'payment_type'=>$payment_type,
														  'subscription'=>$subscription,'admin_email'=>$system_obj->setting['admin_email']), true);
				break;

			case MGM_STATUS_NULL:
				// subject
				$subject = $system_obj->get_template('payment_failed_email_template_subject', array('blogname'=>$blogname), true);				
				// message
				$message = $system_obj->get_template('payment_failed_email_template_body', 
									array('blogname'=>$blogname, 'name'=>$user->display_name, 
										  'email'=>$user->user_email, 'payment_type'=>'subscription payment',
										  'reason'=>$member->status_str,
										  'admin_email'=>$system_obj->setting['admin_email']), true);
				break;

			case MGM_STATUS_PENDING:
				// subject
				$subject = $system_obj->get_template('payment_pending_email_template_subject', array('blogname'=>$blogname), true);
				// body
				$message = $system_obj->get_template('payment_pending_email_template_body', 
										array('blogname'=>$blogname, 'name'=>$user->display_name, 
											  'email'=>$user->user_email, 'reason'=>$member->status_str,
											  'admin_email'=>$system_obj->setting['admin_email']), true);
				break;

			case MGM_STATUS_ERROR:
				// subject
				$subject = $system_obj->get_template('payment_error_email_template_subject', array('blogname'=>$blogname), true);				
				// body	
				$message = $system_obj->get_template('payment_error_email_template_body', 
									array('blogname'=>$blogname, 'name'=>$user->display_name, 
										  'email'=>$user->user_email, 'reason'=>$member->status_str,
										  'admin_email'=>$system_obj->setting['admin_email']), true);
				break;
		}

		// notify user
		if(!$dpne) {
			if($acknowledge_user) {
				//issue #862
				$subject = mgm_replace_email_tags($subject,$user_id);
				$message = mgm_replace_email_tags($message,$user_id);
				
				mgm_mail($user->user_email, $subject, $message);	
				//update as email sent 
				$this->update_paymentemail_sent($_POST['M_CUSTOM']);	
			}
		}	

		// notify admin, only if gateway emails on
		if (!$dge && $acknowledge_user) {
			$subject = "[$blogname] {$user->user_email} - {$member->status}";
			$message = "	User display name: {$user->display_name}\n\n<br />
					User email: {$user->user_email}\n\n<br />
					User ID: {$user->ID}\n\n<br />
					Membership Type: {$membership_type}\n\n<br />
					New status: {$member->status}\n\n<br />
					Status message: {$member->status_str}\n\n<br />
					Subscription period: {$member->duration} ". $s_packs->get_pack_duration($subs_pack) ."\n\n<br />
					Subscription amount: {$member->amount} {$member->currency}\n<br />
					Payment Mode: {$member->payment_type}";
			mgm_mail($system_obj->setting['admin_email'], $subject, $message);
		}

		// subject
		$subject = $system_obj->get_template('subscription_cancelled_email_template_subject', array('blogname'=>$blogname), true);				
		// body	
		$message = $system_obj->get_template('subscription_cancelled_email_template_body', 
							array('blogname'=>$blogname, 'name'=>$user->display_name, 
								  'email'=>$user->user_email, 'admin_email'=>$system_obj->setting['admin_email']), true);

		// send email notification to user
		if(!$dpne) {
			//issue #862
			$subject = mgm_replace_email_tags($subject,$user_id);
			$message = mgm_replace_email_tags($message,$user_id);
			// mail
			mgm_mail($user->user_email, $subject, $message);		
		}

		// send email notification to system administrator
		if (!$dge) {
			$subject = "[$blogname] {$user->user_email} - {$new_status}";
			$message = "	User display name: {$user->display_name}\n\n<br />
					User email: {$user->user_email}\n\n<br />
					User ID: {$user->ID}\n\n<br />
					Membership Type: {$membership_type}\n\n<br />
					New status: {$new_status}\n\n<br />
					Status message: {$member->status_str}\n\n<br />					
					Payment Mode: Cancelled";
			mgm_mail($system_obj->setting['admin_email'], $subject, $message);
		}

		
				$user = get_userdata($user_id);
				// send notification email to admin:
				$message = (__('The User: ', 'mgm')). $user->user_email.' ('. $user_id .') '.(__('has upgraded/cancelled subscription.', 'mgm'));
				$message .= "<br/>" .__('Please unsubscribe the user subscription from Gateway Merchant panel.', 'mgm');						
				if($member->transaction_id)
					$message .= "<br/>" .__('MGM Transaction Id:' ,'mgm' ) . $member->transaction_id;		
				//admin email:
				if(!empty($system_obj->setting['admin_email']))
					@mgm_mail($system_obj->setting['admin_email'], sprintf(__('[%s] User Subscription Cancellation', 'mgm'), get_option('blogname')), $message);
								