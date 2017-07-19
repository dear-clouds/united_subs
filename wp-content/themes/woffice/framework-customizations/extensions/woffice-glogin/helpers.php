<?php if ( ! defined( 'FW' ) ) {
	die( 'Forbidden' );
}

/**
 * Returns the Button HTML
 */
function woffice_glogin_frontend() {
	
	/* Fetch Settings Data */
	$google_show_button = fw_get_db_ext_settings_option('woffice-glogin', 'google_show_button');
	$facebook_show_button = fw_get_db_ext_settings_option('woffice-glogin', 'facebook_show_button');
	$googleplus_app_name = fw_get_db_ext_settings_option('woffice-glogin', 'googleplus_app_name');
	
	$show_facebook = (defined('NEW_FB_LOGIN') && $facebook_show_button == "show" && get_option('users_can_register') == '1') ? true : false;
	
	$extraclass = ($google_show_button == "show" && $show_facebook == true) ? 'two-btns' : 'one-btn';
	
	echo '<div class="social-login-btns '.$extraclass.'">';
	
	/* Google Login */ 
	if ($google_show_button == "show" && !empty($googleplus_app_name)) {
		$url_google = site_url() . "/wp-admin/admin-ajax.php?action=googleplus_oauth_redirect";
		site_url() . "/wp-admin/admin-ajax.php?action=googleplus_oauth_redirect";
		echo '<a href="'.$url_google.'" class="glogin-btn btn btn-default">
		<i class="fa fa-google-plus"></i> <span>'. __('Login With Google','woffice') .'</span></a>';
	}
	
	/* Facebook Register */
	if ($show_facebook == true){
		echo '<a href="'.get_site_url().'/wp-login.php?loginFacebook=1&redirect='.get_site_url().'" onclick="window.location = \''.get_site_url().'/wp-login.php?loginFacebook=1&redirect=\'+window.location.href; return false;" class="facebook-btn btn btn-default">';
		echo '<i class="fa fa-facebook"></i> <span>'. __('Sign In With Facebook','woffice') .'</span>';
		echo '</a>';
	}
	
	if ($show_facebook == true || !empty($googleplus_app_name)) {
		echo '<div class="after-glogin"><hr><span>'. __('or','woffice') .'</span></div>';
	}	
}