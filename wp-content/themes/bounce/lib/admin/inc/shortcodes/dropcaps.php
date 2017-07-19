<?php

if ( ! function_exists( 'gp_dropcap_1' ) ) {
	function gp_dropcap_1($atts, $content = null) {
		extract(shortcode_atts(array(
			'color'      => ''
		), $atts));

		$out = '<span class="dropcap1" style="color: '.$color.';">'.do_shortcode($content).'</span>';

	   return $out;
	}
}
add_shortcode('dropcap_1', 'gp_dropcap_1');

if ( ! function_exists( 'gp_dropcap_2' ) ) {
	function gp_dropcap_2($atts, $content = null) {
		extract(shortcode_atts(array(
			'color'      => '',
		), $atts));

		$out = '<span class="dropcap2" style="color: '.$color.';">'.do_shortcode($content).'</span>';

	   return $out;
	}
}
add_shortcode('dropcap_2', 'gp_dropcap_2');

if ( ! function_exists( 'gp_dropcap_3' ) ) {
	function gp_dropcap_3($atts, $content = null) {
		extract(shortcode_atts(array(
			'color'      => '',
		), $atts));

		$out = '<span class="dropcap3" style="color: '.$color.';">'.do_shortcode($content).'</span>';

	   return $out;
	}
}
add_shortcode('dropcap_3', 'gp_dropcap_3');

if ( ! function_exists( 'gp_dropcap_4' ) ) {
	function gp_dropcap_4($atts, $content = null) {
		extract(shortcode_atts(array(
			'color'      => '',
		), $atts));

		$out = '<span class="dropcap4" style="color: '.$color.';">'.do_shortcode($content).'</span>';

	   return $out;
	}
}
add_shortcode('dropcap_4', 'gp_dropcap_4');

if ( ! function_exists( 'gp_dropcap_5' ) ) {
	function gp_dropcap_5($atts, $content = null) {
		extract(shortcode_atts(array(
			'color'      => '',
		), $atts));

		$out = '<span class="dropcap5" style="color: '.$color.';">'.do_shortcode($content).'</span>';

	   return $out;
	}
}
add_shortcode('dropcap_5', 'gp_dropcap_5');

?>