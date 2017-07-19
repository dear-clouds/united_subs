<?php

	/**
	Sends mail
	This function manage the Mail stuff sent by plugin
	to users
	**/
	
	function userpro_mail_set_content_type( $content_type ) {
		return 'text/html';
	}

	function userpro_mail($id, $template=null, $var1=null, $form=null) {
		global $userpro;
		
		add_filter( 'wp_mail_content_type', 'userpro_mail_set_content_type' );
		
		$user = get_userdata($id);
		$builtin = array(
			'{USERPRO_ADMIN_EMAIL}' => userpro_get_option('mail_from'),
			'{USERPRO_BLOGNAME}' => userpro_get_option('mail_from_name'),
			'{USERPRO_BLOG_URL}' => home_url(),
			'{USERPRO_BLOG_ADMIN}' => admin_url(),
			'{USERPRO_LOGIN_URL}' => $userpro->permalink(0, 'login'),
			'{USERPRO_USERNAME}' => $user->user_login,
			'{USERPRO_FIRST_NAME}' => userpro_profile_data('first_name', $user->ID ),
			'{USERPRO_LAST_NAME}' => userpro_profile_data('last_name', $user->ID ),
			'{USERPRO_NAME}' => userpro_profile_data('display_name', $user->ID ),
			'{USERPRO_EMAIL}' => $user->user_email,
			'{USERPRO_PROFILE_LINK}' => $userpro->permalink( $user->ID ),
			'{USERPRO_VALIDATE_URL}' => $userpro->create_validate_url( $user->ID ),
			'{USERPRO_PENDING_REQUESTS_URL}' => admin_url() . '?page=userpro&tab=requests',
			'{USERPRO_ACCEPT_VERIFY_INVITE}' => $userpro->accept_invite_to_verify($user->ID),
		);
		
		if (isset($var1) && !empty($var1) ){
			$builtin['{VAR1}'] = $var1;
		}
		
		if (isset($form) && $form != ''){
			$profile_fields = $userpro->extract_profile_for_mail( $user->ID, $form );
			$builtin['{USERPRO_PROFILE_FIELDS}'] = $profile_fields['output'];
			$builtin = array_merge($builtin,$profile_fields['custom_fields']);
		}
		
		$search = array_keys($builtin);
		$replace = array_values($builtin);

		$headers = 'From: '.userpro_get_option('mail_from_name').' <'.userpro_get_option('mail_from').'>' . "\r\n";

		/////////////////////////////////////////////////////////
		/* verify email/new registration */
		/////////////////////////////////////////////////////////
		if ($template == 'verifyemail'){
			$subject = userpro_get_option('mail_verifyemail_s');
			$subject = str_replace( $search, $replace, $subject );
			$message = nl2br(userpro_get_option('mail_verifyemail'));
			$message = str_replace( $search, $replace, $message );
		}
		
		/////////////////////////////////////////////////////////
		/* secret key request */
		/////////////////////////////////////////////////////////
		if ($template == 'secretkey'){
				
			$subject = userpro_get_option('mail_secretkey_s');
			$subject = str_replace( $search, $replace, $subject );
			
			$message = nl2br(userpro_get_option('mail_secretkey'));
			$message = str_replace( $search, $replace, $message );
			
		}
		
		if( $template == 'reset_mail' ){
			$subject = userpro_get_option('reset_password_mail_s');
			$subject = str_replace( $search, $replace, $subject );
			$message = nl2br(userpro_get_option('reset_password_mail_c'));
			$message = str_replace( $search, $replace, $message );
		}
		/////////////////////////////////////////////////////////
		/* account being removed */
		/////////////////////////////////////////////////////////
		if ($template == 'accountdeleted'){
			$subject = userpro_get_option('mail_accountdeleted_s');
			$subject = str_replace( $search, $replace, $subject );
			$message = nl2br(userpro_get_option('mail_accountdeleted'));
			$message = str_replace( $search, $replace, $message );	
		}
		
		/////////////////////////////////////////////////////////
		/* verification invite */
		/////////////////////////////////////////////////////////
		if ($template == 'verifyinvite'){
			$subject = userpro_get_option('mail_verifyinvite_s');
			$subject = str_replace( $search, $replace, $subject );
			$message = nl2br(userpro_get_option('mail_verifyinvite'));
			$message = str_replace( $search, $replace, $message );
		}
		
		/////////////////////////////////////////////////////////
		/* account being verified */
		/////////////////////////////////////////////////////////
		if ($template == 'accountverified'){
			$subject = userpro_get_option('mail_accountverified_s');
			$subject = str_replace( $search, $replace, $subject );
			$message = nl2br(userpro_get_option('mail_accountverified'));
			$message = str_replace( $search, $replace, $message );
		}
		
		/////////////////////////////////////////////////////////
		/* account being unverified */
		/////////////////////////////////////////////////////////
		if ($template == 'accountunverified'){
			$subject = userpro_get_option('mail_accountunverified_s');
			$subject = str_replace( $search, $replace, $subject );
			$message = nl2br(userpro_get_option('mail_accountunverified'));
			$message = str_replace( $search, $replace, $message );
		}
		
		/////////////////////////////////////////////////////////
		/* account being blocked */
		/////////////////////////////////////////////////////////
		if ($template == 'accountblocked'){
			$subject = userpro_get_option('mail_accountblocked_s');
			$subject = str_replace( $search, $replace, $subject );
			$message = nl2br(userpro_get_option('mail_accountblocked'));
			$message = str_replace( $search, $replace, $message );
		}
		
		/////////////////////////////////////////////////////////
		/* account being unblocked */
		/////////////////////////////////////////////////////////
		if ($template == 'accountunblocked'){
			$subject = userpro_get_option('mail_accountunblocked_s');
			$subject = str_replace( $search, $replace, $subject );
			$message = nl2br(userpro_get_option('mail_accountunblocked'));
			$message = str_replace( $search, $replace, $message );
		}
		
		/////////////////////////////////////////////////////////
		/* new user's account */
		/////////////////////////////////////////////////////////
		if ($template == 'newaccount' && !$userpro->is_pending($user->ID) ) {
			if(userpro_get_option('new_user_notification')=='1')
			{			
				$subject = userpro_get_option('mail_newaccount_s');
				$subject = str_replace( $search, $replace, $subject );
				$message = nl2br(userpro_get_option('mail_newaccount'));
				$message = str_replace( $search, $replace, $message );

			}
		}
		if($template=="passwordchange")
		{
			$subject = userpro_get_option('mail_password_change_s');
			$subject = str_replace( $search, $replace, $subject );
			$message = nl2br(userpro_get_option('mail_password_change'));
			$message = str_replace( $search, $replace, $message );

		}
		
		/////////////////////////////////////////////////////////
		/* email user except: profileupdate */
		/////////////////////////////////////////////////////////
		if ($template != 'profileupdate' && $template != 'pendingapprove') {
			
			$message = html_entity_decode(nl2br($message));
			wp_mail( $user->user_email, $subject, $message, $headers );
		}
		if ($template == 'pendingapprove'){
			if(userpro_get_option('notify_account_pendingfor_adminapproval')=='1')
			{
				$subject = userpro_get_option('pending_for_admin_approval');
				$subject = str_replace( $search, $replace, $subject );
				$message = userpro_get_option('pending_for_admin_approval_txt');
				$message = str_replace( $search, $replace, $message );
				$message = html_entity_decode(nl2br($message));
				wp_mail( $user->user_email , $subject, $message, $headers );
			}

		}		

		/////////////////////////////////////////////////////////
		/* admin emails notifications */
		/////////////////////////////////////////////////////////
		if($template == 'verifyuser')
		{
			$subject = userpro_get_option('mail_admin_verify_request');
			$subject = str_replace( $search, $replace, $subject );
			$message = userpro_get_option('mail_admin_verify_requests');
			$message = str_replace( $search, $replace, $message );
			$message = html_entity_decode(nl2br($message));
			wp_mail( userpro_get_option('mail_from') , $subject, $message, $headers );


		}
		if ($template == 'pendingapprove'){
			$subject = userpro_get_option('mail_admin_pendingapprove_s');
			$subject = str_replace( $search, $replace, $subject );
			$message = userpro_get_option('mail_admin_pendingapprove');
			$message = str_replace( $search, $replace, $message );
			$message = html_entity_decode(nl2br($message));
			wp_mail( userpro_get_option('mail_from') , $subject, $message, $headers );
		}
		
		if ($template == 'newaccount') {
			$subject = userpro_get_option('mail_admin_newaccount_s');
			$subject = str_replace( $search, $replace, $subject );
			$message = userpro_get_option('mail_admin_newaccount');
			$message = str_replace( $search, $replace, $message );
			$message = html_entity_decode(nl2br($message));
			wp_mail( userpro_get_option('mail_from') , $subject, $message, $headers );
		}
		
		if ($template == 'accountdeleted' && userpro_get_option('notify_admin_profile_remove') ) {
			$subject = userpro_get_option('mail_admin_accountdeleted_s');
			$subject = str_replace( $search, $replace, $subject );
			$message = userpro_get_option('mail_admin_accountdeleted');
			$message = str_replace( $search, $replace, $message );
			$message = html_entity_decode(nl2br($message));
			wp_mail( userpro_get_option('mail_from') , $subject, $message, $headers );
		}
		
		if ($template == 'profileupdate') {
			$subject = userpro_get_option('mail_admin_profileupdate_s');
			$subject = str_replace( $search, $replace, $subject );
			$message = userpro_get_option('mail_admin_profileupdate');
			$message = str_replace( $search, $replace, $message );
			$message = html_entity_decode(nl2br($message));
			wp_mail( userpro_get_option('mail_from') , $subject, $message, $headers );
		}
		
	}
