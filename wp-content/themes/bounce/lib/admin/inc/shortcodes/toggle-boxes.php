<?php

if ( ! function_exists( 'gp_toggle_box' ) ) {
	function gp_toggle_box($atts, $content = null) {
		extract(shortcode_atts(array(
			'title'      => '',
		), $atts));

		wp_enqueue_script('gp-toggle-init');
	
		$out = '';
		$out .= '<h3 class="toggle"><a href="#">' .$title. '</a></h3>';
		$out .= '<div class="toggle-box" style="display: none;"><p>';
		$out .= do_shortcode($content);
		$out .= '</p></div>';

	   return $out;
	}
}
add_shortcode('toggle', 'gp_toggle_box');

?>