<?php

if ( ! function_exists( 'gp_sidebar' ) ) {
	function gp_sidebar($atts, $content = null) {
		extract(shortcode_atts(array(
			'name' => 'default',
			'width' => '',
			'align' => 'alignnone',
			'text' => ''
		), $atts));
	
		ob_start(); ?>
	
		<div class="sc-sidebar <?php echo($align); ?>" style="width: <?php echo($width); ?>px">
	
			<?php if(is_active_sidebar($name)) { ?>
				<?php dynamic_sidebar($name); ?>
			<?php } else { ?>
				<p><strong><?php echo $text; ?></strong></p>			
			<?php } ?>
		
		</div>

	<?php 

		$output_string = ob_get_contents();
		ob_end_clean(); 
	
		return $output_string;

	}
}
add_shortcode("sidebar", "gp_sidebar");

?>