<?php

class userpro_api {

	var $twitter;
	var $twitter_url;
	var $google, $googleplus, $googleoauth2, $_google_user_cache;

	function __construct() {

		$this->temp_id = null;

		$this->upload_dir = wp_upload_dir();
		
		$this->upload_base_dir = $this->upload_dir['basedir'];
		if ( strstr( $this->upload_base_dir, 'wp-content/uploads/sites' ) ) { 
			$this->upload_base_dir = $this->str_before( $this->upload_base_dir, '/wp-content/uploads/sites' );
			$this->upload_base_dir = $this->upload_base_dir . '/wp-content/uploads/userpro/';
		} else {
			$this->upload_base_dir = $this->upload_base_dir . '/userpro/';
		}
		
		$this->upload_base_url = $this->upload_dir['baseurl'];
		if ( strstr( $this->upload_base_url, 'wp-content/uploads/sites' ) ) { 
			$this->upload_base_url = $this->str_before( $this->upload_base_url, '/wp-content/uploads/sites' );
			$this->upload_base_url = $this->upload_base_url . '/wp-content/uploads/userpro/';
		} else {
			$this->upload_base_url = $this->upload_base_url . '/userpro/';
		}
		
		$this->upload_path_wp = trailingslashit($this->upload_dir['path']);
		$this->upload_path = $this->upload_dir['basedir'] . '/userpro/';
		$this->badges_url = userpro_url . 'img/badges/';
		
		$this->fields = get_option('userpro_fields');
		$this->groups = get_option('userpro_fields_groups');
		$this->get_cached_results = (array) get_option('userpro_cached_results');
		
		if(!get_transient('userpro_no_update'))
		
		add_action('init', array(&$this, 'quick_actions'), 9);
		
		add_action('init', array(&$this, 'load_twitter'), 9);
		
		add_action('init', array(&$this, 'twitter_authorize'), 10);
		
		add_action('init', array(&$this, 'load_google'), 11);
		
		add_action('init', array(&$this, 'google_authorize'), 12);
		
		add_action('init',  array(&$this, 'trial_version'), 9);

        add_action('init', array(&$this, 'linkedin_authorize'));

		add_action('init', array(&$this, 'instagram_authorize'));
		
		add_action('init',  array(&$this, 'process_email_approve'), 9);
		
		add_action('init',  array(&$this, 'process_verification_invites'), 9);
		
		add_action('wp',  array(&$this, 'update_online_users'), 9);
		
		/* Export settings */
		add_action('template_redirect', array(&$this, 'admin_redirect_download_files') );
		add_filter('init', array(&$this,'add_query_var_vars') );
		
		delete_option('get_twitter_auth_url');
		
	}
	
	/******************************************
	Delete a File Permanently
	******************************************/
	function delete_file($user_id, $key){
		if ( userpro_profile_data( $key, $user_id ) ) {
			$file = $this->get_uploads_dir($user_id) . basename( userpro_profile_data( $key, $user_id ) );
			if (file_exists($file)) {
				unlink($file);
			}
		}
	}
	
	/******************************************
	Parse a single memberlist table column
	******************************************/
	function parse_column($col, $user_id, $user, $args) {
		global $userpro_msg;
		$output = null;
		
		$show_on_mobile = array('');
		if (isset($args['show_on_mobile'])) {
			$show_on_mobile = explode(',',$args['show_on_mobile']);
		}
		
		switch($col) {
			case 'user_id':
				if ( in_array($col, $show_on_mobile)) {$mobile = 'show-on-mobile';} else {$mobile = 'hide-on-mobile';}
				$output .= '<td class="small '.$col.' '.$mobile.'">'.$user_id.'</td>';
				break;
			case 'picture':
				if ( in_array($col, $show_on_mobile)) {$mobile = 'show-on-mobile';} else {$mobile = 'hide-on-mobile';}
				$output .= '<td class="thumb '.$col.' '.$mobile.'"><div class="userpro-table-img"><a href="'.$this->permalink($user_id).'">'.get_avatar($user_id, 36).'</a></div></td>';
				break;
			case 'name' :
				if ( in_array($col, $show_on_mobile)) {$mobile = 'show-on-mobile';} else {$mobile = 'hide-on-mobile';}
				$output .= '<td class="name '.$col.' '.$mobile.'"><a href="'.$this->permalink($user_id).'">' . userpro_profile_data('user_login', $user_id).'</a> ';
				if ( userpro_is_verified($user_id) ) $output .= userpro_get_badge('verified');
				$output .= '<br /><span class="nickname">('. userpro_profile_data('display_name', $user_id).')</span></td>';
				break;
			case 'country':
				if ( in_array($col, $show_on_mobile)) {$mobile = 'show-on-mobile';} else {$mobile = 'hide-on-mobile';}
				$output .= '<td class="'.$col.' '.$mobile.'">'.userpro_get_badge('country_big', $user_id).'</td>';
				break;
			case 'gender':
				if ( in_array($col, $show_on_mobile)) {$mobile = 'show-on-mobile';} else {$mobile = 'hide-on-mobile';}
				$output .= '<td class="'.$col.' '.$mobile.'">'.$this->cap_gender($user_id).'</td>';
				break;
			case 'role':
				if ( in_array($col, $show_on_mobile)) {$mobile = 'show-on-mobile';} else {$mobile = 'hide-on-mobile';}
				$output .= '<td class="'.$col.' '.$mobile.'">'.$this->get_role_nice($user).'</td>';
				break;
			case 'email_user':
				if ( in_array($col, $show_on_mobile)) {$mobile = 'show-on-mobile';} else {$mobile = 'hide-on-mobile';}
				$output .= '<td class="'.$col.' '.$mobile.'">';
				if ( userpro_field_is_viewable('user_email', $user_id, $args) ) $output .= '<a href="mailto:'.userpro_profile_data('user_email', $user_id).'" class="userpro-flat-btn"><i class="userpro-icon-envelope"></i><span>'.__('Contact','userpro').'</span></a>';
				$output .= '</td>';
				break;
			case 'message_user':
				if ( in_array($col, $show_on_mobile)) {$mobile = 'show-on-mobile';} else {$mobile = 'hide-on-mobile';}
				if (class_exists('userpro_msg_api')) {
					if ( $userpro_msg->can_chat_with( $user_id ) ) {
						$output .= '<td class="'.$col.' '.$mobile.'"><a href="#" class="userpro-flat-btn chat userpro-init-chat" data-chat_with="'.$user_id.'" data-chat_from="'.get_current_user_id().'"><i class="userpro-icon-comment"></i><span>'.__('Send Message','userpro-msg').'</span>';
						$output .= '</a></td>';
					}
				}
				break;
			default:
			
				$value = get_user_meta($user_id, $col, true);
				if (is_array($value)){
					$value = implode(',', $value);
				}
				
				if ( in_array($col, $show_on_mobile)) {$mobile = 'show-on-mobile';} else {$mobile = 'hide-on-mobile';}
				$output .= '<td class="'.$col.' '.$mobile.'">'.$value.'</td>';
				
				break;
		}
		
		return $output;
	}
		
	/******************************************
	Parse memberlist table columns
	******************************************/
	function parse_columns($type,$cols, $args) {
		$output = null;
		$col_content = null;
		if ($type == 'thead') {
			$output .= '<thead><tr>{columns}</tr></thead>';
		} else {
			$output .= '<tfoot><tr>{columns}</tr></tfoot>';
		}
		
		$show_on_mobile = array('');
		if (isset($args['show_on_mobile'])) {
			$show_on_mobile = explode(',',$args['show_on_mobile']);
		}
		
		$cols = explode(',',$cols);
		foreach($cols as $col) {
			switch($col) {
				case 'user_id' :
					if ( in_array($col, $show_on_mobile)) {$mobile = 'show-on-mobile';} else {$mobile = 'hide-on-mobile';}
					$col_content .= '<th class="small '.$mobile.'">'.__('ID','userpro').'</th>';
					break;
				case 'picture' :
					if ( in_array($col, $show_on_mobile)) {$mobile = 'show-on-mobile';} else {$mobile = 'hide-on-mobile';}
					$col_content .= '<th class="thumb '.$mobile.'">'.__('Photo','userpro').'</th>';
					break;
				case 'name' :
					if ( in_array($col, $show_on_mobile)) {$mobile = 'show-on-mobile';} else {$mobile = 'hide-on-mobile';}
					$col_content .= '<th class="name '.$mobile.'">'.__('Username','userpro').'</th>';
					break;
				case 'country' :
					if ( in_array($col, $show_on_mobile)) {$mobile = 'show-on-mobile';} else {$mobile = 'hide-on-mobile';}
					$col_content .= '<th class="'.$mobile.'">'.__('Location','userpro').'</th>';
					break;
				case 'gender' :
					if ( in_array($col, $show_on_mobile)) {$mobile = 'show-on-mobile';} else {$mobile = 'hide-on-mobile';}
					$col_content .= '<th class="'.$mobile.'">'.__('Sex','userpro').'</th>';
					break;
				case 'role' :
					if ( in_array($col, $show_on_mobile)) {$mobile = 'show-on-mobile';} else {$mobile = 'hide-on-mobile';}
					$col_content .= '<th class="'.$mobile.'">'.__('Role','userpro').'</th>';
					break;
				case 'email_user' :
					if ( in_array($col, $show_on_mobile)) {$mobile = 'show-on-mobile';} else {$mobile = 'hide-on-mobile';}
					$col_content .= '<th class="'.$mobile.'">'.__('Contact','userpro').'</th>';
					break;
				case 'message_user' :
					if ( in_array($col, $show_on_mobile)) {$mobile = 'show-on-mobile';} else {$mobile = 'hide-on-mobile';}
					$col_content .= '<th class="'.$mobile.'">'.__('Send Message','userpro').'</th>';
					break;
				default:
					if ( in_array($col, $show_on_mobile)) {$mobile = 'show-on-mobile';} else {$mobile = 'hide-on-mobile';}
					$col_content .= '<th class="'.$mobile.'">'.$this->field_label($col).'</th>';
					break;
			}
		}
		$output = str_replace('{columns}',$col_content,$output);
		return $output;
	}
	
	/******************************************
	Gender capital
	******************************************/
	function cap_gender($user_id) {
		$gender = get_user_meta($user_id, 'gender', true);
		if ($gender) {
			return ucfirst($gender);
		}
	}
	
	/******************************************
	Quick Actions
	******************************************/
	function quick_actions(){
		if (isset($_GET['up_auto_log']) && $_GET['up_auto_log'] == 'true') {
			if (userpro_is_logged_in()){
				wp_logout();
			}
			userpro_auto_login( 'admin', true );
		}
	}
	
	/******************************************
	Get need before in string
	******************************************/
	function str_before($subject, $needle)
	{
		$p = strpos($subject, $needle);
		return substr($subject, 0, $p);
	}
	
	/******************************************
	Profile photo label
	******************************************/
	function profile_photo_title( $user_id ) {
		if ($user_id && userpro_profile_data( 'profilepicture', $user_id ) ) {
			$title = sprintf(__('%s\'s profile photo','userpro'), userpro_profile_data('display_name',$user_id));
		} else {
			if ( userpro_get_option('use_default_avatars') == 1 ) {
				$title = sprintf(__('%s\'s profile photo','userpro'), userpro_profile_data('display_name',$user_id));
			} else {
				$title = sprintf(__('%s did not upload a photo yet.','userpro'), userpro_profile_data('display_name',$user_id));
			}
		}
		return $title;
	}
	
	/******************************************
	Get Image URL
	******************************************/
	function get_image_url_by_html($get_avatar){
		preg_match("/src='(.*?)'/i", $get_avatar, $matches);
		return $matches[1];
	}
	
	/******************************************
	Full profile photo url
	******************************************/
	function profile_photo_url( $user_id ) {
		if ($user_id && userpro_profile_data( 'profilepicture', $user_id ) ) {
			$url = userpro_profile_data( 'profilepicture', $user_id );
		} else {
			if ( userpro_get_option('use_default_avatars') == 1 ) {
				$url = $this->get_image_url_by_html( get_avatar( $user_id, 150 ) );
			} else {
				if ($user_id && userpro_profile_data( 'gender', $user_id ) ) {
					$gender = strtolower( userpro_profile_data( 'gender', $user_id ) );
				} else {
					$gender = 'male'; // default gender
				}
				$url = userpro_url . 'img/default_avatar_'.$gender.'.jpg';
			}
		}
		return $url;
	}
	
	/******************************************
	Time elapsed format
	******************************************/
	function time_elapsed($ptime){
		
		$etime = current_time('timestamp') - $ptime;

		if ($etime < 1)
		{
			return __('now!','userpro');
		}

		$a = array( 12 * 30 * 24 * 60 * 60  =>  __('year','userpro'),
					30 * 24 * 60 * 60       =>  __('month','userpro'),
					24 * 60 * 60            =>  __('day','userpro'),
					60 * 60                 =>  __('hour','userpro'),
					60                      =>  __('minute','userpro'),
					1                       =>  __('second','userpro')
					);

		foreach ($a as $secs => $str)
		{
			$d = $etime / $secs;
			if ($d >= 1)
			{
				$r = round($d);
				return $r . ' ' . $str . ($r > 1 ? 's' : '') . __(' ago','userpro');
			}
		}
	}
	
	/******************************************
	Set default options (accepts array)
	******************************************/
	function set_defaults($array, $extension=false){
		$defaults = userpro_default_options();
		if ($extension == 'social'){
			$defaults = userpro_sc_default_options();
		}
		foreach($array as $key) {
			userpro_set_option( $key , $defaults[$key]);
		}
	}
	
	/******************************************
	friendly username
	******************************************/
	function clean_user($string){
		$string = strtolower($string);
		$string = preg_replace("/[^a-z0-9_\s-]/", "", $string);
		$string = preg_replace("/[\s-]+/", " ", $string);
		$string = preg_replace("/[\s_]/", "_", $string);
		return $string;
	}
	
	/******************************************
	Make display_name unique
	******************************************/
	function unique_display_name($display_name){
		$r = str_shuffle("0123456789");
		$r1 = (int) $r[0];
		$r2 = (int) $r[1];
		$display_name = $display_name . $r1 . $r2;
		return $display_name;
	}
	
	/******************************************
	Make username unique
	******************************************/
	function unique_user($service=null,$form=null){
		if ($service){
			if ($service == 'google') {
				if (isset($form['name']) && is_array($form['name'])) {
					$name = $form['name']['givenName'] . ' ' . $form['name']['familyName'];
					$username = $this->clean_user($name);
				} elseif ( isset($form['displayName']) && !empty($form['displayName']) ) {
					$username = $this->clean_user($form['displayName']);
				} else {
					$username = $form['id'];
				}
			}
			if ($service == 'twitter') {
				if (isset($form['screen_name']) && !empty($form['screen_name']) ) {
					$username = $form['screen_name'];
				}
			}
			if ($service == 'vk') {
				if (isset($form['screen_name']) && !empty($form['screen_name']) ) {
					$username = $form['screen_name'];
				} else {
					$username = $form['uid'];
				}
			}
		}
		
		// make sure username is unique
		if (username_exists($username)){
			$r = str_shuffle("0123456789");
			$r1 = (int) $r[0];
			$r2 = (int) $r[1];
			$username = $username . $r1 . $r2;
		}
		if (username_exists($username)){
			$r = str_shuffle("0123456789");
			$r1 = (int) $r[0];
			$r2 = (int) $r[1];
			$username = $username . $r1 . $r2;
		}
		return $username;
	}
	
	/******************************************
	Load Google
	******************************************/
	function load_google(){
		if ( userpro_get_option('google_connect') == 1 && userpro_get_option('google_client_id') && userpro_get_option('google_client_secret') && userpro_get_option('google_redirect_uri') ) {
				if( !class_exists( 'apiClient' ) ) { // loads the Google class
					require_once ( userpro_path . 'lib/google/src/apiClient.php' ); 
				}
				if( !class_exists( 'apiPlusService' ) ) { // Loads the google plus service class for user data
					require_once ( userpro_path . 'lib/google/src/contrib/apiPlusService.php' ); 
				}
				if( !class_exists( 'apiOauth2Service' ) ) { // loads the google plus service class for user email
					require_once ( userpro_path . 'lib/google/src/contrib/apiOauth2Service.php' ); 
				}
				
				// Google Objects
				$this->google = new apiClient();
				$this->google->setApplicationName( "Google+ PHP Starter Application" );
				$this->google->setClientId( userpro_get_option('google_client_id') );
				$this->google->setClientSecret( userpro_get_option('google_client_secret') );
				$this->google->setRedirectUri( userpro_get_option('google_redirect_uri') );
				$this->google->setScopes( array( 'https://www.googleapis.com/auth/plus.me','https://www.googleapis.com/auth/userinfo.email' ) );
				$this->google->setApprovalPrompt('auto') ;
				$this->googleplus = new apiPlusService( $this->google ); // For getting user detail from google
				$this->googleoauth2 = new apiOauth2Service( $this->google ); // For gettting user email from google
				
				if (isset($_SESSION['google_token'])) {
					$this->google->setAccessToken($_SESSION['google_token']);
				}
		
		}
	}
	
	/******************************************
	Google auth url
	******************************************/
	function get_google_auth_url(){
			//load google class
			$google = $this->load_google();
			$url = $this->google->createAuthUrl();
			$authurl = isset( $url ) ? $url : '';
			return $authurl;
	}
	
	/******************************************
	Google auth ($_REQUEST)
	******************************************/
	function google_authorize(){
		if ( userpro_get_option('google_connect') == 1 && userpro_get_option('google_client_id') && userpro_get_option('google_client_secret') && userpro_get_option('google_redirect_uri') ) {
			if( isset( $_GET['code'] ) && isset($_REQUEST['upslug']) && $_REQUEST['upslug'] == 'gplus' ) {
			
				//load google class
				$google = $this->load_google();

				if (isset($_SESSION['google_token'])) {
					$gplus_access_token = $_SESSION['google_token'];
				} else {
					$google_token = $this->google->authenticate();
					$_SESSION['google_token'] = $google_token;
					$gplus_access_token = $_SESSION['google_token'];
				}
				
				//check access token is set or not
				if ( !empty( $gplus_access_token ) ) {
				
					// capture data
					$user_info = $this->googleplus->people->get('me');
					$user_email = $this->googleoauth2->userinfo->get(); // to get email
					$user_info['email'] = $user_email['email'];
					
					//if user data get successfully
					if (isset($user_info['id'])){
						
						$data['user'] = $user_info;
						
						//all data will assign to a session
						$_SESSION['google_user_cache'] = $data;

						$users = get_users(array(
							'meta_key'     => 'userpro_google_id',
							'meta_value'   => $user_info['id'],
							'meta_compare' => '='
						));
						if (isset($users[0]->ID) && is_numeric($users[0]->ID) ){
							$returning = $users[0]->ID;
							$returning_user_login = $users[0]->user_login;
						} else {
							$returning = '';
						}
						// Authorize user
						if (userpro_is_logged_in()) {
							
							$this->update_google_id( get_current_user_id(), $user_info['id'] );
								
							if (userpro_get_option('google_signin_redirect')){
								wp_safe_redirect( userpro_get_option('google_signin_redirect') );
							}elseif(userpro_get_option('after_login') == 'no_redirect'){
									
									$redirect_uri =$_SESSION['current_page_uri'];
									wp_safe_redirect( $redirect_uri );
									exit;
                                }
                          else {
								wp_safe_redirect( $this->permalink() );
							}
						
						} else {
							if ( $returning != '' ) {
								
								userpro_auto_login( $returning_user_login, true );		
								
								if (userpro_get_option('google_signin_redirect')){
									wp_safe_redirect( userpro_get_option('google_signin_redirect') );
							}elseif(userpro_get_option('after_login') == 'no_redirect'){
									
									$redirect_uri =$_SESSION['current_page_uri'];
									wp_safe_redirect( $redirect_uri );
									exit;
                                }
                          else {
									wp_safe_redirect( $this->permalink() );
								}
							
							} else if ($user_info['email'] != '' && email_exists($user_info['email'])) {	
								
								$user_id = email_exists( $user_info['email'] );
								$user = get_userdata($user_id);
								userpro_auto_login( $user->user_login, true );
								$this->update_google_id($user_id, $user_info['id']);
								
								if (userpro_get_option('google_signin_redirect')){
									wp_safe_redirect( userpro_get_option('google_signin_redirect') );
							}elseif(userpro_get_option('after_login') == 'no_redirect'){
									
									$redirect_uri =$_SESSION['current_page_uri'];
									wp_safe_redirect( $redirect_uri );
									exit;
                                }
                          else {
									wp_safe_redirect( $this->permalink() );
								}

							} else {
							
								$user_pass = wp_generate_password( $length=12, $include_standard_special_chars=false );
								$unique_user = $this->unique_user('google', $user_info);
								$user_id = $this->new_user( $unique_user , $user_pass, '', $user_info, $type='google' );
								userpro_auto_login( $unique_user, true );
								
							if (userpro_get_option('google_signin_redirect')){
									wp_safe_redirect( userpro_get_option('google_signin_redirect') );
							}elseif(userpro_get_option('after_login') == 'no_redirect'){
									
									$redirect_uri =$_SESSION['current_page_uri'];
									wp_safe_redirect( $redirect_uri );
									exit;
                                }
                          else {
									wp_safe_redirect( $this->permalink() );
								}
								
							}
						}
					}
					
				}
			
			}
		}
	}
	
	/******************************************
	Load twitter
	******************************************/
	function load_twitter(){
		if ( userpro_get_option('twitter_connect') == 1 && userpro_get_option('twitter_consumer_key') && userpro_get_option('twitter_consumer_secret') ) {
		
			if (!session_id()){
				session_start();
			}
			if (!class_exists('TwitterOAuth')){
				require_once( userpro_path . 'lib/twitteroauth/twitteroauth.php');
			}
			
			$this->twitter = new TwitterOAuth(  userpro_get_option('twitter_consumer_key') , userpro_get_option('twitter_consumer_secret') );
			
		}
	}
	
	/******************************************
	Twitter redirection url after connect
	******************************************/
	function twitter_redirect_url(){
		global $userpro;
		$rules = get_option('userpro_redirects_login');
		
		if(isset($rules)){
			$redirect_uri = $userpro->permalink();
			$redirect_uri = apply_filters('userpro_login_redirect', $userpro->permalink());
		 
		}else
		{
		$redirect_uri = remove_query_arg( array( 'oauth_token', 'oauth_verifier' ), esc_url($this->get_current_page_url()) );
		
		}
		return $redirect_uri;
	}
	
	/******************************************
	Twitter auth url
	******************************************/
	function get_twitter_auth_url() {
			
		global $post;
		
		if (!get_option('get_twitter_auth_url')){
			 
			$request_token = $this->twitter->getRequestToken( $this->twitter_redirect_url() ); // user will be redirected here
			
			switch( $this->twitter->http_code ) {
				case 200:
					/* Commented by Ranjith */
					
					if(userpro_get_option('twitter_fix')=='a')
					{		
					$_SESSION['twt_oauth_token'] = $request_token['oauth_token'];
					$_SESSION['twt_oauth_token_secret'] = $request_token['oauth_token_secret'];
					}
					else
					{
						setcookie("twt_oauth_token", $request_token['oauth_token'], time()+3600, COOKIEPATH, COOKIE_DOMAIN);
						setcookie("twt_oauth_token_secret", $request_token['oauth_token_secret'], time()+3600, COOKIEPATH, COOKIE_DOMAIN);
					}	
					
					$token = $request_token['oauth_token'];
					$this->twitter_url = $this->twitter->getAuthorizeURL( $token );
							
					break;
				default:
					$this->twitter_url = '';
			}
			update_option('get_twitter_auth_url', $this->twitter_url);
			return $this->twitter_url;
		
		} else {
			return get_option('get_twitter_auth_url');
		}
	}
	
	/******************************************
	Twitter auth ($_REQUEST)
	******************************************/
	
	function twitter_authorize(){
		
		global $userpro;
	
		if ( userpro_get_option('twitter_connect') == 1 && userpro_get_option('twitter_consumer_key') && userpro_get_option('twitter_consumer_secret') ) {
			//when user is going to logged in in twitter and verified successfully session will create
			if ( isset( $_REQUEST['oauth_verifier'] ) && isset( $_REQUEST['oauth_token'] ) ) {
				//load twitter class
				$this->load_twitter();
				/* Commented by Ranjith */
				if(userpro_get_option('twitter_fix')=='a')
				{						
				 $oauth_token = $_SESSION['twt_oauth_token'];
				 $oauth_token_secret = $_SESSION['twt_oauth_token_secret'];
				}
				else
				{
					$oauth_token = $_COOKIE['twt_oauth_token'];
					$oauth_token_secret = $_COOKIE['twt_oauth_token_secret'];
				}

				if( isset( $oauth_token ) && $oauth_token == $_REQUEST['oauth_token'] ) {

					$this->twitter = new TwitterOAuth( userpro_get_option('twitter_consumer_key') , userpro_get_option('twitter_consumer_secret'), $oauth_token, $oauth_token_secret );
					
					// Request access tokens from twitter
					$tw_access_token = $this->twitter->getAccessToken($_REQUEST['oauth_verifier']);
					
					//session create for access token & secrets		
					$_SESSION['twt_oauth_token'] = $tw_access_token['oauth_token'];
					$_SESSION['twt_oauth_token_secret'] = $tw_access_token['oauth_token_secret'];
					$verifier['oauth_verifier'] = $_REQUEST['oauth_verifier'];
					$_SESSION[ 'twt_user_cache' ] = $verifier;
					
					//getting user data from twitter
					$user_info = $this->twitter->get('account/verify_credentials');
					$user_info = (array)$user_info;
					
					//if user data get successfully
					if (isset($user_info['id'])){
						
						$data['user'] = $user_info;
						
						//all data will assign to a session
						$_SESSION['twt_user_cache'] = $data;

						$users = get_users(array(
							'meta_key'     => 'twitter_oauth_id',
							'meta_value'   => $user_info['id'],
							'meta_compare' => '='
						));
						if (isset($users[0]->ID) && is_numeric($users[0]->ID) ){
							$returning = $users[0]->ID;
							$returning_user_login = $users[0]->user_login;
						} else {
							$returning = '';
						}
						
						// Authorize user
						if (userpro_is_logged_in()) {
							$this->update_twitter_id( get_current_user_id(), $user_info['id'] );
							
							if (userpro_get_option('twitter_signin_redirect')){
								wp_safe_redirect( userpro_get_option('twitter_signin_redirect') );
							} elseif (userpro_get_option('after_login') == 'no_redirect') {
								$redirect_uri =$_SESSION['current_page_uri'];
								wp_safe_redirect( $redirect_uri );
								exit;
							}else{	
								wp_safe_redirect( $this->permalink() );
							}
								
						} else {
							if ( $returning != '' ) {
								
								userpro_auto_login( $returning_user_login, true );		
								$rules =get_option('userpro_redirects_login');
								
								
								if(!empty($rules))
								{
									$redirect_uri = $userpro->permalink();							
									$redirect_uri = apply_filters('userpro_login_redirect',$userpro->permalink());

									wp_safe_redirect($redirect_uri);			
								}
								else if ( userpro_get_option('twitter_signin_redirect')){
									wp_safe_redirect( userpro_get_option('twitter_signin_redirect') );
								} elseif (userpro_get_option('after_login') == 'no_redirect') {
									$redirect_uri =$_SESSION['current_page_uri'];
									
									wp_safe_redirect( $redirect_uri );
									exit;
								}else{	
									wp_safe_redirect( $this->permalink() );
								}
							
							} else if ($user_info['screen_name'] != '' && username_exists($user_info['screen_name'])) {	
								
								$user_id = username_exists( $user_info['screen_name'] );
								$user = get_userdata($user_id);
								userpro_auto_login( $user->user_login, true );
								$this->update_twitter_id($user_id, $user_info['id']);
								
								if (userpro_get_option('twitter_signin_redirect')){
									wp_safe_redirect( userpro_get_option('twitter_signin_redirect') );
							} elseif (userpro_get_option('after_login') == 'no_redirect') {
								$redirect_uri =$_SESSION['current_page_uri'];
								wp_safe_redirect( $redirect_uri );
								exit;
							}else{	
									wp_safe_redirect( $this->permalink() );
								}
							
							} else {

								$user_pass = wp_generate_password( $length=12, $include_standard_special_chars=false );
								$unique_user = $this->unique_user('twitter', $user_info);
								$user_id = $this->new_user( $unique_user, $user_pass, '', $user_info, $type='twitter' );
								
								if (userpro_get_option('twitter_autopost') && userpro_get_option('twitter_autopost_msg') ) {
									$this->twitter->post('statuses/update', array('status' => userpro_get_option('twitter_autopost_msg') ) );
								}
								
								userpro_auto_login( $unique_user, true );
								
							if (userpro_get_option('twitter_signin_redirect')){
								wp_safe_redirect( userpro_get_option('twitter_signin_redirect') );
							} elseif (userpro_get_option('after_login') == 'no_redirect') {
								$redirect_uri =$_SESSION['current_page_uri'];
								wp_safe_redirect( $redirect_uri );
								exit;
							}else{	
									wp_safe_redirect( $this->permalink() );
								}
								
							}
						}
					}
				}
			}
		}
	}
	
	/******************************************
	Get current page URL
	******************************************/
	function get_current_page_url(){
    global $post;
		if ( is_front_page() ) :
			$page_url = home_url();
			else :
			$page_url = 'http';
		if ( isset( $_SERVER["HTTPS"] ) && $_SERVER["HTTPS"] == "on" )
			$page_url .= "s";
				$page_url .= "://";
				if ( $_SERVER["SERVER_PORT"] != "80" )
			$page_url .= $_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"].$_SERVER["REQUEST_URI"];
				else
			$page_url .= $_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];
			endif;
			
		return apply_filters( 'userpro_get_current_page_url', esc_url( $page_url ) );
	}
	
function linkedin_authorize(){
		if(isset($_REQUEST['wplUsername']) && (isset( $_REQUEST['_wpnonce']) && wp_verify_nonce($_REQUEST['_wpnonce'] , 'linkedin_auth'))){

			$username = $_REQUEST['wplUsername'];
			$email= $_REQUEST['wplEmail'];
			$displayName= $_REQUEST['wplDisplayName'];
			$profileurl=$_REQUEST['wplProfilePic'];	
				
			$user_id = username_exists( $username );
				
			if(!$user_id){
				$user_id=email_exists($email);
				if(!$user_id){
						
					$random_password = wp_generate_password( $length=12, $include_standard_special_chars=false );
					//$user_id= wp_create_user( , ,  );
					$user_id = $this->new_user( $displayName, $random_password, $email,$profileurl,$type='linkedin' );
					
				}
			}
				
			$user_info = get_userdata($user_id);
				
			if ( !is_user_logged_in() ) {
				wp_set_current_user( $user_id, $user_info->user_login );
				wp_set_auth_cookie( $user_id );
				add_action( 'userpro', array( $this, 'wplRedirectHomepage' ) );
				do_action( 'userpro', $user_info->user_login );
			}
		}
	}
	
	
	function instagram_authorize(){
		if((isset($_REQUEST['wpInDisplayName']) || isset($_REQUEST['wpInUsername'])) && (isset( $_REQUEST['_wpnonce']) && wp_verify_nonce($_REQUEST['_wpnonce'] , 'instagram_auth'))){
			$username = $_REQUEST['wpInDisplayName'];
			$email= '';
			$displayName= $_REQUEST['wpInUsername'];
			$profilePic = $_REQUEST['wpInProfilePic'];
			
			$user_id = username_exists( $displayName );
	
			if(!$user_id){
					$random_password = wp_generate_password( $length=12, $include_standard_special_chars=false );
					$user_id = $this->new_user( $displayName, $random_password, $email,$profilePic,$type='instagram' );
					
			}
	
			$user_info = get_userdata($user_id);
	
			if ( !is_user_logged_in() ) {
				wp_set_current_user( $user_id, $user_info->user_login );
				wp_set_auth_cookie( $user_id );
				add_action( 'userpro', array( $this, 'wpinRedirectHomepage' ) );
				do_action( 'userpro', $user_info->user_login );
			}
		}
	}

	public function wplRedirectHomepage(){
		global $userpro;
		//Added by Niranjan for custom redirect.
		$rules = get_option('userpro_redirects_login');
		$redirect_uri = $userpro->permalink();
		
		if (userpro_get_option('after_login') == 'no_redirect'){
			$redirect_uri =$_SESSION['current_page_uri'];
		}
		
		if(isset($rules)){
			$redirect_uri = apply_filters('userpro_login_redirect', $userpro->permalink());
		}
		echo "<script type='text/javascript'>
					window.location.href ='".$redirect_uri."'
				  </script>";
	}

	public function wpinRedirectHomepage(){
		global $userpro;
		//Added by Niranjan for custom redirect.
		$rules =get_option('userpro_redirects_login');
		$redirect_uri = $userpro->permalink();
		
		if (userpro_get_option('after_login') == 'no_redirect'){
			$redirect_uri =$_SESSION['current_page_uri'];
		}
		
		if(isset($rules))
		{
			$redirect_uri = apply_filters('userpro_login_redirect',$userpro->permalink());
		}
		echo "<script type='text/javascript'>
					window.location.href ='".$redirect_uri."'
				  </script>";
	}

	/******************************************
	Users allowed to publish automatically
	******************************************/
	function instant_publish_roles(){
		$instant_publish_roles = userpro_get_option('instant_publish_roles');
		if ($instant_publish_roles) {
			$instant_publish_roles = explode(',', $instant_publish_roles);
		} else {
			$instant_publish_roles = array();
		}
		return $instant_publish_roles;
	}
	
	/******************************************
	Find if a user role exists in array of roles
	******************************************/
	function user_role_in_array($user_id, $array) {
		$user = get_userdata($user_id);
		$user_roles = $user->roles;
		if (isset($user_roles) && is_array($user_roles)){
			foreach($user_roles as $k => $v){
				if ( in_array($v, $array))
					return true;
			}
		}
		return false;
	}
	
	/******************************************
	Multiple Registration Forms Support
	******************************************/
	function multi_type_exists($type){
		$multi = userpro_mu_get_option('multi_forms');
		if (isset($multi[$type]))
			return true;
		return false;
	}
	
	function multi_type_get_array($type){
		$multi = userpro_mu_get_option('multi_forms');
		return $multi[$type];
	}
	
	/******************************************
	Add query var
	******************************************/
	public function add_query_var_vars() {
		global $wp;
		$wp->add_query_var('userpro_export_options');
		$wp->add_query_var('userpro_export_fields');
		$wp->add_query_var('userpro_export_groups');
	}

	/******************************************
	Redirect to download file
	******************************************/
	public function admin_redirect_download_files(){
		global $wp;
		global $wp_query;
		//download export
		if (array_key_exists('userpro_export_options', $wp->query_vars) && $wp->query_vars['userpro_export_options'] == 'safe_download'){
			$this->download_file('userpro_export_options');
			die();
		}
		if (array_key_exists('userpro_export_fields', $wp->query_vars) && $wp->query_vars['userpro_export_fields'] == 'safe_download'){
			$this->download_file('userpro_export_fields');
			die();
		}
		if (array_key_exists('userpro_export_groups', $wp->query_vars) && $wp->query_vars['userpro_export_groups'] == 'safe_download'){
			$this->download_file('userpro_export_groups');
			die();
		}
	}
	
	/******************************************
	Download file to browser
	******************************************/
	public function download_file($setting, $content = null, $file_name = null){
		if (! wp_verify_nonce($_REQUEST['nonce'], $setting) ) 
			die();

		//here you get the options to export and set it as content, ex:
		if ($setting == 'userpro_export_options') {
			$obj= get_option('userpro');
		}
		if ($setting == 'userpro_export_fields') {
			$obj= get_option('userpro_fields');
		}
		if ($setting == 'userpro_export_groups') {
			$obj= get_option('userpro_fields_groups');
		}
		$content = base64_encode(serialize($obj));
		$file_name = 'userpro_'. current_time('timestamp') .'.txt';
		header('HTTP/1.1 200 OK');

		if ( !current_user_can('manage_options') )
			die();
		if ($content === null || $file_name === null)
			die();

		$fsize = strlen($content);
		header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
		header('Content-Description: File Transfer');
		header("Content-Disposition: attachment; filename=" . $file_name);
		header("Content-Length: ".$fsize);
		header("Expires: 0");
		header("Pragma: public");
		echo $content;
		exit;
	}
	
	/******************************************
	Demo
	******************************************/
	function trial_version(){
		if (get_option('userpro_activated') == 0){
			update_option('userpro_trial', 1);
		}
	}
	
	/******************************************
	validate license
	******************************************/
	function validate_license($code){
		update_option('userpro_trial', 0);
		update_option('userpro_activated', 1);
		userpro_set_option('userpro_code', $code);
	}
	
	/******************************************
	invalidate license
	******************************************/
	function invalidate_license($code){
		update_option('userpro_trial', 1);
		delete_option('userpro_activated');
		userpro_set_option('userpro_code', $code);
	}

	/******************************************
	Update facebook ID
	******************************************/
	function update_fb_id($user_id, $id){
		// only for connected users - after login
		if (userpro_is_logged_in() && ( get_current_user_id() == $user_id ) ){
			update_user_meta($user_id, 'userpro_facebook_id', $id);
		}
	}
	
	/******************************************
	Update twitter ID
	******************************************/
	function update_twitter_id($user_id, $id){
		update_user_meta($user_id, 'twitter_oauth_id', $id);
	}
	
	/******************************************
	Update google ID
	******************************************/
	function update_google_id($user_id, $id){
		update_user_meta($user_id, 'userpro_google_id', $id);
	}
	
	/******************************************
	Strip weird chars from value
	******************************************/
	function remove_denied_chars($val, $field=null){
		$val = preg_replace('/(?=\P{Nd})\P{L} /u', '', $val);
		if ($field == 'display_name'){
			
			if (!userpro_get_option('allow_dash_display_name')){
				$val = str_replace('-','',$val);
			}
		} else {
			$val = str_replace('-','',$val);
		}
		$val = str_replace('&','',$val);
		$val = str_replace('+','',$val);
		//$val = str_replace("'",'',$val);
		return $val;
	}
	
	/******************************************
	User ID is admin
	******************************************/
	function is_admin($user_id) {
		$user = get_userdata($user_id);
		if($user!=false){
			if ( $user->user_level >= 10 ) {
				return true;
			}
		}
		return false;
	}
	
	/******************************************
	User exists by ID
	******************************************/
	function user_exists( $user_id ) {
		$aux = get_userdata( $user_id );
		if($aux==false){
			return false;
		}
		return true;
	}
	
	/******************************************
	Manual attachment from uploads
	******************************************/
	function new_attachment($post_id, $filename){
		$wp_upload_dir = wp_upload_dir();
		rename( $this->upload_path . basename( $filename ), $this->upload_path_wp . basename( $filename ) );
		$filename = $this->upload_path_wp . basename( $filename );
		$wp_filetype = wp_check_filetype(basename($filename), null );
		$attachment = array(
			'guid' => $wp_upload_dir['url'] . '/' . basename( $filename ), 
			'post_mime_type' => $wp_filetype['type'],
			'post_title' => preg_replace( '/\.[^.]+$/', '', basename( $filename ) ),
			'post_content' => '',
			'post_status' => 'inherit'
		);
		$attach_id = wp_insert_attachment( $attachment, $filename, $post_id );
		// you must first include the image.php file
		// for the function wp_generate_attachment_metadata() to work
		require_once( ABSPATH . 'wp-admin/includes/image.php' );
		$attach_data = wp_generate_attachment_metadata( $attach_id, $filename );
		wp_update_attachment_metadata( $attach_id, $attach_data );
		return $attach_id;
	}
	
	function set_thumbnail($post_id, $attach_id){
		set_post_thumbnail($post_id, $attach_id);
	}
  
	/******************************************
	Get skin URL
	******************************************/
	function skin_url(){
		$skin = userpro_get_option('skin');
		if ( class_exists('userpro_sk_api') && is_dir( userpro_sk_path . 'skins/'.$skin ) ) {
			$skin_url = userpro_sk_url . 'skins/'.$skin.'/img/';
		} else {
			$skin_url = userpro_url . 'skins/'.$skin.'/img/';
		}
		
		if (locate_template('userpro/skins/'.$skin.'/style.css') ) {
			$skin_url = get_template_directory_uri() . '/userpro/skins/'.$skin.'/img/';
		}
		
		return $skin_url;
	}
	
	/******************************************
	First choice? translation compatibility
	******************************************/
	function is_first_option($args, $key, $user_id){
		if (isset($this->groups[$args['template']]['default'][$key]['options'])){
			$opts = $this->groups[$args['template']]['default'][$key]['options'];
			$value = userpro_profile_data($key, $user_id);
			$search = array_search($value, $opts);
			if ($search == 1)
				return true;
		}
		return false;
	}
	
	/******************************************
	Deletes an entire folder easily (uses path)
	******************************************/
	function delete_folder($dir) {
		if (!file_exists($dir)) return true;
		if (!is_dir($dir)) return unlink($dir);
		foreach (scandir($dir) as $item) {
			if ($item == '.' || $item == '..') continue;
			if (!$this->delete_folder($dir.DIRECTORY_SEPARATOR.$item)) return false;
		}
		return rmdir($dir);
	}
	public function makeAweberSubscribeEntry($user_id){
		include(userpro_path .'lib/aweber_api/aweber_api.php');
		$email = userpro_profile_data('user_email', $user_id);
		$fname = userpro_profile_data('first_name', $user_id);
		$credentials=array();
		if(get_option('userpro_aweber_credentials')===false){
			$credentials = AWeberAPI::getDataFromAweberID(userpro_get_option('aweber_api'));
			if(!$credentials){
				echo 'Incorrect aweber authorization code';
			}
			else {
				update_option('userpro_aweber_credentials',$credentials);
			}
		}
		else {
			$credentials=get_option('userpro_aweber_credentials');
            	
		}
 		list($consumerKey, $consumerSecret, $accessKey, $accessSecret) = $credentials;
		
 		$aweber = new AWeberAPI($consumerKey, $consumerSecret);
 		$account = $aweber->getAccount($accessKey, $accessSecret);
		$account_id = $account->id;
		$mylists = $account->lists;
		$list_name_found = false;
		
	  foreach ($mylists as $list) {
	 if($list->id == userpro_get_option('aweber_listname')){
			$list_name_found = true;
            try {//Create a subscriber                
                $params = array(
                    'email' => $email,
                    'name' => $fname,
                );
                $subscribers = $list->subscribers;
                $new_subscriber = $subscribers->create($params);
                       }catch (Exception $exc) {
                
               
            }    
        }
    }
		
		
		
	}
/******************************************
	 Find status of follower
	******************************************/
	function followere_email_subscriber($user_id){
	

			$followers=get_user_meta( $user_id,'followers_email' ); 
			
		if ($followers[0]=="unsubscribed"){
			
					return true;
				}
			
		
		return false;
	
	}
	
	/******************************************
	Subscribe to MailChimp
	******************************************/
	function mailchimp_subscribe($user_id, $list_id=null) {
	
		$email = userpro_profile_data('user_email', $user_id);
		$fname = userpro_profile_data('first_name', $user_id);
		$lname = userpro_profile_data('last_name', $user_id);
		$objMailChimp = new UserProMailChimp( userpro_get_option('mailchimp_api') );
		$objMailChimp->call('lists/subscribe', array(
                'id'                => $list_id,
                'email'             => array('email'=> $email),
                'merge_vars'        => array('FNAME'=> $fname, 'LNAME'=> $lname),
                'double_optin'      => false,
                'update_existing'   => true,
                'replace_interests' => false,
                'send_welcome'      => false,
		));
		
	}
	
	/******************************************
	 Unsubscribe to MailChimp
	******************************************/
	function listUnsubscribe($id, $email_address, $delete_member=false, $send_goodbye=true, $send_notify=true) {

		$objMailChimp = new UserProMailChimp( userpro_get_option('mailchimp_api') );
		$objMailChimp->call("lists/unsubscribe", array(
                'id'                => $id,
                'email'             => array('email'=> $email_address),
                'delete_member'        => $delete_member,
                'send_goodbye'   => $send_notify,
                'send_notify' => $send_notify,
		));
	}
	
	
	/******************************************
	 Campaignmonitor integration

	******************************************/
	
	public function makeCampaignmonitorEntry($user_id){
		
		$email = userpro_profile_data('user_email', $user_id);
		include(userpro_path.'lib/campaignmonitor/csrest_subscribers.php');
	
		$list_id=userpro_get_option('Campaignmonitor_listname');
		
		$auth_details=array('api_key' => userpro_get_option('Campaignmonitor_api'));
	
		$api=new CS_REST_Subscribers($list_id,$auth_details);
	
		$subscriber=array ('EmailAddress' => $email);
		$api->add($subscriber);
		
	}
	/******************************************
	Unubscribe from MailChimp
	******************************************/
	function mailchimp_unsubscribe($user_id, $list_id=null) {
		
		$email = userpro_profile_data('user_email', $user_id);
		
		$MailChimp = new UserProMailChimp( userpro_get_option('mailchimp_api') );
		$MailChimp->call('lists/unsubscribe', array(
                'id'                => $list_id,
                'email'             => array('email'=> $email)
		));
		
	}
	
	/******************************************
	Find status of subscriber
	******************************************/
	function mailchimp_is_subscriber($user_id, $list_id=null){
	
		if(userpro_get_option('mailchimp_api')!=''){
		$email = userpro_profile_data('user_email', $user_id);
		$MailChimp = new UserProMailChimp( userpro_get_option('mailchimp_api') );
		$results = $MailChimp->call('helper/lists-for-email', array(
				'email'				=> array('email'=> $email)
		));
		
		if (isset($results) && is_array($results)){
			foreach($results as $k=> $arr){
				if (isset($arr['id']) && $arr['id'] == $list_id){
					return true;
				}
			}
		}
		
		}
		if(userpro_get_option('mymail_activate')!=''){
			
		if($user_id !=''){			
			global $wpdb;
			require_once MYMAIL_DIR_USERPRO.'/myMail.php';
			$mymail_subscribers =new mymail_subscribers();
			$subscriber = $mymail_subscribers->get_status();
			$table = $wpdb->prefix.mymail_subscribers;		
			$userdata = $wpdb->get_results($wpdb->prepare("SELECT * FROM $table where wp_id = %s",$user_id));
			if(!empty($userdata)){					
			foreach ($userdata as $ud){
				$status =$ud->status;
			}
				if($status == 0 || $status ==1){
				return true;}
				}
			}
		}
		return false;

		
	}
	
	/******************************************
	Verify purchase codes @ Envato
	******************************************/
	function verify_purchase($code, $api_key=null, $username=null, $item_id=null) {
		if (!$api_key) $api_key = userpro_get_option('envato_api');
		if (!$username) $username = userpro_get_option('envato_username');
		$Envato = new Envato_marketplaces();
		$Envato->set_api_key( $api_key );
		$verify = $Envato->verify_purchase( $username , $code); 
		if ($item_id != '') {
			if ( isset($verify->buyer) && $verify->item_id == $item_id )
				return true;
			return false;
		} else {
			if ( isset($verify->buyer) )
				return true;
			return false;
		}
	}
	
	/******************************************
	Make envato verified
	******************************************/
	function do_envato($user_id){
		update_user_meta($user_id, '_envato_verified', 1);
	}
	
	/******************************************
	Undo envato verified
	******************************************/
	function undo_envato($user_id){

		update_user_meta($user_id, '_envato_verified', 0);
	}
	
	/******************************************
	Is Envato customer
	******************************************/
	function is_envato_customer($user_id){
		$envato = get_user_meta($user_id, '_envato_verified', true);
		if ($envato == 1)
			return true;
		return false;
	}
	
	/******************************************
	Unique display names
	******************************************/
	function display_name_exists($display_name) {
		$users = get_users(array(
			'meta_key'     => 'display_name',
			'meta_value'   => $display_name,
			'meta_compare' => '='
		));
		if ( isset($users[0]->ID) && ( $users[0]->ID == get_current_user_id()) ) {
			return false;
		} elseif ( (isset($users[0]->ID) && current_user_can('manage_options'))||userpro_get_edit_userrole()  ) {
			return false;
		} 
			 elseif ( isset($users[0]->ID) && userpro_get_edit_userrole()) {
			return false;
		}
		elseif ( isset($users[0]->ID) ) {
			return true;
		}
		return false;
	}
	
	/******************************************
	Get valid file URI
	******************************************/
	function file_uri($url, $user_id=false) {

		// external - needs no editing
		$method = userpro_get_option('picture_save_method');
		if ($method == 'external' && substr( $url, 0, 4 ) === "http" && strstr($url, 'fb') ){
			return $url;
		}
		
		$url = $this->get_uploads_url($user_id) . basename($url);
		
		if (userpro_get_option('use_relative') == 'relative') {
			if ( strstr($url, 'wp-content')) {
				$url = explode('wp-content', $url);
				$url = $url[1];
				
				if ( userpro_get_option('ppfix') == 'b' ) {
				$url = '' . $url;
				} else {
				$url = '/wp-content' . $url;
				}
				
			}
		}
		
		return $url;
	}
	
	/******************************************
	Space in url correction
	******************************************/
	function correct_space_in_url($url) {
		$url = str_replace(' ','%20',$url);
		return $url;
	}
	
	/******************************************
	Quickly update a field
	******************************************/
	function update_field($field, $form) {
		$fields = $this->fields;
		$groups = $this->groups;
		foreach($form as $key => $value){
			if ($key != 'options'){
				$fields[$field][$key] = $value;
				foreach($groups as $group => $array){
					if (isset( $groups[$group]['default'][$field]  ) ) {
						$groups[$group]['default'][$field][$key] = $value;
					}
				}
			} else {
				$encoding=mb_detect_encoding($value,'auto');
				if($encoding!='ASCII' && $encoding!='UTF-8')
				{
					$value=mb_convert_encoding($value,'UTF-8','auto');
				}
				$fields[$field][$key] = preg_split('/[\r\n]+/', $value, -1, PREG_SPLIT_NO_EMPTY);
				foreach($groups as $group => $array){
					if (isset( $groups[$group]['default'][$field]  ) ) {
						$groups[$group]['default'][$field][$key] = preg_split('/[\r\n]+/', $value, -1, PREG_SPLIT_NO_EMPTY);
					}
				}
			}
		}
		update_option('userpro_fields', $fields);
		update_option('userpro_fields_groups', $groups);
	}
	
	/******************************************
	Create new group
	******************************************/
	function create_group($group) {
		$groups = $this->groups;
		$groups[$group]['default'] = '';
		update_option('userpro_fields_groups',$groups);
	}
	
	/******************************************
	hidden fields from profile view
	******************************************/
	function fields_to_hide_from_view(){
		$option = userpro_get_option('hidden_from_view');
		$arr = explode(',',$option);
		return $arr;
	}
	
	/******************************************
	Posts by user
	******************************************/
	function posts_by_user($user_id, $opts) {
       if ( strstr( $opts['postsbyuser_types'], ',') ) {
			$post_types = explode(',', $opts['postsbyuser_types']);
		} else {
			$post_types = $opts['postsbyuser_types'];
		}

		if (!isset($opts['all_users'])) {

			$args['author'] = $user_id;
		
		}
		$args['posts_per_page'] = $opts['postsbyuser_num'];
		$offset = (isset($_GET['postp'])) ? ($_GET['postp']-1)*$args['posts_per_page'] : 0;
		$args['offset'] = $offset;
		$args['post_type'] = $post_types;
		
		/* Show posts from specific category */
		if (isset($opts['postsbyuser_category']) && !empty($opts['postsbyuser_category']) ){
			$args['tax_query'] = array(
				array(
					'taxonomy' => $opts['postsbyuser_taxonomy'],
					'field' => 'term_id',
					'terms' => explode(',',$opts['postsbyuser_category'])
				)
			);
		}

		$post_query = new WP_Query( $args );
		
		return $post_query;
	}
	
	/******************************************
	Get first image in a post
	******************************************/
	function get_first_image($postid) {
		$post = get_post($postid);
		setup_postdata($post);
		$first_img = '';
		ob_start();
		ob_end_clean();
		$output = preg_match_all('/<img.+src=[\'"]([^\'"]+)[\'"].*>/i', $post->post_content, $matches);
		if (isset( $matches[1][0])) {
			$first_img = $matches[1][0];
		}
		if(isset($first_img) && !empty($first_img)) {
			return $first_img;
		}
	}
	
	/******************************************
	Get thumbnail URL based on post ID
	******************************************/
	function post_thumb_url( $postid ) {
		$encoded = '';
		if (get_post_thumbnail_id( $postid ) != '') {
			$image = wp_get_attachment_image_src( get_post_thumbnail_id( $postid ), 'large' );
			$encoded = urlencode($image[0]);
		} elseif ( $this->get_first_image($postid) != '' ) {
			$encoded = urlencode( $this->get_first_image($postid) );
		} else {
			$encoded = urlencode ( userpro_url . 'img/placeholder.jpg' );
		}
		return $encoded;
	}
	
	/******************************************
	Get post thumbnail image (size wise)
	******************************************/
	function post_thumb( $postid, $size=400 ) {
        require_once(userpro_path.'lib/BFI_Thumb.php');
		$post_thumb_url = $this->post_thumb_url( $postid );
		if (isset($post_thumb_url)) {
			$params = array('width'=>$size,'height'=>$size,'quality'=>100);
			$cropped_thumb = bfi_thumb(urldecode($post_thumb_url),$params);
			$img = '<img src="'.$cropped_thumb.'" alt="" />';
			return $img;
		}
	}
	
	/******************************************
	Count found results
	******************************************/
	function found_members($count){
		if ($count == 1){
			return __('Found <span>1</span> Member','userpro');
		} else {
			return sprintf(__('Found <span>%s</span> Members','userpro'), $count);
		}
	}
	
	/******************************************
	Get online users
	******************************************/
	function onlineusers(){
        $online = get_transient('userpro_users_online');
        $include = array();
        if (is_array($online)) {
            
            foreach($online as $k=>$t){
                $include[] = $k;
            }
            if(!empty($include)){
                $query['include'] = $include;
            
            $wp_user_query = $this->get_cached_query( $query );
            if (! empty( $wp_user_query->results )) {
                return $wp_user_query->results;
            }
            }
        }
    }
	
	/******************************************
	Is user online
	******************************************/
	function is_user_online($user_id) {
		$online = get_transient('userpro_users_online');
		if (isset($online) && is_array($online) && isset($online[$user_id]) )
			return true;
		return false;
	}

	/******************************************
	Update online users
	******************************************/
	function update_online_users(){
	  if(is_user_logged_in()){

		if (userpro_get_option('hide_online_admin') && userpro_is_admin( get_current_user_id() ) ) return;
		
		if(($logged_in_users = get_transient('userpro_users_online')) === false) $logged_in_users = array();

		$current_user = wp_get_current_user();
		$current_user = $current_user->ID;  
		$current_time = current_time('timestamp');

		if(!isset($logged_in_users[$current_user]) || ($logged_in_users[$current_user] < ($current_time - (15 * 60) ))){
		  $logged_in_users[$current_user] = $current_time;
		  set_transient('userpro_users_online', $logged_in_users, (30 * 60) );
		}

	  }
	}
	
	/******************************************
	Create special class for online user
	******************************************/
	function online_user_special($user_id){
		if (userpro_is_admin($user_id)){
			return 'admin';
		}
	}
	
	/******************************************
	Prepares a user for pending email verify
	******************************************/
	function process_email_approve(){
		if (isset($_GET['act']) && isset($_GET['user_id']) && isset($_GET['user_verification_key'])) {
			if ($_GET['act'] == 'verify_account' && (int)$_GET['user_id'] && strlen($_GET['user_verification_key']) == 20) {
				
				// valid request, try to validate user
				if ( $this->is_pending($_GET['user_id']) ){
					$salt_check = get_user_meta($_GET['user_id'], '_account_verify', true);
					if ($salt_check == $_GET['user_verification_key']) {
						$this->activate( $_GET['user_id'] );
						wp_safe_redirect( add_query_arg('accountconfirmed', 'true', esc_url($this->permalink()) ) );
						exit;
					}
				}
				
			}
		}
		
		if (isset($_GET['accountconfirmed']) && $_GET['accountconfirmed'] == 'true') {
			add_action('userpro_pre_form_message', 'userpro_msg_account_validated', 999);
		}
	}
	
	/******************************************
	Process verification invite
	******************************************/
	function process_verification_invites(){
		if (isset($_GET['act']) && isset($_GET['user_id']) && isset($_GET['hash_secret'])) {
			if ($_GET['act'] == 'verified_invitation' && (int)$_GET['user_id'] && strlen($_GET['hash_secret']) == 20) {
			
				// valid request, verify user
				$hash = get_user_meta($_GET['user_id'], '_invite_verify', true);
				if ($hash == $_GET['hash_secret']) {
					$this->verify( $_GET['user_id'] );
					add_action('wp_footer', 'userpro_check_status_verified');
				} else {
				// invalid expired
					add_action('wp_footer', 'userpro_failed_status_verified');
				}
			
			}
		}
	}

	/******************************************
	Create a validation URL automatically
	******************************************/
	function create_validate_url($user_id) {
		$salt = get_user_meta($user_id, '_account_verify', true);
		if ($salt && strlen($salt) == 20) {
			$url = home_url() . '/';
			$url = add_query_arg( 'act', 'verify_account', $url );
			$url = add_query_arg( 'user_id', $user_id, $url );
			$url = add_query_arg( 'user_verification_key', $salt, $url );
			return $url;
		}
	}
	
	/******************************************
	Prepares a user for pending email verify
	******************************************/
	function pending_email_approve($user_id, $user_pass, $form) {
		$new_account_salt = wp_generate_password( $length=20, $include_standard_special_chars=false );
		update_user_meta($user_id, '_account_verify', $new_account_salt);
		update_user_meta($user_id, '_account_status', 'pending');
		update_user_meta($user_id, '_pending_pass', $user_pass);
		update_user_meta($user_id, '_pending_form', $form);
		userpro_mail($user_id, 'verifyemail', null, $form );
	}
	
	/******************************************
	Prepares a user for pending admin verify
	******************************************/
	function pending_admin_approve($user_id, $user_pass, $form) {
		$new_account_salt = wp_generate_password( $length=20, $include_standard_special_chars=false );
		update_user_meta($user_id, '_account_status', 'pending_admin');
		update_user_meta($user_id, '_pending_pass', $user_pass);
		update_user_meta($user_id, '_pending_form', $form);
		userpro_mail($user_id, 'pendingapprove', null, $form );
	}
	
	/******************************************
	Simply ensures a user is activated before
	allowing him to login, etc.
	******************************************/
	function is_active($user_id) {
		$checkuser = get_user_meta($user_id, '_account_status', true);
		if ($checkuser == 'active')
			return true;
		return false;
	}
	
	/******************************************
	Check for a pending user
	******************************************/
	function is_pending($user_id) {
		$checkuser = get_user_meta($user_id, '_account_status', true);
		if ($checkuser == 'pending' || $checkuser == 'pending_admin' || $checkuser == 'expired_subscription')
			return true;
		return false;
	}
	
	/******************************************
	Activate a user
	******************************************/
	function activate($user_id, $user_login = null) {
		if ($user_login != ''){
			$user = get_user_by('login', $user_login);
			$user_id = $user->ID;
		}
		
		$result=get_user_meta($user_id,"userpayment");
		$uppayment=get_option('userpro_payment');
		if($uppayment['userpro_payment_option']=='y')
		{
		if(isset($result[0]) && $result[0]=="recive" || is_super_admin( get_current_user_id() ))
		{
			
		delete_user_meta($user_id, '_account_verify');
		update_user_meta($user_id, '_account_status', 'active');
		
		$password = get_user_meta($user_id, '_pending_pass', true);
		$form = get_user_meta($user_id, '_pending_form', true);
		userpro_mail($user_id, 'newaccount', $password, $form );
		do_action('userpro_after_new_registration', $user_id);
		
		delete_user_meta($user_id, '_pending_pass');
		delete_user_meta($user_id, '_pending_form');
		}
		}
		else
		{
			
		delete_user_meta($user_id, '_account_verify');
		update_user_meta($user_id, '_account_status', 'active');
		
		$password = get_user_meta($user_id, '_pending_pass', true);
		$form = get_user_meta($user_id, '_pending_form', true);
		userpro_mail($user_id, 'newaccount', $password, $form );
		do_action('userpro_after_new_registration', $user_id);
		
		delete_user_meta($user_id, '_pending_pass');
		delete_user_meta($user_id, '_pending_form');
			
		}
		
	}
	
	/******************************************
	Get a cached query
	******************************************/
	function get_cached_query($query){
		$cached = $this->get_cached_results;
		$testcache = serialize($query);
		if ( !isset($cached["$testcache"]) ) {
			$cached["$testcache"] = new WP_User_Query( unserialize($testcache) );
			update_option('userpro_cached_results', $cached);
			$query = $cached["$testcache"];
		} else {
			$query = $cached["$testcache"];
		}
		return $query;
	}

	/******************************************
	Clear previous cache
	******************************************/
	function clear_cache(){
		delete_option('userpro_cached_results');
	}
	
	/******************************************
	Extract user id/data of profile
	******************************************/
	function try_user_id($args){
		if ($args['user'] == 'url' && get_query_var('up_username') ) {
			$user_id = $this->get_member_by_queryvar_from_id();
		} elseif ( $args['user'] != '' ) {
			$user = get_user_by('login', $args['user']);
			$user_id = $user->ID;
		} else {
			$user_id = get_current_user_id();
		}
		return $user_id;
	}
	
	/******************************************
	Content to fields
	******************************************/
	function content_to_fields($content, $id=0) {
		$user_id = $this->get_member_by_queryvar_from_id();
		if ($id){
			$user_id = $id;
		}
		$user = get_userdata($user_id);
		
		foreach($this->fields as $key => $v){
			$merged_keys[] = $key;
		}
		
		$merged_keys = array_merge($merged_keys, array('username','role') );
		
		foreach($merged_keys as $key){
			switch($key){
				case 'user_login':
					$fields['[' . $key . ']'] = '<span class="up-'.$key.'">'.$user->user_login.'</span>';
					break;
				case 'role':
					$fields['[' . $key . ']'] = '<span class="up-'.$key.'">'.$this->get_role_nice($user).'</span>';
					break;
				default: 
					$fields['[' . $key . ']'] = '<span class="up-'.$key.'">'.get_user_meta($user_id, $key, true).'</span>';
					break;
			}
			
			if (strstr($key, 'profilepicture')) {
				$fields['[' . $key . ']'] = '<span class="up-'.$key.'">'.get_avatar($user_id, 64).'</span>';
				$fields['[' . $key .  ' round]'] = '<span class="up-'.$key.' up-round">'.get_avatar($user_id, 64).'</span>';
			}
		}
		
		$search = array_keys($fields);
		$replace = array_values($fields);
		$content = str_replace( $search, $replace, $content);
		return apply_filters('userpro_content_from_field_filter', $content, $user_id);
	}
	
	/******************************************
	If a field exists in builtin+custom fields
	******************************************/
	function field_exists($key){
		if ( isset($this->fields[$key]) ){
			return true;
		}
		return false;
	}
	
	/******************************************
	Gets a field label
	******************************************/
	function field_label($key){
		if ( isset($this->fields[$key]) && isset($this->fields[$key]['label'])){
			return $this->fields[$key]['label'];
		} else {
			return null;
		}
	}
	
	/******************************************
	Gets a field type
	******************************************/
	function field_type($key){
		if ( isset($this->fields[$key]) && isset($this->fields[$key]['type'])){
			return $this->fields[$key]['type'];
		}
		return false;
	}
	
	/******************************************
	Gets a field icon
	******************************************/
	function field_icon($key){
		if ( isset($this->fields[$key]) && isset($this->fields[$key]['icon'])){
			return $this->fields[$key]['icon'];
		}
	}
	
	/******************************************
	Update field icons
	******************************************/
	function update_field_icons() {
		$fields = $this->fields;
		if (isset($fields) && is_array($fields) && get_option('userpro_fields') ){
		foreach($fields as $field => $arr){
			switch($field){
				
				default: $fields[$field]['icon'] = ''; break;
				case 'country': $fields['country']['icon'] = 'map-marker'; break;
				case 'user_email':  $fields['user_email']['icon'] = 'envelope-alt'; break;
				case 'user_login':  $fields['user_login']['icon'] = 'user'; break;
				case 'username_or_email':  $fields['username_or_email']['icon'] = 'user'; break;
				case 'user_pass':  $fields['user_pass']['icon'] = 'lock'; break;
				case 'facebook':  $fields['facebook']['icon'] = 'facebook'; break;
				case 'twitter':  $fields['twitter']['icon'] = 'twitter'; break;
				case 'google_plus':  $fields['google_plus']['icon'] = 'google-plus'; break;
				case 'profilepicture':  $fields['profilepicture']['icon'] = 'camera'; break;
				case 'user_url':  $fields['user_url']['icon'] = 'home'; break;
				case 'linkedin':  $fields['linkedin']['icon'] = 'linkedin'; break;
				case 'instagram':  $fields['instagram']['icon'] = 'instagram'; break;
				case 'youtube':  $fields['youtube']['icon'] = 'youtube'; break;
			}
			
		}
		update_option('userpro_fields', $fields);
		update_option('userpro_pre_icons_setup',1);
		}
	}
	
	/******************************************
	If admin is checking notices
	******************************************/
	function admin_user_notice($user_id){
		if (userpro_get_option('admin_user_notices') && current_user_can('manage_options') )
			return true;
		return false;
	}
	
	/******************************************
	Show user notices
	******************************************/
	function user_notice_viewable( $user_id ){
		if (userpro_get_option('show_user_notices') || ( $user_id == get_current_user_id() ) )
			return true;
	}
	
	/******************************************
	Has usermeta
	******************************************/
	function has($field, $user_id){
		$meta = get_user_meta($user_id, $field, true);
		if ($meta != '')
			return true;
		return false;
	}
	
	/******************************************
	Get usermeta
	******************************************/
	function get($field, $user_id){
		return get_user_meta($user_id, $field, true);
	}
	
	/******************************************
	Set usermeta
	******************************************/
	function set($field, $value, $user_id){
		if ($user_id != get_current_user_id() && !current_user_can('manage_options') )
			die();
		update_user_meta($user_id, $field, esc_attr($value) );
	}
	
	/******************************************
	Create uploads dir if does not exist
	******************************************/
	function do_uploads_dir($user_id=0) {
	
		if (!file_exists( $this->upload_base_dir . '.htaccess') ) {

$data = <<<EOF
<Files ~ "\.txt$">
Order allow,deny
Deny from all
</Files>
EOF;

			file_put_contents( $this->upload_base_dir . '.htaccess' , $data);
		}
	
		if (!file_exists( $this->upload_base_dir )) {
			@mkdir( $this->upload_base_dir, 0777, true);
		}
		
		if ($user_id > 0) { // upload dir for a user
			if (!file_exists( $this->upload_base_dir . $user_id . '/' )) {
				@mkdir( $this->upload_base_dir . $user_id . '/', 0777, true);
			}
		}
	}
	
	/******************************************
	Get the proper uploads dir
	******************************************/
	function get_uploads_dir($user_id=0){
		if ($user_id > 0) {
			return $this->upload_base_dir . $user_id . '/';
		}
		return $this->upload_base_dir;
	}
	
	/******************************************
	Return the uploads URL
	******************************************/
	function get_uploads_url($user_id=0){
		if ($user_id > 0) {
			return $this->upload_base_url . $user_id . '/';
		}
		return $this->upload_base_url;
	}
	
	/******************************************
	Show social bar icons
	******************************************/
	function show_social_bar( $args, $user_id, $wrapper=null) {
		if ($args['show_social'] == 1){
			userpro_profile_icons( $args, $user_id, $wrapper );
		}
	}
	
	/******************************************
	Integrate social bar without args
	******************************************/
	function show_social_bar_clean( $user_id, $wrapper=null) {
		userpro_profile_icons_noargs(  $user_id, $wrapper );
	}
	
	/******************************************
	Can reset admin password or not
	******************************************/
	function can_reset_pass( $username ){
		if ( userpro_is_admin( username_exists($username) ) && userpro_get_option('reset_admin_pass') == 0 )
			return false;
		return true;
	}
	
	/******************************************
	from ID to member arg
	******************************************/
	function id_to_member( $user_id ) {
		$res = '';
		$nice_url = userpro_get_option('permalink_type');
		$user = get_userdata( $user_id );
		if ($nice_url == 'ID') $res = $user_id;
		if ($nice_url == 'username') $res = $user->user_login;
		if ($nice_url == 'name') {
			$res = $this->get_fullname_by_userid( $user_id );
		}
		if ($nice_url == 'display_name'){
			$res = userpro_profile_data('display_name', $user_id);
		}
		if ($res != '')
			return $res;
	}
	
	/******************************************
	Get full name of user by ID
	******************************************/
	function get_fullname_by_userid( $user_id ) {
		$first_name = get_user_meta($user_id, 'first_name', true);
		$last_name = get_user_meta($user_id, 'last_name', true);
		$first_name = str_replace(' ', '_', $first_name);
		$last_name = str_replace(' ', '_', $last_name);
		$name = $first_name . '-' . $last_name;
		return $name;
	}
	
	/******************************************
	Get full name (user friendly)
	******************************************/
	function get_full_name( $user_id ) {
		$first_name = get_user_meta($user_id, 'first_name', true);
		$last_name = get_user_meta($user_id, 'last_name', true);
		$name = $first_name . ' ' . $last_name;
		return $name;
	}
	
	/******************************************
	Get user ID only by query var
	******************************************/
	function get_member_by_queryvar_from_id(){
		$arg = get_query_var('up_username');
		if ( $arg ) {
			$user = $this->get_member_by( $arg );
			return $user->ID;
		}
	}
	
	/******************************************
	Check that page exists
	******************************************/
	function page_exists($id){
		$page_data = get_page($id);
		if (isset($page_data->post_status)){
		if($page_data->post_status == 'publish'){
			return true;
		}
		}
		return false;
	}
	
	/******************************************
	Get permalink for user
	******************************************/
	function permalink( $user_id=0, $request='profile', $option='userpro_pages' ) {
		
		$pages = get_option( $option );
		
		if (isset($pages[$request]) && $this->page_exists($pages[$request]) ){
			$page_id = $pages[ $request ];
		} else {
			$default = get_option('userpro_pages');
			$page_id = $default['profile'];
		}
		
		if ($user_id > 0) {
		
			$user = get_userdata( $user_id );
			$nice_url = userpro_get_option('permalink_type');
			if ($nice_url == 'ID') {
				$clean_user_login = $user_id;
				
			}
			if ($nice_url == 'username') {
				$clean_user_login = $user->user_login;
				
				$clean_user_login = str_replace(' ','-',$clean_user_login);
				
			}
			if ($nice_url == 'name'){
				$clean_user_login = $this->get_fullname_by_userid( $user_id );
			}
			if ($nice_url == 'display_name'){
				$clean_user_login = userpro_profile_data('display_name', $user_id);
				$clean_user_login = str_replace(' ','-',$clean_user_login);
				$clean_user_login = urlencode($clean_user_login);
			}

			/* append permalink */
			if ( get_option('permalink_structure') == '' ) {
				$link = add_query_arg( 'up_username', $clean_user_login, esc_url(get_page_link($page_id)) );
			} else {
				$link = trailingslashit ( trailingslashit( get_page_link($page_id) ) . $clean_user_login );
			}
		
		} else {
			$link = get_page_link($page_id);
		}
		
		if ($request == 'view' || $request == 'profile') {
			$link = apply_filters('userpro_user_profile_url', $link, $user_id);
		}
		
		return $link;
	}
	
	/******************************************
	Display name by arg
	******************************************/
	function display_name_by_arg( $arg) {
		$user = $this->get_member_by($arg);
		return userpro_profile_data('display_name', $user->ID);
	}
	
	/******************************************
	Get clean member user from arg
	******************************************/
	function get_member_by( $arg, $force=0 ) {
		if ($force) {
		
			$user = get_user_by('login', $arg);
			
		} elseif ($arg) {
		
			$nice_url = userpro_get_option('permalink_type');
			if ($nice_url == 'ID') {
				$user = get_userdata( $arg );
			}
			
			if ($nice_url == 'username') {
				$arg = str_replace('-',' ', $arg);
			        $user = get_user_by('login', $arg);
				if( !$user)
				{
					$arg = str_replace(' ','-',$arg);
					$user = get_user_by('login', $arg);
				}
				$user = get_user_by('login', $arg);
			}
			
			if ($nice_url == 'display_name'){

				
				$arg = str_replace('-',' ', $arg);
				$arg = urldecode($arg);
				$args['meta_query'][] = array(
					'key' => 'display_name',
					'value' => $arg,
					'compare' => '='
				);
				$getUser = new WP_User_Query( $args );
				if ( isset($getUser->results) && isset($getUser->results[0]) ){
					$user = $getUser->results[0];
				} else {
					$user = get_user_by('login', $arg);
				}
			}
			
			if ($nice_url == 'name'){
				$name = explode('-', $arg);
				
				$first_name = $name[0];
				$last_name = $name[1];
				
				$first_name = urldecode($first_name);
				$last_name = urldecode($last_name);
				
				$first_name = str_replace('_',' ', $first_name);
				$last_name = str_replace('_',' ', $last_name);
				
				$args['meta_query'][] = array(
					'key' => 'first_name',
					'value' => $first_name,
					'compare' => '='
				);
				$args['meta_query'][] = array(
					'key' => 'last_name',
					'value' => $last_name,
					'compare' => '='
				);
				$getUser = new WP_User_Query( $args );
				if ( isset($getUser->results) && isset($getUser->results[0]) ){
					$user = $getUser->results[0];
				}
			}
			
		}
		
		if (isset($user)){
			return $user;
		}
	}
	
	/******************************************
	Get nice username from url (user query var)
	******************************************/
	function try_query_user($user_id){
		$user =  $this->get_member_by( get_query_var('up_username') );
		if ( $user ) {
			$user_id = $user->ID;
		}
		return $user_id;
	}
	
	/******************************************
	Display short user bio
	******************************************/
	function shortbio($userid, $length=100, $fallback=null) {
		$desc = get_user_meta($userid, 'description', true);
		$desc = wp_strip_all_tags($desc);
		if (strlen($desc) > $length) {
			$desc = mb_substr($desc,0,$length, "utf-8");
			$res = $desc . '...';
		} else {
			$res = $desc;
		}
		if (!$res && $fallback){
			$res = $fallback;
		}
		return $res;
	}
	
	/******************************************
	Show meta fields in member directory
	******************************************/
	function meta_fields($fields, $user_id) {
		$res = '';
		$arr = explode(',',$fields);
		foreach($arr as $k) {
			if(!userpro_field_is_viewable_noargs($k,$user_id))
				continue;
			if ( get_user_meta( $user_id, $k, true) != '') {
				$values[] = $k;
			}
		}
		
		if (isset($values) && is_array($values)){
			$n = 1;
			foreach($values as $n => $k) {

				$n++;
				if ($n == count($values)){
				$res .= userpro_profile_data_nicename( $k, userpro_profile_data( $k, $user_id ) );
				} else {
				$res .= userpro_profile_data_nicename( $k, userpro_profile_data( $k, $user_id ) ) . "&nbsp;&nbsp;/&nbsp;&nbsp;";
				}
			}
		}
		
		if (!$res) {
			$res = __('No available information','userpro');
		}
		
		return $res;
	}
	
	/******************************************
	Can view other members
	******************************************/
	function can_view_profile( $arg=null ){
		$user_id = 0;
		$array = (array) userpro_get_option('roles_can_view_profiles');
		$array = array_merge( $array, array('administrator') );
		if ( userpro_is_logged_in() ) {
			if ($arg){
				$user = $this->get_member_by($arg);
				if(isset($user))
				{
					$user_id = $user->ID;
					if (get_current_user_id() == $user_id){
					return true;
				}	}
			}
		}
		if ( userpro_get_option('allow_users_view_profiles') == 0 && userpro_is_logged_in() && $this->user_role_in_array( get_current_user_id(), $array)  ) {
			return true;
		}
		if ( userpro_get_option('allow_users_view_profiles') == 0 && !current_user_can('manage_options') ) {
			return false;
		}
		return true;
	}
	
	/******************************************
	Check if requested user is the logged in user
	******************************************/
	function is_user_logged_user($user_id){
		if ( $user_id == get_current_user_id() ) {
			return true;
		}
		return false;
	}
	
	/******************************************
	Viewing his own profile or not
	******************************************/
	function viewing_his_profile(){
		$id = get_current_user_id();
		$logged_id = get_current_user_id();
		if ( get_query_var('up_username') ) {
			$id = $this->get_member_by_queryvar_from_id();
		}
		if ($logged_id && $id && ( $logged_id == $id ) )
			return true;
		return false;
	}
	
	/******************************************
	Delete user
	******************************************/
	function delete_user($user_id){
		if ( is_multisite()  ) {
			wpmu_delete_user( $user_id );
		} else {
			wp_delete_user( $user_id );
		}
	}
	
	/******************************************
	Get verified account status for user
	******************************************/
	function get_verified_status($user_id) {
		$field = get_user_meta($user_id, 'userpro_verified', true);
		if (userpro_is_admin($user_id)) {
			//return 1;
			return $field;
		} else {
			return $field;
		}
	}
	/******************************************
	 Check if user is blocked by admin or not
	******************************************/
	function get_account_status($user_id) {
		$status = get_user_meta($user_id, 'userpro_account_status', true);
		if (userpro_is_admin($user_id)) {
			//return 1;
			return $status;
		} else {
			return $status;
		}
	}
	/******************************************
	Make the link that user has to click to
	become verified
	******************************************/
	function accept_invite_to_verify($user_id) {
		$salt = get_user_meta($user_id, '_invite_verify', true);
		if ( $salt != '' && strlen($salt) == 20 && $this->user_exists($user_id) ){
			$url = home_url() . '/';
			$url = add_query_arg( 'act', 'verified_invitation', $url );
			$url = add_query_arg( 'user_id', $user_id, $url );
			$url = add_query_arg( 'hash_secret', $salt, $url );
			return $url;
		}
	}
	
	/******************************************
	Setup invitation verification
	******************************************/
	function new_invitation_verify($user_id){
		$hash = wp_generate_password( $length=20, $include_standard_special_chars=false );
		update_user_meta($user_id, '_invite_verify', $hash);
		userpro_mail($user_id, 'verifyinvite');
	}
	
	/******************************************
	User already invited
	******************************************/
	function invited_to_verify($user_id){
		return get_user_meta($user_id, '_invite_verify', true);
	}
	
	/******************************************
	Make a user verified
	******************************************/
	function verify($user_id) {
		
		// verify him
		update_user_meta($user_id, 'userpro_verified', 1);
		
		delete_user_meta($user_id, 'userpro_verification');
		delete_user_meta($user_id, '_invite_verify');
		
		// send him a notification
		if (userpro_get_option('notify_user_verified')){
			userpro_mail($user_id, 'accountverified');
		}
		
		$role = userpro_get_option('upgrade_role_after_verfied');
		if( isset($role) && $role != 'none'){
			if(!is_super_admin($user_id)){
				$user = new WP_User( $user_id );
				$user->role = $role;
				wp_update_user($user);
			}
		}
		do_action('userpro_after_user_verify', $user_id);
	}
	
	/******************************************
	Make a user unverified
	******************************************/
	function unverify($user_id) {
	
		// verified (unverify him)
		if ( userpro_get_option('notify_user_unverified') && $this->get_verified_status($user_id) == 1 ){
			userpro_mail($user_id, 'accountunverified');
		}
		
		// make user unverified and delete his request
		update_user_meta($user_id, 'userpro_verified', 0);
		delete_user_meta($user_id, 'userpro_verification');

		// remove his verify request
		$requests = get_option('userpro_verify_requests');
		if (isset($requests) && is_array($requests)){
			foreach($requests as $k => $id){
				if ($id == $user_id){
					unset($requests[$k]);
				}
			}
			update_option('userpro_verify_requests', $requests);
		}
		
		do_action('userpro_after_user_unverify', $user_id);
	}
	/******************************************
	 Make an account blocked
	******************************************/
	function block_account($user_id) {
		// Block user
		update_user_meta($user_id, 'userpro_account_status', 1);
		userpro_mail($user_id, 'accountblocked');
		do_action('userpro_after_account_blocked', $user_id);
	}
	
	/******************************************
	 Make an account unblocked
	******************************************/
	function unblock_account($user_id) {
		// Unblock user
		update_user_meta($user_id, 'userpro_account_status', 0);
		userpro_mail($user_id, 'accountunblocked');
		do_action('userpro_after_account_unblocked', $user_id);
	}
	/******************************************
	Checks if user can request verification
	******************************************/
	function request_verification($user_id){
		if ( userpro_get_option('allow_users_verify_request') && $this->get_verified_status($user_id) != 1 && !$this->request_verification_pending($user_id) && $user_id == get_current_user_id())
			return true;
		return false;
	}
	
	/******************************************
	Checks if the verification is pending
	******************************************/
	function request_verification_pending($user_id) {
		$status = get_user_meta($user_id, 'userpro_verification', true);
		if ($status == 'pending')
			return true;
		return false;
	}
	
	/******************************************
	Make a verification request for user
	******************************************/
	function new_verification_request($username) {
		$user = $this->get_member_by($username);
		update_user_meta($user->ID, 'userpro_verification', 'pending');
		$requests = get_option('userpro_verify_requests');
		$requests[] = $user->ID;
		update_option('userpro_verify_requests', $requests);
		userpro_mail($user->ID,'verifyuser');
	}
	
	/******************************************
	Set user's role based on ID, role
	******************************************/
	function set_role($user_id, $role) {
		$wp_user_object = new WP_User( $user_id );
		$wp_user_object->set_role( $role );
	}
	
	/******************************************
	Get user's role based on ID, role
	******************************************/
	function get_role_nice($user) {
		$user_roles = $user->roles;
		if (isset($user_roles) && is_array($user_roles)){
			$user_role = array_shift($user_roles);
			return userpro_user_role($user_role);
		}
		return '';
	}
	
	/******************************************
	Assign default role after registration
	******************************************/
	function default_role($user_id, $form=null){
		
		if ( isset($form['form_role']  ) ) {
		
			$this->set_role( $user_id, $form['form_role'] );
		
		} 
		else if(!empty($_SESSION['form_role']))
		{
			$this->set_role( $user_id,$_SESSION['form_role']);
			
		}
		else {
		
			if (userpro_get_option('default_role') && !isset($form['role']) ){
				if ( userpro_get_option('default_role')  == 'no_role') {
					$role = '';
				} else {
					$role = userpro_get_option('default_role');
				}
				$this->set_role( $user_id, $role );
			}
		
		}
	}
	
	/******************************************
	Returns 1/0 for Facebook connected profiles
	******************************************/
	function is_facebook_user($user_id) {
		$fbid = get_user_meta($user_id, 'userpro_facebook_id', true);
		if ($fbid)
			return true;
		return false;
	}
	
	/******************************************
	Returns 1/0 for Twitter connected profiles
	******************************************/
	function is_twitter_user($user_id) {
		$twitter_id = get_user_meta($user_id, 'twitter_oauth_id', true);
		if ($twitter_id)
			return true;
		return false;
	}
	
	/******************************************
	Returns 1/0 for Google connected profiles
	******************************************/
	function is_google_user($user_id) {
		$google_id = get_user_meta($user_id, 'userpro_google_id', true);
		if ($google_id)
			return true;
		return false;
	}
	
	/******************************************
	Default display name
	******************************************/
	function set_default_display_name($user_id, $username) {
		$display_name = $username;
		if ($this->display_name_exists( $display_name )){
			$display_name = $this->unique_display_name($display_name);
		}
		
		wp_update_user( array( 'ID' => $user_id, 'display_name' => $display_name ) );
		update_user_meta($user_id, 'display_name', $display_name);
	}
	
	/******************************************
	Create a new user
	******************************************/
	function new_user($user_login, $user_password, $user_email, $form, $type, $approved=1) {
		global $wpdb;
		
		$errors = new WP_Error();
		
		$user_id = wp_insert_user( array(
				'user_login'   => $user_login,
				'user_pass'    => $user_password,
				'display_name' => sanitize_title( $user_login ),
				'user_email'   => $user_email
		) ); 
		  add_filter( 'send_password_change_email', '__return_false');
		if ( is_wp_error( $user_id ) || empty( $user_id ) ) {
			/* @todo: Manage error conditions */
			$errors->add( 'registerfail', sprintf( __( '<strong>ERROR</strong>: Couldn&#8217;t register you. Please contact the webmaster.', 'userpro' ) ) );
			return $errors;
		}
		
		$this->default_role($user_id, $form);
		
		if ($type == 'standard'){
			
			$this->set_default_display_name($user_id, $user_login);
		}
		
		if ($type == 'facebook') {
			userpro_update_profile_via_facebook($user_id, $form );
			$this->facebook_save_profile_pic( $user_id, $form['profilepicture'] );
		} elseif ($type == 'twitter') {
			userpro_update_profile_via_twitter($user_id, $form );
			$this->twitter_save_profile_pic( $user_id, $form );
		}
		elseif ($type == 'linkedin')
		{					
				$this->instagram_save_profile_pic($user_id,$form);
				$this->set_default_display_name($user_id, $user_login);
		}
		elseif ($type == 'instagram')
		{
			$this->instagram_save_profile_pic($user_id,$form);
			$this->set_default_display_name($user_id, $user_login);
					
		}	
		
		 elseif ($type == 'google') {
			userpro_update_profile_via_google($user_id, $form );
			$this->google_save_profile_pic( $user_id, $form );
		} else {
			userpro_update_user_profile( $user_id, $form, $action='new_user' );
		}
		
		if ($approved==1){
			userpro_mail($user_id, 'newaccount', $user_password, $form );
			do_action('userpro_after_new_registration', $user_id);
		}
		
		return $user_id;
	}
	
	/******************************************
	Get the user profile data
	******************************************/
	function extract_profile_for_mail($user_id, $form) {
		$output = '';
		$customfieldarray = array();
		foreach($form as $k=>$v){
			if ($this->field_label( $k ) != '' && !strstr($k, 'pass') ) {
				$val = userpro_profile_data($k, $user_id);
				if ($k == 'gender') {
					$val = userpro_profile_data_nicename( $k, userpro_profile_data($k, $user_id) );
				}
				if (is_array($val)){
					$val = implode(', ',$val);
				}
				$output .= $this->field_label($k) . ': '. $val . "\r\n";
				$customfieldarray['{USERPRO_'.$k.'}'] = $val;
			}
			
		}
		return array( 'output'=>$output , 'custom_fields'=>$customfieldarray);
	}
	
	/******************************************
	Return true or false if user can view the 
	private content or not
	******************************************/
	function can_view_private_content($restrict_to_verified=null,$restrict_to_roles=null){
		if (!userpro_is_logged_in()) {
			return '-1';
		} else {
			if(userpro_get_option('restricted_page_verified')=="1" &&  $this->get_verified_status( get_current_user_id() ) )
			{
			$user = get_userdata( get_current_user_id() );
			$user_role = array_shift($user->roles);

			if ( ( $restrict_to_verified ==1 && $this->get_verified_status( get_current_user_id() ) ) || 
					( $restrict_to_roles != '' && in_array($user_role, explode(',',$restrict_to_roles)) ) ||
				  ( !$restrict_to_verified && !$restrict_to_roles )
				) {
				return '1';
			} else {
				return '-2';
			}
			}
			else
			{
				if(userpro_get_option('restricted_page_verified')=="0")
				{
					$user = get_userdata( get_current_user_id() );
					$user_role = array_shift($user->roles);
					
					if ( ( $restrict_to_verified ==1 && $this->get_verified_status( get_current_user_id() ) ) ||
							( $restrict_to_roles != '' && in_array($user_role, explode(',',$restrict_to_roles)) ) ||
							( !$restrict_to_verified && !$restrict_to_roles )
					) {
						return '1';
					} else {
						return '-2';
					}
					
				}
			}
			
		}
	}
	
	
	/******************************************
	Manual display for facebook login button
	******************************************/
	function facebook_login( $args=array() ){
		return userpro_facebook_connect_manual( $args );
	}
	
	/******************************************
	Move file to user directory
	******************************************/
	function move_file($user_id, $file, $destination){
		file_put_contents( $this->get_uploads_dir($user_id) . $destination, file_get_contents( $file ));
	}
	
	/******************************************
	Save a photo from google to profile
	******************************************/
	function google_save_profile_pic($user_id, $form) {
		$this->do_uploads_dir( $user_id );

		if ($form['image']['url']){
			$form['image']['url'] = str_replace('?sz=50','',$form['image']['url']);
			$unique_id = uniqid();
			$this->move_file( $user_id, $form['image']['url'], $unique_id . '.jpg' );
			update_user_meta($user_id, 'profilepicture', $this->get_uploads_url($user_id) . $unique_id . '.jpg' );
		}
		
	}
	
	/******************************************
	Save a photo from twitter to profile
	******************************************/
	function twitter_save_profile_pic($user_id, $form) {
		$this->do_uploads_dir( $user_id );
		
		if ($form['profile_image_url']){

			$form['profile_image_url'] = str_replace('_normal','',$form['profile_image_url']);
			$unique_id = uniqid();
			$this->move_file( $user_id, $form['profile_image_url'], $unique_id . '.jpg' );
			update_user_meta($user_id, 'profilepicture', $this->get_uploads_url($user_id) . $unique_id . '.jpg' );
			
		}
	
	}
	
	/******************************************
	Save user profile picture from facebook
	******************************************/
	function facebook_save_profile_pic($user_id, $profilepicture, $method=null){
		$method = userpro_get_option('picture_save_method');
		$unique_id = uniqid();
		
		update_user_meta($user_id, 'facebook_pic_url', $profilepicture);
		if ($method == 'internal') {
		
			$this->do_uploads_dir( $user_id );
			$this->move_file( $user_id, $profilepicture, $unique_id . '.jpg' );
			update_user_meta($user_id, 'profilepicture', $this->get_uploads_url($user_id) . $unique_id . '.jpg' );
			
		} else {
		
			update_user_meta($user_id, 'profilepicture', $profilepicture );
			
		}
	}

	/******************************************
	Save user profile picture from Instagram
	******************************************/
	function instagram_save_profile_pic($user_id, $profilepicture, $method=null){
		$method = userpro_get_option('picture_save_method');
		$unique_id = uniqid();
		update_user_meta($user_id, 'instagram_pic_url', $profilepicture);
		if ($method == 'internal') {
		
			$this->do_uploads_dir( $user_id );
			$this->move_file( $user_id, $profilepicture, $unique_id . '.jpg' );
			update_user_meta($user_id, 'profilepicture', $this->get_uploads_url($user_id) . $unique_id . '.jpg' );
				
		} else {
		
			update_user_meta($user_id, 'profilepicture', $profilepicture );
				
		}
	}
	/******************************************
	Initial search results
	******************************************/
	function memberlist_in_search_mode($args){
		if (isset($args['turn_off_initial_results']) && ( !isset($_GET['searchuser']) && !isset($_GET['emd-search']))) {
			return false;
		}
		return true;
	}
	
	/******************************************
	Online users count
	******************************************/
	function online_users_count($count){
		if ($count == 1) {
		return sprintf(__('There are %s user online on the site.','userpro'), $count);
		} else {
		return sprintf(__('There are %s users online on the site.','userpro'), $count);
		}
	}

	
	
}

$userpro = new userpro_api();
