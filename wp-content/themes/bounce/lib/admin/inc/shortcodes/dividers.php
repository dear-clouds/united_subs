<?php

if ( ! function_exists( 'gp_default_divider' ) ) {
	function gp_default_divider($atts, $content = null) {
		return '<div class="sc-divider"></div>';
	}
}
add_shortcode("divider", "gp_default_divider");

if ( ! function_exists( 'gp_top_divider' ) ) {
	function gp_top_divider($atts, $content = null) {
		return '<div class="sc-divider top"><a class="back-to-top">'.__('Back To Top', 'gp_lang').'</a></div>';
	}
}
add_shortcode("top_divider", "gp_top_divider");

if ( ! function_exists( 'gp_small_divider' ) ) {
	function gp_small_divider($atts, $content = null) {
		return '<div class="sc-divider small"></div>';
	}
}
add_shortcode("small_divider", "gp_small_divider");

if ( ! function_exists( 'gp_clear_divider' ) ) {
	function gp_clear_divider($atts, $content = null) {
		return '<div class="sc-divider clear"></div>';
	}
}
add_shortcode("clear", "gp_clear_divider");

if ( ! function_exists( 'gp_small_clear_divider' ) ) {
	function gp_small_clear_divider($atts, $content = null) {
		return '<div class="sc-divider clear small"></div>';
	}
}
add_shortcode("small_clear", "gp_small_clear_divider");

?>