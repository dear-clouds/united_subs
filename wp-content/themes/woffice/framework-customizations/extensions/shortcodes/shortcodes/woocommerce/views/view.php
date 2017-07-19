<?php if ( ! defined( 'FW' ) ) {
	die( 'Forbidden' );
}
?>

<div class="woocommerce-shortcode">
	<?php 
	
		/* We deisplay the Title */
		if (!empty($atts['woocommerce_title'])) {
			echo '<div class="heading"><h2>'.$atts['woocommerce_title'].'</h2></div>';
		}
		
		
		/* We generate a Woocommerce shortcode : http://docs.woothemes.com/document/woocommerce-shortcodes/ */
		echo '<div class="flexslider">';
			echo do_shortcode('['.$atts['woocommerce_type'].' columns="4" orderby="'.$atts['woocommerce_order_by'].'" order="'.$atts['woocommerce_order_by'].'" per_page="'.$atts['woocommerce_per_page'].'"]'); 
		echo '</div>';
	
	?>
</div>