<?php

if ( ! function_exists( 'gp_pricing_table' ) ) {
	function gp_pricing_table($atts, $content = null) {
		ob_start(); ?>

			<div class="sc-pricing-table">
				<?php echo do_shortcode($content); ?>
			</div>

	<?php 

		$output_string = ob_get_contents();
		ob_end_clean(); 
	
		return $output_string;

	}
}
add_shortcode('pricing_table', 'gp_pricing_table');

?>