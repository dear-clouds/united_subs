<?php

if ( ! function_exists( 'gp_logged_out' ) ) {
	function gp_logged_out($atts, $content = null) {
		if(is_user_logged_in()) {} else {
			return do_shortcode($content);
		}
	}
}
add_shortcode('logged_out', 'gp_logged_out');

?>