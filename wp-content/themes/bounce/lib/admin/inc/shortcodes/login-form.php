<?php

if ( ! function_exists( 'gp_login_form' ) ) {
function gp_login_form($atts, $content = null) {
		extract(shortcode_atts(array(
			'username' => __('Username', 'gp_lang'),
			'password' => __('Password', 'gp_lang'),
			'redirect' => site_url( $_SERVER['REQUEST_URI'] )
		), $atts));
	
		if($redirect == "") {
			$redirect = site_url( $_SERVER['REQUEST_URI'] );
		}

		$args = array(
		'redirect' => $redirect,
		'label_username' => $username,
		'label_password' => $password,
		'remember' => true
		);
	
		ob_start(); ?>
	 
		<?php if (is_user_logged_in()) {} else {
	
			wp_login_form($args);
	
		}

		$output_string = ob_get_contents();
		ob_end_clean(); 
	
		return $output_string;
	}
}
add_shortcode("login", "gp_login_form");

?>