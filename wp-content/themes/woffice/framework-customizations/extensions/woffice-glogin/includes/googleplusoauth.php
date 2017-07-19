<?php

function generateRandomString($length = 10) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, strlen($characters) - 1)];
    }
    return $randomString;
}

function googleplus_oauth_redirect()
{
	global $wp, $wp_query, $wp_the_query, $wp_rewrite, $wp_did_header;
	require_once("../wp-load.php");

	require_once 'googleplusoauth/apiClient.php';
	require_once 'googleplusoauth/contrib/apiPlusService.php';

	$client = new apiClient();
	$client->setApplicationName(fw_get_db_ext_settings_option('woffice-glogin', 'googleplus_app_name'));
	$client->setScopes(array('https://www.googleapis.com/auth/plus.me', 'https://www.googleapis.com/auth/userinfo.email', 'https://www.googleapis.com/auth/plus.login', 'https://www.googleapis.com/auth/userinfo.profile'));
	$plus = new apiPlusService($client);
	$authUrl = $client->createAuthUrl();	

	header("Location: " . $authUrl);

	die();
}

add_action("wp_ajax_googleplus_oauth_redirect", "googleplus_oauth_redirect");
add_action("wp_ajax_nopriv_googleplus_oauth_redirect", "googleplus_oauth_redirect");

function googleplus_oauth_callback()
{
	global $wp, $wp_query, $wp_the_query, $wp_rewrite, $wp_did_header;
	require_once("../wp-load.php");

	require_once 'googleplusoauth/apiClient.php';
	require_once 'googleplusoauth/contrib/apiPlusService.php';

	$client = new apiClient();
	$client->setApplicationName(fw_get_db_ext_settings_option('woffice-glogin', 'googleplus_app_name'));
	$client->setScopes(array('https://www.googleapis.com/auth/plus.me', 'https://www.googleapis.com/auth/userinfo.email', 'https://www.googleapis.com/auth/plus.login', 'https://www.googleapis.com/auth/userinfo.profile'));
	$plus = new apiPlusService($client);

	$client->authenticate();
	$_SESSION['access_token'] = $client->getAccessToken();
	$client->setAccessToken($_SESSION['access_token']);	
	$me = $plus->people->get('me');

	$email = $me["emails"][0]["value"];
	$name = $me["displayName"];

	if(email_exists($email))
	{
		$user_id = email_exists($email);
		wp_set_auth_cookie($user_id);
		update_user_meta($user_id, "googleplus_access_token", $_SESSION["access_token"]);
		header('Location: ' . get_site_url());
	}
	else
	{
		if (get_option('users_can_register') == '1'){
			wp_create_user($name, generateRandomString(), $email);
			$user_id = email_exists($name);
			wp_set_auth_cookie($user_id);
			update_user_meta($user_id, "googleplus_access_token", $_SESSION["access_token"]);
			header('Location: ' . get_site_url());
		}
		else {
			$login_page  = home_url( '/login/' );
			wp_redirect( $login_page . '?login=failed' );
		}
	}

	unset($_SESSION["access_token"]);

	die();
}

add_action("wp_ajax_googleplus_oauth_callback", "googleplus_oauth_callback");
add_action("wp_ajax_nopriv_googleplus_oauth_callback", "googleplus_oauth_callback");


?>