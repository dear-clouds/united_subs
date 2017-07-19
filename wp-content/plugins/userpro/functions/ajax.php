<?php

add_action('wp_ajax_nopriv_userpro_display_user_badges', 'userpro_display_user_badges');
add_action('wp_ajax_userpro_display_user_badges', 'userpro_display_user_badges');
function userpro_display_user_badges()
{    
	
       global $userpro;
	echo userpro_show_badges($_POST['user_id']);
	die();

}

add_action('wp_ajax_nopriv_userpro_post_sort', 'userpro_post_sort');
add_action('wp_ajax_userpro_post_sort', 'userpro_post_sort');
function userpro_post_sort()
{	if(isset($_POST['user_id']))
	{
		$user_info =get_userdata( $_POST['user_id']); 
		$name="";
		if(!empty($user_info)){
			$name = $user_info->user_login;
		}
	}
	if($name!='all')
	echo do_shortcode( "[userpro template=postsbyuser user=$name]" );
	else
	echo do_shortcode( "[userpro template=postsbyuser]");
	die();
}


add_action('wp_ajax_nopriv_userpro_delete_post', 'userpro_delete_post');
add_action('wp_ajax_userpro_delete_post', 'userpro_delete_post');
function userpro_delete_post()
{
	
	$my_post = get_post( $_POST['post_id'] ); // $id - Post ID
        $author_id= $my_post->post_author;
	if(get_current_user_id()==$author_id || is_super_admin(get_current_user_id()))
	wp_delete_post($_POST['post_id']);
	else
	echo "You do not have permission to delete this post";
	die();

}	


/* login / logout cache clear  - for w3 Total Cache Plugin  */

add_action('wp_logout', 'userpro_cache_clear_wt');
add_action('wp_login', 'userpro_cache_clear_wt');
function userpro_cache_clear_wt()
{
    if (function_exists('w3tc_pgcache_flush')) {
        w3tc_pgcache_flush();
    }
}



	add_action('wp_head','userpro_ajax_url');
	function userpro_ajax_url() { ?>
		<script type="text/javascript">
		var userpro_ajax_url = '<?php echo admin_url('admin-ajax.php'); ?>';
		var dateformat ='<?php echo userpro_get_option('date_format');?>';
		</script>
	<?php
	}
	
	add_action('wp_head','userpro_upload_url');
	function userpro_upload_url() { ?>
		<script type="text/javascript">
		var userpro_upload_url = '<?php echo userpro_url . 'lib/fileupload/fileupload.php'; ?>';
		</script>
	<?php
	}
	
	/* Process a form */
	add_action('wp_ajax_nopriv_userpro_process_form', 'userpro_process_form');
	add_action('wp_ajax_userpro_process_form', 'userpro_process_form');
	function userpro_process_form(){
		global $userpro;
		
		/* Security */
		if ( !isset($_POST['_myuserpro_nonce']) ||
			!wp_verify_nonce($_POST['_myuserpro_nonce'], '_myuserpro_nonce_'.$_POST['template'].'_'.$_POST['unique_id'] ) ) {
		   die();
		}
		
		if (!isset($_POST) || $_POST['action'] != 'userpro_process_form')
			die();
			
		if ( !userpro_is_logged_in() && $_POST['template'] == 'edit')
			die();
		
		/* Form */
		$form = array();
		foreach($_POST as $key=>$val) {
			$key = explode('-',$key);
			$key = $key[0];
			$form[$key] = $val;
		} 
		
		$template = $_POST['template'];
		$shortcode = $_POST['shortcode'];
		$user_id = isset($form['user_id'])?$form['user_id']:'';
		/* Runs before a form is processed */
		do_action('userpro_before_form_save', $form);
		
		$output = '';
		/* PROCESSING ACTIONS */
		switch($template) {
					/* publish */
			case 'publish':
				
				$output['error'] = '';
				if (get_current_user_id() != $user_id) {
					die();
				}
				/* no server-side errors */
				if ( empty($output['error']) ) {
					if(isset($form['postid']))
					$array = array('ID' => $form['postid']);
					else
					$array = array('post_author' => $user_id);
					if (isset($form['post_title']) && !empty($form['post_title'])) {
						$array['post_title'] = $form['post_title'];
					}
					
					if (isset($form['userpro_editor']) && !empty($form['userpro_editor'])) {
						$array['post_content'] = @wp_kses($form['userpro_editor']);
					}
					
					if (isset($form['post_type']) && !empty($form['post_type'])){ 
						$array['post_type'] = $form['post_type'];
					}
					if(isset($form['postid']))
					{
					 $my_post = get_post($form['postid']); // $id - Post ID
                                         $author_id= $my_post->post_author;
					}
					/* Insert post */
					if (userpro_is_admin($user_id) || $userpro->user_role_in_array($user_id, $userpro->instant_publish_roles() ) ){
					
						$array['post_status'] = 'publish';	
						

					if(isset($form['postid']) &&  (get_current_user_id()==$author_id || is_super_admin(get_current_user_id())))	
						$post_id = wp_update_post( $array );
						if(empty($form['postid']))
						$post_id = wp_insert_post( $array );
						$output['modal_msg'] = sprintf(__('Your submission has been posted! You can view it %s.','userpro'), '<a href="'.get_permalink($post_id).'">here</a>');
						
					} else {
						
						$array['post_status'] = 'pending';
						if(isset($form['postid']) &&  get_current_user_id()==$author_id)
						$post_id = wp_update_post( $array );
						if(empty($form['postid']))
						$post_id = wp_insert_post( $array );
						$output['modal_msg'] = sprintf(__('Your submission has been sent. It will be reviewed shortly.','userpro'));
						
					}
					
					/* Empty category terms */
					wp_set_object_terms( $post_id, NULL, 'category' );
					
					/* Specific taxonomy and category */
					if (isset($form['taxonomy']) && isset($form['category'])){
						$categories = explode(',',$form['category']);
						if (is_array($categories)){
							foreach($categories as $cat){
								if (is_numeric($cat)){
								$cat = (int)$cat;
								}
								$cats[] = $cat;
							}
							wp_set_object_terms( $post_id, $cats, $form['taxonomy'] );
						} else {
							if (is_numeric($categories)){
								$categories = (int)$categories;
							}
							wp_set_object_terms( $post_id, $categories, $form['taxonomy'] );
						}
					}
					
					/* Insert categories */
					if (isset($form['post_categories'])){
						$i = 0;
						foreach($form['post_categories'] as $cat){
							$i++;
							$split = explode('#',$cat);
							$tax = $split[1];
							$id = $split[0];
							$terms[$tax][] = $id;
						}
						if (is_array($terms)){
						
							foreach($terms as $k => $arr){
		
								wp_set_object_terms( $post_id, $terms[$k], $k, true );
							}
						}
					}
					
					/* Store featured Image */
					if ( isset($form['post_featured_image']) && !empty($form['post_featured_image']) ){
						
						$attach_id = $userpro->new_attachment($post_id, $form['post_featured_image']);
						$userpro->set_thumbnail($post_id, $attach_id);
					}
					
					/* Store post meta */
					foreach($form as $key => $val) {
						if (!in_array($key, array( 'action', 'group', 'post_featured_image', 'post_title', 'post_type', 'shortcode', 'template', 'unique_id', 'up_username', 'userpro_editor', 'user_id' ) ) ) {
							update_post_meta($post_id, $key, $val);
						}
					}

				}
				
				break;
				
			/* delete profile */
			case 'delete':
				$output['error'] = '';
				$user = get_userdata($user_id);
				
				$user_roles = $user->roles;
				$user_role = array_shift($user_roles);
				
				if (!$form['confirmdelete']){
				$output['error']['confirmdelete'] = __('Nothing was deleted. You must choose yes to confirm deletion.','userpro');
				} elseif ( $userpro->user_role_in_array($user_id, array('administrator') ) ){
				$output['error']['confirmdelete'] = __('For security reasons, admin accounts cannot be deleted.','userpro');
				} elseif ($user->user_login == 'test') {
				$output['error']['confirmdelete'] = __('You cannot remove test accounts from frontend!','userpro');
				}
				elseif(get_current_user_id() != $user_id &&  !current_user_can('delete_users')){
					$output['error']['confirmdelete'] = __('You don\'t have sufficient permission to delete this account!','userpro');
				}
				 else {
					 
					require_once(ABSPATH.'wp-admin/includes/user.php' );
					userpro_mail($user_id, 'accountdeleted');
					
					// Delete user
					if ( is_multisite()  ) {
						
						// Multisite: Deletes user's Posts and Links, then deletes from WP Users|Usermeta
						// ONLY IF "Delete From Network" setting checked and user only belongs to this blog	
						wpmu_delete_user( $user_id );
						
					} else {
						
						// Deletes user's Posts and Links
						// Multisite: Removes user from current blog
						// Not Multisite: Deletes user from WP Users|Usermeta	
						wp_delete_user( $user_id );
						
					}
					
					$output['custom_message'] = '<div class="userpro-message userpro-message-ajax"><p>'.__('This account has been deleted successfully.','userpro').'</p></div>';
					$output['redirect_uri'] = home_url();
					
				}
				
				break;
		
			/* change pass */
			case 'change':
				$output['error'] = '';
				
				if (get_current_user_id() != $user_id) {
					die();
				}
				
				if (!$form['secretkey']){
					$output['error']['secretkey'] = __('You did not provide a secret key.','userpro');
				} elseif (strlen($form['secretkey']) != 20) {
					$output['error']['secretkey'] = __('The secret key you entered is invalid.','userpro');
				}
				
				/* Form validation */
				/* Here you can process custom "errors" before proceeding */
				$output['error'] = apply_filters('userpro_form_validation', $output['error'], $form);
				
				if (empty($output['error'])) {
					
					$users = get_users(array(
						'meta_key'     => 'userpro_secret_key',
						'meta_value'   => $form['secretkey'],
						'meta_compare' => '=',
					));
					
					if (!$users[0]) {
						$output['error']['secretkey'] = __('The secret key is invalid or expired.','userpro');
					} else {
						  add_filter( 'send_password_change_email', '__return_false');
						$user_id = $users[0]->ID;
						wp_update_user( array( 'ID' => $user_id, 'user_pass' => $form['user_pass'] ) );
						delete_user_meta($user_id, 'userpro_secret_key');
						
						add_action('userpro_pre_form_message', 'userpro_msg_login_after_passchange');
						$shortcode = stripslashes($shortcode);
						$modded = str_replace('template="change"','template="login"', $shortcode);
						$output['template'] = do_shortcode( $modded );
						if(userpro_get_option('notify_user_password_update')=="1")						
						userpro_mail($user_id, 'passwordchange',$form['user_pass']);
					}
				}
				
				break;
		
			/* send secret key */
			case 'reset':
				$output['error'] = '';
				$username_or_email = $form['username_or_email'];
				if (!$username_or_email){
					$output['error']['username_or_email'] = __('You should provide your email or username.','userpro');
				} else {
				
					if (is_email($username_or_email)) {
						$user = get_user_by('email',$username_or_email);
						$username_or_email = $user->user_login;
					}
				
					if (!username_exists($username_or_email)){
						$output['error']['username_or_email'] = __('There is no such user in our system.','userpro');
					} elseif ( !$userpro->can_reset_pass( $username_or_email ) ) {
						$output['error']['username_or_email'] = __('Resetting admin password is not permitted!','userpro');
					}
					
				}
				
				/* Form validation */
				/* Here you can process custom "errors" before proceeding */
				$output['error'] = apply_filters('userpro_form_validation', $output['error'], $form);
				
				/* email user with secret key and update
					his user meta */
				if (empty($output['error'])) {

					$user = get_user_by('login', $username_or_email);
					$uniquekey =  wp_generate_password(20, $include_standard_special_chars=false);
					
					update_user_meta( $user->ID, 'userpro_secret_key', $uniquekey);
					if( userpro_get_option( 'enable_reset_by_mail' ) == 'y' ){
						userpro_mail($user->ID, 'reset_mail', $uniquekey );
					}
					else{
					 	userpro_mail($user->ID, 'secretkey', $uniquekey);
					}
					
					$shortcode = stripslashes($shortcode);
					if( userpro_get_option('enable_reset_by_mail') == 'n' ){
						add_action('userpro_pre_form_message', 'userpro_msg_secret_key_sent');
						$modded = str_replace('template="reset"','template="change"', $shortcode);
					}
					else{
						add_action('userpro_pre_form_message', 'userpro_reset_link_sent');
						$modded = str_replace('template="reset"','template="reset"', $shortcode);
					}
					$output['template'] = do_shortcode( $modded );
				
				}
				
				break;
			case 'resend':
				$output['error'] = '';
				$userdataval='';
				$username_or_email = $form['username_or_email'];
				if (!$username_or_email){
					$output['error']['username_or_email'] = __('You should provide your email or username.','userpro');
				} else {
				
					if (is_email($username_or_email)) {
						$user = get_user_by('email',$username_or_email);
						$username_or_email = $user->user_login;
					}
					$user = get_user_by('login', $username_or_email);
					if(!empty($user->ID))
					$userdataval=get_user_meta($user->ID,'_account_status',true);
					
					if(!isset($userdataval) && $userdataval!='pending')
					{
						$output['error']['username_or_email'] = __('There is no such user in our system.','userpro');

					}
					if (!username_exists($username_or_email)){
						$output['error']['username_or_email'] = __('There is no such user in our system.','userpro');
					}
					
				}
				$output['error'] = apply_filters('userpro_form_validation', $output['error'], $form);
				if (empty($output['error'])) {
				$user = get_user_by('login', $username_or_email);
				userpro_mail($user->ID, 'verifyemail', null, $form );
				
				add_action('userpro_pre_form_message','userpro_msg_resend_email');
					$shortcode = stripslashes($shortcode);
					$modded = str_replace('template="resend"','template="login"', $shortcode);
					$output['template'] = do_shortcode( $modded );	
				}
				break;
				
			/* login */
			case 'login':
				global $wp_filter;
				$username_or_email = $form['username_or_email'];
				$output['error'] = '';
			
				/* remember me */
				if (!isset($form['rememberme'])) {
					$rememberme = false;
				} else {
					$rememberme = true;
				}

				if (!$username_or_email){
					$output['error']['username_or_email'] = __('You should provide your email or username.','userpro');
				}
				if (!$form['user_pass']){
					$output['error']['user_pass'] = __('You should provide your password.','userpro');
				}
				
				if (email_exists($username_or_email)) {
					$user = get_user_by('email', $username_or_email);
					$username_or_email = $user->user_login;
				}
				
				/* Form validation */
				/* Here you can process custom "errors" before proceeding */
				$output['error'] = apply_filters('userpro_login_validation', $output['error'], $form);
				
				if (empty($output['error']) && $username_or_email && $form['user_pass']) {
				
				$creds = array();
				$creds['user_login'] = $username_or_email;
				$creds['user_password'] = $form['user_pass'];
				$creds['remember'] = $rememberme;
				$wp_login_hook_arr = array();
				$wp_login_hook_arr = $wp_filter['wp_login'];
				remove_all_actions('wp_login');
				$user = wp_signon( $creds, false );
				foreach($wp_login_hook_arr as $key=>$value)
				{
					foreach($value as $wp_login_hook)
					{
						add_action('wp_login',$wp_login_hook['function'],$key,$wp_login_hook['accepted_args']);
					}
				}
				if ( is_wp_error($user) ) {
					if ( $user->get_error_code() == 'invalid_username') {
					$output['error']['username_or_email'] = __('Invalid email or username entered','userpro');
					} elseif ( $user->get_error_code() == 'incorrect_password') {
					$output['error']['user_pass'] = __('The password you entered is incorrect','userpro');
					}
				} else {
					
					/* check the account is active first */
					if ($userpro->is_pending( $user->ID )) {
$uppayment=get_option('userpro_payment');
						if (userpro_get_option('users_approve') === '2') {
							
							if($uppayment['userpro_payment_option']=='y')
							{
								$output['custom_message'] = '<div class="userpro-message userpro-message-ajax"><p>'.__('Your email is pending verification/Payment is Pending. Please activate your account.','userpro').'</p></div>';
							}
							else
							{
								
							$output['custom_message'] = '<div class="userpro-message userpro-message-ajax"><p>'.__('Your email is pending verification. Please activate your account.','userpro').'</p></div>';
							}
						} else {
							
							if($uppayment['userpro_payment_option']=='y')
							{
								$output['custom_message'] = '<div class="userpro-message userpro-message-ajax"><p>'.__('Your account is currently being reviewed/Payment is Pending. Thanks for your patience.','userpro').'</p></div>';
								
						}
							else
							{
							$output['custom_message'] = '<div class="userpro-message userpro-message-ajax"><p>'.__('Your account is currently being reviewed. Thanks for your patience.','userpro').'</p></div>';
						}}
						wp_logout();
							
					} else {
				
					/* a good login */
					userpro_auto_login( $user->user_login, $rememberme );
										
					if (isset($form['force_redirect_uri']) && !empty($form['force_redirect_uri']) && $form['force_redirect_uri']!=0) {
						$output['redirect_uri'] = 'refresh';
						
					} else { 
					
						if (current_user_can('manage_options') && userpro_get_option('show_admin_after_login') ) { 
							$output['redirect_uri'] = admin_url();
						} else { 
						
							if (isset($form['redirect_uri']) && !empty($form['redirect_uri']) ) { 
								$output['redirect_uri'] = wp_validate_redirect($form['redirect_uri']); 
							} else {
								if (userpro_get_option('after_login') == 'no_redirect'){
									$output['redirect_uri'] = 'refresh';
								}
								if (userpro_get_option('after_login') == 'profile'){
									$output['redirect_uri'] = $userpro->permalink();
								}
							}						
						}
			
						/* hook the redirect URI */
						$output['redirect_uri'] = apply_filters('userpro_login_redirect', $output['redirect_uri']);

					}
					
						/* super redirection */
						if (isset($form['global_redirect'])){
							$output['redirect_uri'] = wp_validate_redirect($form['global_redirect']);
						}
					
					} // active/pending
					
				}
				
				}
				
				break;
		
			/* editing */
			case 'edit':
			
				$output['error'] = '';
					
				
				if ($user_id != get_current_user_id() && !current_user_can('manage_options') && !userpro_get_edit_userrole() ){	
						
					die();
		}
					
				/* Form validation */
				/* Here you can process custom "errors" before proceeding */
				$output['error'] = apply_filters('userpro_form_validation', $output['error'], $form);
				
				if ( empty($output['error']) ) {
							
					userpro_update_user_profile( $user_id, $form, $action='ajax_save' );
				
					if (userpro_get_option('notify_admin_profile_save') && !current_user_can('manage_options') ){
						userpro_mail( $user_id , 'profileupdate', null, $form );
					}

					if ($_POST['up_username']){
						set_query_var('up_username',  stripslashes($_POST['up_username']) );
					}

					$shortcode = stripslashes($shortcode);
					$modded = $shortcode;
					$output['template'] = do_shortcode( $modded );
					
				
				
				}
				
				break;
		
			/* registering */
			case 'register':
			
				if(!empty($form['role']) && $form['role'] != ''){
				if(!empty($form['form_role']))
				$form['role'] = $form['form_role'];
				else if(!empty($form['role'])){
				$form['role'] = $form['role'];
				}
				else{
				$form['role'] = userpro_get_option('default_role');
				}
				}
				
				$output['error'] = '';
				$user_invited="";
				/* Form validation */
				/* Here you can process custom "errors" before proceeding */
				$output['error'] = apply_filters('userpro_register_validation', $output['error'], $form);
				if(userpro_get_option('userpro_invite_emails_enable') == 1)				
				$user_invited = register_invited_user_only($form['user_email']);
				if($user_invited == 'not_invited_user') {
					
					$output['error']['user_email'] = 'You are using non invited email';
				}
				if ( empty($output['error']) && ( 
				
					(isset($form['user_login']) && isset($form['user_email']) && isset($form['user_pass']) ) || 
					(isset($form['user_login']) && isset($form['user_email']) ) ||
					(isset($form['user_email']))
				
				) ) {
				
				if (isset($form['user_login']) ) {
					$user_exists = username_exists( $form['user_login'] );
					$user_login = $form['user_login'];
				} else {
					$user_exists = username_exists( 'the_cow_that_did_run_after_the_elephant' );
					$user_login = $form['user_email'];
				}
				
				if ( empty($user_exists) and email_exists($form['user_email']) == false ) {
					
					if (!isset($form['user_pass'])) 
						$user_pass = wp_generate_password( $length=12, $include_standard_special_chars=false );
					else
						$user_pass = $form['user_pass'];
					/* not auto approved? */
				
				$result=get_option('userpro_payment');
				
					if($result['userpro_payment_option']=='y')
					{
						
						if (userpro_get_option('users_approve') === '2') {
						
							$user_id = $userpro->new_user( $user_login, $user_pass, $form['user_email'], $form, $type='standard', $approved=0 );
							complete_invited_user_registration($user_invited);
							$userpro->pending_email_approve( $user_id, $user_pass, $form );
							$userpro->pending_admin_approve( $user_id, $user_pass, $form );
							add_action('userpro_pre_form_message', 'userpro_msg_activate_pending');
							$shortcode = stripslashes($shortcode);
							$modded = str_replace('template="register"','template="login"', $shortcode);
							$output['template'] = do_shortcode( $modded );

							(!empty($output['paypal_form'])) ? $out = $output['paypal_form'] : $out = '';
                             $output['paypal_form']   = apply_filters('paymentredirect',$out,$user_id);
								
						}
						else
						{
						
							$user_id = $userpro->new_user( $user_login, $user_pass, $form['user_email'], $form, $type='standard', $approved=0 );
							complete_invited_user_registration($user_invited);
							$userpro->pending_admin_approve( $user_id, $user_pass, $form );
							
							add_action('userpro_pre_form_message', 'userpro_msg_activate_pending_admin');
							$shortcode = stripslashes($shortcode);
							$modded = str_replace('template="register"','template="login"', $shortcode);
							$output['template'] = do_shortcode( $modded );
							(!empty($output['paypal_form'])) ? $out = $output['paypal_form'] : $out = '';
                             $output['paypal_form']   = apply_filters('paymentredirect',$out,$user_id);
						}
						}	
					else
					{
					if ( userpro_get_option('users_approve') !== '1') {
					
						/* require email validation */
						if (userpro_get_option('users_approve') === '2') {
						
							$user_id = $userpro->new_user( $user_login, $user_pass, $form['user_email'], $form, $type='standard', $approved=0 );
							complete_invited_user_registration($user_invited);
							$userpro->pending_email_approve( $user_id, $user_pass, $form );
							
							add_action('userpro_pre_form_message', 'userpro_msg_activate_pending');
							$shortcode = stripslashes($shortcode);
							$modded = str_replace('template="register"','template="login"', $shortcode);
							$output['template'] = do_shortcode( $modded );
							
						}
						
						/* require admin validation */
						if (userpro_get_option('users_approve') === '3') {
						
							$user_id = $userpro->new_user( $user_login, $user_pass, $form['user_email'], $form, $type='standard', $approved=0 );
							complete_invited_user_registration($user_invited);
							$userpro->pending_admin_approve( $user_id, $user_pass, $form );
							
							add_action('userpro_pre_form_message', 'userpro_msg_activate_pending_admin');
							$shortcode = stripslashes($shortcode);
							$modded = str_replace('template="register"','template="login"', $shortcode);
							$output['template'] = do_shortcode( $modded );
							
						}
					
					} else {
					
						$user_id = $userpro->new_user( $user_login, $user_pass, $form['user_email'], $form, $type='standard' );
						complete_invited_user_registration($user_invited);
						/* auto login */
						if (userpro_get_option('after_register_autologin')) {

							if (isset($user_login)){
								
								userpro_auto_login( $user_login, true );
							
							}
							
							if ($form['redirect_uri']) {
								$output['redirect_uri'] = wp_validate_redirect($form['redirect_uri']);
							} else {
								if (userpro_get_option('after_register') == 'no_redirect'){
									$output['redirect_uri'] = 'refresh';
								}
								if (userpro_get_option('after_register') == 'profile'){
									$output['redirect_uri'] = $userpro->permalink();
								}
							}
							/* hook the redirect URI */
							$output['redirect_uri'] = apply_filters('userpro_register_redirect', $output['redirect_uri']);
						
						/* manual login form */
						} else {
						
							add_action('userpro_pre_form_message', 'userpro_msg_login_after_reg');
							$shortcode = stripslashes($shortcode);
							$modded = str_replace('template="register"','template="login"', $shortcode);
							$output['template'] = do_shortcode( $modded );
						
						}
						//$output['user_id']=$user_id;
					
					}
				
				}
				}
				
   							
                        
				
				}
				break;
				
		}
			
		$output=json_encode($output);
		if(is_array($output)){ print_r($output); }else{ echo $output; } die;
	}
	
	/* Side validate input */
	add_action('wp_ajax_nopriv_userpro_side_validate', 'userpro_side_validate');
	add_action('wp_ajax_userpro_side_validate', 'userpro_side_validate');
	function userpro_side_validate(){
		global $userpro;
		
		if ( $_POST['action'] != 'userpro_side_validate')
			die();
		
		$input_value = $_POST['input_value'];
		
		$ajaxcheck = $_POST['ajaxcheck'];
		$output['error'] = '';
		
		
		switch($ajaxcheck) {
		
			case 'envato_purchase_code':
				if ( !$userpro->verify_purchase($input_value) ) {
						$output['error'] = __('Invalid purchase code or Envato API is down.','userpro');
				} else {
					$output['error'] = '';
				}
				break;
		
			case 'display_name_exists':
				if ($userpro->display_name_exists($input_value)) {
					$output['error'] = __('The display name is already in use.','userpro');
				}
				break;
			
			case 'username_exists':
				if (username_exists($input_value)){
					$output['error'] = __('Username already taken.','userpro');
				} else if ( !preg_match("/^[A-Za-z0-9_-]+$/", $input_value) ) {
					$output['error'] = __('Illegal characters are not allowed in username.','userpro');
				}
				break;
			
			case 'email_exists':
				if (!is_email($input_value)) {
					$output['error'] = __('Please enter a valid email.','userpro');
				} else if (email_exists($input_value)) {
					$output['error'] = __('Email is taken. Is that you? Try to <a href="#" data-template="login">login</a>','userpro');
				}
				break;
			
			case 'validatesecretkey':
				if (strlen($input_value) != 20) {
					$output['error'] = __('The secret key you entered is invalid.','userpro');
				} else {
					$users = get_users(array(
						'meta_key'     => 'userpro_secret_key',
						'meta_value'   => $input_value,
						'meta_compare' => '=',
					));
					if (!$users[0]) {
						$output['error'] = __('The secret key is invalid or expired.','userpro');
					}
				}
				break;
				
		}
		
		$output=json_encode($output);
		if(is_array($output)){ print_r($output); }else{ echo $output; } die;
	}
	
	/* Crop user image upload */
	add_action('wp_ajax_nopriv_userpro_crop_picupload', 'userpro_crop_picupload');
	add_action('wp_ajax_userpro_crop_picupload', 'userpro_crop_picupload');
	function userpro_crop_picupload(){
		if (!isset($_POST['src'])) die();
		require_once(userpro_path.'lib/BFI_Thumb.php');
		$width = $_POST['width'];
		$height =$_POST['height'];
		$src = $_POST['src'];
		$filetype = $_POST['filetype'];
		if ($filetype == 'picture') {
		//commented by yogesh for post feature image.
		/*if ( strstr($src, 'wp-content')) {
			$src = explode('wp-content', $src);
			$src = $src[1];
			
			if ( userpro_get_option('ppfix') == 'b' ) {
			$src = '' . $src;
			} else {
			$src = '/wp-content' . $src;
			}
				
		}*/
			
		$params = array('width'=>$width,'height'=>$height,'quality'=>100);
		$crop = bfi_thumb($src,$params);
		if (!$width) $crop = $src;
		$output['response'] = $crop;
		}
		
		if ($filetype == 'file'){
		$output['response'] = '<div class="userpro-file-input"><a href="'.$src.'" '.userpro_file_type_icon($src).'>'.basename( $src ).'</a></div>';
		}
		
		$output=json_encode($output);
		if(is_array($output)){ print_r($output); }else{ echo $output; } die;
	}
	
	/* save user data form */
	add_action('wp_ajax_nopriv_userpro_save_userdata', 'userpro_save_userdata');
	add_action('wp_ajax_userpro_save_userdata', 'userpro_save_userdata');
	function userpro_save_userdata(){
		global $userpro;
		
		$user_id = $_POST['user_id'];
		$field = $_POST['field'];
		$value = $_POST['value'];
		
		if (!isset($_POST) || $_POST['action'] != 'userpro_save_userdata' || ( $user_id != get_current_user_id() && !current_user_can('manage_options') &&  !userpro_get_edit_userrole() ) )
			die();
			
		$output = '';
		
		$userpro->set($field, $value, $user_id);
		
		if ( $userpro->get($field, $user_id) ) {
			$output['res'] = $userpro->get($field, $user_id);
		} else {
			$output['res'] = __('No custom notice is set for this account.','userpro');
		}
		
		$output=json_encode($output);
		if(is_array($output)){ print_r($output); }else{ echo $output; } die;
	}
	
	/* Get shortcode template */
	add_action('wp_ajax_nopriv_userpro_shortcode_template', 'userpro_shortcode_template');
	add_action('wp_ajax_userpro_shortcode_template', 'userpro_shortcode_template');
	function userpro_shortcode_template(){
		global $wp, $wp_query;
		$shortcode = $_POST['shortcode'];
		ob_start();
		
		if (isset($_POST['up_username'])){
		set_query_var('up_username',  stripslashes($_POST['up_username']) );
		}
		echo do_shortcode( stripslashes( $shortcode ) );
		$output['response'] = ob_get_contents();
		ob_end_clean();
		
		$output=json_encode($output);
		if(is_array($output)){ print_r($output); }else{ echo $output; } die;
	}
	/* Facebook Connect */
	add_action('wp_ajax_nopriv_userpro_fbconnect', 'userpro_fbconnect');
	add_action('wp_ajax_userpro_fbconnect', 'userpro_fbconnect');
	function userpro_fbconnect(){
		
		global $userpro;
		$output = '';
		if (!isset($_POST)) die();
		if ($_POST['action'] != 'userpro_fbconnect') die();
		
		if (!isset($_POST['id'])) die();
		
		if (!isset($_POST['name']) || $_POST['name'] == '' || $_POST['name'] == 'undefined') {
			$username = $_POST['email'];
		}
		else {
			$username = $_POST['name'];
		}
		/* Check if facebook uid exists */
		if (isset($_POST['id']) && $_POST['id'] != '' && $_POST['id'] != 'undefined'){
			$users = get_users(array(
				'meta_key'     => 'userpro_facebook_id',
				'meta_value'   => $_POST['id'],
				'meta_compare' => '='
			));
			if (isset($users[0]->ID) && is_numeric($users[0]->ID) ){
				$returning = $users[0]->ID;
				$returning_user_login = $users[0]->user_login;
			} else {
				$returning = '';
			}
		} else {
			$returning = '';
		}
		$result=get_user_meta($returning,"userpayment");
                $paymentoption=get_option('userpro_payment');

		
		/* Check if user is logged in */
		
		if (userpro_is_logged_in()) {
			
			$userpro->update_fb_id( get_current_user_id(), $_POST['id']);
			
			if ($_POST['redirect'] == '') {
			$output['redirect_uri'] = 'refresh';
			} elseif ($_POST['redirect'] != 'profile') {
			$output['redirect_uri'] = wp_validate_redirect($_POST['redirect']);
			} else {
			$output['redirect_uri'] = $userpro->permalink();
			}
			$output['redirect_uri'] = apply_filters('userpro_login_redirect', $output['redirect_uri']);
		
		} else {
		
		if ( $returning != '' ) {
				
                  if($paymentoption['userpro_payment_option']=='y' )
				{  
				if($result[0]=="recive" || $result[0]=="")
				{
				userpro_auto_login( $returning_user_login, true );
				  $userpro->update_fb_id($returning, $_POST['id']);
				
				if ($_POST['redirect'] == '') {
				$output['redirect_uri'] = 'refresh';
				} elseif ($_POST['redirect'] != 'profile') {
				$output['redirect_uri'] = wp_validate_redirect($_POST['redirect']);
				} else {
				$output['redirect_uri'] = $userpro->permalink();
				}
			$output['redirect_uri'] = apply_filters('userpro_login_redirect', $output['redirect_uri']);
				}
				else
				{
				
				(!empty($output['paypal_form'])) ? $out = $output['paypal_form'] : $out = '';
                             $output['paypal_form']   = apply_filters('paymentredirect',$out,$returning);
}				
}
				else
				{
                                    userpro_auto_login( $returning_user_login, true );
				  if ($_POST['redirect'] == '') {
				$output['redirect_uri'] = 'refresh';
				} elseif ($_POST['redirect'] != 'profile') {
				$output['redirect_uri'] = wp_validate_redirect($_POST['redirect']);
				} else {
				$output['redirect_uri'] = $userpro->permalink();
				}
				$output['redirect_uri'] = apply_filters('userpro_login_redirect', $output['redirect_uri']);
				}
				
				
				
				
			
		/* Email is same, connect them together */
		} else if ( $_POST['email'] != '' && email_exists($_POST['email'])) {
		
				$user_id = email_exists($_POST['email']);
				$user = get_userdata($user_id);
				$result=get_user_meta($user_id,"userpayment");
                              $paymentoption=get_option('userpro_payment');
				
					
                                if($paymentoption['userpro_payment_option']=='y' )
				{  
				if(isset($result[0]) && $result[0]=="recive" || $result[0]=="")
				{
				userpro_auto_login( $user->user_login, true );
				 $userpro->update_fb_id($user_id, $_POST['id']);
				
				if ($_POST['redirect'] == '') {
				$output['redirect_uri'] = 'refresh';
				} elseif ($_POST['redirect'] != 'profile') {
				$output['redirect_uri'] = wp_validate_redirect($_POST['redirect']);
				} else {
				$output['redirect_uri'] = $userpro->permalink();
				}
				$output['redirect_uri'] = apply_filters('userpro_login_redirect', $output['redirect_uri']);	
				}
				else
				{
				
				(!empty($output['paypal_form'])) ? $out = $output['paypal_form'] : $out = '';
                             $output['paypal_form']   = apply_filters('paymentredirect',$out,$user_id);
}				
}					
				
				else
				{
				userpro_auto_login( $user->user_login, true );

				$userpro->update_fb_id($user_id, $_POST['id']);
				
				if ($_POST['redirect'] == '') {
				$output['redirect_uri'] = 'refresh';
				} elseif ($_POST['redirect'] != 'profile') {
				$output['redirect_uri'] = wp_validate_redirect($_POST['redirect']);
				} else {
				$output['redirect_uri'] = $userpro->permalink();
				}
				$output['redirect_uri'] = apply_filters('userpro_login_redirect', $output['redirect_uri']);
				}
				
		
		/* This user already exists! connect them together */
		} else if ($username != '' && username_exists($username)) {
		
				$user_id = username_exists($username);
				$user = get_userdata($user_id);
				
				  if($paymentoption['userpro_payment_option']=='y' )
				{  
				if($result[0]=="recive" || $result[0]=="")
				{
				userpro_auto_login( $user->user_login, true );
				 $userpro->update_fb_id($user_id, $_POST['id']);
				
				if ($_POST['redirect'] == '') {
				$output['redirect_uri'] = 'refresh';
				} elseif ($_POST['redirect'] != 'profile') {
				$output['redirect_uri'] = wp_validate_redirect($_POST['redirect']);
				} else {
				$output['redirect_uri'] = $userpro->permalink();
				}
				$output['redirect_uri'] = apply_filters('userpro_login_redirect', $output['redirect_uri']);	
				 
				}
				else
				{
				
				(!empty($output['paypal_form'])) ? $out = $output['paypal_form'] : $out = '';
                             $output['paypal_form']   = apply_filters('paymentredirect',$out,$user_id);
}				
}					
				else
				{
				userpro_auto_login( $user->user_login, true );
				$userpro->update_fb_id($user_id, $_POST['id']);
				
				if ($_POST['redirect'] == '') {
				$output['redirect_uri'] = 'refresh';
				} elseif ($_POST['redirect'] != 'profile') {
				$output['redirect_uri'] = wp_validate_redirect($_POST['redirect']);
				} else {
				$output['redirect_uri'] = $userpro->permalink();
				}
				$output['redirect_uri'] = apply_filters('userpro_login_redirect', $output['redirect_uri']);
				}
				
		
		/* FBID not found, email/user not found - fresh user */
		} else {

			if($_POST['email']!=='undefined')
				{

				$result=get_option('userpro_payment');
					
					if($result['userpro_payment_option']=='y')
					{
					$user_pass = wp_generate_password( $length=12, $include_standard_special_chars=false );
				    $user_id = $userpro->new_user( $username, $user_pass, $_POST['email'], $_POST, $type='facebook' );
					update_user_meta( $user_id,"userpayment","notrecive");
					$userpro->pending_admin_approve( $user_id, $user_pass, $form="" );
				 (!empty($output['paypal_form'])) ? $out = $output['paypal_form'] : $out = '';
                             $output['paypal_form']   = apply_filters('paymentredirect',$out,$user_id);
					}
					else {
	
				$user_pass = wp_generate_password( $length=12, $include_standard_special_chars=false );
				$user_id = $userpro->new_user( $username, $user_pass, $_POST['email'], $_POST, $type='facebook' );
				userpro_auto_login( $username, true );

				if ($_POST['redirect'] == '') {
				$output['redirect_uri'] = 'refresh';
				} elseif ($_POST['redirect']  != 'profile') {
				$output['redirect_uri'] = wp_validate_redirect($_POST['redirect']);
				} else {
				$output['redirect_uri'] = $userpro->permalink();
				}
				$output['redirect_uri'] = apply_filters('userpro_register_redirect', $output['redirect_uri']);
			}
		}
		}
		}
		
		$output=json_encode($output);
		if(is_array($output)){ print_r($output); }else{ echo $output; } die;
	}
	add_action('wp_ajax_nopriv_userpro_user_invite', 'userpro_user_invite');
	add_action('wp_ajax_userpro_user_invite', 'userpro_user_invite');
	
	
	function userpro_user_invite() {
		$emails = explode(',', $_POST['emails']);
		foreach ($emails as $email)
		{
			if (filter_var($email, FILTER_VALIDATE_EMAIL) === false) {
		
				echo("Not a valid email address");die();
			}
		}
		
				
		$invited = get_option('userpro_invited_users');
		if($invited) {
			$users = explode(',', $_POST['emails']);
			$new_invited = userpro_invite_mail_send($users);
		}else{
			$invited = array();
			$users = explode(',', $_POST['emails']);
			$new_invited = userpro_invite_mail_send($users);
		}
		update_option('userpro_invited_users' , array_merge($invited , $new_invited));
		die();
	}
	
	function userpro_invite_mail_send($users){
		global $userpro;
		$invite_email_template = userpro_get_option('userpro_invite_emails_template');
		$invite_link = home_url().'/'.userpro_get_option('slug').'/'. userpro_get_option('slug_register');
		foreach ($users as $user) {
		   if( email_exists( $user ) == false) {
			$crypted = crypt($user);
			$invited[$crypted] = $user;
			$bloginfo = get_bloginfo();
			$message = "<html><head><title>You Are Invited to ".get_site_url()."</title></head><body>";
			$message .= preg_replace('{invitelink}', $invite_link.'?code='.urlencode($crypted), $invite_email_template);
			$message .= '</body></html>';
			$headers = 'From: '.userpro_get_option('mail_from_name').' <'.userpro_get_option('mail_from').'>' . "\r\n";
			add_filter( 'wp_mail_content_type', 'userpro_invite_mail_set_content_type' );
			$subject=userpro_get_option('invite_subject');
			wp_mail($user,$subject.get_bloginfo('name'),html_entity_decode($message), $headers);
					
		}
			
		}
		return $invited;
	}

	function register_invited_user_only($user_email) {
		$codes = get_option('userpro_invited_users');
		$email_key_codes = array_flip ( $codes);
		if (in_array($user_email , $codes)) {
			$code = $email_key_codes[$user_email];
			unset($codes[$code]);		
			return $codes;
		}else {		
			return 'not_invited_user';
		}
	}
	
	
	function complete_invited_user_registration($codes) {
		update_option('userpro_invited_users' , $codes);
	}

	function userpro_invite_mail_set_content_type( $content_type ) {
		return 'text/html';
	}

        add_action('wp_ajax_nopriv_userpro_performance', 'userpro_userpro_performance');
	add_action('wp_ajax_userpro_performance', 'userpro_userpro_performance');
	
	function userpro_userpro_performance(){
		global $post;
		$ajax_url = parse_url(admin_url('admin-ajax.php'));
		$current_url = parse_url(get_permalink($post->ID));
		$parameters = stripslashes($_POST['params']);
		ob_start();

		echo do_shortcode( "[userpro ".$parameters."]" );
 		$result = ob_get_contents();
 		$result = str_replace($ajax_url['path'], $current_url['path'], $result);
		$output['response'] = $result;
		ob_end_clean();
		
		$output=json_encode($output);
		if(is_array($output)){ print_r($output); }else{ echo $output; } die;
	}

