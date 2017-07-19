<?php

if ( ! function_exists( 'gp_button' ) ) {
	function gp_button($atts, $content = null) {
		extract(shortcode_atts(array(
			'link' => '',
			'color' => '',
			'size' => 'small',
			'target' => '_self'
		), $atts));

		$out = '<a href="'.$link.'" class="sc-button '.$color.' '.$size.'" target="'.$target.'">'.do_shortcode($content).'</a>';
	
		return $out;
	}
}
add_shortcode('button', 'gp_button');

?>