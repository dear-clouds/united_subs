<?php

if ( ! function_exists( 'gp_logged_in' ) ) {
	function gp_logged_in($atts, $content = null) {
		if(is_user_logged_in()) {
			return do_shortcode($content);
		}
	}
}
add_shortcode('logged_in', 'gp_logged_in');

?>