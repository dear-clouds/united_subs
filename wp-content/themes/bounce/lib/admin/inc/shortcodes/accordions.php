<?php

if ( ! function_exists( 'gp_accordion' ) ) {
	function gp_accordion($atts, $content = null, $code) {
		extract(shortcode_atts(array(
			'title' => ''
		), $atts));

		wp_enqueue_script('jquery-ui-accordion');
		wp_enqueue_script('gp-accordion-init');
		
		if($code=="accordion") {
			return '<div class="accordion">'.do_shortcode($content).'</div>';
		} elseif($code=="panel") {
			return '<div class="panel"><h3 class="accordion-title"><a href="#">'.esc_attr($title).'</a></h3><div class="panel-content">'.do_shortcode($content).'</div></div>';
		}

	}
}
add_shortcode("accordion", "gp_accordion");
add_shortcode("panel", "gp_accordion");

?>