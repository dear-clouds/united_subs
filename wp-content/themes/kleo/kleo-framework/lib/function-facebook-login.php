<?php

function kleo_fb_head() {

    if ( is_user_logged_in()) {
        return false;
    }

	?>
	<div id="fb-root"></div>
	<?php
}


function kleo_fb_footer() {

    if ( is_user_logged_in()) {
        return false;
    }

?>
    <script>
        // Additional JS functions here
        window.fbAsyncInit = function() {
            FB.init({
                appId      : '<?php echo sq_option('fb_app_id'); ?>', // App ID
                version    : 'v2.1',
                status     : true, // check login status
                cookie     : true, // enable cookies to allow the server to access the session
                xfbml      : true,  // parse XFBML
                oauth      : true
            });

            // Additional init code here
            jQuery('#fb-root').trigger('facebook:init');

        };

        // Load the SDK asynchronously
        (function(d, s, id) {
            var js, fjs = d.getElementsByTagName(s)[0];
            if (d.getElementById(id)) return;
            js = d.createElement(s); js.id = id;
            js.src = "//connect.facebook.net/<?php echo apply_filters('kleo_facebook_js_locale', 'en_US'); ?>/sdk.js";
            fjs.parentNode.insertBefore(js, fjs);
        }(document, 'script', 'facebook-jssdk'));

    </script>
	<script type="text/javascript">
	var fbAjaxUrl = '<?php echo site_url( 'wp-login.php', 'login_post' ); ?>';

    jQuery(document).ready(function() {

        jQuery('.kleo-facebook-connect').click(function() {

            // fix iOS Chrome
            if (navigator.userAgent.match('CriOS')) {
                window.open('https://www.facebook.com/dialog/oauth?client_id=<?php echo sq_option('fb_app_id'); ?>&redirect_uri=' + document.location.href + '&scope=email,public_profile&response_type=token', '', null);
            } else {
                FB.login(function(FB_response){
                        if (FB_response.authResponse) {
                            fb_intialize(FB_response, '');
                        }
                    },
                    {
                        scope: 'email',
                        auth_type: 'rerequest',
                        return_scopes: true
                    });
            }
        });

        if (navigator.userAgent.match('CriOS')) {
            jQuery("#fb-root").bind("facebook:init", function () {
                var accToken = jQuery.getUrlVar('#access_token');
                if (accToken) {
                    var fbArr = {scopes: "email"};
                    fb_intialize(fbArr, accToken);
                }
            });
        }

    });

	function fb_intialize(FB_response, token){
		FB.api( '/me', 'GET', {
                fields : 'id,email,verified,name',
                access_token : token
            },
            function(FB_userdata){
                jQuery.ajax({
                    type: 'POST',
                    url: fbAjaxUrl,
                    data: {"action": "fb_intialize", "FB_userdata": FB_userdata, "FB_response": FB_response},
                    success: function(user){
                        if( user.error ) {
                            alert( user.error );
                        }
                        else if( user.loggedin ) {
                            jQuery('#kleo-login-result').html(user.message);
                            if( user.type === 'login' ) {
                                if(window.location.href.indexOf("wp-login.php") > -1) {
                                    window.location = user.url;
                                } else if (user.redirectType == 'reload') {
                                    window.location.reload();
                                } else {
                                    window.location = user.url;
                                }
                            }
                            else if( user.type === 'register' ) {
                                window.location = user.url;
                            }
                        }
                    }
                });
            }
		);
	}

    jQuery.extend({
        getUrlVars: function(){
            var vars = [], hash;
            var hashes = window.location.href.slice(window.location.href.indexOf('?') + 1).split('&');
            for(var i = 0; i < hashes.length; i++)
            {
                hash = hashes[i].split('=');
                vars.push(hash[0]);
                vars[hash[0]] = hash[1];
            }
            return vars;
        },
        getUrlVar: function(name){
            return jQuery.getUrlVars()[name];
        }
    });
	</script>
<?php
}

function kleo_fb_loginform_script()
{
    //Enqueue jQuery
    wp_enqueue_script('jquery');
    
    //Output CSS
    echo '<style type="text/css" media="screen">
		.hr-title, .gap-30, .gap-10 {display: none;}
    .kleo-facebook-connect.btn.btn-default {
      background-color: #3b5997;
      border-color: #2b4780;
      color: #fff;
      border-radius: 2px;
      font-size: 13px;
      font-weight: normal;
      margin: 3px 0;
      min-width: 80px;
      transition: all 0.4s ease-in-out 0s;
      cursor: pointer;
      display: inline-block;
      line-height: 1.42857;
      padding: 6px 12px;
      text-align: center;
      text-decoration: none;
      vertical-align: middle;
      white-space: nowrap;
    }
		</style>';
}

if ( sq_option( 'facebook_login', 0 ) == 1 ) {
    add_action('kleo_after_body', 'kleo_fb_head');
    add_action('login_head', 'kleo_fb_head');
    add_action('login_head', 'kleo_fb_loginform_script');
    add_action('wp_footer', 'kleo_fb_footer', 99);
    add_action('login_footer', 'kleo_fb_footer', 99);
}


function kleo_fb_intialize() {

    /* If not our action, bail out */
    if (! isset($_POST['action']) || ( isset($_POST['action']) && $_POST['action'] != 'fb_intialize' ) ) {
        return false;
    }

    @error_reporting( 0 ); // Don't break the JSON result
    header( 'Content-type: application/json' );

    if ( is_user_logged_in() ) {
        die(json_encode(array('error' => __('You are already logged in.', 'kleo_framework'))));
    }

    if( !isset( $_REQUEST['FB_response'] ) || !isset( $_REQUEST['FB_userdata'] )) {
        die(json_encode(array('error' => __('Authentication required.', 'kleo_framework'))));
    }

    $FB_response = $_REQUEST['FB_response'];
    $FB_userdata = $_REQUEST['FB_userdata'];
    $FB_userid = $FB_userdata['id'];

    if( !$FB_userid ) {
        die(json_encode(array('error' => __('Please connect your facebook account.', 'kleo_framework'))));
    }

    global $wpdb;
    //check if we already have matched our facebook account
    $user_ID = $wpdb->get_var( "SELECT user_id FROM $wpdb->usermeta WHERE meta_key = '_fbid' AND meta_value = '$FB_userid'" );

    $redirect = '';

    //if facebook is not connected
    if( !$user_ID ){
        $user_email = $FB_userdata['email'];
        $user_ID = $wpdb->get_var( "SELECT ID FROM $wpdb->users WHERE user_email = '".$wpdb->escape($user_email)."'" );

        //Register user
        if( !$user_ID )
        {
            if ( !get_option( 'users_can_register' )) {
                die( json_encode( array( 'error' => __('Registration is not open at this time. Please come back later.', 'kleo_framework') )));
            }
            if (sq_option('facebook_register', 0) == 0) {
                die( json_encode( array( 'error' => __('Registration using Facebook is not currently allowed. Please use our Register page', 'kleo_framework') )));
            }

            extract( $FB_userdata );

            $display_name = $name;

            $first_name = '';
            $last_name = '';
            $name_array = explode( ' ', $name, 2 );
            $first_name = $name_array[0];
            if ( isset( $name_array[1] ) ) {
                $last_name = $name_array[1];
            }

            if( empty( $verified ) || !$verified ) {
                die(json_encode(array('error' => __('Your facebook account is not verified. You have to verify your account before proceed login or registering on this site.', 'kleo_framework'))));
            }

            $user_email = $email;
            if ( empty( $user_email )) {
                die(json_encode(array('error' => __('Please click again to login with Facebook and allow the application to use your email address', 'kleo_framework'))));
            }

            if( empty( $name )) {
                die(json_encode(array('error' => 'empty_name', __('We didn\'t find your name. Please complete your facebook account before proceeding.', 'kleo_framework'))));
            }

            $user_login = sanitize_title_with_dashes( sanitize_user( $display_name, true ));

            if ( username_exists( $user_login ) ) {
                $user_login = $user_login . time();
            }

            $user_pass = wp_generate_password( 12, false );
            $userdata = compact( 'user_login', 'user_email', 'user_pass', 'display_name', 'first_name', 'last_name' );
            $userdata = apply_filters( 'kleo_fb_register_data', $userdata );

            $user_ID = wp_insert_user( $userdata );
            if ( is_wp_error( $user_ID )) {
                die( json_encode( array( 'error' => $user_ID->get_error_message() ) ) );
            }

            //send email with password
            wp_new_user_notification( $user_ID, wp_unslash( $user_pass ) );

            //add Facebook image
            update_user_meta($user_ID, 'kleo_fb_picture', 'https://graph.facebook.com/' . $id . '/picture');

            do_action( 'fb_register_action', $user_ID );
            do_action( 'user_register', $user_ID );

            update_user_meta( $user_ID, '_fbid', $id );
            $logintype = 'register';

            $redirect_link = home_url();
            if (function_exists( 'bp_is_active' )) {
                $redirect_link = bp_core_get_user_domain( $user_ID ) . 'profile/edit/group/1/?fb=registered';
            }

            $redirect = apply_filters( 'kleo_fb_register_redirect', $redirect_link, $user_ID );
        }
        else
        {
            update_user_meta( $user_ID, '_fbid', $FB_userdata['id'] );
            //add Facebook image
            update_user_meta($user_ID, 'kleo_fb_picture', 'https://graph.facebook.com/' . $FB_userdata['id'] . '/picture');
            $logintype = 'login';
        }
    }
    else
    {
        $logintype = 'login';
    }

    $user = get_user_by( 'id', $user_ID );

    if ( $logintype == 'login' ) {

        $redirect_to = home_url();
        if (function_exists( 'bp_is_active' )) {
            $redirect_to =  bp_core_get_user_domain( $user_ID );
        }

        /**
         * Filter the login redirect URL.
         *
         * @since 3.0.0
         *
         * @param string           $redirect_to           The redirect destination URL.
         * @param string           $requested_redirect_to The requested redirect destination URL passed as a parameter.
         * @param WP_User|WP_Error $user                  WP_User object if login was successful, WP_Error object otherwise.
         */

        $redirect = apply_filters( 'login_redirect', $redirect_to, '', $user );
    }

    wp_set_auth_cookie( $user_ID, false, false );
    /**
     * Fires after the user has successfully logged in.
     *
     * @since 1.5.0
     *
     * @param string  $user_login Username.
     * @param WP_User $user       WP_User object of the logged-in user.
     */
    do_action( 'wp_login', $user->user_login, $user );

    /* Check the configured type of redirect */
    if ( sq_option('login_redirect') == 'reload' ) {
        $redirect_type = 'reload';
    } else {
        $redirect_type = 'redirect';
    }

    die( json_encode( array(
        'loggedin' => true,
        'type' => $logintype,
        'url' => $redirect,
        'redirectType' => $redirect_type,
        'message' => __( 'Login successful, redirecting...','kleo_framework' )
    )));
}
if ( ! is_admin() ) {
    add_action( 'init', 'kleo_fb_intialize' );
}


        
//If registered via Facebook -> show message
add_action( 'template_notices', 'kleo_fb_register_message' );
if (!function_exists('kleo_fb_register_message')):
    function kleo_fb_register_message()
    {
        if (isset($_GET['fb']) && $_GET['fb'] == 'registered')
        {
            echo '<div class="clearfix"></div><div class="alert alert-success" id="message" data-alert>';
            echo __('Thank you for registering. Please make sure to complete your profile fields below.', 'kleo_framework');
            echo '</div>';
        }
    }
endif;



//display Facebook avatar
if( sq_option('facebook_avatar', 1) == 1 ) {
	//show Facebook avatar in WP
	add_filter('get_avatar', 'kleo_fb_show_avatar', 5, 5);
	//show Facebook avatar in Buddypress
	add_filter('bp_core_fetch_avatar', 'kleo_fb_bp_show_avatar', 3, 5);
	//show Facebook avatar in Buddypress - url version
	add_filter('bp_core_fetch_avatar_url','kleo_fb_bp_show_avatar_url', 3, 2);
}
function kleo_fb_show_avatar($avatar = '', $id_or_email, $size = 96, $default = '', $alt = false) {
  $id = 0;
  if (is_numeric($id_or_email)) {
    $id = $id_or_email;
  } else if (is_string($id_or_email)) {
    $u = get_user_by('email', $id_or_email);
    $id = $u->id;
  } else if (is_object($id_or_email)) {
    $id = $id_or_email->user_id;
  }
  if ($id == 0) return $avatar;
	
	//if we have an avatar uploaded and is not Gravatar return it
	if(strpos($avatar, home_url()) !== FALSE && strpos($avatar, 'gravatar') === FALSE) return $avatar;
	
	//if we don't have a Facebook photo
  $pic = get_user_meta($id, 'kleo_fb_picture', true);
  if (!$pic || $pic == '') return $avatar;
	
  $avatar = preg_replace('/src=("|\').*?("|\')/i', 'src=\'' . $pic . apply_filters('fb_show_avatar_params', '?width=580&amp;height=580') . '\'', $avatar);
  return $avatar;
}

function kleo_fb_bp_show_avatar($avatar = '', $params, $id) {
    if(!is_numeric($id) || strpos($avatar, 'gravatar') === false) return $avatar;
		
		//if we have an avatar uploaded and is not Gravatar return it
		if(strpos($avatar, home_url()) !== FALSE && strpos($avatar, 'gravatar') === FALSE) return $avatar;
		
    $pic = get_user_meta($id, 'kleo_fb_picture', true);
    if (!$pic || $pic == '') return $avatar;
    $avatar = preg_replace('/src=("|\').*?("|\')/i', 'src=\'' . $pic. apply_filters('fb_show_avatar_params', '?width=580&amp;height=580') . '\'', $avatar);
    return $avatar;
}

function kleo_fb_bp_show_avatar_url($gravatar, $params) {
	
	//if we have an avatar uploaded and is not Gravatar return it
	if(strpos($gravatar, home_url()) !== FALSE && strpos($gravatar, 'gravatar') === FALSE) return $gravatar;
	
  $pic = get_user_meta($params['item_id'], 'kleo_fb_picture', true);
  if (!$pic || $pic == '') return $gravatar;
	return $pic . apply_filters('fb_show_avatar_params', '?width=580&amp;height=580');
}




/* Add a new activity stream when registering with Facebook */
if (!function_exists('gaf_fb_register_activity')):
function gaf_fb_register_activity($user_id) {
	global $bp;
	if ( !function_exists( 'bp_activity_add' ) ) {
        return false;
    }

	$userlink = bp_core_get_userlink( $user_id );
	bp_activity_add( array(
	'user_id' => $user_id,
	'action' => apply_filters( 'xprofile_fb_register_action', sprintf( __( '%s became a registered member', 'buddypress' ), $userlink ), $user_id ),
	'component' => 'xprofile',
	'type' => 'new_member'
	) );
}
endif;
add_action('fb_register_action','gaf_fb_register_activity');